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
	$seo_data=array();
	$site_config=new Config('site_config');
	$seo_data['title']=$name."_".$site_config->name;
	$seo_data['keywords']=$keywords;
	$seo_data['description']=$description;
	seo::set($seo_data);
?>
<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/cookie/jquery.cookie.js"></script>
<?php $shareInstance = new Share();$shareInstance->show();?>
<?php $breadGuide = goods_class::catRecursion($category);?>
<link rel="stylesheet" type="text/css" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.jqzoom/css/jquery.jqzoom.css";?>" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.jqzoom/js/jquery.jqzoom-core-pack.js";?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.bxSlider/jquery.bxslider.css";?>" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.bxSlider/jquery.bxSlider.min.js";?>"></script>
<div class="position"><span>您当前的位置：</span><a href="<?php echo IUrl::creatUrl("");?>">首页</a><?php foreach($breadGuide as $key => $item){?> » <a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/$item[id]");?>"><?php echo isset($item['name'])?$item['name']:"";?></a><?php }?> » <?php echo isset($name)?$name:"";?></div>
	
	<div class="wrapper clearfix">
	<!--图片放大镜-->

	<div class="preview">
		<div class="pic_show" style="width:400px;height:400px;position:relative;z-index:5;padding-bottom:5px;">
			<a class="jqzoom" href="javascript:void(0)" rel='goodsPhoto' id="bigPicBox" alt="原图">
				<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/nopic_435_435.gif";?>" width="400px" height="400px" id="smallPicBox" alt="缩略图" />
			</a>
		</div>

		<ul id="thumblist" class="pic_thumb">
			<?php foreach($photo as $key => $item){?>
			<li>
				<a href='javascript:void(0);' rel="{gallery:'goodsPhoto',smallimage:'<?php echo IUrl::creatUrl("")."";?><?php echo Thumb::get($item['img'],435,435);?>',largeimage:'<?php echo IUrl::creatUrl("")."$item[img]";?>'}">
					<img src='<?php echo IUrl::creatUrl("")."";?><?php echo Thumb::get($item['img'],60,60);?>' width="60px" height="60px" />
				</a>
			</li>
			<?php }?>
		</ul>
	</div>
	<!--图片放大镜-->
	<div class="summary">
		<h2><?php echo isset($name)?$name:"";?></h2>

		<!--货品ID，当为商品时值为空-->
		<input type='hidden' id='product_id' alt='货品ID' value='' />

		<!--基本信息区域-->
		<ul>
		
			<!--商品价格-->
			<li id='priceLi'></li>
		
			<li>
				返利：<span style='color:#FF3366;'>下单价 ￥<?php echo isset($sell_price)?$sell_price:"";?> | 返还金额 ￥<?php echo isset($fan_money)?$fan_money:"";?> | 折扣 &nbsp;<?php echo isset($zhe)?$zhe:"";?>折</span>
			</li>
			
			<li>
			
				<span style='float:left;'>剩余时间：</span> <div id="countdownTime" style='float:left;font-size:13px;color:#FF4400;'></div>
				<span class="endtime" style='display:none;'><?php echo isset($date)?$date:"";?></span>				
			</li>
				
			<li>
				担保金:商家已存担保金 <span style='color:#FF3366;'> <?php echo isset($seller['cash'])?$seller['cash']:"";?></span> 元，请放心购买
			</li>

			<!--商家信息 开始-->
			<?php if(isset($seller)){?>
			<li>商家：<a class="orange" href="<?php echo IUrl::creatUrl("/site/home/id/$seller_id");?>"><?php echo isset($seller['true_name'])?$seller['true_name']:"";?></a></li>
			<li>所在地：<?php echo join(' ',area::name($seller['province'],$seller['city'],$seller['area']));?></li>
			<?php }?>
			<?php if($store_nums <= 0){?>
			该商品已售完，不能购买，您可以看看其它商品！(<a href="<?php echo IUrl::creatUrl("/simple/arrival/goods_id/$id");?>" class="orange">到货通知</a>)
		<?php }else{?>

			<li><span style='float:left;'>数量</span>
				<a class="jia" href="#">-</a>
				<input class="gray_t f_l" type="text" id="buyNums" disabled value="1" maxlength="5" />
				<a class="jia1" href="#">+</a><span style='margin-left:10px;'>库存(<label id="data_storeNums"><?php echo isset($store_nums)?$store_nums:"";?></label>件)</span>	
			</li>
			<!--商家信息 结束-->
			
		</ul>

		<!--商品价格模板-->
		<script type='text/html' id='priceTemplate'>
		<%if(group_price){%>
		<li id='priceLi'>
			会员价：<b class="price red2"><span class="f30" id="real_price"><%=group_price%></span></b> &nbsp;&nbsp;&nbsp;
			销售价：<s>￥<%=sell_price%></s>
		</li>
		<%}else{%>
		<li id='priceLi'>销售价：<b class="price red2"><span class="f30" id="real_price">￥<%=sell_price%></span></b></li>
		<%}%>
		</script>
		<!--购买区域-->

			<br><br><br>
			
			<div style='display:block;float:left;margin-top:0px;'>
			<a class="newa" href="<?php echo isset($tao_url)?$tao_url:"";?>" title="<?php echo isset($name)?$name:"";?>" target="_blank">查看宝贝详情</a>
			<div style='float:left;'>
			<?php if($date > time()){?><a class="newa" id="buyNowButton" onclick="buy_now();" />立即购买</a><?php }?>
			</div>
			</div>
		<?php }?>
		
	</div>
	
	<div class='productright'>
		<?php if($seller){?>
			<dl>
			<dt><strong><?php echo isset($seller['true_name'])?$seller['true_name']:"";?></strong></dt>
			<dt>信誉:<span class="grade1">
						<?php if($sumGrade >= 0 && $sumGrade <= 100 ){?><i style="width:17px;"></i><?php }?>
						<?php if($sumGrade > 100 && $sumGrade <= 200 ){?><i></i><i></i><?php }?>
						<?php if($sumGrade > 200 && $sumGrade <= 300 ){?><i></i><i></i><i></i><?php }?>
						<?php if($sumGrade > 300 && $sumGrade <= 400 ){?><i></i><i></i><i></i><i></i><?php }?>	
						<?php if($sumGrade > 400 && $sumGrade <= 500 ){?><i></i><i></i><i></i><i></i><i></i><?php }?>		
						</span></dt>
			<dt>联系: <?php Sonline::qqShow($seller['server_num'])?></dt>
			<dt><div style='float:left'>资质: </div><div class='zizhiright'><div class='zizhi'></div><div class='jin'><?php echo isset($seller['cash'])?$seller['cash']:"";?>元</div></div></dt>
			<dt><div style='float:left'>验证: </div><div class='zizhiright'><div class='yanzheng'><div class='yan'>已认证商家</div></div></div></dt>
			
			<dt><a href="<?php echo isset($shop_url)?$shop_url:"";?>" class='in' target="_blank">进入店铺</a></dt>
			<dt><a href="#" onclick="favorite_add();" class='in'>收藏宝贝</a></dt>
			</dl>
			<dl style='margin-top:10px;border-top:1px solid #FFE2A3;height:205px;'>
				<dt><strong>看了又看</strong></dt>
				<dt style='height:130px;overflow:hidden;margin-left:-5px;'>
				<?php $query = new IQuery("commend_goods as cg");$query->join = "left join goods as lg on lg.id = cg.goods_id";$query->fields = "lg.name,lg.sell_price,lg.img,lg.id";$query->where = "commend_id = 3 AND lg.is_del = 0 AND lg.id is not null";$query->order = "lg.sort asc,lg.id desc";$query->limit = "2";$items = $query->find(); foreach($items as $key => $item){?>
					<div  style='margin-top:5px;'>
					<a href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>"><img width="58px" height="58px" alt="<?php echo isset($item['name'])?$item['name']:"";?>" src="<?php echo IUrl::creatUrl("")."";?><?php echo Thumb::get($item['img'],58,58);?>" /></a>
					<b style='color:#FF4805;'>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b>
					</div>
				<?php }?>
				</dt>
			</dl>
		<?php }?>
	</div>
