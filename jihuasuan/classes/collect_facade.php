<?php
/**
 * @brief 商品采集器与iwebshop外观模式
 * @author chendeshan
 * @date 2014/1/2 8:25:15
 */
class collect_facade
{
	/**
	 * @brief 运行采集功能
	 * @param string $collect_name 采集器名字
	 * @param string $url 采集器url地址
	 * @param int $num 采集商品数量
	 */
	public static function run($collect_name,$url,$num = 20)
	{
		set_time_limit(0);
		ini_set("max_execution_time", "0");

		$pluginDir = IWeb::$app->getBasePath().'plugins/collect/';

		switch($collect_name)
		{
			//京东商城数据采集器
			case 'jd':
			{
				include_once($pluginDir.'jd_collect.php');
				$collectorObject = new jd_collect();
			}
			break;

			default:
			{
				return array('result' => 'fail','message' => '没有找到采集器');
			}
		}

		$collectorObject->readListPage($url);
		$goodsData = $collectorObject->collect($num);

		//实例化对象
		$catObj    = new IModel('category');
		$catExtObj = new IModel('category_extend');
		$attrObj   = new IModel('attribute');
		$goodsObj  = new IModel('goods');
		$goodsAttrObj = new IModel('goods_attribute');
		$photoObj     = new IModel('goods_photo');
		$photoRelObj  = new IModel('goods_photo_relation');
		$modelObj     = new IModel('model');
		$productsObj  = new IModel('products');

		//信息入库
		if(isset($goodsData['cat']) && $goodsData['cat'])
		{
			$model_id = 0;
			$attrMap  = array();
			if(isset($goodsData['attr']) && $goodsData['attr'])
			{
				$modelName = end($goodsData['cat']);

				//1,模型存在情况-直接读取
				if($modelRow = $modelObj->getObj('name = "'.$modelName.'"'))
				{
					$model_id = $modelRow['id'];
					$attrList = $attrObj->query('model_id = '.$model_id);
					foreach($attrList as $key => $val)
					{
						$attrMap[$val['name']] = $val['id'];
					}
				}
				//2,模型不存在情况-插入操作
				else
				{
					//创建模型
					$modelObj->setData(array('name' => $modelName));
					$model_id = $modelObj->add();

					//创建模型属性
					foreach($goodsData['attr'] as $key => $val)
					{
						$attrObj->setData(array('model_id' => $model_id,'type' => 2,'name' => $key,'value' => $val,'search' => 1));
						$newAttrId = $attrObj->add();
						$attrMap[$key] = $newAttrId;
					}
				}
			}

			//分类添加
			$parentId = 0;
			$catPath = array();
			foreach($goodsData['cat'] as $key => $val)
			{
				if($catRow = $catObj->getObj('name = "'.$val.'"'))
				{
					$catPath[] = $parentId = $catRow['id'];
				}
				else
				{
					$catObj->setData(array('name' => $val,'parent_id' => $parentId,'model_id' => $model_id));
					$parentId = $catObj->add();
					$catPath[] = $parentId;
				}
			}

			//处理商品数据
			foreach($goodsData['item'] as $key => $val)
			{
				//商品添加
				$goodsObj->setData(array(
					'name'         => $val['name'],
					'sell_price'   => $val['price'],
					'market_price' => $val['price'],
					'model_id'     => $model_id,
					'goods_no'     => $val['goods_no'],
					'up_time'      => $val['up_time'],
					'content'      => IFilter::act($val['content'],'text'),
					'store_nums'   => 100,
					'weight'       => $val['weight'],
					'unit'         => $val['unit'],
					'create_time'  => date('Y-m-d H:i:s'),
				));
				$goods_id = $goodsObj->add();

				//商品图片拷贝
				if(isset($val['img']) && $val['img'])
				{
					foreach($val['img'] as $img)
					{
						$md5Val     = md5_file($img);
						$photoData  = $photoObj->getObj('id = "'.$md5Val.'"');

						//如果图库中没有图片数据就要拷贝
						if(!$photoData)
						{
							$destFile = PhotoUpload::hashDir().'/'.basename($img);

							while(true)
							{
								$copyResult = IFile::copy($img,$destFile);
								if($copyResult)
								{
									$photoObj->setData(array('id' => $md5Val,'img' => $destFile));
									$photoObj->add();
									break;
								}
							}
						}

						//商品图片关联
						$photoRelObj->setData(array('goods_id' => $goods_id,'photo_id' => $md5Val));
						$photoRelObj->add();
					}

					$imgVal = isset($destFile) ? $destFile : $photoData['img'];
					$goodsObj->setData(array('img' => $imgVal));
					$goodsObj->update('id = '.$goods_id);
				}

				//商品与商品分类关联
				if($catPath)
				{
					foreach($catPath as $catId)
					{
						$catExtObj->setData(array('goods_id' => $goods_id,'category_id' => $catId));
						$catExtObj->add();
					}
				}

				//商品与属性关联
				if(isset($val['attr']) && $val['attr'])
				{
					foreach($val['attr'] as $attrName => $attrVal)
					{
						if(isset($attrMap[$attrName]))
						{
							$attrArray = explode('，',$attrVal);
							foreach($attrArray as $k => $v)
							{
								$goodsAttrObj->setData(array(
									'goods_id' => $goods_id,
									'attribute_id' => $attrMap[$attrName],
									'attribute_value' => $v,
									'model_id' => $model_id
								));
								$goodsAttrObj->add();
							}
						}
					}
				}
			}
			return array('result' => 'success');
		}
		else
		{
			return array('result' => 'fail','message' => '采集信息不存在');
		}
	}
}