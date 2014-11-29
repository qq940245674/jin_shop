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
		<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/editor/kindeditor-min.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/editor/lang/zh_CN.js"></script><script type="text/javascript">window.KindEditor.options.uploadJson = "/iwebshop/pic/upload_json";window.KindEditor.options.fileManagerJson = "/iwebshop/pic/file_manager_json";</script>
<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/my97date/wdatepicker.js"></script>
<?php $swfloadObject = new Swfupload('/seller/goods_img_upload');$swfloadObject->show($this->seller['seller_name'],$this->seller['seller_pwd']);?>
<?php $seller_id = $this->seller['seller_id']?>

<link rel="stylesheet" type="text/css" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.ui/jquery-ui.css";?>" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.ui/jquery.min.js";?>"></script>
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.ui/jquery-ui.js";?>"></script>
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.ui/zhong.js";?>"></script>

<article class="module width_full">
	<header>
		<h3 class="tabs_involved">商品编辑</h3>

		<ul class="tabs" name="menu1">
			<li id="li_1" class="active"><a href="javascript:select_tab('1');">商品信息</a></li>
			<li id="li_2"><a href="javascript:select_tab('2');">描述</a></li>
			<li id="li_3"><a href="javascript:select_tab('3');">SEO优化</a></li>
		</ul>
	</header>

	<form action="<?php echo IUrl::creatUrl("/seller/goods_update");?>" name="goodsForm" method="post">
		<input type="hidden" name="id" value="" />
		<input type='hidden' name="img" value="" />
		<input type='hidden' name="_imgList" value="" />
		<input type='hidden' name="callback" value="<?php echo IUrl::getRefRoute();?>" />

		<!--商品信息 开始-->
		<div class="module_content" id="table_box_1">
			<fieldset>
				<label>商品名称</label>
				<input name="name" type="text" value="" initmsg="商品名称填写正确" pattern="required" alt="商品名称不能为空" />
			</fieldset>

			<fieldset>
				<label>关键词</label>
				<input type='text' name='search_words' value='' />
				<label class="tip">每个关键词最长为15个字符，超过后系统不予存储，每个词以逗号分隔</label>
			</fieldset>
			
			<fieldset>
				<label>淘宝宝贝地址</label>
				<input type='text' name='tao_url' value='' pattern="required" alt="宝贝地址不能为空" />
				<label class="tip">此处务必填入您淘宝宝贝的地址URL，否则顾客买不到您的宝贝</label>
			</fieldset>
			<fieldset>
				<label>淘宝店铺地址</label>
				<input type='text' name='shop_url' value='' pattern="required" alt="店铺地址不能为空" />
				<label class="tip">此处可填入您的淘宝店铺的地址，方便更多顾客光临您的店铺</label>
			</fieldset>
			<fieldset>
				<label>抢购到期时间</label>
				<input type="text" name = "date" id="date" />
			</fieldset>
			<fieldset>
				<label>返利金额</label>
				<input type='text' name='fan_money'  pattern="int" value='' />
				<label class="tip">此处填写返利金额，如：淘宝2000的商品，此处填写200，买家以2000元在淘宝购买后，您将返200元给买家。</label>
			</fieldset>
			<fieldset>
				<label>所属分类</label>

				<?php if(isset($this->category) && $this->category){?>
				<ul class="select">
					<?php foreach($this->category as $key => $item){?>
					<li><input type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" name="_goods_category[]" /><?php echo isset($item['name'])?$item['name']:"";?></li>
					<?php }?>
				</ul>
				<?php }else{?>
				<label class="tip">系统暂无商品分类</label>
				<?php }?>
			</fieldset>

			<fieldset>
				<label>商品排序</label>
				<input name="sort" type="text" pattern="int" value="99" disabled />
			</fieldset>

			<fieldset>
				<label>计量单位显示</label>
				<input name="unit" type="text" value="千克"/>
			</fieldset>

			<fieldset>
				<label>基本数据</label>
				<table class="tablesorter clear">
					<thead id="goodsBaseHead"></thead>
					<tbody id="goodsBaseBody"></tbody>

					<!--商品标题模板-->
					<script id="goodsHeadTemplate" type='text/html'>
					<tr>
						<th>商品货号</th>
						<%var isProduct = false;%>
						<%for(var item in templateData){%>
						<%isProduct = true;%>
						<th><%=templateData[item]['name']%></th>
						<%}%>
						<th>库存</th>
						<th>市场价格</th>
						<th>销售价格</th>
						<th>成本价格</th>
						<th>重量(克)</th>
						<%if(isProduct == true){%>
						<th>操作</th>
						<%}%>
					</tr>
					</script>

					<!--商品内容模板-->
					<script id="goodsRowTemplate" type="text/html">
					<%var i=0;%>
					<%for(var item in templateData){%>
					<%item = templateData[item]%>
					<tr>
						<td><input class="small" name="_goods_no[<%=i%>]" pattern="required" type="text" value="<%=item['goods_no'] ? item['goods_no'] : item['products_no']%>" /></td>
						<%var isProduct = false;%>
						<%var specArrayList = parseJSON(item['spec_array'])%>
						<%for(var result in specArrayList){%>
						<%result = specArrayList[result]%>
						<input type='hidden' name="_spec_array[<%=i%>][]" value='{"id":"<%=result.id%>","type":"<%=result.type%>","value":"<%=result.value%>","name":"<%=result.name%>"}' />
						<%isProduct = true;%>
						<td>
							<%if(result['type'] == 1){%>
								<%=result['value']%>
							<%}else{%>
								<img class="img_border" width="30px" height="30px" src="<?php echo IUrl::creatUrl("")."<%=result['value']%>";?>">
							<%}%>
						</td>
						<%}%>
						<td><input class="tiny" name="_store_nums[<%=i%>]" type="text" pattern="required" value="<%=item['store_nums']?item['store_nums']:100%>" /></td>
						<td><input class="tiny" name="_market_price[<%=i%>]" type="text" pattern="float" value="<%=item['market_price']%>" /></td>
						<td><input class="tiny" name="_sell_price[<%=i%>]" type="text" pattern="required" value="<%=item['sell_price']%>" /></td>
						<td><input class="tiny" name="_cost_price[<%=i%>]" type="text" pattern="float" empty value="<%=item['cost_price']%>" /></td>
						<td><input class="tiny" name="_weight[<%=i%>]" type="text" pattern="float" empty value="<%=item['weight']%>" /></td>
						<%if(isProduct == true){%>
						<td><a href="javascript:void(0)" onclick="delProduct(this);"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/main/icn_trash.png";?>" alt="删除" /></a></td>
						<%}%>
					</tr>
					<%i++;%>
					<%}%>
					</script>
				</table>
			</fieldset>

		<!-- 	<fieldset>
				<label>规格</label>
				<div class="box">
					<input type="button" onclick="selSpec()" value="添加规格" />
				</div>
			</fieldset>
		
			<fieldset>
				<label>商品模型</label>
				<select name="model_id" onchange="create_attr(this.value)">
					<option value="0">通用类型 </option>
					<?php $query = new IQuery("model");$items = $query->find(); foreach($items as $key => $item){?>
					<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></option>
					<?php }?>
				</select>
			</fieldset>
		
		
			<fieldset id="properties" style="display:none">
				<label>扩展属性</label>
				<table class="tablesorter clear" id="propert_table">
				</table>

				<!--商品属性模板 开始-->
				<script type='text/html' id='propertiesTemplate'>
				<%for(var item in templateData){%>
				<%item = templateData[item]%>
				<%var valueItems = item['value'].split(',');%>
				<tr>
					<td>
						<%=item["name"]%>：
						<%if(item['type'] == 1){%>
							<%for(var tempVal in valueItems){%>
							<%tempVal = valueItems[tempVal]%>
								<input type="radio" name="attr_id_<%=item['id']%>" value="<%=tempVal%>" /><%=tempVal%>
							<%}%>
						<%}else if(item['type'] == 2){%>
							<%for(var tempVal in valueItems){%>
							<%tempVal = valueItems[tempVal]%>
								<input type="checkbox" name="attr_id_<%=item['id']%>[]" value="<%=tempVal%>"/><%=tempVal%>
							<%}%>
						<%}else if(item['type'] == 3){%>
							<select name="attr_id_<%=item['id']%>">
							<%for(var tempVal in valueItems){%>
							<%tempVal = valueItems[tempVal]%>
							<option value="<%=tempVal%>"><%=tempVal%></option>
							<%}%>
							</select>
						<%}%>
					</td>
				</tr>
				<%}%>
				</script>
				<!--商品属性模板 结束-->
			</fieldset>

			<!-- <fieldset>
				<label>商品品牌</label>
				<select name="brand_id">
					<option value="0">请选择</option>
					<?php $query = new IQuery("brand");$items = $query->find(); foreach($items as $key => $item){?>
					<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></option>
					<?php }?>
				</select>
			</fieldset> -->
			
			
			<fieldset>
				<label>商品状态</label>
				<div class="box">
					<input type='radio' name='is_del' value='3' checked="checked" />申请上架
					<input type='radio' name='is_del' value='2' />下架
				</div>
			</fieldset>

			<fieldset>
				<label>商品首页展示图片</label>
				<div class="box upload_btn">
					<span id='uploadButton'></span>
				</div>
				<label class="tip">可以上传多张图片，图片规格必须是800X800或者400X400，大小不得超过<?php echo IUpload::getMaxSize();?></label>

				<div class="box" id="divFileProgressContainer" style="margin-bottom:10px;"></div>
				<div class="box" id="thumbnails"></div>

				<!--图片模板-->
				<script type='text/html' id='picTemplate'>
				<span class='pic'>
					<img onclick="defaultImage(this);" style="margin:5px; opacity:1;width:100px;height:100px" src="<?php echo IUrl::creatUrl("")."<%=picRoot%>";?>" alt="<%=picRoot%>" /><br />
					<a href='javascript:void(0)' onclick="$(this).parent().remove();">删除</a>
				</span>
				</script>
			</fieldset>
		</div>
		<!--商品信息 结束-->

		<!--商品描述 开始-->
		<div class="module_content" id="table_box_2" style="display:none;">
			<fieldset>
				<label>产品描述</label>
				<div class="clear" style="width:98%;margin:10px 10px;">
					<textarea id="content" name="content" style="width:100%;height:400px;"></textarea>
				</div>
			</fieldset>
		</div>
		<!--商品描述 结束-->

		<!--SEO 开始-->
		<div class="module_content" id="table_box_3" style="display:none;">
			<fieldset>
				<label>SEO关键词</label>
				<input name="keywords" type="text" value="" />
			</fieldset>

			<fieldset>
				<label>SEO描述</label>
				<textarea name="description" style="height:200px;"></textarea>
			</fieldset>
		</div>
		<!--SEO 结束-->

		<footer>
			<div class="submit_link">
				<input type="submit" class="alt_btn" value="确 定" onclick="return checkForm()" />
				<input type="reset" value="重 置" />
			</div>
		</footer>
	</form>