</div>


<div class="wrapper clearfix container_2">
	<div class="main f_r" style="overflow:hidden">

		<div class="uc_title" name="showButton">
			<label class="current"><span>宝贝详情</span></label>
			<label><span>累计评论(<?php echo isset($comments)?$comments:"";?>)</span></label>
			<label><span>成交记录(<?php echo isset($buy_num)?$buy_num:"";?>)</span></label>
			<label><span>疑问解答(<?php echo isset($refer)?$refer:"";?>)</span></label>
			<label><span>售后服务</span></label>
			<label><span>支付方式</span></label>
		</div>

		<div name="showBox">
			<!-- 商品详情 start -->
			<div>
				<ul class="saleinfos m_10 clearfix">
					<li>商品名称：<?php echo isset($name)?$name:"";?></li>

					<?php if(isset($brand) && $brand){?>
					<li>品牌：<?php echo isset($brand)?$brand:"";?></li>
					<?php }?>

					<?php if(isset($weight) && $weight){?>
					<li>商品毛重：<label id="data_weight"><?php echo isset($weight)?$weight:"";?></label></li>
					<?php }?>

					<?php if(isset($unit) && $unit){?>
					<li>单位：<?php echo isset($unit)?$unit:"";?></li>
					<?php }?>

					<?php if(isset($up_time) && $up_time){?>
					<li>上架时间：<?php echo isset($up_time)?$up_time:"";?></li>
					<?php }?>

					<?php if(($attribute)){?>
					<?php foreach($attribute as $key => $item){?>
					<li><?php echo isset($item['name'])?$item['name']:"";?>：<?php echo isset($item['attribute_value'])?$item['attribute_value']:"";?></li>
					<?php }?>
					<?php }?>
				</ul>
				<?php if(isset($content) && $content){?>
				<div class="salebox">
					<p class="saledesc"><?php echo isset($content)?$content:"";?></p>
				</div>
				<?php }?>
			</div>
			<!-- 商品详情 end -->

			<!-- 顾客评论 start -->
			<div class="hidden comment_list box">
				<div class="title3">
					<span class="f_r f12 light_gray normal">
						只有购买过该商品的用户才能进行评价
						<?php if(isset($this->user['user_id']) && $user_id = $this->user['user_id']){?>
						<?php $query = new IQuery("comment");$query->fields = "id";$query->where = "status = 0 and goods_id = $id and user_id = $user_id";$query->limit = "1";$items = $query->find(); foreach($items as $key => $item){?>
						<a class="comm_btn" href="<?php echo IUrl::creatUrl("/site/comments/id/$item[id]");?>">我要评论</a>
						<?php }?>
						<?php }?>
					</span>
					<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/comm.gif";?>" width="16px" height="16px" />商品评论<span class="f12 normal">（已有<b class="red2"><?php echo isset($comments)?$comments:"";?></b>条）</span>
				</div>

				<div id='commentBox'></div>

				<!--评论JS模板-->
				<script type='text/html' id='commentRowTemplate'>
				<div class="item">
					<div class="user">
						<div class="ico">
							<a href="javascript:void(0)">
								<img src="<?php echo IUrl::creatUrl("")."<%=head_ico%>";?>" width="70px" height="70px" onerror="this.src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/user_ico.gif";?>'" />
							</a>
						</div>
						<span class="blue"><%=username%></span>
					</div>
					<dl class="desc">
						<%var widthPoint = 14 * point;%>
						<p class="clearfix">
							<b>评分：</b>
							<span class="grade"><i style="width:<%=widthPoint%>px"></i></span>
							<span class="light_gray"><%=comment_time%></span><label></label>
						</p>
						<hr />
						<p><b>评价：</b><span class="gray"><%=contents%></span></p>
					</dl>
					<div class="corner b"></div>
				</div>
				<hr />
				</script>
			</div>
			<!-- 顾客评论 end -->

			<!-- 购买记录 start -->
			<div class="hidden box">
				<div class="title3">
					<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/cart.gif";?>" width="16" height="16" alt="" />
					购买记录<span class="f12 normal">（已有<b class="red2"><?php echo isset($buy_num)?$buy_num:"";?></b>购买）</span>
				</div>

				<table width="100%" class="list_table m_10 mt_10">
					<col width="150" />
					<col width="120" />
					<col width="120" />
					<col width="150" />
					<col />
					<thead class="thead">
						<tr>
							<th>购买人</th>
							<th>出价</th>
							<th>数量</th>
							<th>购买时间</th>
							<th>状态</th>
						</tr>
					</thead>
				</table>

				<table width="100%" class="list_table m_10">
					<col width="150" />
					<col width="120" />
					<col width="120" />
					<col width="150" />
					<col />
					<tbody class="dashed" id="historyBox"></tbody>

					<!--购买历史js模板-->
					<script type='text/html' id='historyRowTemplate'>
					<tr>
						<td><%=username?username:'游客'%></td>
						<td><%=goods_price%></td>
						<td class="bold orange"><%=goods_nums%></td>
						<td class="light_gray"><%=completion_time%></td>
						<td class="bold blue">成交</td>
					</tr>
					</script>
				</table>
			</div>
		

			<!-- 网友讨论圈 start -->
			<div class="hidden box">
				
				<div class="wrap_box no_wrap">
					
				</div>
			</div>
			<!-- 网友讨论圈 end -->

			<!-- 售后服务 start -->
			<div class="hidden box">
				<div class="title3"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/tel.gif";?>" width="20px" height="19px" />售后服务</div>
				<div class="cont_s gray">
					<?php $query = new IQuery("help");$query->fields = "content";$query->where = "id = 52";$items = $query->find(); foreach($items as $key => $item){?>
						<?php echo $item['content'];?>
					<?php }?>
				</div>
			</div>
			<!-- 售后服务 end -->

			<!-- 支付方式 start -->
			<div class="hidden box">
				<div class="title3"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/card.gif";?>" width="23px" height="18px" />支付方式</div>
				<div class="cont_pay">
					支付方式为淘宝支付，用户在淘宝上下单购买，返回单号后填写即可
				</div>
			</div>
			<!-- 支付方式 end -->
		</div>
	</div>
