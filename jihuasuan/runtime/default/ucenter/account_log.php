<?php 
	$myCartObj  = new Cart();
	$myCartInfo = $myCartObj->getMyCart();
	$siteConfig = new Config("site_config");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $siteConfig->name;?></title>
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/index.css";?>" />
	<link rel="shortcut icon" href="favicon.ico" />
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/iwebshop/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/iwebshop/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/site.js";?>'></script>
	<script type='text/javascript'>
		//用户中心导航条
		function menu_current()
		{
		    var current = "<?php echo $this->getAction()->getId();?>";
		    if(current == 'consult_old') current='consult';
		    else if(current == 'isevaluation') current ='evaluation';
		    else if(current == 'withdraw') current = 'account_log';
		    var tmpUrl = "<?php echo IUrl::creatUrl("/ucenter/current");?>";
		    tmpUrl = tmpUrl.replace("current",current);
		    $('div.cont ul.list li a[href^="'+tmpUrl+'"]').parent().addClass("current");
		}
	</script>
</head>
<body class="index">
<div class="yizhe_top">
	<div class="loginfo">
		<?php if($this->user){?>
		<span style='color:#FF4254;'><?php echo $this->user['username'];?></span> 您好，欢迎您来到<?php echo $siteConfig->name;?>购物！<a href="<?php echo IUrl::creatUrl("/simple/logout");?>" class="reg">安全退出</a>
		<?php }else{?>
		<ul class='loginfo_ul'>
			<li><a href="<?php echo IUrl::creatUrl("/simple/login?callback=$callback");?>">登录</a></li>
			<li style='width:5px;'>|</li>
			<li><a href="<?php echo IUrl::creatUrl("/simple/reg?callback=$callback");?>" style='margin-left:10px;'>免费注册</a></li>
		</ul>
		<?php }?>
		<ul class="shortcut">
				<li class="first"><a href="<?php echo IUrl::creatUrl("/ucenter/index");?>">我的账户</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/ucenter/order");?>">我的订单</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/simple/seller");?>">申请开店</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/index.php?controller=systemseller&action=index");?>">商家管理</a></li>
				<li class='last'><a href="<?php echo IUrl::creatUrl("/site/help_list");?>">使用帮助</a></li>
		</ul>
	</div>
