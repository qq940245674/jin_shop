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
			<h1 class="site_title"><a href="<?php echo IUrl::creatUrl("/seller/index");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/main/logo.png";?>" /></a></h1>
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
			<p><strong>Copyright &copy; 2014 iWebShop</strong></p>
			<p>Powered by <a href="http://www.aircheng.com">iWebShop</a></p>
		</footer>
	</aside>
	<!--侧边栏菜单 结束-->

	<!--主体内容 开始-->
	<section id="main" class="column">
		<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/artTemplate/area_select.js";?>'></script>

<article class="module width_full">
	<header>
		<h3 class="tabs_involved">订单发货</h3>
	</header>

	<form action="<?php echo IUrl::creatUrl("/seller/order_delivery_doc");?>" method="post" id="deliver_form">
		<input type="hidden" name="order_no" value="<?php echo isset($order_no)?$order_no:"";?>"/>
		<input type="hidden" name="id" value="<?php echo isset($order_id)?$order_id:"";?>"/>
		<input type="hidden" name="weight_total" id="weight_total" value="<?php echo isset($goods_weight)?$goods_weight:"";?>"/>
		<input type="hidden" name="user_id" value="<?php echo isset($user_id)?$user_id:"";?>"/>
		<input type="hidden" name="freight" value="<?php echo isset($real_freight)?$real_freight:"";?>" />

		<fieldset>
			<table class="tablesorter clear">
				<thead>
					<tr>
						<th>商品名称</th>
						<th>商品价格</th>
						<th>返利金额</th>
						<th>购买数量</th>
						<th onclick="selectAll('sendgoods[]')">确认订单</th>
					</tr>
				</thead>

				<tbody>
					<?php $seller_id = $this->seller['seller_id']?>
					<?php $query = new IQuery("order_goods as og");$query->join = "left join goods as go on go.id = og.goods_id";$query->fields = "og.*,go.seller_id";$query->where = "og.order_id = $order_id and go.seller_id = $seller_id";$items = $query->find(); foreach($items as $key => $item){?>
					<tr>
						<td>
							<?php $goodsRow = JSON::decode($item['goods_array'])?>
							<?php echo isset($goodsRow['name'])?$goodsRow['name']:"";?> &nbsp;&nbsp; <?php echo isset($goodsRow['value'])?$goodsRow['value']:"";?>
						</td>	
						<td><?php echo isset($item['real_price'])?$item['real_price']:"";?></td>
						<td style='color:#FF3366;'><?php echo isset($fan_money)?$fan_money:"";?></td>
						<td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>
						<td>
							<?php if($item['is_send'] == 1){?>
							<input type="checkbox" checked="checked" disabled="disabled" title="商品已经发货" />
							<?php }else{?>
							<input type="checkbox" name="sendgoods[]" value="<?php echo isset($item['id'])?$item['id']:"";?>" />
							<?php }?>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</fieldset>

		<fieldset>
			<table class="tablesorter clear">
				<colgroup>
					<col width="120px" />
					<col />
					<col width="120px" />
					<col />
				</colgroup>

				<tbody>
					<tr>
						<th>订单号:</th><td align="left"><?php echo isset($order_no)?$order_no:"";?></td>
						<th>下单时间:</th><td align="left"><?php echo isset($create_time)?$create_time:"";?></td>
					</tr>
					<tr>
						<th>配送方式:</th>
						<td align="left">
							<select name="delivery_type" pattern="required" alt="请选择配送方式" class="auto" disabled="disabled">
							<?php $query = new IQuery("delivery");$query->where = "is_delete = 0";$items = $query->find(); foreach($items as $key => $item){?>
							<option value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($distribution==$item['id']){?>selected<?php }?>><?php echo isset($item['name'])?$item['name']:"";?></option>
							<?php }?>
							</select>
						</td>
						<th>配送费用:</th><td align="left"><?php echo isset($real_freight)?$real_freight:"";?></td>
					</tr>
					<tr>
						<th>是否保价:</th><td align="left"><?php if($if_insured==0){?>否<?php }else{?>是<?php }?></td><th>保价费用:</th><td align="left">￥<?php echo isset($insured)?$insured:"";?></td>
					</tr>
					<tr>
						<th>收货人姓名:</th><td align="left"><input type="text" class="small" name="name" value="<?php echo isset($accept_name)?$accept_name:"";?>" pattern="required"/></td>
						<th>电话:</th><td align="left"><input type="text" class="small" name="telphone" value="<?php echo isset($telphone)?$telphone:"";?>" pattern="phone" empty /></td>
					</tr>
					<tr>
						<th>手机:</th><td align="left"><input type="text" class="small" name="mobile" value="<?php echo isset($mobile)?$mobile:"";?>" pattern="mobi"/></td>
						<th>邮政编码:</th><td align="left"><input type="text" name="postcode" class="small" value="<?php echo isset($postcode)?$postcode:"";?>" pattern="zip" empty /></td>
					</tr>
					<tr>
						<th>物流公司：</th>
						<td align="left">
							<select name="freight_id" pattern="required">
								<?php $query = new IQuery("freight_company");$query->where = "is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>
								<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['freight_name'])?$item['freight_name']:"";?></option>
								<?php }?>
							</select>
						</td>
						<th>配送单号:</th><td align="left"><input type="text" class="normal" name="delivery_code" pattern="required"/></td>
					</tr>
					<tr>
						<th>地区:</th>
						<td align="left" colspan="3">
							<select name="province" child="city,area" onchange="areaChangeCallback(this);" class="auto"></select>
							<select name="city" child="area" parent="province" onchange="areaChangeCallback(this);" class="auto"></select>
							<select name="area" parent="city" pattern="required" class="auto"></select>
						</td>
					</tr>
					<tr>
						<th>地址:</th><td align="left" colspan="3"><input type="text" class="normal" name="address" value="<?php echo isset($address)?$address:"";?>" size="50" pattern="required"/></td>
					</tr>
					<tr>
						<th>确认此笔交易备注:</th><td align="left" colspan="3"><textarea name="note" class="normal"></textarea></td>
					</tr>
				</tbody>
			</table>
		</fieldset>

		<footer>
			<div class="submit_link">
				<input type="submit" class="alt_btn" value="确 定" onclick="return checkForm()" />
				<input type="reset" value="重 置" />
			</div>
		</footer>
	</form>
