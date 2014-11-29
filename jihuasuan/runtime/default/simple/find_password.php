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
	    <div class="wrapper clearfix">
	<div class="wrap_box">

		<div id="fp_form">
			<h3 class="notice">忘记密码</h3>
			<p class="tips">欢迎来到我们的网站，如果忘记密码，请填写下面表单来重新获取密码</p>
			<div class="box">
			<form>
				<table class="form_table">
					<col width="300px" />
					<col />
					<tr><th>用户名：</th><td><input id="username" class="gray" type="text" pattern="required" alt="请输入正确的用户名" /></td></tr>
					<tr><th>邮箱：</th><td><input id="useremail" class="gray" type="text" pattern="email" alt="请输入正确的邮件地址" /></td></tr>
					<tr><th>验证码：</th><td><input id="captcha" class="gray_s" type="text" pattern='^\w{5,10}$' /><br /><img src='<?php echo IUrl::creatUrl("/simple/getCaptcha");?>' id='captchaImg' /><span class="light_gray">看不清？<a class="link" href="javascript:changeCaptcha('<?php echo IUrl::creatUrl("/simple/getCaptcha");?>');">换一张</a></span></td></tr>
					<tr><td></td><td><input class="submit" type="button" value="找回密码" onclick="submit_passwordfind(this);" /></td></tr>
				</table>
			</form>
			</div>
		</div>

		<div id="fp_success" style="display:none;">
			<h3 class="notice">找回密码</h3>
			<div class="box clearfix">
				<table class="form_table prompt_3 f_l">
					<col width="250px" />
					<col />
					<tr>
						<th valign="top"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/right.gif";?>" width="48" height="51" alt="" /></th>
						<td>
							<p class="mt_10"><strong class="f14">恭喜，请去邮箱查收邮件！</strong></p>
							<p class="mt_10">修改密码的地址已经发送到您的邮箱，请注意查收！</p>
							<p>您现在可以去：<a class="blue" href="<?php echo IUrl::creatUrl("");?>">商城首页</a><a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/index");?>">用户中心</a></p>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>

<script language="javascript">
$().ready(
	function(){$(".form_table input:text").focus(function(){$(this).addClass('current');}).blur(function(){$(this).removeClass('current');}) ;}
);

function submit_passwordfind(obj)
{
	obj.disabled = true;
	var username=$("#username").val();
	var useremail=$("#useremail").val();
	var captcha=$("#captcha").val();
	if(username=="" || useremail=="" || captcha=="")
	{
		alert('请填写信息');
		obj.disabled = false;
		return;
	}

	$.get("<?php echo IUrl::creatUrl("/simple/do_find_password/");?>",{'username':username,'useremail':useremail,"captcha":captcha},function(c){
		if(c=='success')
		{
			$("#fp_form").hide();
			$("#fp_success").show('fast');
		}
		else
		{
			alert(c);
			obj.disabled = false;
		}
	});
}
</script>

		<?php echo IFilter::stripSlash($siteConfig->site_footer_code);?>
	</div>
</body>
</html>
