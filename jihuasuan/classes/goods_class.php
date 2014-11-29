<?php
/**
 * @copyright (c) 2011 jihuasuan.cn
 * @file goods_class.php
 * @brief 商品管理类库
 * @author nswe
 * @date 2014/8/18 11:53:43
 * @version 2.6
 */
class goods_class
{
	//算账类库
	private static $countsumInstance = null;

	//商户ID
	public $seller_id = '';

	//构造函数
	public function __construct($seller_id = '')
	{
		$this->seller_id = $seller_id;
	}

	/**
	 * 获取商品价格
	 * @param int $goods_id 商品ID
	 * @param float $sell_price 商品销售价
	 */
	public static function price($goods_id,$sell_price)
	{
		if(self::$countsumInstance == null)
		{
			self::$countsumInstance = new CountSum();
		}
		$price = self::$countsumInstance->getGroupPrice($goods_id);
		return $price ? $price : $sell_price;
	}

	/**
	 * 生成商品货号
	 * @return string 货号
	 */
	public static function createGoodsNo()
	{
		$config = new Config('site_config');
		return $config->goods_no_pre.time().rand(10,99);
	}

	/**
	 * @brief 修改商品数据
	 * @param int $id 商品ID
	 * @param array $paramData 商品所需数据
	 */
	public function update($id,$paramData)
	{
		$postData = array();
		$nowDataTime = ITime::getDateTime();

		foreach($paramData as $key => $val)
		{
			$postData[$key] = $val;

			//数据过滤分组
			if(strpos($key,'attr_id_') !== false)
			{
				$goodsAttrData[ltrim($key,'attr_id_')] = IFilter::act($val);
			}
			else if($key[0] != '_')
			{
				$goodsUpdateData[$key] = IFilter::act($val,'text');
			}
		}

		//商家发布商品默认设置
		if($this->seller_id)
		{
			$goodsUpdateData['seller_id'] = $this->seller_id;
			$goodsUpdateData['is_del'] = $goodsUpdateData['is_del'] == 2 ? 2 : 3;
		}

		//上架或者下架处理
		if(isset($goodsUpdateData['is_del']))
		{
			//上架
			if($goodsUpdateData['is_del'] == 0)
			{
				$goodsUpdateData['up_time']   = $nowDataTime;
				$goodsUpdateData['down_time'] = null;
			}
			//下架
			else if($goodsUpdateData['is_del'] == 2)
			{
				$goodsUpdateData['up_time']  = null;
				$goodsUpdateData['down_time']= $nowDataTime;
			}
			//审核或者删除
			else
			{
				$goodsUpdateData['up_time']   = null;
				$goodsUpdateData['down_time'] = null;
			}
		}

		//是否存在货品
		$goodsUpdateData['spec_array'] = '';
		if(isset($postData['_spec_array']))
		{
			//生成goods中的spec_array字段数据
			$goods_spec_array = array();
			foreach($postData['_spec_array'] as $key => $val)
			{
				foreach($val as $v)
				{
					$tempSpec = JSON::decode($v);
					if(!isset($goods_spec_array[$tempSpec['id']]))
					{
						$goods_spec_array[$tempSpec['id']] = array('id' => $tempSpec['id'],'name' => $tempSpec['name'],'type' => $tempSpec['type'],'value' => array());
					}
					$goods_spec_array[$tempSpec['id']]['value'][] = $tempSpec['value'];
				}
			}
			foreach($goods_spec_array as $key => $val)
			{
				$val['value'] = array_unique($val['value']);
				$goods_spec_array[$key]['value'] = join(',',$val['value']);
			}
			$goodsUpdateData['spec_array'] = JSON::encode($goods_spec_array);
		}

		$goodsUpdateData['goods_no']     = preg_replace("/(?:\-\d*)$/","",current($postData['_goods_no']));
		$goodsUpdateData['store_nums']   = array_sum($postData['_store_nums']);
		$goodsUpdateData['market_price'] = isset($postData['_market_price']) ? current($postData['_market_price']) : 0;
		$goodsUpdateData['sell_price']   = isset($postData['_sell_price'])   ? current($postData['_sell_price'])   : 0;
		$goodsUpdateData['cost_price']   = isset($postData['_cost_price'])   ? current($postData['_cost_price'])   : 0;
		$goodsUpdateData['weight']       = isset($postData['_weight'])       ? current($postData['_weight'])       : 0;
	//	$goodsUpdateData['weight']       = isset($postData['_weight'])       ? current($postData['_weight'])       : 0;

		//处理商品
		$goodsDB = new IModel('goods');
		if($id)
		{
			$goodsDB->setData($goodsUpdateData);

			$where = " id = {$id} ";
			if($this->seller_id)
			{
				$where .= " and seller_id = ".$this->seller_id;
			}
	
			if($_POST){
				$goodsDB->update($where);
			}
	
		}
		else
		{
			$goodsUpdateData['create_time'] = $nowDataTime;
			$goodsDB->setData($goodsUpdateData);
			$id = $goodsDB->add();
		}

		//处理商品属性和规格
		$goodsAttrDB = new IModel('goods_attribute');
		$goodsAttrDB->del('goods_id = '.$id);
		if(isset($goodsAttrData) && $goodsAttrData)
		{
			foreach($goodsAttrData as $key => $val)
			{
				$attrData = array(
					'goods_id' => $id,
					'model_id' => $goodsUpdateData['model_id'],
					'attribute_id' => $key,
					'attribute_value' => is_array($val) ? join(',',$val) : $val
				);
				$goodsAttrDB->setData($attrData);
				$goodsAttrDB->add();
			}
		}

		if(isset($goods_spec_array) && $goods_spec_array)
		{
			foreach($goods_spec_array as $key => $val)
			{
				$temp = explode(',',$val['value']);
				foreach($temp as $v)
				{
					$attrData = array(
						'goods_id' => $id,
						'model_id' => $goodsUpdateData['model_id'],
						'spec_id' => $val['id'],
						'spec_value' => $v
					);
					$goodsAttrDB->setData($attrData);
					$goodsAttrDB->add();
				}
			}
		}

		//是否存在货品
		$productsDB = new IModel('products');
		$productsDB->del('goods_id = '.$id);
		if(isset($postData['_spec_array']))
		{
			$productIdArray = array();

			//创建货品信息
			foreach($postData['_goods_no'] as $key => $rs)
			{
				$productsData = array(
					'goods_id' => $id,
					'products_no' => $postData['_goods_no'][$key],
					'store_nums' => $postData['_store_nums'][$key],
					'market_price' => $postData['_market_price'][$key],
					'sell_price' => $postData['_sell_price'][$key],
					'cost_price' => $postData['_cost_price'][$key],
					'weight' => $postData['_weight'][$key],
					'spec_array' => "[".join(',',$postData['_spec_array'][$key])."]"
				);
				$productsDB->setData($productsData);
				$productIdArray[$key] = $productsDB->add();
			}
		}

		//处理商品分类
		$categoryDB = new IModel('category_extend');
		$categoryDB->del('goods_id = '.$id);
		if(isset($postData['_goods_category']) && $postData['_goods_category'])
		{
			if(count($postData['_goods_category']) > 3){
				IError::show(403,'对不起，不能选择超过三个分类');
				
				exit;
			}
			
			if(isset($postData['_goods_category']['1'])){
				$mygoods = new IModel('goods');
				if(isset($postData['_goods_category']['2'])){
					$mygoods->setData(array('onecate'=>$postData['_goods_category']['1'],'in'=>$postData['_goods_category']['2']));
				}else{
					$mygoods->setData(array('onecate'=>$postData['_goods_category']['1']));
				}
				$mygoods->update('id = '. $id);
			}
			
		
			
			foreach($postData['_goods_category'] as $item)
			{
				$categoryDB->setData(array('goods_id' => $id,'category_id' => $item));
				$categoryDB->add();
			}
		}

		//处理商品促销
		$commendDB = new IModel('commend_goods');
		$commendDB->del('goods_id = '.$id);
		
		
		if(isset($postData['_goods_commend']) && $postData['_goods_commend'])
		{
		
			foreach($postData['_goods_commend'] as $item)
			{
				$commendDB->setData(array('goods_id' => $id,'commend_id' => $item));
				$commendDB->add();
			}
		}

		//处理商品关键词
		keywords::add($goodsUpdateData['search_words']);

		//处理商品图片
		$photoRelationDB = new IModel('goods_photo_relation');
		$photoRelationDB->del('goods_id = '.$id);
		if(isset($postData['_imgList']) && $postData['_imgList'])
		{
			$postData['_imgList'] = str_replace(',','","',trim($postData['_imgList'],','));
			$photoDB = new IModel('goods_photo');
			$photoData = $photoDB->query('img in ("'.$postData['_imgList'].'")','id');
			if($photoData)
			{
				foreach($photoData as $item)
				{
					$photoRelationDB->setData(array('goods_id' => $id,'photo_id' => $item['id']));
					$photoRelationDB->add();
				}
			}
		}

		//处理会员组的价格
		$groupPriceDB = new IModel('group_price');
		$groupPriceDB->del('goods_id = '.$id);
		if(isset($productIdArray) && $productIdArray)
		{
			foreach($productIdArray as $index => $value)
			{
				if(isset($postData['_groupPrice'][$index]) && $postData['_groupPrice'][$index])
				{
					$temp = JSON::decode($postData['_groupPrice'][$index]);
					foreach($temp as $k => $v)
					{
						$groupPriceDB->setData(array(
							'goods_id' => $id,
							'product_id' => $value,
							'group_id' => $k,
							'price' => $v
						));
						$groupPriceDB->add();
					}
				}
			}
		}
		else
		{
			if(isset($postData['_groupPrice'][0]) && $postData['_groupPrice'][0])
			{
				$temp = JSON::decode($postData['_groupPrice'][0]);
				foreach($temp as $k => $v)
				{
					$groupPriceDB->setData(array(
						'goods_id' => $id,
						'group_id' => $k,
						'price' => $v
					));
					$groupPriceDB->add();
				}
			}
		}
		return true;
	}

