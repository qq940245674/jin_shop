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
		<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/artTemplate/area_select.js";?>'></script>

<article class="module width_full">
	<header>
		<h3>编辑商户</h3>
	</header>

	<form action="<?php echo IUrl::creatUrl("/seller/seller_add");?>" method="post" name="sellerForm" enctype='multipart/form-data'>
		<div class="module_content">
			<fieldset>
				<label>登陆用户名：</label>
				<input name="seller_name" type="text" value="" pattern="required" alt="用户名不能为空" disabled="disabled" />
				<label class="tip">* 用户名称（必填）</label>
			</fieldset>

			<fieldset>
				<label>密码：</label>
				<input name="password" type="password" bind='repassword' empty />
				<label class="tip">* 登录密码</label>
			</fieldset>

			<fieldset>
				<label>确认密码：</label>
				<input name="repassword" type="password" bind='password' empty  />
				<label class="tip">* 重复确认密码</label>
			</fieldset>

			<fieldset>
				<label>商户真实全称：</label>
				<input name="true_name" type="text" value="" pattern="required" disabled="disabled" />
			</fieldset>

			<fieldset>
				<label>商户资质材料：</label>
				<div class="box">
					<?php if(isset($this->sellerRow['paper_img']) && $this->sellerRow['paper_img']){?>
					<p><a target="_blank" href="<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->sellerRow['paper_img'])?$this->sellerRow['paper_img']:"";?>"><img src='<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->sellerRow['paper_img'])?$this->sellerRow['paper_img']:"";?>' style='width:320px;border:1px solid #ccc' /></a></p>
					<?php }else{?>
					暂无商户资质材料
					<?php }?>
				</div>
			</fieldset>

			<fieldset>
				<label>保证金数额：</label>
				<input type="text" name="cash" pattern="float" empty disabled="disabled" />
				<label class="tip">人民币（元）</label>
			</fieldset>

			<fieldset>
				<label>收款账号：</label>
				<textarea class="normal" name="account" empty></textarea>
				<label class="tip">标明开户行，卡号，账户名称等</label>
			</fieldset>

			<fieldset>
				<label>固定电话：</label>
				<input type="text" name="phone" pattern="phone" />
			</fieldset>

			<fieldset>
				<label>手机号码：</label>
				<input type="text" name="mobile" pattern="mobi" />
			</fieldset>

			<fieldset>
				<label>邮箱：</label>
				<input type="text" name="email" pattern="email" empty />
			</fieldset>

			<fieldset>
				<label>地区：</label>
				<div class="box">
					<select name="province" child="city,area" onchange="areaChangeCallback(this);" class="auto"></select>
					<select name="city" child="area" parent="province" onchange="areaChangeCallback(this);" class="auto"></select>
					<select name="area" parent="city" class="auto"></select>
				</div>
			</fieldset>

			<fieldset>
				<label>详细地址：</label>
				<input name="address" type="text" empty value="" />
			</fieldset>

			<fieldset>
				<label>客服QQ号码：</label>
				<input name="server_num" type="text" empty value="" />
			</fieldset>

			<fieldset>
				<label>企业官网：</label>
				<input name="home_url" type="text" pattern="url" empty value="" />
				<label class="tip">官网的URL网址，如：http://www.aircheng.com</label>
			</fieldset>
		</div>

		<footer>
			<div class="submit_link">
				<input type="submit" class="alt_btn" value="确 定" />
				<input type="reset" value="重 置" />
			</div>
		</footer>
	</form>
</article>

<script language="javascript">
//DOM加载完毕
$(function(){
	//初始化地域联动
	template.compile("areaTemplate",areaTemplate);

	//修改模式
	<?php if(isset($this->sellerRow)){?>
		var formObj = new Form('sellerForm');
		formObj.init(<?php echo JSON::encode($this->sellerRow);?>);

		//城市设置
		<?php if(isset($this->sellerRow['area'])){?>
			createAreaSelect('province',0,"<?php echo isset($this->sellerRow['province'])?$this->sellerRow['province']:"";?>");
			createAreaSelect('city',"<?php echo isset($this->sellerRow['province'])?$this->sellerRow['province']:"";?>","<?php echo isset($this->sellerRow['city'])?$this->sellerRow['city']:"";?>");
			createAreaSelect('area',"<?php echo isset($this->sellerRow['city'])?$this->sellerRow['city']:"";?>","<?php echo isset($this->sellerRow['area'])?$this->sellerRow['area']:"";?>");
		<?php }else{?>
			createAreaSelect('province',0,"");
		<?php }?>
	<?php }else{?>
		createAreaSelect('province',0,'');
	<?php }?>
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
</script>

	</section>
	<!--主题内容 结束-->
</body>
</html>