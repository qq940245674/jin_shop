<?php
/**
 * @brief 商家模块
 * @class Seller
 * @author chendeshan
 * @datetime 2014/7/19 15:18:56
 */
class Seller extends IController
{
	public $layout = 'seller';

	/**
	 * @brief 初始化检查
	 */
	public function init()
	{
		IInterceptor::reg('CheckRights@onCreateAction');
	}
	/**
	 * @brief 商品添加中图片上传的方法
	 */
	public function goods_img_upload()
	{
		//获得配置文件中的数据
		$config = new Config("site_config");
	
	 	//调用文件上传类
		$photoObj = new PhotoUpload();
		$photo    = current($photoObj->run());
		
		if($photo == '-10'){
			echo JSON::encode('首页展示图片规格必须是400 x 400 或 800 x 800');
			exit;
		}
		
		//判断上传是否成功，如果float=1则成功
		if($photo['flag'] == 1)
		{
			$result = array(
				'flag'=> 1,
				'img' => $photo['img']
			);
		}
		else
		{
			$result = array('flag'=> $photo['flag']);
		}
		echo JSON::encode($result);
	}
	/**
	 * @brief 商品添加和修改视图
	 */
	public function goods_edit()
	{
		$goods_id = IFilter::act(IReq::get('id'),'int');

		//初始化数据
		$goods_class = new goods_class($this->seller['seller_id']);

		//获取商品分类列表
		$tb_category = new IModel('category');
		$this->category = $goods_class->sortdata($tb_category->query(false,'*','sort','asc'),0,'--');

		//获取所有商品扩展相关数据
		$data = $goods_class->edit($goods_id);
		
		if($goods_id && !$data)
		{
			die("没有找到相关商品！");
		}

		$this->setRenderData($data);
		$this->redirect('goods_edit');
	}
	//商品更新动作
	public function goods_update()
	{
		
		$id       = IFilter::act(IReq::get('id'),'int');
		$callback = IFilter::act(IReq::get('callback'),'url');
		$callback = strpos($callback,'seller/goods_list') === false ? '' : $callback;

		//检查表单提交状态
		if(!$_POST)
		{
			die('请确认表单提交正确');
		}
		//初始化商品数据
		unset($_POST['id']);
		unset($_POST['callback']);
		$Seller = new IModel('seller');
		$cash = $Seller->getObj('id = '.$this->seller['seller_id'],'cash');
		$cash = $cash['cash'];
		if($cash == 0 || $cash == ''){
			IError::show(403,'您的担保金不足，请及时充值');
			exit;
		}
		if($_POST['_store_nums'] <=0 ){
			IError::show(403,'您的商品库存不足');
			exit;
		}
		$store = (int) $_POST['_store_nums']['0'];
		$sell = (float) $_POST['_sell_price']['0'];
		$sumprice = $store * $sell;
	
		if($sumprice > $cash){
			IError::show(403,'您的担保金小于您的商品价格 x 库存数,请减少库存/价格,或充值担保金');
			exit;
		}
		if($cash < $_POST['fan_money']){
			IError::show(403,'对不起，您发布的商品返利金大于您账户的担保金');
			exit;
		}
		if(!$_POST['fan_money'] || !is_numeric($_POST['fan_money'])){
			IError::show(403,'商品返利金不能为空');
			exit;
		}
		if(empty($_POST['_goods_category'])){
			IError::show(403,'请选择商品所属分类');
			exit;			
		}
		if(count($_POST['_goods_category']) > 3 ){
			IError::show(403,'商品所属分类不能多于三个');
			exit;
		}
		
		
		$_POST['date'] = strtotime($_POST['date']);
		$goodsObject = new goods_class($this->seller['seller_id']);
		$goodsObject->update($id,$_POST);
		$callback ? $this->redirect($callback) : $this->redirect("goods_list");
	}
	//商品列表
	public function goods_list()
	{
		$this->redirect('goods_list');
	}
	//商品删除
	public function goods_del()
	{
		//post数据
	    $id = IFilter::act(IReq::get('id'));

	    //生成goods对象
	    $goods = new goods_class();
	    $goods->seller_id = $this->seller['seller_id'];

	    if($id)
		{
			if(is_array($id))
			{
				foreach($id as $key => $val)
				{
					$goods->del($val);
				}
			}
			else
			{
				$goods->del($id);
			}
		}
		$this->redirect("goods_list");
	}