	/**
	* @brief 删除与商品相关表中的数据
	*/
	public function del($goods_id)
	{
		$goodsWhere = " id = {$goods_id} ";
		if($this->seller_id)
		{
			$goodsWhere .= " and seller_id = ".$this->seller_id;
		}

		//删除商品表
		$tb_goods = new IModel('goods');
		if(!$tb_goods ->del($goodsWhere))
		{
			return;
		}

		//删除推荐类商品
		$tb_commend_goods = new IModel('commend_goods');
		$tb_commend_goods->del('goods_id = '.$goods_id);

		//删除商品公用属性
		$tb_goods_attribute = new IModel('goods_attribute');
		$tb_goods_attribute->del('goods_id = '.$goods_id);

		//删除相册商品关系表
		$tb_goods_relation = new IModel('goods_photo_relation');
		$tb_goods_relation->del('goods_id = '.$goods_id);

		//删除货品表
		$tb_products = new IModel('products');
		$tb_products->del('goods_id = '.$goods_id);

		//删除会员价格表
		$tb_group_price = new IModel('group_price');
		$tb_group_price->del('goods_id = '.$goods_id);

		//删除扩展商品分类表
		$tb_cate_extend = new IModel('category_extend');
		$tb_cate_extend->del('goods_id='.$goods_id);
	}
	/**
	 * 获取编辑商品所有数据
	 * @param int $id 商品ID
	 */
	public function edit($id)
	{
		$goodsWhere = " id = {$id} ";
		if($this->seller_id)
		{
			$goodsWhere .= " and seller_id = ".$this->seller_id;
		}

		//获取商品
		$obj_goods = new IModel('goods');
		$goods_info = $obj_goods->getObj($goodsWhere);

		if(!$goods_info)
		{
			return null;
		}

		//赋值到FORM用于渲染
		$data = array('form' => $goods_info);

		//获取商品的会员价格
		$groupPriceDB = new IModel('group_price');
		$goodsPrice   = $groupPriceDB->query("goods_id = ".$goods_info['id']." and product_id is NULL ");
		$temp = array();
		foreach($goodsPrice as $key => $val)
		{
			$temp[$val['group_id']] = $val['price'];
		}
		$goods_info['groupPrice'] = $temp ? JSON::encode($temp) : '';

		//获取货品
		$productObj = new IModel('products');
		$product_info = $productObj->query('goods_id = '.$id);
		if($product_info)
		{
			//获取货品会员价格
			foreach($product_info as $k => $rs)
			{
				$temp = array();
				$productPrice = $groupPriceDB->query('product_id = '.$rs['id']);
				foreach($productPrice as $key => $val)
				{
					$temp[$val['group_id']] = $val['price'];
				}
				$product_info[$k]['groupPrice'] = $temp ? JSON::encode($temp) : '';
			}
			$data['product'] = $product_info;
		}

		//加载推荐类型
		$tb_commend_goods = new IModel('commend_goods');
		$commend_goods = $tb_commend_goods->query('goods_id='.$goods_info['id'],'commend_id');
		if($commend_goods)
		{
			foreach($commend_goods as $value)
			{
				$data['goods_commend'][] = $value['commend_id'];
			}
		}

		//相册
		$tb_goods_photo = new IQuery('goods_photo_relation as ghr');
		$tb_goods_photo->join = 'left join goods_photo as gh on ghr.photo_id=gh.id';
		$tb_goods_photo->fields = 'gh.img';
		$tb_goods_photo->where = 'ghr.goods_id='.$goods_info['id'];
		$tb_goods_photo->order = 'ghr.id asc';
		$data['goods_photo'] = $tb_goods_photo->find();

		//扩展基本属性
		$tb_spec_attr = new IQuery('goods_attribute');
		$tb_spec_attr->where = "goods_id=".$goods_info['id']." and attribute_id != '' ";
		$spec_attr_info = $tb_spec_attr->find();
		if($spec_attr_info)
		{
			foreach($spec_attr_info as $item)
			{
				//key：属性名；val：属性值
				$data['goods_attr'][$item['attribute_id']] = $item['attribute_value'];
			}
		}

		//商品分类
		$categoryExtend = new IQuery('category_extend');
		$categoryExtend->where = 'goods_id = '.$goods_info['id'];
		$tb_goods_photo->fields = 'category_id';
		$cateData = $categoryExtend->find();
		if($cateData)
		{
			foreach($cateData as $item)
			{
				$data['goods_category'][] = $item['category_id'];
			}
		}
		return $data;
	}
	/**
	 * @param
	 * @return array
	 * @brief 无限极分类递归函数
	 */
	public static function sortdata($catArray, $id = 0 , $prefix = '')
	{
		static $formatCat = array();
		static $floor     = 0;

		foreach($catArray as $key => $val)
		{
			if($val['parent_id'] == $id)
			{
				$str         = self::nstr($prefix,$floor);
				$val['name'] = $str.$val['name'];

				$val['floor'] = $floor;
				$formatCat[]  = $val;

				unset($catArray[$key]);

				$floor++;
				self::sortdata($catArray, $val['id'] ,$prefix);
				$floor--;
			}
		}
		return $formatCat;
	}

