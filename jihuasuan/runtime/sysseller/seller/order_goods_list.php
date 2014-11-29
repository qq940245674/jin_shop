<?php $seller_id = $this->seller['seller_id'];$seller_name = $this->seller['seller_name'];?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>商家管理后台</title>
	<link type="image/x-icon" href="favicon.ico" rel="icon">
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/iwebshop/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/iwebshop/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/ie.css";?>" type="text/css" media="screen" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" type="text/css" media="screen" />
</head>

<body>
	<!--头部 开始-->
	<header id="header">
		<hgroup>
			<h1 class="site_title"></h1>
			<h2 class="section_title"></h2>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("");?>" target="_blank">网站首页</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("/site/home/id/$seller_id");?>" target="_blank">商家主页</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("/systemseller/logout");?>" target="_blank">退出登录</a></div>
		</hgroup>
	</header>
	<!--头部 结束-->

	<!--面包屑导航 开始-->
	<section id="secondary_bar">
		<div class="user">
			<p><?php echo isset($seller_name)?$seller_name:"";?></p>
		</div>
	</section>
	<!--面包屑导航 结束-->

	<!--侧边栏菜单 开始-->
	<aside id="sidebar" class="column">
		<h3>统计结算模块</h3>
		<ul class="toggle">
			<li class="icn_tags"><a href="<?php echo IUrl::creatUrl("/seller/index");?>">管理首页</a></li>
			<li class="icn_settings"><a href="<?php echo IUrl::creatUrl("/seller/account");?>">销售额统计</a></li>
			<li class="icn_categories"><a href="<?php echo IUrl::creatUrl("/seller/order_goods_list");?>">货款明细</a></li>
			<!-- <li class="icn_photo"><a href="<?php echo IUrl::creatUrl("/seller/bill_list");?>">货款结算单列表</a></li> -->
		</ul>

		<h3>商品模块</h3>
		<ul class="toggle">
			<li class="icn_categories"><a href="<?php echo IUrl::creatUrl("/seller/goods_list");?>">商品列表</a></li>
			<li class="icn_new_article"><a href="<?php echo IUrl::creatUrl("/seller/goods_edit");?>">添加商品</a></li>
			<li class="icn_audio"><a href="<?php echo IUrl::creatUrl("/seller/refer_list");?>">商品咨询</a></li>
		<!-- 	<li class="icn_categories"><a href="<?php echo IUrl::creatUrl("/seller/spec_list");?>">规格列表</a></li> -->
		</ul>

		<h3>订单模块</h3>
		<ul class="toggle">
			<li class="icn_categories"><a href="<?php echo IUrl::creatUrl("/seller/order_list");?>">订单列表</a></li>
		</ul>

	<!-- 	<h3>营销模块</h3>
		<ul class="toggle">
			<li class="icn_view_users"><a href="<?php echo IUrl::creatUrl("/seller/regiment_list");?>">团购</a></li>
		</ul> -->

		<h3>信息模块</h3>
		<ul class="toggle">
			<li class="icn_profile"><a href="<?php echo IUrl::creatUrl("/seller/seller_edit");?>">资料修改</a></li>
			<li class="icn_video"><a href="<?php echo IUrl::creatUrl("/site/home/id/$seller_id");?>" target="_blank">主页信息</a></li>
		</ul>

		<footer>
			<hr />
			<p><strong>Copyright &copy; 2014 集划算</strong></p>
			<p>Powered by <a href="http://www.jihuasuan.com">集划算</a></p>
		</footer>
	</aside>
	<!--侧边栏菜单 结束-->

	<!--主体内容 开始-->
	<section id="main" class="column">
		<?php $seller_id = $this->seller['seller_id']?>
<?php $siteConfig = new Config("site_config")?>

<h4 class="alert_info">您最近的货款明细</h4>
<h4 class="alert_warning">只有<在线支付>(非货到付款) 并且 <发货后>的商品才会统计到这里</h4>

