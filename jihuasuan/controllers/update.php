<?php
/**
 * @brief 升级更新控制器
 */
class Update extends IController
{
	/**
	 * @brief iwebshop14090000 版本升级更新
	 */
	public function iwebshop14090000()
	{
		$sql = array(
			"DROP table IF EXISTS `iweb_seller`",
			"
			CREATE TABLE `iweb_seller` (
			  `id` int(11) unsigned NOT NULL auto_increment,
			  `seller_name` varchar(80) NOT NULL COMMENT '商家登录用户名',
			  `password` char(32) NOT NULL COMMENT '商家密码',
			  `create_time` datetime DEFAULT NULL COMMENT '加入时间',
			  `login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
			  `is_vip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是特级商家',
			  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未删除,1:已删除',
			  `is_lock` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未锁定,1:已锁定',
			  `true_name` varchar(80) NOT NULL COMMENT '商家真实名称',
			  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '电子邮箱',
			  `mobile` varchar(20) NOT NULL COMMENT '手机号码',
			  `phone` varchar(20) NOT NULL COMMENT '座机号码',
			  `paper_img` varchar(255) DEFAULT NULL COMMENT '执照证件照片',
			  `cash` decimal(15,2) DEFAULT NULL COMMENT '保证金',
			  `country` int(11) unsigned default NULL COMMENT '国ID',
			  `province` int(11) unsigned NOT NULL COMMENT '省ID',
			  `city` int(11) unsigned NOT NULL COMMENT '市ID',
			  `area` int(11) unsigned NOT NULL COMMENT '区ID',
			  `address` varchar(255) NOT NULL COMMENT '地址',
			  `account` text COMMENT '收款账号信息',
			  `server_num` varchar(20) default NULL COMMENT '客服号码',
			  `home_url` varchar(255) default NULL COMMENT '企业URL网站',
			  UNIQUE KEY `seller_name` (`seller_name`),
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商家表';
			",
			"DROP table IF EXISTS `iweb_bill`",
			"
			CREATE TABLE `iweb_bill` (
			  `id` int(11) unsigned NOT NULL auto_increment,
			  `seller_id` int(11) NOT NULL COMMENT '商家ID',
			  `apply_time` datetime DEFAULT NULL COMMENT '申请结算时间',
			  `pay_time` datetime DEFAULT NULL COMMENT '支付结算时间',
			  `admin_id` int(11) DEFAULT NULL COMMENT '管理员ID',
			  `is_pay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未结算,1:已结算',
			  `apply_content` text COMMENT '申请结算文本',
			  `pay_content` text COMMENT '支付结算文本',
			  `start_time` date DEFAULT NULL COMMENT '结算起始时间',
			  `end_time` date DEFAULT NULL COMMENT '结算终止时间',
			  `log` text COMMENT '结算明细',
			  `order_goods_ids` text COMMENT 'order_goods表主键ID，结算的ID',
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商家货款结算单表';
			",
			"DROP table IF EXISTS `iweb_delivery_goods`",
			"
			CREATE TABLE `iweb_delivery_goods` (
			  `id` int(11) unsigned NOT NULL auto_increment,
			  `delivery_id` int(11) unsigned NOT NULL COMMENT '发货单ID',
			  `goods_id` int(11) unsigned default NULL COMMENT '商品ID',
			  `product_id` int(11) unsigned default NULL COMMENT '货品id',
			  `goods_nums` int(11) default NULL COMMENT '货品数量',
			  `time` datetime NOT NULL COMMENT '时间',
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='发货清单';
			",

			"ALTER TABLE `iweb_spec` ADD `seller_id` int(11) default '0' COMMENT '商家ID'",

			"ALTER TABLE `iweb_goods` ADD `ad_img` varchar(255) default NULL COMMENT '宣传图'",

			"ALTER TABLE `iweb_refer` ADD `seller_id` int(11) unsigned default '0' COMMENT '回复的商户ID'",

			"ALTER TABLE `iweb_order_goods` ADD `is_send` tinyint(1) NOT NULL default '0' COMMENT '是否已发货 0:未发货;1:已发货'",
			"ALTER TABLE `iweb_order_goods` ADD `delivery_id` int(11) NOT NULL default '0' COMMENT '配送ID'",

			"ALTER TABLE `iweb_delivery_doc` ADD `freight_id` int(11) unsigned NOT NULL COMMENT '货运公司ID'",
			"ALTER TABLE `iweb_delivery_doc` ADD `seller_id` int(11) unsigned default '0' COMMENT '商户ID'",

			"ALTER TABLE `iweb_ad_manage` ADD `goods_cat_id` int(11) default '0' COMMENT '绑定的商品分类ID'",

			"ALTER TABLE `iweb_regiment` ADD `sort` smallint(5) NOT NULL DEFAULT '99' COMMENT '排序'",

			"ALTER TABLE `iweb_order_goods` ADD `is_checkout` tinyint(1) NOT NULL default '0' COMMENT '是否给商家结算货款 0:未结算;1:已结算'",

			"ALTER TABLE `iweb_payment` ADD `config_param` text NOT NULL",
		);

		foreach($sql as $key => $val)
		{
			$val = str_replace('iweb_',IWeb::$app->config['DB']['tablePre'],$val);
			IDBFactory::getDB()->query($val);
		}

		die('升级成功！');
	}
}