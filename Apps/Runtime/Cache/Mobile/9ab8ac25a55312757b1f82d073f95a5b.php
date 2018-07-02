<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>超级医生</title>
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
	</style>
</head>
	<div class="mobilePublicNav">
		<div class="navDiv oneNavDiv" data-n="1"><img src="/Hope-three/Public/Mobile/image/20180614logo.png"></div>
		<div class="navDiv twoNavDiv">400-052-0680</div>
		<div class="navDiv threeNavDiv"><img src="/Hope-three/Public/Mobile/image/20180614search.png" style="margin-right:2rem;"></div>
		<div class="cl"></div>
	</div>
<script src="/Hope-three/Public/Mobile/js/zepto.min.js"></script>
<script src="/Hope-three/Public/Mobile/js/swiper-4.3.3.min.js"></script>
<link rel="stylesheet" href="/Hope-three/Public/Mobile/css/swiper-4.3.3.min.css">
	<style>
		/*主体部分开始*/
		.mainBox{
			width:102%;
			height:auto;
			margin-left:-0.8rem;
			background:#f0f0f0;
			position:absolute;
		}
		.quiclyNav{
			width:100%;
			height:48rem;
			background:#fff;
			margin-top:14rem;
		}
		.sixModels{
			width:33.33%;
			height:22rem;
			float:left;
		}
		.sixModelsImg{
			height:50%;
			margin-left:38%;
			margin-top:2rem;
		}
		.sixModelsImgs{
			margin-top:3rem;
			width:8rem;
		}
		.sixModelsWord{
			height:9rem;
			line-height:9rem;
			font-size:4rem;
			color:#333;
			text-align:center;
		}
		.nomalDisease{
			width:100%;
			height:8rem;
			margin-top:2rem;
			background:#fff;
		}
		.publicDisaeseDiv{
			width:26%;
			height:8rem;
			float:left;
		}
		.publicDisaeseDivs{
			width:auto;
			height:8rem;
			line-height:8rem;
			padding:0 2rem;
			font-size:4rem;
			float:left;
			text-align:center;
		}
		.publicDisaese{
			margin-left:3rem;
			margin-top:2rem;
			float:left;
		}
		.publicDisaeses{
			height:8rem;
			line-height:8rem;
			font-size:4rem;
			float:left;
			margin-left:1rem;
		}
		.swiperBanners{
			margin-top:2rem;
		}
		.autoBanner{
			width:100%;
		}
		.doctorRecommend{
			margin-top:2rem;
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
			width:20rem;
			height:9rem;
			line-height:9rem;
			font-size:4rem;
			text-align:center;
			float:left;
		}
		.doctorRecommendTwo{
			width:100%;
			height:40rem;
			background:#fff;
		}
		.doctorRecommendList{
			width:33.33%;
			height:100%;
			float:left;
		}
		.doctorRecommendDiv{
			position:relative;
		}
		.doctorRecommendImg{
			width:18rem;
			height:18rem;
			border-radius:50%;
			margin-left:24.5%;
			margin-top:3rem;
		}
		.doctorRecommendName{
			width:100%;
			height:7rem;
			line-height:7rem;
			font-size:4rem;
			font-weight:bold;
			text-align:center;
		}
		.doctorRecommendAbstract{
			width:80%;
			margin-left:10%;
			height:10rem;
			line-height:5rem;
			display: -webkit-box;
			-webkit-box-orient: vertical;
			-webkit-line-clamp: 2;
			font-size:3.5rem;
			overflow: hidden;
			color:#666;
		}
		.specialCircle{
			position:absolute;
			width:6rem;
			height:6rem;
			line-height:6rem;
			text-align:center;
			font-size:2rem;
			background:orange;
			color:#fff;
			top:5%;
			right:20%;
			border-radius:50%;
		}
		.hospitalRecommendTwo{
			width:100%;
			height:50rem;
			background:#fff;
		}
		.hospitalRecommendList{
			width:50%;
			height:100%;
			float:left;
		}
		.hospitalRecommendImg{
			width:90%;
			margin-left:5%;
			margin-top:2rem;
		}
		.hospitalRecommendName{
			width:90%;
			margin-left:5%;
			height:auto;
			line-height:7.5rem;
			font-size:4rem;
			display: -webkit-box;
			-webkit-box-orient: vertical;
			-webkit-line-clamp: 2;
			font-size:4rem;
			overflow: hidden;
		}
		.hospitalRecommendAbstract{
			width:90%;
			margin-left:5%;
			height:10rem;
			line-height:5rem;
			display: -webkit-box;
			-webkit-box-orient: vertical;
			-webkit-line-clamp: 2;
			font-size:3.5rem;
			overflow: hidden;
			color:#666;
		}
		.QuestionRecommendList{
			width:96%;
			height:8rem;
			margin-left:2%;
		}
		.QuestionRecommendListLeft{
			width:91%;
			height:8rem;
			line-height:8rem;
			display: -webkit-box;
			-webkit-box-orient: vertical;
			-webkit-line-clamp: 1;
			font-size:4rem;
			overflow: hidden;
			float:left;
		}
		.QuestionRecommendListRight{
			width:9%;
			height:8rem;
			line-height:8rem;
			text-align:center;
			font-size:3rem;
			float:left;
		}
		.MessagePreList{
			width:96%;
			height:auto;
			margin-left:2%;
			border-bottom:0.2rem solid rgba(220,220,220,1);
		}
		.MessagePreListLeft{
			width:30%;
			height:20rem;
			float:left;
		}
		.MessagePreListRight{
			width:67%;
			margin-left:2rem;
			height:20rem;
			float:left;
		}
		.MessagePreListRightU{
			height:5rem;
			line-height:5rem;
			font-size:4rem;
			display: -webkit-box;
			-webkit-box-orient: vertical;
			-webkit-line-clamp: 2;
			overflow: hidden;
		}
		.MessagePreListRightB{
			font-size:3.5rem;
			display: -webkit-box;
			-webkit-box-orient: vertical;
			-webkit-line-clamp: 2;
			overflow: hidden;
			color:#666666;
			margin-top:2rem;
		}
		.clickViewMoreImg{
			width:100%;
			height:5rem;
			line-height:5rem;
			text-align:center;
			background:#fff;
		}
		.clickViewMore{
			width:100%;
			height:10rem;
			line-height:10rem;
			text-align:center;
			font-size:4rem;
			background:#fff;
		}
	</style>
	<div class="mainBox">
		<div class="quiclyNav">
			<div class="sixModels">
				<div class="sixModelsImg"><img class="sixModelsImgs" src="/Hope-three/Public/Mobile/image/20180615jibingzhishi.png"></div>
				<div class="sixModelsWord">疾病知识</div>
			</div>
			<div class="sixModels">
				<div class="sixModelsImg"><img class="sixModelsImgs" src="/Hope-three/Public/Mobile/image/20180615zhuanjia.png"></div>
				<a href="http://192.168.1.21/Hope-three/index.php/Mobile/Index/expertIndex"><div class="sixModelsWord">超级专家</div></a>
			</div>
			<div class="sixModels">
				<div class="sixModelsImg"><img class="sixModelsImgs" src="/Hope-three/Public/Mobile/image/20180615yiyuan.png"></div>
				<a href="http://192.168.1.21/Hope-three/index.php/Mobile/Index/hospitalIndex"><div class="sixModelsWord">权威医院</div></a>
			</div>
			<div class="sixModels">
				<div class="sixModelsImg"><img class="sixModelsImgs" src="/Hope-three/Public/Mobile/image/20180615zixun.png"></div>
				<div class="sixModelsWord">前沿资讯</div>
			</div>
			<div class="sixModels">
				<div class="sixModelsImg"><img class="sixModelsImgs" src="/Hope-three/Public/Mobile/image/20180615wenda.png"></div>
				<div class="sixModelsWord">互动问答</div>
			</div>
			<div class="sixModels">
				<div class="sixModelsImg"><img class="sixModelsImgs" src="/Hope-three/Public/Mobile/image/20180615wenyisheng.png"></div>
				<div class="sixModelsWord">问医生</div>
			</div>
			<div class="cl"></div>
		</div>
		<div class="nomalDisease">
			<div class="publicDisaeseDiv"><div class="publicDisaese"><img src="/Hope-three/Public/Mobile/image/20180615changjianzhongji.png"></div><div class="publicDisaeses">常见重疾:</div></div>
			<div class="publicDisaeseDivs">肺癌</div>
			<div class="publicDisaeseDivs">肝癌</div>
			<div class="publicDisaeseDivs">胃癌</div>
			<div class="publicDisaeseDivs">乳腺癌</div>
			<div class="publicDisaeseDivs">卵巢癌</div>
		</div>
		<div class="swiperBanners"> 
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<a href=""><img class="autoBanner" src="/Hope-three/Public/Mobile/image/20180615banner1.jpg"></a>
					</div>
					<div class="swiper-slide">
						<a href=""><img class="autoBanner" src="/Hope-three/Public/Mobile/image/20180615banner2.jpg"></a>
					</div>
					<div class="swiper-slide">
						<a href=""><img class="autoBanner" src="/Hope-three/Public/Mobile/image/20180615banner3.jpg"></a>
					</div>
				</div>
			</div>
		</div> 
		<script>
			var mySwiper = new Swiper('.swiper-container',{
					loop: true,
					autoplay: 2500,
					autoplayDisableOnInteraction : false,
				});
		</script>
		<div class="doctorRecommend">
			<div class="doctorRecommendOne">
				<div class="doctorRecommendLine" style="margin-left:2rem;color:#009FA8;font-size:5rem;">医生推荐</div>
				<div class="doctorRecommendLine" style="float:right;color:#666;font-size:3.5rem;text-align:right;">更多<img style="position:relative;top:0.3rem;margin-left:1rem;" src="/Hope-three/Public/Mobile/image/20180615right.png"> &nbsp;&nbsp;</div>
			</div>
			<div class="doctorRecommendTwo">
				<div class="doctorRecommendList">
					<div class="doctorRecommendDiv"><img class="doctorRecommendImg" src="/Hope-three/Public/Mobile/image/20180615banner1.jpg"><div class="specialCircle">签约</div></div>
					<div class="doctorRecommendName">幕内雅敏</div>
					<div class="doctorRecommendAbstract">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
				</div>
				<div class="doctorRecommendList">
					<div class="doctorRecommendDiv"><img class="doctorRecommendImg" src="/Hope-three/Public/Mobile/image/20180615banner2.jpg"><div class="specialCircle">独家</div></div>
					<div class="doctorRecommendName">幕内晴朗</div>
					<div class="doctorRecommendAbstract">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
				</div>
				<div class="doctorRecommendList">
					<div class="doctorRecommendDiv"><img class="doctorRecommendImg" src="/Hope-three/Public/Mobile/image/20180615banner3.jpg"><div class="specialCircle">独家</div></div>
					<div class="doctorRecommendName">川崎</div>
					<div class="doctorRecommendAbstract">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
				</div>
			</div>
		</div>
		<div class="doctorRecommend">
			<div class="doctorRecommendOne">
				<div class="doctorRecommendLine" style="margin-left:2rem;color:#009FA8;font-size:5rem;">医院推荐</div>
				<div class="doctorRecommendLine" style="float:right;color:#666;font-size:3.5rem;text-align:right;">更多<img style="position:relative;top:0.3rem;margin-left:1rem;" src="/Hope-three/Public/Mobile/image/20180615right.png"> &nbsp;&nbsp;</div>
			</div>
			<div class="hospitalRecommendTwo">
				<div class="hospitalRecommendList">
					<div class="hospitalRecommendDiv"><img class="hospitalRecommendImg" src="/Hope-three/Public/Mobile/image/20180615banner1.jpg"></div>
					<div class="hospitalRecommendName">幕内雅敏</div>
					<div class="hospitalRecommendAbstract">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
				</div>
				<div class="hospitalRecommendList">
					<div class="hospitalRecommendDiv"><img class="hospitalRecommendImg" src="/Hope-three/Public/Mobile/image/20180615banner1.jpg"></div>
					<div class="hospitalRecommendName">幕内雅敏</div>
					<div class="hospitalRecommendAbstract">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
				</div>
			</div>
		</div> 
		<div class="doctorRecommend">
			<div class="doctorRecommendOne">
				<div class="doctorRecommendLine" style="margin-left:2rem;color:#009FA8;font-size:5rem;">推荐问答</div>
				<div class="doctorRecommendLine" style="float:right;color:#666;font-size:3.5rem;text-align:right;">更多<img style="position:relative;top:0.3rem;margin-left:1rem;" src="/Hope-three/Public/Mobile/image/20180615right.png"> &nbsp;&nbsp;</div>
			</div>
			<div class="hospitalRecommendTwo" style="height:42rem;">
				<div class="QuestionRecommendList">
					<div class="QuestionRecommendListLeft">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
					<div class="QuestionRecommendListRight">5回答</div>
				</div>
				<div class="QuestionRecommendList">
					<div class="QuestionRecommendListLeft">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
					<div class="QuestionRecommendListRight">5回答</div>
				</div>
				<div class="QuestionRecommendList">
					<div class="QuestionRecommendListLeft">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
					<div class="QuestionRecommendListRight">5回答</div>
				</div>
				<div class="QuestionRecommendList">
					<div class="QuestionRecommendListLeft">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
					<div class="QuestionRecommendListRight">5回答</div>
				</div>
				<div class="QuestionRecommendList">
					<div class="QuestionRecommendListLeft">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
					<div class="QuestionRecommendListRight">5回答</div>
				</div>
			</div>
		</div>
		<div class="doctorRecommend">
			<div class="doctorRecommendOne">
				<div class="doctorRecommendLine" style="margin-left:2rem;color:#009FA8;font-size:5rem;">前沿资讯</div>
				<div class="doctorRecommendLine" style="float:right;color:#666;font-size:3.5rem;text-align:right;">更多<img style="position:relative;top:0.3rem;margin-left:1rem;" src="/Hope-three/Public/Mobile/image/20180615right.png"> &nbsp;&nbsp;</div>
			</div>  
			<div class="hospitalRecommendTwo" style="height:115rem;"> 
				<div style="width:100%;height:2rem;"></div>
				<div class="MessagePreList">
					<div class="MessagePreListLeft"><img style="width:100%;" src="/Hope-three/Public/Mobile/image/20180615banner2.jpg"></div>
					<div class="MessagePreListRight">
						<div class="MessagePreListRightU">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
						<div class="MessagePreListRightB">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
					</div>
					<div class="cl"></div>
				</div> 
				<div style="width:100%;height:2rem;"></div>
				<div class="MessagePreList">
					<div class="MessagePreListLeft"><img style="width:100%;" src="/Hope-three/Public/Mobile/image/20180615banner3.jpg"></div>
					<div class="MessagePreListRight">
						<div class="MessagePreListRightU">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
						<div class="MessagePreListRightB">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
					</div>
					<div class="cl"></div>
				</div> 
				<div style="width:100%;height:2rem;"></div>
				<div class="MessagePreList">
					<div class="MessagePreListLeft"><img style="width:100%;" src="/Hope-three/Public/Mobile/image/20180615banner1.jpg"></div>
					<div class="MessagePreListRight">
						<div class="MessagePreListRightU">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
						<div class="MessagePreListRightB">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
					</div>
					<div class="cl"></div>
				</div> 
				<div style="width:100%;height:2rem;"></div>
				<div class="MessagePreList">
					<div class="MessagePreListLeft"><img style="width:100%;" src="/Hope-three/Public/Mobile/image/20180615banner2.jpg"></div>
					<div class="MessagePreListRight">
						<div class="MessagePreListRightU">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
						<div class="MessagePreListRightB">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
					</div>
					<div class="cl"></div>
				</div> 
				<div style="width:100%;height:2rem;"></div>
				<div class="MessagePreList">
					<div class="MessagePreListLeft"><img style="width:100%;" src="/Hope-three/Public/Mobile/image/20180615banner3.jpg"></div>
					<div class="MessagePreListRight">
						<div class="MessagePreListRightU">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
						<div class="MessagePreListRightB">幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏幕内雅敏</div>
					</div>
					<div class="cl"></div>
				</div>
			</div>   
			<div class="clickViewMore">
				<div class="clickViewMoreImg"><img src="/Hope-three/Public/Mobile/image/20180619viewmore.png"></div>
				<div class="clickViewMore">点击查看更多</div>
			</div>   
			   
			<div style="width:100%;height:30rem;"></div>   
		</div>   
	</div>
	<div class="mobilePublicFot">
		<div class="fotDiv fotDivBorder fotDivBorderNav" data-n="1">
			<div class="fotDivFirst"><img src="/Hope-three/Public/Mobile/image/20180614daohang.png" class="firstImg"></div>
			<div class="fotDivTwo">导航</div>
		</div>
		<div class="fotDiv fotDivBorder">
			<div class="fotDivFirst"><img src="/Hope-three/Public/Mobile/image/20180614dianhuazixun.png" class="firstImg"></div>
			<div class="fotDivTwo">电话咨询</div>
		</div>
		<div class="fotDiv fotDivBorder">
			<div class="fotDivFirst"><img src="/Hope-three/Public/Mobile/image/20180614zaixianzixun.png" class="firstImg"></div>
			<div class="fotDivTwo">在线咨询</div>
		</div>
		<div class="fotDiv">
			<div class="fotDivFirst"><img src="/Hope-three/Public/Mobile/image/20180614liuyan.png" class="firstImg"></div>
			<div class="fotDivTwo">立即留言</div>
		</div>
	</div>
	<div class="mobilePublicFotNav">
		<div class="mobilePublicFotNavTwo">
			<div class="fotNavList">首页</div>
			<div class="fotNavList">互动问答</div>
			<div class="fotNavList">前沿资讯</div>
			<div class="fotNavList">疾病知识</div>
			<div class="fotNavList">权威医院</div>
			<div class="fotNavList">超级专家</div>
		</div>
	</div>
	<script>
		var height = $(window).height()/12-2;
		$('.mobilePublicFotNav').css({'height':height+'rem','top':'12.2rem'});
		//点击展开导航
		$('.fotDivBorderNav').click(function(){
			var n = $(this).data('n');
			if(n==1){
				$('.mobilePublicFotNav').show('fast');
				$(this).css({'backgroundColor':'#008c95'});
				$(this).data('n',2);
			}else if(n==2){
				$(this).css({'backgroundColor':'#009FA8'});
				$('.mobilePublicFotNav').hide('fast');
				$(this).data('n',1);
			}
		});
		$('.mobilePublicFotNav').on("click",function(){
			$('.mobilePublicFotNav').hide('fast');
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
					$('.oneNavDiv').html('<img src="/Hope-three/Public/Mobile/image/20180627newreback.png">');
				}else{
					$('.oneNavDiv').html('<img src="/Hope-three/Public/Mobile/image/20180627newlogo.png">');
				}
				$('.threeNavDiv').html('<img src="/Hope-three/Public/Mobile/image/20180627newsearch.png" style="margin-right:2rem;">');
				$('.mobilePublicNav').css({'box-shadow':'0rem 0rem 4rem rgba(220,220,220,1)'});
			}else{
				$('.mobilePublicNav').css({'background':'#009FA8'});
				$('.twoNavDiv').css({'color':'#fff'});
				if(publicN == 2){
					$('.oneNavDiv').html('<img src="/Hope-three/Public/Mobile/image/20180627reback.png">');
				}else{
					$('.oneNavDiv').html('<img src="/Hope-three/Public/Mobile/image/20180614logo.png">');
				}
				$('.threeNavDiv').html('<img src="/Hope-three/Public/Mobile/image/20180614search.png" style="margin-right:2rem;">');
				
			}
		});
	</script>
</html>