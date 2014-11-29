<?php
/**
 * @brief ��Ʒ�ɼ�����iwebshop���ģʽ
 * @author chendeshan
 * @date 2014/1/2 8:25:15
 */
class collect_facade
{
	/**
	 * @brief ���вɼ�����
	 * @param string $collect_name �ɼ�������
	 * @param string $url �ɼ���url��ַ
	 * @param int $num �ɼ���Ʒ����
	 */
	public static function run($collect_name,$url,$num = 20)
	{
		set_time_limit(0);
		ini_set("max_execution_time", "0");

		$pluginDir = IWeb::$app->getBasePath().'plugins/collect/';

		switch($collect_name)
		{
			//�����̳����ݲɼ���
			case 'jd':
			{
				include_once($pluginDir.'jd_collect.php');
				$collectorObject = new jd_collect();
			}
			break;

			default:
			{
				return array('result' => 'fail','message' => 'û���ҵ��ɼ���');
			}
		}

		$collectorObject->readListPage($url);
		$goodsData = $collectorObject->collect($num);

		//ʵ��������
		$catObj    = new IModel('category');
		$catExtObj = new IModel('category_extend');
		$attrObj   = new IModel('attribute');
		$goodsObj  = new IModel('goods');
		$goodsAttrObj = new IModel('goods_attribute');
		$photoObj     = new IModel('goods_photo');
		$photoRelObj  = new IModel('goods_photo_relation');
		$modelObj     = new IModel('model');
		$productsObj  = new IModel('products');

		//��Ϣ���
		if(isset($goodsData['cat']) && $goodsData['cat'])
		{
			$model_id = 0;
			$attrMap  = array();
			if(isset($goodsData['attr']) && $goodsData['attr'])
			{
				$modelName = end($goodsData['cat']);

				//1,ģ�ʹ������-ֱ�Ӷ�ȡ
				if($modelRow = $modelObj->getObj('name = "'.$modelName.'"'))
				{
					$model_id = $modelRow['id'];
					$attrList = $attrObj->query('model_id = '.$model_id);
					foreach($attrList as $key => $val)
					{
						$attrMap[$val['name']] = $val['id'];
					}
				}
				//2,ģ�Ͳ��������-�������
				else
				{
					//����ģ��
					$modelObj->setData(array('name' => $modelName));
					$model_id = $modelObj->add();

					//����ģ������
					foreach($goodsData['attr'] as $key => $val)
					{
						$attrObj->setData(array('model_id' => $model_id,'type' => 2,'name' => $key,'value' => $val,'search' => 1));
						$newAttrId = $attrObj->add();
						$attrMap[$key] = $newAttrId;
					}
				}
			}

			//�������
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

			//������Ʒ����
			foreach($goodsData['item'] as $key => $val)
			{
				//��Ʒ���
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

				//��ƷͼƬ����
				if(isset($val['img']) && $val['img'])
				{
					foreach($val['img'] as $img)
					{
						$md5Val     = md5_file($img);
						$photoData  = $photoObj->getObj('id = "'.$md5Val.'"');

						//���ͼ����û��ͼƬ���ݾ�Ҫ����
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

						//��ƷͼƬ����
						$photoRelObj->setData(array('goods_id' => $goods_id,'photo_id' => $md5Val));
						$photoRelObj->add();
					}

					$imgVal = isset($destFile) ? $destFile : $photoData['img'];
					$goodsObj->setData(array('img' => $imgVal));
					$goodsObj->update('id = '.$goods_id);
				}

				//��Ʒ����Ʒ�������
				if($catPath)
				{
					foreach($catPath as $catId)
					{
						$catExtObj->setData(array('goods_id' => $goods_id,'category_id' => $catId));
						$catExtObj->add();
					}
				}

				//��Ʒ�����Թ���
				if(isset($val['attr']) && $val['attr'])
				{
					foreach($val['attr'] as $attrName => $attrVal)
					{
						if(isset($attrMap[$attrName]))
						{
							$attrArray = explode('��',$attrVal);
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
			return array('result' => 'fail','message' => '�ɼ���Ϣ������');
		}
	}
}