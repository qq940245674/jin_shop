jQuery(function(){
	//高度自适应
	initLayout();
	$(window).resize(function()
	{
		initLayout();
	});
	function initLayout()
	{
		var h1 = document.documentElement.clientHeight - $("#header").outerHeight(true) - $("#info_bar").height();
		var h2 = h1 - $(".headbar").height() - $(".pages_bar").height() - 30;
		$('#admin_left').height(h1);
		$('#admin_right .content').height(h2);
	}
	//一级菜单切换
	$("#menu ul li:first-child").addClass("first");
	$("#menu ul li:last-child").addClass("last");
	$("[name='menu']>li").click(function(){
		$(this).siblings().removeClass("selected");
        $(this).addClass("selected");
	});
	//二级菜单展示效果
	$("ul.submenu>li>span").toggle(
		function(){
			$(this).next().css("display","none");
			$(this).addClass("selected");
		},
		function(){
			$(this).next().css("display","");
			$(this).removeClass("selected");
		}
	);
	//文字滚动显示
	$("#tips a:not(:first)").css("display","none");
	var tips_l=$("#tips a:last");
	var tips_f=$("#tips a:first");
	setInterval(function()
	{
		if($("#tips").children().length	!= 1){
			if(tips_l.is(":visible")){
				tips_f.fadeIn(500);
				tips_l.hide()
			}else{
				$("#tips a:visible").addClass("now");
				$("#tips a.now").next().fadeIn(500);
				$("#tips a.now").hide().removeClass("now");
			}
		}
	},3000);
	//搜索
	var sch_val = "输入商铺名称";
	$(".search>input.text").blur(
		function(){
			if($(this).val()==''){
				$(this).val(sch_val);
			}
		}
	).click(
		function(){
			if($(this).val()==sch_val){
				$(this).val('');
			}
		}
	);
	//关闭侧边栏
	$("#separator").click(function(){
		document.body.className = (document.body.className == "folden") ? "":"folden";
	});
});