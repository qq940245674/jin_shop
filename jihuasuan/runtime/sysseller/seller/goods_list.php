<?php $seller_id = $this->seller['seller_id'];$seller_name = $this->seller['seller_name'];?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>商家管理后台</title>
	<link type="image/x-icon" href="favicon.ico" rel="icon">
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/iwebshop/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/iwebshop/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/ie.css";?>" type="text/css" media="screen" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" type="text/css" media="screen" />
</head>

<body>
	<!--头部 开始-->
	<header id="header">
		<hgroup>
			<h1 class="site_title"></h1>
			<h2 class="section_title"></h2>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("");?>" target="_blank">网站首页</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("/site/home/id/$seller_id");?>" target="_blank">商家主页</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("/systemseller/logout");?>" target="_blank">退出登录</a></div>
		</hgroup>
	</header>
	<!--头部 结束-->

	<!--面包屑导航 开始-->
	<section id="secondary_bar">
		<div class="user">
			<p><?php echo isset($seller_name)?$seller_name:"";?></p>
		</div>
	</section>
	<!--面包屑导航 结束-->

	<!--侧边栏菜单 开始-->
	<aside id="sidebar" class="column">
		<h3>统计结算模块</h3>
		<ul class="toggle">
			<li class="icn_tags"><a href="<?php echo IUrl::creatUrl("/seller/index");?>">管理首页</a></li>
			<li class="icn_settings"><a href="<?php echo IUrl::creatUrl("/seller/account");?>">销售额统计</a></li>
			<li class="icn_categories"><a href="<?php echo IUrl::creatUrl("/seller/order_goods_list");?>">货款明细</a></li>
			<!-- <li class="icn_photo"><a href="<?php echo IUrl::creatUrl("/seller/bill_list");?>">货款结算单列表</a></li> -->
		</ul>

		<h3>商品模块</h3>
		<ul class="toggle">
			<li class="icn_categories"><a href="<?php echo IUrl::creatUrl("/seller/goods_list");?>">商品列表</a></li>
			<li class="icn_new_article"><a href="<?php echo IUrl::creatUrl("/seller/goods_edit");?>">添加商品</a></li>
			<li class="icn_audio"><a href="<?php echo IUrl::creatUrl("/seller/refer_list");?>">商品咨询</a></li>
		<!-- 	<li class="icn_categories"><a href="<?php echo IUrl::creatUrl("/seller/spec_list");?>">规格列表</a></li> -->
		</ul>

		<h3>订单模块</h3>
		<ul class="toggle">
			<li class="icn_categories"><a href="<?php echo IUrl::creatUrl("/seller/order_list");?>">订单列表</a></li>
		</ul>

	<!-- 	<h3>营销模块</h3>
		<ul class="toggle">
			<li class="icn_view_users"><a href="<?php echo IUrl::creatUrl("/seller/regiment_list");?>">团购</a></li>
		</ul> -->

		<h3>信息模块</h3>
		<ul class="toggle">
			<li class="icn_profile"><a href="<?php echo IUrl::creatUrl("/seller/seller_edit");?>">资料修改</a></li>
			<li class="icn_video"><a href="<?php echo IUrl::creatUrl("/site/home/id/$seller_id");?>" target="_blank">主页信息</a></li>
		</ul>

		<footer>
			<hr />
			<p><strong>Copyright &copy; 2014 集划算</strong></p>
			<p>Powered by <a href="http://www.jihuasuan.com">集划算</a></p>
		</footer>
	</aside>
	<!--侧边栏菜单 结束-->

	<!--主体内容 开始-->
	<section id="main" class="column">
		<article class="module width_full">
	<header>
		<h3 class="tabs_involved">商品列表</h3>
		<ul class="tabs">
			<li><input type="button" class="alt_btn" onclick="filterResult();" value="检索" /></li>
			<li><input type="button" class="alt_btn" onclick="window.location.href='<?php echo IUrl::creatUrl("/seller/goods_edit");?>';" value="添加商品" /></li>
			<li><input type="button" class="alt_btn" onclick="selectAll('id[]');" value="全选" /></li>
			<li><input type="button" class="alt_btn" onclick="goods_del();" value="批量删除" /></li>
			<li><input type="button" class="alt_btn" onclick="goods_status(2);" value="批量下架" /></li>
			<li><input type="button" class="alt_btn" onclick="goods_status(3);" value="批量审核" /></li>
		</ul>
	</header>

	<form action="<?php echo IUrl::creatUrl("/goods/goods_del");?>" method="post" name="goodsForm">
		<table class="tablesorter" cellspacing="0">
			<colgroup>
				<col width="25px" />
				<col />
				<col width="150px" />
				<col width="70px" />
				<col width="70px" />
				<col width="70px" />
				<col width="70px" />
				<col width="80px" />
			</colgroup>

			<thead>
				<tr>
					<th class="header"></th>
					<th class="header">商品名字</th>
					<th class="header">分类</th>
					<th class="header">销售价</th>
					<th class="header">库存</th>
					<th class="header">状态</th>
					<th class="header">排序</th>
					<th class="header">操作</th>
				</tr>
			</thead>

			<tbody>
				<?php $seller_id = $this->seller['seller_id']?>
				<?php $page = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1?>
				<?php $condition = IReq::get('search');$where = '';?>

				<?php if($condition){?>
					<?php foreach($condition as $key => $item){?>
					<?php if($item !== ""){?>
						<?php if($key == "go.store_nums"){?>
						<?php $where .= ' and '.$key.$item?>
						<?php }else{?>
						<?php $where .= ' and '.$key.'"'.$item.'"'?>
						<?php }?>
					<?php }?>
					<?php }?>
				<?php }?>

				<?php $goodsObject = new IQuery("goods as go");$goodsObject->join = "left join category_extend as ce on ce.goods_id = go.id";$goodsObject->where = "go.seller_id = $seller_id $where";$goodsObject->page = "$page";$goodsObject->fields = "distinct go.id, go.*";$items = $goodsObject->find(); foreach($items as $key => $item){?>
				<tr>
					<td><input name="id[]" type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" /></td>
					<td><img src='<?php echo IUrl::creatUrl("")."$item[img]";?>' class="ico" /><a href="javascript:jumpUrl('<?php echo isset($item['is_del'])?$item['is_del']:"";?>','<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>')" title="<?php echo isset($item['name'])?$item['name']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a></td>
					<td>
						<?php $catName = array()?>
						<?php $query = new IQuery("category_extend as ce");$query->join = "left join category as cd on cd.id = ce.category_id";$query->fields = "cd.name";$query->where = "goods_id = $item[id]";$items = $query->find(); foreach($items as $key => $catData){?>
							<?php $catName[] = $catData['name']?>
						<?php }?>
						<?php echo join(',',$catName);?>
					</td>
					<td><?php echo isset($item['sell_price'])?$item['sell_price']:"";?></td>
					<td><?php echo isset($item['store_nums'])?$item['store_nums']:"";?></td>
					<td class="<?php echo $item['is_del']==0 ? "green":"red";?>"><?php echo goods_class::statusText($item['is_del']);?></td>
					<td><input class="tiny" type="text" value="<?php echo isset($item['sort'])?$item['sort']:"";?>" onchange="changeSort(<?php echo isset($item['id'])?$item['id']:"";?>,this);" /></td>
					<td>
						<a href="<?php echo IUrl::creatUrl("/seller/goods_edit/id/$item[id]");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/main/icn_edit.png";?>" title="编辑" /></a>
						<a href="javascript:delModel({link:'<?php echo IUrl::creatUrl("/seller/goods_del/id/$item[id]");?>'})"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/main/icn_del.png";?>" title="删除" /></a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</form>
	<?php echo $goodsObject->getPageBar();?>
</article>

<script type="text/html" id="filterTemplate">
<form action="<?php echo IUrl::creatUrl("/");?>" method="get" name="filterForm">
	<input type='hidden' name='controller' value='seller' />
	<input type='hidden' name='action' value='goods_list' />

	<div class="module_content">
		<fieldset>
			<label>商品名称</label>
			<input name="search[go.name=]" value="" type="text" />
		</fieldset>

		<fieldset>
			<label>商品货号</label>
			<input name="search[go.goods_no=]" value="" type="text" />
		</fieldset>

		<fieldset>
			<label>商品分类</label>
			<select name="search[ce.category_id=]">
			<option value="">不限</option>
			<?php $query = new IQuery("category");$query->order = "sort asc";$items = $query->find(); foreach($items as $key => $item){?>
			<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></option>
			<?php }?>
			</select>
		</fieldset>

		<fieldset>
			<label>商品状态</label>
			<select name="search[go.is_del=]">
			<option value="">不限</option>
			<option value="0">上架</option>
			<option value="2">下架</option>
			<option value="3">待审</option>
			</select>
		</fieldset>

		<fieldset>
			<label>商品库存</label>
			<select name="search[go.store_nums]">
				<option value="">选择库存</option>
				<option value="<1">无货</option>
				<option value=">=1 and go.store_nums<10">低于10</option>
				<option value="<=100 and go.store_nums>=10">10-100</option>
				<option value=">=100">100以上</option>
			</select>
		</fieldset>
	</div>
</form>
</script>

<script type="text/javascript">
//检索商品
function filterResult()
{
	var goodsHeadHtml = template.render('filterTemplate');
	art.dialog(
	{
		"init":function()
		{
			var filterPost = <?php echo JSON::encode(IReq::get('search'));?>;
			var formObj = new Form('filterForm');
			for(var index in filterPost)
			{
				formObj.setValue("search["+index+"]",filterPost[index]);
			}
		},
		"content":goodsHeadHtml,
		"okVal":"立即检索",
		"ok":function(iframeWin, topWin)
		{
			iframeWin.document.forms[0].submit();
		}
	});
}

//删除
function goods_del()
{
	var checkNum = $('input:checkbox[name="id[]"]:checked').length;
	if(checkNum > 0)
	{
		$("form[name='goodsForm']").attr('action',"<?php echo IUrl::creatUrl("/seller/goods_del");?>");
		confirm('确定要删除所选中的商品吗？','formSubmit(\'goodsForm\')');
	}
	else
	{
		alert('请选择要删除的商品');
		return false;
	}
}

//商品状态修改
function goods_status(is_del)
{
	var checkNum = $('input:checkbox[name="id[]"]:checked').length;
	if(checkNum > 0)
	{
		var postUrl = "<?php echo IUrl::creatUrl("/seller/goods_status/is_del/@is_del@");?>";
		postUrl = postUrl.replace("@is_del@",is_del);
		$("form[name='goodsForm']").attr('action',postUrl);
		confirm('确定要修改所选中的商品吗？','formSubmit(\'goodsForm\')');
	}
	else
	{
		alert('请选择要修改的商品');
		return false;
	}
}

//修改排序
function changeSort(gid,obj)
{
	var selectedValue = obj.value;
	$.getJSON("<?php echo IUrl::creatUrl("/seller/ajax_sort");?>",{"id":gid,"sort":selectedValue});
}

//商品详情的跳转连接
function jumpUrl(is_del,url)
{
	is_del == 0 ? window.open(url) : alert("该商品没有上架无法查看");
}
</script>
	</section>
	<!--主题内容 结束-->
</body>
</html>