</article>

<script language="javascript">
//创建表单实例
var formObj = new Form('goodsForm');

//默认货号
var defaultProductNo = '<?php echo goods_class::createGoodsNo();?>';

$(function()
{
	initProductTable();

	//存在商品信息
	<?php if(isset($form)){?>
	var goods = <?php echo JSON::encode($form);?>;

	var goodsRowHtml = template.render('goodsRowTemplate',{'templateData':[goods]});
	$('#goodsBaseBody').html(goodsRowHtml);

	formObj.init(goods);

	//模型选择
	$('[name="model_id"]').change();
	<?php }else{?>
	$('[name="_goods_no[0]"]').val(defaultProductNo);
	<?php }?>

	//存在货品信息,进行数据填充
	<?php if(isset($product)){?>
	var spec_array = <?php echo $product[0]['spec_array'];?>;
	var product    = <?php echo JSON::encode($product);?>;

	var goodsHeadHtml = template.render('goodsHeadTemplate',{'templateData':spec_array});
	$('#goodsBaseHead').html(goodsHeadHtml);

	var goodsRowHtml = template.render('goodsRowTemplate',{'templateData':product});
	$('#goodsBaseBody').html(goodsRowHtml);
	<?php }?>

	//商品分类回填
	<?php if(isset($goods_category)){?>
	formObj.setValue('_goods_category[]',"<?php echo join(';',$goods_category);?>");
	<?php }?>

	//商品图片的回填
	<?php if(isset($goods_photo)){?>
	var goodsPhoto = <?php echo JSON::encode($goods_photo);?>;
	for(var item in goodsPhoto)
	{
		var picHtml = template.render('picTemplate',{'picRoot':goodsPhoto[item].img});
		$('#thumbnails').append(picHtml);
	}
	<?php }?>

	//商品默认图片
	<?php if(isset($form['img']) && $form['img']){?>
	$('#thumbnails img[alt="<?php echo $form['img'];?>"]').addClass('current');
	<?php }?>

	//编辑器载入
	KindEditor.ready(function(K){
		K.create('#content');
	});
});

