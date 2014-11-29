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
	<script type="text/javascript" charset="UTF-8" src="/jihuasuan/runtime/_systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/jihuasuan/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/jihuasuan/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/jihuasuan/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/jihuasuan/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/jihuasuan/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/jihuasuan/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/jihuasuan/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="/jihuasuan/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/jihuasuan/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/site.js";?>'></script>
	<?php $sonline = new Sonline();$sonline->show($siteConfig->phone,$siteConfig->service_online);?>
</head>
<body class="index">
<div class="yizhe_top">
	<div class="loginfo">
		<?php if($this->user){?>
		<span style='color:#FF4254;margin-left:-45px;'><?php echo $this->user['username'];?></span><span style='color:#666666;margin-left:10px;'> 您好，欢迎您来到<?php echo $siteConfig->name;?>购物！</span>&nbsp;&nbsp;&nbsp;<a href="<?php echo IUrl::creatUrl("/simple/logout");?>" class="reg" style='color:#FC6E7C;'>安全退出</a>
		<?php }else{?>
		<ul class='loginfo_ul'>
			<li><a href="<?php echo IUrl::creatUrl("/simple/login?callback=$callback");?>">登录</a></li>
			<li style='width:5px;'>|</li>
			<li><a href="<?php echo IUrl::creatUrl("/simple/reg?callback=$callback");?>" style='margin-left:10px;'>免费注册</a></li>
		</ul>
		<?php }?>
		<ul class="shortcut">
				<li class="first" style='background:#F5F5F5;'><a href="<?php echo IUrl::creatUrl("/ucenter/index");?>">我的账户</a></li>|
				<li  style='background:#F5F5F5;'><a href="<?php echo IUrl::creatUrl("/ucenter/order");?>">我的订单</a></li>|
				<li  style='background:#F5F5F5;'><a href="<?php echo IUrl::creatUrl("/index.php?controller=systemseller&action=index");?>">商家管理</a></li>|
				<li class='last'  style='background:#F5F5F5;'><a href="<?php echo IUrl::creatUrl("/site/help_list");?>">使用帮助</a></li>|
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
	
	<?php $brandId = IFilter::act(IReq::get('id'),'int')?>
<?php $query = new IQuery("brand");$query->where = "id = $brandId";$items = $query->find(); foreach($items as $key => $brandRow){?><?php }?>

