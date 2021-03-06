// +----------------------------------------------------------------------
// | 非速搜WEB项目
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://fairso.com All rights reserved.
// +----------------------------------------------------------------------
// | Fairso 通用表单
// +----------------------------------------------------------------------
// | Author: 狼啸 <11740390@qq.com>
// +----------------------------------------------------------------------

/*
	标准表单div示例
	<div class="inputDiv">
		//表单字段名
		<div class="inputText">
			<span>账户名：</span>
		</div>
		<div class="inputValue">
		//表单输入框
			<input id="passinput" class="formFrame  inputTxt username" placeholder="邮箱/手机号/会员名" type="text" data-id="1" data-state="2" data-title="账户名" data-ischeck="1" data-checktype="8" data-useronly="1"  data-userchecktype="7">
		</div>
		//表单提示框
		<div class="formPrompt formPrompt-1">
			<div class="alert alert-success" role="alert">
				<span class="icon-info-sign promptIco"></span><span class="promptText-1">请输入账户名</span>
			</div>
		</div>
		//表单报错框
		<div class="formError formError-1">
			<div class="alert alert-danger" role="alert">
				<span class="icon-remove-sign errorIco"></span><span class="errorText-1">账户名错误！</span>
			</div>
		</div>
	</div>
*/
//输入框执行绿色输入状态
$('.inputTxt').focus(function(){
	var id =$(this).data('id');
	//初始化
	$('.inputTxt').each(function(){
		//判断是否为错误状态，如果不是错误状态，则执行灰色边框初始化
		if($(this).data('state')!=3){
			$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
		}
	});
	//输入框执行绿色输入状态
	$(this).css({ "border": "1px solid #06da24", "box-shadow": "0 0 2px #a1f3ab" });
	//隐藏当前错误框
	$('.formError-'+id).hide();
	//打开当前提示
	$('.formPrompt-'+id).show();
});
//输入框执行校验
//该校验使用data缓存传值校验
//参数：	id				表单项ID
//			state			表单状态 1正确 2未操作（默认） 3错误
//			title			表单文本 
//			ischeck			是否启用校验 1启用 2不启用 
//			checktype		校验方式 
//									1手机号 2邮箱 3验证数字 4验证n位的数字（依赖length参数） 5验证至少n位数字（依赖length参数） 
//									6验证m-n位的数字（依赖slength、olength参数） 7验证有两位小数的正实数 8验证用户唯一 9验证密码
//									10验证重复密码 11校验验证码 12校验身份证
//			slength			校验长度开始数（checktype为6、9时起作用，选其他忽略）
//			olength			校验长度结束数 （checktype为6、9时起作用，选其他忽略）
//			length			校验长度 （checktype为4、5时起作用，选其他忽略）
//			useronly		校验用户存在类型（checktype为8时起作用，选其他忽略） 1校验用户是否存在（不存在报错） 2校验用户是否不存在（存在报错）注意：依赖地址接口，请保证地址接口畅通
//			userchecktype	用户校验类型（checktype为8时起作用，选其他忽略） 1用户名 2手机号 3邮箱 4用户名和手机号 5用户名和邮箱 6手机号和邮箱 7用户名，手机号和邮箱
//			passid			密码框的ID名（请保证页面唯一） 
$('.inputTxt').focusout(function(){
	var id = $(this).data('id');
	//关闭当前提示
	$('.formPrompt-'+id).hide();
	if($(this).data('ischeck')!=undefined && $(this).data('ischeck')==1){
		var value = $(this).val();
		var input = $(this);
		if(value){
			if($(this).data('checktype')!=undefined){
				if($(this).data('checktype')==1){
					//校验是否为手机号
					//校验手机号是否为11位
					var re = /^1\d{10}$/;//手机正则表达式
					if(re.test(value)){
						$(this).data('state',1);
						$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
						$('.errorText-'+id).html('');
						$('.formError-'+id).hide();
					}else{
						$(this).data('state',3);
						$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
						$('.errorText-'+id).html('手机号格式错误！');
						$('.formError-'+id).show();
					}
				}else if($(this).data('checktype')==2){
					//校验是否为邮箱
					//校验手机号是否为11位
					var re = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/;//邮箱正则表达式
					if(re.test(value)){
						$(this).data('state',1);
						$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
						$('.errorText-'+id).html('');
						$('.formError-'+id).hide();
					}else{
						$(this).data('state',3);
						$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
						$('.errorText-'+id).html('邮箱格式错误！');
						$('.formError-'+id).show();
					}
				}else if($(this).data('checktype')==3){
					//校验是否为纯数字
					var re = /^[0-9]*$/;//纯数字正则表达式
					if(re.test(value)){
						$(this).data('state',1);
						$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
						$('.errorText-'+id).html('');
						$('.formError-'+id).hide();
					}else{
						$(this).data('state',3);
						$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
						$('.errorText-'+id).html($(this).data('title')+'不是纯数字！');
						$('.formError-'+id).show();
					}
				}else if($(this).data('checktype')==4){
					//校验是否为n位的数字（依赖length参数）
					var length = $(this).data('length');
					if(length!=undefined){
						var re = new RegExp('^\\d{'+length+'}$');//n位纯数字正则表达式
						if(re.test(value)){
							$(this).data('state',1);
							$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
							$('.errorText-'+id).html('');
							$('.formError-'+id).hide();
						}else{
							$(this).data('state',3);
							$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
							$('.errorText-'+id).html($(this).data('title')+'不是'+length+'位纯数字！');
							$('.formError-'+id).show();
						}
					}else{
						//校验是否为纯数字
						var re = /^[0-9]*$/;//纯数字正则表达式
						if(re.test(value)){
							$(this).data('state',1);
							$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
							$('.errorText-'+id).html('');
							$('.formError-'+id).hide();
						}else{
							$(this).data('state',3);
							$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
							$('.errorText-'+id).html($(this).data('title')+'不是纯数字！');
							$('.formError-'+id).show();
						}
					}
				}else if($(this).data('checktype')==5){
					//校验是否为至少n位数字（依赖length参数）
					var length = $(this).data('length');
					if(length!=undefined){
						//var re = /^\d{length,}$/;//至少n位数字正则表达式
						var re = new RegExp('^\\d{'+length+',}$');//至少n位数字正则表达式
						if(re.test(value)){
							$(this).data('state',1);
							$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
							$('.errorText-'+id).html('');
							$('.formError-'+id).hide();
						}else{
							$(this).data('state',3);
							$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
							$('.errorText-'+id).html($(this).data('title')+'不得少于'+length+'位纯数字！');
							$('.formError-'+id).show();
						}
					}else{
						//校验是否为纯数字
						var re = /^[0-9]*$/;//纯数字正则表达式
						if(re.test(value)){
							$(this).data('state',1);
							$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
							$('.errorText-'+id).html('');
							$('.formError-'+id).hide();
						}else{
							$(this).data('state',3);
							$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
							$('.errorText-'+id).html($(this).data('title')+'不是纯数字！');
							$('.formError-'+id).show();
						}
					}
				}else if($(this).data('checktype')==6){
					//校验是否为m-n位的数字（依赖slength、olength参数）
					var slength = $(this).data('slength');
					var olength = $(this).data('olength');
					if(slength!=undefined && olength!=undefined){
						//var re = /^\d{slength,olength}$/;//m-n位的数字正则表达式
						var re = new RegExp('^\\d{'+slength+','+olength+'}$');//m-n位的数字正则表达式
						if(re.test(value)){
							$(this).data('state',1);
							$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
							$('.errorText-'+id).html('');
							$('.formError-'+id).hide();
						}else{
							$(this).data('state',3);
							$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
							$('.errorText-'+id).html($(this).data('title')+'不得少于'+slength+'位或多于'+olength+'位纯数字！');
							$('.formError-'+id).show();
						}
					}else{
						//校验是否为纯数字
						var re = /^[0-9]*$/;//纯数字正则表达式
						if(re.test(value)){
							$(this).data('state',1);
							$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
							$('.errorText-'+id).html('');
							$('.formError-'+id).hide();
						}else{
							$(this).data('state',3);
							$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
							$('.errorText-'+id).html($(this).data('title')+'不是纯数字！');
							$('.formError-'+id).show();
						}
					}
				}else if($(this).data('checktype')==7){
					//校验是否为有两位小数的正实数 
					var re = /^[0-9]+(.[0-9]{2})?$/;//有两位小数的正实数正则表达式
					if(re.test(value)){
						$(this).data('state',1);
						$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
						$('.errorText-'+id).html('');
						$('.formError-'+id).hide();
					}else{
						$(this).data('state',3);
						$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
						$('.errorText-'+id).html($(this).data('title')+'格式非法！');
						$('.formError-'+id).show();
					}
				}else if($(this).data('checktype')==8){
					//校验用户存在类型非法时，默认校验用户存在
					if($(this).data('useronly')!=1 && $(this).data('useronly')!=2 ){
						$(this).data('useronly',1);
					}
					//校验用户类型非法时，默认校验全部用户
					if($(this).data('userchecktype')!=1 && $(this).data('userchecktype')!=2 && $(this).data('userchecktype')!=3 && $(this).data('userchecktype')!=4 && $(this).data('userchecktype')!=5 && $(this).data('userchecktype')!=6 && $(this).data('userchecktype')!=7){
						$(this).data('userchecktype',7);
					}
					//校验手机号或邮箱时进行校验
					if($(this).data('userchecktype') == 2 || $(this).data('userchecktype') == 3){
						if($(this).data('userchecktype') == 2){
							//校验手机
							//校验是否为手机号
							//校验手机号是否为11位
							var re = /^1\d{10}$/;//手机正则表达式
							if(re.test(value)){
								//进行唯一校验
								//校验是否为有两位小数的正实数 
								if($(this).data('useronly')==1){
									$.ajax({
										// 地址
										url:WEBURL+"/User/registerUserOnly",
										//传送方式
										type:'post',
										//数据类型
										dataType:'json',
										//数据
										data: "value="+value+"&type="+$(this).data('userchecktype'),
										//成功执行函数
										success:function(data){
											if(data){
												if(data.status!=1){
													input.data('state',3);
													input.css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
													$('.errorText-'+id).html('账户不存在！');
													$('.formError-'+id).show();
												}else{
													input.data('state',1);
													input.css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
													$('.errorText-'+id).html('');
													$('.formError-'+id).hide();
												}
											}
										}
									});
								}else{
									$.ajax({
										// 地址
										url:WEBURL+"/User/registerUserOnly",
										//传送方式
										type:'post',
										//数据类型
										dataType:'json',
										//数据
										data: "value="+value+"&type="+$(this).data('userchecktype'),
										//成功执行函数
										success:function(data){
											if(data){
												if(data.status!=5){
													input.data('state',3);
													input.css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
													$('.errorText-'+id).html('账户存在！');
													$('.formError-'+id).show();
												}else{
													input.data('state',1);
													input.css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
													$('.errorText-'+id).html('');
													$('.formError-'+id).hide();
												}
											}
										}
									});
								}
							}else{
								$(this).data('state',3);
								$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
								$('.errorText-'+id).html('手机号格式错误！');
								$('.formError-'+id).show();
							}
						}else{
							//校验邮箱
							var re = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/;//邮箱正则表达式
							if(re.test(value)){
								//进行唯一校验
								//校验是否为有两位小数的正实数 
								if($(this).data('useronly')==1){
									$.ajax({
										// 地址
										url:WEBURL+"/User/registerUserOnly",
										//传送方式
										type:'post',
										//数据类型
										dataType:'json',
										//数据
										data: "value="+value+"&type="+$(this).data('userchecktype'),
										//成功执行函数
										success:function(data){
											if(data){
												if(data.status!=1){
													input.data('state',3);
													input.css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
													$('.errorText-'+id).html('账户不存在！');
													$('.formError-'+id).show();
												}else{
													input.data('state',1);
													input.css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
													$('.errorText-'+id).html('');
													$('.formError-'+id).hide();
												}
											}
										}
									});
								}else{
									$.ajax({
										// 地址
										url:WEBURL+"/User/registerUserOnly",
										//传送方式
										type:'post',
										//数据类型
										dataType:'json',
										//数据
										data: "value="+value+"&type="+$(this).data('userchecktype'),
										//成功执行函数
										success:function(data){
											if(data){
												if(data.status!=5){
													input.data('state',3);
													input.css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
													$('.errorText-'+id).html('账户存在！');
													$('.formError-'+id).show();
												}else{
													input.data('state',1);
													input.css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
													$('.errorText-'+id).html('');
													$('.formError-'+id).hide();
												}
											}
										}
									});
								}
							}else{
								$(this).data('state',3);
								$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
								$('.errorText-'+id).html('邮箱格式错误！');
								$('.formError-'+id).show();
							}
						}
					}else{
						//校验是否为有两位小数的正实数 
						if($(this).data('useronly')==1){
							$.ajax({
								// 地址
								url:WEBURL+"/User/registerUserOnly",
								//传送方式
								type:'post',
								//数据类型
								dataType:'json',
								//数据
								data: "value="+value+"&type="+$(this).data('userchecktype'),
								//成功执行函数
								success:function(data){
									if(data){
										if(data.status!=1){
											input.data('state',3);
											input.css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
											$('.errorText-'+id).html('账户不存在！');
											$('.formError-'+id).show();
										}else{
											input.data('state',1);
											input.css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
											$('.errorText-'+id).html('');
											$('.formError-'+id).hide();
										}
									}
								}
							});
						}else{
							$.ajax({
								// 地址
								url:WEBURL+"/User/registerUserOnly",
								//传送方式
								type:'post',
								//数据类型
								dataType:'json',
								//数据
								data: "value="+value+"&type="+$(this).data('userchecktype'),
								//成功执行函数
								success:function(data){
									if(data){
										if(data.status!=5){
											input.data('state',3);
											input.css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
											$('.errorText-'+id).html('账户存在！');
											$('.formError-'+id).show();
										}else{
											input.data('state',1);
											input.css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
											$('.errorText-'+id).html('');
											$('.formError-'+id).hide();
										}
									}
								}
							});
						}
					}
				}else if($(this).data('checktype')==9){
					//校验密码
					//校验密码长度范围不存在时给予默认值
					if($(this).data('slength')==undefined || $(this).data('olength')==undefined ){
						$(this).data('slength',6);
						$(this).data('olength',18);
					}
					var slength = $(this).data('slength');
					var olength = $(this).data('olength');
					slength = slength-1;
					olength = olength-1;
					//校验手机号是否为11位
					//var re = /^[a-zA-Z]\w{5,17}$/;//以字母开头，长度在6-18之间，只能包含字符、数字和下划线。正则表达式
					var re = new RegExp('^[a-zA-Z]\\w{'+slength+','+olength+'}$');//m-n位的数字正则表达式
					if(re.test(value)){
						$(this).data('state',1);
						$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
						$('.errorText-'+id).html('');
						$('.formError-'+id).hide();
					}else{
						$(this).data('state',3);
						$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
						$('.errorText-'+id).html('密码格式错误！以字母开头，长度在'+$(this).data('slength')+'-'+$(this).data('olength')+'之间，只能包含字符、数字和下划线。');
						$('.formError-'+id).show();
					}
				}else if($(this).data('checktype')==10){
					//校验重复密码
					if($('#'+$(this).data('passid')).val()){
						if($('#'+$(this).data('passid')).val()==value){
							$(this).data('state',1);
							$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
							$('.errorText-'+id).html('');
							$('.formError-'+id).hide();
						}else{
							$(this).data('state',3);
							$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
							$('.errorText-'+id).html('密码不一致！');
							$('.formError-'+id).show();
						}
					}else{
						$(this).data('state',1);
						$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
						$('.errorText-'+id).html('');
						$('.formError-'+id).hide();
					}
				}else if($(this).data('checktype')==11){
					//校验验证码
					if($(this).data('verifysign')!=undefined){
						$.ajax({
							// 地址
							url:WEBURL+"/Common/verifyCheck",
							//传送方式
							type:'post',
							//数据类型
							dataType:'json',
							//数据
							data: "verify="+value+"&sign="+$(this).data('verifysign'),
							//成功执行函数
							success:function(data){
								if(data){
									if(data.status!=1){
										input.data('state',3);
										input.css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
										$('.errorText-'+id).html('验证码错误！');
										$('.formError-'+id).show();
									}else{
										input.data('state',1);
										input.css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
										$('.errorText-'+id).html('');
										$('.formError-'+id).hide();
									}
								}
							}
						});
					}else{
						$(this).data('state',1);
						$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
						$('.errorText-'+id).html('');
						$('.formError-'+id).hide();
					}
				}else if($(this).data('checktype')==12){
					//身份证校验
					var re = /^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/;//身份证正则表达式
					if(re.test(value)){
						if(value.length==18){
							var idCardWi=new Array( 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ); //将前17位加权因子保存在数组里
							var idCardY=new Array( 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ); //这是除以11后，可能产生的11位余数、验证码，也保存成数组
							var idCardWiSum=0; //用来保存前17位各自乖以加权因子后的总和
							for(var i=0;i<17;i++){
								idCardWiSum+=value.substring(i,i+1)*idCardWi[i];
							}
							var idCardMod=idCardWiSum%11;//计算出校验码所在数组的位置
							var idCardLast=value.substring(17);//得到最后一位身份证号码
							//如果等于2，则说明校验码是10，身份证号码最后一位应该是X
							if(idCardMod==2){
								if(idCardLast=="X"||idCardLast=="x"){
									//校验地区
									//var cityarray={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江 ",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北 ",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏 ",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"}
									var cityarray=['11','12','13','14','15','21','22','23','31','32','33','34','35','36','37','41','42','43','44','45','46','50','51','52','53','54','61','62','63','64','65','71','81','82','91'];
									if(cityarray.indexOf(value.substr(0,2))>-1){
										//身份证校验格式通过，等待校验唯一
										if($(this).data('useronly')==1 || $(this).data('useronly')==2){
										//进行用户唯一校验	
											$.ajax({
												// 地址
												url:WEBURL+"/User/idCardOnly",
												//传送方式
												type:'post',
												//数据类型
												dataType:'json',
												//数据
												data: "idcard="+value,
												//成功执行函数
												success:function(data){
													if(data){
														if($(this).data('useronly')==1){
															//不存在报错
															if(data.status==1){
																input.data('state',1);
																input.css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
																input.data('errorstr','');
																$('.errorText-'+id).html('');
																$('.formError-'+id).hide();
															}else{
																input.data('state',3);
																input.css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
																input.data('errorstr','该身份证号码不存在！');
																$('.errorText-'+id).html('该身份证号码不存在！');
																$('.formError-'+id).show();
															}
														}else{
															//存在报错
															if(data.status==3){
																input.data('state',1);
																input.css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
																input.data('errorstr','');
																$('.errorText-'+id).html('');
																$('.formError-'+id).hide();
															}else{
																input.data('state',3);
																input.css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
																input.data('errorstr','该身份证号码已存在！');
																$('.errorText-'+id).html('该身份证号码已存在！');
																$('.formError-'+id).show();
															}
														}
													}
												}
											});
										}else{
											$(this).data('state',1);
											$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
											$(this).data('errorstr','');
											$('.errorText-'+id).html('');
											$('.formError-'+id).hide();
										}
									}else{
										$(this).data('state',3);
										$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
										$(this).data('errorstr','身份证号码错误！');
										$('.errorText-'+id).html('身份证号码错误！');
										$('.formError-'+id).show();
									}
								}else{
									$(this).data('state',3);
									$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
									$(this).data('errorstr','身份证号码错误！');
									$('.errorText-'+id).html('身份证号码错误！');
									$('.formError-'+id).show();
								}
							}else{
								//用计算出的验证码与最后一位身份证号码匹配，如果一致，说明通过，否则是无效的身份证号码
								if(idCardLast==idCardY[idCardMod]){
									//校验地区
									//var cityarray={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江 ",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北 ",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏 ",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"}
									var cityarray=['11','12','13','14','15','21','22','23','31','32','33','34','35','36','37','41','42','43','44','45','46','50','51','52','53','54','61','62','63','64','65','71','81','82','91'];
									if(cityarray.indexOf(value.substr(0,2))>-1){
										//身份证校验格式通过，等待校验唯一
										if($(this).data('useronly')==1 || $(this).data('useronly')==2){
										//进行用户唯一校验	
											$.ajax({
												// 地址
												url:WEBURL+"/User/idCardOnly",
												//传送方式
												type:'post',
												//数据类型
												dataType:'json',
												//数据
												data: "idcard="+value,
												//成功执行函数
												success:function(data){
													if(data){
														if($(this).data('useronly')==1){
															//不存在报错
															if(data.status==1){
																input.data('state',1);
																input.css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
																input.data('errorstr','');
																$('.errorText-'+id).html('');
																$('.formError-'+id).hide();
															}else{
																input.data('state',3);
																input.css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
																input.data('errorstr','该身份证号码不存在！');
																$('.errorText-'+id).html('该身份证号码不存在！');
																$('.formError-'+id).show();
															}
														}else{
															//存在报错
															if(data.status==3){
																input.data('state',1);
																input.css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
																input.data('errorstr','');
																$('.errorText-'+id).html('');
																$('.formError-'+id).hide();
															}else{
																input.data('state',3);
																input.css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
																input.data('errorstr','该身份证号码已存在！');
																$('.errorText-'+id).html('该身份证号码已存在！');
																$('.formError-'+id).show();
															}
														}
													}
												}
											});
										}else{
											$(this).data('state',1);
											$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
											$(this).data('errorstr','');
											$('.errorText-'+id).html('');
											$('.formError-'+id).hide();
										}
									}else{
										$(this).data('state',3);
										$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
										$(this).data('errorstr','身份证号码错误！');
										$('.errorText-'+id).html('身份证号码错误！');
										$('.formError-'+id).show();
									}
								}else{
									$(this).data('state',3);
									$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
									$(this).data('errorstr','身份证号码错误！');
									$('.errorText-'+id).html('身份证号码错误！');
									$('.formError-'+id).show();
								}
							}
						}
					}else{
						$(this).data('state',3);
						$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
						$(this).data('errorstr','身份证格式错误！');
						$('.errorText-'+id).html('身份证格式错误！');
						$('.formError-'+id).show();
					}
				}
			}else{
				//只需要校验是否为空其他都不需要
				$(this).data('state',1);
				$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
				$('.errorText-'+id).html('');
				$('.formError-'+id).hide();
			}
			//为空报错
			
		}else{
			$(this).data('state',3);
			$(this).css({ "border": "1px solid #ff6569", "box-shadow": "0 0 2px #fda3a5" });
			$('.errorText-'+id).html($(this).data('title')+'不能为空！');
			$('.formError-'+id).show();
		}
	}else{
		//不需要任何校验
		$(this).data('state',1);
		$(this).css({ "border": "1px solid #a0a0a0", "box-shadow": "none" });
		$('.errorText-'+id).html('');
		$('.formError-'+id).hide();
	}
});
//验证码点击获取
//验证码切换
/* $('.verificationPic').click(function(){
	var sign = $(this).data('sign');
	$('.verificationPic').attr("src",WEBURL+"/Common/verifyCreate/sign/"+sign+"/sj/"+parseInt(10*Math.random()));
}); */
//短信发送
$('.PhoneSmsVerifyBtn').click(function(){
	if($(this).data('inputdataid')!=undefined && $(this).data('phoneid')!=undefined && $(this).data('sign')!=undefined){
		var id = $(this).data('inputdataid');
		//校验手机号输入框的状态
		if($('#'+$(this).data('phoneid')).data('state')==1){
			//校验手机号合法性
			var phone = $('#'+$(this).data('phoneid')).val();
			var time = $('#'+$(this).data('phoneid')).val();
			if($(this).data('time')==undefined){
				var time = 60;
			}else{
				var time = $(this).data('time');
			}
			//校验是否为手机号
			//校验手机号是否为11位
			var re = /^1\d{10}$/;//手机正则表达式
			if(re.test(phone)){
				$('.errorText-'+id).html('');
				$('.formError-'+id).hide();
				//执行发送短信请求
				$.ajax({
					// 地址
					url:WEBURL+"/Common/verifySMSCreateSend",
					//传送方式
					type:'post',
					//数据类型
					dataType:'json',
					//数据
					data: "phone="+phone+"&sign="+$(this).data('sign'),
					//成功执行函数
					success:function(data){
						if(data){
							if(data.status==1){
								$(this).data('state',1);
								PhoneSMSBtnTime(time);
							}else{
								$(this).data('state',3);
							}
						}
					}
				});
			}else{
				$('.errorText-'+id).html('手机号格式非法！');
				$('.formError-'+id).show();
			}
		}else{
			$('.errorText-'+id).html('手机号校验失败！');
			$('.formError-'+id).show();
		}
	}
});
//发送手机短信定时
function PhoneSMSBtnTime(times){
	setTimeout(function(){
		if(times == 0){
			//解除锁定Button按钮
			$(".PhoneSmsVerifyBtn").val("获取短信验证码");
			$(".PhoneSmsVerifyBtn").removeAttr("disabled");
		}else{
			//锁定Button按钮
			$(".PhoneSmsVerifyBtn").attr("disabled","disabled");
			$(".PhoneSmsVerifyBtn").val(times+"秒后重新发送");
			times--;
			PhoneSMSBtnTime(times);
		}
		
	},1000);	
}
//提交校验各表单项状态 表单项通过校验返回TRUE 表单项未通过校验返回FALSE
function inputsubmit(){
	var state = 1;
	$('.inputTxt').each(function(){
		//判断是否为错误状态，如果不是错误状态，则执行灰色边框初始化
		if($(this).data('state')!=1){
			state = 2;
		}
	});
	if(state ==1){
		return true;
	}else{
		return false;
	}
}
//***************************************************************************************************
//*******************************************复选框**************************************************
//***************************************************************************************************
//单项复选框操作
$('.formCheckbox').click(function(){
	if($(this).data('state')==1){
		//去除选中样式
		$(this).removeClass("icon-check");
		//增加未选中样式
		$(this).addClass("icon-check-empty");
		if($(this).data('textname')!=undefined && $(this).data('cname')!=undefined){
			formCheckboxInput(2,$(this).data('name'),$(this).data('id'),$(this).data('textname'),$(this).data('cname'));
		}else{
			formCheckboxInput(2,$(this).data('name'),$(this).data('id'));
		}	
		//更新缓存状态
		$(this).data('state',2);
	}else{
		//去除未选中样式
		$(this).removeClass("icon-check-empty");
		//增加选中样式
		$(this).addClass("icon-check");
		if($(this).data('textname')!=undefined && $(this).data('cname')!=undefined){
			formCheckboxInput(1,$(this).data('name'),$(this).data('id'),$(this).data('textname'),$(this).data('cname'));
		}else{
			formCheckboxInput(1,$(this).data('name'),$(this).data('id'));
		}
		//更新缓存状态
		$(this).data('state',1);
	}
});
//反选操作
$('.formCheckboxReverseSelect').click(function(){
	var name = $(this).data('name');
	//执行反选
	$('.formCheckbox-'+name).each(function(i){
		if($(this).data('state')==1){
			//执行增加未选中样式
			//去除选中样式
			$(this).removeClass("icon-check");
			//增加未选中样式
			$(this).addClass("icon-check-empty");
			formCheckboxInput(2,$(this).data('name'),$(this).data('id'));
			//更新缓存状态
			$(this).data('state',2);
		}else{
			//执行增加选中样式
			//去除未选中样式
			$(this).removeClass("icon-check-empty");
			//增加选中样式
			$(this).addClass("icon-check");
			formCheckboxInput(1,$(this).data('name'),$(this).data('id'));
			//更新缓存状态
			$(this).data('state',1);
		}
	});
});
//全选/全不选操作
$('.formCheckboxSelect').click(function(){
	var name = $(this).data('name');
	var state = $(this).data('state');
	if(state==2){
		//执行全选
		$('.formCheckbox-'+name).each(function(i){
			if($(this).data('state')!=1){
				//执行增加选中样式
				//去除未选中样式
				$(this).removeClass("icon-check-empty");
				//增加选中样式
				$(this).addClass("icon-check");
				formCheckboxInput(1,name,$(this).data('id'));
				//更新缓存状态
				$(this).data('state',1);
			}
		});
		//执行增加全选样式
		//去除未选中样式
		$(this).removeClass("icon-check-empty");
		//增加选中样式
		$(this).addClass("icon-check");
		//更新提示语
		$(this).attr("title","全不选");
		//更新缓存状态
		$(this).data('state',1);
	}else{
		//执行全不选
		$('.formCheckbox-'+name).each(function(i){
			if($(this).data('state')!=2){
				//执行增加未选中样式
				//去除选中样式
				$(this).removeClass("icon-check");
				//增加未选中样式
				$(this).addClass("icon-check-empty");
				formCheckboxInput(2,name,$(this).data('id'));
				//更新缓存状态
				$(this).data('state',2);
			}
		});
		//执行增加全不选样式
		//去除选中样式
		$(this).removeClass("icon-check");
		//增加未选中样式
		$(this).addClass("icon-check-empty");
		//更新提示语
		$(this).attr("title","全选");
		//更新缓存状态
		$(this).data('state',2);
	}
});
//ID组处理函数
//type 处理类型 1增加元素 2去除元素
//name 操作的ID组名
//id 元素值
function formCheckboxInput(type,name,id,textname,cname){
	var dataOne = $('.Checkbox-'+name).val();
	var dataTwo = $('.Checkboxtext-'+textname).val();
	//拆分字符串(转数组)
	dataOne=dataOne.split(",");
	if(dataTwo){
		dataTwo=dataTwo.split(",");
	}else{
		dataTwo = new Array();
	}
	if(type==1){
		//增加元素
		dataOne.splice(0,0,id);
		dataTwo.splice(0,0,cname);
	}else if(type==2){
		//去除元素
		for(var i=0;i<dataOne.length;i++){
			if(dataOne[i]==id){
				//从数组dataOne的i位置开始删除一个元素
				dataOne.splice(i,1);
			}
		}
		if(dataTwo){
			for(var i=0;i<dataTwo.length;i++){
				if(dataTwo[i]==cname){
					//从数组dataOne的i位置开始删除一个元素
					dataTwo.splice(i,1);
				}
			}
		}
	}
	//使用“,”间隔符将数组dataOne重组成字符串
	dataOne = dataOne.join(",");
	$('.Checkbox-'+name).val(dataOne);	
	if(dataTwo){	
		dataTwo = dataTwo.join(",");
		$('.Checkboxtext-'+textname).val(dataTwo);	
	}
}
//ID组初始化操作
function formCheckboxStar(name,textname){
	var dataOne = $('.Checkbox-'+name).val();
	var dataTwo = $('.Checkboxtext-'+textname).val();
	//拆分字符串(转数组)
	dataOne=dataOne.split(",");
	if(dataTwo){
		dataTwo=dataTwo.split(",");
	}else{
		dataTwo = new Array();
	}
	$('.formCheckbox-'+name).each(function(i){
	   var id = $(this).data('id');
	   var cname = $(this).data('cname');
	   var state = $(this).data('state');
	   for(var i=0;i<dataOne.length;i++){
			if(dataOne[i]==id){
				if(state!=1){
					//执行增加选中样式
					//去除未选中样式
					$(this).removeClass("icon-check-empty");
					//增加选中样式
					$(this).addClass("icon-check");
					//更新缓存状态
					$(this).data('state',1);
					//执行增加选项名称到预览数组中
					dataTwo.splice(0,0,cname);
				}
				//从数组dataOne的i位置开始删除一个元素
				dataOne.splice(i,1);
			}else{
				if(state!=2){
					//执行增加未选中样式
					//去除选中样式
					$(this).removeClass("icon-check");
					//增加未选中样式
					$(this).addClass("icon-check-empty");
					//更新缓存状态
					$(this).data('state',2);
				}
			}
		}
	});
	if(dataTwo){	
		dataTwo = dataTwo.join(",");
		$('.Checkboxtext-'+textname).val(dataTwo);	
	}
}
//================================省市县联动公共类==================================================
//准备联动一
//初始化选择省市县数据
if($("#bLink").data("pid")!=undefined && $("#bLink").data("cid")!=undefined && $("#bLink").data("aid")!=undefined){
	//判断是否启用多级省市联动
	//获取省id
	var  provinceSelect = $("#bLink").data("pid");
	//获取市id
	var  citySelect = $("#bLink").data("cid");
	//获取区id
	var  areaSelect = $("#bLink").data("aid");
	//创建省信息下拉列表
	province(provinceSelect,citySelect,areaSelect);
	$("#"+provinceSelect).change(function(){
		//更新缓存
		$(this).data('id',$(this).val());
		//执行选中
		//市和区执行初始化
		$("#"+citySelect).removeData("id");
		$("#"+areaSelect).removeData("id");
		$("#"+areaSelect).data('id',null);
		$("#"+citySelect).html("<option>--请选择城市--</option>");
		$("#"+areaSelect).html("<option>--请选择区域--</option>");
		city(provinceSelect,citySelect,areaSelect);	
	});

	$("#"+citySelect).change(function(){
		//更新缓存
		$(this).data('id',$(this).val());
		//执行选中
		//市和区执行初始化
		$("#"+areaSelect).data('id',null);
		$("#"+areaSelect).html("<option>--请选择区域--</option>");
		area(citySelect,areaSelect);	
	});
	$("#"+areaSelect).change(function(){
		//更新缓存
		$(this).data('id',$(this).val());
	});
}
//准备联动二
//初始化选择省市县数据
if($("#bLink2").data("pid")!=undefined && $("#bLink2").data("cid")!=undefined && $("#bLink2").data("aid")!=undefined){
	//判断是否启用多级省市联动
	//获取省id
	var  provinceSelect2 = $("#bLink2").data("pid");
	//获取市id
	var  citySelect2 = $("#bLink2").data("cid");
	//获取区id
	var  areaSelect2 = $("#bLink2").data("aid");
	//创建省信息下拉列表
	province(provinceSelect2,citySelect2,areaSelect2);
	$("#"+provinceSelect2).change(function(){
		//更新缓存
		$(this).data('id',$(this).val());
		//执行选中
		//市和区执行初始化
		$("#"+citySelect2).removeData("id");
		$("#"+areaSelect2).removeData("id");
		$("#"+areaSelect2).data('id',null);
		$("#"+citySelect2).html("<option>--请选择城市--</option>");
		$("#"+areaSelect2).html("<option>--请选择区域--</option>");
		city(provinceSelect2,citySelect2,areaSelect2);	
	});

	$("#"+citySelect2).change(function(){
		//更新缓存
		$(this).data('id',$(this).val());
		//执行选中
		//市和区执行初始化
		$("#"+areaSelect2).data('id',null);
		$("#"+areaSelect2).html("<option>--请选择区域--</option>");
		area(citySelect2,areaSelect2);	
	});
	$("#"+areaSelect2).change(function(){
		//更新缓存
		$(this).data('id',$(this).val());
	});
}
//准备联动一
//初始化选择省市县数据
if($("#bLink3").data("pid")!=undefined && $("#bLink3").data("cid")!=undefined && $("#bLink3").data("aid")!=undefined){
	//判断是否启用多级省市联动
	//获取省id
	var  provinceSelect3 = $("#bLink3").data("pid");
	//获取市id
	var  citySelect3 = $("#bLink3").data("cid");
	//获取区id
	var  areaSelect3 = $("#bLink3").data("aid");
	//创建省信息下拉列表
	province(provinceSelect3,citySelect3,areaSelect3);
	$("#"+provinceSelect3).change(function(){
		//更新缓存
		$(this).data('id',$(this).val());
		//执行选中
		//市和区执行初始化
		$("#"+citySelect3).removeData("id");
		$("#"+areaSelect3).removeData("id");
		$("#"+areaSelect3).data('id',null);
		$("#"+citySelect3).html("<option>--请选择城市--</option>");
		$("#"+areaSelect3).html("<option>--请选择区域--</option>");
		city(provinceSelect3,citySelect3,areaSelect3);	
	});

	$("#"+citySelect3).change(function(){
		//更新缓存
		$(this).data('id',$(this).val());
		//执行选中
		//市和区执行初始化
		$("#"+areaSelect3).data('id',null);
		$("#"+areaSelect3).html("<option>--请选择区域--</option>");
		area(citySelect3,areaSelect3);	
	});
	$("#"+areaSelect3).change(function(){
		//更新缓存
		$(this).data('id',$(this).val());
	});
}

