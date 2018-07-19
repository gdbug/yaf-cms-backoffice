<?php
class PagesController extends CommonController
{
	/**
	public function templateAction(){
		$dir 	= $this->config['application']['directory'] . '/views/index/';
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
		$dir 	= $this->config['application']['directory'] . '/views/index/';
		$file	= $this->getPost('filename', '');

		die(file_get_contents($dir.$file));
	}	
	public function updatefileAction(){
		$dir 	= $this->config['application']['directory'] . '/views/index/';
		$file		= $this->getPost('filename', '');
		$content	= $this->getPost('content', '');
		$content	= base64_decode($content);
		$bit		= file_put_contents($dir . $file, $content);
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