</article>

<script type="text/javascript">
//DOM加载完毕
$(function(){
	//初始化地域联动
	template.compile("areaTemplate",areaTemplate);

	createAreaSelect('province',0,<?php echo isset($province)?$province:"";?>);
	createAreaSelect('city',<?php echo isset($province)?$province:"";?>,<?php echo isset($city)?$city:"";?>);
	createAreaSelect('area',<?php echo isset($city)?$city:"";?>,<?php echo isset($area)?$area:"";?>);
});

/**
 * 生成地域js联动下拉框
 * @param name
 * @param parent_id
 * @param select_id
 */
function createAreaSelect(name,parent_id,select_id)
{
	//生成地区
	$.getJSON("<?php echo IUrl::creatUrl("/block/area_child");?>",{"aid":parent_id,"random":Math.random()},function(json)
	{
		$('[name="'+name+'"]').html(template.render('areaTemplate',{"select_id":select_id,"data":json}));
	});
}

//表单提交前检测
function checkForm()
{
	var checkedNum = $('input[name="sendgoods[]"]:checked').length;
	var checkedNum2 = $('input[name="delivery_code"]').val();
	var danhao = checkedNum2.length;
	if(checkedNum == 0)
	{
		alert('请选择要确认的商品');
		return false;
	}
	if(danhao == 0)
	{
		alert('请填写配送快递单号');
		return false;
	}
	if(confirm('您确定要审核通过此笔交易吗?(此操作会扣除账户担保金，将返利金额汇至买家账户)')){
		return true;
	}else{
		return false;
	}
}
</script>
	</section>
	<!--主题内容 结束-->
</body>
</html>