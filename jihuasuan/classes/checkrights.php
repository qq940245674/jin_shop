<?php
/**
 * @copyright (c) 2014 www.aircheng.com
 * @file CheckRight.php
 * @brief 权限校验类,包括admin(管理员),seller(商家),user(注册用户)
 * @author chendeshan
 * @date 2014/7/29 12:22:07
 * @version 2.7
 */
class CheckRights extends IInterceptorBase
{
	/**
	 * admin分享给seller的action
	 * 控制器名称(controller) @ 动作名称(action)
	 */
	private static $adminShareSellerAction = array
	(
		'goods@search_spec',
		'goods@select_spec',
		'goods@spec_edit',
		'goods@spec_update',

		'pic@upload_json',
	);

	//商家action校验
	private static $sellerAction = array('seller@goods_img_upload' => 'sellerImageUpload');

	//管理员action校验
	private static $adminAction  = array('goods@goods_img_upload' => 'adminImageUpload');

	//检查sessionId
	public static function getSessionId()
	{
		return isset($_COOKIE[session_name()]) && $_COOKIE[session_name()] ? $_COOKIE[session_name()] : "";
	}

	/**
	 * @brief 获取通用的管理员数组
	 */
	public static function getAdmin()
	{
		if(!self::getSessionId())
		{
			return null;
		}

		$admin = array(
			'admin_id'        => ISafe::get('admin_id'),
			'admin_name'      => ISafe::get('admin_name'),
			'admin_pwd'       => ISafe::get('admin_pwd'),
			'admin_role_name' => ISafe::get('admin_role_name'),
		);

		if(self::isValidAdmin($admin['admin_name'],$admin['admin_pwd']))
		{
			return $admin;
		}
		else
		{
			ISafe::clear('admin_id');
			ISafe::clear('admin_name');
			ISafe::clear('admin_pwd');
			ISafe::clear('admin_role_name');
			return null;
		}
	}

	/**
	 * @brief 获取通用的商户数组
	 */
	public static function getSeller()
	{
		$seller = array(
			'seller_id'   => ISafe::get('seller_id'),
			'seller_name' => ISafe::get('seller_name'),
			'seller_pwd'  => ISafe::get('seller_pwd'),
		);

		if(self::isValidSeller($seller['seller_name'],$seller['seller_pwd']))
		{
			return $seller;
		}
		else
		{
			ISafe::clear('seller_id');
			ISafe::clear('seller_name');
			ISafe::clear('seller_pwd');
			return null;
		}
	}

	/**
	 * @brief 获取通用的注册用户数组
	 */
	public static function getUser()
	{
		$user = array(
			'user_id'  => ISafe::get('user_id'),
			'username' => ISafe::get('username'),
			'head_ico' => ISafe::get('head_ico'),
			'user_pwd' => ISafe::get('user_pwd'),
		);

		if(self::isValidUser($user['username'],$user['user_pwd']))
		{
			return $user;
		}
		else
		{
			ISafe::clear('user_id');
			ISafe::clear('username');
			ISafe::clear('head_ico');
			ISafe::clear('user_pwd');
			return null;
		}
	}

	/**
	 * [接口]对所有的管理类控制器进行动作拦截
	 */
	public static function onCreateAction()
	{
		$controllerInstance = IWeb::$app->getController();
		switch($controllerInstance->getId())
		{
			case "seller":
			{
				//检查商家身份
				self::checkSellerRights();
			}
			break;

			default:
			{
				//检查管理员身份
				self::checkAdminRights();
			}
			break;
		}
	}

	/**
	 * [接口]对所有的前台控制器进行动作拦截
	 */
	public static function checkUserRights()
	{
		$object = IWeb::$app->getController();
		$object->user = self::getUser();
	}

	/**
	 * @brief 检查商家权限是否通过
	 * @return boolean
	 */
	public static function checkSellerRights()
	{
		$object       = IWeb::$app->getController();
		$controllerId = $object->getId();
		$actionId     = $object->getAction()->getId();

		//1,针对独立配置的action检测
		if(isset(self::$sellerAction[$controllerId."@".$actionId]) && method_exists(__CLASS__,self::$sellerAction[$controllerId."@".$actionId]))
		{
			call_user_func(array(__CLASS__,self::$sellerAction[$controllerId."@".$actionId]));
			return;
		}
		//2,其余action检测
		else
		{
			$object->seller = self::getSeller();
			if(!$object->seller)
			{
				$object->redirect('/systemseller/index');
			}
		}
	}

