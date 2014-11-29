<?php
/**
 * @copyright (c) 2011 jihuasuan.cn
 * @file Order_Class.php
 * @brief 订单中相关的
 * @author relay
 * @date 2011-02-24
 * @version 0.6
 */
class Order_Class
{
	/**
	 * @brief 产生订单ID
	 * @return string 订单ID
	 */
	public static function createOrderNum()
	{
		return date('YmdHis').rand(100000,999999);
	}

	/**
	 * 添加评论商品的机会
	 * @param $order_id 订单ID
	 */
	public static function addGoodsCommentChange($order_id)
	{
		//获取订单对象
		$orderDB  = new IModel('order');
		$orderRow = $orderDB->getObj('id = '.$order_id);

		//获取此订单中的商品种类
		$orderGoodsDB        = new IQuery('order_goods');
		$orderGoodsDB->where = 'order_id = '.$order_id;
		$orderGoodsDB->group = 'goods_id';
		$orderList           = $orderGoodsDB->find();

		//可以允许进行商品评论
		$commentDB = new IModel('comment');

		//对每类商品进行评论开启
		foreach($orderList as $val)
		{
			$attr = array(
				'goods_id' => $val['goods_id'],
				'order_no' => $orderRow['order_no'],
				'user_id'  => $orderRow['user_id'],
				'time'     => date('Y-m-d H:i:s')
			);
			$commentDB->setData($attr);
			$commentDB->add();
		}
	}

	/**
	 * 支付成功后修改订单状态
	 * @param $orderNo  string 订单编号
	 * @param $admin_id int    管理员ID
	 * @param $note     string 收款的备注
	 * @return false or int order_id
	 */
	public static function updateOrderStatus($orderNo,$admin_id = '',$note = '')
	{
		//获取订单信息
		$orderObj  = new IModel('order');
		$orderRow  = $orderObj->getObj('order_no = "'.$orderNo.'"');

		if(empty($orderRow))
		{
			return false;
		}

		if($orderRow['pay_status'] == 1)
		{
			return $orderRow['id'];
		}
		else if($orderRow['pay_status'] == 0)
		{
			$dataArray = array(
				'status'     => ($orderRow['status'] == 5) ? 5 : 2,
				'pay_time'   => ITime::getDateTime(),
				'pay_status' => 1,
			);

			$orderObj->setData($dataArray);
			$is_success = $orderObj->update('order_no = "'.$orderNo.'"');
			if($is_success == '')
			{
				return false;
			}

			//删除订单中使用的道具
			$ticket_id = trim($orderRow['prop']);
			if($ticket_id != '')
			{
				$propObj  = new IModel('prop');
				$propData = array('is_userd' => 1);
				$propObj->setData($propData);
				$propObj->update('id = '.$ticket_id);
			}

			if(intval($orderRow['user_id']) != 0)
			{
				$user_id = $orderRow['user_id'];

				//获取用户信息
				$memberObj  = new IModel('member');
				$memberRow  = $memberObj->getObj('user_id = '.$user_id,'prop,group_id');

				//(1)删除订单中使用的道具
				if($ticket_id != '')
				{
					$finnalTicket = str_replace(','.$ticket_id.',',',',','.trim($memberRow['prop'],',').',');
					$memberData   = array('prop' => $finnalTicket);
					$memberObj->setData($memberData);
					$memberObj->update('user_id = '.$user_id);
				}

				if($memberRow)
				{
					//(2)进行促销活动奖励
			    	$proObj = new ProRule($orderRow['real_amount']);
			    	$proObj->setUserGroup($memberRow['group_id']);
			    	$proObj->setAward($user_id);

			    	//(3)增加经验值
			    	$memberData = array(
			    		'exp'   => 'exp + '.$orderRow['exp'],
			    	);
					$memberObj->setData($memberData);
					$memberObj->update('user_id = '.$user_id,'exp');

					//(4)增加积分
					$pointConfig = array(
						'user_id' => $user_id,
						'point'   => $orderRow['point'],
						'log'     => '成功购买了订单号：'.$orderRow['order_no'].'中的商品,奖励积分'.$orderRow['point'],
					);
					$pointObj = new Point();
					$pointObj->update($pointConfig);
				}
			}

			//插入收款单
			$collectionDocObj = new IModel('collection_doc');
			$collectionData   = array(
				'order_id'   => $orderRow['id'],
				'user_id'    => $orderRow['user_id'],
				'amount'     => $orderRow['order_amount'],
				'time'       => ITime::getDateTime(),
				'payment_id' => $orderRow['pay_type'],
				'pay_status' => 1,
				'if_del'     => 0,
				'note'       => $note,
				'admin_id'   => $admin_id ? $admin_id : 0
			);

			$collectionDocObj->setData($collectionData);
			$collectionDocObj->add();

			/*同步数据*/
			//同步团购的数据
			if($orderRow['type'] == 1)
			{
				$regimentUserObj = new IModel('regiment_user_relation');
				$regimentUserObj->setData(array('is_over' => 1));
				$regimentUserObj->update("order_no = '".$orderRow['order_no']."'");
			}

			//更改购买商品的库存数量
			self::updateStore($orderRow['id'] , 'reduce');

			return $orderRow['id'];
		}
		else
		{
			return false;
		}
	}

