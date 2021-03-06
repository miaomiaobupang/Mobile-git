<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>超级医生</title>
	<link rel="stylesheet" href="/Mobile/Public/Mobile/css/bootstrap.min.css">
	<link rel="stylesheet" href="/Mobile/Public/Mobile/css/font-awesome.css">
	<link rel="stylesheet" href="/Mobile/Public/Mobile/css/swiper-4.3.3.min.css">
	<script src="/Mobile/Public/Mobile/js/swiper-4.3.3.min.js"></script>
	<script src="/Mobile/Public/Mobile/js/jquery-3.3.1.min.js"></script>
	<style>
		/*共公头部结束*/
		html{
			font-size:62.5%;
			margin:0 0 0rem;
		}
		input[type=button],input[type=text],input[type=password]{
			-webkit-appearance:none;
			outline:none;
		}
		textarea {
			-webkit-appearance: none;
			outline:none;
		} 
		select{
			-webkit-appearance: none;
			outline:none;
		}
		.mobilePublicNav{
			width:102%;
			height:13rem;
			margin-left:-0.8rem;
			margin-top:-0.8rem;
			background:rgba(0,159,168,1);
			position:fixed;
			z-index:10;
		}
		.navDiv{
			height:13rem;
			line-height:13rem;
			font-size:6rem;
			margin-left:3%;
			margin-top: 0.5rem;
			float:left;
		}
		.cl{
			clear:both;
		}
		.oneNavDiv{
			width:20%;
			text-align:left;
		}
		.twoNavDiv{
			width:50%;
			text-align:center;
			color:white;
			overflow: hidden;
			text-overflow:ellipsis;
			white-space: nowrap;
		}
		.threeNavDiv{
			text-align:right;
			width:20%;
		}
		/*公共底部开始*/
		.mobilePublicFot{
			width:100%;
			height:15rem;
			right:0rem;
			bottom:0rem;
			background:rgba(0,159,168,1);
			position:fixed;
			z-index:10;
		}
		.fotDiv{
			width:24.8%;
			height:15rem;
			color:white;
			float:left;
		}
		.fotDivFirst{
			height:7.5rem;
			width:24.8%;
		}
		.fotDivTwo{
			width:100%;
			height:7.5rem;
			line-height:7.5rem;
			font-size:4rem;
			text-align:center;
		}
		.firstImg{
			margin-top:3rem;
			margin-left:10rem;
		}
		.fotDivBorder{
			border-right:0.2rem solid #058C94;
		}
		/*左下角导航菜单*/
		.mobilePublicFotNav{
			width:104%;
			left:-1rem;
			top:-1rem;
			position:fixed;
			background:rgba(0,0,0,0.7);
			display:none;
			z-index:100;
		}
		.mobilePublicFotNavTwo{
			width:100%;
			height:auto;
			position:fixed;
			bottom:15rem;
			left:0rem;
		}
		.fotNavList{
			width:100%;
			height:10rem;
			line-height:10rem;
			background:#fff;
			border-bottom:0.2rem solid rgba(220,220,220,1);
			font-size:4rem;
			text-align:center;
			color:rgba(51,51,51,1);
		}
		a{
			text-decoration:none;
		}
		.fl{
			float:left;
		}
		
		/*********公共登录********/
		.loginPublicModel{
			width:100%;
			height:100%;
			position:absolute;
			top:0rem;
			left:0rem;
			background:rgba(0,0,0,0.7);
			z-index:1000;
			position:fixed;
			display:none;
		}
		.loginPublicModelOne{
			width:84%;
			height:70rem;
			background:#fff;
			border-radius:2rem;
		}
		.loginTitle{
			width:100%;
			height:12rem;
			line-height:12rem;
			text-align:center;
			font-size:5rem;
			color:#009FA8;
			border-bottom:0.1rem solid #999;
		}
		.publicLoginDiv{
			width:100%;
			position:relative;
			margin-top:5rem;
		}
		.publicLoginInput{
			width:80%;
			height:10rem;
			line-height:10rem;
			font-size:3.5rem;
			color:#666;
			border:0.1rem solid #999;
			border-radius:10rem;
			margin-left:10%;
			padding:0 0 0 2rem;
		}
		.publicLoginQrcode{
			position:absolute;
			width:auto;
			padding:0 1.5rem 0 1.5rem;
			font-size:3.5rem;
			background:#009FA8;
			color:#fff;
			height:6rem;
			line-height:6rem;
			text-align:center;
			border-radius:10rem;
			right:12%;
			top:2rem;
		}
		.publicLoginSubmit{
			width:80%;
			height:10rem;
			line-height:10rem;
			font-size:5rem;
			color:#666;
			border-radius:10rem;
			margin-left:10%;
			margin-top:8rem;
			background:#009FA8;
			text-align:center;
			color:#fff;
		}
		/*********公共登录********/
	</style>