</div>

<script type="text/javascript">
$(function(){

//图片初始化
var goodsSmallPic = "<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/nopic_435_435.gif";?>";
var goodsBigPic   = "<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/nopic_435_435.gif";?>";

//存在图片数据时候
<?php if(isset($photo) && $photo){?>
goodsSmallPic = "<?php echo IUrl::creatUrl("")."";?><?php echo isset($photo[0]['img'])?$photo[0]['img']:"";?>";
goodsBigPic   = "<?php echo IUrl::creatUrl("")."";?><?php echo isset($photo[0]['img'])?$photo[0]['img']:"";?>";
<?php }?>

//初始化商品轮换图
var bxObj = $('#thumblist').bxSlider({
	infiniteLoop: false,
	hideControlOnEnd: true,
	pager:false,
	minSlides: 5,
	maxSlides: 5,
	slideWidth: 72,
	slideMargin: 15,
	controls:true,
	onSliderLoad:function(currentIndex){
		//设置图片
		$('#smallPicBox').attr('src',goodsSmallPic);
		$('#bigPicBox').attr('href',goodsBigPic);

		//开启放大镜
		$('.jqzoom').jqzoom({
			title:false,
			lens:true,
			preloadText:'加载中...',
			zoomWidth:400,
			zoomHeight:400,
			xOffset:15,
		    zoomType: 'standard',
		    preloadImages: false
		});
	}
});

//如果抢购或团购过期则不许立即购买
<?php if($promo!='' && !isset($promotion) && !isset($regiment)){?>
	closeBuy();
<?php }?>

//如果当前是团购
<?php if(isset($regiment)){?>
	<?php $reg_id = IFilter::act(IReq::get('active_id'),'int');?>

	//团购检查,1,人数已满 2,已经参加过
	<?php if(Regiment::isFull($reg_id) || (isset($this->user['user_id']) && Regiment::hasJoined($reg_id,$this->user['user_id'])) || (ICookie::get("regiment_".$reg_id) && Regiment::hasJoined($reg_id,ICookie::get("regiment_".$reg_id)))){?>
		closeBuy();
	<?php }?>
<?php }?>

//开启倒计时功能
var cd_timer = new countdown();

//限时抢购倒计时
<?php if(isset($promotion)){?>
cd_timer.add('promotiona');
<?php }?>

//团购倒计时
<?php if(isset($regiment)){?>
cd_timer.add('promotionb');
<?php }?>

//城市地域选择按钮事件
$('.sel_area').hover(
	function(){
		$('.area_box').show();
	},function(){
		$('.area_box').hide();
	}
);
$('.area_box').hover(
	function(){
		$('.area_box').show();
	},function(){
		$('.area_box').hide();
	}
);

//获取地址的ip地址
getAddress();

//生成商品价格
var priceHtml = template.render('priceTemplate',{"group_price":"<?php echo isset($group_price)?$group_price:"";?>","minSellPrice":"<?php echo isset($minSellPrice)?$minSellPrice:"";?>","maxSellPrice":"<?php echo isset($maxSellPrice)?$maxSellPrice:"";?>","sell_price":"<?php echo isset($sell_price)?$sell_price:"";?>"});
$('#priceLi').replaceWith(priceHtml);

//按钮绑定
$('[name="showButton"]>label').click(function(){
	$(this).siblings().removeClass('current');
	if($(this).hasClass('current') == false)
	{
		$(this).addClass('current');
	}
	$('[name="showBox"]>div').addClass('hidden');
	$('[name="showBox"]>div:eq('+$(this).index()+')').removeClass('hidden');

	switch($(this).index())
	{
		case 1:
		{
			comment_ajax();
		}
		break;

		case 2:
		{
			history_ajax();
		}
		break;

		case 3:
		{
			refer_ajax();
		}
		break;

		case 4:
		{
			discuss_ajax();
		}
		break;
	}
});

});