//获取省信息的方法
function province(provinceName,cityName,areaName){
	var provinceId = $("#"+provinceName);
	$("#"+provinceName).html("<option>--请选择省份--</option>");
	$("#"+cityName).html("<option>--请选择城市--</option>");
	$("#"+areaName).html("<option>--请选择区域--</option>");
	$.ajax({
		url:WEBURL+'/Common/CityList',
		type:'post',
		data:'pid=6'+'&level=2',
		success:function(data){
			if(data.status == 1){
				var citylistNum = data.citylist.length;
				for(var i=0;i<citylistNum;i++){
					var provinceSelectId = provinceId.data("id");
					if(data.citylist[i].id == provinceSelectId){
						provinceId.append(
							"<option class='cityData' value='"+data.citylist[i].id+"' selected>"+data.citylist[i].name+"</option>"
						);
					}else{
						provinceId.append(
							"<option class='cityData' value='"+data.citylist[i].id+"'>"+data.citylist[i].name+"</option>"
						);
					}
				}
			}
		}
	});	
	//创建市信息下拉列表
	if($("#"+provinceName).data('id')>0){
		city(provinceName,cityName,areaName);
	}
}
//获取市信息的方法
function city(provinceName,cityName,areaName){
	var provinceId = $("#"+provinceName).data('id');
	var cityId = $("#"+cityName);
	$.ajax({
		url:WEBURL+'/Common/CityList',
		type:'post',
		data:'pid='+provinceId+'&level=3',
		success:function(data){
			if(data.status == 1){
				var citylistNum = data.citylist.length;
				for(var i=0;i<citylistNum;i++){
					var citySelectId = cityId.data("id");
					if(data.citylist[i].id == citySelectId){
						cityId.append(
							"<option class='cityData' value='"+data.citylist[i].id+"' selected>"+data.citylist[i].name+"</option>"
						);
					}else{
						cityId.append(
							"<option class='cityData' value='"+data.citylist[i].id+"'>"+data.citylist[i].name+"</option>"
						);
					}
				}
			}
		}
	});	
	//创建区域信息下拉列表
	if($("#"+cityName).data('id')>0){
		area(cityName,areaName);
	}
}
//获取区域信息的方法
function area(cityName,areaName){
	var cityId = $("#"+cityName).data('id');
	var areaId = $("#"+areaName);
	$.ajax({
		url:WEBURL+'/Common/CityList',
		type:'post',
		data:'pid='+cityId+'&level=4',
		success:function(data){
			if(data.status == 1){
				var citylistNum = data.citylist.length;
				for(var i=0;i<citylistNum;i++){
					var areaSelectId = areaId.data("id");					
					if(data.citylist[i].id == areaSelectId){
						areaId.append(
							"<option class='cityData' value='"+data.citylist[i].id+"' selected>"+data.citylist[i].name+"</option>"
						);
					}else{
						areaId.append(
							"<option class='cityData' value='"+data.citylist[i].id+"'>"+data.citylist[i].name+"</option>"
						);
					}
				}
			}
		}
	});	
}
//================================省市县联动公共类==================================================