</head>
	<div class="mobilePublicNav">
		<div class="navDiv oneNavDiv" data-n="1"><img src="/Mobile/Public/Mobile/image/20180614logo.png"></div>
		<div class="navDiv twoNavDiv">400-052-0680</div>
		<div class="navDiv threeNavDiv"><img src="/Mobile/Public/Mobile/image/20180614search.png" style="margin-right:2rem;"></div>
		<div class="cl"></div>
	</div>
	<div class="loginPublicModel">
		<div class="loginPublicModelOne">
			<div class="loginTitle">快速登录</div>
			<div class="publicLoginDiv"><input type="text" name="name" value="" class="publicLoginInput" id="loginName" placeholder="请输入手机号"/></div>
			<div class="publicLoginDiv"><input type="text" name="name" value="" class="publicLoginInput" id="loginPass" placeholder="请输入验证码"/><div class="publicLoginQrcode">获取验证码</div></div>
			<div class="publicLoginSubmit">快速登录</div>
		</div>
	</div>
	<style>
		/*主体部分开始*/
		.mainBox{
			width:102%;
			height:auto;
			margin-left:-0.8rem;
			background:#f0f0f0;
			position:absolute;
		}
		.countryDepartment{
			width:100%;
			height:auto;
			background:#fff;
			padding:2rem 2rem;
			margin-top:14rem;
		}
		.doctorRecommend{
			width:100%;
			padding:0 2rem 2rem 2rem;
			margin-top:2rem;
			background:#fff;
		}
		.hospitalRecommendTwo{
			width:100%;
			height:auto;
		}
		.doctorRecommendOne{
			width:100%;
			height:9rem;
			background:#fff;
			border-bottom:0.2rem solid rgba(220,220,220,1);
		}
		.doctorRecommendLine{
			width:auto;
			height:9rem;
			line-height:9rem;
			font-size:4rem;
			text-align:center;
			float:left;
		}
		.departments{
			width:100%;
			height:auto;
		}
		.department{
			width:25%;
			height:22rem;
			float:left;
		}
		.departmentImg{
			margin-top:4rem;
			text-align:center;
		}
		.departmentTitle{
			width:100%;
			height:5rem;
			line-height:5rem;
			text-align:center;
			margin-top:1rem;
			font-size:3.5rem;
		}
		.hotMessageList{
			width:100%;
			height:auto;
			border-bottom:0.1rem solid #999;
			padding:2rem 0 2rem 0;
		}
		.hotMessageTitle{
			width:100%;
			height:7rem;
			line-height:7rem;
			font-size:4rem;
			display: -webkit-box;
			-webkit-box-orient: vertical;
			-webkit-line-clamp:1;
			overflow: hidden;
		}
		.hotMessageImgContent{
			width:100%;
			height:18rem;
			margin-top:1rem;
		}
		.hotMessageImg{
			width:30%;
		}
		.hotMessageImg img{
			width:100%;
		}
		.hotMessageContent{
			width:68%;
			height:18rem;
			line-height:6rem;
			font-size:3.5rem;
			color:#999;
			margin-left:2%;
			display: -webkit-box;
			-webkit-box-orient: vertical;
			-webkit-line-clamp:3;
			overflow: hidden;
		}
		.clickViewMore{
			width:100%;
			height:10rem;
			line-height:10rem;
			text-align:center;
			font-size:4rem;
			background:#fff;
		}
		.leftImgStyle{
			width:100%;
		}
	</style>
	<div class="mainBox">
		<div class="countryDepartment"> 
			<div class="departments" data-n="1">
				<div class="department"><div class="departmentImg"><img src="/Mobile/Public/Mobile/image/20180626zhongliuke.png"></div><div class="departmentTitle">肿瘤科</div></div>
				<div class="department"><div class="departmentImg"><img src="/Mobile/Public/Mobile/image/20180626shenjingwaike.png"></div><div class="departmentTitle">神经外科</div></div>
				<div class="department"><div class="departmentImg"><img src="/Mobile/Public/Mobile/image/20180628wuguanke.png"></div><div class="departmentTitle">五官科</div></div>
				<div class="department"><div class="departmentImg"><img src="/Mobile/Public/Mobile/image/20180626yanke.png"></div><div class="departmentTitle">眼科</div></div>
				<div class="department"><div class="departmentImg"><img src="/Mobile/Public/Mobile/image/20180626shenjingneike.png"></div><div class="departmentTitle">神经内科</div></div>
				<div class="department"><div class="departmentImg"><img src="/Mobile/Public/Mobile/image/20180626xinneike.png"></div><div class="departmentTitle">心内科</div></div>
				<div class="cl"></div>
			</div>
		</div> 
		<div class="doctorRecommend"">
			<div class="doctorRecommendOne">
				<div class="doctorRecommendLine" style="color:#009FA8;font-size:5rem;">热门资讯</div>
				<div class="doctorRecommendLine" style="float:right;color:#999;font-size:3.5rem;text-align:right;">更多<img style="position:relative;top:-0.3rem;" src="/Mobile/Public/Mobile/image/20180615right.png"></div>
			</div>  
			<div class="hospitalRecommendTwo"> 
				<div class="hotMessageList">
					<div class="hotMessageTitle">乳腺癌12个防癌处方，来源日常生活经济又实用</div>
					<div class="hotMessageImgContent">
						<div class="hotMessageImg fl"><img class="hospitalRecommendImg" src="/Mobile/Public/Mobile/image/20180615banner2.jpg"></div>
						<div class="hotMessageContent fl">所有人都想远离癌症、健康长寿，但你想知道最简单、便宜的防癌方法是什么吗？国际抗癌联盟曾发表报告称</div>
						<div class="cl"></div>
					</div>
				</div>
				<div class="hotMessageList">
					<div class="hotMessageTitle">乳腺癌12个防癌处方，来源日常生活经济又实用</div>
					<div class="hotMessageImgContent">
						<div class="hotMessageImg fl"><img class="hospitalRecommendImg" src="/Mobile/Public/Mobile/image/20180615banner2.jpg"></div>
						<div class="hotMessageContent fl">所有人都想远离癌症、健康长寿，但你想知道最简单、便宜的防癌方法是什么吗？国际抗癌联盟曾发表报告称</div>
						<div class="cl"></div>
					</div>
				</div>
				<div class="hotMessageList">
					<div class="hotMessageTitle">乳腺癌12个防癌处方，来源日常生活经济又实用</div>
					<div class="hotMessageImgContent">
						<div class="hotMessageImg fl"><img class="hospitalRecommendImg" src="/Mobile/Public/Mobile/image/20180615banner2.jpg"></div>
						<div class="hotMessageContent fl">所有人都想远离癌症、健康长寿，但你想知道最简单、便宜的防癌方法是什么吗？国际抗癌联盟曾发表报告称</div>
						<div class="cl"></div>
					</div>
				</div>
				<div class="hotMessageList">
					<div class="hotMessageTitle">乳腺癌12个防癌处方，来源日常生活经济又实用</div>
					<div class="hotMessageImgContent">
						<div class="hotMessageImg fl"><img class="hospitalRecommendImg" src="/Mobile/Public/Mobile/image/20180615banner2.jpg"></div>
						<div class="hotMessageContent fl">所有人都想远离癌症、健康长寿，但你想知道最简单、便宜的防癌方法是什么吗？国际抗癌联盟曾发表报告称</div>
						<div class="cl"></div>
					</div>
				</div>
				<div class="hotMessageList">
					<div class="hotMessageTitle">乳腺癌12个防癌处方，来源日常生活经济又实用</div>
					<div class="hotMessageImgContent">
						<div class="hotMessageImg fl"><img class="hospitalRecommendImg" src="/Mobile/Public/Mobile/image/20180615banner2.jpg"></div>
						<div class="hotMessageContent fl">所有人都想远离癌症、健康长寿，但你想知道最简单、便宜的防癌方法是什么吗？国际抗癌联盟曾发表报告称</div>
						<div class="cl"></div>
					</div>
				</div>
				<div class="hotMessageList">
					<div class="hotMessageTitle">乳腺癌12个防癌处方，来源日常生活经济又实用</div>
					<div class="hotMessageImgContent">
						<div class="hotMessageImg fl"><img class="hospitalRecommendImg" src="/Mobile/Public/Mobile/image/20180615banner2.jpg"></div>
						<div class="hotMessageContent fl">所有人都想远离癌症、健康长寿，但你想知道最简单、便宜的防癌方法是什么吗？国际抗癌联盟曾发表报告称</div>
						<div class="cl"></div>
					</div>
				</div>
				<div class="hotMessageList">
					<div class="hotMessageTitle">乳腺癌12个防癌处方，来源日常生活经济又实用</div>
					<div class="hotMessageImgContent">
						<div class="hotMessageImg fl"><img class="hospitalRecommendImg" src="/Mobile/Public/Mobile/image/20180615banner2.jpg"></div>
						<div class="hotMessageContent fl">所有人都想远离癌症、健康长寿，但你想知道最简单、便宜的防癌方法是什么吗？国际抗癌联盟曾发表报告称</div>
						<div class="cl"></div>
					</div>
				</div>
				<div class="hotMessageList">
					<div class="hotMessageTitle">乳腺癌12个防癌处方，来源日常生活经济又实用</div>
					<div class="hotMessageImgContent">
						<div class="hotMessageImg fl"><img class="hospitalRecommendImg" src="/Mobile/Public/Mobile/image/20180615banner2.jpg"></div>
						<div class="hotMessageContent fl">所有人都想远离癌症、健康长寿，但你想知道最简单、便宜的防癌方法是什么吗？国际抗癌联盟曾发表报告称</div>
						<div class="cl"></div>
					</div>
				</div>
			</div>   
			<div class="clickViewMore">
				<div class="clickViewMoreImg"><img src="/Mobile/Public/Mobile/image/20180619viewmore.png"></div>
				<div class="clickViewMore">点击查看更多</div>
			</div>   
			   
			<div style="width:100%;height:30rem;"></div>   
		</div> 
	</div>
	<script>
		//国家科室切换
		$('.country').each(function(){
			var n = $(this).data('n');
			if(n==1){
				$(this).css({'background':'#009FA8','color':'#fff'});
			}
		});
		$('.country').click(function(){
			var n = $(this).data('n');
			//赋值
			$('.departments').data('n',n);
			//切换css
			$('.country').css({'background':'#fff','color':'#333'});
			$(this).css({'background':'#009FA8','color':'#fff'});
		});
		//动态改变导航栏信息
		$('.oneNavDiv').html('<img src="/Mobile/Public/Mobile/image/20180627reback.png">');
		$('.oneNavDiv').data('n',2);
		$('.twoNavDiv').html('前沿资讯');
	</script> 
	<div class="mobilePublicFot">
		<div class="fotDiv fotDivBorder fotDivBorderNav" data-n="1">
			<div class="fotDivFirst"><img src="/Mobile/Public/Mobile/image/20180614daohang.png" class="firstImg"></div>
			<div class="fotDivTwo">导航</div>
		</div>
		<div class="fotDiv fotDivBorder">
			<div class="fotDivFirst"><img src="/Mobile/Public/Mobile/image/20180614dianhuazixun.png" class="firstImg"></div>
			<div class="fotDivTwo">电话咨询</div>
		</div>
		<div class="fotDiv fotDivBorder">
			<div class="fotDivFirst"><img src="/Mobile/Public/Mobile/image/20180614zaixianzixun.png" class="firstImg"></div>
			<div class="fotDivTwo">在线咨询</div>
		</div>
		<div class="fotDiv">
			<div class="fotDivFirst"><img src="/Mobile/Public/Mobile/image/20180614liuyan.png" class="firstImg"></div>
			<div class="fotDivTwo">立即留言</div>
		</div>
	</div>
	<div class="mobilePublicFotNav">
		<div class="mobilePublicFotNavTwo">
			<a href="http://192.168.1.21/Mobile/index.php/Mobile/Index/index"><div class="fotNavList">首页</div></a>
			<a href="http://192.168.1.21/Mobile/index.php/Mobile/Index/questionIndex"><div class="fotNavList">互动问答</div></a>
			<a href="http://192.168.1.21/Mobile/index.php/Mobile/Index/newMessages"><div class="fotNavList">前沿资讯</div></a>
			<a href="http://192.168.1.21/Mobile/index.php/Mobile/Index/diseaseIndex"><div class="fotNavList">疾病知识</div></a>
			<a href="http://192.168.1.21/Mobile/index.php/Mobile/Index/hospitalIndex"><div class="fotNavList">权威医院</div></a>
			<a href="http://192.168.1.21/Mobile/index.php/Mobile/Index/expertIndex"><div class="fotNavList">超级专家</div></a>
		</div>
	</div>
	<script>
		var height = $(window).height()/12-2;
		$('.mobilePublicFotNav').css({'height':height+'rem','top':'12.2rem'});
		//点击展开导航
		$('.fotDivBorderNav').click(function(){
			var n = $(this).data('n');
			if(n==1){
				$('.mobilePublicFotNav').slideDown('fast');
				$(this).css({'backgroundColor':'#008c95'});
				$(this).data('n',2);
			}else if(n==2){
				$(this).css({'backgroundColor':'#009FA8'});
				$('.mobilePublicFotNav').slideUp('fast');
				$(this).data('n',1);
			}
		});
		$('.mobilePublicFotNav').on("click",function(){
			$('.mobilePublicFotNav').slideUp('fast');
			$('.fotDivBorderNav').css({'backgroundColor':'#009FA8'});
			$('.fotDivBorderNav').data('n',1);
		});
		//定时刷新页面
		setInterval(function(){
			<!-- window.location.reload() -->
		},5000);
		$('.oneNavDiv').click(function(){
			var n = $(this).data('n');
			if(n==2){
				//返回上个页面
				window.location.href=document.referrer;
			}
		});
		//透明导航栏
		var publicN = $('.oneNavDiv').data('n');
		$(window).scroll(function(){
			var bodyScrollTop = $(window).scrollTop();
			if(bodyScrollTop > 100){
				$('.mobilePublicNav').css({'background':'#fff'});
				$('.twoNavDiv').css({'color':'#999'});
				<!-- alert(publicN); -->
				if(publicN == 2){
					$('.oneNavDiv').html('<img src="/Mobile/Public/Mobile/image/20180627newreback.png">');
				}else{
					$('.oneNavDiv').html('<img src="/Mobile/Public/Mobile/image/20180627newlogo.png">');
				}
				$('.threeNavDiv').html('<img src="/Mobile/Public/Mobile/image/20180627newsearch.png" style="margin-right:2rem;">');
				$('.mobilePublicNav').css({'box-shadow':'0rem 0rem 4rem rgba(220,220,220,1)'});
			}else{
				$('.mobilePublicNav').css({'background':'#009FA8'});
				$('.twoNavDiv').css({'color':'#fff'});
				if(publicN == 2){
					$('.oneNavDiv').html('<img src="/Mobile/Public/Mobile/image/20180627reback.png">');
				}else{
					$('.oneNavDiv').html('<img src="/Mobile/Public/Mobile/image/20180614logo.png">');
				}
				$('.threeNavDiv').html('<img src="/Mobile/Public/Mobile/image/20180614search.png" style="margin-right:2rem;">');
				
			}
		});
		//公共登录框
		$(function(){
			var loginTop = ($(window).height()/12-70)/2;
			$('.loginPublicModelOne').css({'margin-top':loginTop+'rem','margin-left':'8%'});
			$('.loginPublicModelOne').on('click',function(e){
				e.stopPropagation();
			});
			$('.fotNavList').on('click',function(e){
				e.stopPropagation();
			});
			$('.loginPublicModel').on('click',function(){
				$('.loginPublicModel').css({'display':'none'});
			});
		});
	</script>
</html>