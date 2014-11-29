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

<article class="module width_full">
	<header>
		<h3 class="tabs_involved">订单查看</h3>

		<ul class="tabs" name="menu1">
			<li id="li_1" class="active"><a href="javascript:select_tab('1');">基本信息</a></li>
			<li id="li_2"><a href="javascript:select_tab('2');">发货记录</a></li>
			<li id="li_3"><a href="javascript:select_tab('3');">淘宝订单号</a></li>
		</ul>
	</header>

	<div class="module_content" id="tab-1">
		<fieldset>
			<table class="tablesorter clear">
				<colgroup>
					<col width="550px" />
					<col width="100px" />
					<col width="100px" />
					<col />
				</colgroup>

				<thead>
					<tr>
						<th>商品名称</th>
						<th>商品价格</th>
						<th>商品数量</th>
						<th>小计</th>
					</tr>
				</thead>

				<tbody>
					<?php $goodsSum = 0;$orderWeight = 0?>
					<?php $query = new IQuery("order_goods as og");$query->join = "left join goods as go on go.id = og.goods_id";$query->where = "order_id = $order_id and go.seller_id = $seller_id";$query->fields = "og.*";$items = $query->find(); foreach($items as $key => $item){?>
					<?php $goodsSum    += $item['goods_price'] * $item['goods_nums']?>
					<?php $orderWeight += $item['goods_weight']* $item['goods_nums']?>
					<tr>
						<td>
							<?php $goodsRow = JSON::decode($item['goods_array'])?>
							<?php echo isset($goodsRow['name'])?$goodsRow['name']:"";?> &nbsp;&nbsp; <?php echo isset($goodsRow['value'])?$goodsRow['value']:"";?>
						</td>
						<td><?php echo isset($item['goods_price'])?$item['goods_price']:"";?></td>
						<td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>
						<td><?php echo $item['goods_price']*$item['goods_nums'];?></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</fieldset>

		<fieldset>
			<?php $orderCount = CountSum::countOrderFee($goodsSum,$goodsSum,$orderWeight,$province,$distribution,0,false,$if_insured,$invoice)?>

			<table class="tablesorter clear">
				<colgroup>
					<col width="120px" />
					<col />
				</colgroup>

				<thead>
					<tr><th colspan="2">订单金额明细</th></tr>
				</thead>

				<tbody>
					<tr>
						<th>商品总额:</th><td>￥<?php echo isset($goodsSum)?$goodsSum:"";?></td>
					</tr>
					<tr>
						<th>配送费用:</th><td>￥<?php echo isset($orderCount['deliveryPrice'])?$orderCount['deliveryPrice']:"";?></td>
					</tr>
					<tr>
						<th>保价费用:</th><td>￥<?php echo isset($orderCount['insuredPrice'])?$orderCount['insuredPrice']:"";?></td>
					</tr>
					<tr>
						<th>税金:</th><td>￥<?php echo isset($orderCount['taxPrice'])?$orderCount['taxPrice']:"";?></td>
					</tr>
					<tr>
						<th>订单总额:</th><td>￥<?php echo isset($orderCount['orderAmountPrice'])?$orderCount['orderAmountPrice']:"";?></td>
					</tr>
				</tbody>
			</table>
		</fieldset>

		<fieldset>
			<table class="tablesorter clear">
				<colgroup>
					<col width="120px" />
					<col />
				</colgroup>

				<thead>
					<tr><th colspan="2">订单其他信息</th></tr>
				</thead>

				<tbody>
					<tr>
						<th>配送方式:</th><td><?php echo isset($delivery)?$delivery:"";?></td>
					</tr>
					<tr>
						<th>配送保价:</th><td><?php if($if_insured==0){?>不保价<?php }else{?>保价<?php }?></td>
					</tr>
					<tr>
						<th>商品重量:</th><td><?php echo isset($orderWeight)?$orderWeight:"";?> g</td>
					</tr>
					<tr>
						<th>支付方式:</th><td><?php echo isset($payment)?$payment:"";?></td>
					</tr>
					<tr>
						<th>是否开票:</th><td><?php if($invoice==0){?>否<?php }else{?>是<?php }?></td>
					</tr>
					<tr>
						<th>发票抬头:</th><td><?php echo isset($invoice_title)?$invoice_title:"";?></td>
					</tr>
				</tbody>
			</table>
		</fieldset>

		<fieldset>
			<table class="tablesorter clear">
				<colgroup>
					<col width="120px" />
					<col />
				</colgroup>

				<thead>
					<tr><th colspan="2">收货人信息</th></tr>
				</thead>

				<tbody>
					<tr>
						<th>发货日期:</th><td><?php echo isset($send_time)?$send_time:"";?></td>
					</tr>
					<tr>
						<th>姓名:</th><td><?php echo isset($accept_name)?$accept_name:"";?></td>
					</tr>
					<tr>
						<th>电话:</th><td><?php echo isset($telphone)?$telphone:"";?></td>
					</tr>
					<tr>
						<th>手机 :</th><td><?php echo isset($mobile)?$mobile:"";?></td>
					</tr>
					<tr>
						<th>地区:</th><td><?php echo isset($area_addr)?$area_addr:"";?></td>
					</tr>
					<tr>
						<th>地址:</th><td><?php echo isset($address)?$address:"";?></td>
					</tr>
					<tr>
						<th>邮编:</th><td><?php echo isset($postcode)?$postcode:"";?></td>
					</tr>
					<tr>
						<th>送货时间:</th><td><?php echo isset($accept_time)?$accept_time:"";?></td>
					</tr>
				</tbody>
			</table>
		</fieldset>
	</div>

	<div class="module_content" id="tab-2">
		<fieldset>
			<table class="tablesorter clear">
				<colgroup>
					<col width="200px" />
					<col />
				</colgroup>

				<thead>
					<tr><th colspan="2">发货单据列表</th></tr>
				</thead>

				<tbody>
					<?php $query = new IQuery("delivery_doc as c");$query->join = "left join delivery as p on c.delivery_type = p.id";$query->fields = "c.*,p.name as pname";$query->where = "c.order_id = $order_id and c.seller_id = $seller_id";$deliveryData = $query->find(); foreach($deliveryData as $key => $item){?><?php }?>
					<?php if($deliveryData){?>
					<tr><th>配送时间：</th><td><?php echo isset($item['time'])?$item['time']:"";?></td></tr>
					<tr><th>配送方式：</th><td><?php echo isset($item['pname'])?$item['pname']:"";?></td></tr>
					<tr><th>物流单号：</th><td><?php echo isset($item['delivery_code'])?$item['delivery_code']:"";?></td></tr>
					<tr><th>收件人：</th><td><?php echo isset($item['name'])?$item['name']:"";?></td></tr>
					<tr><th>备注：</th><td><?php echo isset($item['note'])?$item['note']:"";?></td></tr>
					<?php }else{?>
					<tr><td colspan="2">暂无数据</td></tr>
					<?php }?>
				</tbody>
			</table>
		</fieldset>
	</div>

	<div class="module_content" id="tab-3">
		<fieldset>
			<label>淘宝订单号</label>
			<div class="box">
				<?php echo isset($postscript)?$postscript:"";?>
			</div>
		</fieldset>
	</div>
</article>

<script type='text/javascript'>

var pay_status = '<?php echo isset($pay_status)?$pay_status:"";?>';

//DOM加载完毕后运行
$(function()
{
	select_tab(1);
});

//选择当前Tab
function select_tab(curr_tab)
{
	$("div.module_content").hide();
	$("#tab-"+curr_tab).show();
	$("ul[name=menu1] > li").removeClass('active');
	$('#li_'+curr_tab).addClass('active');
}
</script>

	</section>
	<!--主题内容 结束-->
</body>
</html>