	/**
	 * 订单商品数量更新操作[公共]
	 * @param $order_id 订单ID
	 * @param $type 增加或者减少 add 或者 reduce
	 */
	public static function updateStore($order_id,$type = 'add')
	{
		$newStoreNums  = 0;
		$updateGoodsId = array();
		$orderGoodsObj = new IModel('order_goods');
		$goodsObj      = new IModel('goods');
		$productObj    = new IModel('products');
		$goodsList     = $orderGoodsObj->query('order_id = '.$order_id,'goods_id,product_id,goods_nums');

		foreach($goodsList as $key => $val)
		{
			//货品库存更新
			if($val['product_id'] != 0)
			{
				$productsRow = $productObj->getObj('id = '.$val['product_id'],'store_nums');
				$localStoreNums = $productsRow['store_nums'];

				//同步更新所属商品的库存量
				if(in_array($val['goods_id'],$updateGoodsId) == false)
				{
					$updateGoodsId[] = $val['goods_id'];
				}

				$newStoreNums = ($type == 'add') ? $localStoreNums + $val['goods_nums'] : $localStoreNums - $val['goods_nums'];
				$newStoreNums = $newStoreNums > 0 ? $newStoreNums : 0;

				$productObj->setData(array('store_nums' => $newStoreNums));
				$productObj->update('id = '.$val['product_id'],'store_nums');
			}
			//商品库存更新
			else
			{
				$goodsRow = $goodsObj->getObj('id = '.$val['goods_id'],'store_nums');
				$localStoreNums = $goodsRow['store_nums'];

				$newStoreNums = ($type == 'add') ? $localStoreNums + $val['goods_nums'] : $localStoreNums - $val['goods_nums'];
				$newStoreNums = $newStoreNums > 0 ? $newStoreNums : 0;

				$goodsObj->setData(array('store_nums' => $newStoreNums));
				$goodsObj->update('id = '.$val['goods_id'],'store_nums');
			}

			//更新销售量sale字段，库存减少销售量增加，两者成反比
			$saleData = ($type == 'add') ? -$val['goods_nums'] : $val['goods_nums'];
			$goodsObj->setData(array('sale' => 'sale + '.$saleData));
			$goodsObj->update('id = '.$val['goods_id'],'sale');
		}

		//更新统计goods的库存
		if($updateGoodsId)
		{
			foreach($updateGoodsId as $val)
			{
				$totalRow = $productObj->getObj('goods_id = '.$val,'SUM(store_nums) as store');
				$goodsObj->setData(array('store_nums' => $totalRow['store']));
				$goodsObj->update('id = '.$val);
			}
		}
	}

