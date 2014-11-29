<?php
/**
 * @copyright Copyright(c) 2014 aircheng.com
 * @file offline.php
 * @brief 线下支付
 * @author nswe
 * @date 2014/9/1 9:09:28
 * @version 2.7
 */

 /**
 * @class offline
 * @brief 线下支付
 */
class offline extends paymentPlugin
{
	//支付插件名称
    public $name = '线下支付';

	/**
	 * @see paymentplugin::notifyStop()
	 */
	public function notifyStop(){}
	
	/**
	 * @see paymentplugin::getSubmitUrl()
	 */
	  public function getSubmitUrl()
    {
    	return IUrl::getHost() . IUrl::creatUrl('/ucenter/offline');
    }

	/**
	 * @see paymentplugin::getSendData()
	 */
	public function getSendData($paymentInfo){
		$return = array();
		$return['postscript'] = $paymentInfo['M_Remark'];
		$return['orderid'] = $paymentInfo['M_OrderId'];
		$return['orderon'] = $paymentInfo['M_OrderNO'];
		$return['amount'] = $paymentInfo['M_Amount'];
		$return['paymentid'] = $paymentInfo['M_Paymentid'];		
		$return['mobile'] = $paymentInfo['P_Mobile'];
		$return['return_url'] = $this->callbackUrl;
		$return['li_notify_url'] = $this->serverCallbackUrl;	
		$return['payment_type'] = 2;

		//除去待签名参数数组中的空值和签名参数
		$para_filter = $this->paraFilter($return);
		//对待签名参数数组排序
		$para_sort = $this->argSort($para_filter);
		$mysign = $this->buildMysign($para_sort,$paymentInfo['M_OrderId']);
		
		$return['sign'] = $mysign;
		$return['sign_type'] = 'MD5';
		return $return;
	}
	/**
	 * 生成签名结果
	 * @param $sort_para 要签名的数组
	 * @param $key 支付宝交易安全校验码
	 * @param $sign_type 签名类型 默认值：MD5
	 * return 签名结果字符串
	 */
	private function buildMysign($sort_para,$key,$sign_type = "MD5")
	{
		//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$prestr = $this->createLinkstring($sort_para);
		//把拼接后的字符串再与安全校验码直接连接起来
		$prestr = $prestr.$key;
		//把最终的字符串签名，获得签名结果
		$mysgin = md5($prestr);
		return $mysgin;
	}
	
	/**
	 * 除去数组中的空值和签名参数
	 * @param $para 签名参数组
	 * return 去掉空值与签名参数后的新签名参数组
	 */
	private function paraFilter($para)
	{
		$para_filter = array();
		foreach($para as $key => $val)
		{
			if($key == "sign" || $key == "sign_type" || $val == "")
			{
				continue;
			}
			else
			{
				$para_filter[$key] = $para[$key];
			}
		}
		return $para_filter;
	}

	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	private function createLinkstring($para)
	{
		$arg  = "";
		
		foreach($para as $key => $val)
		{
			$arg.=$key."=".$val."&";
		}

		//去掉最后一个&字符
		$arg = trim($arg,'&');

		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc())
		{
			$arg = stripslashes($arg);
		}

		return $arg;
	}
	
	/**
	 * 对数组排序
	 * @param $para 排序前的数组
	 * return 排序后的数组
	 */
	private function argSort($para)
	{
		ksort($para);
		reset($para);
		return $para;
	}
	
	/**
	 * @see paymentplugin::callback()
	 */
	public function callback($ExternalData,&$paymentId,&$money,&$message,&$orderNo){
	
        $user_id    = ISafe::get('user_id');
		$orderid = $ExternalData['orderid'];
		$is_success = $ExternalData['is_success'];
		unset($ExternalData['is_success']);
		
		$old_li_notify_url = $ExternalData['li_notify_url'];
		$old_return_url = $ExternalData['return_url'];
		$ExternalData['return_url'] = $this->callbackUrl;
		$ExternalData['li_notify_url'] = $this->serverCallbackUrl;	
		
		$temp = array();
        foreach($ExternalData as $k => $v)
        {
            if($k!='sign')
            {
                $temp[] = $k.'='.$v;
            }
        }
        $testStr = join('&',$temp).$orderid;
        $orderNo = $ExternalData['orderon'];
        $money   = $ExternalData['amount'];
		$ExternalData['is_success'] = $is_success;
		
        if($ExternalData['sign'] == md5($testStr))
        {
            //支付单号
            switch($ExternalData['is_success'])
            {
                case 'T':
                {
					$log    = new AccountLog();
					$config = array(
						'user_id'  => $user_id,
						'event'    => 'pay',
						'note'     => '已提交淘宝订单号，等待卖家发货',
						'num'      => '-'.$money,
						'order_id' => $orderNo,
					);
					$log->write($config);
                	return true;
                }
                break;

                case 'F':
                {
                	return false;
                }
                break;
				
				default :
					return false;
				break;
            }
        }
        else
        {
        	$message = '校验码不正确';
        }
        return false;
	}

	/**
	 * @see paymentplugin::serverCallback()
	 */
	public function serverCallback($ExternalData,&$paymentId,&$money,&$message,&$orderNo){}
}