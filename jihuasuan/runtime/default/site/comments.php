<?php 
	$myCartObj  = new Cart();
	$myCartInfo = $myCartObj->getMyCart();
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
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/iwebshop/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/iwebshop/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/site.js";?>'></script>
	<?php $sonline = new Sonline();$sonline->show($siteConfig->phone,$siteConfig->service_online);?>
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

<div class="container">
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
	<?php
		if(isset($_GET['action'])){
			if(!$_GET || $_GET['action'] == 'index'){
				$_GET['cat'] = 0;
			}
			if($_GET['action'] == 'products' || ($_GET['controller'] == 'site' && $_GET['action'] != 'pro_list')){
				$_GET['cat'] = 0;
			}
		}else{
			$_GET['cat'] = 0;
		}
	?>
	<div class="navbar">
		<ul>
			<li><a href="<?php echo IUrl::creatUrl("/site/index");?>"  <?php if(!$_GET['cat']){?>class='current' style='color:#FF3366;'<?php }?>>首页</a></li>
			<?php $query = new IQuery("guide");$items = $query->find(); foreach($items as $key => $item){?>
			<li><a href="<?php echo IUrl::creatUrl("$item[link]");?>" <?php if($_GET['cat'] == $item['order']+1){?>class='current' style='color:#FF3366;'<?php }?>><?php echo isset($item['name'])?$item['name']:"";?><span></span></a></li>
			<?php }?>
		</ul>
		
	</div>

	<div class="searchbar">
		
	</div>
	
	<?php echo Ad::show(1);?>

	<?php $average_point=$this->comment_info['average_point'];?>
<?php $goods_id=$this->comment['goods_id'];?>
<?php $id=intval(IReq::get('id'));?>
<?php $query = new IQuery("goods");$query->where = "id = $goods_id";$query->limit = "1";$items = $query->find(); foreach($items as $key => $item){?><?php }?>

<div class="position"> <span>您当前的位置：</span> <a href="<?php echo IUrl::creatUrl("");?>"> 首页</a> » <a href="<?php echo IUrl::creatUrl("/site/products/id/$goods_id");?>"><?php echo isset($item['name'])?$item['name']:"";?></a> </div>
<div class="clearfix">
	

	<div class="wrapper main f_r">
		<div class="wrap_box">
			<?php if($this->can_submit===true){?>
			<form method="post">
			<table class="form_table f_l">
				<caption><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/comments.gif";?>" width="88" height="23" alt="我要评论" /></caption>
				<col width="120px" />
				<col />
				<tr>
					<th>评论等级：</th>
					<td>
						<label><input name="point" class="radio" type="radio" value="5" checked="checked" /><span class="grade"><i style="width:<?php echo Common::gradeWidth(5);?>px"></i></span></label>
						<label><input name="point" class="radio" type="radio" value="4" /><span class="grade"><i style="width:<?php echo Common::gradeWidth(4);?>px"></i></span></label>
						<label><input name="point" class="radio" type="radio" value="3" /><span class="grade"><i style="width:<?php echo Common::gradeWidth(3);?>px"></i></span></label>
						<label><input name="point" class="radio" type="radio" value="2" /><span class="grade"><i style="width:<?php echo Common::gradeWidth(2);?>px"></i></span></label>
						<label><input name="point" class="radio" type="radio" value="1" /><span class="grade"><i style="width:<?php echo Common::gradeWidth(1);?>px"></i></span></label>
					</td>
				</tr>
				<tr>
					<th>评论内容：</th><td valign="top"><textarea name="contents" id="contents"></textarea></td>
				</tr>
				<tr><td></td><td><label class="btn"><input type="button" onclick="comment_add();" value="我要评价" /></label></td></tr>
			</table>
			</form>
			<?php }else{?>
			<table class="form_table prompt_3 f_l">
				<caption><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/comments.gif";?>" width="88" height="23" alt="我要评论" /></caption>
				<col width="250px" />
				<col />
				<tr>
					<th valign="top"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/error.gif";?>" width="46" height="65" alt="" /></th>
					<td>
						<p class="mt_10"><strong class="f14 red2">您暂不能对该商品进行评价，可能有以下原因：</strong></p>
						<p class="mt_10">1.您可能没有在<?php echo $siteConfig->name;?>购买过该商品；</p>
						<p>2.您已经评价过该商品。</p>
					</td>
				</tr>
			</table>
			<?php }?>
		</div>
	</div>