//================================弹层类==================================================
//创建背景层
$("body").append("<div id='popupBg' style='width: 100%; z-index: 99; height: 100%; position: fixed; top: 0px; left: 0px; background: rgba(0, 0, 0, 0.5) none repeat scroll 0px 0px;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#7F000000,endColorstr=#7F000000);display:none'></div>");

//***************************************************************************************************
//*******************************************错误层**************************************************
//***************************************************************************************************

//错误弹层
function ErrorPopupLayer(content){
	//创建错误层
	var errorDiv  = "<div id='ErrorPopupLayer' style='background-color: #FFFFFF;left: "+($(window).width()-700)/2+"px;position: fixed;top: -400px;width: 700px;z-index: 100;border-radius: 10px 10px 20px 20px;'>";
		errorDiv += "<div class='PopupBody' style='background-color:#E6E9E9;border-radius: 10px 10px 0px 0px;margin:10px 10px 0px 10px;'>";
		errorDiv += "<p class='text-danger text-center error-ErrorPopupLayer' style='margin:0px;line-height:320px;font-size:24px;color:#668db8;'><span class='icon-info-sign' style='color:#FF6569;padding-right:30px;font-size:40px'></span>"+content+"</p>";
		errorDiv += "</div>";
		errorDiv += "<div class='PopupFooter' style='width:100%;line-height:70px;text-align:center;font-size:30px;color:#668db8;background-color: #FFFFFF;border-radius: 0 0 20px 20px;cursor:pointer;'>";
		errorDiv += "<span class='PopupFooterTrue ErrorSure' data-name='ErrorPopupLayer'>确&nbsp;&nbsp;&nbsp;&nbsp;定</span>";
		errorDiv += "</div>";
		errorDiv += "<span class='PopupLayerClose' style='color: #E6E9E9;font-size: 100px;position: fixed;right: 50px;top: 30px;z-index: 101;cursor:pointer;'>×</span>";
		errorDiv += "</div>";
	$("body").append(errorDiv);
	//初始化错误层位置
	$("#ErrorPopupLayer").css("top","-"+$('#ErrorPopupLayer').height()+"px");
	//展示错误层
	$("#popupBg").slideDown(function(){
		var height = ($(window).height()-$('#ErrorPopupLayer').height())/2
		//height = height + 400;
		$('#ErrorPopupLayer').animate({top: '+'+height+'px'}, "slow");

	});
}
//关闭层鼠标移入移出事件
$('body').on('mouseover', '#ErrorPopupLayer .PopupFooter', function() { 
  $("#ErrorPopupLayer .PopupFooter").css({ "color": "#FFFFFF", "background-color": "#668db8" });
});
$('body').on('mouseout', '#ErrorPopupLayer .PopupFooter', function() { 
  $("#ErrorPopupLayer .PopupFooter").css({ "color": "#668db8", "background-color": "#FFFFFF" });
});
$('body').on('mouseover', '#ErrorPopupLayer .PopupLayerClose', function() { 
  $("#ErrorPopupLayer .PopupLayerClose").css("color","#FF6569");
});
$('body').on('mouseout', '#ErrorPopupLayer .PopupLayerClose', function() { 
  $("#ErrorPopupLayer .PopupLayerClose").css("color","#E6E9E9");
});
//关闭并清除错误层
$('body').on('click', '#ErrorPopupLayer .PopupFooter', function() { 
	$('#ErrorPopupLayer').animate({top: '-'+$('#ErrorPopupLayer').height()+'px'}, "slow",function(){
		$('#ErrorPopupLayer').remove();
		$("#popupBg").slideUp();
	});
});
$('body').on('click', '#ErrorPopupLayer .PopupLayerClose', function() { 
	$('#ErrorPopupLayer').animate({top: '-'+$('#ErrorPopupLayer').height()+'px'}, "slow",function(){
		$('#ErrorPopupLayer').remove();
		$("#popupBg").slideUp();
	});
});

