<?php 
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
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/iwebshop/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/iwebshop/runtime/_systemjs/artdialog/skins/default.css" />
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/site.js";?>'></script>
</head>
<body class="second">
	<div class="brand_list container_2">
		<div class="header">
			<h1 class="logo"><a title="<?php echo $siteConfig->name;?>" style="background:url(<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/logo.gif";?>);" href="<?php echo IUrl::creatUrl("");?>"><?php echo $siteConfig->name;?></a></h1>
			<ul class="shortcut">
				<li class="first"><a href="<?php echo IUrl::creatUrl("/ucenter/index");?>">我的账户</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/ucenter/order");?>">我的订单</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/simple/seller");?>">申请开店</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/seller/seller");?>">商家管理</a></li>
		   		<li class='last'><a href="<?php echo IUrl::creatUrl("/site/help_list");?>">使用帮助</a></li>
			</ul>
			<p class="loginfo">
			<?php if($this->user){?>
			<span style='color:#FF4254;'><?php echo isset($this->user['username'])?$this->user['username']:"";?></span> 您好，欢迎您来到<?php echo $siteConfig->name;?>购物！[<a href="<?php echo IUrl::creatUrl("/simple/logout");?>" class="reg">安全退出</a>]
			<?php }else{?>
			[<a href="<?php echo IUrl::creatUrl("/simple/login?callback=$callback");?>">登录</a><a class="reg" href="<?php echo IUrl::creatUrl("/simple/reg?callback=$callback");?>">免费注册</a>]
			<?php }?>
			</p>
		</div>
	    <script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/artTemplate/area_select.js";?>'></script>
<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/orderFormClass.js";?>'></script>
<script type='text/javascript'>
//创建订单表单实例
orderFormInstance = new orderFormClass();

//DOM加载完毕
jQuery(function(){
	
	//使用红包按钮
	$('#ticket_a').click(function()
	{
		//第一次打开时生成缓存数据
		if($.trim($('#ticket_show_box').text()) == '')
		{
			var ticketList = <?php echo JSON::encode($this->prop);?>;
			for(var index in ticketList)
			{
				var ticketHtml = template.render('ticketTrTemplate',{item:ticketList[index]});
				$('#ticket_show_box').append(ticketHtml);
			}
		}

		$(this).toggleClass('fold');
		$(this).toggleClass('unfold');
		$('#ticket_box').toggle('slow');
	});

	//初始化地域联动JS模板
	template.compile("areaTemplate",areaTemplate);

	//收货地址数据
	orderFormInstance.addressInit("<?php echo isset($this->defaultAddressId)?$this->defaultAddressId:"";?>");

	//配送方式初始化
	orderFormInstance.deliveryInit("<?php echo isset($this->custom['delivery'])?$this->custom['delivery']:"";?>");

	//设置是否免运费
	orderFormInstance.freeFreight = <?php echo $this->freeFreight ? 1 : 0;?>;

	//支付方式
	orderFormInstance.paymentInit("<?php echo isset($this->custom['payment'])?$this->custom['payment']:"";?>");

	//商品价格
	orderFormInstance.goodsSum = "<?php echo isset($this->final_sum)?$this->final_sum:"";?>";
});

/**
 * 生成地域js联动下拉框
 * @param name
 * @param parent_id
 * @param select_id
 */
function createAreaSelect(name,parent_id,select_id)
{
	//生成地区
	$.getJSON("<?php echo IUrl::creatUrl("/block/area_child");?>",{"aid":parent_id,"random":Math.random()},function(json)
	{
		$('[name="'+name+'"]').html(template.render('areaTemplate',{"select_id":select_id,"data":json}));
	});
}

//[address]保存到常用的收货地址
function address_default_save()
{
	if(orderFormInstance.addressCheck())
	{
		$.getJSON('<?php echo IUrl::creatUrl("/ucenter/address_add");?>',$('form[name="order_form"]').serialize(),function(content){
			if(content.isError == false)
			{
				var addressLiHtml = template.render('addressLiTemplate',{"item":content.data});
				$('.addr_list').prepend(addressLiHtml);
				$('input:radio[name="radio_address"]:first').trigger('click');
			}
			else
			{
				alert(content.message);
			}
		});
	}
}

