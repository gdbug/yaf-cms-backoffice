<?php

class AdminController extends CoreController
	public function indexAction() {
	}
	public function mainAction() {
	public function infoAction() {
    }
	public function infoCellUpdateAction(){
			if( $this->method=='POST' ){
				$rows	=	$this->getPost()['data'];
				if( $info->where($key,'=',$id)->update($rows)!==FALSE  ){
					$result	= array(
								'code'=>	'200',
								'msg'	=>	'更新成功',										
							);
				}else{
					$result	= array(
								'code'=>	'300',
								'msg'	=>	'更新失败',										
							);
				}
			}else{
				$result	= array(
								'code'=>	'300',
								'msg'	=>	'提交方式有误',										
							);
			}
		}while(FALSE);
    }
	
	public function menusAction(){		    	
		$this->_view->assign('uniqid',	 uniqid());
    }	
	public function menusaddAction(){
		$dataset  	= DB::table('menus')->where('up','=',0)->get();
		$this->_view->assign('dataset', $dataset);
    }	
	public function menusincreaseAction(){
		do{
			if( $this->method!='POST' ){
				$result	= array(
							'code'=>	'300',
							'msg'	=>	'操作失败',										
						);
				break;
			}
			$title		= $this->getPost('title', '');
			$links		= $this->getPost('links', '');
			$up			= $this->getPost('up', 	0);
			$sortorder	= $this->getPost('sortorder', 0);			
			if( empty($title) ){
				$result	= array(
							'code'	=>	'300',
							'msg'		=>	'菜单名称不能为空',
						);
				break;
			}
			$rows	= array(
								'title'		=>	$title,
								'links'		=>	$links,
								'up'		=>	$up,
								'sortorder'	=>	$sortorder,
					);
			if( DB::table('menus')->insert($rows) ){
				$result	= array(
							'code'	=>	'200',
							'msg'		=>	'操作成功',								
						);
			}else{
				$result	= array(
							'code'=>	'300',
							'msg'	=>	'数据插入失败',	
						);
			}
		}while(FALSE);
		
		die(json_encode($result));
    }	
	public	function menuseditAction(){    
		$dataset  	= DB::table('menus')->where('up','=',0)->get();
		
		$id			= intval($this->get('id', NULL));
		if($id==NULL){	return false;	}		
     	$mymenu  	= DB::table('menus')->find($id);

		$this->_view->assign('dataset', $dataset);
		$this->_view->assign('mymenu',  $mymenu);
    }	
    public function menusupdateAction(){
		do{
			if( $this->method!='POST' ){
				$result	= array(
							'code'	=>	'300',
							'msg'		=>	'操作失败',										
						);
				break;
			}
			$id			= $this->getPost('id', '');
			$title		= $this->getPost('title', '');
			$links		= $this->getPost('links', '');
			$up			= $this->getPost('up', 	0);
			$sortorder	= $this->getPost('sortorder', 0);			
			if( empty($id)||empty($title) ){
				$result	= array(
							'code'	=>	'300',
							'msg'		=>	'菜单id与标题不能为空',
						);
				break;
			}
			if( $id==$up ){
				$result	= array(
							'code'	=>	'300',
							'msg'		=>	'上级菜单循环设置.',
						);
				break;
			}
			$rows	=	array(	
							'title'		=>	$title,
							'links'		=>	$links,
							'up'		=>	$up,
							'sortorder'	=>	$sortorder,
						);
			if( DB::table('menus')->where('id','=',$id)->update($rows)!==FALSE ){
				$result	= array(
							'code'		=>	'200',
							'msg'		=>	'操作成功',	
						);
			}else{
				$result	= array(
							'code'		=>	'300',
							'msg'		=>	'更新失败',	
						);
			}
		}while(FALSE);
    			
		die(json_encode($result));
    }		
    public function menusdeleteAction(){	
		do{
			if($this->method!='POST'){
				$result	= array(
							'code'=>	'300',
							'msg'	=>	'操作失败',										
						);
				break;				
			}
			$id	= $this->get('id', '');
			if( empty($id) ){
				$result	= array(
							'code'	=>	'300',
							'msg'		=>	'参数为空',
						);
				break;
			}
			if(DB::table('menus')->delete($id)){
				$result		= array(
							'code'	=>	'200',
							'msg'		=>	'操作成功',
							'navTabId'		=>	'menus',
							);						
			}else{
				$result		= array(
							'code'	=>	'300',
							'msg'		=>	'删除失败',
							);
			}
		}while(FALSE);	
		
		die(json_encode($result));    	
    }
	
	
	public function imagesAction(){
		$this->_view->assign('uniqid',	 uniqid());
    }
	public function imagesaddAction(){
		return true;
    }	
	public function imagesincreaseAction(){
		do{
			if( $this->method!='POST' ){
				$result	= array(
							'code'=>	'300',
							'msg'	=>	'操作失败',										
						);
				break;
			}
			$title		= $this->getPost('title', '');
			$links		= $this->getPost('links', '');
			$sortorder	= $this->getPost('sortorder', 0);			
			$status		= $this->getPost('status', 	0);
			if( empty($title) ){
				$result	= array(
							'code'	=>	'300',
							'msg'		=>	'图片标题不能为空',
						);
				break;
			}
			$rows	= array(
								'title'		=>	$title,
								'links'		=>	$links,
								'sortorder'	=>	$sortorder,
								'status'	=>	$status,
			);
			if( DB::table('images')->insert($rows) ){
				$result	= array(
							'code'		=>	'200',
							'msg'		=>	'操作成功',	
						);
			}else{
				$result	= array(
							'code'=>	'300',
							'msg'	=>	'数据插入失败',	
						);
			}
		}while(FALSE);
		
		die(json_encode($result));
    }	
	public	function imageseditAction(){
		$id			= $this->get('id', NULL);
		if($id==NULL){	return false;	}		
     	$dataset  	= DB::table('images')->find(intval($id));

		$this->_view->assign('dataset', $dataset);
    }
    public function imagesupdateAction(){
		do{
			if( $this->method!='POST' ){
				$result	= array(
							'code'	=>	'300',
							'msg'		=>	'操作失败',										
						);
				break;
			}
			$id			= $this->getPost('id', '');
			$title		= $this->getPost('title', '');
			$links		= $this->getPost('links', '');		
			$sortorder	= $this->getPost('sortorder', 0);			
			$status		= $this->getPost('status', 	0);
			if( empty($id)||empty($title) ){
				$result	= array(
							'code'	=>	'300',
							'msg'		=>	'图片id与标题不能为空',
						);
				break;
			}
			$rows	=	array(	
							'title'		=>	$title,
							'links'		=>	$links,
							'sortorder'	=>	$sortorder,
							'status'	=>	$status,
						);						
			if( DB::table('images')->where('id','=',$id)->update($rows)!==FALSE ){
				$result	= array(
							'code'		=>	'200',
							'msg'		=>	'操作成功',	
						);
			}else{
				$result	= array(
							'code'		=>	'300',
							'msg'		=>	'更新失败',	
						);
			}
		}while(FALSE);
    			
		die(json_encode($result));
    }		
    public function imagesdeleteAction(){	
		do{
			if($this->method!='POST'){
				$result	= array(
							'code'=>	'300',
							'msg'	=>	'操作失败',										
						);
				break;				
			}
			$id	= $this->get('id', '');
			if( empty($id) ){
				$result	= array(
							'code'	=>	'300',
							'msg'		=>	'参数为空',
						);
				break;
			}
			if(DB::table('images')->delete($id)){
				$result		= array(
							'code'	=>	'200',
							'msg'		=>	'操作成功',
							);						
			}else{
				$result		= array(
							'code'	=>	'300',
							'msg'		=>	'删除失败',
							);
			}
		}while(FALSE);	
		
		die(json_encode($result));    	
    }
	
	public function friendlinkAction(){
    	$this->_view->assign('uniqid',	 uniqid());
    }
	public function friendlinkaddAction(){
		return true;
    }
	
	
	public function changepwdAction() {	
		$this->_view->assign('username', $this->auth->name);
    }	
	public function changepwddoAction(){
		do{
			$id			=	$this->auth->user_id;
			$oldPassword=	$this->getPost('oldpassword', '');
			$newPassword=	$this->getPost('newpassword', '');
			$rePassword=	$this->getPost('repassword', '');
			do{
				if( empty($id)||empty($oldPassword)||empty($rePassword) ){
					$result	= array(
								'code'	=>	'300',
								'msg'		=>	'原密码或新密码不能为空',
							);	
					break;				
				}
				if( $rePassword!=$newPassword ){
					$result	= array(
								'code'	=>	'300',
								'msg'		=>	'重复密码不一致.',
							);	
					break;				
				}
				/***检查旧密码是否正确***/
				$rows	=	DB::table('admin')->find($id);				
				if( $rows['password']!==md5($oldPassword) ){
					$result	= array(
								'code'	=>	'300',
								'msg'	=>	'原密码输入有误.',
							);	
					break;
				}
				unset($rows);
				$rows	=	['password'	=>	md5($newPassword)];
				if( DB::table('admin')->where('id','=',$id)->update($rows)!==FALSE ){
						$result	= array(
								'code'	=>	'200',
								'msg'	=>	'操作成功',
						);
				}else{
						$result	= array(
								'code'	=>	'300',
								'msg'	=>	'更新失败,请多试几下',	
						);
				}			
			}while(FALSE);
		}while(FALSE);
		die(json_encode($result));
	}	
	
	public function uploadToCDNAction() {
	
	/**
     * deal imgage upload
     */
    private function _uploadPicture($upfile) {
        do {
            $uploader  = new FileUploader();
            $files     = $uploader->getFile($upfile);
            if(!$files) break; 
            if($files->getSize()==0){
				//throw new Exception('file size is zero.');
				break;
            }
			$config	= Yaf_Registry::get('config');
            if (!$files->checkExts($config['application']['upfileExts'])){				
            	//throw new Exception('文件类型出错, 只允许'.$config['application']['upfileExts']);
                break;
            }
			if (!$files->checkSize($config['application']['upfileSize'])){
            	//throw new Exception('文件大小出错, 不允许超过.'.$config['application']['upfileSize'].'字节');
                break;
            }
			
			$filename = 'home-t' . time() . '.' . $files->getExt();
			$descdir  = $config['application']['uploadpath'] . '/Home/';
			if( !is_dir($descdir) ){ mkdir($descdir); }
			$realpath = $descdir . $filename;			
			if($files->move($realpath)){				
				return str_replace('./', '/', $realpath);
			}
        }while(false);
        
        return false;
    }

	
}