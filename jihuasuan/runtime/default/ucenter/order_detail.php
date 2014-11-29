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
		<?php $item = $this->order_info;?>
<?php $orderStatus = Order_Class::getOrderStatus($item)?>
<script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/iwebshop/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/artTemplate/area_select.js";?>'></script>
<div class="main f_r" style='width:760px;margin-left:1px;'>
	<div class="uc_title m_10">
		<label class="current"><span>订单详情</span></label>
	</div>
	<div class="prompt_2 m_10">
		<div class="t_part">
			<?php $orderStep = Order_Class::orderStep($item)?>
			<?php foreach($orderStep as $eventTime => $stepData){?>
			<p><?php echo isset($eventTime)?$eventTime:"";?>&nbsp;&nbsp;<span class="black"><?php echo isset($stepData)?$stepData:"";?></span></p>
			<?php }?>
		</div>
		<p>
			<b>订单号：</b><?php echo isset($item['order_no'])?$item['order_no']:"";?>
			<b>下单日期：</b><?php echo isset($item['create_time'])?$item['create_time']:"";?>
			<b>状态：</b>
			<span class="red2">
				<b class="<?php if($orderStatus >= 6){?>green<?php }else{?>orange<?php }?>"><?php echo Order_Class::orderStatusText($orderStatus);?></b>
	        </span>
        </p>

        <form action='<?php echo IUrl::creatUrl("/ucenter/order_status");?>' method='post'>
        <p>
	        <input type="hidden" name="order_id" value="<?php echo isset($item['id'])?$item['id']:"";?>" />
	    	<?php if(in_array($orderStatus,array(1,2))){?>
	        <label class="btn_orange">
	        	<input type="hidden" name='op' value='cancel' />
	        	<input type="submit" value="取消订单" />
	        </label>
	        <?php }?>

			<?php if($orderStatus == 2){?>
			<label class="btn_green">
				<input type="button" value="淘宝已收货好评,点击此处" onclick="return zhifu();" />
			</label>
			<?php }?>

			<?php if($orderStatus == 3){?>
	        <label class="btn_green">
	        	<input type="hidden" name='op' value='confirm' />
	        	<input type="submit" value="确认交易完成" />
	        </label>

			<label class="btn_orange">
				<input type="button" value="快递跟踪" onclick="exdelievey()" />
			</label>
			<?php }?>

	        <?php if($orderStatus == 6){?>
	        <!-- <label class="btn_orange">
	        	<input type="button" value="申请退款" onclick='javascript:window.location.href="<?php echo IUrl::creatUrl("/ucenter/refunds/order_no/$item[order_no]");?>"' />
	        </label> -->
	    	<?php }?>
	    </p>
        </form>

	</div>
	<div class="box m_10">
		<div class="title">
			<h2><span class="orange">收件人信息</span></h2>
			<?php if(in_array($orderStatus,array(1,2))){?>
			<span style="float:right;margin-right:10px">
				<a href="javascript:void(0);" onclick="editForm();">修改</a>
			</span>
			<?php }?>
		</div>

		<!--收获信息展示-->
		<div class="cont clearfix" id="acceptShow">
			<table class="dotted_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<col width="130px" />
				<col />
				<tr>
					<th>收货人：</th>
					<td><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td>
				</tr>
				<tr>
					<th>地址：</th>
					<td><?php echo isset($this->area[$item['province']])?$this->area[$item['province']]:"";?> <?php echo isset($this->area[$item['city']])?$this->area[$item['city']]:"";?> <?php echo isset($this->area[$item['area']])?$this->area[$item['area']]:"";?> <?php echo isset($item['address'])?$item['address']:"";?></td>
				</tr>
				<tr>
					<th>邮编：</th>
					<td><?php echo isset($item['postcode'])?$item['postcode']:"";?></td>
				</tr>
				<tr>
					<th>固定电话：</th>
					<td><?php echo isset($item['telphone'])?$item['telphone']:"";?></td>
				</tr>
				<tr>
					<th>手机号码：</th>
					<td><?php echo isset($item['mobile'])?$item['mobile']:"";?></td>
				</tr>
				<tr>
					<th style="color:#FF3366;">淘宝订单号：</th>
					<td><?php echo isset($item['postscript'])?$item['postscript']:"";?></td>
				</tr>
			</table>
		</div>

		<!--收获信息修改表单-->
		<div class="cont clearfix" id="acceptForm" style="display:none;">
			<form method="post" action="<?php echo IUrl::creatUrl("/ucenter/order_accept");?>" name="modelForm">
				<input type="hidden" name="order_id" value="<?php echo isset($item['id'])?$item['id']:"";?>"/>
				<input type="hidden" name="goods_weight" value=""/>

				<table class="dotted_table f_l" width="100%" cellpadding="0" cellspacing="0">
					<col width="130px" />
					<col />
					<tr>
						<th>收货人：</th>
						<td><input class="normal" type="text" name="accept_name" pattern="required" value="<?php echo isset($item['accept_name'])?$item['accept_name']:"";?>" alt="收货人姓名错误"/><label>收货人姓名</label></td>
					</tr>
					<tr>
						<th>地址地区：</th>
						<td>
							<select name="province" child="city,area" onchange="areaChangeCallback(this);countDelievey();"></select>
							<select name="city" child="area" parent="province" onchange="areaChangeCallback(this);"></select>
							<select name="area" parent="city" pattern="required"></select>
						</td>
					</tr>
					<tr>
						<th>邮编：</th>
						<td><input class="normal" type="text" name="postcode" pattern="zip" value="<?php echo isset($item['postcode'])?$item['postcode']:"";?>" alt="填写正确的邮编"/><label>收货人邮编</label></td>
					</tr>
					<tr>
						<th>地址：</th>
						<td><input class="normal" type="text" name="address" pattern="required" value="<?php echo isset($item['address'])?$item['address']:"";?>" alt="收货地址错误"/><label>收货地址</label></td>
					</tr>
					<tr>
						<th>固定电话：</th>
						<td><input class="normal" type="text" name="telphone" empty pattern="phone" value="<?php echo isset($item['telphone'])?$item['telphone']:"";?>" alt="请输入正确的联系电话"/><label>联系电话</label></td>
					</tr>
					<tr>
						<th>手机号码：</th>
						<td><input class="normal" type="text" name="mobile" empty pattern="mobi" maxlength="11" value="<?php echo isset($item['mobile'])?$item['mobile']:"";?>" alt="手机号码错误"/><lable>手机号码</lable></td>
					</tr>
					<tr>
						<th style='color:#FF3366;'>淘宝订单号:</th>
						<td><input class="normal" type="text" name="postscript" empty pattern="postscript" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="15" value="<?php echo isset($item['postscript'])?$item['postscript']:"";?>" alt="淘宝订单号错误"/></td>
					</tr>
					<tr>
						<th></th><td colspan="2"><label class="btn"><input type="submit" value="保存" /></label></td>
					</tr>
				</table>
			</form>
		</div>
	</div>

	<!--支付和配送-->
	<div class="box m_10">
		<div class="title"><h2><span class="orange">支付及配送方式</span></h2></div>
		<div class="cont clearfix">
			<table class="dotted_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<col width="130px" />
				<col />
				<tr>
					<th>支付方式：</th>
					<td><?php echo isset($this->pay_name)?$this->pay_name:"";?></td>
				</tr>

				<?php if(isset($this->pay_note)){?>
				<tr>
					<th>支付说明：</th>
					<td><?php echo isset($this->pay_note)?$this->pay_note:"";?></td>
				</tr>
				<?php }?>

				<tr>
					<th>运费：</th>
					<td><?php echo isset($item['real_freight'])?$item['real_freight']:"";?></td>
				</tr>
				<tr>
					<th>物流公司：</th>
					<td><?php echo isset($this->deliveryRow['freight_name'])?$this->deliveryRow['freight_name']:"";?></td>
				</tr>
				<tr>
					<th>快递单号：</th>
					<td><?php echo isset($this->deliveryRow['delivery_code'])?$this->deliveryRow['delivery_code']:"";?></td>
				</tr>
			</table>
		</div>
	</div>

    <!--发票信息-->
    <?php if($item['invoice']==1){?>
	<div class="box m_10">
		<div class="title"><h2><span class="orange">发票信息</span></h2></div>
		<div class="cont clearfix">
			<table class="dotted_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<col width="129px" />
				<col />
				<tr>
					<th>所需税金：</th>
					<td><?php echo isset($item['taxes'])?$item['taxes']:"";?></td>
				</tr>
				<tr>
					<th>发票抬头：</th>
					<td><?php echo isset($item['invoice_title'])?$item['invoice_title']:"";?></td>
				</tr>
			</table>
		</div>
	</div>
    <?php }?>

	<!--物品清单-->
	<div class="box m_10">
		<div class="title"><h2><span class="orange">商品清单</span></h2></div>
		<div class="cont clearfix">
			<table class="list_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<th>图片</th>
						<th>商品名称</th>
						<th>赠送积分</th>
						<th>商品价格</th>
						<th>优惠金额</th>
						<th>商品数量</th>
						<th>小计</th>
					</tr>
                    <?php $order_id=$item['id']?>
                    <?php $query = new IQuery("order_goods as og");$query->join = "left join goods as go on og.goods_id = go.id";$query->where = "order_id = $order_id";$query->field = "og.*,go.point";$items = $query->find(); foreach($items as $key => $good){?>
                    <?php $good_info = JSON::decode($good['goods_array'])?>
                    <?php $totalWeight = $good['goods_nums'] * $good['goods_weight']?>
					<tr>
						<td><img class="pro_pic" src="<?php echo IUrl::creatUrl("")."$good[img]";?>" width="50px" height="50px" onerror='this.src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/nopic_100_100.gif";?>"' /></td>
						<td class="t_l">
							<a class="blue" href="<?php echo IUrl::creatUrl("/site/products/id/$good[goods_id]");?>" target='_blank'><?php echo isset($good_info['name'])?$good_info['name']:"";?></a>
							<?php if($good_info['value']!=''){?><p><?php echo isset($good_info['value'])?$good_info['value']:"";?></p><?php }?>
						</td>
						<td><?php echo $good['point']*$good['goods_nums'];?></td>
						<td class="red2">￥<?php echo isset($good['goods_price'])?$good['goods_price']:"";?></td>
						<td class="red2">￥<?php echo $good['goods_price']-$good['real_price'];?></td>
						<td>x <?php echo isset($good['goods_nums'])?$good['goods_nums']:"";?></td>
						<td class="red2 bold">￥<?php echo $good['goods_nums']*$good['real_price'];?></td>
					</tr>
                    <?php }?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="gray_box">
		<div class="t_part">
			<p>商品总金额：￥<?php echo isset($item['real_amount'])?$item['real_amount']:"";?></p>
			<p>+ 运费：￥<label id="freightFee"><?php echo isset($item['real_freight'])?$item['real_freight']:"";?></label></p>

            <?php if($item['taxes'] > 0){?>
            <p>+ 税金：￥<?php echo isset($item['taxes'])?$item['taxes']:"";?></p>
            <?php }?>

            <?php if($item['pay_fee'] > 0){?>
            <p>+ 支付手续费：￥<?php echo isset($item['pay_fee'])?$item['pay_fee']:"";?></p>
            <?php }?>

            <?php if($item['insured'] > 0){?>
            <p>+ 保价：￥<?php echo isset($item['insured'])?$item['insured']:"";?></p>
            <?php }?>

            <p>订单折扣或涨价：￥<?php echo isset($item['discount'])?$item['discount']:"";?></p>

            <?php if($item['promotions'] > 0){?>
            <p>- 促销优惠金额：￥<?php echo isset($item['promotions'])?$item['promotions']:"";?></p>
            <?php }?>
		</div>

		<div class="b_part">
			<p>订单支付金额：<span class="red2">￥<label id="order_amount"><?php echo isset($item['order_amount'])?$item['order_amount']:"";?></label></span></p>
		</div>
	</div>