	/**
	 * @brief 获取订单基本数据资料
	 * @param $order_id int 订单的id
	 * @return array()
	 */
	public function getOrderShow($order_id)
	{
		$data = array();

		//获得对象
		$tb_order = new IModel('order');
 		$data = $tb_order->getObj('id='.$order_id);
 		if($data)
 		{
	 		$data['order_id'] = $order_id;

	 		//获取配送方式
	 		$tb_delivery = new IModel('delivery');
	 		$delivery_info = $tb_delivery->getObj('id='.$data['distribution']);
	 		if($delivery_info)
	 		{
	 			$data['delivery'] = $delivery_info['name'];
	 		}

	 		//获取支付方式
	 		$tb_payment = new IModel('payment');
	 		$payment_info = $tb_payment->getObj('id='.$data['pay_type']);
	 		if($payment_info)
	 		{
	 			$data['payment'] = $payment_info['name'];
	 		}

	 		//获取商品总重量和总金额
	 		$tb_order_goods = new IModel('order_goods');
	 		$order_goods_info = $tb_order_goods->query('order_id='.$order_id);
	 		$data['goods_amount'] = 0;
	 		$data['goods_weight'] = 0;
	 		if($order_goods_info)
	 		{
	 			foreach ($order_goods_info as $value)
	 			{
	 				$data['goods_amount'] += $value['real_price']   * $value['goods_nums'];
	 				$data['goods_weight'] += $value['goods_weight'] * $value['goods_nums'];
				}
	 		}
			
			//返利金额
			$fan = new IModel('goods');
			$fan_money = $fan->query('id='.$data['goods_id'],'fan_money');
			$fan_money = $fan_money['0']['fan_money'];
			$data['fan_money'] = $fan_money;
			
	 		//获取用户信息
	 		$query = new IQuery('user as u');
	 		$query->join = ' left join member as m on u.id=m.user_id ';
	 		$query->fields = 'u.username,u.email,m.mobile,m.contact_addr,m.true_name';
	 		$query->where = 'u.id='.$data['user_id'];
	 		$user_info = $query->find();
	 		if($user_info)
	 		{
	 			$user_info = $user_info[0];
	 			$data['username']     = $user_info['username'];
	 			$data['email']        = $user_info['email'];
	 			$data['u_mobile']     = $user_info['mobile'];
	 			$data['contact_addr'] = $user_info['contact_addr'];
	 			$data['true_name']    = $user_info['true_name'];
	 		}
 		}
 		return $data;
	}

	/**
	 * 获取订单信息
	 * @param $orderIdString string 订单ID序列
	 */
	public function getOrderInfo($orderIdString)
	{
		$orderObj    = new IModel('order');
		$areaIdArray = array();
		$orderList   = $orderObj->query('id in ('.$orderIdString.')');

		foreach($orderList as $key => $val)
		{
			$temp = area::name($val['province'],$val['city'],$val['area']);
			$orderList[$key]['province_str'] = $temp[$val['province']];
			$orderList[$key]['city_str']     = $temp[$val['city']];
			$orderList[$key]['area_str']     = $temp[$val['area']];
		}

		return $orderList;
	}

	//判断变量是数组还是单个变量
	public static function getWhere($id)
	{
		if(is_array($id))
		{
			$id = join(',',$id);
			$where = ' id in ('.$id.')';
		}
		else
		{
			$where = 'id = '.$id;
		}
		return $where;
	}