//初始化货品表格
function initProductTable()
{
	//默认产生一条商品标题空挡
	var goodsHeadHtml = template.render('goodsHeadTemplate',{'templateData':[]});
	$('#goodsBaseHead').html(goodsHeadHtml);

	//默认产生一条商品空挡
	var goodsRowHtml = template.render('goodsRowTemplate',{'templateData':[[]]});
	$('#goodsBaseBody').html(goodsRowHtml);
}

//删除货品
function delProduct(_self)
{
	$(_self).parent().parent().remove();
	if($('#goodsBaseBody tr').length == 0)
	{
		initProductTable();
	}
}

//提交表单前的检查
function checkForm()
{
	//整理商品图片
	var goodsPhoto = [];
	$('#thumbnails img').each(function(){
		goodsPhoto.push(this.alt);
	});
	if(goodsPhoto.length > 0)
	{
		$('input[name="_imgList"]').val(goodsPhoto.join(','));
		$('input[name="img"]').val($('#thumbnails img[class="current"]').attr('alt'));
	}
	return true;
}

//tab标签切换
function select_tab(curr_tab)
{
	$("form[name='goodsForm'] > div").hide();
	$("#table_box_"+curr_tab).show();
	$("ul[name=menu1] > li").removeClass('active');
	$('#li_'+curr_tab).addClass('active');
}