//禁止购买
function closeBuy()
{
	if($('#buyNowButton').length > 0)
	{
		$('#buyNowButton').attr('disabled','disabled');
		$('#buyNowButton').addClass('disabled');
	}

	if($('#joinCarButton').length > 0)
	{
		$('#joinCarButton').attr('disabled','disabled');
		$('#joinCarButton').addClass('disabled');
	}
}

//开放购买
function openBuy()
{
	if($('#buyNowButton').length > 0)
	{
		$('#buyNowButton').removeAttr('disabled');
		$('#buyNowButton').removeClass('disabled');
	}

	if($('#joinCarButton').length > 0)
	{
		$('#joinCarButton').removeAttr('disabled');
		$('#joinCarButton').removeClass('disabled');
	}
}

//加载根据地域获取城市
function getAddress()
{
	//根据IP查询所在地
	var ipAddress = $.cookie('ipAddress');
	if(ipAddress)
	{
		searchDelivery(ipAddress);
	}
	else
	{
		$.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js',function(){
			ipAddress = remote_ip_info['province'];
			$.cookie('ipAddress',ipAddress);
			searchDelivery(ipAddress);
		});
	}
}

//发表讨论
function sendDiscuss()
{
	var userId = "<?php echo isset($this->user['user_id'])?$this->user['user_id']:"";?>";
	if(userId)
	{
		$('#discussTable').show('normal');
		$('#discussContent').focus();
	}
	else
	{
		alert('请登陆后再发表讨论!');
	}
}

