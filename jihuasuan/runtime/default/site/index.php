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
	
	<?php 
	$site_config=new Config('site_config');
	$seo_data=array();
	$seo_data['title']=$site_config->name;
	$seo_data['title'].=$site_config->index_seo_title;
	$seo_data['keywords']=$site_config->index_seo_keywords;
	$seo_data['description']=$site_config->index_seo_description;
	seo::set($seo_data);
?>
<link rel="stylesheet" type="text/css" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.bxSlider/jquery.bxslider.css";?>" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.bxSlider/responsiveslides.min.js";?>"></script>
<div class="wrapper clearfix">
	<div class="sidebar f_l">
		<ul class="sortlist" id='div_allsort'>
				<?php $query = new IQuery("category");$query->where = "parent_id = 0 and visibility = 1";$query->order = "sort asc";$items = $query->find(); foreach($items as $key => $first){?>
				<li>
					<a class='color1' href="<?php echo IUrl::creatUrl("/site/pro_list/cat/$first[id]");?>"><?php echo isset($first['name'])?$first['name']:"";?></a>
					<!--商品分类 浮动div 开始-->
					<div class="sublist">
						<div class="items">
							<strong>选择分类</strong>
							<?php $query = new IQuery("category");$query->where = "parent_id = $first[id] and visibility = 1";$query->order = "sort asc";$items = $query->find(); foreach($items as $key => $second){?>
							<dl class="category selected">
							
								<dt>
									<a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/$second[id]");?>"><?php echo isset($second['name'])?$second['name']:"";?></a>
								</dt>
							
								<dd>
									<?php $query = new IQuery("category");$query->where = "parent_id = $second[id] and visibility = 1";$query->order = "sort asc";$items = $query->find(); foreach($items as $key => $third){?>
									<a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/$third[id]");?>"><?php echo isset($third['name'])?$third['name']:"";?></a>|
									<?php }?>
								</dd>
							</dl>
							<?php }?>
						</div>
					</div>
					<!--商品分类 浮动div 结束-->
				</li>
			<?php }?>
		</ul>
	</div>
	<!--幻灯片 开始-->
	 <div class="main11">
		<div id="events"></div>
		<?php if($this->index_slide){?>
		<div class="callbacks_container">
		<ul class="bxslider" id="slider4">
			<?php foreach($this->index_slide as $key => $item){?>
			<li title="<?php echo isset($item['name'])?$item['name']:"";?>"><a href="<?php echo IUrl::creatUrl("$item[url]");?>" target="_blank"><img src="<?php echo IUrl::creatUrl("")."$item[img]";?>" width="600px" height="330px" title="<?php echo isset($item['name'])?$item['name']:"";?>" />
			<p class="caption"><?php echo isset($item['name'])?$item['name']:"";?></p>
			</a></li>
			<?php }?>
		</ul>
		</div>
		<?php }?> 
		<div class='shen'>
			<span>
				<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/qiang.gif";?>"/><strong>您好~欢迎来到集划算！</strong>
			</span>
			<div class='open'><a href="<?php echo IUrl::creatUrl("/simple/seller");?>" class='newa1'/>我要开店</a></div>
			<div class='open' style='margin-left:5px;'><a href="<?php echo IUrl::creatUrl("/simple/login?callback=$callback");?>" class='newa1'/>我要抢购</a></div>
		</div>
		<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/one.jpg";?>"/>
		<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/two.jpg";?>"/>
	</div> 
	<!--幻灯片 结束-->
</div>