//添加规格
function selSpec()
{
	//货品是否已经存在
	if($('input:hidden[name^="_spec_array"]').length > 0)
	{
		alert('当前货品已经存在，无法进行规格设置。<p>如果需要重新设置规格请您手动删除当前货品</p>');
		return;
	}

	var tempUrl = '<?php echo IUrl::creatUrl("/goods/search_spec/model_id/@model_id@/goods_id/@goods_id@/seller_id/$seller_id");?>';
	var model_id = $('[name="model_id"]').val();
	var goods_id = $('[name="id"]').val();

	tempUrl = tempUrl.replace('@model_id@',model_id);
	tempUrl = tempUrl.replace('@goods_id@',goods_id);

	art.dialog.open(tempUrl,{
		title:'设置商品的规格',
		okVal:'保存',
		ok:function(iframeWin, topWin)
		{
			//添加的规格
			var addSpecObject = $(iframeWin.document).find('[id^="vertical_"]');
			if(addSpecObject.length == 0)
			{
				initProductTable();
				return;
			}

			//开始遍历规格
			var specValueData = {};
			var specData      = {};
			addSpecObject.each(function()
			{
				$(this).find('input:hidden[name="specJson"]').each(function()
				{
					var json = $.parseJSON(this.value);
					if(!specValueData[json.id])
					{
						specData[json.id]      = {'id':json.id,'name':json.name,'type':json.type};
						specValueData[json.id] = [];
					}
					specValueData[json.id].push(json['value']);
				});
			});

			//生成货品的笛卡尔积
			var specMaxData = descartes(specValueData,specData);

			//从表单中获取默认商品数据
			var productJson = {};
			$('#goodsBaseBody tr:first').find('input[type="text"]').each(function(){
				productJson[this.name.replace(/^_(\w+)\[\d+\]/g,"$1")] = this.value;
			});

			//生成最终的货品数据
			var productList = [];
			for(var i = 0;i < specMaxData.length;i++)
			{
				var productItem = {};
				for(var index in productJson)
				{
					//自动组建货品号
					if(index == 'goods_no')
					{
						//值为空时设置默认货号
						if(productJson[index] == '')
						{
							productJson[index] = defaultProductNo;
						}

						if(productJson[index].match(/(?:\-\d*)$/) == null)
						{
							//正常货号生成
							productItem['goods_no'] = productJson[index]+'-'+(i+1);
						}
						else
						{
							//货号已经存在则替换
							productItem['goods_no'] = productJson[index].replace(/(?:\-\d*)$/,'-'+(i+1));
						}
					}
					else
					{
						productItem[index] = productJson[index];
					}
				}
				productItem['spec_array'] = specMaxData[i];
				productList.push(productItem);
			}

			//创建规格标题
			var goodsHeadHtml = template.render('goodsHeadTemplate',{'templateData':specData});
			$('#goodsBaseHead').html(goodsHeadHtml);

			//创建货品数据表格
			var goodsRowHtml = template.render('goodsRowTemplate',{'templateData':productList});
			$('#goodsBaseBody').html(goodsRowHtml);
		}
	});
}