/**
 * 根据省份获取运费信息
 * @param province 省份名称
 */
function searchDelivery(province)
{
	var url = '<?php echo IUrl::creatUrl("/block/searchPrivice/random/@random@");?>';
	url = url.replace("@random@",Math.random);

	$.getJSON(url,{'province':province},function(json)
	{
		if(json.flag == 'success')
		{
			delivery(json.area_id,province);
		}
	});
}

/**
 * 计算运费
 * @param provinceId
 * @param provinceName
 */
function delivery(provinceId,provinceName)
{
	$('.sel_area').text(provinceName);

	var weight  = '<?php echo isset($weight)?$weight:"";?>';
	var buyNums = $('#buyNums').val();

	//通过省份id查询出配送方式，并且传送总重量计算出运费,然后显示配送方式
	var totalWeight = parseInt(weight) * parseInt(buyNums);
	var url = '<?php echo IUrl::creatUrl("/block/order_delivery");?>';

	$.getJSON(url,{'province':provinceId,'total_weight':totalWeight,'random':Math.random},function(json)
	{
		//清空配送信息
		$('#deliveInfo').empty();

		for(var item in json)
		{
			var deliveRowHtml = template.render('deliveInfoTemplate',json[item]);
			$('#deliveInfo').append(deliveRowHtml);
		}
	});
}

