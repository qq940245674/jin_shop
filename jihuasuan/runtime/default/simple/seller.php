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
	    <script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/artTemplate/area_select.js";?>'></script>

<div class="wrapper clearfix">
	<div class="wrap_box">
		<div id="fp_form">
			<h3 class="notice" style='text-align:center;'>申请加盟商户</h3><br>
			<p class="tips">加入我们的电商平台，成为我们的供应商，一起共创美好未来</p>
			<div class="box">
				<form action="<?php echo IUrl::creatUrl("/simple/seller_reg");?>" method="post" enctype='multipart/form-data' name="sellerForm">
					<table class="form_table">
						<colgroup>
							<col width="300px" />
							<col />
						</colgroup>

						<tbody>
							<tr>
								<th>登陆用户名：</th>
								<td><input class="normal" name="seller_name" type="text" value="" pattern="required" alt="用户名不能为空" /><label>* 用户名称（必填）</label></td>
							</tr>
							<tr>
								<th>密码：</th><td><input class="normal" name="password" type="password" bind='repassword' empty /><label>* 登录密码</label></td>
							</tr>
							<tr>
								<th>确认密码：</th><td><input class="normal" name="repassword" type="password" bind='password' empty /><label>* 重复确认密码</label></td>
							</tr>
							<tr>
								<th>商户真实全称：</th>
								<td><input class="normal" name="true_name" type="text" value="" pattern="required" /></td>
							</tr>
							<tr>
								<th>商户资质材料：</th>
								<td>
									<input type='file' name='paper_img' />
									<?php if(isset($this->sellerRow['paper_img']) && $this->sellerRow['paper_img']){?>
									<p><a target="_blank" href="<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->sellerRow['paper_img'])?$this->sellerRow['paper_img']:"";?>"><img src='<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->sellerRow['paper_img'])?$this->sellerRow['paper_img']:"";?>' style='width:320px;border:1px solid #ccc' /></a></p>
									<?php }?>
								</td>
							</tr>
							<tr>
								<th>固定电话：</th>
								<td><input type="text" class="normal" name="phone" pattern="phone" /><label>* 固定电话联系方式，如：010-88888888</label></td>
							</tr>
							<tr>
								<th>手机号码：</th>
								<td><input type="text" class="normal" name="mobile" pattern="mobi" /><label>* 移动电话联系方式：如：13000000000</label></td>
							</tr>
							<tr>
								<th>邮箱：</th>
								<td><input type="text" class="normal" name="email" pattern="email" /><label>* 电子邮箱联系方式：如：aircheng@163.com</label></td>
							</tr>
							<tr>
								<th>地区：</th>
								<td>
									<select name="province" child="city,area" onchange="areaChangeCallback(this);"></select>
									<select name="city" child="area" parent="province" onchange="areaChangeCallback(this);"></select>
									<select name="area" parent="city"></select>
								</td>
							</tr>
							<tr>
								<th>详细地址：</th><td><input class="normal" name="address" type="text" empty value="" /></td>
							</tr>
							
							<tr>
								<td></td>
								<td>
									<input class="submit" type="submit" value="申请加盟" />
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>

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

		<?php echo IFilter::stripSlash($siteConfig->site_footer_code);?>
	</div>
</body>
</html>
