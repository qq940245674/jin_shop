<?php
/**
 * @copyright (c) 2014 aircheng
 * @file statistics.php
 * @brief 统计分析类库
 * @author nswe
 * @date 2014/7/27 11:09:43
 * @version 1.0.0
 */
class statistics
{
	//日期单位
	public static $dateUnit = '';

	//日期格式
	public static $format = 'Y-m-d';

	/**
	 * @brief 日期的智能处理
	 * @param string $start 开始日期 Y-m-d
	 * @param string $end   结束日期 Y-m-d
	 */
	private static function dateParse($start = '',$end = '')
	{
		//默认没有时间条件,查询之前7天的数据
		if(!$start && !$end)
		{
			$diffSec = 86400 * 6;
			$beforeDate = ITime::pass(-$diffSec,self::$format);
			return array($beforeDate,ITime::getNow(self::$format));
		}

		//有时间条件
		if($start && $end)
		{
			return array($start,$end);
		}
		else if($start)
		{
			return array($start,$start);
		}
		else if($end)
		{
			return array($end,$end);
		}
	}

	/**
	 * @brief 根据条件分组
	 * @param int 相差的秒数
	 * @return string y年,m月,d日
	 */
	private static function groupByCondition($diffSec)
	{
		//按天分组，小于30个天
		if($diffSec <= 86400 * 30)
		{
			return 'd';
		}
		//按月分组，小于24个月
		else if($diffSec <= 86400 * 30 * 24)
		{
			return 'm';
		}
		//按年分组
		else
		{
			return 'y';
		}
	}

	/**
	 * @brief 处理条件
	 * @param IQuery $db 数据库IQuery对象
	 * @param string $timeCols 时间字段名称
	 * @param string $start 开始日期 Y-m-d
	 * @param string $end   结束日期 Y-m-d
	 */
	private static function ParseCondition($db,$timeCols = 'time',$start = '',$end = '')
	{
		$result     = array();

		//获取时间段
		$date       = self::dateParse($start,$end);
		$startArray = explode('-',$date[0]);
		$endArray   = explode('-',$date[1]);
		$diffSec    = ITime::getDiffSec($date[0],$date[1]);

		switch(self::groupByCondition($diffSec))
		{
			//按照年
			case "y":
			{
				$startCondition = $startArray[0];
				$endCondition   = $endArray[0]+1;
				$db->fields .= ',DATE_FORMAT(`'.$timeCols.'`,"%Y") as xValue';
				$db->group   = "DATE_FORMAT(`".$timeCols."`,'%Y') having `".$timeCols."` >= '{$startCondition}' and `".$timeCols."` < '{$endCondition}'";
			}
			break;

			//按照月
			case "m":
			{
				$startCondition = $startArray[0].'-'.$startArray[1];
				$endCondition   = $endArray[0].'-'.($endArray[1]+1);
				$db->fields .= ',DATE_FORMAT(`'.$timeCols.'`,"%Y-%m") as xValue';
				$db->group   = "DATE_FORMAT(`".$timeCols."`,'%Y-%m') having `".$timeCols."` >= '{$startCondition}' and `".$timeCols."` < '{$endCondition}'";
			}
			break;

			//按照日
			case "d":
			{
				$startCondition = $startArray[0].'-'.$startArray[1].'-'.$startArray[2];
				$endCondition   = $endArray[0].'-'.$endArray[1].'-'.($endArray[2]+1);
				$db->fields .= ',DATE_FORMAT(`'.$timeCols.'`,"%m-%d") as xValue';
				$db->group   = "DATE_FORMAT(`".$timeCols."`,'Y-%m-%d') having `".$timeCols."` >= '{$startCondition}' and `".$timeCols."` < '{$endCondition}'";
			}
			break;
		}
		$data = $db->find();

		foreach($data as $key => $val)
		{
			$result[$val['xValue']] = intval($val['yValue']);
		}
		return $result;
	}

	/**
	 * @brief 统计注册用户的数据
	 * @param string $start 开始日期 Y-m-d
	 * @param string $end   结束日期 Y-m-d
	 * @return array key => 日期时间,value => 注册的人数
	 */
	public static function userReg($start = '',$end = '')
	{
		$db = new IQuery('member');
		$db->fields = 'count(*) as yValue,`time`';
		return self::ParseCondition($db,'time',$start,$end);
	}