/**
 * 获取评论数据
 * @page 分页数
 */
function comment_ajax(page)
{
	if(!page && $.trim($('#commentBox').text()))
	{
		return;
	}
	page = page ? page : 1;
	var url = '<?php echo IUrl::creatUrl("/site/comment_ajax/page/@page@/goods_id/$id");?>';
	url = url.replace("@page@",page);
	$.getJSON(url,function(json)
	{
		//清空评论数据
		$('#commentBox').empty();

		for(var item in json.data)
		{
			var commentHtml = template.render('commentRowTemplate',json.data[item]);
			$('#commentBox').append(commentHtml);
		}
		$('#commentBox').append(json.pageHtml);
	});
}

/**
 * 获取购买记录数据
 * @page 分页数
 */
function history_ajax(page)
{
	if(!page && $.trim($('#historyBox').text()))
	{
		return;
	}
	page = page ? page : 1;
	var url = '<?php echo IUrl::creatUrl("/site/history_ajax/page/@page@/goods_id/$id");?>';
	url = url.replace("@page@",page);
	$.getJSON(url,function(json)
	{
		//清空购买历史记录
		$('#historyBox').empty();
		$('#historyBox').parent().parent().find('.pages_bar').remove();

		for(var item in json.data)
		{
			var historyHtml = template.render('historyRowTemplate',json.data[item]);
			$('#historyBox').append(historyHtml);
		}
		$('#historyBox').parent().after(json.pageHtml);
	});
}

/**
 * 获取购买记录数据
 * @page 分页数
 */
function refer_ajax(page)
{
	if(!page && $.trim($('#referBox').text()))
	{
		return;
	}
	page = page ? page : 1;
	var url = '<?php echo IUrl::creatUrl("/site/refer_ajax/page/@page@/goods_id/$id");?>';
	url = url.replace("@page@",page);
	$.getJSON(url,function(json)
	{
		//清空评论数据
		$('#referBox').empty();

		for(var item in json.data)
		{
			var commentHtml = template.render('referRowTemplate',json.data[item]);
			$('#referBox').append(commentHtml);
		}
		$('#referBox').append(json.pageHtml);
	});
}

/**
 * 获取购买记录数据
 * @page 分页数
 */
function discuss_ajax(page)
{
	if(!page && $.trim($('#discussBox').text()))
	{
		return;
	}
	page = page ? page : 1;
	var url = '<?php echo IUrl::creatUrl("/site/discuss_ajax/page/@page@/goods_id/$id");?>';
	url = url.replace("@page@",page);
	$.getJSON(url,function(json)
	{
		//清空购买历史记录
		$('#discussBox').empty();
		$('#discussBox').parent().parent().find('.pages_bar').remove();

		for(var item in json.data)
		{
			var historyHtml = template.render('discussRowTemplate',json.data[item]);
			$('#discussBox').append(historyHtml);
		}
		$('#discussBox').parent().after(json.pageHtml);
	});
}