</div>

<script language="javascript">
function comment_add()
{
	var point=$("input[name='point']:checked").val();
	if(point==0)
	{
		alert("请选择评论等级");
		return;
	}

	var contents=$("#contents").val();
	var data={'point':point,'contents':contents,'id':<?php echo isset($id)?$id:"";?>};
	$.post("<?php echo IUrl::creatUrl("/site/comment_add/id/$id");?>",data,function(c)
	{
		if(c==='success')
		{
			location="<?php echo IUrl::creatUrl("/site/comments_list/id/$goods_id");?>";
		}
		else
			alert(c);
	});
}
</script>


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

<!--选择货品添加购物车模板 开始-->
<script type='text/html' id='selectProductTemplate'>
<table width="100%">
	<col />
	<col width="80px" />
	<col width="60px" />
	<%for(var item in productData){%>
	<%item = productData[item]%>
	<tr>
		<td align="left">
			<%for(var spectName in item['specData']){%>
			<%var spectValue = item['specData'][spectName]%>
				<%=spectName%>：<%==spectValue%> &nbsp&nbsp
			<%}%>
		</td>
		<td align="center"><span class="bold red2">￥<%=item['sell_price']%></span></td>
		<td align="right"><label class="btn_gray_s"><input type="button" onclick="joinCart_ajax('<%=item['id']%>','product');" value="购买"></label></td>
	</tr>
	<%}%>
	<tr>
		<td colspan='3' align="left"><a href="<?php echo IUrl::creatUrl("/site/products/id/<%=item['goods_id']%>");?>">查看更多</a></td>
	</tr>
</table>
</script>
<!--选择货品添加购物车模板 结束-->

<script type='text/javascript'>
$(function()
{
	<?php $word = IReq::get('word') ? IFilter::act(IReq::get('word'),'text') : '输入关键字...'?>
	$('input:text[name="word"]').val("<?php echo isset($word)?$word:"";?>");

	$('input:text[name="word"]').bind({
		keyup:function(){autoComplete('<?php echo IUrl::creatUrl("/site/autoComplete");?>','<?php echo IUrl::creatUrl("/site/search_list/word/@word@");?>','<?php echo isset($siteConfig->auto_finish)?$siteConfig->auto_finish:"";?>');}
	});

	var mycartLateCall = new lateCall(200,function(){showCart('<?php echo IUrl::creatUrl("/simple/showCart");?>')});

	//购物车div层
	$('.mycart').hover(
		function(){
			mycartLateCall.start();
		},
		function(){
			mycartLateCall.stop();
			$('#div_mycart').hide('slow');
		}
	);
});

//[ajax]加入购物车
function joinCart_ajax(id,type)
{
	$.getJSON("<?php echo IUrl::creatUrl("/simple/joinCart");?>",{"goods_id":id,"type":type,"random":Math.random()},function(content){
		if(content.isError == false)
		{
			var count = parseInt($('[name="mycart_count"]').html()) + 1;
			$('[name="mycart_count"]').html(count);
			$('.msgbox').hide();
			alert(content.message);
		}
		else
		{
			alert(content.message);
		}
	});
}

//列表页加入购物车统一接口
function joinCart_list(id)
{
	$.getJSON('<?php echo IUrl::creatUrl("/simple/getProducts");?>',{"id":id},function(content){
		if(!content)
		{
			joinCart_ajax(id,'goods');
		}
		else
		{
			var selectProductTemplate = template.render('selectProductTemplate',{'productData':content});
			$('#product_box_'+id).html(selectProductTemplate);
			$('#product_box_'+id).parent().show();
		}
	});
}
</script>
</body>
</html>