	/**
	 * @brief 统计平均消费数据
	 * @param string $start 开始日期 Y-m-d
	 * @param string $end   结束日期 Y-m-d
	 * @return array key => 日期时间,value => 消费金额
	 */
	public static function spandAvg($start = '',$end = '')
	{
		$db = new IQuery('collection_doc');
		$db->fields = 'sum(amount)/count(*) as yValue,`time`';
		$db->where  = 'pay_status = 1';
		return self::ParseCondition($db,'time',$start,$end);
	}

	/**
	 * @brief 统计销售额数据
	 * @param string $start 开始日期 Y-m-d
	 * @param string $end   结束日期 Y-m-d
	 * @return array key => 日期时间,value => 销售金额
	 */
	public static function spandAmount($start = '',$end = '')
	{
		$db = new IQuery('collection_doc');
		$db->fields = 'sum(amount) as yValue,`time`';
		$db->where  = 'pay_status = 1';
		return self::ParseCondition($db,'time',$start,$end);
	}

	/**
	 * @brief 获取商家销售额统计数据
	 * @param int $seller_id 商家ID
	 * @param string $start 开始日期 Y-m-d
	 * @param string $end   结束日期 Y-m-d
	 * @return array key => 日期时间,value => 销售金额
	 */
	public static function sellerAmount($seller_id,$start = '',$end = '')
	{
		$db = new IQuery('order_goods as og');
		$db->join   = 'left join goods as go on go.id = og.goods_id left join order as o on o.id = og.order_id';
		$db->fields = 'sum(og.goods_price * og.goods_nums) as yValue,`pay_time`';
		$db->where  = "og.is_send = 1 and go.seller_id = {$seller_id} and o.pay_status = 1";
		return self::ParseCondition($db,'pay_time',$start,$end);
	}

	/**
	 * @brief 获取商品统计数据
	 * @param int $seller_id 商家ID
	 * @return int
	 */
	public static function goodsCount($seller_id = '')
	{
		$where = "is_del != 1";
		if($seller_id)
		{
			$where .= " and seller_id = {$seller_id} ";
		}

		$goodsDB = new IModel('goods');
		$data = $goodsDB->getObj($where,'count(*) as num');
		return isset($data['num']) ? $data['num'] : 0;
	}

	/**
	 * @brief 等待商品咨询回复数量
	 * @param int $seller_id 商家ID
	 * @return int
	 */
	public static function referWaitCount($seller_id = '')
	{
		$where = "re.goods_id = go.id and re.status = 0";
		if($seller_id)
		{
			$where .= " and go.seller_id = {$seller_id}";
		}
		$goodsDB = new IModel('refer as re,goods as go');
		$data = $goodsDB->getObj($where,'count(*) as num');
		return isset($data['num']) ? $data['num'] : 0;
	}

	/**
	 * @brief 等待商品评论回复数量
	 * @param int $seller_id 商家ID
	 * @return int
	 */
	public static function commentCount($seller_id = '')
	{
		$where = "co.goods_id = go.id and co.status = 1";
		if($seller_id)
		{
			$where .= " and go.seller_id = {$seller_id}";
		}
		$goodsDB = new IModel('comment as co,goods as go');
		$data = $goodsDB->getObj($where,'count(*) as num');
		return isset($data['num']) ? $data['num'] : 0;
	}

	/**
	 * @brief 商户的商品销售量
	 * @param int $seller_id 商家ID
	 * @return int
	 */
	public static function sellCountSeller($seller_id)
	{
		$goodsDB = new IModel('goods');
		$dataRow = $goodsDB->getObj("seller_id = {$seller_id}",'sum(sale) as num');
		return isset($dataRow['num']) ? intval($dataRow['num']) : 0;
	}

	/**
	 * @brief 商户的评分
	 * @param int $seller_id 商家ID
	 * @return int
	 */
	public static function gradeSeller($seller_id)
	{
		$goodsDB = new IModel('goods');
		$dataRow = $goodsDB->getObj("seller_id = {$seller_id}",'sum(grade)/sum(comments) as num');
		return isset($dataRow['num']) ? floatval($dataRow['num']) : 0;
	}
}