</div>
<div class="ucenter container">
	<div class="header">
		<h1 class="logo"><a title="<?php echo $siteConfig->name;?>" style="background:url(<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/logo.gif";?>);" href="<?php echo IUrl::creatUrl("");?>"><?php echo $siteConfig->name;?></a></h1>
		<div class="searchbox">
			<form method='get' action='<?php echo IUrl::creatUrl("/");?>'>
				<input type='hidden' name='controller' value='site' />
				<input type='hidden' name='action' value='search_list' />
				<input class="text" type="text" name='word' autocomplete="off" value="输入关键字..." />
				<input class="btn" type="submit" value="Go!" onclick="checkInput('word','输入关键字...');" />
			</form>
			<!--自动完成div 开始-->
			<ul class="auto_list" style='display:none'></ul>
			<!--自动完成div 开始-->
		</div>
	<!-- 	<div class="hotwords">热门搜索：
			<?php $query = new IQuery("keyword");$query->where = "hot = 1";$query->limit = "5";$query->order = "`order` asc";$items = $query->find(); foreach($items as $key => $item){?>
			<?php $tmpWord = urlencode($item['word']);?>
			<a href="<?php echo IUrl::creatUrl("/site/search_list/word/$tmpWord");?>"><?php echo isset($item['word'])?$item['word']:"";?></a>
			<?php }?>
		</div> -->
	</div>
	<div class="navbar">
		<ul>
			<li><a href="<?php echo IUrl::creatUrl("");?>">首页</a></li>
			<?php $query = new IQuery("guide");$items = $query->find(); foreach($items as $key => $item){?>
			<li><a href="<?php echo isset($item['link'])?$item['link']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?><span> </span></a></li>
			<?php }?>
		</ul>
	
	</div>

	

	<div class="position" style='margin-top:3px;'>
		您当前的位置： <a href="<?php echo IUrl::creatUrl("");?>">首页</a> » <a href="<?php echo IUrl::creatUrl("/ucenter/index");?>">我的账户</a>
	</div>
	<div class="wrapper clearfix" style="margin-top:20px;">
		<div class="sidebar f_l">
			<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/ucenter/ucenter.gif";?>" width="180" height="40" />
			<div class="box">
				<div class="title"><h2>交易记录</h2></div>
				<div class="cont">
					<ul class="list">
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/order");?>">我的订单</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/integral");?>">我的积分</a></li>
					
					</ul>
				</div>
			</div>
			<div class="box">
				<div class="title"><h2 class='bg2'>服务中心</h2></div>
				<div class="cont">
					<ul class="list">
						
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/complain");?>">站点建议</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/consult");?>">商品咨询</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/evaluation");?>">商品评价</a></li>
					</ul>
				</div>
			</div>
			<div class="box">
				<div class="title"><h2 class='bg3'>应用</h2></div>
				<div class="cont">
					<ul class="list">
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/message");?>">短信息</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/favorite");?>">收藏夹</a></li>
					</ul>
				</div>
			</div>
			<div class="box">
				<div class="title"><h2 class='bg4'>账户资金</h2></div>
				<div class="cont">
					<ul class="list">
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/account_log");?>">帐户余额</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/online_recharge");?>">在线充值</a></li>
					</ul>
				</div>
			</div>
			<div class="box">
				<div class="title"><h2 class='bg5'>个人设置</h2></div>
				<div class="cont">
					<ul class="list">
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/address");?>">地址管理</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/info");?>">个人资料</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/password");?>">修改密码</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="main f_r" style='width:760px;margin-left:1px;'>

	<div class="uc_title m_10">
		<label class="current"><span><a href='<?php echo IUrl::creatUrl("/ucenter/account_log");?>'>交易记录</a></span></label>
		<label><span><a href='<?php echo IUrl::creatUrl("/ucenter/withdraw");?>'>提现申请</a></span></label>
	</div>

	<div class="prompt m_10">
		<p>账户余额：<b class="orange f14">￥<?php echo isset($this->memberRow['balance'])?$this->memberRow['balance']:"";?></b></p>
	</div>

	<div>
		<table class='list_table m_10' width='100%' cellspacing='0' cellpadding='0'>
			<col />
			<col width="110px" />
			<col width="110px" />
			<col width="110px" />
			<col width="145px" />
			<thead>
				<tr>
					<th>事件</th><th>存入金额</th><th>支出金额</th><th>当前金额</th><th>时间</th>
				</tr>
			</thead>
			<tbody>
				<?php $page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;?>
				<?php $user_id = $this->user['user_id']?>
				<?php $query = new IQuery("account_log");$query->where = "user_id = $user_id";$query->page = "$page";$query->order = "id desc";$items = $query->find(); foreach($items as $key => $item){?>
				<tr>
					<td style="text-align:left;"><?php echo isset($item['note'])?$item['note']:"";?></td>
					<td><?php if(!strpos($item['note'],'减少')){?><?php echo $item['amount'] > 0 ? $item['amount'].'元' : '';?><?php }?></td>
					<td><?php if(strpos($item['note'],'提交')){?>0元<?php }else{?><?php if(strpos($item['note'],'减少')){?><?php echo $item['amount'];?><?php }?><?php echo $item['amount'] < 0 ? $item['amount'].'元' : '';?><?php }?></td>
					<td><span class="red"><?php echo isset($item['amount_log'])?$item['amount_log']:"";?> 元</span></td>
					<td><?php echo isset($item['time'])?$item['time']:"";?></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<?php echo $query->getPageBar();?>
	</div>

</div>

	</div>

	<div class="help m_10">
		<div class="cont clearfix">
			<?php $query = new IQuery("help_category");$query->where = "position_foot = 1";$query->order = "sort ASC,id desc";$query->limit = "5";$items = $query->find(); foreach($items as $key => $helpCat){?>
			<dl>
     			<dt><a href="<?php echo IUrl::creatUrl("/site/help_list/id/$helpCat[id]");?>"><?php echo isset($helpCat['name'])?$helpCat['name']:"";?></a></dt>
     			<?php $query = new IQuery("help");$query->where = "cat_id = $helpCat[id]";$query->order = "sort ASC,id desc";$items = $query->find(); foreach($items as $key => $item){?>
					<dd><a href="<?php echo IUrl::creatUrl("/site/help/id/$item[id]");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></dd>
				<?php }?>
      		</dl>
      		<?php }?>
		</div>
	</div>
	<?php echo IFilter::stripSlash($siteConfig->site_footer_code);?>
</div>
<script type='text/javascript'>
//DOM加载完毕后运行
$(function()
{
	$(".tabs").each(function(i){
	    var parrent = $(this);
		$('.tabs_menu .node',this).each(function(j){
			var current=".node:eq("+j+")";
			$(this).bind('click',function(event){
				$('.tabs_menu .node',parrent).removeClass('current');
				$(this).addClass('current');
				$('.tabs_content>.node',parrent).css('display','none');
				$('.tabs_content>.node:eq('+j+')',parrent).css('display','block');
			});
		});
	});

	//隔行换色
	$(".list_table tr:nth-child(even)").addClass('even');
	$(".list_table tr").hover(
		function () {
			$(this).addClass("sel");
		},
		function () {
			$(this).removeClass("sel");
		}
	);

	menu_current();

	$('input:text[name="word"]').bind({
		keyup:function(){autoComplete('<?php echo IUrl::creatUrl("/site/autoComplete");?>','<?php echo IUrl::creatUrl("/site/search_list/word/@word@");?>','<?php echo isset($siteConfig->auto_finish)?$siteConfig->auto_finish:"";?>');}
	});

	<?php $word = IReq::get('word') ? IFilter::act(IReq::get('word'),'text') : '输入关键字...'?>
	$('input:text[name="word"]').val("<?php echo isset($word)?$word:"";?>");

	//购物车div层
	$('.mycart').hover(
		function(){
			showCart('<?php echo IUrl::creatUrl("/simple/showCart");?>');
		},
		function(){
			$('#div_mycart').hide('slow');
		}
	);
});
</script>
</body>
</html>