	/**
	 * @brief 把订单商品同步到order_goods表中
	 * @param $order_id 订单ID
	 * @param $goodsInfo 商品和货品信息（购物车数据结构,countSum 最终生成的格式）
	 */
	public function insertOrderGoods($order_id,$goodsResult = array())
	{
		$orderGoodsObj = new IModel('order_goods');

		//清理旧的关联数据
		$orderGoodsObj->del('order_id = '.$order_id);

		$goodsArray = array(
			'order_id' => $order_id
		);

		$findType = array('goods'=>'goodsList','product'=>'productList');

		foreach($findType as $key => $list)
		{
			if(isset($goodsResult[$list]) && count($goodsResult[$list]) > 0)
			{
				foreach($goodsResult[$list] as $k => $val)
				{
					//拼接商品名称和规格数据
					$specArray = array('name' => $val['name'],'value' => '');
					if($key == 'product')
					{
						$goodsArray['product_id']  = $val['id'];
						$goodsArray['goods_id']    = $val['goods_id'];

						$spec = block::show_spec($val['spec_array']);
						foreach($spec as $skey => $svalue)
						{
							$specArray['value'] .= $skey.':'.$svalue.',';
						}
						$specArray['value'] = IFilter::addSlash(trim($specArray['value'],','));
					}
					else
					{
						$goodsArray['goods_id']  = $val['id'];
						$goodsArray['product_id']= 0;
					}

					$goodsArray['img']         = $val['img'];
					$goodsArray['goods_price'] = $val['sell_price'];
					$goodsArray['real_price']  = $val['sell_price'] - $val['reduce'];
					$goodsArray['goods_nums']  = $val['count'];
					$goodsArray['goods_weight']= $val['weight'];
					$goodsArray['goods_array'] = JSON::encode($specArray);
					$orderGoodsObj->setData($goodsArray);
					$orderGoodsObj->add();
				}
			}
		}
	}
	/**
	 * 获取订单状态
	 * @param $orderRow array('status' => '订单状态','pay_type' => '支付方式ID','distribution_status' => '配送状态','pay_status' => '支付状态')
	 * @return int 订单状态值 0:未知;1:未付款等待发货;2:等待付款;3:已发货;4:已付款等待发货;5:已取消;6:已完成;7:已退款;
	 */
	public static function getOrderStatus($orderRow)
	{
		if($orderRow['status'] == 1)
		{
			//货到付款
			if($orderRow['pay_type'] == 0)
			{
				if($orderRow['distribution_status'] == 0)
				{
					return 1;
				}
				else if($orderRow['distribution_status'] == 1)
				{
					return 3;
				}
			}
			else
			{
				return 2;
			}
		}
		else if($orderRow['status'] == 2)
		{
			if($orderRow['distribution_status'] == 1)
			{
				return 3;
			}
			else
			{
				return 4;
			}
		}
		else if($orderRow['status'] == 3 || $orderRow['status'] == 4)
		{
			return 5;
		}
		else if($orderRow['status'] == 5)
		{
			if($orderRow['pay_status'] == 1)
			{
				return 6;
			}
			else if($orderRow['pay_status'] == 2)
			{
				return 7;
			}
		}
		return 0;
	}

	//获取订单支付状态
	public static function getOrderPayStatusText($orderRow)
	{
		if($orderRow['pay_status'] == 0)
		{
			return '淘宝未收货';
		}
		else if($orderRow['pay_status'] == 1)
		{
			return '淘宝已收货';
		}
		else if($orderRow['pay_status'] == 2)
		{
			return '退款完成';
		}
	}

	//获取订单类型
	public static function getOrderTypeText($orderRow)
	{
		switch($orderRow['type'])
		{
			case "1":
			{
				return '团购订单';
			}
			break;

			case "2":
			{
				return '抢购订单';
			}
			break;

			default:
			{
				return '普通订单';
			}
		}
	}

	//获取订单配送状态
	public static function getOrderDistributionStatusText($orderRow)
	{
		if($orderRow['status'] == 5)
		{
			return '买家已确认<br>交易完成';
		}
		else if($orderRow['distribution_status'] == 1)
		{
			return '卖家已核实<br>等待买家确认';
		}
		else if($orderRow['distribution_status'] == 0)
		{
			return '卖家未确认';
		}
		else if($orderRow['distribution_status'] == 2)
		{
			return '部分发货';
		}
	}

	/**
	 * 获取订单状态问题说明
	 * @param $statusCode int 订单的状态码
	 * @return string 订单状态说明
	 */
	public static function orderStatusText($statusCode)
	{
		$result = array(
			0 => '未知',
			1 => '等待卖家确认',
			2 => '等待淘宝收货好评',
			3 => '卖家已确认',
			4 => '等待卖家确认',
			5 => '已取消',
			6 => '交易完成',
			7 => '已退款'
		);
		return isset($result[$statusCode]) ? $result[$statusCode] : '';
	}

