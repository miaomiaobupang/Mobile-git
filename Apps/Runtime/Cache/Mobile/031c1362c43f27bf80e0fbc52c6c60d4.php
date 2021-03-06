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
<link rel="stylesheet" href="/Mobile/Public/Mobile/css/bootstrap.min.css">
<link rel="stylesheet" href="/Mobile/Public/Mobile/css/font-awesome.css">
<script src="/Mobile/Public/Mobile/js/zepto.min.js"></script>
<link rel="stylesheet" href="/Mobile/Public/Mobile/css/swiper-4.3.3.min.css">
<script src="/Mobile/Public/Mobile/js/swiper-4.3.3.min.js"></script>
	<style>
		/*主体部分开始*/
		.mainBox{
			width:102%;
			height:auto;
			margin-left:-0.8rem;
			background:#f0f0f0;
			position:absolute;
		}
		.BreadcrumbTrail{
			width:100%;
			height:7rem;
			background:#fff;
			margin-top:12rem;
		}
		.breadLeftImg{
			width:12%;
			float:left;
			height:7rem;
			line-height:7rem;
			font-size:3.5rem;
			color:#999;
			text-align:center;
			margin-left:2rem;
		}
		.breadLeftText{
			width:85%;
			height:7rem;
			line-height:7rem;
			float:left;
			font-size:3.5rem;
			color:#999;
			text-align:left;
			overflow: hidden;
			text-overflow:ellipsis;
			white-space: nowrap;
		}
		.coverPerson{
			width:100%;
			height:40rem;
			margin-top:2rem;
			background-image:url('/Mobile/Public/Mobile/image/20180627coverperson.png');
			background-repeat:repeat-y;
		}
		.coverOne{
			width:100%;
			height:25rem;
			line-height:25rem;
			text-align:center;
		}
		.coverTwo{
			width:100%;
			height:6rem;
			line-height:6rem;
			text-align:center;
			color:#009FA8;
			font-size:5rem;
		}
		.coverThree{
			width:100%;
			height:8rem;
		}
		.coverThreeO{
			width:50%;
			height:8rem;
			line-height:8rem;
			text-align:right;
			float:left;
			padding-right:2rem;
		}
		.coverThreeT{
			width:50%;
			height:8rem;
			line-height:8rem;
			text-align:left;
			float:left;
			font-size:4rem;
			color:#009FA8;
		}
		.abstract{
			background:#fff;
			padding:2rem 2rem 2rem 2rem;
			width:100%;
			color:#666;
			line-height:7rem;
			display: -webkit-box;
			-webkit-box-orient: vertical;
			-webkit-line-clamp: 5;
			overflow: hidden;
			font-size:4rem;
			text-indent:2rem;
		}
		.mainContent{
			width:100%;
			height:auto;
			margin-top:2rem;
			background:#fff;
			padding:1rem 2rem 1rem 2rem;
		}
		.titleImg{
			width:100%;
			height:5rem;
			text-align:left;
			margin-left:2rem;
		}
		.contentOne{
			width:100%;
			height:auto;
			color:#666;
			line-height:7rem;
			font-size:4rem;
			text-indent:2rem;
			color:#666;
			padding:1rem 2rem 1rem 2rem;
		}
		.contentTwo{
			width:100%;
			height:200rem;
			color:#666;
			line-height:7rem;
			font-size:4rem;
			text-indent:2rem;
			display: -webkit-box;
			-webkit-box-orient: vertical;
			overflow: hidden;
			padding:1rem 2rem 1rem 2rem;
		}
		.clickViewMoreDiv{
			width:100%;
			height:auto;
			display:none;
		}
		.clickViewMoreImg{
			width:100%;
			height:7rem;
			line-height:7rem;
			text-align:center;
			background:#fff;
		}
		.clickViewMore{
			width:100%;
			height:7rem;
			line-height:7rem;
			text-align:center;
			font-size:4rem;
			background:#fff;
			color:#999;
		}
	</style>
	<div class="mainBox">
		<div class="BreadcrumbTrail">
			<div class="breadLeftImg"><img src="/Mobile/Public/Mobile/image/20180627backtoindex.png"> 首页</div>
			<div class="breadLeftText"> > 超级专家 > 日本肿瘤专家 > 幕内亚敏</div>
		</div>
		<div class="coverPerson">
			<div class="coverOne"><img src="/Mobile/Public/Mobile/image/20180627muneiyaming.png"></div>
			<div class="coverTwo">幕内亚敏 教授</div>
			<div class="coverThree">
				<div class="coverThreeO"><img src="/Mobile/Public/Mobile/image/20180627detaildisease.png"></div>
				<div class="coverThreeT">肝癌 肝病</div>
			</div>
		</div>
		<div class="abstract">BioMedExperts排名中，幕内教授在肝切除及活体肝移植领域排名世界第一。幕内教授是国际外科、消化科和肿瘤科医师协会(IASGO)主席，日本外科学主席，被NHK电视台采访并拍摄纪录片。世界首次成功进行小儿活体肝移植手术，世界第一例采用左半肝供肝的成人间活体肝移植术，世界第一例将术中超声融入</div>
		<div class="mainContent">
			<div class="content contentOne">幕内雅敏



