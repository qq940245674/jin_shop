<?php 
	$siteConfig = new Config("site_config");
	$callback   = IReq::get('callback') ? urlencode(IFilter::act(IReq::get('callback'),'url')) : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $siteConfig->name;?></title>
	<link type="image/x-icon" href="favicon.ico" rel="icon">
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/index.css";?>" />
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/iwebshop/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/iwebshop/runtime/_systemjs/artdialog/skins/default.css" />
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/site.js";?>'></script>
</head>
<body class="second">
	<div class="brand_list container_2">
		<div class="header">
			<h1 class="logo"><a title="<?php echo $siteConfig->name;?>" style="background:url(<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/logo.gif";?>);" href="<?php echo IUrl::creatUrl("");?>"><?php echo $siteConfig->name;?></a></h1>
			<ul class="shortcut">
				<li class="first"><a href="<?php echo IUrl::creatUrl("/ucenter/index");?>">我的账户</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/ucenter/order");?>">我的订单</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/simple/seller");?>">申请开店</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/seller/seller");?>">商家管理</a></li>
		   		<li class='last'><a href="<?php echo IUrl::creatUrl("/site/help_list");?>">使用帮助</a></li>
			</ul>
			<p class="loginfo">
			<?php if($this->user){?>
			<span style='color:#FF4254;'><?php echo isset($this->user['username'])?$this->user['username']:"";?></span> 您好，欢迎您来到<?php echo $siteConfig->name;?>购物！[<a href="<?php echo IUrl::creatUrl("/simple/logout");?>" class="reg">安全退出</a>]
			<?php }else{?>
			[<a href="<?php echo IUrl::creatUrl("/simple/login?callback=$callback");?>">登录</a><a class="reg" href="<?php echo IUrl::creatUrl("/simple/reg?callback=$callback");?>">免费注册</a>]
			<?php }?>
			</p>
		</div>
	    <script type='text/javascript'>
jQuery(function(){
	//查看订单详情按钮
	$('#order_a').click(function()
	{
		$(this).toggleClass('fold');
		$(this).toggleClass('unfold');
		$('#order_detail').toggle('slow');
	});
});
</script>

<div class="wrapper clearfix">
	<div class="position mt_10"><span>您当前的位置：</span> <a href="<?php echo IUrl::creatUrl("");?>"> 首页</a> » 成功提交订单</div>
	<div class="myshopping m_10">
		<ul class="order_step">
			<li><span class="first">1、查看购物车</span></li>
			<li class="current_prev"><span>2、填写核对订单信息</span></li>
			<li class="last_current"><span>3、成功提交订单</span></li>
		</ul>
	</div>

	<div class="cart_box m_10">
		<div class="title">成功提交订单</div>
		<div class="cont">
			<?php if($this->user['user_id']){?>
			<?php $tmpId=$this->order_id;?>
			<p class="order_stats">
				<a href="<?php echo IUrl::creatUrl("/ucenter/order_detail/id/$tmpId");?>" class="f_r blue">查看订单状态</a>
				<img width="48px" height="51px" alt="" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/right.gif";?>"><strong class="f14">订单已提交</strong>
			</p>
			<?php }?>

			<div class="stats_box">
				<h3>订单信息</h3>
				<table width="100%" class="form_table t_l orange">
					<col width="75px" />
					<col />

					<tbody>
						<tr><th>订单编号：</th><td class="f18 bold red2"><?php echo isset($this->order_num)?$this->order_num:"";?></td></tr>
						<tr><th>订单金额：</th><td class="f18 bold red2">￥<b><?php echo isset($this->final_sum)?$this->final_sum:"";?></b></td></tr>
						<tr><th>淘宝单号：</th><td class="f18 bold red2"><?php echo isset($this->postscript)?$this->postscript:"";?></td></tr>
						<tr><th>支付方式：</th><td class="f18 bold red2">淘宝支付</td></tr>
						<tr><th>配送方式：</th><td class="f18 bold red2"><?php echo isset($this->delivery)?$this->delivery:"";?></td></tr>
					</tbody>
				</table>

				<a class="fold" href="javascript:void(0)" id='order_a'>[查看订单详细信息]</a>

				<div class="blue_box gray m_10" id='order_detail' style='display:none'>
					<table class="form_table t_l">
						<col width="80px" />
						<col />

						<tbody>
							<tr><td class="t_r">收货人名：</td><td><?php echo isset($accept_name)?$accept_name:"";?></td></tr>
							<tr><td class="t_r">联系方式：</td><td><?php echo isset($mobile)?$mobile:"";?></td></tr>
							<tr><td class="t_r">收货时间：</td><td><?php echo isset($accept_time)?$accept_time:"";?></td></tr>
						</tbody>
					</table>
				</div>

				<!--不是货到付款并且支付方式为线上支付-->
				<?php if($this->deliveryType == 0 && $this->paymentType == 1){?>
				<?php $tmpId=$this->order_id;?>
				<!-- <form action='<?php echo IUrl::creatUrl("/block/doPay/order_id/$tmpId");?>' method='post' target='_blank'>
					<input class="submit_pay" type="submit" value="立即支付" onclick="return dopay();" />
				</form> -->
				<?php }?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
function dopay()
{
	confirm('支付是否成功',"window.location.href='<?php echo IUrl::creatUrl("/ucenter/order_detail/id/$tmpId");?>';");
}
</script>
		<?php echo IFilter::stripSlash($siteConfig->site_footer_code);?>
	</div>
</body>
</html>