	/**
	 * @breif 订单的流向
	 * @param $orderRow array 订单数据
	 * @return array('时间' => '事件')
	 */
	public static function orderStep($orderRow)
	{
		$result = array();
		//1,创建订单
		$result[$orderRow['create_time']] = '订单创建';
	
		//2,订单支付
		if($orderRow['pay_status'] > 0)
		{
			$gid = $orderRow['goods_id'];
			$goods = new IModel('goods');
			$goods_info = $goods->query('id = '.$gid,'fan_money',false,'DESC','1');
			$result[$orderRow['pay_time']] = "<span style='color:#FE6C00;'>订单已收货，卖家核实后即可返还金额 ".$goods_info['0']['fan_money']."</span>";
		}

		//3,订单配送
        if($orderRow['distribution_status'] > 0)
        {
        	$result[$orderRow['send_time']] = '<span style=\'color:#F2751F;\'>卖家已核实，返利金额已打到您的账户，请核实..</span>';
    	}

		//4,订单完成
        if($orderRow['status'] == 5)
        {
        	$result[$orderRow['completion_time']] = '订单完成';
        }
        ksort($result);
        return $result;
	}

	/**
	 * @brief 商户订单核实接口
	 * @param string $order_id 订单id
	 * @param array $order_goods_relation 订单与商品关联id
	 * @param int $sendor_id 操作者id
	 * @param string $sendor 操作者所属 admin,seller
	 */
	public static function sendDeliveryGoods($order_id,$order_goods_relation,$sendor_id,$sendor = 'admin',$adminid)
	{
		$order_no = IFilter::act(IReq::get('order_no'));
	 	$paramArray = array(
	 		'order_id'      => $order_id,
	 		'user_id'       => IFilter::act(IReq::get('user_id'),'int'),
	 		'name'          => IFilter::act(IReq::get('name')),
	 		'postcode'      => IFilter::act(IReq::get('postcode'),'int'),
	 		'telphone'      => IFilter::act(IReq::get('telphone')),
	 		'province'      => IFilter::act(IReq::get('province'),'int'),
	 		'city'          => IFilter::act(IReq::get('city'),'int'),
	 		'area'          => IFilter::act(IReq::get('area'),'int'),
	 		'address'       => IFilter::act(IReq::get('address')),
	 		'mobile'        => IFilter::act(IReq::get('mobile')),
	 		'freight'       => IFilter::act(IReq::get('freight'),'float'),
	 		'delivery_code' => IFilter::act(IReq::get('delivery_code')),
	 		'delivery_type' => IFilter::act(IReq::get('delivery_type')),
	 		'note'          => IFilter::act(IReq::get('note'),'text'),
	 		'time'          => date('Y-m-d H:i:s'),
	 		'freight_id'    => IFilter::act(IReq::get('freight_id'),'int'),
	 	);
		$uid = $paramArray['user_id'];
	 	switch($sendor)
	 	{
	 		case "admin":
	 		{
	 			$paramArray['admin_id'] = $sendor_id;
	 			$adminDB = new IModel('admin');
	 			$sendorData = $adminDB->getObj('id = '.$adminid);
	 			$sendorName = $sendorData['admin_name'];
	 			$sendorSort = '商城管理员';
	 		}
	 		break;

	 		case "seller":
	 		{
	 			$paramArray['seller_id'] = $sendor_id;
				
	 			$sellerDB = new IModel('seller');
	 			$sendorData = $sellerDB->getObj('id = '.$sendor_id);
	 			$sendorName = $sendorData['true_name'];
	 			$sendorSort = '加盟商户';
	 		}
	 		break;
	 	}


	 	//获得delivery_doc表的对象
	 	$tb_delivery_doc = new IModel('delivery_doc');
	 	$tb_delivery_doc->setData($paramArray);
	 	$deliveryId = $tb_delivery_doc->add();
		
		//更新发货状态
	 	$orderGoodsDB = new IModel('order_goods');
	 	$orderGoodsRow = $orderGoodsDB->getObj('is_send = 0 and order_id = '.$order_id,'count(*) as num');
		$sendStatus = 2;//部分发货
	 	if(count($order_goods_relation) >= $orderGoodsRow['num'])
	 	{
	 		$sendStatus = 1;//全部发货
	 	}
	 	foreach($order_goods_relation as $key => $val)
	 	{
	 		$orderGoodsDB->setData(array(
	 			"is_send"     => 1,
	 			"delivery_id" => $deliveryId,
	 		));
	 		$orderGoodsDB->update(" id = {$val} ");
	 	}

	 	//更新发货状态
	 	$tb_order = new IModel('order');
	 	$tb_order->setData(array
	 	(
	 		'distribution_status' => $sendStatus,
	 		'status'              => 2,
	 		'send_time'           => date('Y-m-d H:i:s')
	 	));
	 	$tb_order->update('id='.$order_id);
		
		//核实货款,扣除卖家担保金
		//--取得返利金额--//
		$fan = new IModel('order');
		$goods_id = $fan->getObj('id='.$order_id,'goods_id');
		$goods_id = $goods_id['goods_id'];
		$pay = new IModel('goods');
		$fan_money = $pay->getObj('id='.$goods_id,'fan_money');
		$fan_money = $fan_money['fan_money'];
		
		//--扣除商家担保金--//
		$seller_money = new IModel('seller');
		$sell = $seller_money->query('id = '.$sendor_id,'cash');
		$cash = $sell['0']['cash'];
		$seller_money -> setData(array(
			'cash'	=>	$cash-$fan_money
		));
		
		$okid = $seller_money->update('id='.$sendor_id);
		//--把返利金给买家--//
		if($okid){
			$buyer = new IModel('member');
			$balance = $buyer->getObj('user_id='.$uid,'balance');
			$balance = $balance['balance'];
			$buyer->setData(array(
				'balance'	=>	$balance+$fan_money
			));
			$buyer->update('user_id='.$uid);
		}
		
		//生成订单日志
    	$tb_order_log = new IModel('order_log');
    	$tb_order_log->setData(array(
    		'order_id' => $order_id,
    		'user'     => $sendorName,
    		'action'   => '核实,消耗返利金额'.$fan_money,
    		'result'   => '成功',
    		'note'     => '订单【'.$order_no.'】由【'.$sendorSort.'】'.$sendorName.'核实',
    		'addtime'  => date('Y-m-d H:i:s')
    	));
    	$sendResult = $tb_order_log->add();

		//获取货运公司
    	$freightDB  = new IModel('freight_company');
    	$freightRow = $freightDB->getObj('id = '.$paramArray['freight_id']);

    	//发送短信
    	$replaceData = array(
    		'{user_name}'        => $paramArray['name'],
    		'{order_no}'         => $order_no,
    		'{sendor}'           => '['.$sendorSort.']'.$sendorName,
    		'{delivery_company}' => $freightRow['freight_name'],
    		'{delivery_no}'      => $paramArray['delivery_code'],
    	);
    	$mobileMsg = Hsms::sendGoodsTemplate($replaceData);
    	Hsms::send($paramArray['mobile'],$mobileMsg);

    	//同步发货接口，如支付宝担保交易等
    	if($sendResult && $sendStatus == 1)
    	{
    		sendgoods::run($order_id);
    	}
	}

	/**
	 * @biref 是否可以发货操作
	 * @param array $orderRow 订单对象
	 */
	public static function isGoDelivery($orderRow)
	{
		/* 1,已经完全发货
		 * 2,非货到付款，并且没有支付*/
		if($orderRow['distribution_status'] == 1 || ($orderRow['pay_type'] != 0 && $orderRow['pay_status'] == 0))
		{
			return false;
		}
		return true;
	}
}