//[delivery]根据省份地区ajax获取配送方式
function get_delivery(province)
{
	$.getJSON("<?php echo IUrl::creatUrl("/block/order_delivery");?>",{"province":province,"total_weight":"<?php echo isset($this->weight)?$this->weight:"";?>","goodsSum":"<?php echo isset($this->sum)?$this->sum:"";?>"},function(content){

		//清空数据
		$('#deliveryFormTrBox').empty();

		for(var index in content)
		{
			var deliveryTrHtml = template.render('deliveryTrTemplate',{item:content[index]});
			$('#deliveryFormTrBox').append(deliveryTrHtml);
		}

		if($.trim($('#deliveryFormTrBox').text()) == '')
		{
			alert('需要从后台添加配送方式才能下单');
			return;
		}

		//是否选中无法送达的配送方式
		if(orderFormInstance.deliveryActiveId)
		{
			var defaultDeliveryItem = $('input[type="radio"][name="delivery_id"][value="'+orderFormInstance.deliveryActiveId+'"]');
			if(defaultDeliveryItem.length > 0)
			{
				//不能送达省份时
				if(defaultDeliveryItem.attr('disabled'))
				{
					defaultDeliveryItem.attr('checked',false);

					tips('您选择的省份当前的配送方式不能送达！请重新选择配送方式');

					//切换视图方式
					if(orderFormInstance.deliveryMod == 'exit')
					{
						orderFormInstance.deliveryModToggle();
					}
					return;
				}

				defaultDeliveryItem.trigger('click');

				//默认配送方式
				if($('#paymentBox:hidden').length == 1 && orderFormInstance.paytype == 0)
				{
					orderFormInstance.deliverySave();
				}
			}
		}
	});
}

//添加代金券
function add_ticket()
{
	var ticket_num = $('#ticket_num').val();
	var ticket_pwd = $('#ticket_pwd').val();

	if(ticket_num == '' || ticket_pwd == '')
	{
		alert('请填写卡号和密码');
		return '';
	}

	$.getJSON('<?php echo IUrl::creatUrl("/block/add_download_ticket");?>',{"ticket_num":ticket_num,"ticket_pwd":ticket_pwd},function(content){
		if(content.isError == false)
		{
			is_success = true;
			$('[name="ticket_id"]').each(
				function()
				{
					if($(this).val() == content.data.id)
					{
						alert('代金券已经存在，不要重复添加');
						is_success = false;
					}
				}
			);

			if(is_success)
			{
				var ticketHtml = template.render('ticketTrTemplate',{item:content.data});
				$('#ticket_show_box').append(ticketHtml);
				$('[name="ticket_id"]').attr('checked',true);
				$('[name="ticket_id"]:last').trigger('click');
			}
			$('#ticket_num').val('');
			$('#ticket_pwd').val('');
		}
		else
		{
			alert(content.message);
		}
	});
}

//取消红包
function cancel_ticket()
{
	$('#ticket_a').trigger('click');
	$('[name="ticket_id"]').attr('checked',false);
	orderFormInstance.doAccount();
}
</script>

