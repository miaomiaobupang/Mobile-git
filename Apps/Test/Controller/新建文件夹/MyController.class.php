<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\UploadFileModel as UploadFile;

// +----------------------------------------------------------------------
// | 爱能社
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://langyue.org All rights reserved.
// +----------------------------------------------------------------------
// | 我的
// +----------------------------------------------------------------------
// | Author: 狼啸 <11740390@qq.com>
// +----------------------------------------------------------------------
class MyController extends LimitController {
	private $comment;//评论表
	private $curriculum;//最IN课程表
	private $appconfig;//配置表
	private $user;//用户表
	private $feedback;//反馈表
	private $edition;//版本更新表
	private $sign_record;//签到记录表
	private $score_record;//积分记录表
	private $school;//学校表
	private $message;//学校私信表
	private $school_auth;//学校认证表
	private $school_activity;//学校活动表
	private $school_activity_apply;//学校活动报名表
	private $school_curriculum;//学校公开课表
	private $school_curriculum_record;//学校公开课历史记录表
	private $collect;//收藏表
	private $privilege;//优惠券表
	private $privilege_type;//优惠券类型表
	private $privilege_apply;//优惠券申请表
	
	/**
	 * 构造方法
	 */
	public function __construct() {
		parent::__construct();
		//实例化评论表
		$this->comment     = D('comment');
		//实例化最IN课程表
		$this->curriculum     = D('curriculum');
		//实例化配置表
		$this->appconfig     = D('appconfig');
		//实例化用户表
		$this->user     = D('user');
		//实例化反馈表
		$this->feedback     = D('feedback');
		//实例化版本更新表
		$this->edition     = D('edition');
		//实例化签到记录表
		$this->sign_record     = D('sign_record');
		//实例化积分记录表
		$this->score_record     = D('score_record');
		//实例化学校
		$this->school     = D('school');
		//实例化学校认证
		$this->school_auth     = D('school_auth');
		//实例化学校私信
		$this->message     = D('message');
		//实例化学校活动
		$this->school_activity     = D('school_activity');
		//实例化学校活动
		$this->school_activity_apply     = D('school_activity_apply');
		//实例化学校公开课
		$this->school_curriculum     = D('school_curriculum');
		//实例化公开课历史记录
		$this->school_curriculum_record     = D('school_curriculum_record');
		//实例化收藏表
		$this->collect     = D('collect');
		//实例化优惠券表
		$this->privilege     = D('privilege');
		//实例化优惠券类型表
		$this->privilege_type     = D('privilege_type');
		//实例化优惠券申请
		$this->privilege_apply     = D('privilege_apply');
	}
	
	
	//检测优惠券过期
	public function privilegeDue(){
		$where['state']=1;
		$where['statecode']=array('lt',3);
		$where['etime']=array('neq',0);
		$privilegelist = $this->privilege->where($where)->select();
		$privilegelistNum=count($privilegelist);
		for($i=0;$i<$privilegelistNum;$i++){
			if($privilegelist[$i]['stime']>time()){
				//更新该任务为进行状态
				$this->privilege->where("cid = ".$privilegelist[$i]['cid'])->setField('statecode','2');
			}
			if($privilegelist[$i]['etime']<time()){
				//更新该任务为过期状态
				$this->privilege->where("cid = ".$privilegelist[$i]['cid'])->setField('statecode','3');
			}
		}
	}
	
	
	/*
	* 我的课程列表
	* 接收数据格式 'uid'=>用户ID,'page'=>页数（默认为1）,'size'=>每页条数（默认为10条）
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息,
			'curriculumList'=我的课程列表=array(
				每条公开课数据=array(
					'record'=>课程历史记录ID,
					'cid'=>学校公开课ID,
					'title'=>学校公开课标题,
					'cover'=>学校公开课封面,
					'grade'=>学校公开课评分,
					'praise'=>公开课点赞数,
					'share'=>公开课分享数,
					'comment'=>公开课评论数,
				)
			)
		} 
	status = {
		1：获取成功；
		2：缺少用户ID;
		3：获取评论列表失败（无数据）;
	}
	*/
	public function curriculum(){
		$uid =I('uid','');     
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		$curriculumList=$this->school_curriculum_record->where('uid='.$uid.' and state=1')->field('cid,fid')->order('ctime desc')->page($page,$size)->select();
		if($curriculumList){
			$curriculumListNum=count($curriculumList);
			for($i=0;$i<$curriculumListNum;$i++){
				//记录ID
				$recordId=null;
				$recordId=$curriculumList[$i]['cid'];
				$curriculumList[$i]=$this->school_curriculum->where('cid='.$curriculumList[$i]['fid'].' and state=1')->field('cid,title,cover,grade,praise,share,comment')->find();
				//补全封面地址
				$curriculumList[$i]['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$curriculumList[$i]['cover'];
				//评分
				$curriculumList[$i]['grade']=$curriculumList[$i]['grade']/10;
				$curriculumList[$i]['record']=$recordId;
			}
			$output = array(
					'status' 	=>'1',
					'message'	=>'获取成功',
					'curriculumList'	=>$curriculumList
			);
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'获取数据失败（无数据）'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的课程历史记录删除
	* 接收数据格式 'uid'=>用户ID,'recordid'=>公开课历史记录ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：删除成功；
		2：缺少用户ID;
		3：缺少公开课ID;
		4：数据校验失败;
		5：删除失败;
	}
	*/
	public function curriculumDel(){
		$uid =I('uid','');
		$cid =I('recordid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		     
		if(empty($cid)){
			$output = array(
					'status' 	=>'3',
					'message'	=>'缺少公开课历史记录ID'
			);
			$this->ajaxReturn($output);
		}
		//校验用户ID和公开课ID
		$recordData=$this->school_curriculum_record->where('uid='.$uid.' and cid='.$cid.' and state=1')->find();
		if($recordData){
			$state=$this->school_curriculum_record->delete($cid);
			if($state){
				$output = array(
					'status' 	=>'1',
					'message'	=>'删除成功'
				);
			}else{
				$output = array(
					'status' 	=>'5',
					'message'	=>'删除失败'
				);
			}
		}else{
			$output = array(
					'status' 	=>'4',
					'message'	=>'数据校验失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的课程历史记录清空
	* 接收数据格式 'uid'=>用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：清空成功；
		2：缺少用户ID;
		3：清空失败;
	}
	*/
	public function curriculumEmpty(){
		$uid =I('uid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		$state=$this->school_curriculum_record->where('uid='.$uid.' and state=1')->delete();
		if($state){
			$output = array(
					'status' 	=>'1',
					'message'	=>'清空成功'
			);
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'清空失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的收藏学校列表
	* 接收数据格式 'uid'=>用户ID,'page'=>页数（默认为1）,'size'=>每页条数（默认为10条）
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'collectList'=我的收藏学校列表=array(
				'collectId'=>收藏记录ID,
				'cid'=>学校ID,
				'cover'=>学校封面,
				'grade'=>学校评分,
				'name'=>学校名称,
				'adress'=>学校地址,
				'tags'=>学校标签,
			),
		} 
	status = {
		1：获取成功；
		2：缺少用户ID;
		3：获取用户收藏列表失败（无数据）;
	}
	*/
	public function collectSchool(){
		$uid =I('uid','');     
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		//获取用户收藏学校列表
		$collectList=$this->collect->where('uid='.$uid.' and type=1 and state=1')->field('cid,fid')->order('ctime desc')->page($page,$size)->select();
		if($collectList){
			$collectListNum=count($collectList);
			//循环处理数据
			for($i=0;$i<$collectListNum;$i++){
				//获取学校信息
				$collectId=null;
				$collectId=$collectList[$i]['cid'];
				$collectList[$i]=$this->school ->where('cid='.$collectList[$i]['fid'].' and state=1')->field('cid,name,tags,cover,adress,grade')->find();
				//补全封面地址
				$collectList[$i]['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$collectList[$i]['cover'];
				//评分
				$collectList[$i]['grade']=$collectList[$i]['grade']/10;
				//收藏ID
				$collectList[$i]['collectId']=$collectId;
			}
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取成功',
				//我的评论列表
				'collectList'	=>$collectList
			);
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'获取用户收藏列表失败（无数据）'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的收藏学校记录删除
	* 接收数据格式 'uid'=>用户ID,'collectid'=>收藏学校ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：删除成功；
		2：缺少用户ID;
		3：缺少收藏学校ID;
		4：数据校验失败;
		5：删除失败;
	}
	*/
	public function collectSchoolDel(){
		$uid =I('uid','');
		$cid =I('collectid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		     
		if(empty($cid)){
			$output = array(
					'status' 	=>'3',
					'message'	=>'缺少收藏学校ID'
			);
			$this->ajaxReturn($output);
		}
		//校验用户ID和收藏学校ID
		$collectData=$this->collect->where('uid='.$uid.' and cid='.$cid.' and type=1 and state=1')->find();
		if($collectData){
			$state=$this->collect->delete($cid);
			if($state){
				$output = array(
					'status' 	=>'1',
					'message'	=>'删除成功'
				);
			}else{
				$output = array(
					'status' 	=>'5',
					'message'	=>'删除失败'
				);
			}
		}else{
			$output = array(
					'status' 	=>'4',
					'message'	=>'数据校验失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的收藏学校记录清空
	* 接收数据格式 'uid'=>用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：清空成功；
		2：缺少用户ID;
		3：清空失败;
	}
	*/
	public function collectSchoolEmpty(){
		$uid =I('uid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		$state=$this->collect->where('uid='.$uid.' and type=1 and state=1')->delete();
		if($state){
			$output = array(
					'status' 	=>'1',
					'message'	=>'清空成功'
			);
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'清空失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的收藏活动列表
	* 接收数据格式 'uid'=>用户ID,'page'=>页数（默认为1）,'size'=>每页条数（默认为10条）
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'collectList'=我的收藏学校列表=array(
				'collectId'=>收藏记录ID,
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
			),
		} 
	status = {
		1：获取成功；
		2：缺少用户ID;
		3：获取用户收藏列表失败（无数据）;
	}
	*/
	public function collectActivity(){
		$uid =I('uid','');     
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		//获取用户收藏活动列表
		$collectList=$this->collect->where('uid='.$uid.' and type=2 and state=1')->field('cid,fid')->order('ctime desc')->page($page,$size)->select();
		if($collectList){
			$collectListNum=count($collectList);
			//循环处理数据
			for($i=0;$i<$collectListNum;$i++){
				//获取活动信息
				$collectId=null;
				$collectId=$collectList[$i]['cid'];
				$collectList[$i]=$this->school_activity ->where('cid='.$collectList[$i]['fid'].' and state=1')->field('cid,title,cover,stime,etime,adress,praise,share,comment,statecode')->find();
				//补全封面地址
				$collectList[$i]['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$collectList[$i]['cover'];
				//格式化时间
				$collectList[$i]['stime']=date('Y/m/d',$collectList[$i]['stime']);
				$collectList[$i]['etime']=date('Y/m/d',$collectList[$i]['etime']);
				//收藏ID
				$collectList[$i]['collectId']=$collectId;
				
				
			}
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取成功',
				//我的评论列表
				'collectList'	=>$collectList
			);
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'获取用户收藏列表失败（无数据）'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的收藏活动记录删除
	* 接收数据格式 'uid'=>用户ID,'collectid'=>收藏活动ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：删除成功；
		2：缺少用户ID;
		3：缺少收藏活动ID;
		4：数据校验失败;
		5：删除失败;
	}
	*/
	public function collectActivityDel(){
		$uid =I('uid','');
		$cid =I('collectid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		     
		if(empty($cid)){
			$output = array(
					'status' 	=>'3',
					'message'	=>'缺少收藏活动ID'
			);
			$this->ajaxReturn($output);
		}
		//校验用户ID和收藏活动ID
		$collectData=$this->collect->where('uid='.$uid.' and cid='.$cid.' and type=2 and state=1')->find();
		if($collectData){
			$state=$this->collect->delete($cid);
			if($state){
				$output = array(
					'status' 	=>'1',
					'message'	=>'删除成功'
				);
			}else{
				$output = array(
					'status' 	=>'5',
					'message'	=>'删除失败'
				);
			}
		}else{
			$output = array(
					'status' 	=>'4',
					'message'	=>'数据校验失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的收藏活动记录清空
	* 接收数据格式 'uid'=>用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：清空成功；
		2：缺少用户ID;
		3：清空失败;
	}
	*/
	public function collectActivityEmpty(){
		$uid =I('uid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		$state=$this->collect->where('uid='.$uid.' and type=2 and state=1')->delete();
		if($state){
			$output = array(
					'status' 	=>'1',
					'message'	=>'清空成功'
			);
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'清空失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的收藏公开课列表
	* 接收数据格式 'uid'=>用户ID,'page'=>页数（默认为1）,'size'=>每页条数（默认为10条）
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'collectList'=我的收藏学校列表=array(
				'collectId'=>收藏记录ID,
				'cid'=>学校公开课ID,
				'title'=>学校公开课标题,
				'cover'=>学校公开课封面,
				'grade'=>学校公开课评分,
				'praise'=>公开课点赞数,
				'share'=>公开课分享数,
				'comment'=>公开课评论数,
			),
		} 
	status = {
		1：获取成功；
		2：缺少用户ID;
		3：获取用户收藏列表失败（无数据）;
	}
	*/
	public function collectCurriculum(){
		$uid =I('uid','');     
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		//获取用户收藏公开课列表
		$collectList=$this->collect->where('uid='.$uid.' and type=3 and state=1')->field('cid,fid')->order('ctime desc')->page($page,$size)->select();
		if($collectList){
			$collectListNum=count($collectList);
			//循环处理数据
			for($i=0;$i<$collectListNum;$i++){
				//获取活动信息
				$collectId=null;
				$collectId=$collectList[$i]['cid'];
				$collectList[$i]=$this->school_curriculum ->where('cid='.$collectList[$i]['fid'].' and state=1')->field('cid,title,cover,grade,praise,share,comment')->find();
				//补全封面地址
				$collectList[$i]['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$collectList[$i]['cover'];
				//评分
				$collectList[$i]['grade']=$collectList[$i]['grade']/10;
				//收藏ID
				$collectList[$i]['collectId']=$collectId;
				
				
			}
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取成功',
				//我的评论列表
				'collectList'	=>$collectList
			);
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'获取用户收藏列表失败（无数据）'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的收藏公开课记录删除
	* 接收数据格式 'uid'=>用户ID,'collectid'=>收藏公开课ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：删除成功；
		2：缺少用户ID;
		3：缺少收藏公开课ID;
		4：数据校验失败;
		5：删除失败;
	}
	*/
	public function collectCurriculumDel(){
		$uid =I('uid','');
		$cid =I('collectid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		     
		if(empty($cid)){
			$output = array(
					'status' 	=>'3',
					'message'	=>'缺少收藏公开课ID'
			);
			$this->ajaxReturn($output);
		}
		//校验用户ID和收藏公开课ID
		$collectData=$this->collect->where('uid='.$uid.' and cid='.$cid.' and type=3 and state=1')->find();
		if($collectData){
			$state=$this->collect->delete($cid);
			if($state){
				$output = array(
					'status' 	=>'1',
					'message'	=>'删除成功'
				);
			}else{
				$output = array(
					'status' 	=>'5',
					'message'	=>'删除失败'
				);
			}
		}else{
			$output = array(
					'status' 	=>'4',
					'message'	=>'数据校验失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的收藏公开课记录清空  
	* 接收数据格式 'uid'=>用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：清空成功；
		2：缺少用户ID;
		3：清空失败;
	}
	*/
	public function collectCurriculumEmpty(){
		$uid =I('uid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		$state=$this->collect->where('uid='.$uid.' and type=3 and state=1')->delete();
		if($state){
			$output = array(
					'status' 	=>'1',
					'message'	=>'清空成功'
			);
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'清空失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的评论列表
	* 接收数据格式 'uid'=>用户ID,'page'=>页数（默认为1）,'size'=>每页条数（默认为10条）
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'commentList'=我的评论列表=array(
				'cid'=>评论ID,
				'contment'=>评论内容,
				'ctime'=>评论时间,
				'title'=>评论主题,
			),
		} 
	status = {
		1：获取成功；
		2：缺少用户ID;
		3：获取评论列表失败（无数据）;
	}
	*/
	public function commentIndex(){
		$uid =I('uid','');     
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		//获取用户评论列表
		$commentList=$this->comment->where('uid='.$uid.' and state=1')->field('cid,fid,contment,ctime,type')->order('ctime desc')->page($page,$size)->select();
		if($commentList){
			$commentListNum=count($commentList);
			//循环处理数据
			for($i=0;$i<$commentListNum;$i++){
				$commentList[$i]['ctime']=date('Y-m-d',$commentList[$i]['ctime']);
				//获取评论主题
				if($commentList[$i]['type']==1){
					//获取最IN课程主题
					$commentList[$i]['title']=$this->curriculum->getFieldByCid($commentList[$i]['fid'],'title');
				}else if($commentList[$i]['type']==2){
					//评论照片
					$commentList[$i]['title']="学校照片";
				}else if($commentList[$i]['type']==3){
					//获取活动主题
					$commentList[$i]['title']=$this->school_activity->getFieldByCid($commentList[$i]['fid'],'title');
				}else if($commentList[$i]['type']==4){
					//获取公开课主题
					$commentList[$i]['title']=$this->school_curriculum->getFieldByCid($commentList[$i]['fid'],'title');
				}
				//去除无用元素
				unset($commentList[$i]['fid']);
				unset($commentList[$i]['type']);
				if(!$commentList[$i]['title']){
					unset($commentList[$i]);
				}
			}
			$commentList=array_values($commentList);
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取成功',
				//我的评论列表
				'commentList'	=>$commentList
			);
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'获取评论列表失败（无数据）'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的评论删除
	* 接收数据格式 'uid'=>用户ID,'cid'=>评论ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：删除成功；
		2：缺少用户ID;
		3：缺少评论ID;
		4：数据校验失败;
		5：删除失败;
	}
	*/
	public function commentDel(){
		$uid =I('uid','');
		$cid =I('cid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		     
		if(empty($cid)){
			$output = array(
					'status' 	=>'3',
					'message'	=>'缺少评论ID'
			);
			$this->ajaxReturn($output);
		}
		//校验用户ID和评论ID
		$commentData=$this->comment->where('uid='.$uid.' and cid='.$cid.' and state=1')->find();
		if($commentData){
			$state=$this->comment->where('cid='.$cid)->setField('state','2');
			if($state){
				$output = array(
					'status' 	=>'1',
					'message'	=>'删除成功'
				);
			}else{
				$output = array(
					'status' 	=>'5',
					'message'	=>'删除失败'
				);
			}
		}else{
			$output = array(
					'status' 	=>'4',
					'message'	=>'数据校验失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的评论清空
	* 接收数据格式 'uid'=>用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：清空成功；
		2：缺少用户ID;
		3：清空失败;
	}
	*/
	public function commentEmpty(){
		$uid =I('uid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		$state=$this->comment->where('uid='.$uid.' and state=1')->setField('state','2');
		if($state){
			$output = array(
					'status' 	=>'1',
					'message'	=>'清空成功'
			);
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'清空失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的留言列表
	* 接收数据格式 'uid'=>用户ID,'page'=>页数（默认为1）,'size'=>每页条数（默认为10条）
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'messageList'=我的留言列表=array(
				'cid'=>留言ID,
				'uid'=>用户ID,
				'school'=>学校名称,
				'schoolCover'=>学校头像,
				'uname'=>用户名称,
				'uCover'=>用户头像,
				'fid'=>留言学校ID,
				'leaves'=>留言内容,
				'ltime'=>留言时间,
				'reply'=>回复内容,
				'rtime'=>回复时间,
				'statecode'=>状态码 1未回复 2已回复未查看 3已回复已查看,
			),
		} 
	status = {reply
		1：获取成功；
		2：缺少用户ID;
		3：获取我的留言列表失败（无数据）;
	}
	*/
	public function message(){
		$uid =I('uid','');     
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//判断是否是校长
		$schoolId=$this->school_auth->where('statecode=1 and state=1 and uid='.$uid)->field('fid')->find();
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		if($schoolId){
			$schoolId=$schoolId['fid'];
			//获取用户留言列表
			$messageList=$this->message->where('fid='.$schoolId.' and state=1')->field('cid,uid,fid,leaves,reply,ltime,rtime,statecode')->order('ltime desc')->page($page,$size)->select();
		}else{
			//获取用户留言列表
			$messageList=$this->message->where('uid='.$uid.' and state=1')->field('cid,uid,fid,leaves,reply,ltime,rtime,statecode')->order('ltime desc')->page($page,$size)->select();
		}
		if($messageList){
			$messageListNum=count($messageList);
			//循环处理数据
			for($i=0;$i<$messageListNum;$i++){
				//获取学校名称
				$messageList[$i]['school']=$this->school->where('cid='.$messageList[$i]['fid'])->field('name,cover')->find();
				$messageList[$i]['schoolCover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$messageList[$i]['school']['cover'];
				$messageList[$i]['school']=$messageList[$i]['school']['name'];
				//获取用户名称
				$messageList[$i]['uname']=$this->user->where('uid='.$messageList[$i]['uid'])->field('nickname,head_img')->find();
				$messageList[$i]['uCover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$messageList[$i]['uname']['head_img'];
				$messageList[$i]['ucovers']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$messageList[$i]['uname']['head_img'];
				$messageList[$i]['uname']=$messageList[$i]['uname']['nickname'];
				if($messageList[$i]['statecode']==1){
					//未回复
					$messageList[$i]['reply']="";
					$messageList[$i]['rtime']="";
				}else{
					//格式化回复时间
					$messageList[$i]['rtime']=date('Y/m/d H:i',$messageList[$i]['rtime']);
				}
				//格式化留言时间
				$messageList[$i]['ltime']=date('Y/m/d H:i',$messageList[$i]['ltime']);
			}
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取成功',
				//我的留言列表
				'messageList'	=>$messageList
			);
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'获取我的留言列表失败（无数据）'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 回复留言
	* 接收数据格式 'cid'=>ID,'reply'=>回复内容
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：回复成功；
		2：缺少回复ID;
		3：缺少回复内容;
		4：回复失败;
	}
	*/
	public function messageReply(){
		$cid =I('cid','');		
		$reply =I('reply','');		
		if(empty($cid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少回复ID'
			);
			$this->ajaxReturn($output);
		}
		if(empty($reply)){
			$output = array(
					'status' 	=>'3',
					'message'	=>'缺少回复内容'
			);
			$this->ajaxReturn($output);
		}
		$data=null;
		$data['reply']=$reply;
		$data['rtime']=time();
		$data['statecode']=2;
		$state=$this->message->where('cid='.$cid)->save($data);
		if($state){
			$output = array(
				'status' 	=>'1',
				'message'	=>'回复成功'
			);
		}else{
			$output = array(
				'status' 	=>'4',
				'message'	=>'回复失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的留言删除
	* 接收数据格式 'uid'=>用户ID,'cid'=>留言ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：删除成功；
		2：缺少用户ID;
		3：缺少留言ID;
		4：数据校验失败;
		5：删除失败;
	}
	*/
	public function messageDel(){
		$uid =I('uid','');
		$cid =I('cid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		     
		if(empty($cid)){
			$output = array(
					'status' 	=>'3',
					'message'	=>'缺少留言ID'
			);
			$this->ajaxReturn($output);
		}
		//校验用户ID和留言ID
		$messageData=$this->message->where('uid='.$uid.' and cid='.$cid.' and state=1')->find();
		if($messageData){
			$state=$this->message->where('cid='.$cid)->setField('state','2');
			if($state){
				$output = array(
					'status' 	=>'1',
					'message'	=>'删除成功'
				);
			}else{
				$output = array(
					'status' 	=>'5',
					'message'	=>'删除失败'
				);
			}
		}else{
			$output = array(
					'status' 	=>'4',
					'message'	=>'数据校验失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的留言清空
	* 接收数据格式 'uid'=>用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：清空成功；
		2：缺少用户ID;
		3：清空失败;
	}
	*/
	public function messageEmpty(){
		$uid =I('uid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		$state=$this->message->where('uid='.$uid.' and state=1')->setField('state','2');
		if($state){
			$output = array(
					'status' 	=>'1',
					'message'	=>'清空成功'
			);
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'清空失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的活动列表
	* 接收数据格式 'uid'=>用户ID,'page'=>页数（默认为1）,'size'=>每页条数（默认为10条）
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'activitytList'=我的活动列表=array(
				'applyId'=>活动报名ID,
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
			),
		} 
	status = {
		1：获取成功；
		2：缺少用户ID;
		3：获取评论列表失败（无数据）;
	}
	*/
	public function activity(){
		$uid =I('uid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		//获取用户报名的活动列表
		$activitytList=$this->school_activity_apply->where('uid='.$uid.' and state=1')->field('cid,fid')->order('ctime desc')->page($page,$size)->select();
		if($activitytList){
			$activitytListNum=count($activitytList);
			//循环处理数据
			for($i=0;$i<$activitytListNum;$i++){
				//获取活动信息
				$applyId=null;
				$applyId=$activitytList[$i]['cid'];
				$activitytList[$i]=$this->school_activity ->where('cid='.$activitytList[$i]['fid'].' and state=1')->field('cid,title,cover,stime,etime,adress,praise,share,comment,statecode')->find();
				//补全封面地址
				$activitytList[$i]['cover']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$activitytList[$i]['cover'];
				//格式化时间
				$activitytList[$i]['stime']=date('Y/m/d',$activitytList[$i]['stime']);
				$activitytList[$i]['etime']=date('Y/m/d',$activitytList[$i]['etime']);
				//收藏ID
				$activitytList[$i]['applyId']=$applyId;				
			}
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取成功',
				//我的活动列表
				'activitytList'	=>$activitytList
			);
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'获取用户活动列表失败（无数据）'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的活动记录删除
	* 接收数据格式 'uid'=>用户ID,'applyid'=>活动报名ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：删除成功；
		2：缺少用户ID;
		3：缺少活动报名ID
		4：数据校验失败;
		5：删除失败;
	}
	*/
	public function activityDel(){
		$uid =I('uid','');
		$cid =I('applyid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		     
		if(empty($cid)){
			$output = array(
					'status' 	=>'3',
					'message'	=>'缺少活动报名ID'
			);
			$this->ajaxReturn($output);
		}
		//校验用户ID和活动报名ID
		$collectData=$this->school_activity_apply->where('uid='.$uid.' and cid='.$cid.' and state=1')->find();
		if($collectData){
			$state=$this->school_activity_apply->delete($cid);
			if($state){
				$output = array(
					'status' 	=>'1',
					'message'	=>'删除成功'
				);
			}else{
				$output = array(
					'status' 	=>'5',
					'message'	=>'删除失败'
				);
			}
		}else{
			$output = array(
					'status' 	=>'4',
					'message'	=>'数据校验失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的活动记录清空
	* 接收数据格式 'uid'=>用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：清空成功；
		2：缺少用户ID;
		3：清空失败;
	}
	*/
	public function activityEmpty(){
		$uid =I('uid','');		
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		$state=$this->school_activity_apply->where('uid='.$uid.' and state=1')->delete();
		if($state){
			$output = array(
					'status' 	=>'1',
					'message'	=>'清空成功'
			);
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'清空失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 关于我们
	* 接收数据格式 无
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
			'info'=>关于我们
		} 
		status = {
			1：获取成功；
		}
	*/
	public function about(){
		//获取关于我们的值
		$info=$this->appconfig->getFieldByCid('1','value');
		$output = array(
			'status' 	=>'1',
			'message'	=>'获取成功',
			'info'	=>$info
		);
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 用户是否接受推送
	* 接收数据格式 'uid'=>用户ID,'state'=>当前状态 1接受 2不接受
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：修改成功；
		2：缺少用户ID;
		3：缺少当前状态;
		4：修改失败;
	}
	*/
	public function ispush(){
		$uid =I('uid','');
		$state =I('state','');			
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
			
		if(empty($state)){
			$output = array(
					'status' 	=>'3',
					'message'	=>'缺少当前状态'
			);
			$this->ajaxReturn($output);
		}
		if($state==1){
			$ispush=$this->user->where('uid='.$uid.' and state=1')->setField('user_ispush','2');
		}else{
			$ispush=$this->user->where('uid='.$uid.' and state=1')->setField('user_ispush','1');
		}
		if($ispush){
			$output = array(
					'status' 	=>'1',
					'message'	=>'修改成功'
			);
		}else{
			$output = array(
					'status' 	=>'4',
					'message'	=>'修改失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 意见反馈
	* 接收数据格式 'type'=>设备类型 1安卓 2IOS,'contment'=>反馈内容,'contact'=>联系方式
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息
		} 
	status = {
		1：反馈成功；
		2：缺少设备类型;
		3：缺少反馈内容;
		4：缺少联系方式;
		5：反馈失败;
	}
	*/
	public function feedback(){
		$type =I('type','');			
		$contment =I('contment','');			
		$contact =I('contact','');			
		if(empty($type)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少设备类型'
			);
			$this->ajaxReturn($output);
		}
		if(empty($contment)){
			$output = array(
					'status' 	=>'3',
					'message'	=>'缺少反馈内容'
			);
			$this->ajaxReturn($output);
		}
		if(empty($contact)){
			$output = array(
					'status' 	=>'4',
					'message'	=>'缺少联系方式'
			);
			$this->ajaxReturn($output);
		}
		$data=null;
		$data['type']=$type;
		$data['contment']=$contment;
		$data['contact']=$contact;
		$data['ctime']=time();
		$feedbackId=$this->feedback->add($data);
		if($feedbackId){
			$output = array(
					'status' 	=>'1',
					'message'	=>'反馈成功'
			);
		}else{
			$output = array(
					'status' 	=>'5',
					'message'	=>'反馈失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 版本更新
	* 接收数据格式 'cid'=>版本ID,'type'=>设备类型 1安卓 2IOS
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息,
			'edition'=最新版本数据=array(
				'cid'=>版本ID,
				'number'=>版本号,
				'url'=>版本更新地址,
			),
		} 
	status = {
		1：获取最新版本数据成功；
		2：缺少版本ID;
		3：缺少设备类型;
		4：版本已经是最新;
		5：获取最新版本数据失败;
	}
	*/
	public function edition(){
		$cid =I('cid','');			
		$type =I('type','');			
		if(empty($cid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少版本ID'
			);
			$this->ajaxReturn($output);
		}
		if(empty($type)){
			$output = array(
					'status' 	=>'3',
					'message'	=>'缺少设备类型'
			);
			$this->ajaxReturn($output);
		}
		//获取该设备最新版本ID
		$editionId=$this->edition->where('state=1 and type='.$type)->max('cid');
		if($editionId==$cid){
			$output = array(
					'status' 	=>'4',
					'message'	=>'版本已经是最新'
			);
		}else{
			//获取最新版本数据
			$edition=$this->edition->where('cid='.$editionId)->field('cid,number,url')->find();
			if($edition){
				//补全地址
				$edition['url']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$edition['url'];
				$output = array(
					'status' 	=>'1',
					'message'	=>'获取最新版本数据成功',
					'edition'	=>$edition
				);
			}else{
				$output = array(
					'status' 	=>'5',
					'message'	=>'获取最新版本数据失败'
				);
			}
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 版本更新简约版
	* 接收数据格式 无
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息,
			'number'=>版本号,
			'url'=>版本更新地址,
		} 
	status = {
		1：获取版本地址失败；
		2：获取版本号失败;
		3：获取版本地址失败;
	}
	*/
	public function editionEasy(){
		//获取版本号
		//获取关于我们的值
		$number=$this->appconfig->getFieldByCid('2','value');
		if(!$number){
			$output = array(
				'status' 	=>'2',
				'message'	=>'获取版本号失败',
			);
		}
		$url=$this->appconfig->getFieldByCid('3','value');
		//补全地址
		$url='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$url;
		if(!$url){
			$output = array(
				'status' 	=>'3',
				'message'	=>'获取版本地址失败',
			);
		}
		$output = array(
			'status' 	=>'1',
			'message'	=>'获取成功',
			'number'	=>$number,
			'url'	=>$url
		);
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 签到
	* 接收数据格式 'uid'=>用户ID,'type'=>设备类型 1安卓 2IOS
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息,
		} 
	status = {
		1：签到成功；
		2：缺少用户ID;
		3：缺少设备类型;
		4：该用户今天已经签到;
		5：签到记录新增失败;
		6：用户积分增加失败;
		7：积分记录新增失败;
	}
	*/
	public function sign(){
		//设置每次签到奖励的积分值
		$scoreValue=5;
		$uid =I('uid','');			
		$type =I('type','');			
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		if(empty($type)){
			$output = array(
					'status' 	=>'3',
					'message'	=>'缺少设备类型'
			);
			$this->ajaxReturn($output);
		}
		$today=strtotime(date('Y-m-d',time()));
		//判断是否签到
		$state=$this->sign_record->where('today='.$today.' and uid='.$uid.' and state=1')->find();
		if($state){
			$output = array(
					'status' 	=>'4',
					'message'	=>'该用户今天已经签到'
			);
			$this->ajaxReturn($output);
		}else{
			//签到记录新增
			$data=null;
			$data['uid']=$uid;
			$data['today']=$today;
			$data['ctime']=time();
			$data['type']=$type;
			$signId=$this->sign_record->add($data);
			if($signId){
				//用户积分新增
				$userState=$this->user->where('uid='.$uid.' and state=1')->setInc('score',$scoreValue); // 用户的积分增加
				if($userState){
					//积分记录新增
					$datas=null;
					$datas['title']="每日签到+".$scoreValue;
					$datas['uid']=$uid;
					$datas['operate']=1;	//操作类型 1加 2减
					$datas['value']=$scoreValue;	//操作数值
					$datas['type']=1;	//积分类型 1代表签到
					$datas['ctime']=time();	//积分类型 1代表签到
					$scoreId=$this->score_record->add($datas);
					if($scoreId){
						$output = array(
							'status' 	=>'1',
							'message'	=>'签到成功'
						);
					}else{
						$output = array(
							'status' 	=>'7',
							'message'	=>'积分记录新增失败'
						);
					}
				}else{
					$output = array(
						'status' 	=>'6',
						'message'	=>'用户积分增加失败'
					);
				}
			}else{
				$output = array(
					'status' 	=>'5',
					'message'	=>'签到记录新增失败'
				);
			}
			$this->ajaxReturn($output);
		}
	}
	
	
	/*
	* 积分记录
	* 接收数据格式 'uid'=>用户ID,'page'=>页数（默认为1）,'size'=>每页条数（默认为10条）
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息,
			'score'=>用户积分,
			'scoreList'=用户积分记录列表=array(
				'cid'=>记录ID,
				'operate'=>操作值,
				'ctime'=>记录时间,
				'typeText'=>类型文本,
			)
		} 
	status = {
		1：获取用户积分记录成功；
		2：缺少用户ID;
		3：获取用户积分记录失败（无数据）;
	}
	*/
	public function score(){
		$uid =I('uid','');			
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//准备分页
		$page   = intval(I('page')) ? intval(I('page')) : 1;
	    $size   =  intval(I('size')) ? intval(I('size')) : 10;
		//获取用户积分
		$score=$this->user->getFieldByUid($uid,'score');
		//获取用户积分记录
		$scoreList=$this->score_record->where('uid='.$uid.' and state=1')->field('cid,operate,value,type,ctime')->order('ctime desc')->page($page,$size)->select();
		if($scoreList){
			$scoreListNum=count($scoreList);
			//类型判断
			for($i=0;$i<$scoreListNum;$i++){
				if($scoreList[$i]['type']==1){
					$scoreList[$i]['typeText']="签到获取";
				}
				if($scoreList[$i]['operate']==1){
					$scoreList[$i]['operate']="+".$scoreList[$i]['value'];
				}else if($scoreList[$i]['operate']==2){
					$scoreList[$i]['operate']="-".$scoreList[$i]['value'];
				}
				//处理时间格式
				$scoreList[$i]['ctime']=date('Y-m-d',$scoreList[$i]['ctime']);
				//销毁无用变量
				unset($scoreList[$i]['value']);
				unset($scoreList[$i]['type']);
			}
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取用户积分记录成功',
				'score'	=>$score,
				'scoreList'	=>$scoreList,
			);
		}else{
			$output = array(
				'status' 	=>'3',
				'message'	=>'获取用户积分记录失败（无数据）'
			);
		}
		
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我是校长（校长认证申请）
	* 接收数据格式 'uid'=>用户ID,'name'=>机构名称,'cityid'=>区县ID,'address'=>地址,'manager'=>企业法人,'phone'=>联系电话,'idcard'=>身份证,'business'=>营业执照
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息,
		} 
	status = {
		1：提交成功；
		2：缺少用户ID;
		3：缺少机构名称;
		4：缺少区域ID;
		5：缺少地址;
		6：缺少企业法人;
		7：缺少联系电话;
		8：上传身份证出错;
		9：上传营业执照出错;
		10：提交失败;
	}
	*/
	public function principal(){
		$uid =I('uid','');			
		$name =I('name','');			
		$cityid =I('cityid','');			
		$address =I('address','');			
		$manager =I('manager','');			
		$phone =I('phone','');					
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		if(empty($name)){
			$output = array(
					'status' 	=>'3',
					'message'	=>'缺少机构名称'
			);
			$this->ajaxReturn($output);
		}
		if(empty($cityid)){
			$output = array(
					'status' 	=>'4',
					'message'	=>'缺少区域ID'
			);
			$this->ajaxReturn($output);
		}
		if(empty($address)){
			$output = array(
					'status' 	=>'5',
					'message'	=>'缺少地址'
			);
			$this->ajaxReturn($output);
		}
		if(empty($manager)){
			$output = array(
					'status' 	=>'6',
					'message'	=>'缺少企业法人'
			);
			$this->ajaxReturn($output);
		}
		if(empty($phone)){
			$output = array(
					'status' 	=>'7',
					'message'	=>'缺少联系电话'
			);
			$this->ajaxReturn($output);
		}
		$myUpload = new UploadFile();
		$imgpath1 = $myUpload->upload("idcard");//图片路径
		$imgpath2 = $myUpload->upload("business");//图片路径
		if(!$imgpath1){
			$output = array(
				'status' 	=>'8',
				'message'	=>'上传身份证出错'.$myUpload->error,
				'head_img'	=>'http://'.$_SERVER['HTTP_HOST'].__ROOT__.$imgpath
			);
			$this->ajaxReturn($output);
		}
		if(!$imgpath2){
			$output = array(
				'status' 	=>'9',
				'message'	=>'上传营业执照出错'.$myUpload->error,
				'head_img'	=>'http://'.$_SERVER['HTTP_HOST'].__ROOT__.$imgpath
			);
			$this->ajaxReturn($output);
		}
		//准备数据创建
		$data=null;
		$data['uid']=$uid;
		$data['name']=$name;
		$data['cityid']=$cityid;
		$data['address']=$address;
		$data['manager']=$manager;
		$data['phone']=$phone;
		$data['idcard']=$imgpath1;
		$data['business']=$imgpath2;
		$data['ctime']=time();
		$data['cdate']=strtotime(date('Y-m-d',time()));
		$data['statecode']=2;
		$state=$this->school_auth->where('uid='.$uid)->find();
		if($state){
			$authId=$this->school_auth ->where('cid='.$state['cid'])->save($data);
		}else{
			$authId=$this->school_auth ->add($data);
		}
		if($authId){
			$output = array(
					'status' 	=>'1',
					'message'	=>'提交成功'
			);
		}else{
			$output = array(
					'status' 	=>'10',
					'message'	=>'提交失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 校长审核状态查询
	* 接收数据格式 'uid'=>用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息,
			'reason'=>失败原因,
		} 
	status = {
		1：审核通过；
		2：缺少用户ID;
		3：审核中;
		4：审核失败;
		5：该用户暂未申请;
	}
	*/
	public function principalState(){
		$uid =I('uid','');					
		if(empty($uid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//查询用户当前申请状态
		$auth=$this->school_auth->where('uid='.$uid.' and state=1')->field('cid,reason,statecode')->find();
		if($auth){
			if($auth['statecode']==1){
				$output = array(
					'status' 	=>'1',
					'message'	=>'审核通过'
				);
				$this->ajaxReturn($output);
			}else if($auth['statecode']==2){
				$output = array(
					'status' 	=>'3',
					'message'	=>'审核中'
				);
				$this->ajaxReturn($output);
			}else if($auth['statecode']==3){
				$reason=$auth['reason'];
				if(empty($reason)){
					$reason="";
				}
				$output = array(
					'status' 	=>'4',
					'message'	=>'审核失败',
					'reason'	=>$auth['reason']
				);
				$this->ajaxReturn($output);
			}
		}else{
			$output = array(
				'status' 	=>'5',
				'message'	=>'该用户暂未申请'
			);
			$this->ajaxReturn($output);
		}	
	}
	
	
	/*
	* 校长申请信息查询
	* 接收数据格式 'uid'=>用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息,
			'Info'=校长申请信息=array(
				'cid'=>申请ID,
				'name'=>机构名称,
				'cityid'=>区域ID,
				'address'=>地址,
				'manager'=>企业家信息,
				'phone'=>联系电话,
				'idcard'=>身份证,
				'business'=>营业执照,
			),
		} 
	status = {
		1：获取成功；
		2：缺少用户ID;
		3：该用户暂未申请;
	}
	*/
	public function principalInfo(){
		$uid =I('uid','');					
		if(empty($uid)){
			$output = array(
				'status' 	=>'2',
				'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//查询用户当前申请状态
		$auth=$this->school_auth->where('uid='.$uid.' and state=1')->field('cid,name,cityid,address,manager,phone,idcard,business')->find();
		if($auth){
			//补全封面地址
			$auth['idcard']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$auth['idcard'];
			$auth['business']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$auth['business'];
			$output = array(
				'status' 	=>'1',
				'message'	=>'获取成功',
				'Info'	=>$auth
			);
		}else{
			$output = array(
				'status' 	=>'3',
				'message'	=>'该用户暂未申请'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 校长申请信息修改
	* 接收数据格式 'cid'=>申请ID,'name'=>机构名称,'cityid'=>区县ID,'address'=>地址,'manager'=>企业法人,'phone'=>联系电话,'idcard'=>身份证,'business'=>营业执照
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息,
		} 
	status = {
		1：提交成功；
		2：缺少用户ID;
		3：缺少机构名称;
		4：缺少区域ID;
		5：缺少地址;
		6：缺少企业法人;
		7：缺少联系电话;
		8：上传身份证出错;
		9：上传营业执照出错;
		10：提交失败;
	}
	*/
	public function principalEdit(){
		$cid =I('cid','');			
		$name =I('name','');			
		$cityid =I('cityid','');			
		$address =I('address','');			
		$manager =I('manager','');			
		$phone =I('phone','');					
		if(empty($cid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少申请ID'
			);
			$this->ajaxReturn($output);
		}
		if(empty($name)){
			$output = array(
					'status' 	=>'3',
					'message'	=>'缺少机构名称'
			);
			$this->ajaxReturn($output);
		}
		if(empty($cityid)){
			$output = array(
					'status' 	=>'4',
					'message'	=>'缺少区域ID'
			);
			$this->ajaxReturn($output);
		}
		if(empty($address)){
			$output = array(
					'status' 	=>'5',
					'message'	=>'缺少地址'
			);
			$this->ajaxReturn($output);
		}
		if(empty($manager)){
			$output = array(
					'status' 	=>'6',
					'message'	=>'缺少企业法人'
			);
			$this->ajaxReturn($output);
		}
		if(empty($phone)){
			$output = array(
					'status' 	=>'7',
					'message'	=>'缺少联系电话'
			);
			$this->ajaxReturn($output);
		}
		$myUpload = new UploadFile();
		$imgpath1 = $myUpload->upload("idcard");//图片路径
		$imgpath2 = $myUpload->upload("business");//图片路径
		if(!$imgpath1){
			$output = array(
				'status' 	=>'8',
				'message'	=>'上传身份证出错'.$myUpload->error,
				'head_img'	=>'http://'.$_SERVER['HTTP_HOST'].__ROOT__.$imgpath1
			);
			$this->ajaxReturn($output);
		}
		if(!$imgpath2){
			$output = array(
				'status' 	=>'9',
				'message'	=>'上传营业执照出错'.$myUpload->error,
				'head_img'	=>'http://'.$_SERVER['HTTP_HOST'].__ROOT__.$imgpath2
			);
			$this->ajaxReturn($output);
		}
		//准备数据修改
		$data=null;
		$data['uid']=$uid;
		$data['cityid']=$cityid;
		$data['address']=$address;
		$data['manager']=$manager;
		$data['phone']=$phone;
		$data['idcard']=$imgpath1;
		$data['business']=$imgpath2;
		$data['ctime']=time();
		$data['statecode']=2;
		$authId=$this->school_auth ->where('cid='.$cid)->save($data);
		if($authId){
			$output = array(
					'status' 	=>'1',
					'message'	=>'提交成功'
			);
		}else{
			$output = array(
					'status' 	=>'10',
					'message'	=>'提交失败'
			);
		}
		$this->ajaxReturn($output);
	}
	
	
	/*
	* 我的优惠券
	* 接收数据格式 'uid'=>用户ID
	* 返回数据格式
		{
			'status'=>状态,
			'message'=>提示信息,
			'privilegeNList'=未使用的优惠券列表=array(
				每条优惠券数据=array(
					'cid'=>优惠券ID,
					'title'=>优惠券标题,
					'type'=>优惠券类型,
					'bg'=>优惠券背景图,
					'stime'=>优惠券开始时间,
					'etime'=>优惠券结束时间,
					'statecode'=>优惠券状态码 1未开始 2进行中 3已过期,
				),
			),
			'privilegeYList'=已使用的优惠券列表=array(
				每条优惠券数据=array(
					'cid'=>优惠券ID,
					'title'=>优惠券标题,
					'type'=>优惠券类型,
					'bg'=>优惠券背景图,
					'stime'=>优惠券开始时间,
					'etime'=>优惠券结束时间,
					'statecode'=>优惠券状态码 1未开始 2进行中 3已过期,
				),
			),
		} 
	status = {
		1：获取成功；
		2：缺少用户ID;
		3：用户不存在;
		4：用户不是校长身份;
		5：用户暂未领取优惠券;
	}
	*/
	public function privilege(){
		//检测优惠券过期
		$this->privilegeDue();
		$uid =I('uid','');     
		if(empty($uid)){
			$output = array(
					'status' 	=>'2',
					'message'	=>'缺少用户ID'
			);
			$this->ajaxReturn($output);
		}
		//判断用户是否存在
		$state=$this->user->getFieldByUid($uid,'role');
		if($state){
			//判断校长身份
			if($state!=2){
				$output = array(
					'status' 	=>'4',
					'message'	=>'用户不是校长身份'
				);
				$this->ajaxReturn($output);
			}
		}else{
			$output = array(
					'status' 	=>'3',
					'message'	=>'用户不存在'
			);
			$this->ajaxReturn($output);
		}
		//获取我的优惠券列表
		$privilegeList=$this->privilege_apply->where('uid='.$uid.' and state=1')->field('fid,statecode')->order('ctime desc')->select();
		if($privilegeList){
			//已使用的优惠券集
			$privilegeYIds=null;
			//未使用的优惠券集
			$privilegeNIds=null;
			$privilegeListNum=null;
			$privilegeListNum=count($privilegeList);
			for($i=0;$i<$privilegeListNum;$i++){
				if($privilegeList[$i]['statecode']==2){
					$privilegeYIds.=$privilegeList[$i]['fid'].",";
				}else{
					$privilegeNIds.=$privilegeList[$i]['fid'].",";
				}
				
			}
			//去除多余空格
			$privilegeYIds=rtrim($privilegeYIds,',');
			$privilegeNIds=rtrim($privilegeNIds,',');
			//已使用的优惠券组
			$privilegeYWhere['cid']  = array('in',$privilegeYIds);
			$privilegeYWhere['state']  = 1;
			$privilegeYList=$this->privilege->where($privilegeYWhere)->field('cid,type,title,stime,etime,statecode')->select();
			if($privilegeYList){
				$privilegeYListNum=null;
				$privilegeYListNum=count($privilegeYList);
				for($i=0;$i<$privilegeYListNum;$i++){
					//格式化时间
					$privilegeYList[$i]['stime']=date('Y/m/d',$privilegeYList[$i]['stime']);
					$privilegeYList[$i]['etime']=date('Y/m/d',$privilegeYList[$i]['etime']);
					//获取类型背景图
					$privilegeYList[$i]['bg']=$this->privilege_type->getFieldByCid($privilegeYList[$i]['type'],'bg');
					//补全优惠券背景图地址
					$privilegeYList[$i]['bg']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$privilegeYList[$i]['bg'];
				}
			}else{
				$privilegeYList=array();
			}
			//未使用的优惠券组
			$privilegeNWhere['cid']  = array('in',$privilegeNIds);
			$privilegeNWhere['state']  = 1;
			$privilegeNList=$this->privilege->where($privilegeNWhere)->field('cid,type,title,stime,etime,statecode')->select();
			if($privilegeNList){
				$privilegeNListNum=null;
				$privilegeNListNum=count($privilegeNList);
				for($i=0;$i<$privilegeNListNum;$i++){
					//格式化时间
					$privilegeNList[$i]['stime']=date('Y/m/d',$privilegeNList[$i]['stime']);
					$privilegeNList[$i]['etime']=date('Y/m/d',$privilegeNList[$i]['etime']);
					//获取类型背景图
					$privilegeNList[$i]['bg']=$this->privilege_type->getFieldByCid($privilegeNList[$i]['type'],'bg');
					//补全优惠券背景图地址
					$privilegeNList[$i]['bg']='http://'.$_SERVER['HTTP_HOST'].__ROOT__.$privilegeNList[$i]['bg'];
				}
			}else{
				$privilegeNList=array();
			}
			$output = array(
					'status' 	=>'1',
					'message'	=>'获取成功',
					'privilegeNList'	=>$privilegeNList,
					'privilegeYList'	=>$privilegeYList,
			);
		}else{
			$output = array(
					'status' 	=>'5',
					'message'	=>'用户暂未领取优惠券'
			);		
		}
		$this->ajaxReturn($output);
	}
}