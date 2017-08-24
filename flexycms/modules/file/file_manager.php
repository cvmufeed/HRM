<?php
/*
 * Class   : file_manager
 * Purpose : All files related functionalities goes here
 */
class file_manager extends mod_manager {
#######################################################################################################
### Function Name : file_manager	  							    ###
### Description   : This is a constructor 							    ###					 
### Input         : Reference of smarty,input and output parameters 	  			    ###
### Output	  : Initiates mod manager and initialize object and business class for file manager ###
#######################################################################################################
	function file_manager (& $smarty, & $_output, & $_input) {
		if($_REQUEST['ce']!='0'){
	    		check_session();
	    	}elseif($_REQUEST['choice']!='uploadFile'){
	    		if(!$_SESSION['id_user']){
				exit("nosession");
	    		}
	    	}
		$this->mod_manager($smarty, $_output, $_input, 'file');
		$this->obj_file = new file;
		$this->file_bl = new file_bl;
 	}
######################################################################################################
### Function Name : get_module_name(Predefined Function)					  ####
######################################################################################################
	function get_module_name() { 
		return 'file';
	}
######################################################################################################
### Function Name : get_manager_name(Predefined Function) 					   ###
######################################################################################################
	function get_manager_name() {
		return 'file';
	}
######################################################################################################
### Function Name : default(Predefined Function) 		  				   ###
### Description   : Handle default request(if no choice specified)                                 ###
######################################################################################################
	function _default() {
		return true;
	}
######################################################################################################
### Function Name : manager_error_handler						           ###
### Description   : Function to handle error when choice not found                                 ###
### Input         : No input 						   			   ###
### Ouput         : Error handling template.		         			           ###
######################################################################################################
	function manager_error_handler() {
		$call = "_".$this->_input['choice'];
		if (function_exists($call)) {
			$call($this);
		} else {
			//Put your own error handling code here
			$this->_output['tpl'] ='default/error_handler';
		}
	}
	
##################################################################
	function _uploadFile(){
		$fname =convert_me($_FILES['Filedata']['name']);
		$fileArray['id_company'] = $this->_input['id_company'];
		$fileArray['id_folder']  = $this->_input['id_parent']?$this->_input['id_parent']:'0';
		$fileArray['filename']   = $fname;
		$fileArray['filesize']   = $this->getFileSize($_FILES['Filedata']['size'],"byte");
		$fileArray['file_ext_type']   = strtolower(substr(strrchr($fname,"."),1));
		$id =  $this->obj_file->insert("companyFile",$fileArray);
		if($id){
			print copy($_FILES['Filedata']['tmp_name'],APP_ROOT."files/files/".$id."_".$fname);
			print $id."_".$fname."::".getmessage('FILE_INS_SUCC');		
		}else{
			print "::".getmessage('FILE_INS_FAIL');				
		}
		exit;
	}
##################################################################
### Function Name : list									   ###
### Description   : Function to show list of files and folders ###
### Input         : No input 	  							   ###
### Output	  	  : List Template  							   ###
##################################################################
	function temp_list(){
		global $link;
		$path = '<a href="'.LBL_SITE_URL.'file/list" title="root">'."Root".'</a>';
		$fid = $this->_input['fid'] ? $this->_input['fid'] : 0;
		
		$folder_sql = get_search_sql("companyFolder","id_parent = $fid ORDER BY folder_name ASC");
		$rec 		= $link->query($folder_sql);
		while($res = $rec->fetch_assoc()){
			$cntFF 		= 1;
			$cnt_fol	= $this->file_bl->countFF("companyFolder","id_parent",$res['id_folder']);
			if(!$cnt_fol['no_FF']){
				$cnt_file	= $this->file_bl->countFF("companyFile","id_folder",$res['id_folder']);
				if(!$cnt_file['no_FF'])
					$cntFF = 0;
			}
			$res['cnt']	= $cntFF;
			$result[] 	= $res;
		}
		$file_sql   = get_search_sql("companyFile","id_folder = $fid ORDER BY filename ASC");
				
		if($fid){
			$breadcom = $this->getBreadcom($fid,"");
			$path    .= $this->getPath(trim($breadcom,"--"));
		}
				
		$this->_output['path'] 		 = $path;
		//$this->_output['folder_res'] = getrows($folder_sql,$err);
		$this->_output['folder_res'] = $result;
		$this->_output['file_res']   = getrows($file_sql,$err);
		$this->_output['fid']        = $fid;
		$this->_output['tpl']        = "file/list";			
	}
	function _list($fid='',$msg=''){
		global $link;
		if($fid!=''){
			$_SESSION['msg']=$msg;
		}else{
			$_SESSION['msg']='';
		}
		$uri="file/list/";
		$path = '<a href="'.LBL_SITE_URL.'file/list" title="root">'."Root".'</a>';
		$fid = $this->_input['fid'] ? $this->_input['fid'] : 0;
		
		$sql="SELECT * FROM ((SELECT id_folder id,id_parent idf,folder_name name,'category' ftype,'' fsize,add_date adddate,'2' typ,if((SELECT cfo.id_parent FROM ".TABLE_PREFIX."companyFolder cfo WHERE cfo.id_parent=f.id_folder LIMIT 1)!='','1',if((SELECT cfi.id_file FROM ".TABLE_PREFIX."companyFile cfi WHERE cfi.id_folder=f.id_folder LIMIT 1)!='','1','0')) iner FROM hrm__companyFolder f ) UNION (SELECT id_file id,id_folder idf,filename name,file_ext_type ftype,filesize fsize,add_date adddate,'1' typ,'0' iner FROM ".TABLE_PREFIX."companyFile)) T WHERE idf=".$fid." ORDER BY concat(T.typ,T.adddate) DESC";

		if($fid!=0){
			$uri.="fid-".$fid;
			$breadcom = $this->getBreadcom($fid,"");
			$path    .= $this->getPath(trim($breadcom,"--"));
		}				
		$this->_output['path'] 	= $path;
		$this->_output['idparent'] = $fid;
		$this->_output['list']=getrows($sql,$err);
		
		if(!$this->_input['chk']){
			$this->_output['tpl']="file/searchFile";
		}else{
			$this->_output['tpl']="file/list";
		}
	}
#####################################################################################################
### Function Name : getBreadcom									  ###
### Description   : Recursion function to show list of files and folders 			  ###
### Input         : $fid(Folder ID),$str(String to return folder ID and Folder name               ###
### Output	  : String with folder ID and Folder name  				          ###
#####################################################################################################
	function getBreadcom($fid,$str){
		global $link;
		if($fid == 0){
			return $str;
		}else{
			$sql = get_search_sql("companyFolder","id_folder = $fid LIMIT 1");
			$res = getsingleindexrow($sql);
			$str .= $res['id_folder']."::".$res['folder_name']."--";
			return $this->getBreadcom($res['id_parent'],$str);
		}
	}
######################################################################################################
### Function Name : getPath					     				   ###
### Description   : Function to return breadcomb path				                   ###
### Input         : $breadcom(String with folder ID and Folder name)                               ###
### Output	  : Breadcomb path to show in template                                             ###
######################################################################################################
	function getPath($breadcom){
		$str = "";
		$bdArray = explode("--",$breadcom);
		foreach(array_reverse($bdArray,true) as $k => $v){
			$valArray = explode("::",$v);
			$str .= '&nbsp;&nbsp;>>&nbsp;&nbsp;<a href="'.LBL_SITE_URL.'file/list/fid-'.$valArray[0].'" title="root">'.$valArray[1].'</a>';
		}
		return $str;
	}
######################################################################################################
### Function Name : addFile									   ###			
### Description   : Function to show template to add new file or folder				   ###
### Input         : No input									   ###	 	
### Output        : Template to show add file or folder  	                                   ###
######################################################################################################
	function _addFile(){
		$this->_output['id_parent'] = $this->_input['id_parent']?$this->_input['id_parent']:0;
		$this->_output['id_company']=$_SESSION['id_company'];
		if($this->_input['flg']=='edit'){
			$sql=get_search_sql("companyFolder","id_folder=".$this->_input['id_folder']);
			$this->_output['res']=getsingleindexrow($sql);
		}
		$this->_output['tpl'] = "file/addFile";
	}
######################################################################################################
### Function Name : insertFF									   ###
### Description   : Function to insert new folder					           ###
### Input         : Form input									   ###
### Output	  : Insert record to table and redirect to list function                           ###                       
######################################################################################################
	function _insertFF(){
		$folderArray['id_company'] 	= $_SESSION['id_company'];
		$folderArray['id_parent'] 	= $this->_input['id_parent'];
		$folderArray['folder_name'] = $this->_input['FF_name'];
		$id =  $this->obj_file->insert("companyFolder",$folderArray);
		if($id)				
			$_SESSION['raise_message']['global'] = getmessage('CAT_INS_SUCC');	
		else
			$_SESSION['raise_message']['global'] = getmessage('CAT_INS_FAIL');
		$url = "index.php/file/list";
		if($this->_input['id_parent'] && $this->_input['id_parent']!=0)
			$url .= "/fid-".$this->_input['id_parent'];
		redirect(LBL_SITE_URL.$url);
	}
######################################################################################################
### Function Name : updateFF									   ###
### Description   : Function to update folder						           ###
### Input         : Form input									   ###
### Output	  : update record to table and redirect to list function                           ###                       
######################################################################################################
	function _updateFF(){
		$folderArray['folder_name'] = $this->_input['FF_name'];
		$id =  $this->obj_file->update("companyFolder",$folderArray,"id_folder=".$this->_input['idfold']." AND id_company=".$_SESSION['id_company']);
		if($id)				
			$_SESSION['raise_message']['global'] = getmessage('CAT_UPD_SUCC');	
		else
			$_SESSION['raise_message']['global'] = getmessage('CAT_UPD_FAIL');
		$url = "file/list";
		if($this->_input['id_parent'] && $this->_input['id_parent']!=0)
			$url .= "/fid-".$this->_input['id_parent'];
		redirect(LBL_SITE_URL.$url);
	}
######################################################################################################
### Function Name : getFileSize									   ###
### Description   : Function to return file size in byte,KB,MB or GB format	                   ###
### Input         : $size(size of file),$unit(unit as defined)		 		           ###
### Output	  : String with file size in byte,KB,MB or GB format  		                   ###
######################################################################################################	
	function getFileSize($size,$unit){
		if($size < 1024){
			$str = round($size,2)." ".$unit;
			return $str;
		}else {
			if($unit == "byte")
				$unit='KB';
			elseif($unit=='KB')
				$unit='MB';
			else
				$unit='GB';
			return $this->getFileSize(($size/1024),$unit);			
		}
	}
######################################################################################################
### Function Name : deleteFF						                           ###
### Description   : Function to delete file or folder                                              ###
### Input         : Input from ajax		 			                           ###
### Output	  : Delete file or folder        			                           ###
######################################################################################################	
	function _deleteFF(){		
		if($this->_input['typ']=='1'){			
			$table = "companyFile";
			$field = "id_file";
			$nm='file';
		}else{
			$table = "companyFolder";
			$field = "id_folder";			
			$nm='category';
		}
		$id =  $this->obj_file->delete($table,$field,$this->_input['id']);
		if($id){
			if($this->_input['typ']=='1'){
				unlink(APP_ROOT."files/files/".$this->_input['id']."_".$this->_input['file_name']);
			}
			$msg=$nm.' '.getmessage('COM_DEL_SUCC');
		}else{
			$msg=getmessage('COM_DEL_FAIL').$nm.'.';
		}
		$msg=ucfirst(strtolower($msg));
		print "<script>callmsg('".$msg."')</script>";
		$this->_list($this->_input['fid'],'');
	}
######################################################################################################
### Function Name : downloadFile						                   ###
### Description   : Function to download file                                                      ###
### Input         : Input from ajax		 			                           ###
### Output	  : download file                     			                           ###
######################################################################################################	
	function _downloadFile(){
		$filename=$this->_input['id']."_".$this->_input['file_name'];
		$file_extension = strtolower(substr(strrchr($filename,"."),1));
		switch( $file_extension ) {
		 	case "pdf": $ctype="application/pdf"; break;
			case "exe": $ctype="application/octet-stream"; break;
			case "zip": $ctype="application/zip"; break;
			case "doc": $ctype="application/msword"; break;
			case "xls": $ctype="application/vnd.ms-excel"; break;
			case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
			case "gif": $ctype="image/gif"; break;
			case "png": $ctype="image/png"; break;
			case "jpeg":
			case "jpg": $ctype="image/jpg"; break;
			case "mp3": $ctype="audio/mpeg"; break;
			case "wav": $ctype="audio/x-wav"; break;
			case "mpeg":
			case "mpg":
			case "mpe": $ctype="video/mpeg"; break;
			case "mov": $ctype="video/quicktime"; break;
			case "avi": $ctype="video/x-msvideo"; break;
			case "xml": $ctype="text/xml"; break;
			case "css": $ctype="text/css"; break;
			case "js": $ctype="application/javascript"; break;
			case "php":
			case "htm":
			case "html":
			case "csv":$ctype="application/csv";break;
			case "txt": $ctype="text/plain";break;
			default: $ctype="application/force-download";
		}
		ob_clean();	
		header("Content-type:".$ctype);
		header('Content-length: '.filesize(APP_ROOT."files/files/".$filename));	
		header("Content-Disposition: attachment; filename=".$this->_input['file_name']);	
		readfile(APP_ROOT."files/files/".$filename);
		exit;
	}
}