</div>

<script type="text/javascript">
//DOM加载完毕
$(function(){
	//初始化地域联动
	template.compile("areaTemplate",areaTemplate);
	createAreaSelect('province',0,<?php echo isset($item['province'])?$item['province']:"";?>);
	createAreaSelect('city',<?php echo isset($item['province'])?$item['province']:"";?>,<?php echo isset($item['city'])?$item['city']:"";?>);
	createAreaSelect('area',<?php echo isset($item['city'])?$item['city']:"";?>,<?php echo isset($item['area'])?$item['area']:"";?>);

	//设置商品总重量
	$('[name="goods_weight"]').val(<?php echo isset($totalWeight)?$totalWeight:"";?>);
});

//计算运费
function countDelievey()
{
	
}

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

//快递单跟踪
function exdelievey()
{
	art.dialog.open('<?php echo IUrl::creatUrl("/block/exdelivery");?>',{title:'快递跟踪',width:"820px",height:"420px"});
}

function zhifu(){
	if(confirm("订单号 <?php echo isset($item['postscript'])?$item['postscript']:"";?> 您确定已在淘宝收货了吗?")){
		window.location.href='<?php echo IUrl::creatUrl("/block/doPay/order_id/$item[id]");?>';
	}else{
		return;
	}
}

//修改表单信息
function editForm()
{
	$('#acceptShow').toggle();
	$('#acceptForm').toggle();
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