<div class="wrapper clearfix">
	<div class="position mt_10"><span>您当前的位置：</span> <a href="<?php echo IUrl::creatUrl("");?>"> 首页</a> » 填写核对订单信息</div>
	<div class="myshopping m_10">
		<ul class="order_step">
			<li class="current_prev"><span class="first"><a href='<?php if(IReq::get('id')){?>javascript:window.history.go(-1);<?php }else{?><?php echo IUrl::creatUrl("/simple/cart");?><?php }?>'>1、查看购物车</a></span></li>
			<li class="current"><span>2、填写核对订单信息</span></li>
			<li class="last"><span>3、成功提交订单</span></li>
		</ul>
	</div>

	<form action='<?php echo IUrl::creatUrl("/simple/cart3");?>' method='post' name='order_form' callback='orderFormInstance.isSubmit();'>

		<input type='hidden' name='timeKey' value='<?php echo time();?>' />
		<input type='hidden' name='direct_gid' value='<?php echo isset($this->gid)?$this->gid:"";?>' />
		<input type='hidden' name='direct_type' value='<?php echo isset($this->type)?$this->type:"";?>' />
		<input type='hidden' name='direct_num' value='<?php echo isset($this->num)?$this->num:"";?>' />
		<input type='hidden' name='direct_promo' value='<?php echo isset($this->promo)?$this->promo:"";?>' />
		<input type='hidden' name='direct_active_id' value='<?php echo isset($this->active_id)?$this->active_id:"";?>' />

		<div class="cart_box m_10">
			<div class="title">填写核对订单信息</div>
			<div class="cont">

				<!--地址管理 开始-->
				<div class="wrap_box">
					<h3>
						<span class="orange">收货人信息</span>
						<a class="normal f12" href="javascript:void(0)" id="addressToggleButton" onclick="orderFormInstance.addressModToggle();">[退出]</a>
					</h3>

					<!--地址展示 开始-->
					<table class="form_table" id="address_show_box" style='display:none'>
						<col width="120" />
						<col />

						<tbody id="addressShowBox"></tbody>

						<!--收货地址展示模板-->
						<script type='text/html' id='addressShowTemplate'>
						<tr><th>收货人姓名：</th><td><%=accept_name%></td></tr>
						<tr><th>省份：</th><td><%=province_val%> <%=city_val%> <%=area_val%></td></tr>
						<tr><th>地址：</th><td><%=address%></td></tr>
						<tr><th>手机号码：</th><td><%=mobile%></td></tr>
						<tr><th>固定电话：</th><td><%=telphone%></td></tr>
						<tr><th>邮政编码：</th><td><%=zip%></td></tr>
						</script>
					</table>
					<!--地址展示 结束-->

					<!--收货表单信息 开始-->
					<div class="prompt_4 m_10" id='address_often'>
						<strong>常用收货地址</strong>
						<ul class="addr_list">
							<?php foreach($this->addressList as $key => $item){?>
							<li>
								<label><input class="radio" name="radio_address" type="radio" value="<?php echo isset($item['id'])?$item['id']:"";?>" onclick='orderFormInstance.addressSelected(<?php echo JSON::encode($item);?>);' /><?php echo isset($item['accept_name'])?$item['accept_name']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo isset($item['province_val'])?$item['province_val']:"";?> <?php echo isset($item['city_val'])?$item['city_val']:"";?> <?php echo isset($item['area_val'])?$item['area_val']:"";?> <?php echo isset($item['address'])?$item['address']:"";?></label>
							</li>
							<?php }?>
							<li>
								<label><input type='radio' name='radio_address' onclick='orderFormInstance.addressEmpty();' value='' />其他收货地址</label>
							</li>
						</ul>

						<!--收货地址项模板-->
						<script type='text/html' id='addressLiTemplate'>
						<li>
							<label><input class="radio" name="radio_address" type="radio" value="<%=item['id']%>" onclick='orderFormInstance.addressSelected(<%=jsonToString(item)%>);' /><%=item['accept_name']%>&nbsp;&nbsp;&nbsp;&nbsp;<%=item['province_val']%> <%=item['city_val']%> <%=item['area_val']%> <%=item['address']%></label>
						</li>
						</script>
					</div>

					<div class="box" id='address_form'>
						<table class="form_table">
							<col width="90px" />
							<col />

							<tbody>
								<tr>
									<th>收货人姓名：</th><td><input class="normal" type="text" name="accept_name" pattern='required' alt='收件人姓名不能为空' /> <span>(*) 收货人的姓名</span> </td>
								</tr>
								<tr>
									<th>省份：</th>
									<td>
										<select name="province" child="city,area" onchange="areaChangeCallback(this);"></select>
										<select name="city" child="area" parent="province" onchange="areaChangeCallback(this);"></select>
										<select name="area" parent="city" pattern="required" alt="请选择收货地区"></select>
										<span>(*) 收货地区</span>
									</td>
								</tr>
								<tr>
									<th>地址：</th><td><input class="normal" name='address' type="text" alt='格式不正确' pattern='required' /> <span>(*) 收货地址</span></td>
								</tr>
								<tr>
									<th>手机号码：</th><td><input class="middle" name='mobile' type="text" pattern='mobi' alt='格式不正确' /> <span>(*) 收货人的手机号，用于接收发货通知短信及送货前确认</span></td>
								</tr>
								<tr>
									<th>固定电话：</th><td><input class="middle" type="text" pattern='phone' name='telphone' empty alt='格式不正确' /></td>
								</tr>
								<tr>
									<th>邮政编码：</th><td><input class="middle" name='zip' empty type="text" pattern='zip' alt='格式不正确' /></td>
								</tr>
								<?php if($this->user['user_id']){?>
								<tr>
									<th></th><td><a href="javascript:void(0)" onclick="address_default_save();" class="blue">[添加到常用收货地址]</a></td>
								</tr>
								<?php }?>
							</tbody>
						</table>
					</div>
					<!--收货表单信息 结束-->

					<label class="btn_orange3" id='address_save_button'><input type="button" value="保存收货人地址" onclick="orderFormInstance.addressSave();" /></label>
				</div>
				<!--地址管理 结束-->

			<!--配送方式 开始-->
				<div class="wrap_box" id='deliveryBox' style="display:none">
					<h3>
						<span class="orange">配送方式</span>
						<a class="normal f12" href="javascript:void(0)" id='deliveryToggleButton' onclick="orderFormInstance.deliveryModToggle();">[关闭]</a>
					</h3>

					<!--配送展示 开始-->
					<table class="form_table" id="delivery_show_box" style='display:none'>
						<col width="120px" />
						<col />

						<tbody id="deliveryShowBox"></tbody>

						<!--配送方式展示模板-->
						<script type='delivery' id='deliveryShowTemplate'>
						<tr>
							<th>配送方式：</th><td><%=name%></td>
						</tr>
						<tr>
							<th>运费：</th><td>￥<%=price%></td>
						</tr>
						</script>
					</table>
					<!--配送展示 结束-->

					<!--配送修改 开始-->
					<table width="100%" class="border_table m_10" id='delivery_form'>
						<col width="180px" />
						<col />

						<tbody id="deliveryFormTrBox"></tbody>

						<script type='text/html' id='deliveryTrTemplate'>
						<tr>
							<th><label><input type="radio" name="delivery_id" paytype="<%=item['type']%>" alt="<%=item['price']%>" value="<%=item['id']%>" <%if(item['if_delivery'] == 1){%>disabled="disabled" title="无法送达"<%}%> onclick='orderFormInstance.deliverySelected(<%=jsonToString(item)%>);' /><%=item['name']%></label></th>
							<td>
								<%=item['description']%> 运费：￥<%=item['price']%> &nbsp;&nbsp;
								<%if(item['protect_price'] > 0){%>
									<label><input type="checkbox" onclick="orderFormInstance.doAccount();" name="insured" value="<%=item['protect_price']%>" />保价：￥<%=item['protect_price']%></label>
								<%}%>
							</td>
						</tr>
						</script>

						<tfoot>
							<th>指定送货时间：</th>
							<td>
								<label class='attr'><input type='radio' name='accept_time' checked="checked" value='任意' />任意</label>
								<label class='attr'><input type='radio' name='accept_time' value='周一到周五' />周一到周五</label>
								<label class='attr'><input type='radio' name='accept_time' value='周末' />周末</label>
							</td>
						</tfoot>
					</table>
					<!--配送修改 结束-->

					<label class="btn_orange3"><input type="button" id="delivery_save_button" onclick="orderFormInstance.deliverySave();" value="保存配送方式" /></label>
				</div>
				<!--配送方式 结束-->

				<!--支付方式 开始-->
				
				<!--支付方式 结束-->

				<!--淘宝订单号 开始-->
				<div class="wrap_box">
					<h3>
						<span class="orange">淘宝订单号</span>
						<a class="normal f12" href="javascript:void(0)" id='messageToggleButton' onclick="orderFormInstance.messageModToggle();">[修改]</a>
					</h3>

					<table width="100%" class="border_table" id='message_show_box'>
						<col width="120px" />
						<col />
						<tbody>
							<tr>
								<th>淘宝订单号：</th>
								<td id="messageShowBox"></td>
							</tr>
						</tbody>
					</table>

					<table width="100%" class="form_table" id='message_form' style='display:none'>
						<col width="120px" />
						<col />
						<tr>
							<th>淘宝订单号：</th>
							<td><input class="normal" id="taodingdan" type="text" maxlength='15' onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" name='message' /></td>
						</tr>
					</table>

					<label class="btn_orange3" id='message_save_button' style='display:none'><input type="button" onclick="orderFormInstance.messageSave();" value="保存淘宝订单号" /></label>
				</div>
				<!--淘宝订单号 结束-->

				<!--购买清单 开始-->
				<div class="wrap_box">

					<h3><span class="orange">购买的商品</span></h3>

					<div class="cart_prompt f14 t_l m_10" <?php if(empty($this->promotion)){?>style="display:none"<?php }?>>
						<p class="m_10 gray"><b class="orange">恭喜，</b>您的订单已经满足了以下优惠活动！</p>
						<?php foreach($this->promotion as $key => $item){?>
						<p class="indent blue"><?php echo isset($item['plan'])?$item['plan']:"";?>，<?php echo isset($item['info'])?$item['info']:"";?></p>
						<?php }?>
					</div>

					<table width="100%" class="cart_table t_c">
						<col width="115px" />
						<col />
						<col width="85px" />
						<col width="80px" />
						<col width="105px" />
						<col width="80px" />
						<col width="80px" />

						<thead>
							<tr>
								<th>图片</th>
								<th>商品名称</th>
								<th>赠送积分</th>
								<th>单价</th>
								<th>优惠</th>
								<th>数量</th>
								<th class="last">小计</th>
							</tr>
						</thead>

						<tbody>

							<!-- 货品展示 开始-->
							<?php foreach($this->productList as $key => $item){?>
							<?php if(intval(IReq::get('num')) > $item['store_nums'] || intval(IReq::get('num')) < 0){?>
							<?php IError::show(403,'购买的商品数量不正确或者大于库存量');?>
							<?php }?>
							<tr>
								<td><img src="<?php echo IUrl::creatUrl("")."";?><?php echo Thumb::get($item['img'],66,66);?>" width="66px" height="66px" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></td>
								<td class="t_l">
									<a href="<?php echo IUrl::creatUrl("/site/products/id/$item[goods_id]");?>" class="blue"><?php echo isset($item['name'])?$item['name']:"";?></a>
									<p>
									<?php $spec_array=Block::show_spec($item['spec_array']);?>
									<?php foreach($spec_array as $specName => $specValue){?>
										<?php echo isset($specName)?$specName:"";?>：<?php echo isset($specValue)?$specValue:"";?> &nbsp&nbsp
									<?php }?>
									</p>
								</td>
								<td><?php echo isset($item['point'])?$item['point']:"";?></td>
								<td><b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></td>
								<td>减￥<?php echo isset($item['reduce'])?$item['reduce']:"";?></td>
								<td><?php echo isset($item['count'])?$item['count']:"";?></td>
								<td><b class="red2">￥<?php echo isset($item['sum'])?$item['sum']:"";?></b></td>
							</tr>
							<?php }?>
							<!-- 货品展示 结束-->

							<!-- 商品展示 开始-->
							<?php foreach($this->goodsList as $key => $item){?>
							<?php if(intval(IReq::get('num')) > $item['store_nums'] || intval(IReq::get('num')) < 0){?>
							<?php IError::show(403,'购买的商品数量不正确或者大于库存量');?>
							<?php }?>
							<tr>
								<td><img src="<?php echo IUrl::creatUrl("")."";?><?php echo Thumb::get($item['img'],66,66);?>" width="66px" height="66px" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></td>
								<td class="t_l">
									<a href="<?php echo IUrl::creatUrl("/site/products/id/$item[id]");?>" class="blue"><?php echo isset($item['name'])?$item['name']:"";?></a>
								</td>
								<td><?php echo isset($item['point'])?$item['point']:"";?></td>
								<td>￥<b><?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></td>
								<td>减￥<?php echo isset($item['reduce'])?$item['reduce']:"";?></td>
								<td><?php echo isset($item['count'])?$item['count']:"";?></td>
								<td>￥<b class="red2"><?php echo isset($item['sum'])?$item['sum']:"";?></b></td>
							</tr>
							<?php }?>
							<!-- 商品展示 结束-->

						</tbody>
					</table>
				</div>
				<!--购买清单 结束-->

			</div>
		</div>

		<!--金额结算-->
		<div class="cart_box" id='amountBox' style='display:none'>
			<div class="cont_2">
				<strong>结算信息</strong>
				<hr class="dashed" />
				<div class="pink_box gray m_10" style='background:white;'>
					<table width="100%" class="form_table t_l">
						<tr>
							<td class="t_r" style='background:white;'><b class="price f14">应付总额：<span class="red2">￥<b id='final_sum'><?php echo isset($this->final_sum)?$this->final_sum:"";?></b></span>元</b></td>
						</tr>
					</table>
				</div>
				<p class="m_10 t_r"><input type="submit" class="submit_order" /></p>
			</div>
		</div>

	</form>
<script>
	$(document).ready(function(){
		var taodingdan = $("#taodingdan").val();
		$("#messageShowBox").append(taodingdan);
		String.prototype.len = function(){ 
			return this.replace(/[^\x00-\xff]/g, "xx").length; 
		} 
		$(".submit_order").click(function(){
		var taodingdan = $("#taodingdan").val().len();
		if(taodingdan != 15){
			alert('请填写正确的淘宝订单号哦');
			return false;
		}
	});
	});
</script>
</div>
		<?php echo IFilter::stripSlash($siteConfig->site_footer_code);?>
	</div>
</body>
</html>