//***************************************************************************************************
//******************************************图片弹层*************************************************
//***************************************************************************************************
function popupLayerIMG(src,ImgState){
	//创建图片弹层
	var Imgsrc = URL+'/'+src;
	//var ImgState = imgExist(Imgsrc);
	var ImgState = true;
	//alert(imgExist(Imgsrc));
	var DocumentHeight = $(document).height();
	if(ImgState){
		var ImgDiv  = "<div id='popupLayerIMGDiv'>";
			ImgDiv += "<img id='popupLayerIMG' src='"+Imgsrc+"' style='display:none'>";
			ImgDiv += "<span class='PopupLayerClose' style='color: #E6E9E9;font-size: 100px;position: fixed;right: 50px;top: 30px;z-index: 101;cursor:pointer;'>×</span>";
			ImgDiv += "</div>";
		$("body").append(ImgDiv);
		//初始化图片弹层样式
		//图片加载完成后执行
		$('#popupLayerIMG').load(function(){
			var Img = $('#popupLayerIMG');
			//图片宽度改变状态
			var ImgWidthState = 1;
			if(Img.width()>$(window).width()){
				Img.css('width',$(window).width()*0.8);
				ImgWidthState = 2;
			}
			if(Img.height()>DocumentHeight){
				//图片高度大于文档高度
				Img.css({ "position": "absolute", "top": "0px", "left": ($(window).width()-Img.width())/2+"px", "display": "none" , "z-index": "100"});
				//标记高度状态，为关闭后恢复页面原样做准备
				$('#popupLayerIMGDiv .PopupLayerClose').data('heightState',1);
				$("#popupBg").show(function(){
					Img.show();
				});
			}else if(Img.height()>$(window).height()){
				//图片高度大于可视屏幕高度
				Img.css({ "position": "absolute", "top": (DocumentHeight-Img.height())/2+"px", "left": ($(window).width()-Img.width())/2+"px", "display": "none" , "z-index": "100"});
				//标记高度状态，为关闭后恢复页面原样做准备
				$('#popupLayerIMGDiv .PopupLayerClose').data('heightState',2);
				//展示图片层
				$("#popupBg").slideDown(function(){
					Img.show();
				});
			}else{
				Img.css({ "position": "fixed", "top": "-"+Img.height()+"px", "left": ($(window).width()-Img.width())/2+"px" , "z-index": "100"});
				//标记高度状态，为关闭后恢复页面原样做准备
				$('#popupLayerIMGDiv .PopupLayerClose').data('heightState',3);
				//展示图片层
				Img.show();
				$("#popupBg").slideDown(function(){
					Img.animate({top: '+'+($(window).height()-Img.height())/2+'px'}, "slow");
				});
			}
		});
	}else{
		ErrorPopupLayer("图片加载失败！")
	}
	
}
//图片层鼠标移入移出事件
$('body').on('mouseover', '#popupLayerIMGDiv .PopupLayerClose', function() { 
  $("#popupLayerIMGDiv .PopupLayerClose").css("color","#FF6569");
});
$('body').on('mouseout', '#popupLayerIMGDiv .PopupLayerClose', function() { 
  $("#popupLayerIMGDiv .PopupLayerClose").css("color","#E6E9E9");
});
//关闭并清除图片层
$('body').on('click', '#popupLayerIMGDiv .PopupLayerClose', function() {
	if($('#popupLayerIMGDiv .PopupLayerClose').data('heightState')==3){
		$('#popupLayerIMG').animate({top: '-'+$('#popupLayerIMG').height()+'px'}, "slow",function(){
			$('#popupLayerIMGDiv').remove();
			$("#popupBg").slideUp();
		});
	}else{
		//执行默认删除		
		$('#popupLayerIMGDiv').hide();
		$('#popupLayerIMGDiv').remove();
		$("#popupBg").slideUp();
	}
	
});
//判断图片是否存在
function imgExist(SRC){
//var oReq = new ActiveXObject("Microsoft.xmlHTTP")
//oReq.open("Get",SRC,false);
//oReq.send();
//alert(oReq.status)
//if(oReq.status==404)
//	return false;
//else
//	return true;
	//创建测试区
	$("body").append("<img id='imgExist' style='display:none'>");
	//进行测试
	$('#imgExist').load(SRC,function(responseText,textStatus,XMLHttpRequest){
	//alert(textStatus);
		if(textStatus=='success'){
			//删除测试区
			$('#imgExist').remove();
			//返回真
			return true;
		}else{
			//删除测试区
			$('#imgExist').remove();
			//返回假
			return false;
		}
	});
}
//***************************************************************************************************
//*****************************************自定义弹层************************************************
//***************************************************************************************************
/*
	说明：创建自定义弹层
	参数：	name	待转为弹层DIV的ID（请保证页面唯一）
	*/