//发布讨论数据
function sendDiscussData()
{
	var content = $('#discussContent').val();
	var captcha = $('[name="captcha"]').val();

	if($.trim(content)=='')
	{
		alert('请输入讨论内容!');
		$('#discussContent').focus();
		return false;
	}
	if($.trim(captcha)=='')
	{
		alert('请输入验证码!');
		$('[name="captcha"]').focus();
		return false;
	}

	var url = '<?php echo IUrl::creatUrl("/site/discussUpdate/id/$id/captcha/@captcha@/random/@Math@");?>';
	url = url.replace("@captcha@",captcha).replace("@Math@",Math.random);

	$.getJSON(url,{'content':content},function(json)
	{
		if(json.isError == false)
		{
			var discussHtml = template.render('discussRowTemplate',json);
			$('#discussBox').prepend(discussHtml);

			//清除数据
			$('#discussContent').val('');
			$('[name="captcha"]').val('');
			$('#discussTable').hide('normal');
			changeCaptcha('<?php echo IUrl::creatUrl("/site/getCaptcha");?>');
		}
		else
		{
			alert(json.message);
		}
	});
}

/**
 * 规格的选择
 * @param _self 规格本身
 */
function sele_spec(_self)
{
	var specObj = $.parseJSON($(_self).attr('value'));

	//清除同规格下已选数据
	$('#selectedSpan'+specObj.id).remove();

	//已经为选中状态时
	if($(_self).attr('class') == 'current')
	{
		$(_self).removeClass('current');
		$('#selectedSpan'+specObj.id).remove();
	}
	else
	{
		//清除同行中其余规格选中状态
		$('#specList'+specObj.id).find('a.current').removeClass('current');

		$(_self).addClass('current');
		var newSpecHtml = template.render('selectedSpecTemplate',specObj);
		$('#specSelected').append(newSpecHtml);
	}

	//检查规格是否选择符合标准
	if(checkSpecSelected())
	{
		//整理规格值
		var specArray = [];
		$('[name="specCols"]').each(function(){
			specArray.push($(this).find('a.current').attr('value'));
		});
		var specJSON = '['+specArray.join(",")+']';

		//获取货品数据并进行渲染
		$.getJSON('<?php echo IUrl::creatUrl("/site/getProduct");?>',{"goods_id":"<?php echo isset($id)?$id:"";?>","specJSON":specJSON,"random":Math.random},function(json){
			if(json.flag == 'success')
			{
				//普通商品购买方式(非团购，抢购等),商品价格渲染
				if($('#priceLi').length > 0)
				{
					var priceHtml = template.render('priceTemplate',json.data);
					$('#priceLi').replaceWith(priceHtml);
				}
				//非普通商品购买方式，商品价格渲染
				else if($('#data_sellPrice').length > 0)
				{
					$('#data_sellPrice').text(json.data.sell_price);
				}

				//普通货品数据渲染
				$('#data_goodsNo').text(json.data.products_no);
				$('#data_storeNums').text(json.data.store_nums);
				$('#data_marketPrice').text("￥"+json.data.market_price);
				$('#data_weight').text(json.data.weight);
				$('#product_id').val(json.data.id);

				//库存监测
				checkStoreNums();
			}
			else
			{
				alert(json.message);
				closeBuy();
			}
		});
	}
}

/**
 * 监测库存操作
 */
function checkStoreNums()
{
	var storeNums = parseInt($.trim($('#data_storeNums').text()));
	if(storeNums > 0)
	{
		openBuy();
	}
	else
	{
		closeBuy();
	}
}

/**
 * 检查规格选择是否符合标准
 * @return boolen
 */
function checkSpecSelected()
{
	if($('[name="specCols"]').length === $('[name="specCols"] .current').length)
	{
		return true;
	}
	return false;
}

//检查购买数量是否合法
function checkBuyNums()
{
	//购买数量小于0
	var buyNums = parseInt($.trim($('#buyNums').val()));
	if(buyNums <= 0)
	{
		$('#buyNums').val(1);
		return;
	}

	//购买数量大于库存
	var storeNums = parseInt($.trim($('#data_storeNums').text()));
	if(buyNums >= storeNums)
	{
		$('#buyNums').val(storeNums);
		return;
	}
}

/**
 * 购物车数量的加减
 * @param code 增加或者减少购买的商品数量
 */
function modified(code)
{
	var buyNums = parseInt($.trim($('#buyNums').val()));
	switch(code)
	{
		case 1:
		{
			buyNums++;
		}
		break;

		case -1:
		{
			buyNums--;
		}
		break;
	}

	$('#buyNums').val(buyNums);
	checkBuyNums();
}