	//后台管理员权限校验
	public static function checkAdminRights()
	{
		$object       = IWeb::$app->getController();
		$controllerId = $object->getId();
		$actionId     = $object->getAction()->getId();

		//1,针对独立配置的action检测
		if(isset(self::$adminAction[$controllerId."@".$actionId]) && method_exists(__CLASS__,self::$adminAction[$controllerId."@".$actionId]))
		{
			call_user_func(array(__CLASS__,self::$adminAction[$controllerId."@".$actionId]));
			return;
		}
		//2,admin共享给seller
		else if(in_array($controllerId."@".$actionId,self::$adminShareSellerAction) && ($object->seller = self::getSeller()))
		{
			$object->admin = self::getAdmin();
			return;
		}
		//3,其余action检测
		else
		{
			$admin = self::getAdmin();
			if(!$admin)
			{
				$object->redirect('/systemadmin/index');
			}

			//获取管理员数据
			$adminRow = self::isValidAdmin($admin['admin_name'],$admin['admin_pwd']);

			//非超管角色
			if($adminRow['role_id'] != 0)
			{
				$roleObj = new IModel('admin_role');
				$where   = 'id = '.$adminRow["role_id"].' and is_del = 0';
				$roleRow = $roleObj->getObj($where);

				//角色权限校验
				if(self::checkRight($roleRow['rights']) == false)
				{
					IError::show('503','no permission to access');
					exit;
				}
			}

			$object->admin = $admin;
		}
	}

	/**
	 * @brief 权限校验拦截
	 * @param string $ownRight 用户的权限码
	 * @return bool true:校验通过; false:校验未通过
	 */
	private static function checkRight($ownRight)
	{
		$controllerInstance = IWeb::$app->getController();
		$actionId           = $controllerInstance->getAction()->getId();

		//是否需要权限校验 true:需要; false:不需要
		$isCheckRight = false;
		if($controllerInstance->checkRight == 'all')
		{
			$isCheckRight = true;
		}
		else if(is_array($controllerInstance->checkRight))
		{
			if(isset($controllerInstance->checkRight['check']) && ( ($controllerInstance->checkRight['check'] == 'all') || ( is_array($controllerInstance->checkRight['check']) && in_array($actionId,$controllerInstance->checkRight['check']) ) ) )
			{
				$isCheckRight = true;
			}

			if(isset($controllerInstance->checkRight['uncheck']) && is_array($controllerInstance->checkRight['uncheck']) && in_array($actionId,$controllerInstance->checkRight['uncheck']))
			{
				$isCheckRight = false;
			}
		}

		//需要校验权限
		if($isCheckRight == true)
		{
			$rightCode = $controllerInstance->getId().'@'.$actionId; //拼接的权限校验码
			$ownRight  = ','.trim($ownRight,',').',';

			if(stripos($ownRight,','.$rightCode.',') === false)
				return false;
			else
				return true;
		}
		else
			return true;
	}

	/**
	 * @brief  校验注册用户身份信息
	 * @param  string $login_info 用户名或者email
	 * @param  string $password   用户名的md5密码
	 * @return array or false 如果合法则返回用户数据;不合法返回false
	 */
	public static function isValidUser($login_info,$password)
	{
		$login_info = IFilter::act($login_info);
		$password   = IFilter::act($password);

		$userObj = new IModel('user as u,member as m');
		$where   = "u.username = '{$login_info}' and m.status = 1 and u.id = m.user_id";
		$userRow = $userObj->getObj($where);

		if(empty($userRow))
		{
			$where   = "email = '{$login_info}' and m.status = 1 and u.id = m.user_id";
			$userRow = $userObj->getObj($where);
		}

		if($userRow && ($userRow['password'] == $password))
		{
			return $userRow;
		}
		return false;
	}

	/**
	 * @brief 验证卖家身份信息
	 * @param string $login_info 登录信息
	 * @param string $password 登录密码
	 * @param array or false
	 */
	private static function isValidSeller($login_info,$password)
	{
		$login_info = IFilter::act($login_info);
		$password   = IFilter::act($password);

		$sellerObj = new IModel('seller');
		$where     = "seller_name = '{$login_info}' and is_del = 0 and is_lock = 0";
		$sellerRow = $sellerObj->getObj($where);

		if($sellerRow && ($sellerRow['password'] == $password))
		{
			return $sellerRow;
		}
		return false;
	}

	/**
	 * @brief 验证管理员身份信息
	 * @param string $login_info 登录信息
	 * @param string $password 登录密码
	 * @param array or false
	 */
	private static function isValidAdmin($login_info,$password)
	{
		$login_info = IFilter::act($login_info);
		$password   = IFilter::act($password);

		$adminObj = new IModel('admin');
		$where    = "admin_name='{$login_info}' and is_del = 0";
		$adminRow = $adminObj->getObj($where);

		if($adminRow && ($adminRow['password'] == $password))
		{
			return $adminRow;
		}
		return false;
	}

	//管理员商品图片上传校验
	public static function adminImageUpload()
	{
		$result = self::isValidAdmin(IReq::get('admin_name'),IReq::get('admin_pwd'));
		if($result == false)
		{
			die('the sellerImageUpload is stoped');
		}
	}

	//商家商品图片上传校验
	public static function sellerImageUpload()
	{
		$result = self::isValidSeller(IReq::get('admin_name'),IReq::get('admin_pwd'));
		if($result == false)
		{
			die('the sellerImageUpload is stoped');
		}
	}
}