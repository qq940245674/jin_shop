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
	
	<?php $seo_data=array(); $site_config=new Config('site_config');?>
<?php $seo_data['title'] = $this->catRow['title']?$this->catRow['title']:$this->catRow['name']?>
<?php $seo_data['title'].="_".$site_config->name?>
<?php $seo_data['keywords']=$this->catRow['keywords']?>
<?php $seo_data['description']=$this->catRow['descript']?>
<?php seo::set($seo_data);?>
<?php $breadGuide = goods_class::catRecursion($this->catId)?>

<div class="position">
	<span>您当前的位置：</span>
	<a href="<?php echo IUrl::creatUrl("");?>">首页</a><?php foreach($breadGuide as $key => $item){?> » <a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/$item[id]");?>"><?php echo isset($item['name'])?$item['name']:"";?></a><?php }?>
</div>

<div class="wrapper clearfix container_2" style='width:998px;'>

	<div class="sidebar f_l">
	</div>

	<div class="main f_r" style='width:998px;margin-top:5px;'>
		<!--推荐商品-->
	  	<?php $query = new IQuery("category_extend as ca");$query->join = "left join goods as go on ca.goods_id = go.id left join commend_goods as co on co.goods_id = go.id";$query->where = "ca.category_id in ($this->childId) and co.commend_id = 4 and go.is_del = 0";$query->limit = "9";$query->order = "go.sort asc,go.id desc";$query->fields = "DISTINCT go.img,go.sell_price,go.name,go.id,go.market_price,go.description";$pro_list = $query->find();?>
	  	<?php if($pro_list){?>
		<div class="brown_box m_10 clearfix">
			<p class="caption"><span>推荐</span></p>

			<ul class="prolist">
				<?php foreach($pro_list as $key => $item){?>
				<li>
					<a class="pic" href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><img src="<?php echo IUrl::creatUrl("")."";?><?php echo isset($item['img'])?$item['img']:"";?>" alt="<?php echo isset($item['name'])?$item['name']:"";?>" height="85px" width="85px"></a>
					<p class="pro_title"><a href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></p>
					<p><b style='color:#F84476;'>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b> <s>￥<?php echo isset($item['market_price'])?$item['market_price']:"";?></s></p>
				</li>
				<?php }?>
			</ul>
		</div>
		<?php }?>
		<!--推荐商品-->

		<!--顶级栏目-->
		<div class='newfenlei'>
			<ul>
			<?php $c = 0; ?>
				<?php $query = new IQuery("category");$query->where = "parent_id = 0";$query->order = "sort asc";$items = $query->find(); foreach($items as $key => $second){?>
							<li class="newcategory<?php echo isset($c)?$c:"";?>">
								<a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/$second[id]");?>"><?php echo isset($second['name'])?$second['name']:"";?></a>
							</li>
				<?php $c++; ?>
				<?php }?>
			</ul>
		</div>
		<!--顶级栏目-->
			
		<div class="box m_10" style='border-top:none;'>
			<div class="cont">
				<!--品牌展示-->
				<?php $query = new IQuery("category_extend as ca");$query->join = "left join goods as go on ca.goods_id = go.id left join brand as b on b.id = go.brand_id";$query->where = "ca.category_id in ( $this->childId ) and go.is_del = 0 and go.brand_id  !=  0";$query->fields = "DISTINCT b.id,b.name";$query->limit = "10";$brandList = $query->find();?>
				<?php if($brandList){?>
				<dl class="sorting">
					<dt>品牌：</dt>
					<dd id='brand_dd'>
						<a class="current" href="<?php echo search_goods::searchUrl('brand','');?>">不限</a>
						<?php foreach($brandList as $key => $item){?>
						<a href="<?php echo search_goods::searchUrl('brand',$item['id']);?>" id='brand_<?php echo isset($item['id'])?$item['id']:"";?>'><?php echo isset($item['name'])?$item['name']:"";?></a>
						<?php }?>
					</dd>
				</dl>
				<?php }?>
				<!--品牌展示-->
				
			
				<!-- 类别 -->
				
				<!--  一 -->
				<?php $query = new IQuery("category as ca");$query->where = "ca.parent_id = $this->catId";$query->fields = "DISTINCT ca.id,ca.name";$cateList = $query->find();?>
				<?php if($cateList){?>
				<dl class="sorting">
					<dt>专题活动：</dt>
					<dd id='onecate_dd'>
						<a class="current" href="<?php echo search_goods::searchUrl(array('onecate','in'),'');?>">不限</a>
						<?php foreach($cateList as $key => $item){?>
						<a href="<?php echo search_goods::searchUrl('onecate',$item['id']);?>" id='onecate_<?php echo isset($item['id'])?$item['id']:"";?>'><?php echo isset($item['name'])?$item['name']:"";?></a>
						<?php }?>
					</dd>
				</dl>
				<?php }?>
				<!--  一 -->
				
				<!--  二 -->
				<?php if($this->onecateId){?>
				<?php $query = new IQuery("category as c");$query->where = "c.parent_id = $this->onecateId";$query->fields = "DISTINCT c.id,c.name";$cList = $query->find();?>
				<?php if($cList){?>
				<dl class="sorting">
					<dt>分类：</dt>
					<dd id='in_dd'>
						<a class="current" href="<?php echo search_goods::searchUrl('in','');?>">不限</a>
						<?php foreach($cList as $key => $item){?>
						<a href="<?php echo search_goods::searchUrl('in',$item['id']);?>"   id='in_<?php echo isset($item['id'])?$item['id']:"";?>' ><?php echo isset($item['name'])?$item['name']:"";?></a>
						<?php }?>
					</dd>
				</dl>
				<?php }?>
				<?php }?>
				<!--  二 -->

				<!-- 类别 -->
				
				<!--商品属性-->
				<?php $query = new IQuery("category as ca");$query->join = "left join attribute as attr on ca.model_id = attr.model_id";$query->where = "ca.id = $this->catId and attr.search = 1";$query->fields = "distinct attr.name,attr.name as name,attr.id ,attr.value as value";$items = $query->find(); foreach($items as $key => $item){?>
				<dl class="sorting">
					<dt><?php echo isset($item['name'])?$item['name']:"";?>：</dt>
					<dd id="attr_dd_<?php echo isset($item['id'])?$item['id']:"";?>">
						<a class="current" href="<?php echo search_goods::searchUrl('attr['.$item["id"].']','');?>">不限</a>
						<?php $attrVal = explode(',',$item['value']);?>
						<?php foreach($attrVal as $key => $attr){?>
						<a href="<?php echo search_goods::searchUrl('attr['.$item["id"].']',$attr);?>" id="attr_<?php echo isset($item['id'])?$item['id']:"";?>_<?php echo urlencode($attr);?>"><?php echo isset($attr)?$attr:"";?></a>
						<?php }?>
					</dd>
				</dl>
				<?php }?>
				<!--商品属性-->

				<!--商品规格-->
				<?php if($this->spec){?>
				<?php foreach($this->spec as $key => $item){?>
				<dl class="sorting">
					<dt><?php echo isset($item['name'])?$item['name']:"";?>：</dt>
					<dd id='spec_dd_<?php echo isset($item['id'])?$item['id']:"";?>'>
						<a class="current" href="<?php echo search_goods::searchUrl('spec['.$item["id"].']','');?>">不限</a>
						<?php if($item['type'] == 1){?>
						<?php foreach(JSON::decode($item['value']) as $key => $spec){?>
						<a href="<?php echo search_goods::searchUrl('spec['.$item["id"].']',$spec);?>" id='spec_<?php echo isset($item['id'])?$item['id']:"";?>_<?php echo urlencode($spec);?>'><?php echo isset($spec)?$spec:"";?></a>
						<?php }?>
						<?php }else{?>
						<?php foreach(JSON::decode($item['value']) as $key => $spec){?>
						<a href="<?php echo search_goods::searchUrl('spec['.$item["id"].']',$spec);?>" id='spec_<?php echo isset($item['id'])?$item['id']:"";?>_<?php echo urlencode($spec);?>'><img src='<?php echo IUrl::creatUrl("")."$spec";?>' style='width:20px;height:20px' /></a>
						<?php }?>
						<?php }?>
					</dd>

				</dl>
				<?php }?>
				<?php }?>
				<!--商品规格-->

				<!--商品价格-->
				<dl class="sorting"  style='width:920px;border-top:none;'>
					<dt>价格：</dt>
					<dd id='price_dd'>
						<p class="f_r"><input type="text" class="mini" name="min_price" value="<?php echo IFilter::act(IReq::get('min_price'),'url');?>" onchange="checkPrice(this);"> 至 <input type="text" class="mini" name="max_price" onchange="checkPrice(this);" value="<?php echo IFilter::act(IReq::get('max_price'),'url');?>"> 元
						<label class="btn_gray_s"><input type="button" onclick="priceLink();" value="确定"></label></p>
						<a class="current" href="<?php echo search_goods::searchUrl(array('min_price','max_price'),'');?>">不限</a>
						<?php $goodsPrice = goods_class::getGoodsPrice($this->childId)?>
						<?php foreach($goodsPrice as $key => $item){?>
						<?php $priceZone = explode('-',$item)?>
						<a href="<?php echo search_goods::searchUrl(array('min_price','max_price'),array($priceZone[0],$priceZone[1]));?>" id="<?php echo isset($priceZone[0])?$priceZone[0]:"";?>-<?php echo isset($priceZone[1])?$priceZone[1]:"";?>"><?php echo isset($item)?$item:"";?></a>
						<?php }?>
					</dd>
				</dl>
				<!--商品价格-->
			</div>

		<!--商品列表展示-->
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
	</div>
		
		<?php $goodsObj = search_goods::find(array('category_extend' => $this->childId,'newsort'=>'sort'));$resultData = $goodsObj->find()?>
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
					<a title="<?php echo isset($item['name'])?$item['name']:"";?>" href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><img src="<?php echo IUrl::creatUrl("")."";?><?php echo isset($item['img'])?$item['img']:"";?>" width="280" height="300" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
				</div>
				<div class="price">
					<div class='prot'>
					<span>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></span> &nbsp;返利￥<?php echo isset($item['fan_money'])?$item['fan_money']:"";?> <p>销量: <?php echo isset($item['sale'])?$item['sale']:"";?></p><br>
					</div>
					<div class='prob'>
					<p style='float:left;margin-top:10px;margin-left:5px;'>剩余:<?php echo isset($item['store_nums'])?$item['store_nums']:"";?></p>
					<?php if($item['zhe']){?><p style='float:left;margin-top:10px;margin-left:15px;color:#FF4400;font-size:12px;'><?php echo isset($item['zhe'])?$item['zhe']:"";?> 折</p><?php }else{}?>
					<a title="<?php echo isset($item['name'])?$item['name']:"";?>" class='newa' href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>">我要抢购</a>
					</div>
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
		<!--商品列表展示-->

				</div>
			</div>