	/**
	 * @brief 计算商品的价格区间
	 * @param $catId        商品分类id
	 * @param $showPriceNum 展示分组最大数量
	 * @return array        价格区间分组
	 */
	public static function getGoodsPrice($catId,$showPriceNum = 4)
	{
		$goodsObj     = new IModel('category_extend as ca,goods as go');
		$goodsPrice   = $goodsObj->getObj('ca.category_id in ('.$catId.') and ca.goods_id = go.id','MIN(sell_price) as min,MAX(sell_price) as max');
		if($goodsPrice['min'] <= 0)
		{
			return array();
		}

		$minBit = strlen(intval($goodsPrice['min']));
		if($minBit <= 2)
		{
			$minPrice = 99;
		}
		else
		{
			$minPrice = substr(intval($goodsPrice['min']),0,1).str_repeat('9',($minBit - 1));
		}

		//商品价格计算
		$result   = array('1-'.$minPrice);
		$perPrice = floor(($goodsPrice['max'] - $minPrice)/($showPriceNum - 1));

		if($perPrice > 0)
		{
			for($addPrice = $minPrice+1; $addPrice < $goodsPrice['max'];)
			{
				$stepPrice = $addPrice + $perPrice;
				$stepPrice = substr(intval($stepPrice),0,1).str_repeat('9',(strlen(intval($stepPrice)) - 1));
				$result[]  = $addPrice.'-'.$stepPrice;
				$addPrice  = $stepPrice + 1;
			}
		}

		return $result;
	}