<br>
<div class="wrapper clearfix">
<div class="newmain f_l">
	<div class='newcenter'>
	<ul>
		<li style='border-left:1px solid #DCDCDC;'>
		<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/new.png";?>"/><span>每日更新</span><p class='p'>每天10点、20点准时上线<p></li>
		<li><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/bao.png";?>"/><span>消费保障</span><p class='p'>商家预存足额保证金<p></li>
		<li><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/shan.png";?>"/><span>闪电返款</span><p class='p'> 每笔闪返 50%~90% <p></li>
		<li style='width:260px;'><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/yan.png";?>"/><span>品质验证</span><p class='p'>商品质量层层把关<p></li>
	</ul>
	</div>
	<br>
		<!--最新商品-->
		<div class="box yellow m_10" >
			<div class="title2">
				<span>特卖每日上新，感受上千品牌的舒适生活</span>
				<a class='more' href='<?php echo IUrl::creatUrl("site/pro_list/cat/1");?>'>查看全部特卖 &gt;</a>
			</div>	
			<div class="cont clearfix">
				<ul class="prolist">
					<?php $query = new IQuery("commend_goods as co");$query->join = "left join goods as go on co.goods_id = go.id";$query->where = "co.commend_id = 1 and go.is_del = 0 AND go.id is not null";$query->fields = "go.img,go.sale,go.fan_money,go.sell_price,go.name,go.market_price,go.id";$query->order = "go.sort asc,id desc";$query->group = "id";$items = $query->find(); foreach($items as $key => $item){?>	
					<?php $tmpId=$item['id'];?>
					<?php 
					
						if($item['fan_money'] != 0){
							$item['zhe'] = number_format(($item['sell_price']-$item['fan_money'])/$item['sell_price'],2)*10;	
						}
					?>
					
					<li style="overflow:hidden;background:white;margin-left:24px;">
						<a href="<?php echo IUrl::creatUrl("/site/products/id/$tmpId");?>">
						<img src="<?php echo IUrl::creatUrl("")."";?><?php echo isset($item['img'])?$item['img']:"";?>" width="300" height="320" alt="<?php echo isset($item['name'])?$item['name']:"";?>" />
						</a>
						<p class="newtitle"><a title="<?php echo isset($item['name'])?$item['name']:"";?>" href="<?php echo IUrl::creatUrl("/site/products/id/$tmpId");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></p>
						<div class='newprice'>
							<i>￥</i>
							<?php echo isset($item['sell_price'])?$item['sell_price']:"";?>
						</div>
						<p style='margin-left:190px;font-size:14px;margin-top:17px;color:#F72862;'>返利 ￥<?php echo isset($item['fan_money'])?$item['fan_money']:"";?></span></p>
						<div class='zhi'>
						<p class='newbaoyou'><span style='color:white;display:block;font-size:14px;'>包 邮</span></p>
						<p class='newbaoyou'><span style='color:#FFFFFF;display:block;font-size:14px;padding-left:5px;'><?php if(isset($item['zhe'])){ echo $item['zhe'].' 折';}else{echo '0 折';}?></span></p>
						<p style='font-size:15px;color:#555555;margin-top:10px;float:right;margin-right:30px;'><span style='color:#599E07;'><?php echo isset($item['sale'])?$item['sale']:"";?></span>人已买</p>
						</div>
					</li>
				
					<?php }?>
					
				</ul>
			</div>
		</div>
		<!-- 衣服 -->
		<div class="brand box m_10" style='border-top:none;border-left:none;border-right:none;height:520px;overflow:hidden;'>
			<div class='top'>
				<div class='cloth'>|&nbsp;今日上新<strong>124</strong>件</div>
				<div class='ahref'><a href="#" >查看所有衣服 ></a></div>
			</div>
			<div class='top2'>
			<?php if($this->cloth){?>
				<?php foreach($this->cloth as $key => $item){?>
					<div class='pi'>
					<a href="<?php echo IUrl::creatUrl("/site/products/id/$tmpId");?>"><img src="<?php echo IUrl::creatUrl("")."";?><?php echo isset($item['img'])?$item['img']:"";?>" width="180" height="225" alt="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
					<a class="picbottom" href="<?php echo IUrl::creatUrl("/site/products/id/$tmpId");?>"><span><?php echo isset($item['name'])?$item['name']:"";?></span></a>
					</div>
				<?php }?>
			<?php }?>
			</div>
			<div class='topright'>
				<div class="cmn_title">
				<p class="f14_f">
				<a  href="#">
				更多好店
				<samp> ></samp>
				</a>
				</p>
				<h3 class="f16_f"  style='color:#FF4400;'>最热好店</h3>
				</div>
				<ul>
				<?php foreach($this->sellerRow as $key => $item){?>
					<li>
						<img src="<?php echo IUrl::creatUrl("")."";?><?php echo isset($item['img'])?$item['img']:"";?>" width="35" height="35" alt="<?php echo isset($item['name'])?$item['name']:"";?>" />
						<a href="<?php echo IUrl::creatUrl("")."";?>site/home/id/<?php echo isset($item['seller_id'])?$item['seller_id']:"";?>"><span><?php echo isset($item['seller_name'])?$item['seller_name']:"";?></span></a><br>
						<span style='margin-top:5px;'><span style='color:#FF4400;'><?php echo isset($item['count'])?$item['count']:"";?></span>件商品/总销量<?php echo isset($item['sumsale'])?$item['sumsale']:"";?></span>
					</li>
				<?php }?>		
				</ul>
			</div>
		</div>
		<!-- 衣服 -->
		
		<!-- 鞋子 -->
		<div class="brand box m_10" style='border-top:none;border-left:none;border-right:none;height:530px;overflow:hidden;'>
			<div class='top'>
				<div class='shoe'>|&nbsp;今日上新<strong>124</strong>件</div>
				<div class='ahref'><a href="#" >查看所有鞋子 ></a></div>
			</div>
			<div class='top2'>
				<?php if($this->shoe){?>
				<?php foreach($this->shoe as $key => $item){?>
					<div class='pi'>
					<a href="<?php echo IUrl::creatUrl("/site/products/id/$tmpId");?>"><img src="<?php echo IUrl::creatUrl("")."";?><?php echo isset($item['img'])?$item['img']:"";?>" width="180" height="225" alt="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
					<a class="picbottom" href="<?php echo IUrl::creatUrl("/site/products/id/$tmpId");?>"><span><?php echo isset($item['name'])?$item['name']:"";?></span></a>
					</div>
				<?php }?>
				<?php }?>
			</div>
			<div class='topright2'>
				<div class="cmn_title">
				<p class="f14_f">
				<a  href="#">
				更多推荐
				<samp> ></samp>
				</a>
				</p>
				<h3 class="f16_f" style='color:#FF4400;'>极品推荐</h3>
				</div>
				<div class='ulli'>
				<ul>
				<?php if($this->tuijian){?>
				<?php foreach($this->tuijian as $key => $item){?>
					<li>
						<a class="pic" href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>">
						<img src="<?php echo IUrl::creatUrl("")."";?><?php echo Thumb::get($item['img'],85,85);?>" alt="<?php echo isset($item['name'])?$item['name']:"";?>" />
						</a>
						<h4><?php echo isset($item['name'])?$item['name']:"";?></h4>
						<span>集划算向您推荐,惊喜返利价</span>
						<p>￥<?php echo isset($item['fan_money'])?$item['fan_money']:"";?></p>
					</li>
				<?php }?>
				<?php }?>				
				</ul>
				</div>
			</div>
		</div>
		<!-- 鞋子 -->
		
		
		<!-- 手机/超值团购 -->
		<div class="brand box m_10" style='border-top:none;border-left:none;border-right:none;height:540px;overflow:hidden;'>
			<div class='top'>
				<div class='phone'>|&nbsp;今日上新<strong>124</strong>件</div>
				<div class='ahref'><a href="#" >查看所有电子产品 ></a></div>
			</div>
			<div class='top2'>
				<?php if($this->phone){?>
				<?php foreach($this->phone as $key => $item){?>
					<div class='pi'>
					<a href="<?php echo IUrl::creatUrl("/site/products/id/$tmpId");?>"><img src="<?php echo IUrl::creatUrl("")."";?><?php echo isset($item['img'])?$item['img']:"";?>" width="180" height="225" alt="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
					<a class="picbottom" href="<?php echo IUrl::creatUrl("/site/products/id/$tmpId");?>"><span><?php echo isset($item['name'])?$item['name']:"";?></span></a>
					</div>
				<?php }?>
				<?php }?>
			</div>
			<div class='topright3'>
				<div class="cmn_title">
				<p class="f14_f">
				<a href="#">
				更多热卖
				<samp> ></samp>
				</a>
				</p>
				<h3 class="f16_f"  style='color:#FF4400;'>划算热卖</h3>
				</div>
				<ul>
				<div class='ulli'>
				<?php foreach($this->hotsell as $key => $item){?>
					<li>
						<img src="<?php echo IUrl::creatUrl("")."";?><?php echo isset($item['img'])?$item['img']:"";?>" width="105" height="125" alt="" />
					</li>
				<?php }?>		
				</ul>
				</div>
			</div>
		</div>
		<!-- 手机 -->
		
		
		<!-- 配饰 -->
		<div class="brand box m_10" style='border-top:none;border-left:none;border-right:none;height:540px;overflow:hidden;'>
			<div class='top'>
				<div class='peishi'>|&nbsp;今日上新<strong>124</strong>件</div>
				<div class='ahref'><a href="#" >查看所有配饰 ></a></div>
			</div>
			<div class='top2'>
			<?php if($this->peishi){?>
				<?php foreach($this->peishi as $key => $item){?>
					<div class='pi'>
					<a href="<?php echo IUrl::creatUrl("/site/products/id/$tmpId");?>"><img src="<?php echo IUrl::creatUrl("")."";?><?php echo isset($item['img'])?$item['img']:"";?>" width="180" height="225" alt="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
					<a class="picbottom" href="<?php echo IUrl::creatUrl("/site/products/id/$tmpId");?>"><span><?php echo isset($item['name'])?$item['name']:"";?></span></a>
					</div>
				<?php }?>
			<?php }?>
			</div>
			<div class='topright3'>
				<div class="cmn_title">
				<p class="f14_f">
				<a href="#">
				更多特价
				<samp> ></samp>
				</a>
				</p>
				<h3 class="f16_f"  style='color:#FF4400;'>限时特价</h3>
				</div>
				<ul>
				<?php foreach($this->tesell as $key => $item){?>
					<li>
						<img src="<?php echo IUrl::creatUrl("")."";?><?php echo isset($item['img'])?$item['img']:"";?>" width="105" height="125" alt="" />
					</li>
				<?php }?>		
				</ul>
			</div>
		</div>
		<!-- 配饰 -->
		
		
		<!--品牌列表-->
		<div class="brand box m_10">
			<div class="lititle"><h2><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/brand.gif";?>" alt="品牌推荐" width="155" height="36" style='float:left;'/></h2><a class="more" href="<?php echo IUrl::creatUrl("/site/brand");?>">查看全部品牌 &gt;</a></div>
			<div class="cont clearfix" style='clear:both;'>
				<ul style='margin-left:50px;margin-top:10px;'>
					<?php $query = new IQuery("brand");$query->fields = "id,name,logo";$query->order = "sort asc";$query->limit = "20";$items = $query->find(); foreach($items as $key => $item){?>
					<?php $tmpId=$item['id'];?>
					<li><a href="<?php echo IUrl::creatUrl("/site/brand_zone/id/$tmpId");?>"><img src="<?php echo IUrl::creatUrl("")."$item[logo]";?>"  width="190" height="90"/></a></li>
					<?php }?>
				</ul>
			</div>
		</div>
		<!--品牌列表-->

		<!--最新评论-->
		<div class="comment box m_10">
			<div class="lititle" style='float:left;'><h2><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/comment.gif";?>" alt="最新评论" width="155" height="36" /></h2></div>
			<div class="cont clearfix">
				<?php $query = new IQuery("comment as co");$query->join = "left join goods as go on co.goods_id = go.id";$query->order = "co.id desc";$query->limit = "6";$query->where = "co.status = 1 AND go.is_del = 0 AND go.id is not null";$query->fields = "go.img as img,go.name as name,co.point,co.contents,co.goods_id";$items = $query->find(); foreach($items as $key => $item){?>
				<dl class="no_bg">
					<?php $tmpGoodsId=$item['goods_id'];?>
					<dt><a href="<?php echo IUrl::creatUrl("/site/products/id/$tmpGoodsId");?>"><img src="<?php echo IUrl::creatUrl("")."";?><?php echo Thumb::get($item['img'],66,66);?>" width="66" height="66" /></a></dt>
					<dd><a href="<?php echo IUrl::creatUrl("/site/products/id/$tmpGoodsId");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></dd>
					<dd><span class="grade"><i style="width:<?php echo $item['point']*14;?>px"></i></span></dd>
					<dd class="com_c"><?php echo isset($item['contents'])?$item['contents']:"";?></dd>
				</dl>
				<?php }?>
			</div>
		</div>
		<!--最新评论-->
	</div>
