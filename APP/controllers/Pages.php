<?php
class PagesController extends CoreController
{
	public function pagesAction(){
    }
	public function pagesaddAction(){
		return true;
    }	
	public function pagesincreaseAction(){
		do{
			if( $this->method!='POST' ){
				$result	= array(
							'code'	=>	'300',
							'msg'	=>	'操作失败',										
						);
				break;
			}
			$title		= $this->getPost('title', '');
			$keywords	= $this->getPost('keywords', '');
			$content	= $this->getPost('content', '');
			$status		= $this->getPost('status', 1);			
			if( empty($title) || empty($content) ){
				$result	= array(
							'code'	=>	'300',
							'msg'		=>	'页面标题和内容不能为空',
						);
				break;
			}
			$rows	=	array(				
							'title'			=>	$title,
							'keywords'		=>	$keywords,
							'content'		=>	$content,
							'created_at'	=>	date('Y-m-d H:i:s'),
							'status'		=>	intval($status),
						);		
			if( DB::table('pages')->insert($rows) ){
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
	public function pageseditAction(){    
		$id			= $this->get('id', 0);
		$dataset  	= DB::table('pages')->find(intval($id));		
		$this->_view->assign('dataset', $dataset);
    }	
    public function pagesupdateAction(){
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
			$keywords	= $this->getPost('keywords', '');
			$content	= $this->getPost('content', '');
			$status		= $this->getPost('status', 1);
			$rows	=	array(		
							'title'			=>	$title,
							'keywords'		=>	$keywords,
							'content'		=>	$content,
							'updated_at'	=>	date('Y-m-d H:i:s'),
							'status'		=>	$status,
						);	
			if( empty($id) || empty($title) || empty($content) ){
				$result	= array(
							'code'	=>	'300',
							'msg'		=>	'页面ID,标题和内容不能为空',
						);
				break;
			}
			if( DB::table('pages')->where('id','=',$id)->update($rows)!==FALSE ){
				$result	= array(
							'code'	=>	'200',
							'msg'		=>	'更新成功',	
				);
			}else{
				$result	= array(
							'code'	=>	'300',
							'msg'		=>	'更新失败',	
				);
			}
		}while(FALSE);
    			
		die(json_encode($result));
    }		
    public function pagesdeleteAction(){	
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
			if(DB::table('pages')->delete($id)){
				$result		= array(
							'code'	=>	'200',
							'msg'		=>	'操作成功',
							'navTabId'		=>	'pages',
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
	
	public function templateAction(){
		$dir 	= Yaf_Registry::get('config')['smarty']['template_dir'] . '/index';
		$filearr= array();	
		if(is_dir($dir) && $dh=opendir($dir)){
			while (($file = readdir($dh)) !== false)
			{
				if(!is_dir($file)){
					array_push($filearr, $file);
				}
			}
			closedir($dh);			
		}
		sort($filearr);
		
		$this->_view->assign('dir',            $dir);
		$this->_view->assign('filearr',        $filearr);
    }	
	public function readfileAction(){
		$dir 	= $this->config->smarty->template_dir . '/index';
		$file	= $this->getPost('filename', '');

		die(file_get_contents($dir.DS.$file));
	}	
	public function updatefileAction(){
		$dir 		= $this->config->smarty->template_dir . '/index';
		$file		= $this->getPost('filename', '');
		$content	= $this->getPost('content', '');
		$content	= base64_decode($content);
		$bit		= file_put_contents($dir . '/' . $file, $content);
		if( $bit>0 ){
			$result	= array(
							'code'	=>	'200',
							'msg'		=>	'操作成功',
						);
		}else{
			$result	= array(
							'code'	=>	'300',
							'msg'		=>	'操作失败',										
						);
		}
		die(json_encode($result));
	}
	
	/**
     * deal imgage upload
     */
	public function uploadimgAction(){
		$files	= $this->getFiles('filedata', NULL);				
		if( $files!=NULL && $files['size']>0 ){
			if( $image = $this->_uploadPicture('filedata') ){
				$rows	=	array(
									'err'	=>	'',
									'msg'	=>	$image,
							);
			}else{
				$rows	=	array(
									'err'	=>	'300',
									'msg'	=>	'文件上传失败',
							);
			}
		}
		die( json_encode($rows) );		
	} 
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
			
			$filename = 'pages-t' . time() . '.' . $files->getExt();
			$descdir  = $config['application']['uploadpath'] . '/Pages/';
			if( !is_dir($descdir) ){ mkdir($descdir); }
			$realpath = $descdir . $filename;
			if($files->move($realpath)){				
				return str_replace('./', '/', $realpath);
			}
        }while(false);
        
        return false;
    }

	
}