<article class="module width_full">
	<header>
		<h3 class="tabs_involved">商品货款明细</h3>
		<!-- <ul class="tabs">
			<li><input type="button" class="alt_btn" onclick="window.location.href='<?php echo IUrl::creatUrl("/seller/bill_edit");?>';" value="申请结算货款" /></li>
		</ul> -->
	</header>

	<table class="tablesorter" cellspacing="0">
		<colgroup>
			<col width="165px" />
			<col width="325px" />
			<col width="110px" />
			<col width="110px" />
			<col width="70px" />
			<col width="85px" />
			<col width="70px" />
			<col />
		</colgroup>

		<thead>
			<tr>
				<th>订单号</th>
				<th>商品信息</th>
				<th>货款计费</th>
				<th>返利金额</th>
				<th>其他计费</th>
				<th>总计</th>
				<th>下单时间</th>
				<th>结算状态</th>
				<th>操作</th>
			</tr>
		</thead>

		<tbody>
			<?php 
				$page = (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;
				$orderGoodsQuery = CountSum::getSellerGoodsFeeQuery($seller_id);
				$orderGoodsQuery->page = $page;
			?>

			<?php foreach($orderGoodsQuery->find() as $key => $item){?>
			<?php $goodsSum    = $item['goods_price'] * $item['goods_nums']?>
			<?php $orderWeight = $item['goods_weight']* $item['goods_nums']?>
			<?php $orderCount = CountSum::countOrderFee($goodsSum,$goodsSum,$orderWeight,$item['province'],$item['distribution'],0,false,$item['if_insured'],$item['invoice'])?>
			<tr>
				<td title="<?php echo isset($item['order_no'])?$item['order_no']:"";?>"><?php echo isset($item['order_no'])?$item['order_no']:"";?></td>
				<td>
					<img src='<?php echo IUrl::creatUrl("")."$item[img]";?>' class="ico" />
					<?php $goodsRow = JSON::decode($item['goods_array'])?>
					<?php echo isset($goodsRow['name'])?$goodsRow['name']:"";?> &nbsp;&nbsp; <?php echo isset($goodsRow['value'])?$goodsRow['value']:"";?>
					<label class="orange bold">X <?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?> 件</label>
				</td>
				<td>￥<?php echo isset($item['goods_price'])?$item['goods_price']:"";?> x <label class="orange bold"><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?> 件</label></td>
				<td>￥<?php echo isset($item['fan_money'])?$item['fan_money']:"";?></td>
				<td width="100px">
					<p>运费：￥<?php echo isset($orderCount['deliveryPrice'])?$orderCount['deliveryPrice']:"";?>
					<p>保价：￥<?php echo isset($orderCount['insuredPrice'])?$orderCount['insuredPrice']:"";?>
					<p>税金：￥<?php echo isset($orderCount['taxPrice'])?$orderCount['taxPrice']:"";?>
				</td>
				<td title="<?php echo isset($orderCount['orderAmountPrice'])?$orderCount['orderAmountPrice']:"";?>">￥<?php echo isset($orderCount['orderAmountPrice'])?$orderCount['orderAmountPrice']:"";?></td>
				<td title="<?php echo isset($item['create_time'])?$item['create_time']:"";?>"><?php echo isset($item['create_time'])?$item['create_time']:"";?></td>
				<td width="100px">
					<?php if($item['is_checkout'] == 1){?>
					<label class="green">已结算</label>
					<?php }else{?>
					<label class="orange">未结算</label>
					<?php }?>
				</td>
				<td><a href="<?php echo IUrl::creatUrl("/seller/order_show/id/$item[order_id]");?>"><img title="订单详情" alt="订单详情" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/main/icn_settings.png";?>" /></a></td>
			</tr>
			<?php }?>
		</tbody>
	</table>

	<?php echo $orderGoodsQuery->getPageBar();?>
</article>
	</section>
	<!--主题内容 结束-->
</body>
</html>