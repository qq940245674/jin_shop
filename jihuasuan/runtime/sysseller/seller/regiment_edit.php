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
			<h1 class="site_title"><a href="<?php echo IUrl::creatUrl("/seller/index");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/main/logo.png";?>" /></a></h1>
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

		<h3>营销模块</h3>
		<ul class="toggle">
			<li class="icn_view_users"><a href="<?php echo IUrl::creatUrl("/seller/regiment_list");?>">团购</a></li>
		</ul>

		<h3>信息模块</h3>
		<ul class="toggle">
			<li class="icn_profile"><a href="<?php echo IUrl::creatUrl("/seller/seller_edit");?>">资料修改</a></li>
			<li class="icn_video"><a href="<?php echo IUrl::creatUrl("/site/home/id/$seller_id");?>" target="_blank">主页信息</a></li>
		</ul>

		<footer>
			<hr />
			<p><strong>Copyright &copy; 2014 iWebShop</strong></p>
			<p>Powered by <a href="http://www.aircheng.com">iWebShop</a></p>
		</footer>
	</aside>
	<!--侧边栏菜单 结束-->

	<!--主体内容 开始-->
	<section id="main" class="column">
		<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/my97date/wdatepicker.js"></script>
<?php $seller_id = $this->seller['seller_id']?>

<article class="module width_full">
	<header>
		<h3 class="tabs_involved">团购编辑</h3>
	</header>

	<form action="<?php echo IUrl::creatUrl("/seller/regiment_edit_act");?>"  method="post" name='regiment_edit' enctype='multipart/form-data'>
		<input type='hidden' name='id' />
		<div class="module_content">
			<fieldset>
				<label>团购标题：</label>
				<div class="box">
					<input type='text' name='title' pattern='required' alt='请填写团购标题' />
					<label class="tip">* 填写团购名称</label>
				</div>
			</fieldset>

			<fieldset>
				<label>团购时间：</label>
				<div class="box">
					<input type='text' class="normal" name='start_time' pattern='datetime' onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" alt='请填写一个日期' />
					<input type='text' class="normal" name='end_time' pattern='datetime' onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" alt='请填写一个日期' />
				</div>
				<label class="tip">* 此团购的时间段</label>
			</fieldset>

			<fieldset>
				<label>设置团购商品：</label>
				<div class="box">
					<table class='tablesorter clear'>
						<colgroup>
							<col width="120px" />
							<col />
						</colgroup>

						<input type='hidden' name='goods_id' />

						<tbody id='regiment_box'>
						</tbody>

						<tfoot>
						<tr>
							<td colspan=2>
								<input type='button' class='alt_btn' onclick='searchGoods("<?php echo IUrl::creatUrl("/block/search_goods/type/radio/seller_id/$seller_id");?>",searchGoodsCallback);' value="添加商品" />
								<label class="tip">* 添加要团购的商品</label>
							</td>
						</tr>
						</tfoot>
					</table>
				</div>
			</fieldset>

			<fieldset>
				<label>介绍：</label>
				<div class="box">
					<textarea class='textarea' name='intro'><?php echo isset($this->regimentRow['intro'])?$this->regimentRow['intro']:"";?></textarea>
				</div>
			</fieldset>
		</div>

		<footer>
			<div class="submit_link">
				<input type="submit" class="alt_btn" value="确 定" />
				<input type="reset" value="重 置" />
			</div>
		</footer>
	</form>
</article>

<script type='text/javascript'>
	//输入筛选商品的条件
	function searchGoodsCallback(goodsList)
	{
		goodsList.each(function()
		{
			var temp = $.parseJSON($(this).attr('data'));
			var content = {
				"data":
				{
					"id":temp.goods_id,
					"name":temp.name,
					"img":temp.img,
					"sell_price":temp.sell_price,
					"img":temp.img,
					"store_nums":temp.store_nums
				}
			};
			relationCallBack(content);
		});
	}

	//关联商品回调处理函数
	function relationCallBack(content,regimentImg)
	{
		if(content)
		{
			$('[name="goods_id"]').val(content['data']['id']);
			regimentImg = !regimentImg ? content['data']['img'] : regimentImg;

			var imgUrl = "<?php echo IUrl::creatUrl("")."@url@";?>";
			imgUrl     = imgUrl.replace("@url@",regimentImg);

			var html = '<tr><th>商品名称：</th><td>'+content['data']['name']+'</td></tr>'
					  +'<tr><th>展示图片：</th><td><img src="'+imgUrl+'" title="'+content['data']['name']+'" style="max-width:140px;" /><p><input type="file" class="file" name="img" /></p></td></tr>'
					  +'<tr><th>团购价格：</th><td><input type="text" class="small" name="regiment_price" pattern="float" alt="填写数字" />，  目前原价：'+content['data']['sell_price']+'<label class="tip">* 设置团购价格</label></td></tr>'
					  +'<tr><th>团购最大销售量：</th><td><input type="text" class="small" name="store_nums" pattern="int" alt="填写数字" />，  目前库存：'+content['data']['store_nums']+'<label class="tip">* 团购出售的最大数量，设置空或0则无限制</label></td></tr>'
					  +'<tr><th>团购最小销售量：</th><td><input type="text" class="small" name="least_count" pattern="int" alt="填写数字" />，  目前库存：'+content['data']['store_nums']+'<label class="tip">* 如果最后团购销售量小于此数值，则团购无效，设置空或者0则无限制</label></td></tr>';

			$('#regiment_box').html(html);
		}
	}

	//关联商品信息
	<?php if(isset($this->regimentRow['goodsRow'])){?>
	relationCallBack(<?php echo isset($this->regimentRow['goodsRow'])?$this->regimentRow['goodsRow']:"";?>,"<?php echo isset($this->regimentRow['img'])?$this->regimentRow['img']:"";?>");
	<?php }?>

	//表单回填
	var formObj = new Form('regiment_edit');
	formObj.init(<?php echo JSON::encode($this->regimentRow);?>);
</script>
	</section>
	<!--主题内容 结束-->
</body>
</html>