</div>

<script type='text/javascript'>
//dom载入完毕执行
jQuery(function()
{
	//幻灯片开启
	$("#slider4").responsiveSlides({
		auto: true,
		pager: false,
		nav: true,
		speed: 500,
		namespace: "callbacks",
		before: function () {
		  $('.events').append("");
		},
		after: function () {
		  $('.events').append("");
		}
	  });
	  

	//index 分类展示
	$('#index_category tr').hover(
		function(){
			$(this).addClass('current');
		},
		function(){
			$(this).removeClass('current');
		}
	);

	//email订阅 事件绑定
	var tmpObj = $('input:text[name="orderinfo"]');
	var defaultText = tmpObj.val();
	tmpObj.bind({
		focus:function(){checkInput($(this),defaultText);},
		blur :function(){checkInput($(this),defaultText);}
	});

	$.fn.getHexBackgroundColor = function() { var rgb = $(this).css('color'); if(!$.browser.msie){ rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/); function hex(x) {return ("0" + parseInt(x).toString(16)).slice(-2);} rgb= "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]); } return rgb; }
	
	//导航颜色
	$(".color1").hover(function(){
		$(this).css({"color":"white"});
	},function(){
		var newObject = $(this);
		var color = newObject.getHexBackgroundColor();
		$(".items").hover(function(){
		
			if(color == '#ffffff' || color == 'rgb(255, 255, 255)' || color == 'white'){
				$(".color1").css({"color":"#333333"});
				newObject.css({"color":"#ffffff"});
			}
		},function(){
			newObject.css({"color":"#333333"});
		});
		$(".color1").css({"color":"#333333"});
	});


	//首页商品变色
	var colorArray = ['green','yellow','purple'];
	$('div[name="showGoods"]').each(function(i)
	{
		$(this).addClass(colorArray[i%colorArray.length]);
	});
});

//电子邮件订阅
function orderinfo()
{
	var email = $('[name="orderinfo"]').val();
	if(email == '')
	{
		alert('请填写正确的email地址');
	}
	else
	{
		$.getJSON('<?php echo IUrl::creatUrl("/site/email_registry");?>',{email:email},function(content){
			if(content.isError == false)
			{
				alert('订阅成功');
				$('[name="orderinfo"]').val('');
			}
			else
				alert(content.message);
		});
	}
}
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