幕内雅敏教授(Prof.Masatoshi Makuuchi)在现代肝脏外科的发展史上是位温文尔雅、为人熟知的专家。

BioMedExperts排名中，幕内教授在肝切除及活体肝移植领域排名世界第一。幕内教授是国际外科、消化科和肿瘤科医师协会(IASGO)主席，日本外科学主席，被NHK电视台采访并拍摄纪录片。世界首次成功进行小儿活体肝移植手术，世界第一例采用左半肝供肝的成人间活体肝移植术，世界第一例将术中超声融入手术并建立肝胆胰外科标准，世界第一例实施门静脉栓赛术大幅度提高肝脏切除术后的安全性 ，世界首先提出了在肝切除术中采用选择性半肝阻断，幕内教授已经发表了超过1000篇的论文及著作，其中有关解剖性肝段切除，门静脉栓塞后二期肝切除，成人间活体肝移植3篇论文被称为“肝脏外科领域最具有世界影响力的标志性成果”。幕内院长被业界誉为世界肝胆外科之王。



教授履历

1946

生于日本东京；

1973

毕业于东京大学医学部；

1979

完成6年基层医院轮转，进入日本国立癌症中心外科工作，主攻肝胆胰外科；

1988

担任肝胆科主任；

1989

任外科主任；10月，前往信州大学第一外科担任主任教授；

1994

回到东京大学第二外科担任主任教授(第二外科，现称肝胆胰外科及人工脏器移植外科)；

2007

4月前往日本红十字医院担任院长至今。

此外幕内教授还是国际消化外科领域最权威的学术组织——国际外科、消化科和肿瘤科医师协会(IASGO)的主席，同时还身兼许多国际医学协会的会员。幕内教授在肝脏外科和肝癌的治疗方面做出了众多影响至今的先驱性的贡献，被称为“肝脏外科的王者”。

从上个世纪80年代初期开始，幕内教授便创新和发展了一系列外科手术技术，他率先将超声技术融入肝胆外科手术，并由此发展出了一系列全新的外科手术方式，例如超声引导下经肝脏穿刺胆道造影和胆道引流、解剖性肝段切除、以及保留右后肝静脉的右肝部分切除的全新术式。

其中解剖性肝段切除又称Makuuchi’sprocedure，幕内教授因开展这种新型肝脏切除术式而闻名世界。运用术中超声技术判定荷瘤肝段并实施解剖性切除，这是一项划时代的术式，至今仍是肝细胞癌手术的第一选择。这种解剖性肝切除术式，以en-bloc切除肿瘤病灶及其潜在的微小转移和血管侵袭为特点，明显提高了患者的术后生存率。通过对新型术式的深入思考，对临床成果的分析总结，出版了闻名世界的《AbdominalIntraoperative Ultrasonograph》一书，在该书卷首页中，世界肝脏外科权威Bismuth教授称赞幕内教授为“肝脏外科最具创新精神的先锋”。

随着外科与麻醉技术的进步，许多巨大肿瘤或多发肿瘤的患者得到了更多的手术机会，术后肝脏残余体积不足而致肝功能不全却成为了实施肝脏切除手术的主要障碍。1982年，幕内教授实施了第一例门静脉栓塞术以提高肝切除术后的安全性。通过使栓塞侧肝脏萎缩，而非栓塞侧肝脏代偿性增生，增加了术后残余肝脏体积，让原本肝脏储备功能不足而不能进行肝切除的患者同样能够得到治疗，从而延长生存。

1985年，他首先提出了在肝切除术中采用选择性半肝阻断这一间断血流阻断方式。该方法可有效减少术中出血，同时保留了健侧肝脏正常血供，避免了缺血-再灌注损伤，没有严格的阻断时间限制，对术中血流动力学影响小，不致发生因肠道静脉淤血造成的肠道细菌、内毒素易位和肠道粘膜损伤，术后并发症发生率低，肝功能恢复快，成为了目前广泛使用的肝脏血流阻断技术。

在全球首次成功进行小儿活体肝移植手术后，幕内教授的外科团队开始了有关活体肝移植的研究，经过反复的摸索、尝试，取得了令人满意的成绩，在1993年，他完成了世界第一例采用左半肝供肝的成人间活体肝移植术，打破了当时活体供肝只能用于小儿的限制。