	//商品状态修改
	public function goods_status()
	{
	    $id        = IFilter::act(IReq::get('id'));
		$is_del    = IFilter::act(IReq::get('is_del'),'int');
		$is_del    = $is_del === 0 ? 3 : $is_del; //不能等于0直接上架
		$seller_id = $this->seller['seller_id'];

		$goodsDB = new IModel('goods');
		$goodsDB->setData(array('is_del' => $is_del));

	    if($id)
		{
			if(is_array($id))
			{
				foreach($id as $key => $val)
				{
					$goodsDB->update("id = ".$val." and seller_id = ".$seller_id);
				}
			}
			else
			{
				$goodsDB->update("id = ".$val." and seller_id = ".$seller_id);
			}
		}
		$this->redirect("goods_list");
	}

	//规格删除
	public function spec_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		if($id)
		{
			$idString = is_array($id) ? join(',',$id) : $id;
			$specObj  = new IModel('spec');
			$specObj->del("id in ( {$idString} ) and seller_id = ".$this->seller['seller_id']);
			$this->redirect('spec_list');
		}
		else
		{
			$this->redirect('spec_list',false);
			Util::showMessage('请选择要删除的规格');
		}
	}
	//修改排序
	public function ajax_sort()
	{
		$id   = IFilter::act(IReq::get('id'),'int');
		$sort = IFilter::act(IReq::get('sort'),'int');

		$goodsDB = new IModel('goods');
		$goodsDB->setData(array('sort' => $sort));
		$goodsDB->update("id = {$id} and seller_id = ".$this->seller['seller_id']);
	}

	//咨询回复
	public function refer_reply()
	{
		$rid     = IFilter::act(IReq::get('refer_id'),'int');
		$content = IFilter::act(IReq::get('content'),'text');

		if($rid && $content)
		{
			$tb_refer = new IModel('refer');
			$seller_id = $this->seller['seller_id'];//商户id
			$data = array(
				'answer' => $content,
				'reply_time' => date('Y-m-d H:i:s'),
				'seller_id' => $seller_id,
				'status' => 1
			);
			$tb_refer->setData($data);
			$tb_refer->update("id=".$rid);
		}
		$this->redirect('refer_list');
	}
	/**
	 * @brief查看订单
	 */
	public function order_show()
	{
		//获得post传来的值
		$order_id = IFilter::act(IReq::get('id'),'int');
		$data = array();
		if($order_id)
		{
			$order_show = new Order_Class();
			$data = $order_show->getOrderShow($order_id);
			if($data)
			{
				//获得折扣前的价格
			 	$rule = new ProRule($data['real_amount']);
			 	$this->result = $rule->getInfo();

		 		//获取地区
		 		$data['area_addr'] = join('&nbsp;',area::name($data['province'],$data['city'],$data['area']));

			 	$this->setRenderData($data);
				$this->redirect('order_show',false);
			}
		}
		if(!$data)
		{
			$this->redirect('order_list');
		}
	}
	/**
	 * @brief 发货订单页面
	 */
	public function order_deliver()
	{
		$order_id = IFilter::act(IReq::get('id'),'int');
		$data = array();
		if($order_id)
		{
			$order_show = new Order_Class();
			$data = $order_show->getOrderShow($order_id);
		}
		$this->setRenderData($data);
		$this->redirect('order_deliver');
	}
	/**
	 * @brief 商户核实操作
	 */
	public function order_delivery_doc()
	{
	 	//获得post变量参数
	 	$order_id = IFilter::act(IReq::get('id'),'int');

	 	//发送的商品关联
	 	$sendgoods = IFilter::act(IReq::get('sendgoods'));

	 	if(!$sendgoods)
	 	{
	 		die('请选择要发货的商品');
	 	}

	 	Order_Class::sendDeliveryGoods($order_id,$sendgoods,$this->seller['seller_id'],'seller','');
	 	$this->redirect('order_list');
	}

	//修改商户信息
	public function seller_edit()
	{
		$seller_id = $this->seller['seller_id'];
		$sellerDB        = new IModel('seller');
		$this->sellerRow = $sellerDB->getObj('id = '.$seller_id);
		$this->redirect('seller_edit');
	}

	/**
	 * @brief 商户的增加动作
	 */
	public function seller_add()
	{
		$seller_id   = $this->seller['seller_id'];
		$email       = IFilter::act(IReq::get('email'));
		$password    = IFilter::act(IReq::get('password'));
		$repassword  = IFilter::act(IReq::get('repassword'));
		$phone       = IFilter::act(IReq::get('phone'));
		$mobile      = IFilter::act(IReq::get('mobile'));
		$province    = IFilter::act(IReq::get('province'),'int');
		$city        = IFilter::act(IReq::get('city'),'int');
		$area        = IFilter::act(IReq::get('area'),'int');
		$address     = IFilter::act(IReq::get('address'));
		$account     = IFilter::act(IReq::get('account'));
		$server_num  = IFilter::act(IReq::get('server_num'));
		$home_url    = IFilter::act(IReq::get('home_url'));

		if(!$seller_id && $password == '')
		{
			$errorMsg = '请输入密码！';
		}

		if($password != $repassword)
		{
			$errorMsg = '两次输入的密码不一致！';
		}

		//操作失败表单回填
		if(isset($errorMsg))
		{
			$this->sellerRow = $_POST;
			$this->redirect('seller_edit',false);
			Util::showMessage($errorMsg);
		}

		//待更新的数据
		$sellerRow = array(
			'account'   => $account,
			'phone'     => $phone,
			'mobile'    => $mobile,
			'email'     => $email,
			'address'   => $address,
			'province'  => $province,
			'city'      => $city,
			'area'      => $area,
			'server_num'=> $server_num,
			'home_url'  => $home_url,
		);

		//创建商家操作类
		$sellerDB   = new IModel("seller");

		//修改密码
		if($password)
		{
			$sellerRow['password'] = md5($password);
		}

		$sellerDB->setData($sellerRow);
		$sellerDB->update("id = ".$seller_id);

		$this->redirect('seller_edit');
	}

	//[团购]添加修改[单页]
	function regiment_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		if($id)
		{
			$regimentObj = new IModel('regiment');
			$where       = 'id = '.$id;
			$regimentRow = $regimentObj->getObj($where);
			if(!$regimentRow)
			{
				$this->redirect('regiment_list');
			}

			//促销商品
			$goodsObj = new IModel('goods');
			$goodsRow = $goodsObj->getObj('id = '.$regimentRow['goods_id']);

			$result = array(
				'isError' => false,
				'data'    => $goodsRow,
			);
			$regimentRow['goodsRow'] = JSON::encode($result);
			$this->regimentRow = $regimentRow;
		}
		$this->redirect('regiment_edit');
	}

	//[团购]删除
	function regiment_del()
	{
		$id = IReq::get('id');
		if(!empty($id))
		{
			$regObj     = new IModel('regiment');
			$regUserObj = new IModel('regiment_user_relation');

			if(is_array($id))
			{
				$idStr = join(',',$id);
				$where = ' id in ('.$idStr.')';
				$uwhere= ' regiment_id in ('.$idStr.')';
			}
			else
			{
				$where  = 'id = '.$id;
				$uwhere = 'regiment_id = '.$id;
			}
			$regObj->del($where);
			$regUserObj->del($uwhere);
			$this->redirect('regiment_list');
		}
		else
		{
			$this->redirect('regiment_list',false);
			Util::showMessage('请选择要删除的id值');
		}
	}

	//[团购]添加修改[动作]
	function regiment_edit_act()
	{
		$id      = IFilter::act(IReq::get('id'),'int');
		$goodsId = IFilter::act(IReq::get('goods_id'),'int');

		$dataArray = array(
			'id'        	=> $id,
			'title'     	=> IFilter::act(IReq::get('title','post')),
			'start_time'	=> IFilter::act(IReq::get('start_time','post')),
			'end_time'  	=> IFilter::act(IReq::get('end_time','post')),
			'is_close'      => 1,
			'intro'     	=> IFilter::act(IReq::get('intro','post')),
			'goods_id'      => $goodsId,
			'store_nums'    => IFilter::act(IReq::get('store_nums','post')),
			'least_count'   => IFilter::act(IReq::get('least_count','post')),
			'regiment_price'=> IFilter::act(IReq::get('regiment_price','post')),
		);

		if($goodsId)
		{
			$goodsObj = new IModel('goods');
			$where    = 'id = '.$goodsId.' and seller_id = '.$this->seller['seller_id'];
			$goodsRow = $goodsObj->getObj($where);

			//商品信息不存在
			if(!$goodsRow)
			{
				$this->regimentRow = $dataArray;
				$this->redirect('regiment_edit',false);
				Util::showMessage('请选择商户自己的商品');
			}

			//处理上传图片
			if(isset($_FILES['img']['name']) && $_FILES['img']['name'] != '')
			{
				$uploadObj = new PhotoUpload();
				$photoInfo = $uploadObj->run();
				$dataArray['img'] = $photoInfo['img']['img'];
			}
			else
			{
				$dataArray['img'] = $goodsRow['img'];
			}

			$dataArray['sell_price'] = $goodsRow['sell_price'];
		}
		else
		{
			$this->regimentRow = $dataArray;
			$this->redirect('regiment_edit',false);
			Util::showMessage('请选择要关联的商品');
		}

		$regimentObj = new IModel('regiment');
		$regimentObj->setData($dataArray);

		if($id)
		{
			$where = 'id = '.$id;
			$regimentObj->update($where);
		}
		else
		{
			$regimentObj->add();
		}
		$this->redirect('regiment_list');
	}

	//结算单修改
	public function bill_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		$billRow = array();

		if($id)
		{
			$billDB  = new IModel('bill');
			$billRow = $billDB->getObj('id = '.$id.' and seller_id = '.$this->seller['seller_id']);
		}

		$this->billRow = $billRow;
		$this->redirect('bill_edit');
	}

	//结算单删除
	public function bill_del()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		if($id)
		{
			$billDB = new IModel('bill');
			$billDB->del('id = '.$id.' and seller_id = '.$this->seller['seller_id'].' and is_pay = 0');
		}

		$this->redirect('bill_list');
	}

	//结算单更新
	public function bill_update()
	{
		$id          = IFilter::act(IReq::get('id'),'int');
		$start_time  = IFilter::act(IReq::get('start_time'));
		$end_time    = IFilter::act(IReq::get('end_time'));

		$billDB = new IModel('bill');

		if($id)
		{
			$billRow = $billDB->getObj('id = '.$id);
			if($billRow['is_pay'] == 0)
			{
				$billDB->setData(array('apply_content' => IFilter::act(IReq::get('apply_content'))));
				$billDB->update('id = '.$id.' and seller_id = '.$this->seller['seller_id']);
			}
		}
		else
		{
			$queryObject = CountSum::getSellerGoodsFeeQuery($this->seller['seller_id'],$start_time,$end_time);
			$countData   = CountSum::countSellerOrderFee($queryObject->find());

			if($countData['orderAmountPrice'] > 0)
			{
				$replaceData = array(
					'{startTime}'     => $start_time,
					'{endTime}'       => $end_time,
					'{goodsNums}'     => count($countData['order_goods_ids']),
					'{goodsSums}'     => $countData['goodsSum'],
					'{deliveryPrice}' => $countData['deliveryPrice'],
					'{protectedPrice}'=> $countData['insuredPrice'],
					'{taxPrice}'      => $countData['taxPrice'],
					'{totalSum}'      => $countData['orderAmountPrice'],
				);

				$billString = strtr(AccountLog::sellerBillTemplate(),$replaceData);
				$data = array(
					'seller_id'  => $this->seller['seller_id'],
					'apply_time' => date('Y-m-d H:i:s'),
					'apply_content' => IFilter::act(IReq::get('apply_content')),
					'start_time' => $start_time,
					'end_time' => $end_time,
					'log' => $billString,
					'order_goods_ids' => join(",",$countData['order_goods_ids']),
				);
				$billDB->setData($data);
				$billDB->add();
			}
			else
			{
				$this->redirect('bill_list',false);
				Util::showMessage('当前时间段内没有任何结算货款');
			}
		}
		$this->redirect('bill_list');
	}

	//计算应该结算的货款明细
	public function countGoodsFee()
	{
		$seller_id   = $this->seller['seller_id'];
		$start_time  = IFilter::act(IReq::get('start_time'));
		$end_time    = IFilter::act(IReq::get('end_time'));

		$queryObject = CountSum::getSellerGoodsFeeQuery($seller_id,$start_time,$end_time);
		$countData   = CountSum::countSellerOrderFee($queryObject->find());

		if($countData['orderAmountPrice'] > 0)
		{
			$replaceData = array(
				'{startTime}'     => $start_time,
				'{endTime}'       => $end_time,
				'{goodsNums}'     => count($countData['order_goods_ids']),
				'{goodsSums}'     => $countData['goodsSum'],
				'{deliveryPrice}' => $countData['deliveryPrice'],
				'{protectedPrice}'=> $countData['insuredPrice'],
				'{taxPrice}'      => $countData['taxPrice'],
				'{totalSum}'      => $countData['orderAmountPrice'],
			);

			$billString = AccountLog::sellerBillTemplate($replaceData);
			$result     = array('result' => 'success','data' => $billString);
		}
		else
		{
			$result = array('result' => 'fail','data' => '当前没有任何款项可以结算');
		}

		die(JSON::encode($result));
	}
}