	//处理商品列表显示缩进
	public static function nstr($str,$num=0)
	{
		$return = '';
		for($i=0;$i<$num;$i++)
		{
			$return .= $str;
		}
		return $return;
	}

	/**
	 * @brief  获取分类数据
	 * @param  int   $catId  分类ID
	 * @return array $result array(id => name)
	 */
	public static function catRecursion($catId)
	{
		$result = array();
		$catDB  = new IModel('category');
		$catRow = $catDB->getObj('id = '.$catId);
		while(true)
		{
			if($catRow)
			{
				array_unshift($result,array('id' => $catRow['id'],'name' => $catRow['name']));
				$catRow = $catDB->getObj('id = '.$catRow['parent_id']);
			}
			else
			{
				break;
			}
		}
		return $result;
	}

	/**
	 * @brief 获取树形分类
	 * @param int $catId 分类ID
	 * @return array
	 */
	public static function catTree($catId)
	{
		$result    = array();
		$catDB     = new IModel('category');
		$childList = $catDB->query('parent_id = '.$catId);
		if(!$childList)
		{
			$catRow = $catDB->getObj('id = '.$catId);
			$childList = $catDB->query('parent_id = '.$catRow['parent_id']);
		}
		return $childList;
	}

	/**
	 * @brief 获取子分类可以无限递归获取子分类
	 * @param int $catId 分类ID
	 * @param int $level 层级数
	 * @return array
	 */
	public static function catChild($catId,$level = 1)
	{
		if($level == 0)
		{
			return $catId;
		}

		$temp   = array();
		$result = array($catId);
		$catDB  = new IModel('category');

		while(true)
		{
			$id = current($result);
			if(!$id)
			{
				break;
			}
			$temp = $catDB->query('parent_id = '.$id);
			foreach($temp as $key => $val)
			{
				$result[] = $val['id'];
			}
			next($result);
		}
		return join(',',$result);
	}

	/**
	 * @brief 返回商品状态
	 * @param int $is_del 商品状态
	 * @return string 状态文字
	 */
	public static function statusText($is_del)
	{
		$date = array('0' => '上架','1' => '删除','2' => '下架','3' => '等审');
		return isset($date[$is_del]) ? $date[$is_del] : '';
	}
}