<div class="position"> <span>您当前的位置：</span> <a href="<?php echo IUrl::creatUrl("");?>"> 首页</a> » 商品品牌 </div>
<div class="wrapper clearfix container_2">
	<div class="sidebar f_l">
		

		<div class="box m_10">
			<div class="title">更多品牌</div>
				<div class="cont clearfix" style='clear:both;'>
				<ul style='margin-left:50px;margin-top:10px;'>
					<?php $query = new IQuery("brand");$query->fields = "id,name,logo";$query->order = "sort asc";$query->limit = "20";$items = $query->find(); foreach($items as $key => $item){?>
					<?php $tmpId=$item['id'];?>
					<li style='width:220px;float:left;margin-top:10px;'><a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/$tmpId");?>"><img src="<?php echo IUrl::creatUrl("")."$item[logo]";?>"  width="190" height="90"/></a></li>
					<?php }?>
				</ul>
			</div>
		</div>

	</div>

	<div class="main f_r">
		<div class="box m_10" style="width:998px;">
			<div class="title">品牌专区</div>
			<div class="cont">
				<div class="c_box">
					<dl class="clearfix">
						<dt><img src="<?php echo IUrl::creatUrl("")."$brandRow[logo]";?>" width="220" height="100" /></dt>
						<dd><strong><?php echo isset($brandRow['name'])?$brandRow['name']:"";?></strong></dd>
						<dd>官方站点：<?php echo isset($brandRow['url'])?$brandRow['url']:"";?></dd>
					</dl>
					<p><?php echo isset($brandRow['description'])?$brandRow['description']:"";?></p>
				</div>
			</div>
		</div>

		<div class="display_title">
			<ul>
				<?php foreach(search_goods::getOrderType() as $key => $item){?>
				<?php $next = search_goods::getOrderValue($key)?>
				<li class="<?php echo search_goods::isOrderCurrent($key) ? 'current':'';?>">
					<a href="<?php echo search_goods::searchUrl('order',$next);?>"><?php echo isset($item)?$item:"";?><span class="<?php echo search_goods::isOrderDesc() ? 'desc':'';?>">&nbsp;</span></a>
				</li>
				<?php }?>
			</ul>
			
			<span class="f_l">显示方式：</span>
			<a class="show_b" href="<?php echo search_goods::searchUrl('show_type','win');?>" title='橱窗展示' alt='橱窗展示'><span class='<?php echo search_goods::getListShow(IReq::get('show_type')) == 'win' ? 'current':'';?>'></span></a>
			
		</div>
		<?php $goodsObj = search_goods::find(' go.brand_id = '.$brandId);$resultData = $goodsObj->find();?>
		<?php if($resultData){?>
		<?php $listSize = search_goods::getListSize(IFilter::act(IReq::get('show_type')))?>
		<ul class="display_list clearfix m_10">	
			<?php foreach($resultData as $key => $item){?>
				<?php 
					if($item['fan_money'] != 0){
						$item['zhe'] = number_format(($item['sell_price']-$item['fan_money'])/$item['sell_price'],2)*10;	
					}
				?>
			<li class="clearfix <?php echo search_goods::getListShow(IFilter::act(IReq::get('show_type')));?>">
				<a title="<?php echo isset($item['name'])?$item['name']:"";?>" class="p_name" href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><?php echo isset($item['name'])?$item['name']:"";?></a>
				<div class="pic">
					<a title="<?php echo isset($item['name'])?$item['name']:"";?>" href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><img src="<?php echo IUrl::creatUrl("")."";?><?php echo Thumb::get($item['img'],280,280);?>" width="280" height="280" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
				</div>
				<div class="price"><span>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></span> &nbsp;返利￥<?php echo isset($item['fan_money'])?$item['fan_money']:"";?> <p>销量: <?php echo isset($item['sale'])?$item['sale']:"";?></p><br>
					<p style='float:left;margin-top:10px;margin-left:5px;'>剩余:<?php echo isset($item['store_nums'])?$item['store_nums']:"";?></p>
					<?php if($item['zhe']){?><p style='float:left;margin-top:10px;margin-left:15px;color:#FF4400;font-size:12px;'><?php echo isset($item['zhe'])?$item['zhe']:"";?> 折</p><?php }else{}?>
					<a title="<?php echo isset($item['name'])?$item['name']:"";?>" class='newa' href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>" style='float:right;'>我要抢购</a>
				</div>
			</li>
			<?php }?>
		</ul>
		<?php echo $goodsObj->getPageBar();?>

		<?php }else{?>
		<p class="display_list mt_10" style='margin-top:50px;margin-bottom:50px'>
			<strong class="gray f14">对不起，没有找到相关商品</strong>
		</p>
		<?php }?>
	</div>
</div>

	</div>
	<div class='footcontainer'>
	<div class='footcenter'>
	<div class="help m_10">
		<div class="cont clearfix">
			<?php $query = new IQuery("help_category");$query->where = "position_foot = 1";$query->order = "sort ASC,id desc";$query->limit = "5";$items = $query->find(); foreach($items as $key => $helpCat){?>
			<dl>
     			<dt><a href="<?php echo IUrl::creatUrl("/site/help_list/id/$helpCat[id]");?>"><?php echo isset($helpCat['name'])?$helpCat['name']:"";?></a></dt>
     			<?php $query = new IQuery("help");$query->where = "cat_id = $helpCat[id]";$query->order = "sort ASC,id desc";$items = $query->find(); foreach($items as $key => $item){?>
					<dd>.<a href="<?php echo IUrl::creatUrl("/site/help/id/$item[id]");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></dd>
				<?php }?>
      		</dl>
      		<?php }?>
		</div>
	</div>
	</div>
	</div>
	
	<div class='end'>
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