//商品加入购物车
function joinCart()
{
	if(!checkSpecSelected())
	{
		tips('请先选择商品的规格');
		return;
	}

	var buyNums   = parseInt($.trim($('#buyNums').val()));
	var price     = parseFloat($.trim($('#real_price').text()));
	var productId = $('#product_id').val();
	var type      = productId ? 'product' : 'goods';
	var goods_id  = (type == 'product') ? productId : <?php echo isset($id)?$id:"";?>;

	$.getJSON('<?php echo IUrl::creatUrl("/simple/joinCart");?>',{"goods_id":goods_id,"type":type,"goods_num":buyNums,"random":Math.random},function(content){
		if(content.isError == false)
		{
			//获取购物车信息
			$.getJSON('<?php echo IUrl::creatUrl("/simple/showCart");?>',{"random":Math.random},function(json)
			{
				$('[name="mycart_count"]').text(json.count);
				$('[name="mycart_sum"]').text(json.sum);

				//展示购物车清单
				$('#product_myCart').show();

				//暂闭加入购物车按钮
				$('#joinCarButton').attr('disabled','disabled');
			});
		}
		else
		{
			alert(content.message);
		}
	});
}

//添加收藏夹
function favorite_add(obj)
{
	<?php if(isset($this->user['user_id'])){?>
		$.getJSON('<?php echo IUrl::creatUrl("/simple/favorite_add");?>',{'goods_id':<?php echo isset($id)?$id:"";?>,'random':Math.random},function(content)
		{
			if(content.isError == false)
			{
				alert(content.message);
			}
			else
			{
				alert(content.message);
			}
		});
	<?php }else{?>
		window.location.href="<?php echo IUrl::creatUrl("/simple/login/?callback=/site/products/id/$id");?>";
	<?php }?>
}

//立即购买按钮
function buy_now()
{
	//对规格的检查
	if(!checkSpecSelected())
	{
		tips('请选择商品的规格');
		return;
	}

	//设置必要参数
	var buyNums  = parseInt($.trim($('#buyNums').val()));
	var id = <?php echo isset($id)?$id:"";?>;
	var type = 'goods';

	if($('#product_id').val())
	{
		id = $('#product_id').val();
		type = 'product';
	}

	<?php if($promo){?>
	//有促销活动（团购，抢购）
	var url = '<?php echo IUrl::creatUrl("/simple/cart2/id/@id@/num/@buyNums@/type/@type@/promo/$promo/active_id/$active_id");?>';
	url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
	<?php }else{?>
	//普通购买
	var url = '<?php echo IUrl::creatUrl("/simple/cart2/id/@id@/num/@buyNums@/type/@type@");?>';
	url = url.replace('@id@',id).replace('@buyNums@',buyNums).replace('@type@',type);
	<?php }?>

	//页面跳转
	window.location.href = url;
}

function getDate(tm){
var tt=new Date(parseInt(tm) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ")
return tt;
}
var endtime, nowtime, nowtimes, lasttime, lastdate, lasthours, lastminutes, strtime;
endtime = $(".endtime").text();

function getLastTime(){
nowtime = Date.parse(new Date()) / 1000;
lasttime = endtime - nowtime;
if(lasttime > 0){
var date = getDate(lasttime);
lastdate = parseInt(lasttime/3600/24);
lasthours = parseInt(((lasttime-(lastdate*24*60*60))/3600));
lastminutes = parseInt(((lasttime-(lastdate*24*60*60)-(lasthours*3600))/60));
lastsecond = parseInt((lasttime-((lastdate*24*60*60)+(lasthours*3600)+(lastminutes*60))));
strtime = '' + lastdate + '' + '天' + '' + lasthours + '' + '时' + '' + lastminutes + '' + '分' + '' + lastsecond + '' + '秒';
$("#countdownTime").html(strtime);
}else{
strtime = '宝贝抢购时间已结束';
$("#countdownTime").html(strtime);
}
window.setTimeout("getLastTime()", 100);
}

$(function (){
getLastTime();
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
