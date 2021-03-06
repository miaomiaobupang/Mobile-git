<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\UploadFileModel as UploadFile;

// +----------------------------------------------------------------------
// | 爱能社
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://langyue.org All rights reserved.
// +----------------------------------------------------------------------
// | 微校管理
// +----------------------------------------------------------------------
// | Author: 狼啸 <11740390@qq.com>
// +----------------------------------------------------------------------
class SchoolController extends LimitController {
	private $juvenile;//少年表
	private $juvenile_article;//少年文章表
	private $juvenile_resource;//少年资源表
	private $juvenile_stage;//少年阶段表
	private $juvenile_praise;//少年点赞表
	private $home_content;//首页文章表
	private $user;//用户表
	private $city;//省市区县表
	private $school;//学校表
	private $school_activity;//学校活动表
	private $school_activity_apply;//学校活动申请表
	private $school_curriculum;//学校公开课表
	private $school_curriculum_type;//学校公开课类型表
	private $school_curriculum_record;//学校公开课历史记录表
	private $collect;//收藏表
	private $praise;//点赞表
	private $comment;//评论表
	private $message;//私信表
	private $search;//搜索表
	

	
	/**
	 * 构造方法
	 */
	public function __construct() {
		parent::__construct();
		//实例化少年表
		$this->juvenile     = D('juvenile');
		//实例化少年文章表
		$this->juvenile_article     = D('juvenile_article');
		//实例化少年资源表
		$this->juvenile_resource     = D('juvenile_resource');
		//实例化课程少年阶段表
		$this->juvenile_stage     = D('juvenile_stage');
		//实例化课程少年点赞表
		$this->juvenile_praise     = D('juvenile_praise');
		//实例化首页文章表
		$this->home_content     = D('home_content');
		//实例化用户表
		$this->user     = D('user');
		//实例化省市区县表
		$this->city     = D('city');
		//实例化学校表
		$this->school     = D('school');
		//实例化学校私信表
		$this->message     = D('message');
		//实例化学校活动表
		$this->school_activity     = D('school_activity');
		//实例化学校活动申请表
		$this->school_activity_apply     = D('school_activity_apply');
		//实例化学校公开课
		$this->school_curriculum     = D('school_curriculum');
		//实例化学校公开课类型
		$this->school_curriculum_type     = D('school_curriculum_type');
		//实例化收藏表
		$this->collect     = D('collect');
		//实例化点赞表
		$this->praise     = D('praise');
		//实例化评论表
		$this->comment     = D('comment');
		//实例化搜索表
		$this->search     = D('search');
		//实例化公开课历史记录
		$this->school_curriculum_record     = D('school_curriculum_record');
	}
	
	
	//检测学校活动过期
	public function activityDue(){
		$where['state']=1;
		$where['statecode']=array('lt',3);
		$where['etime']=array('neq',0);
		$activitylist = $this->school_activity->where($where)->select();
		$activitylistNum=count($activitylist);
		for($i=0;$i<$activitylistNum;$i++){
			if($activitylist[$i]['stime']>time()){
				//更新该任务为进行状态
				$this->school_activity->where("cid = ".$activitylist[$i]['cid'])->setField('statecode','2');
			}
			if($activitylist[$i]['etime']<time()){
				//更新该任务为过期状态
				$this->school_activity->where("cid = ".$activitylist[$i]['cid'])->setField('statecode','3');
			}
		}
	}
	
	
	public function test(){
		$n="116.667364,39.940387";
		$a=BD09LLtoWGS84("116.667364,39.940387");
		$b=BD09LLtoWGS84($n);
		var_dump($b);exit();
		$c = explode(',', $a);
		$d = explode(',', $b);
		$fP1Lat=$c[1];
		$fP1Lon=$c[0];
		$fP2Lat=$d[1];
		$fP2Lon=$d[0];
		//header('Content-type:text/html; charset=utf8;');
		//$str = file_get_contents('http://api.map.baidu.com/direction/v1/routematrix?output=json&origins=霍营地铁站&destinations=月坛北街与南礼士路交叉口向北200米路东&ak=ddqGwQqOFhK9NqbN7dBc6dD7');
		
		//exit($str);
		//var_dump($fP1Lat.','.$fP1Lon.'#'.$fP2Lat.','.$fP2Lon);
		var_dump(distanceBetween($fP1Lat, $fP1Lon, $fP2Lat, $fP2Lon));
	}
	
	
	/*
	* 学校列表【普通排序：智能排序和收藏最多】列表展示
	* 接收数据格式  
		以下均为选传：
			'type'排序类型 1智能排序（评分）（默认） 2收藏最多
			'coord'=>用户坐标
			'city'=>城市名称（不带市）,'county'=>区县名称（不带区县）,不传则默认为北京市朝阳区
			'screenCityId'=>区县学校筛选ID
			'page'=>页数（默认为1）,'size'=>每页条数（默认为10条）
		若所有限制条件均无，默认返回北京市朝阳区的智能排序（评分）的第一页的10条学校数据
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'schoolList'=学校列表=array(
				每条学校数据=array(
					'cid'=>学校ID,
					'name'=>学校名称,
					'tags'=>学校标签,
					'cover'=>学校封面,
					'adress'=>学校地址,
					'grade'=>学校评分（百分制）,
					'praise'=>学校赞数,
					'distance'=>学校距离（单位：米）,
				)
			)
		} 
	status = {
		1：获取学校列表成功；
		2：该城市暂未开通服务；
		3：获取学校列表失败（无数据）；
	}
	*/
	public function school(){
		//默认数据信息：北京市朝阳区 ID：26
		$defaultCity=26;
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		//准备地区学校列表
		//获取定位信息
		$city =I('city','');     
		$county =I('county','');
		//如果没有获取到定位市区县信息
		if(empty($city) or empty($county)){
			//没有获取到定位市区县信息
				//使用默认城市信息
				$countyId =$defaultCity;
		}
		//如果获取到定位市区县信息
		if($city and $county){
			//查询该市区县是否后台开通服务
			$cityId=$this->city->where("name LIKE '".$city."%' and type=2 and state=1")->field('cid')->find();
			$cityId=$cityId['cid'];
			if($cityId){
				$countyId=$this->city->where("name LIKE '".$county."%' and fid=".$cityId." and type=3 and state=1")->field('cid')->find();
				if($countyId){
					$countyId=$countyId['cid'];			
				}else{
					$output = array(
					'status' 	=>'2',
					'message'	=>'该城市暂未开通服务'
					);
					$this->ajaxReturn($output);
				}
				
			}else{
				$output = array(
					'status' 	=>'2',
					'message'	=>'该城市暂未开通服务'
				);
				$this->ajaxReturn($output);
			}
		}
		//获取排序类型，若没有则为默认为1（智能排序：评分）
		$type   = intval(I('type')) ? intval(I('type')) : 1;
		//判断是否使用城市筛选
		$screenCityId=I('screenCityId','');
		if($screenCityId){
			//如果有城市筛选优先使用
			$countyId=$screenCityId;
		}
		//判断微校排序方式
		if($type==1){
			//默认智能排序：评分
			//获取学校列表
			$schoolList=$this->school ->where('fid='.$countyId.' and state=1')->field('cid,name,tags,cover,adress,coordgps,grade,praise')->order('grade desc')->page($page,$size)->select();
		}else if($type==2){
			//收藏最多排序
			$schoolList=$this->school ->where('fid='.$countyId.' and state=1')->field('cid,name,tags,cover,adress,coordgps,grade,praise')->order('collect desc')->page($page,$size)->select();
		}
		if(!$schoolList){
			$output = array(
				'status' 	=>'3',
				'message'	=>'该城市暂无数据'
			);
			$this->ajaxReturn($output);
		}
		$schoolListNum=count($schoolList);
		$coord= I('coord','');
		if($coord){
			//用户经纬度
			$coord=explode(',',$coord);
			$userCoord=null;
			//用户经度
			$userCoord['lng']=$coord[0];
			//用户纬度
			$userCoord['lat']=$coord[1];
		}
		for($i=0;$i<$schoolListNum;$i++){
			//补全封面地址
			$schoolList[$i]['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$schoolList[$i]['cover'];
			//判断用户坐标为空
			if(empty($coord)){
				//没有接收到距离，不计算距离
				$schoolList[$i]['distance']=0;
			}else{
				//接收到用户坐标，计算距离
				//获取学校经纬度
				$coords=null;
				$coords=$schoolList[$i]['coordgps'];
				$coords=explode(',',$coords);
				//经度
				$schoolList[$i]['lng']=$coords[0];
				//纬度
				$schoolList[$i]['lat']=$coords[1];
				//距离
				$schoolList[$i]['distance']=distanceBetween($userCoord['lat'],$userCoord['lng'],$schoolList[$i]['lat'], $schoolList[$i]['lng']);
				//去除无用元素
				unset($schoolList[$i]['lng']);
				unset($schoolList[$i]['lat']);			
			}
			//去除无用元素
			unset($schoolList[$i]['coordgps']);
		}
		$output = array(
			'status' 	=>'1',
			'message'	=>'获取学校列表成功',
			'schoolList'	=>$schoolList
		);
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校列表【距离排序：离我最近】列表展示
	* 接收数据格式  
		以下均为必传：
			'coord'=>用户坐标
		以下均为选传：
			'city'=>城市名称（不带市）,'county'=>区县名称（不带区县）,不传则默认为北京市朝阳区
			'screenCityId'=>区县学校筛选ID
			'page'=>页数（默认为1）,'size'=>每页条数（默认为10条）
		若所有限制条件均无，默认返回北京市朝阳区的普通排序的第一页的10条学校数据
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'schoolList'=学校列表=array(
				每条学校数据=array(
					'cid'=>学校ID,
					'name'=>学校名称,
					'tags'=>学校标签,
					'cover'=>学校封面,
					'adress'=>学校地址,
					'grade'=>学校评分（百分制）,
					'praise'=>学校赞数,
					'distance'=>学校距离（单位：米）,	
				)
			)
		} 
	status = {
		1：获取学校列表成功；
		2：缺少用户坐标；
		3：该城市暂未开通服务；
		4：该城市暂无数据；
		5：获取学校列表失败（无数据）；
	}
	*/
	public function schoolDistance(){
		$coord= I('coord','');
		//判断用户坐标为空
		if(empty($coord)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户坐标'
			);
			$this->ajaxReturn($output);
		}
		//默认数据信息：北京市朝阳区 ID：26
		$defaultCity=26;
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		//起始条数
		$Srecord=($page-1)*$size;
		//结束条数
		$Erecord=$page*$size-1;
		//准备地区学校列表
		//获取定位信息
		$city =I('city','');     
		$county =I('county','');
		//如果没有获取到定位市区县信息
		if(empty($city) or empty($county)){
			//没有获取到定位市区县信息
				//使用默认城市信息
				$countyId =$defaultCity;
		}
		//如果获取到定位市区县信息
		if($city and $county){
			//查询该市区县是否后台开通服务
			$cityId=$this->city->where("name LIKE '".$city."%' and type=2 and state=1")->field('cid')->find();
			$cityId=$cityId['cid'];
			if($cityId){
				$countyId=$this->city->where("name LIKE '".$county."%' and fid=".$cityId." and type=3 and state=1")->field('cid')->find();
				if($countyId){
					$countyId=$countyId['cid'];			
				}else{
					$output = array(
					'status' 	=>'3',
					'message'	=>'该城市暂未开通服务'
					);
					$this->ajaxReturn($output);
				}
				
			}else{
				$output = array(
					'status' 	=>'3',
					'message'	=>'该城市暂未开通服务'
				);
				$this->ajaxReturn($output);
			}
		}
		//判断是否使用城市筛选
		$screenCityId=I('screenCityId','');
		if($screenCityId){
			//如果有城市筛选优先使用
			$countyId=$screenCityId;
		}
		$schoolList=$this->school ->where('fid='.$countyId.' and state=1')->field('cid,name,tags,cover,adress,coordgps,grade,praise')->select();
		if(!$schoolList){
			$output = array(
				'status' 	=>'4',
				'message'	=>'该城市暂无数据'
			);
			$this->ajaxReturn($output);
		}
		$schoolListNum=count($schoolList);
		//用户经纬度
		$coord=explode(',',$coord);
		$userCoord=null;
		//用户经度
		$userCoord['lng']=$coord[0];
		//用户纬度
		$userCoord['lat']=$coord[1];
		//按照距离排序
		for($i=0;$i<$schoolListNum;$i++){
			//补全封面地址
			$schoolList[$i]['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$schoolList[$i]['cover'];
			//获取学校经纬度
			$coords=null;
			$coords=$schoolList[$i]['coordgps'];
			$coords=explode(',',$coords);
			//经度
			$schoolList[$i]['lng']=$coords[0];
			//纬度
			$schoolList[$i]['lat']=$coords[1];
			//距离
			$schoolList[$i]['distance']=distanceBetween($userCoord['lat'],$userCoord['lng'],$schoolList[$i]['lat'], $schoolList[$i]['lng']);
			//去除无用元素
			unset($schoolList[$i]['lng']);
			unset($schoolList[$i]['lat']);
			unset($schoolList[$i]['coordgps']);
		}
		//根据热门数使用自定义函数array_sort进行二维数组字段排序
		$schoolListY=array_sort($schoolList,'distance');
		//分页处理
		$schoolListY=array_slice($schoolListY,$Srecord,$size);
		if($schoolListY){
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取学校列表成功',
				'schoolList'	=>$schoolListY
			);			
		}else{
			$output = array(
				'status' 	=>'5',
				'message'	=>'获取学校列表失败（无数据）'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校活动列表【普通排序：智能排序和评论最多】列表展示
	* 接收数据格式  
		以下均为选传：
			'type'排序类型 1智能排序（点赞）（默认） 2评论最多
			'coord'=>用户坐标
			'classid'=>筛选类别 1即将开始 2正在进去 3已经过期
			'city'=>城市名称（不带市）,'county'=>区县名称（不带区县）,不传则默认为北京市朝阳区
			'screenCityId'=>区县学校筛选ID
			'page'=>页数（默认为1）,'size'=>每页条数（默认为10条）
		若所有限制条件均无，默认返回北京市朝阳区的智能排序（点赞）的第一页的10条学校数据
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'activityList'=学校活动列表=array(
				每条学校活动数据=array(
					'cid'=>学校活动ID,
					'title'=>学校活动标题,
					'cover'=>学校活动封面,
					'stime'=>学校活动开始时间,
					'etime'=>学校活动结束时间,
					'adress'=>学校活动地址,
					'praise'=>活动点赞数,
					'share'=>活动分享数,
					'comment'=>活动评论数,
					'statecode'=>活动状态码 1未开始 2进行中 3已过期,
					'distance'=>学校距离（单位：米）,	
				)
			)
		} 
	status = {
		1：获取学校活动列表成功；
		2：该城市暂未开通服务；
		3：获取学校活动列表失败（无数据）；
	}
	*/
	public function activity(){
		//检测活动过期
		$this->activityDue();
		//默认数据信息：北京市朝阳区 ID：26
		$defaultCity=26;
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		//准备地区学校列表
		//获取定位信息
		$city =I('city','');     
		$county =I('county','');
		//如果没有获取到定位市区县信息
		if(empty($city) or empty($county)){
			//没有获取到定位市区县信息
				//使用默认城市信息
				$countyId =$defaultCity;
		}
		//如果获取到定位市区县信息
		if($city and $county){
			//查询该市区县是否后台开通服务
			$cityId=$this->city->where("name LIKE '".$city."%' and type=2 and state=1")->field('cid')->find();
			$cityId=$cityId['cid'];
			if($cityId){
				$countyId=$this->city->where("name LIKE '".$county."%' and fid=".$cityId." and type=3 and state=1")->field('cid')->find();
				if($countyId){
					$countyId=$countyId['cid'];			
				}else{
					$output = array(
					'status' 	=>'2',
					'message'	=>'该城市暂未开通服务'
					);
					$this->ajaxReturn($output);
				}
				
			}else{
				$output = array(
					'status' 	=>'2',
					'message'	=>'该城市暂未开通服务'
				);
				$this->ajaxReturn($output);
			}
		}
		//获取排序类型，若没有则为默认为1（智能排序：评分）
		$type   = intval(I('type')) ? intval(I('type')) : 1;
		//判断是否使用城市筛选
		$screenCityId=I('screenCityId','');
		if($screenCityId){
			//如果有城市筛选优先使用
			$countyId=$screenCityId;
		}	
		$where=null;
		$where['cityid']=$countyId;
		$where['state']=1;
		$classid =I('classid','');
		//判断是否有筛选类别
		if($classid){
			$where['statecode']=$classid;
		}
		//判断微校活动排序方式
		if($type==1){
			//默认智能排序：点赞
			//获取学校活动列表
			$activityList=$this->school_activity ->where($where)->field('cid,title,cover,stime,etime,adress,coordgps,praise,share,comment,statecode')->order('praise desc')->page($page,$size)->select();
		}else if($type==2){
			//评论最多排序
			$activityList=$this->school_activity ->where($where)->field('cid,title,cover,stime,etime,adress,coordgps,praise,share,comment,statecode')->order('comment desc')->page($page,$size)->select();
		}
		if(!$activityList){
			$output = array(
				'status' 	=>'3',
				'message'	=>'该城市暂无数据'
			);
			$this->ajaxReturn($output);
		}
		$activityListNum=count($activityList);
		$coord= I('coord','');
		if($coord){
			//用户经纬度
			$coord=explode(',',$coord);
			$userCoord=null;
			//用户经度
			$userCoord['lng']=$coord[0];
			//用户纬度
			$userCoord['lat']=$coord[1];
		}
		for($i=0;$i<$activityListNum;$i++){
			//补全封面地址
			$activityList[$i]['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$activityList[$i]['cover'];
			//判断用户坐标为空
			if(empty($coord)){
				//没有接收到距离，不计算距离
				$activityList[$i]['distance']=0;
			}else{
				//接收到用户坐标，计算距离
				//获取学校经纬度
				$coords=null;
				$coords=$activityList[$i]['coordgps'];
				$coords=explode(',',$coords);
				//经度
				$activityList[$i]['lng']=$coords[0];
				//纬度
				$activityList[$i]['lat']=$coords[1];
				//距离
				$activityList[$i]['distance']=distanceBetween($userCoord['lat'],$userCoord['lng'],$activityList[$i]['lat'], $activityList[$i]['lng']);
				//去除无用元素
				unset($activityList[$i]['lng']);
				unset($activityList[$i]['lat']);			
			}
			//处理时间格式
			$activityList[$i]['stime']=date('Y/m/d',$activityList[$i]['stime']);
			$activityList[$i]['etime']=date('Y/m/d',$activityList[$i]['etime']);
			//去除无用元素
			unset($activityList[$i]['coordgps']);
		}
		$output = array(
			'status' 	=>'1',
			'message'	=>'获取学校活动列表成功',
			'activityList'	=>$activityList
		);
		$this->ajaxReturn($output);
		
	}
	
	
	/*
	* 学校活动列表【距离排序：离我最近】列表展示
	* 接收数据格式  
		以下均为必传：
			'coord'=>用户坐标
		以下均为选传：
			'city'=>城市名称（不带市）,'county'=>区县名称（不带区县）,不传则默认为北京市朝阳区
			'classid'=>筛选类别 1即将开始 2正在进去 3已经过期
			'screenCityId'=>区县学校筛选ID
			'page'=>页数（默认为1）,'size'=>每页条数（默认为10条）
		若所有限制条件均无，默认返回北京市朝阳区的普通排序的第一页的10条学校数据
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'activityList'=学校活动列表=array(
				每条学校活动数据=array(
					'cid'=>学校活动ID,
					'title'=>学校活动标题,
					'cover'=>学校活动封面,
					'stime'=>学校活动开始时间,
					'etime'=>学校活动结束时间,
					'adress'=>学校活动地址,
					'praise'=>活动点赞数,
					'share'=>活动分享数,
					'comment'=>活动评论数,
					'distance'=>学校距离（单位：米）,	
				)
			)
		} 
	status = {
		1：获取学校列表成功；
		2：缺少用户坐标；
		3：该城市暂未开通服务；
		4：该城市暂无数据；
		5：获取学校列表失败（无数据）；
	}
	*/
	public function activityDistance(){
		$coord= I('coord','');
		//判断用户坐标为空
		if(empty($coord)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户坐标'
			);
			$this->ajaxReturn($output);
		}
		//默认数据信息：北京市朝阳区 ID：26
		$defaultCity=26;
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		//起始条数
		$Srecord=($page-1)*$size;
		//结束条数
		$Erecord=$page*$size-1;
		//准备地区学校列表
		//获取定位信息
		$city =I('city','');     
		$county =I('county','');
		//如果没有获取到定位市区县信息
		if(empty($city) or empty($county)){
			//没有获取到定位市区县信息
				//使用默认城市信息
				$countyId =$defaultCity;
		}
		//如果获取到定位市区县信息
		if($city and $county){
			//查询该市区县是否后台开通服务
			$cityId=$this->city->where("name LIKE '".$city."%' and type=2 and state=1")->field('cid')->find();
			$cityId=$cityId['cid'];
			if($cityId){
				$countyId=$this->city->where("name LIKE '".$county."%' and fid=".$cityId." and type=3 and state=1")->field('cid')->find();
				if($countyId){
					$countyId=$countyId['cid'];			
				}else{
					$output = array(
					'status' 	=>'3',
					'message'	=>'该城市暂未开通服务'
					);
					$this->ajaxReturn($output);
				}
				
			}else{
				$output = array(
					'status' 	=>'3',
					'message'	=>'该城市暂未开通服务'
				);
				$this->ajaxReturn($output);
			}
		}
		//判断是否使用城市筛选
		$screenCityId=I('screenCityId','');
		if($screenCityId){
			//如果有城市筛选优先使用
			$countyId=$screenCityId;
		}
		$where=null;
		$where['cityid']=$countyId;
		$where['state']=1;
		$classid =I('classid','');
		//判断是否有筛选类别
		if($classid){
			$where['statecode']=$classid;
		}
		$activityList=$this->school_activity ->where($where)->field('cid,title,cover,stime,etime,adress,coordgps,praise,share,comment,statecode')->select();
		if(!$activityList){
			$output = array(
				'status' 	=>'4',
				'message'	=>'该城市暂无数据'
			);
			$this->ajaxReturn($output);
		}
		$activityListNum=count($activityList);
		//用户经纬度
		$coord=explode(',',$coord);
		$userCoord=null;
		//用户经度
		$userCoord['lng']=$coord[0];
		//用户纬度
		$userCoord['lat']=$coord[1];
		//按照距离排序
		for($i=0;$i<$activityListNum;$i++){
			//补全封面地址
			$activityList[$i]['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$activityList[$i]['cover'];
			//处理时间格式
			$activityList[$i]['stime']=date('Y/m/d',$activityList[$i]['stime']);
			$activityList[$i]['etime']=date('Y/m/d',$activityList[$i]['etime']);
			//获取学校经纬度
			$coords=null;
			$coords=$activityList[$i]['coordgps'];
			$coords=explode(',',$coords);
			//经度
			$activityList[$i]['lng']=$coords[0];
			//纬度
			$activityList[$i]['lat']=$coords[1];
			//距离
			$activityList[$i]['distance']=distanceBetween($userCoord['lat'],$userCoord['lng'],$activityList[$i]['lat'], $activityList[$i]['lng']);
			//去除无用元素
			unset($activityList[$i]['lng']);
			unset($activityList[$i]['lat']);
			unset($activityList[$i]['coordgps']);
		}
		//根据热门数使用自定义函数array_sort进行二维数组字段排序
		$activityListY=array_sort($activityList,'distance');
		//分页处理
		$activityListY=array_slice($activityListY,$Srecord,$size);
		if($activityListY){
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取学校活动列表成功',
				'activityList'	=>$activityListY
			);			
		}else{
			$output = array(
				'status' 	=>'5',
				'message'	=>'获取学校活动列表失败（无数据）'
			);
		}
		$this->ajaxReturn($output);
	}
	
		
		
	/*
	* 学校公开课列表【普通排序：智能排序、评论最多和人气最高】列表展示
	* 接收数据格式  
		以下均为选传：
			'type'排序类型 1智能排序（点赞）（默认） 2评论最多 3人气最高（分享）
			'classid'筛选分类ID 
			'page'=>页数（默认为1）,'size'=>每页条数（默认为10条）
		若所有限制条件均无，默认返回北京市朝阳区的智能排序（点赞）的第一页的10条学校数据
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'curriculumList'=学校公开课列表=array(
				每条公开课数据=array(
					'cid'=>学校公开课ID,
					'title'=>学校公开课标题,
					'cover'=>学校公开课封面,
					'praise'=>公开课点赞数,
					'share'=>公开课分享数,
					'comment'=>公开课评论数,
				)
			)
		} 
	status = {
		1：获取学校公开课列表成功；
		2：暂无数据；
		3：获取学校公开课列表失败（无数据）；
	}
	*/
	public function curriculum(){
		$classid    = I('classid','');
		//获取排序类型，若没有则为默认为1（智能排序：点赞）
		$type   = intval(I('type')) ? intval(I('type')) : 1;
		//判断微校活动排序方式
		$where=null;
		$where['state']=1;
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		if($classid){
			$where['typeid']=$classid;
		}
		if($type==1){
			//默认智能排序：点赞
			//获取学校活动列表
			$curriculumList=$this->school_curriculum ->where($where)->field('cid,title,cover,grade,praise,share,comment')->order('praise desc')->page($page,$size)->select();
		}else if($type==2){
			//评论最多排序
			$curriculumList=$this->school_curriculum ->where($where)->field('cid,title,cover,grade,praise,share,comment')->order('comment desc')->page($page,$size)->select();
		}else if($type==3){
			//人气最高排序
			$curriculumList=$this->school_curriculum ->where($where)->field('cid,title,cover,grade,praise,share,comment')->order('share desc')->page($page,$size)->select();
		}
		if(!$curriculumList){
			$output = array(
				'status' 	=>'2',
				'message'	=>'暂无数据'
			);
			$this->ajaxReturn($output);
		}
		$curriculumListNum=count($curriculumList);
		for($i=0;$i<$curriculumListNum;$i++){
			//补全封面地址
			$curriculumList[$i]['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$curriculumList[$i]['cover'];
			//评分
			$curriculumList[$i]['grade']=$curriculumList[$i]['grade']/10;
		}
		$output = array(
			'status' 	=>'1',
			'message'	=>'获取学校公开课列表成功',
			'curriculumList'	=>$curriculumList
		);
		$this->ajaxReturn($output);
		
	}
	
	
	/*
	* 学校详情展示
	* 接收数据格式  
			'cid'学校ID,'uid'用户ID（选传）
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'schoolInfo'=array(
				'cid'=>学校ID,
				'name'=>学校名称,
				'cover'=>学校封面,
				'adress'=>学校地址,
				'phone'=>学校电话,
				'descs'=>学校说明,			
				'statecode'=>学校认证 1已认证 2未认证,			
				'collectState'=>用户收藏状态 1已收藏 2未收藏,			
			)
		} 
	status = {
		1：获取学校信息成功；
		2：缺少学校ID；
		3：缺少用户ID；
		4：获取学校信息失败；
	}
	*/
	public function schoolInfo(){
		$cid = I('cid','');
		$uid = I('uid','');
		//判断学校ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少学校ID'
			);
			$this->ajaxReturn($output);
		}
		//获取学校信息
		$schoolInfo=$this->school->where('cid='.$cid.' and state=1')->field('cid,name,cover,adress,phone,descs,statecode')->find();
		if($schoolInfo){
			//补全封面地址
			$schoolInfo['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$schoolInfo['cover'];
			if(I('uid')){
				//判断用户是否已收藏（收藏状态）
				//校验该学校该用户是否已收藏
				$collectState=$this->collect->where('fid='.$cid.' and uid='.$uid.' and type=1 and state=1')->find();
				if($collectState){
					//已收藏
					$schoolInfo['collectState']='1';
				}else{
					$schoolInfo['collectState']='2';
				}
			}else{
				$schoolInfo['collectState']='2';
			}
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取学校信息成功',
				'schoolInfo'	=>$schoolInfo
			);
		
		}else{
			$output = array(
				'status' 	=>'4',
				'message'	=>'获取学校信息失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校的活动展示
	* 接收数据格式  
			'cid'学校ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'activityList'=array(
				'cid'=>学校活动ID,
				'title'=>学校活动标题,
				'cover'=>学校活动封面,
				'stime'=>学校活动开始时间,
				'etime'=>学校活动结束时间,
				'adress'=>学校活动地址,
				'grade'=>活动评分,
				'praise'=>活动点赞数,
				'share'=>活动分享数,
				'comment'=>活动评论数,
				'statecode'=>活动状态码 1未开始 2进行中 3已过期,			
			)
		} 
	status = {
		1：获取学校活动成功；
		2：缺少学校ID；
		3：获取学校活动失败（无数据）；
	}
	*/
	public function schoolActivity(){
		$cid = I('cid','');
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		//判断学校ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少学校ID'
			);
			$this->ajaxReturn($output);
		}
		//获取该学校的所有活动
		//基于状态码排序
		$activityList=$this->school_activity ->where('state=1 and fid='.$cid)->field('cid,title,cover,stime,etime,adress,grade,praise,share,comment,statecode')->order('statecode')->page($page,$size)->select();
		if($activityList){
			$activityListNum=count($activityList);
			for($i=0;$i<$activityListNum;$i++){
				//补全封面地址
				$activityList[$i]['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$activityList[$i]['cover'];
				//修改日期格式
				$activityList[$i]['stime']=date('Y/m/d',$activityList[$i]['stime']);
				$activityList[$i]['etime']=date('Y/m/d',$activityList[$i]['etime']);
				//评分
				$activityList[$i]['grade']=$activityList[$i]['grade']/10;
			}
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取学校活动成功',
				'activityList'	=>$activityList
			);	
		}else{
			$output = array(
				'status' 	=>'3',
				'message'	=>'无数据'
			);	
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校的公开课展示
	* 接收数据格式  
			'cid'学校ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'curriculumList'=array(
				'cid'=>学校公开课ID,
				'title'=>学校公开课标题,
				'cover'=>学校公开课封面,
				'grade'=>公开课评分,
				'praise'=>公开课点赞数,
				'share'=>公开课分享数,
				'comment'=>公开课评论数,			
			)
		} 
	status = {
		1：获取学校公开课成功；
		2：缺少学校ID；
		3：获取学校公开课失败（无数据）；
	}
	*/
	public function schoolCurriculum(){
		$cid = I('cid','');
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		//判断学校ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少学校ID'
			);
			$this->ajaxReturn($output);
		}
		//获取该学校的公开课
		$curriculumList=$this->school_curriculum ->where('fid='.$cid.' and state=1')->field('cid,title,cover,grade,praise,share,comment')->order('ctime desc')->page($page,$size)->select();
		if($curriculumList){
			$curriculumListNum=count($curriculumList);
			for($i=0;$i<$curriculumListNum;$i++){
				//补全封面地址
				$curriculumList[$i]['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$curriculumList[$i]['cover'];
				//评分
				$curriculumList[$i]['grade']=$curriculumList[$i]['grade']/10;
				$output = array(
					'status' 	=>'1',
					'message'	=>'获取学校公开课成功',
					'curriculumList'	=>$curriculumList
				);	
			}
		}else{
			$output = array(
				'status' 	=>'3',
				'message'	=>'无数据'
			);	
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校收藏
	* 接收数据格式  
			'cid'学校ID,'uid'用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：收藏成功；
		2：缺少学校ID；
		3：缺少用户ID；
		4：学校不存在；
		5：该用户已收藏该学校；
		6：收藏记录新增失败；
		7：学校收藏自增失败；
	}
	*/
	public function schoolCollect(){
		$cid = I('cid','');
		$uid = I('uid','');
		//判断学校ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少学校ID'
			);
			$this->ajaxReturn($output);
		}
		//判断用户ID为空
		if(empty($uid)){
			$output = array(
				'status' 	=>'3',
				'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//校验学校是否存在
		$School=$this->school->where('cid='.$cid.' and state=1')->find();
		if($School){
			//校验该学校该用户是否已收藏，
			$collect=$this->collect->where('fid='.$cid.' and uid='.$uid.' and state=1')->find();
			if(!$collect){
				//创建收藏记录
				$data=null;
				$data['fid']=$cid;
				$data['uid']=$uid;
				//收藏源类型 1代表学校
				$data['type']=1;
				$data['ctime']=time();
				$data['cdate']=strtotime(date('Y-m-d',time()));
				$collectId=$this->collect->add($data);
				if($collectId){
					//新增学校收藏数
					$SchoolState=$this->school->where('cid='.$cid.' and state=1')->setInc('collect'); // 学校的收藏数自增1
					if($SchoolState){
						$output = array(
							'status' 	=>'1',
							'message'	=>'收藏成功'
						);
					}else{
						$output = array(
							'status' 	=>'7',
							'message'	=>'学校收藏自增失败'
						);	
					}
				}else{
					$output = array(
						'status' 	=>'6',
						'message'	=>'收藏记录新增失败'
					);	
				}
			}else{
				$output = array(
					'status' 	=>'5',
					'message'	=>'该用户已收藏该学校'
				);
			}
			
		}else{
			$output = array(
				'status' 	=>'4',
				'message'	=>'学校不存在'
			);	
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校私信
	* 接收数据格式  
			'cid'学校ID,'uid'用户ID,'leaves'私信内容
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：私信成功；
		2：缺少学校ID；
		3：缺少用户ID；
		4：缺少私信内容；
		5：学校不存在；
		6：私信失败；
	}
	*/
	public function schoolMessage(){
		$cid = I('cid','');
		$uid = I('uid','');
		$leaves = I('leaves','');
		//判断学校ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少学校ID'
			);
			$this->ajaxReturn($output);
		}
		//判断用户ID为空
		if(empty($uid)){
			$output = array(
				'status' 	=>'3',
				'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//判断私信为空
		if(empty($leaves)){
			$output = array(
				'status' 	=>'4',
				'message'	=>'缺少私信内容'
			);
			$this->ajaxReturn($output);
		}
		//校验学校是否存在
		$School=$this->school->where('cid='.$cid.' and state=1')->find();
		if($School){
			//创建私信记录
			$data=null;
			$data['fid']=$cid;
			$data['uid']=$uid;
			$data['leaves']=$leaves;
			$data['ltime']=time();
			$data['statecode']=1;
			$messageId=$this->message->add($data);
			if($messageId){
				$output = array(
					'status' 	=>'1',
					'message'	=>'私信成功'
				);
			}else{
				$output = array(
					'status' 	=>'6',
					'message'	=>'私信失败'
				);	
			}
		}else{
			$output = array(
				'status' 	=>'4',
				'message'	=>'学校不存在'
			);	
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 活动详情展示
	* 接收数据格式  
			'cid'活动ID,'uid'用户ID(选传)
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'activityInfo'=活动信息=array(
				'cid'=>学校活动ID,
				'fid'=>所属学校ID,
				'title'=>活动标题,
				'cover'=>活动封面,
				'adress'=>活动地址,
				'phone'=>联系电话,
				'descs'=>活动说明,
				'teacher'=>活动主讲人,
				'people'=>活动报名人数,
				'onpeople'=>活动已报名人数,
				'stime'=>活动开始时间,
				'etime'=>活动结束时间,
				'statecode'=>活动状态码 1即将开始 2进行中 3已经过期,
				'schoolName'=>学校名称,		
				'collectState'=>用户活动收藏状态 1已收藏 2未收藏,		
				'praiseState'=>用户活动点赞状态 1已点赞 2未点赞,		
				'applyState'=>用户活动报名状态 1已报名 2未报名,		
			)
			'commentList'=评论列表=array(
				'cid'=>评论ID,
				'contment'=>评论内容,
				'ctime'=>评论时间,
				'uname'=>评论用户,
			),
		} 
	status = {
		1：获取活动信息成功；
		2：缺少活动ID；
		3：缺少用户ID；
		4：获取活动信息失败；
	}
	*/
	public function activityInfo(){
		$cid = I('cid','');
		$uid = I('uid','');
		//判断活动ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少活动ID'
			);
			$this->ajaxReturn($output);
		}
		//获取活动信息
		$activityInfo=$this->school_activity->where('cid='.$cid.' and state=1')->field('cid,fid,title,cover,adress,phone,descs,teacher,people,onpeople,stime,etime,statecode')->find();
		if($activityInfo){
			//补全封面地址
			$activityInfo['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$activityInfo['cover'];
			//格式化时间
			$activityInfo['stime']=date('Y/m/d',$activityInfo['stime']);
			$activityInfo['etime']=date('Y/m/d',$activityInfo['etime']);
			//获取学校名称
			$activityInfo['schoolName']=$this->school->getFieldByCid($activityInfo['fid'],'name');
			if(I('uid')){
				//获取活动收藏状态
				$collectState=$this->collect->where('fid='.$cid.' and uid='.$uid.' and type=2 and state=1')->find();
				if($collectState){
					$activityInfo['collectState']='1';
				}else{
					$activityInfo['collectState']='2';
				}
				//获取活动点赞状态
				$praiseState=$this->praise->where('fid='.$cid.' and uid='.$uid.' and type=4 and state=1')->find();
				if($praiseState){
					$activityInfo['praiseState']='1';
				}else{
					$activityInfo['praiseState']='2';
				}
				//获取活动报名状态
				$applyState=$this->school_activity_apply ->where('fid='.$cid.' and uid='.$uid.' and state=1')->find();
				if($applyState){
					$activityInfo['applyState']='1';
				}else{
					$activityInfo['applyState']='2';
				}
			}else{
				$activityInfo['collectState']='2';
				$activityInfo['praiseState']='2';
				$activityInfo['applyState']='2';
			}
			
			//准备活动评论列表
			$commentList=$this->comment->where('fid='.$cid.' and type=3 and state')->field('cid,uid,contment,ctime')->order('ctime desc')->select();
			if($commentList){
				$commentListNum=count($commentList);
				for($i=0;$i<$commentListNum;$i++){
					$commentList[$i]['uname']=$this->user->getFieldByUid($commentList[$i]['uid'],'nickname');
					//格式化时间
					$commentList[$i]['ctime']=date('Y-m-d',$commentList[$i]['ctime']);
					unset($commentList[$i]['uid']);
				}
			}else{
				$commentList=array();
			}
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取活动信息成功',
				'activityInfo'	=>$activityInfo,
				'commentList'	=>$commentList
			);
		}else{
			$output = array(
				'status' 	=>'4',
				'message'	=>'获取活动信息失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校活动收藏
	* 接收数据格式  
			'cid'活动ID,'uid'用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：收藏成功；
		2：缺少活动ID；
		3：缺少用户ID；
		4：活动不存在；
		5：该用户已收藏该活动；
		6：收藏记录新增失败；
		7：活动收藏自增失败；
	}
	*/
	public function activityCollect(){
		$cid = I('cid','');
		$uid = I('uid','');
		//判断学校ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少活动ID'
			);
			$this->ajaxReturn($output);
		}
		//判断用户ID为空
		if(empty($uid)){
			$output = array(
				'status' 	=>'3',
				'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//校验活动是否存在
		$activity=$this->school_activity->where('cid='.$cid.' and state=1')->find();
		if($activity){
			//校验该活动该用户是否已收藏，
			$collect=$this->collect->where('fid='.$cid.' and uid='.$uid.' and type=2 and state=1')->find();
			if(!$collect){
				//创建收藏记录
				$data=null;
				$data['fid']=$cid;
				$data['uid']=$uid;
				//收藏源类型 1代表学校 2代表活动
				$data['type']=2;
				$data['ctime']=time();
				$data['cdate']=strtotime(date('Y-m-d',time()));
				$collectId=$this->collect->add($data);
				if($collectId){
					//新增活动收藏数
					$activityState=$this->school_activity->where('cid='.$cid.' and state=1')->setInc('collect'); // 活动的收藏数自增1
					if($activityState){
						$output = array(
							'status' 	=>'1',
							'message'	=>'收藏成功'
						);
					}else{
						$output = array(
							'status' 	=>'7',
							'message'	=>'活动收藏自增失败'
						);	
					}
				}else{
					$output = array(
						'status' 	=>'6',
						'message'	=>'收藏记录新增失败'
					);	
				}
			}else{
				$output = array(
					'status' 	=>'5',
					'message'	=>'该用户已收藏该活动'
				);
			}
			
		}else{
			$output = array(
				'status' 	=>'4',
				'message'	=>'活动不存在'
			);	
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校活动点赞
	* 接收数据格式  
			'cid'活动ID,'uid'用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：点赞成功；
		2：缺少活动ID；
		3：缺少用户ID；
		4：活动不存在；
		5：该用户已点赞；
		6：点赞记录新增失败；
		7：活动点赞自增失败；
	}
	*/
	public function activityPraise(){
		$cid = I('cid','');
		$uid = I('uid','');
		//判断学校ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少活动ID'
			);
			$this->ajaxReturn($output);
		}
		//判断用户ID为空
		if(empty($uid)){
			$output = array(
				'status' 	=>'3',
				'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//校验活动是否存在
		$activity=$this->school_activity->where('cid='.$cid.' and state=1')->find();
		if($activity){
			//校验该活动该用户是否已点赞，
			$praise=$this->praise->where('fid='.$cid.' and uid='.$uid.' and type=4 and state=1')->find();
			if(!$praise){
				//创建点赞记录
				$data=null;
				$data['fid']=$cid;
				$data['uid']=$uid;
				//点赞源类型 1代表最In课程 2代表少年 3代表图片 4代表活动
				$data['type']=4;
				$praiseId=$this->praise->add($data);
				if($praiseId){
					//新增活动点赞数
					$activityState=$this->school_activity->where('cid='.$cid.' and state=1')->setInc('praise'); // 活动的点赞数自增1
					if($activityState){
						$output = array(
							'status' 	=>'1',
							'message'	=>'点赞成功'
						);
					}else{
						$output = array(
							'status' 	=>'7',
							'message'	=>'活动点赞自增失败'
						);	
					}
				}else{
					$output = array(
						'status' 	=>'6',
						'message'	=>'点赞记录新增失败'
					);	
				}
			}else{
				$output = array(
					'status' 	=>'5',
					'message'	=>'该用户已点赞'
				);
			}
			
		}else{
			$output = array(
				'status' 	=>'4',
				'message'	=>'活动不存在'
			);	
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校活动评论列表
	* 接收数据格式  
			'cid'活动ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'commentList'=评论列表=array(
				'cid'=>评论ID,
				'contment'=>评论内容,
				'ctime'=>评论时间,
				'uname'=>评论用户,
			),
		} 
	status = {
		1：活动评论列表获取成功；
		2：缺少活动ID；
		3：活动不存在；
		4：活动评论列表获取失败（无数据）；
	}
	*/
	public function activityContmentIndex(){
		$cid = I('cid','');
		//判断学校ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少活动ID'
			);
			$this->ajaxReturn($output);
		}
		//校验活动是否存在
		$activity=$this->school_activity->where('cid='.$cid.' and state=1')->find();
		if($activity){
			//准备活动评论列表
			$commentList=$this->comment->where('fid='.$cid.' and type=3 and state')->field('cid,uid,contment,ctime')->order('ctime desc')->select();
			if($commentList){
				$commentListNum=count($commentList);
				for($i=0;$i<$commentListNum;$i++){
					$commentList[$i]['uname']=$this->user->getFieldByUid($commentList[$i]['uid'],'nickname');
					//格式化时间
					$commentList[$i]['ctime']=date('Y-m-d',$commentList[$i]['ctime']);
					unset($commentList[$i]['uid']);
				}
				$output = array(
					'status' 	=>'1',
					'message'	=>'活动评论列表获取成功',
					'commentList'	=>$commentList
				);
			}else{
				$output = array(
					'status' 	=>'4',
					'message'	=>'活动评论列表获取失败（无数据）'
				);
			}
		}else{
			$output = array(
				'status' 	=>'3',
				'message'	=>'活动不存在'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校活动评论
	* 接收数据格式  
			'cid'活动ID,'uid'用户ID,'contment'评论内容
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：评论成功；
		2：缺少活动ID；
		3：缺少用户ID；
		4：缺少评论内容；
		5：活动不存在；
		6：活动评论新增失败；
		7：活动评论数自增失败；
	}
	*/
	public function activityContment(){
		$cid = I('cid','');
		$uid = I('uid','');
		$contment = I('contment','');
		//判断学校ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少活动ID'
			);
			$this->ajaxReturn($output);
		}
		//判断用户ID为空
		if(empty($uid)){
			$output = array(
				'status' 	=>'3',
				'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//判断评论内容为空
		if(empty($contment)){
			$output = array(
				'status' 	=>'4',
				'message'	=>'缺少评论内容'
			);
			$this->ajaxReturn($output);
		}
		//校验活动是否存在
		$activity=$this->school_activity->where('cid='.$cid.' and state=1')->find();
		if($activity){
			//新增评论
			$data=null;
			$data['fid']=$cid;
			$data['uid']=$uid;
			$data['contment']=$contment;
			//点赞源类型 1代表最In课程 2代表图片 3代表活动
			$data['type']=3;
			$data['ctime']=time();
			$commentId=$this->comment->add($data);
			if($commentId){
				//活动评论数自增
				$activityState=$this->school_activity->where('cid='.$cid.' and state=1')->setInc('comment'); // 活动的评论数自增1
				if($activityState){
					$output = array(
						'status' 	=>'1',
						'message'	=>'评论成功'
					);
				}else{
					$output = array(
						'status' 	=>'7',
						'message'	=>'活动评论数自增失败'
					);	
				}
			}else{
				$output = array(
					'status' 	=>'6',
					'message'	=>'评论新增失败'
				);	
			}
		}else{
			$output = array(
				'status' 	=>'5',
				'message'	=>'活动不存在'
			);	
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校活动报名
	* 接收数据格式  
			'cid'活动ID,'uid'用户ID,'parent'家长姓名,'child'孩子姓名,'age'孩子年龄,'grade'孩子年级,'phone'联系电话
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：报名成功；
		2：缺少活动ID；
		3：缺少用户ID；
		4：缺少家长姓名；
		5：缺少孩子姓名；
		6：缺少孩子年龄；
		7：缺少孩子年级；
		8：缺少联系电话；
		9：活动不存在；
		10：该用户已报名；
		11：活动报名记录新增失败；
		12：活动报名数自增失败；
	}
	*/
	public function activityApply(){
		$cid = I('cid','');
		$uid = I('uid','');
		$parent = I('parent','');
		$child = I('child','');
		$age = I('age','');
		$grade = I('grade','');
		$phone = I('phone','');
		//判断活动ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少活动ID'
			);
			$this->ajaxReturn($output);
		}
		//判断用户ID为空
		if(empty($uid)){
			$output = array(
				'status' 	=>'3',
				'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//判断家长姓名为空
		if(empty($parent)){
			$output = array(
				'status' 	=>'4',
				'message'	=>'缺少家长姓名'
			);
			$this->ajaxReturn($output);
		}
		//判断孩子姓名为空
		if(empty($child)){
			$output = array(
				'status' 	=>'5',
				'message'	=>'缺少孩子姓名'
			);
			$this->ajaxReturn($output);
		}
		//判断孩子年龄为空
		if(empty($age)){
			$output = array(
				'status' 	=>'6',
				'message'	=>'缺少孩子年龄'
			);
			$this->ajaxReturn($output);
		}
		//判断孩子年级为空
		if(empty($grade)){
			$output = array(
				'status' 	=>'7',
				'message'	=>'缺少孩子年级'
			);
			$this->ajaxReturn($output);
		}
		//判断联系电话为空
		if(empty($phone)){
			$output = array(
				'status' 	=>'8',
				'message'	=>'缺少联系电话'
			);
			$this->ajaxReturn($output);
		}
		//校验活动是否存在
		$activity=$this->school_activity->where('cid='.$cid.' and state=1')->find();
		if($activity){
			//校验该活动该用户是否已报名，
			$apply=$this->school_activity_apply ->where('fid='.$cid.' and uid='.$uid.' and state=1')->find();
			if(!$apply){
				//创建报名记录
				$data=null;
				$data['fid']=$cid;
				$data['uid']=$uid;
				$data['parent']=$parent;
				$data['child']=$child;
				$data['age']=$age;
				$data['grade']=$grade;
				$data['phone']=$phone;
				$data['ctime']=time();
				$applyId=$this->school_activity_apply ->add($data);
				if($applyId){
					//新增活动报名人数数
					$activityState=$this->school_activity->where('cid='.$cid.' and state=1')->setInc('onpeople'); // 活动的报名数自增1
					if($activityState){
						$output = array(
							'status' 	=>'1',
							'message'	=>'报名成功'
						);
					}else{
						$output = array(
							'status' 	=>'12',
							'message'	=>'活动报名数自增失败'
						);	
					}
				}else{
					$output = array(
						'status' 	=>'11',
						'message'	=>'活动报名记录新增失败'
					);	
				}
			}else{
				$output = array(
					'status' 	=>'10',
					'message'	=>'该用户已报名'
				);
			}
			
		}else{
			$output = array(
				'status' 	=>'9',
				'message'	=>'活动不存在'
			);	
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校活动分享
	* 接收数据格式  
			'cid'活动ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：分享成功；
		2：缺少活动ID；
		3：活动不存在；
		4：活动分享数自增失败；
	}
	*/
	public function activityShare(){
		$cid = I('cid','');
		//判断学校ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少活动ID'
			);
			$this->ajaxReturn($output);
		}
		//校验活动是否存在
		$activity=$this->school_activity->where('cid='.$cid.' and state=1')->find();
		if($activity){
			//活动分享数自增
			$activityState=$this->school_activity->where('cid='.$cid.' and state=1')->setInc('share'); // 活动的分享数自增1
			if($activityState){
				$output = array(
					'status' 	=>'1',
					'message'	=>'分享成功'
				);
			}else{
				$output = array(
					'status' 	=>'4',
					'message'	=>'活动分享数自增失败'
				);	
			}
		}else{
			$output = array(
				'status' 	=>'3',
				'message'	=>'活动不存在'
			);	
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 公开课详情展示
	* 接收数据格式  
			'cid'公开课ID,'uid'用户ID（选传）
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'curriculumInfo'=array(
				'cid'=>学校公开课ID,
				'fid'=>所属学校ID,
				'title'=>公开课标题,
				'cover'=>公开课封面,
				'url'=>公开课资源地址,
				'phone'=>联系电话,
				'descs'=>公开课说明,
				'teacher'=>公开课主讲人,
				'schoolName'=>学校名称,		
				'collectState'=>用户活动收藏状态 1已收藏 2未收藏,		
				'praiseState'=>用户活动点赞状态 1已点赞 2未点赞,	
			),
			'commentList'=评论列表=array(
				'cid'=>评论ID,
				'contment'=>评论内容,
				'ctime'=>评论时间,
				'uname'=>评论用户,
			),
		} 
	status = {
		1：获取公开课信息成功；
		2：缺少公开课ID；
		3：缺少用户ID；
		4：获取公开课信息失败；
		5：用户浏览记录更新失败；
		6：用户浏览记录新增失败；
	}
	*/
	public function curriculumInfo(){
		$cid = I('cid','');
		$uid = I('uid','');
		//判断活动ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少公开课ID'
			);
			$this->ajaxReturn($output);
		}
		//获取活动信息
		$curriculumInfo=$this->school_curriculum->where('cid='.$cid.' and state=1')->field('cid,fid,title,cover,url,phone,descs,teacher')->find();
		if($curriculumInfo){
			//补全封面地址
			$curriculumInfo['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$curriculumInfo['cover'];
			//获取学校名称
			$curriculumInfo['schoolName']=$this->school->getFieldByCid($curriculumInfo['fid'],'name');
			if(I('uid')){
				//获取活动收藏状态
				$collectState=$this->collect->where('fid='.$cid.' and uid='.$uid.' and type=3 and state=1')->find();
				if($collectState){
					$curriculumInfo['collectState']='1';
				}else{
					$curriculumInfo['collectState']='2';
				}
				//获取活动点赞状态
				$praiseState=$this->praise->where('fid='.$cid.' and uid='.$uid.' and type=5 and state=1')->find();
				if($praiseState){
					$curriculumInfo['praiseState']='1';
				}else{
					$curriculumInfo['praiseState']='2';
				}
				//准备用户浏览历史记录
				$record=$this->school_curriculum_record->where('fid='.$cid.' and uid='.$uid.' and state=1')->find();
				if($record){
					//该用户对该公开课有浏览记录，更新浏览时间
					$recordState=$this->school_curriculum_record->where('fid='.$cid.' and uid='.$uid.' and state=1')->setField('ctime',time());
					if(!$recordState){
						$output = array(
							'status' 	=>'5',
							'message'	=>'用户浏览记录更新失败'
						);
					}
				}else{
					//该用户对该公开课没有浏览记录，新建浏览记录
					$data=null;
					$data['fid']=$cid;
					$data['uid']=$uid;
					$data['ctime']=time();
					$recordId=$this->school_curriculum_record->add($data);
					if(!$recordId){
						$output = array(
							'status' 	=>'6',
							'message'	=>'用户浏览记录新增失败'
						);
					}
				}
			}else{
				$curriculumInfo['collectState']='2';
				$curriculumInfo['praiseState']='2';
			}
			//准备活动评论列表
			$commentList=$this->comment->where('fid='.$cid.' and type=4 and state')->field('cid,uid,contment,ctime')->order('ctime desc')->select();
			if($commentList){
				$commentListNum=count($commentList);
				for($i=0;$i<$commentListNum;$i++){
					$commentList[$i]['uname']=$this->user->getFieldByUid($commentList[$i]['uid'],'nickname');
					//格式化时间
					$commentList[$i]['ctime']=date('Y-m-d',$commentList[$i]['ctime']);
					unset($commentList[$i]['uid']);
				}
			}else{
				$commentList=array();
			}
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取公开课信息成功',
				'curriculumInfo'	=>$curriculumInfo,
				'commentList'	=>$commentList
			);
		}else{
			$output = array(
				'status' 	=>'4',
				'message'	=>'获取公开课信息失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校公开课收藏
	* 接收数据格式  
			'cid'公开课ID,'uid'用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：收藏成功；
		2：缺少公开课ID；
		3：缺少用户ID；
		4：公开课不存在；
		5：该用户已收藏该公开课；
		6：收藏记录新增失败；
		7：公开课收藏数自增失败；
	}
	*/
	public function curriculumCollect(){
		$cid = I('cid','');
		$uid = I('uid','');
		//判断公开课ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少公开课ID'
			);
			$this->ajaxReturn($output);
		}
		//判断用户ID为空
		if(empty($uid)){
			$output = array(
				'status' 	=>'3',
				'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//校验公开课是否存在
		$curriculum=$this->school_curriculum->where('cid='.$cid.' and state=1')->find();
		if($curriculum){
			//校验该公开课该用户是否已收藏，
			$collect=$this->collect->where('fid='.$cid.' and uid='.$uid.' and type=3 and state=1')->find();
			if(!$collect){
				//创建收藏记录
				$data=null;
				$data['fid']=$cid;
				$data['uid']=$uid;
				//收藏源类型 1代表学校 2代表活动 3代表公开课
				$data['type']=3;
				$data['ctime']=time();
				$data['cdate']=strtotime(date('Y-m-d',time()));
				$collectId=$this->collect->add($data);
				if($collectId){
					//新增公开课收藏数
					$curriculumState=$this->school_curriculum->where('cid='.$cid.' and state=1')->setInc('collect'); // 公开课的收藏数自增1
					if($curriculumState){
						$output = array(
							'status' 	=>'1',
							'message'	=>'收藏成功'
						);
					}else{
						$output = array(
							'status' 	=>'7',
							'message'	=>'公开课收藏数自增失败'
						);	
					}
				}else{
					$output = array(
						'status' 	=>'6',
						'message'	=>'收藏记录新增失败'
					);	
				}
			}else{
				$output = array(
					'status' 	=>'5',
					'message'	=>'该用户已收藏该公开课'
				);
			}
			
		}else{
			$output = array(
				'status' 	=>'4',
				'message'	=>'公开课不存在'
			);	
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校公开课类型
	* 接收数据格式  
			无
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'typeList'=校长申请信息=array(
				'cid'=>类型ID,
				'name'=>类型名称,
			)
		} 
	status = {
		1：获取成功；
		2：获取失败；
	}
	*/
	public function curriculumType(){
		//获取学校公开课类型
		$typeList=$this->school_curriculum_type->where('state=1')->field('cid,name')->select();
		if($typeList){
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取成功',
				'typeList'	=>$typeList
			);
		}else{
			$output = array(
				'status' 	=>'2',
				'message'	=>'获取失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校公开课点赞
	* 接收数据格式  
			'cid'公开课ID,'uid'用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：点赞成功；
		2：缺少公开课ID；
		3：缺少用户ID；
		4：公开课不存在；
		5：该用户已点赞；
		6：点赞记录新增失败；
		7：公开课点赞自增失败；
	}
	*/
	public function curriculumPraise(){
		$cid = I('cid','');
		$uid = I('uid','');
		//判断公开课ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少公开课ID'
			);
			$this->ajaxReturn($output);
		}
		//判断用户ID为空
		if(empty($uid)){
			$output = array(
				'status' 	=>'3',
				'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//校验公开课是否存在
		$curriculum=$this->school_curriculum->where('cid='.$cid.' and state=1')->find();
		if($curriculum){
			//校验该公开课该用户是否已点赞，
			$praise=$this->praise->where('fid='.$cid.' and uid='.$uid.' and type=5 and state=1')->find();
			if(!$praise){
				//创建点赞记录
				$data=null;
				$data['fid']=$cid;
				$data['uid']=$uid;
				//点赞源类型 1代表最In课程 2代表少年 3代表图片 4代表活动 5代表公开课
				$data['type']=5;
				$praiseId=$this->praise->add($data);
				if($praiseId){
					//新增公开课点赞数
					$curriculumState=$this->school_curriculum->where('cid='.$cid.' and state=1')->setInc('praise'); // 公开课的点赞数自增1
					if($curriculumState){
						$output = array(
							'status' 	=>'1',
							'message'	=>'点赞成功'
						);
					}else{
						$output = array(
							'status' 	=>'7',
							'message'	=>'公开课点赞自增失败'
						);	
					}
				}else{
					$output = array(
						'status' 	=>'6',
						'message'	=>'点赞记录新增失败'
					);	
				}
			}else{
				$output = array(
					'status' 	=>'5',
					'message'	=>'该用户已点赞'
				);
			}
			
		}else{
			$output = array(
				'status' 	=>'4',
				'message'	=>'公开课不存在'
			);	
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 公开课评论列表
	* 接收数据格式  
			'cid'公开课ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'commentList'=评论列表=array(
				'cid'=>评论ID,
				'contment'=>评论内容,
				'ctime'=>评论时间,
				'uname'=>评论用户,
			),
		} 
	status = {
		1：公开课评论列表获取成功；
		2：缺少公开课ID；
		3：公开课不存在；
		4：公开课评论列表获取失败（无数据）；
	}
	*/
	public function curriculumContmentIndex(){
		$cid = I('cid','');
		//判断公开课ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少公开课ID'
			);
			$this->ajaxReturn($output);
		}
		//校验公开课是否存在
		$curriculum=$this->school_curriculum->where('cid='.$cid.' and state=1')->find();
		if($curriculum){
			//准备活动评论列表
			$commentList=$this->comment->where('fid='.$cid.' and type=4 and state')->field('cid,uid,contment,ctime')->order('ctime desc')->select();
			if($commentList){
				$commentListNum=count($commentList);
				for($i=0;$i<$commentListNum;$i++){
					$commentList[$i]['uname']=$this->user->getFieldByUid($commentList[$i]['uid'],'nickname');
					//格式化时间
					$commentList[$i]['ctime']=date('Y-m-d',$commentList[$i]['ctime']);
					unset($commentList[$i]['uid']);
				}
				$output = array(
					'status' 	=>'1',
					'message'	=>'公开课评论列表获取成功',
					'commentList'	=>$commentList
				);
			}else{
				$output = array(
					'status' 	=>'4',
					'message'	=>'公开课评论列表获取失败（无数据）'
				);
			}
		}else{
			$output = array(
				'status' 	=>'3',
				'message'	=>'公开课不存在'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校公开课评论
	* 接收数据格式  
			'cid'公开课ID,'uid'用户ID,'contment'评论内容
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：评论成功；
		2：缺少公开课ID；
		3：缺少用户ID；
		4：缺少评论内容；
		5：公开课不存在；
		6：公开课评论新增失败；
		7：公开课评论数自增失败；
	}
	*/
	public function curriculumContment(){
		$cid = I('cid','');
		$uid = I('uid','');
		$contment = I('contment','');
		//判断公开课ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少公开课ID'
			);
			$this->ajaxReturn($output);
		}
		//判断用户ID为空
		if(empty($uid)){
			$output = array(
				'status' 	=>'3',
				'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//判断评论内容为空
		if(empty($contment)){
			$output = array(
				'status' 	=>'4',
				'message'	=>'缺少评论内容'
			);
			$this->ajaxReturn($output);
		}
		//校验公开课是否存在
		$curriculum=$this->school_curriculum->where('cid='.$cid.' and state=1')->find();
		if($curriculum){
			//新增评论
			$data=null;
			$data['fid']=$cid;
			$data['uid']=$uid;
			$data['contment']=$contment;
			//点赞源类型 1代表最In课程 2代表图片 3代表活动 4代表公开课
			$data['type']=4;
			$data['ctime']=time();
			$commentId=$this->comment->add($data);
			if($commentId){
				//公开课评论数自增
				$activityState=$this->school_curriculum->where('cid='.$cid.' and state=1')->setInc('comment'); // 公开课的评论数自增1
				if($activityState){
					$output = array(
						'status' 	=>'1',
						'message'	=>'评论成功'
					);
				}else{
					$output = array(
						'status' 	=>'7',
						'message'	=>'公开课评论数自增失败'
					);	
				}
			}else{
				$output = array(
					'status' 	=>'6',
					'message'	=>'评论新增失败'
				);	
			}
		}else{
			$output = array(
				'status' 	=>'5',
				'message'	=>'公开课不存在'
			);	
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 学校公开课分享
	* 接收数据格式  
			'cid'公开课ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：分享成功；
		2：缺少公开课ID；
		3：公开课不存在；
		4：公开课分享数自增失败；
	}
	*/
	public function curriculumShare(){
		$cid = I('cid','');
		//判断学校ID为空
		if(empty($cid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少公开课ID'
			);
			$this->ajaxReturn($output);
		}
		//校验公开课是否存在
		$curriculum=$this->school_curriculum->where('cid='.$cid.' and state=1')->find();
		if($curriculum){
			//公开课分享数自增
			$activityState=$this->school_curriculum->where('cid='.$cid.' and state=1')->setInc('share'); // 公开课的分享数自增1
			if($activityState){
				$output = array(
					'status' 	=>'1',
					'message'	=>'分享成功'
				);
			}else{
				$output = array(
					'status' 	=>'4',
					'message'	=>'公开课分享数自增失败'
				);	
			}
		}else{
			$output = array(
				'status' 	=>'3',
				'message'	=>'公开课不存在'
			);	
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 搜索
	* 接收数据格式  
			'name'搜索内容,'page'=>页数（默认为1）,'size'=>每页条数（默认为10条）
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息,
			'searchNum'=>搜索结果数量,
			'searchList'=搜索结果列表=array(
				每条搜索数据=array(
					'cid'=>索引ID,
					'fid'=>跳转ID,
					'cover'=>封面,
					'title'=>标题,
					'type'=>类型 1学校 2活动 3公开课,
					'text'=>类型文本,
					'state'=>状态 1开启 2停用,
				)
			)
		} 
	status = {
		1：获取成功；
		2：缺少搜索内容；
		3：获取失败（无数据）；
	}
	*/
	public function search(){
		$name = I('name','');
		//判断搜索内容为空
		if(empty($name)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少搜索内容'
			);
			$this->ajaxReturn($output);
		}
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		$searchNum=$this->search->where("title LIKE '%".$name."%' and state=1")->count();
		$searchList=$this->search->where("title LIKE '%".$name."%' and state=1")->page($page,$size)->select();
		if($searchList){
			$searchListNum=count($searchList);
			for($i=0;$i<$searchListNum;$i++){
				//补全封面地址
				$searchList[$i]['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$searchList[$i]['cover'];
				if($searchList[$i]['type']==1){
					$searchList[$i]['text']="学校";
				}else if($searchList[$i]['type']==2){
					$searchList[$i]['text']="活动";
				}else if($searchList[$i]['type']==3){
					$searchList[$i]['text']="公开课";
				}
			}
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取成功',
				'searchNum'	=>$searchNum,
				'searchList'	=>$searchList
			);
		}else{
			$output = array(
				'status' 	=>'3',
				'message'	=>'获取失败（无数据）'
			);
		}
		$this->ajaxReturn($output);
	}
}