function popupLayer(name){
	var popupDiv = $("#"+name);
	var DocumentHeight = $(document).height();
	//创建关闭按钮
	popupDiv.append("<span class='PopupLayerClose' style='color: #E6E9E9;font-size: 100px;position: fixed;right: 50px;top: 30px;z-index: 101;cursor:pointer;' data-id='"+name+"'>×</span>");
	//图片宽度改变状态
	var IpopupWidthState = 1;
	if(popupDiv.width()>$(window).width()){
		popupDiv.css('width',$(window).width()*0.8);
		IpopupWidthState = 2;
	}
	if(popupDiv.height()>DocumentHeight){
		//弹层高度大于文档高度
		popupDiv.css({ "position": "absolute", "top": "0px", "left": ($(window).width()-popupDiv.width())/2+"px", "display": "none" , "z-index": "100"});
		//标记高度状态，为关闭后恢复页面原样做准备
		$('#'+name+' .PopupLayerClose').data('heightState',1);
	}else if(popupDiv.height()>$(window).height()){
		//弹层高度大于可视屏幕高度
		popupDiv.css({ "position": "absolute", "top": (DocumentHeight-popupDiv.height())/2+"px", "left": ($(window).width()-popupDiv.width())/2+"px", "display": "none" , "z-index": "100"});
		//标记高度状态，为关闭后恢复页面原样做准备
		$('#'+name+' .PopupLayerClose').data('heightState',2);
	}else{
		popupDiv.css({ "position": "fixed", "top": "-"+popupDiv.height()+"px", "left": ($(window).width()-popupDiv.width())/2+"px" , "z-index": "100", "display": "none"});
		//标记高度状态，为关闭后恢复页面原样做准备
		$('#'+name+' .PopupLayerClose').data('heightState',3);
	}
}
//*标题：	展示弹层函数【需先创建】
//*参数：	name为自定义弹层ID名【必填项】
//			width为自定义弹层的宽度，默认为400【选填项】
//			height为自定义弹层的高度，默认为300【选填项】
//*说明：	定义阴影背景层：
//			定义自定义弹层
function popupLayerShow(name){
	var popupDiv = $("#"+name);
	//读取状态
	var heightState = $('#'+name+' .PopupLayerClose').data('heightState');
	if(heightState==1){
		//展示弹层
		$("#popupBg").slideDown(function(){
			popupDiv.show();
		});
	}else if(heightState==2){
		//展示弹层
		$("#popupBg").slideDown(function(){
			popupDiv.show();
		});
	}else if(heightState==3){
		//展示弹层
		popupDiv.show();
		$("#popupBg").slideDown(function(){
			popupDiv.animate({top: '+'+($(window).height()-popupDiv.height())/2+'px'}, "slow");
		});
	}else{
		ErrorPopupLayer("获取弹层资源失败！");
	}
}
//关闭通用层
$('body').on('click', '.GeneralPopup .PopupLayerClose', function() { 
	var heightState = $(this).data('heightState');
	if(heightState==1){
		//弹层隐藏
		$('#'+$(this).data('id')).hide(function(){
			//删除关闭按钮
			$(this).hide();
			//背景层隐藏
			$("#popupBg").slideUp();
		});
	}else if(heightState==2){
		//弹层隐藏
		$('#'+$(this).data('id')).hide(function(){
			//删除关闭按钮
			$(this).hide();
			//背景层隐藏
			$("#popupBg").slideUp();
		});
	}else if(heightState==3){
		//弹层隐藏
		$('#'+$(this).data('id')).animate({top: '-'+$('#'+$(this).data('id')).height()+'px'}, "slow",function(){
			//删除关闭按钮
			$(this).hide();
			//背景层隐藏
			$("#popupBg").slideUp();
		});
	}else{
		ErrorPopupLayer("获取弹层资源失败！");
	}
});
$('body').on('click', '.GeneralPopup .PopupFooterBack', function() { 
	var heightState = $('#'+$(this).data('id')+' .PopupLayerClose').data('heightState');
	if(heightState==1){
		//弹层隐藏
		$('#'+$(this).data('id')).hide(function(){
			//删除关闭按钮
			$(this).hide();
			//背景层隐藏
			$("#popupBg").slideUp();
		});
	}else if(heightState==2){
		//弹层隐藏
		$('#'+$(this).data('id')).hide(function(){
			//删除关闭按钮
			$(this).hide();
			//背景层隐藏
			$("#popupBg").slideUp();
		});
	}else if(heightState==3){
		//弹层隐藏
		$('#'+$(this).data('id')).animate({top: '-'+$('#'+$(this).data('id')).height()+'px'}, "slow",function(){
			//删除关闭按钮
			$(this).hide();
			//背景层隐藏
			$("#popupBg").slideUp();
		});
	}else{
		ErrorPopupLayer("获取弹层资源失败！");
	}
});
//通用层鼠标移入移出事件
$('body').on('mouseover', '.GeneralPopup .PopupLayerClose', function() { 
  $(".GeneralPopup .PopupLayerClose").css("color","#FF6569");
});
$('body').on('mouseout', '.GeneralPopup .PopupLayerClose', function() { 
  $(".GeneralPopup .PopupLayerClose").css("color","#E6E9E9");
});