<script type='text/javascript'>
//价格跳转
function priceLink()
{
	var minVal = $('[name="min_price"]').val();
	var maxVal = $('[name="max_price"]').val();
	if(isNaN(minVal) || isNaN(maxVal))
	{
		alert('价格填写不正确');
		return '';
	}
	var urlVal = "<?php echo IFilter::act(preg_replace('|&min_price=\w*&max_price=\w*|','',search_goods::searchUrl(array('min_price','max_price'),'')),'url');?>";
	window.location.href=urlVal+'&min_price='+minVal+'&max_price='+maxVal;
}

//价格检查
function checkPrice(obj)
{
	if(isNaN(obj.value))
	{
		obj.value = '';
	}
}

//筛选条件按钮高亮
$(document).ready(function(){
	
	<?php 
		$attr_spec = Array('attr','spec');
		$onecate = IFilter::act(IReq::get('onecate'),'int');
	?>
	<?php if(!empty($onecate)){?>
	$('#onecate_dd>a').removeClass('current');
	$('#onecate_<?php echo isset($onecate)?$onecate:"";?>').addClass('current');
	<?php }?>
	
	<?php 
		$attr_spec = Array('brand','spec');
		$brand = IFilter::act(IReq::get('brand'),'int');
	?>
	<?php if(!empty($brand)){?>
	$('#brand_dd>a').removeClass('current');
	$('#brand_<?php echo isset($brand)?$brand:"";?>').addClass('current');
	<?php }?>
	
	<?php 
		$attr_spec = Array('attr','spec');
		$myin = IFilter::act(IReq::get('in'),'int');
	?>
	<?php if(!empty($myin)){?>
	$('#in_dd>a').removeClass('current');
	$('#in_<?php echo isset($myin)?$myin:"";?>').addClass('current');
	<?php }?>

	<?php foreach($attr_spec as $key => $item){?>
	<?php $tempArray = IFilter::act(IReq::get($item),'url')?>
	<?php if(!empty($tempArray)){?>
		<?php $json = JSON::encode(array_map('urlencode',$tempArray))?>
		var attrArray = <?php echo isset($json)?$json:"";?>;
		for(val in attrArray)
		{
			if(attrArray[val])
			{
				$('#<?php echo isset($item)?$item:"";?>_dd_'+val+'>a').removeClass('current');
				document.getElementById('<?php echo isset($item)?$item:"";?>_'+val+'_'+attrArray[val]).className = 'current';
			}
		}
	<?php }?>
	<?php }?>

	<?php if(IReq::get('min_price') != ''){?>
	$('#price_dd>a').removeClass('current');
	$('#<?php echo IReq::get('min_price');?>-<?php echo IReq::get('max_price');?>').addClass('current');
	<?php }?>
});
</script>

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
