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
		<?php $user_id = $this->user['user_id']?>
<?php $favoriteSum = 0?>
<div class="main f_r" style='width:765px;'>
	<div class="uc_title m_10">
		<label class="current"><span>收藏夹</span></label>
	</div>

	<div class="box">
		<div class="title">
			<b class="gray">按分类查找：</b>
			<a href="<?php echo IUrl::creatUrl("/ucenter/favorite/");?>" class='<?php if(IReq::get('cat_id') == ''){?>orange<?php }?>'>全部（<label id='favoriteSum'></label>）</a>
			<?php $query = new IQuery("favorite as f,category as c");$query->where = "f.user_id = $user_id and f.cat_id = c.id";$query->fields = "count(*) as num,c.name,c.id";$query->group = "cat_id";$items = $query->find(); foreach($items as $key => $item){?>
			<?php $favoriteSum+=$item['num']?>
			<a href="<?php echo IUrl::creatUrl("/ucenter/favorite/cat_id/$item[id]");?>" class='<?php if(IReq::get('cat_id') == $item['id']){?>orange<?php }?>'><?php echo isset($item['name'])?$item['name']:"";?>（<?php echo isset($item['num'])?$item['num']:"";?>）</a>
			<?php }?>
		</div>
	</div>

	<form action='#' method='post' id='favorite' name='favorite'>
		<table class="border_table" width="100%" cellpadding="0" cellspacing="0">
			<col width='15px' />
			<col />
			<col width='100px' />
			<col width='60px' />
			<col width='70px' />
			<thead>
				<tr>
					<td><input type="checkbox" onclick="selectAll('id[]');" /></td>
					<td align="center">商品名称</td>
					<td align="center">收藏时间</td>
					<td align="center">价格</td>
					<td align="center">操作</td>
				</tr>
			</thead>

			<tbody>
				<?php $favoriteObj = null;$favoriteList = $this->get_favorite($favoriteObj)?>
				<?php foreach($favoriteList as $key => $item){?>
				<?php $type=1?>
				<tr>
					<td><input name="id[]" type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" /></td>
					<td>
						<dl>
							<?php $tmp=$item['data']['id'];$tmpIMG=$item['data']['img'];?>
							<dt><a href="<?php echo IUrl::creatUrl("/site/products/id/$tmp");?>"><img src="<?php echo IUrl::creatUrl("")."";?><?php echo Thumb::get($tmpIMG,88,88);?>" width="88px" height="88px" alt="<?php echo isset($item['data']['name'])?$item['data']['name']:"";?>" /></a></dt>
							<dd><a class="blue" href="<?php echo IUrl::creatUrl("/site/products/id/$tmp");?>"><?php echo isset($item['data']['name'])?$item['data']['name']:"";?></a></dd>

							<input type='hidden' name='goods_id[]' value='<?php echo isset($item['data']['id'])?$item['data']['id']:"";?>' />
							<dd>库存：<?php echo isset($item['data']['store_nums'])?$item['data']['store_nums']:"";?></dd>

							<dd id='summary_show_<?php echo isset($item['id'])?$item['id']:"";?>'><?php echo isset($item['summary'])?$item['summary']:"";?></dd>
							<dd class="blue" id='summary_button_box_<?php echo isset($item['id'])?$item['id']:"";?>'>
								<a class="blue" href='javascript:void(0)' onclick='$("#summary_box_<?php echo isset($item['id'])?$item['id']:"";?>").show();$("#summary_button_box_<?php echo isset($item['id'])?$item['id']:"";?>").hide();'>+更新备注</a>
							</dd>

							<dd class="blue" id='summary_box_<?php echo isset($item['id'])?$item['id']:"";?>' style='display:none'>
								备注：<input type="text" id="summary_val_<?php echo isset($item['id'])?$item['id']:"";?>" />
								<input class="sbtn" type="button" value="提交" onclick="edit_summary(<?php echo isset($item['id'])?$item['id']:"";?>);" />
								<input class="sreset" type="button" value="[取消]" onclick='$("#summary_box_<?php echo isset($item['id'])?$item['id']:"";?>").hide();$("#summary_button_box_<?php echo isset($item['id'])?$item['id']:"";?>").show();' />
							</dd>
						</dl>
					</td>

					<td><?php echo isset($item['time'])?$item['time']:"";?></td>
					<td><span class='red'>￥<?php echo isset($item['data']['sell_price'])?$item['data']['sell_price']:"";?></span></td>
					<td>
						<label class="btn_gray_s"><input type="button" value="加入购物车" onclick="joinCart_list(<?php echo isset($item['data']['id'])?$item['data']['id']:"";?>);" /></span></label><br />
						<label class="btn_gray_s"><input type="button" value="取消收藏" onclick="delModel({link:'<?php echo IUrl::creatUrl("/ucenter/favorite_del/id/$item[id]");?>',msg:'是否取消收藏？'});" /></span></label>
						<div class="msgbox" style="width:350px;display:none;margin:-44px 0 0 -250px;*margin:-10px 0 0 -350px;">
							<div class="msg_t"><a class="close f_r" onclick="$(this).parents('.msgbox').hide();">关闭</a>请选择规格</div>
							<div class="msg_c" id='product_box_<?php echo isset($item['data']['id'])?$item['data']['id']:"";?>'></div>
						</div>
					</td>
				</tr>
				<?php }?>
			</tbody>

			<tfoot>
				<tr>
					<td colspan="5">
						<div class="pages_bar f_r"><?php echo $favoriteObj->getPageBar();?></div>
						<label><input class="radio" type="checkbox" onclick="selectAll('id[]');" />全选</label>
						<label class="btn_gray_s"><input type="button" onclick="$('#favorite').attr('action','<?php echo IUrl::creatUrl("/ucenter/favorite_del");?>');delModel({msg:'是否取消收藏？',form:'favorite'});" value="取消收藏" /></span></label>
					</td>
				</tr>
			</tfoot>

		</table>
	</form>

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
				<%=spectName%>：<%=spectValue%> &nbsp&nbsp
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
//修改备注信息
function edit_summary(idVal)
{
	var summary = $("#summary_val_"+idVal).val();
	if($.trim(summary))
	{
		$.getJSON('<?php echo IUrl::creatUrl("/ucenter/edit_summary");?>',{id:idVal,summary:summary},function(content){
			if(content.isError == false)
			{
				$('#summary_show_'+idVal).html(summary);
				$("#summary_box_"+idVal).hide();$("#summary_button_box_"+idVal).show();
				$('#summary_val_'+idVal).val('');
			}
			else
			{
				alert(content.message);
			}
		});
	}
	else
	{
		alert('请填写备注信息');
	}
}

//统计总数
$('#favoriteSum').html('<?php echo isset($favoriteSum)?$favoriteSum:"";?>');

//[ajax]加入购物车
function joinCart_ajax(id,type)
{
	$.getJSON('<?php echo IUrl::creatUrl("/simple/joinCart");?>',{goods_id:id,type:type},function(content){
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
