<?php
/**
 * @copyright (c) 2014 aircheng.com
 * @file mysqli_class.php
 * @brief mysqli数据库应用
 * @author nswe
 * @date 2014/8/20 20:47:07
 * @version 2.6
 */

/**
 * @class IMysqli
 * @brief MYSQLI数据库应用
 */
class IMysqli extends IDB
{
	//数据库连接资源
	public $linkRes = false;

	/**
	 * @brief 数据库连接
	 * @param array $dbinfo 数据库的连接配制信息 [0]ip地址 [1]用户名 [2]密码 [3]数据库
	 * @return bool or resource 值: false:链接失败; resource类型:链接的资源句柄;
	 */
	public function connect($dbinfo)
	{
		if($this->linkRes)
		{
			return $this->linkRes;
		}

		$hostArray = explode(':',$dbinfo['host']);
		$hostPort  = isset($hostArray[1]) ? $hostArray[1] : ini_get("mysqli.default_port");

	  	$this->linkRes = new mysqli($hostArray[0],$dbinfo['user'],$dbinfo['passwd'],$dbinfo['name'],$hostPort);

		if($this->linkRes->connect_errno)
		{
			throw new IException($this->linkRes->connect_error);
		}

	  	if($this->linkRes)
	  	{
		  	$DBCharset = isset(IWeb::$app->config['DB']['charset']) ? IWeb::$app->config['DB']['charset'] : 'utf8';

		  	$this->linkRes->set_charset($DBCharset);
		  	$this->linkRes->query("SET SESSION sql_mode = '' ");
		  	return $this->linkRes;
	  	}
	  	else
	  	{
	  		return false;
	  	}
	}

	/**
	* @brief MYSQL的SQL执行的系统入口
	* @param string $sql 要执行的SQL语句
	* @return mixed
	*/
	public function doSql($sql)
	{
		//读操作
		$readyConf = array('select','show','describe');
		if(in_array(self::$sqlType,$readyConf))
		{
			return $this->read($sql,MYSQLI_ASSOC);
		}

		//写操作
		else
		{
			return $this->write($sql);
		}
	}

	/**
	* @brief 获取数据库内容
	* @param $sql SQL语句
	* @param $type 返回数据的键类型
	* @return array 查询结果集
	*/
	private function read($sql,$type = MYSQLI_ASSOC)
	{
		$result   = array();
		$resource = $this->linkRes->query($sql);

		if($resource)
		{
			while($data = $resource->fetch_array($type))
			{
				$result[] = $data;
			}
			$resource->free();
			return $result;
		}
		else
		{
			throw new IException("{$sql}\n -- ".$this->linkRes->error);
		}
	}

	/**
	* @brief 写入操作
	* @param string $sql SQL语句
	* @return int or bool 失败:false; 成功:影响的结果数量;
	*/
	private function write($sql)
	{
		$result = $this->linkRes->query($sql);

		if($result==true)
		{
			switch(self::$sqlType)
			{
				case "insert":
				{
					return $this->linkRes->insert_id;
				}
				break;

				default:
				{
					return $this->linkRes->affected_rows;
				}
			}
		}
		else
		{
			throw new IException("{$sql}\n -- ".$this->linkRes->error);
			return false;
		}
	}
}