//笛卡儿积组合
function descartes(list,specData)
{
	//parent上一级索引;count指针计数
	var point  = {};

	var result = [];
	var pIndex = null;
	var tempCount = 0;
	var temp   = [];

	//根据参数列生成指针对象
	for(var index in list)
	{
		if(typeof list[index] == 'object')
		{
			point[index] = {'parent':pIndex,'count':0}
			pIndex = index;
		}
	}

	//单维度数据结构直接返回
	if(pIndex == null)
	{
		return list;
	}

	//动态生成笛卡尔积
	while(true)
	{
		for(var index in list)
		{
			tempCount = point[index]['count'];
			temp.push({"id":specData[index].id,"type":specData[index].type,"name":specData[index].name,"value":list[index][tempCount]});
		}

		//压入结果数组
		result.push(temp);
		temp = [];

		//检查指针最大值问题
		while(true)
		{
			if(point[index]['count']+1 >= list[index].length)
			{
				point[index]['count'] = 0;
				pIndex = point[index]['parent'];
				if(pIndex == null)
				{
					return result;
				}

				//赋值parent进行再次检查
				index = pIndex;
			}
			else
			{
				point[index]['count']++;
				break;
			}
		}
	}
}

//根据模型动态生成扩展属性
function create_attr(model_id)
{
	$.getJSON("<?php echo IUrl::creatUrl("/block/attribute_init");?>",{'model_id':model_id}, function(json)
	{
		if(json && json.length > 0)
		{
			var templateHtml = template.render('propertiesTemplate',{'templateData':json});
			$('#propert_table').html(templateHtml);
			$('#properties').show();

			//表单回填设置项
			<?php if(isset($goods_attr)){?>
			<?php $attrArray = array();?>
			<?php foreach($goods_attr as $key => $item){?>
			<?php $valArray = explode(',',$item);?>
			<?php $attrArray[] = '"attr_id_'.$key.'[]":"'.join(";",$valArray).'"'?>
			<?php $attrArray[] = '"attr_id_'.$key.'":"'.join(";",$valArray).'"'?>
			<?php }?>
			formObj.init({<?php echo join(',',$attrArray);?>});
			<?php }?>
		}
		else
		{
			$('#properties').hide();
		}
	});
}

/**
 * 图片上传回调,handers.js回调
 * @param picJson => {'flag','img','list','show'}
 */
function uploadPicCallback(picJson)
{
	var picHtml = template.render('picTemplate',{'picRoot':picJson.img});
	$('#thumbnails').append(picHtml);

	//默认设置第一个为默认图片
	if($('#thumbnails img[class="current"]').length == 0)
	{
		$('#thumbnails img:first').addClass('current');
	}
}

/**
 * 设置商品默认图片
 */
function defaultImage(_self)
{
	$('#thumbnails img').removeClass('current');
	$(_self).addClass('current');
}

$(function() {  
	$.datepicker.setDefaults($.datepicker.regional['zh-CN']);
	$("#date").datepicker($.datepicker.regional['zh-CN']);
	$('#date').datepicker('option', $.datepicker.regional['zh-CN']);
 });  

</script>

	</section>
	<!--主题内容 结束-->
</body>
</html>