<?php
/**
 * @copyright (c) 2011 aircheng.com
 * @file hsms.php
 * @brief 短信发送接口
 * @author chendeshan
 * @date 2014/8/11 9:51:51
 * @version 2.6
 */

 /**
 * @class Hsms
 * @brief 短信发送接口
 */
class Hsms
{
	/**
	 * @brief 获取config用户配置
	 * @return array
	 */
	private static function getConfig()
	{
		$siteConfigObj = new Config("site_config");

		return array(
			'userid'   => $siteConfigObj->sms_userid,
			'username' => $siteConfigObj->sms_username,
			'userpwd'  => $siteConfigObj->sms_pwd,
		);
	}

	/**
	 * @brief 发送短信
	 * @param string $mobile
	 * @param string $content
	 */
	public static function send($mobile,$content)
	{
		$config = self::getConfig();

		$post_data = array(
			'userid'   => $config['userid'],
			'account'  => $config['username'],
			'password' => $config['userpwd'],
			'content'  => $content,
			'mobile'   => $mobile,
			'sendtime' => '',
		);

		$url    = 'http://www.duanxin10086.com/sms.aspx?action=send';
		$string = '';
		foreach ($post_data as $k => $v)
		{
		   $string .="$k=".urlencode($v).'&';
		}

		$post_string = substr($string,0,-1);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
		curl_exec($ch);
	}

	/**
	 * @brief 订单发货的信息模板
	 * @param array $data 替换的数据
	 */
	public static function sendGoodsTemplate($data = null)
	{
		$siteConfig = new Config("site_config");
		$templateString = "您好{user_name}，订单号为 {order_no} 已经由 {sendor} 发货，物流公司：{delivery_company}，物流单号：{delivery_no}。{$siteConfig->name}为您服务";
		return strtr($templateString,$data);
	}
}