其后幕内外科团队完善了附带尾状叶的左半肝供肝，右后叶供肝等术式，进一步扩大供肝选择范围。通过临床研究明确了以不含中肝静脉的右半肝作为供肝时，供肝的淤血范围及中肝静脉分支重建的适应症。为了提高活体肝移植受体的安全性，幕内教授就围手术期管理及外科手术技术方面进行了一系列的改进和发展。通过临床研究证实了供体肝切除时通过Pringle法阻断肝脏血流并不损害供肝的功能;发明了通过受体体表面积计算其标准肝体积的公式(浦田公式)。

多年来，幕内教授将肝脏切除和肝脏移植的技巧和技术进行有机的融会贯通，并且在两个领域都做出了杰出的贡献。高山忠立教授将幕内教授的外科手术理念总结为“最小出血量;术中零死亡率;患者最佳生存期”。

迄今为止，幕内教授已经发表了超过1000篇的论文及著作，被引用频次最高的论文超过700次，其中有关解剖性肝段切除，门静脉栓塞后二期肝切除，成人间活体肝移植3篇论文被称为“肝脏外科领域最具有世界影响力的标志性成果”。相对于论文的影响因子，近年来很多评价机构采用发表论文总数及被引用频次来评价研究者的学术贡献，在以此为评价标准的BioMedExperts排名中，幕内教授在肝切除及活体肝移植领域排名世界第一。

作为国际顶级专家，幕内教授同样承担了繁重的临床、教学、科研工作，被称为“365天24小时的外科医生”，曾经创造13个小时内成功切除一例肝转移瘤患者肝内99个肿瘤的记录。然而辛劳的临床工作丝毫没有影响幕内教授的教学热情，出于医者传道、奉献的精神，幕内教授积极参加各类国际交流，除了受邀在国际会议上讲课或发言900余次，还应邀在欧美及亚洲多国实施各类肝脏切除手术表演，并得到国际外科界的极大认可。而幕内教授与中国也颇有渊源，对中国医学同道真诚相待，在与中国留学生及访日学者交流时，少谈冗长理论，而侧重于日常临床工作中应注意或易失误的问题。多年来应邀到中国多个城市举办学会、演示手术，此外由幕内教授主编的《要点与盲点》系列丛书在中国深受外科医生欢迎，好评如潮。



《幕内肝脏外科学》是幕内教授根据从事肝脏外科近40年的经验，将他的手术技巧全面介绍给读者，除采用详细的文字描述之外，还绘制了大量简洁直观的示意图，并辅以术中彩色照片加以说明，行文流畅，结构紧凑，图文并茂，实用性很强。许多复杂的手术操作通过术中照片及示意图一一再现，使读者仿佛亲临手术现场一般倍感真实。尤为重要的是，幕内教授长期致力于中青年外科医师的教育和培养，因而全书基础理论与临床应用密切结合，传统经验和现代技术融会贯通。

幕内教授对中国医学同行十分友好，多次应邀来华讲学和手术演示，热心传播最新的肝胆胰外科理论与技术，他所在的东京大学第二外科接受了一大批中国留学生和研修生。他对中国肝胆胰外科和肝脏移植事业给予了巨大的帮助，赢得了中国同行的尊敬和爱戴。

2016年1月22日，厚朴方舟独家签约幕内雅敏教授。至此，日本医学界乃至全球医学界都闻名的“幕内三兄弟”(维基百科上有专门介绍)已有二人(幕内雅敏教授+日本心脏学会主席：幕内晴朗教授)签约厚朴方舟。



专门领域

活体肝脏移植、肝脏切除、胆道恶性肿瘤手术、胰腺切除手术以及手术中的超音波检查。

认定医师资格证书

日本外科学会指导医·外科专门医

日本消化器外科学会指导医·消化器外科专门医·消化器癌症外科治疗认定医

日本消化器病学会指导医·消化器病专门医

日本肝脏学会指导医·肝脏专门医

日本超音波医学会超音波指导医·专门医

日本肝胆胰外科学会高度技能指导医</div>
		</div>
		<div class="clickViewMoreDiv">
			<div class="clickViewMoreImg"><img src="/Mobile/Public/Mobile/image/20180619viewmore.png"></div>
			<div class="clickViewMore">点击阅读更多</div>
		</div>
		<div style="width:100%;height:30rem;background:#fff;"></div>  
	</div>
	<script>
		//动态改变导航栏信息
		$('.oneNavDiv').html('<img src="/Mobile/Public/Mobile/image/20180627reback.png">');
		$('.oneNavDiv').data('n',2);
		$('.twoNavDiv').html('幕内亚敏');
		//阅读全文
		var contentHeight = $('.content').height();
		if(contentHeight > 1000){
			$('.content').removeClass('contentOne');
			$('.content').addClass('contentTwo');
			$('.clickViewMoreDiv').css({'display':'block'});
		}
		//点击阅读更多
		$('.clickViewMoreDiv').click(function(){
			$('.content').removeClass('contentTwo');
			$('.content').addClass('contentOne');
			$('.clickViewMoreDiv').css({'display':'none'});
		});
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
			<div class="fotNavList">前沿资讯</div>
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