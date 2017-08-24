<?php
/**
 * Class   : setting_manager
 * Purpose : All setting coding done here. 
 */
class setting_manager extends mod_manager {
#######################################################################################################
### Function Name : setting_manager	  							    ###
### Description   : This is a constructor 							    ###					 
### Input         : Reference of smarty,input and output parameters 	  			    ###
### Output	  : Initiates mod manager and initialize object and business class for user manager ###
#######################################################################################################
	function setting_manager (& $smarty, & $_output, & $_input) {
		if($_REQUEST['ce']!='0'){
	    		check_session();
	    	}else{
	    		if(!$_SESSION['id_user']){
	    			exit("<span class='fcolor'>".getmessage('COM_NO_SESSION')."Please <a href='javascript:void(0);' onclick=check_JSsession('nosession',0); style='text-decoration : underline;'>click</a> here to log in again</span>");
	    		}
	    	}
		$this->mod_manager($smarty, $_output, $_input, 'setting');
		$this->obj_setting = new setting;
		$this->setting_bl = new setting_bl;
 	}
####################################################################################################
### Function Name : get_module_name(Predefined Function)				        ####
####################################################################################################
	function get_module_name() { 
		return 'setting';
	}
####################################################################################################
### Function Name : get_manager_name(Predefined Function) 					 ###
####################################################################################################
	function get_manager_name() {
		return 'setting';
	}
######################################################################################################
### Function Name : default(Predefined Function) 		  				   ###
### Description   : Handle default request(if no choice specified)                                 ###
######################################################################################################
	function _default() {
		return true;
	}
####################################################################################################
### Function Name : _listing					         	     		 ###
### Description   : Function to show setting listing                                             ###
### Input         : No input 						      	                 ###
### Ouput	  : listing template                                                             ###
####################################################################################################
	function _listing(){
		check_session();
		if(!$_SESSION['id_developer']){
			$cond=" is_editable=1 ";
			$this->_output['tpl']='setting/listing';
		}else{
			redirect(LBL_SITE_URL);		
		}
		$sql = get_search_sql("config",$cond." ORDER BY	name,id_seq ");
		$this->_output['res']=getrows($sql,$err);
	}
####################################################################################################
### Function Name : _add         			         	        		 ###
### Description   : Function to show editable language template with add option in fancybox      ###
### Input         : No input 						      	                 ###
### Ouput	  : dev_add template                                                             ###
####################################################################################################
	function _add(){
		check_session();
		global $link;
		$sql.=get_search_sql('config','');
		if($this->_input['id_config']) {
			$sql.= " WHERE id_config = '".$this->_input['id_config']."' LIMIT 1";
			$this->_output['section'] = getsingleindexrow($sql);
			$this->_output['add_section'] = 1;
		}else {
			$sql.=" GROUP BY name";
			$this->_output['section']=getindexrows($sql,'name','name');
		}
		$this->_output['f_type']=array("text" => "Text","radio" => "Radio","checkbox" => "Checkbox","dropdown" => "Drop Down");
		$this->_output['tpl']='setting/dev_add';
	}

####################################################################################################
### Function Name : _edit                		                      	     		 ###
### Description   : Function to show editable setting options                                    ###
### Input         : No input 						      	                 ###
### Ouput	  : dev_add template                                                             ###
####################################################################################################	
	function _edit(){
		check_session();
		$sql=get_search_sql("config"," GROUP BY name");
		$this->_output['section']=getindexrows($sql,'name','name');
		$sql_config = get_search_sql('config',"id_config = '".$this->_input['id_config']."' LIMIT 1");
		$res = getrows($sql_config,$err);
		$this->_output['res'] = $res[0];
		$this->_output['f_type']=array("text" => "Text","radio" => "Radio","checkbox" => "Checkbox","dropdown" => "Drop Down");
		$this->_output['tpl']='setting/dev_add';
	}
#####################################################################################################
### Function Name : _update_config  						                  ###
### Description   : Function to update config                                                     ###
### Input         : No input 							                  ###
### Ouput	  : Redirect to _write_config() function		                          ###
#####################################################################################################
	function _update_config(){
		check_session();
		global $link;
		$sectype=$this->_input['sectype'];
		foreach($this->_input[$sectype] as $key=>$value){
			if($_SESSION['id_developer']) {
				if(is_array($this->_input[$sectype][$key][$key])) {
					$this->_input[$sectype][$key][$key] = implode(",",$this->_input[$sectype][$key][$key]);
				}		
				$usql ="UPDATE ".TABLE_PREFIX."config SET value='".$this->_input[$sectype][$key][$key]."',comment='".$this->_input[$sectype][$key]['comment']."' WHERE id_config=".$key;
			}else {
				if(is_array($value)) {
					$value=implode(",",$value);
				}
				$usql ="UPDATE ".TABLE_PREFIX."config SET value='".$value."' WHERE id_config=".$key;
			
			}
			$link->query($usql);
			$_SESSION['raise_message']['global']=getmessage('COM_UPD_SUCC');
		}
		$this->write_config('ajax');
		ob_clean();
		$this->_listing();
	}
#####################################################################################################
### Function Name : _delete_config     		         			                  ###
### Description   : Function to update config                                                     ###
### Input         : No input 							                  ###
### Ouput	  : Redirect to _language() function		       		                  ###
#####################################################################################################
	function _delete_config(){
		check_session();
		global $link;
		ob_clean();
		$keys=stripslashes($this->_input['keys']);
		$keys=trim($keys,',');
		$dsql="DELETE FROM ".TABLE_PREFIX."config WHERE id_config IN(".$keys.")";
		$link->query($dsql);
		$_SESSION['raise_message']['global']=getmessage('COM_DEL_SUCC');
		$this->write_config('ajax');
		exit;
	}
#####################################################################################################
### Function Name : _set_config  						                  ###
### Description   : Function to Insert config                                                     ###
### Input         : No input 							                  ###
### Ouput	  : Redirect to _write_config() function		                          ###
#####################################################################################################
	function _set_config(){
		ob_clean(); 
		global $link;
		$cond=" ckey='".$this->_input['sec']['ckey']."' LIMIT 1";
		$csql=get_search_sql('config',$cond);
		$cres=getsingleindexrow($csql);
		if($cres['name']==$this->_input['sec']['name']){
			print "no";exit;
		}else{
			$this->_input['sec']['name']=str_replace(" ", "_", trim($this->_input['sec']['name']));
			$this->_input['sec']['name']=strtoupper($this->_input['sec']['name']);
			$this->obj_setting->insert($this->_input['sec']);
			$_SESSION['raise_message']['global']=getmessage('COM_INS_SUCC');
			$this->write_config('ajax');
			exit;
		}
	}
####################################################################################################
### Function Name : _edit_config               		                      	     		 ###
### Description   : Function to show editable config options                                     ###
### Input         : No input 						      	                 ###
### Ouput	  : Redirect to _write_config() function                                         ###
####################################################################################################
	function _edit_config(){
		ob_clean(); 
		global $link;
		$cond=" ckey='".$this->_input['sec']['ckey']."' AND id_config != '".$this->_input['id_config']."' LIMIT 1";
		$csql=get_search_sql('config',$cond);
		$cres=getsingleindexrow($csql);
		if($cres['name']==$this->_input['sec']['name']){
			print "no";exit;
		}else{
			$this->_input['sec']['name']=strtoupper($this->_input['sec']['name']);
			$this->obj_setting->edit_config($this->_input['sec'],$this->_input['id_config']);
			$this->write_config('ajax');
		}
	}
####################################################################################################
### Function Name : write_config               		                      	     		 ###
### Description   : Function to fetch one by one record and write                                ###
### Input         : No input 						      	                 ###
### Ouput	  : Redirect to listing function                                                 ###
####################################################################################################
	function write_config($p=''){
		global $link;
		$sql = "SELECT * FROM ".TABLE_PREFIX."config ORDER BY name,id_config";
		$sth = execute($sql,$err);
		if ($sth) {
			do {
				if ($result = $link->store_result()) {
					while($res1 = $result->fetch_assoc()){
						$sampleData[$res1['name']][$res1['ckey']]=$res1['value'];
					}
					$result->close();
				}
			} while ($link->next_result());
			
			$f=$this->write_ini_file($sampleData, APP_ROOT.'flexycms/configs/'.SITE_USED.'/config.ini.php');
			if($p){
				print LBL_SITE_URL."index.php/page-setting-choice-listing";
			}else{
				redirect(LBL_SITE_URL."index.php/page-setting-choice-listing");
			}
			
		} else {
			printf("<br />First Error: %s\n", $link->error);
			exit;
		}
	}
####################################################################################################
### Function Name : write_ini_file           		                      	     		 ###
### Description   : write on config.ini.php file                                                 ###
### Input         : No input 						      	                 ###
### Ouput	  : No output                                                                    ###
####################################################################################################
	function write_ini_file($assoc_arr, $path, $has_sections=TRUE) {
		$content = ""; 
		if ($has_sections) { 
			foreach ($assoc_arr as $key=>$elem) { 
				if($content)
				$content .= "\n";
				$content .= "[".$key."]\n"; 
				foreach ($elem as $key2=>$elem2) { 
					if(is_array($elem2)) { 
						for($i=0;$i<count($elem2);$i++) { 
							$content .= $key2."[] = \"".$elem2[$i]."\"\n"; 
						} 
					} 
					else if($elem2=="") $content .= $key2." = \n"; 
					else $content .= $key2." = \"".$elem2."\"\n"; 
				} 
			} 
		}else { 
			foreach ($assoc_arr as $key=>$elem) { 
				if(is_array($elem)) { 
					for($i=0;$i<count($elem);$i++) { 
						$content .= $key2."[] = \"".$elem[$i]."\"\n"; 
					} 
				} 
				else if($elem=="") $content .= $key2." = \n"; 
				else $content .= $key2." = \"".$elem."\"\n"; 
			} 
		} 
		if (!$handle = fopen($path, 'w')) { 
			return false; 
		}
		if (!fwrite($handle, $content)) { 
			return false; 
		} 
		fclose($handle); 
		return true; 
	}
####################################################################################################
### Function Name : _reorder            		                      	     		 ###
### Description   : update the ordering of general setting page rows                             ###
### Input         : No input 						      	                 ###
### Ouput	  : No output                                                                    ###
####################################################################################################
	function _reorder() {	
		$ordered = explode(',',$this->_input['tab']);
		$cnt=count($ordered);
		for($i=0;$i<$cnt;$i++){
		       $j = $i+1;
		       $sql = "UPDATE ".TABLE_PREFIX."config SET id_seq = ".$j." WHERE id_config = ".$ordered[$i];
		       execute($sql,$err);
		}
	}
	
###################################################################################################
### Function Name : _modulelist            		                      	     		 ###
### Description   : get the module list from modules                             ###
### Input         : No input 						      	                 ###
### Ouput	  : Fetched modules list data                                                        ###
####################################################################################################
	function _modulelist($x=1) {
	    if($_SESSION['id_company']){
     	$sql_property="select * from ".TABLE_PREFIX."modules";
  		/*$res=getrows($sql_property,$err);
		$this->_output['list']=$res;
		$this->_output['tpl']="setting/modulelist"; */
		 $uri = 'index.php/setting/modulelist';
      	$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Module List";
		$this->_output['field'] = array("module_name"=>array("Module Name", 1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql_property;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "module_name";
		//$result=getrows($sql_property,$err);
		$this->_input['qstart']=$this->_input['qstart'];
		if(isset($this->_input['qstart']) || $x){
			$this->_input['choice']='modulelist';
			$this->setting_bl->page_listing($this,"setting/modulelist");
        }
        }
	}

###################################################################################################
### Function Name : _Addmodules           		                      	     		 ###
### Description   : add modules name page                             ###
### Input         : No input 						      	                 ###
### Ouput	  : insert the modules data                                                       ###
####################################################################################################
		function _addmodules(){
		if($_SESSION['id_company']){
 			$this->_output['tpl']="setting/addmodules";
		}else{
			redirect(LBL_SITE_URL);
		}
	}

###################################################################################################
### Function Name : _Addmodules           		                      	     		 ###
### Description   : add modules name page                             ###
### Input         : No input 						      	                 ###
### Ouput	  : insert the modules data                                                       ###
####################################################################################################
		function _editmodules($id=""){

		if($_SESSION['id_company']){
			$arr['id']=$this->_input['id'];
			$sql_property="select * from ".TABLE_PREFIX."modules where id_modules=".$arr['id'];
		//$res=getindexrows('CALL get_search_sql("'.TABLE_PREFIX.'companyleavescheme","'."	id_leave_type=".$_SESSION['id_company'].'")',"leave_schemename","id_leave_type",$err);
		  $res=getsingleindexrow($sql_property,$err);
			$this->_output['module_edit']=$res;
   //print_r($this->_output['leave_scheme']);
			$this->_output['tpl']="setting/addmodules";
		}else{
			redirect(LBL_SITE_URL);
		}
	}
	
#####################################################################################################
# Function Name : _insertmodules                                                                #
# Description   : Insert modules under an setting					                    #
#		                      	                                                            #       #
# Input         : id_modules                                                                      #
# Output	    : call to insertmodules function				                    #               #
#####################################################################################################
	function _insertmodules(){
 		$arr['module_name']=$this->_input['modules']['module_name'];
   		$arr['module_value']=$this->_input['modules']['module_value'];
 		$arr['isactive']=$this->_input['modules']['isactive'];
 		$arr['create_date']= date("Y-m-d H:i:s");
     	$this->obj_setting->insertmodules($arr,"modules");
        $msg=getmessage('COM_INS_SUCC');
	    print "<script>callmsg('".$msg."');</script>";
	    $this->_modulelist($_SESSION['id_company']);

	}
	
	#####################################################################################################
# Function Name : _insertmodules                                                                #
# Description   : Insert modules under an setting					                    #
#		                      	                                                            #       #
# Input         : id_modules                                                                      #
# Output	    : call to insertmodules function				                    #               #
#####################################################################################################
 	function _updatemodules()
       {
    $arr['module_name']=$this->_input['modules']['module_name'];
   		$arr['module_value']=$this->_input['modules']['module_value'];
 		$arr['isactive']=$this->_input['modules']['isactive'];
 		$arr['create_date']= date("Y-m-d H:i:s");
        $RES=$this->obj_setting->update1("modules",$arr,"id_modules=".$this->_input['modules']['temp_id']);
        $msg=getmessage('COM_UPD_SUCC');
		print "<script>callmsg('".$msg."');</script>";
	    $this->_modulelist($_SESSION['id_company']);
        }
        
#######################################################################################################
# Function Name : _deleteleavescheme                                                                  #
# Description   : delete leave scheme under an adminstration 					                      #
#		                      	                                                                      #
# Input         : id_employee                                                                         #
# Output	    : call to delete leavescheme function				                                  #
#######################################################################################################
	function _deletemodules(){
		if($_SESSION['id_company']){
           	$this->obj_setting->delete($this->_input['id_modules'],"id_modules","","modules");
  			ob_clean();
			$msg=getmessage('COM_DEL_SUCC');
			print "<script>callmsg('".$msg."');</script>";
			$this->_modulelist($_SESSION['id_company']);
		}
	}
	
#######################################################################################################
# Function Name : _modulefeatureslist                                                                  #
# Description   : fetch each modules features list 					                      #
#		                      	                                                                      #
# Input         : id_modules                                                                         #
# Output	    : call to modulefeatures function				                                  #
#######################################################################################################

    	function _modulefeatures() {
	    if($_SESSION['id_company']){
	    //echo $this->_input['id_modulefeatures'];
	   //Get Modules Detail

	    $sql_property="select * from ".TABLE_PREFIX."modules where id_modules=".$this->_input['id']."";
      		$result=getsingleindexrow($sql_property,$err);
  		$this->_output['module']=$result;

        $sql_property="select * from ".TABLE_PREFIX."modulefeatures where id_modules=".$this->_input['id']."" ;
  		$res=getrows($sql_property,$err);
		$this->_output['list']=$res;
		$this->_output['tpl']="setting/modulefeatureslist";
		// $this->_modulefeatures($_SESSION['id_company']);
        }

    	}

#######################################################################################################
# Function Name : _addfeatures                                                                 #
# Description   : add features tpl  					                      #
#		                      	                                                                      #
# Input         : id_modules                                                                         #
# Output	    : call to addfeatures function				                                  #
#######################################################################################################
    	
    	function _addfeatures(){
		if($_SESSION['id_company']){
	//	$this->_input['id_modules'];
		$sql_property="select * from ".TABLE_PREFIX."modules where id_modules=".$this->_input['id_modules']."" ;
  		$res=getsingleindexrow($sql_property,$err);
  		//print_r($res);
  		$this->_output['modules']=$res;
 		$this->_output['tpl']="setting/addfeatures";
		}else{
			redirect(LBL_SITE_URL);
		}
	}

#######################################################################################################
# Function Name : _editfeatures                                                                 #
# Description   : edit features tpl  					                      #
#		                      	                                                                      #
# Input         : id_modules                                                                         #
# Output	    : call to editfeatures function				                                  #
#######################################################################################################

	
		function _editfeatures($id="")
        {
		if($_SESSION['id_company']){
         $sql_property="select * from ".TABLE_PREFIX."modulefeatures where id_modulefeatures=".$this->_input['id'];
        $res=getsingleindexrow($sql_property,$err);
       	$this->_output['feature_edit']=$res;
       	   	 $this->_output['tpl']="setting/addfeatures";
   		}else{
			redirect(LBL_SITE_URL);
		}
	}
	
######################################################################################################
# Function Name : _insertfeatures                                                                 #
# Description   : insert features in modulefeatures table  					                      #
#		                      	                                                                      #
# Input         : id_modules,id_modulefeatures                                                                         #
# Output	    : call to insertfeatures function				                                  #
#######################################################################################################
	
		function _insertfeatures(){
 		$arr['features_name']=$this->_input['features']['features_name'];
 		$arr['features_value']=$this->_input['features']['features_values'];
   		$arr['iswriteaccess']=$this->_input['features']['iswriteaccess'];
        $arr['id_modules']=$this->_input['modules']['modules_id'];
        $arr['create_date']= date("Y-m-d H:i:s");
       	$this->obj_setting->insertmodules($arr,"modulefeatures");
        $msg=getmessage('COM_INS_SUCC');
	    print "<script>callmsg('".$msg."');</script>";
	    //$this->_modulelist($_SESSION['id_company']);

	}
######################################################################################################
# Function Name : _updatefeatures                                                                 #
# Description   : update features in modulefeatures table  					                      #
#		                      	                                                                      #
# Input         : id_modules,id_modulefeatures                                                                         #
# Output	    : call to updatefeatures function				                                  #
#######################################################################################################

    function _updatefeatures()
       {
        $arr['features_name']=$this->_input['features']['features_name'];
   		$arr['iswriteaccess']=$this->_input['features']['iswriteaccess'];
   		$arr['features_value']=$this->_input['features']['features_values'];
   		$arr['create_date']= date("Y-m-d H:i:s");
        $res=$this->obj_setting->update1("modulefeatures",$arr,"id_modulefeatures=".$this->_input['features']['temp_id']);
       // print_r($res);
        $msg=getmessage('COM_UPD_SUCC');
		print "<script>callmsg('".$msg."');</script>";
        $this->_modulelist($_SESSION['id_company']);
	    }
	    
######################################################################################################
# Function Name : _deletefeatures                                                                 #
# Description   : delete features in modulefeatures table  					                      #
#		                      	                                                                      #
# Input         : id_modules,id_modulefeatures                                                                         #
# Output	    : call to updatefeatures function				                                  #
#######################################################################################################
        
        function _deletefeatures(){
		if($_SESSION['id_company']){

           	$this->obj_setting->delete($this->_input['id_modulefeatures'],"id_modulefeatures","","modulefeatures");
  			ob_clean();
			$msg=getmessage('COM_DEL_SUCC');
			print "<script>callmsg('".$msg."');</script>";
		     $this->_modulelist($_SESSION['id_company']);

		}
	}
#######################################################################################################
# Function Name : _rolelist                                                                  #
# Description   : fetch each modules features list 					                      #
# Created By	: Thirumaran	                      	                                                                      #
# Input         :                                                                          #
# Output	    : call to rolelist function				                                  #
#######################################################################################################
	function _rolelist($x=1) {
	    if($_SESSION['id_company']){
	    $sql_property="select * from ".TABLE_PREFIX."roles";
      	/*$result=getrows($sql_property,$err);
  		$this->_output['list']=$result;
		$this->_output['tpl']="setting/rolelist";
	    //$this->_rolelist();*/
	    $uri = 'index.php/setting/rolelist';
      	$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Role List";
		$this->_output['field'] = array("role_name"=>array("Role Name", 1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql_property;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "role_name";
		//$result=getrows($sql_property,$err);
		$this->_input['qstart']=$this->_input['qstart'];
		if(isset($this->_input['qstart']) || $x){
			$this->_input['choice']='rolelist';
			$this->setting_bl->page_listing($this,"setting/rolelist");
        }
        }
    	}

 #######################################################################################################
# Function Name : _rolelist                                                                  #
# Description   : fetch each modules features list 					                      #
# Created By	: Thirumaran	                      	                                                                      #
# Input         :                                                                          #
# Output	    : call to rolelist function				                                  #
#######################################################################################################

function _addroles(){
		if($_SESSION['id_company']){
    	$this->_output['tpl']="setting/addroles";
		}else{
			redirect(LBL_SITE_URL);
		}
	}
	
#######################################################################################################
# Function Name : _rolelist                                                                  #
# Description   : fetch each modules features list 					                      #
# Created By	: Thirumaran	                      	                                                                      #
# Input         :                                                                          #
# Output	    : call to rolelist function				                                  #
#######################################################################################################
 	function _editroles($id="")
        {
		if($_SESSION['id_company']){
         $sql_property="select * from ".TABLE_PREFIX."roles where id_roles=".$this->_input['id'];
        $res=getsingleindexrow($sql_property,$err);
       	$this->_output['roles_edit']=$res;
       	   	 $this->_output['tpl']="setting/addroles";
   		}else{
			redirect(LBL_SITE_URL);
		}
	}

######################################################################################################
# Function Name : _insertroles                                                                 #
# Description   : insert roles in roles table  					                      #
#		                      	                                                                      #
# Input         : id_roles                                                                        #
# Output	    : call to insertroles function				                                  #
#######################################################################################################

		function _insertroles(){
 		$arr['role_name']=$this->_input['roles']['role_name'];
   		$arr['role_description']=$this->_input['roles']['role_description'];
   		$arr['create_date']= date("Y-m-d H:i:s");
        $result=$this->obj_setting->insertmodules($arr,"roles");
        $table="rolefeatures";
        $this->obj_setting->altercolumn($table,$result);
        //print_r($result);

        $msg=getmessage('COM_INS_SUCC');
	    print "<script>callmsg('".$msg."');</script>";
     $this->_rolelist($_SESSION['id_company']);

	}
	
######################################################################################################
# Function Name : _updateroles                                                                 #
# Description   : update roles in roles table  					                      #
#		                      	                                                                      #
# Input         : id_roles                                                                        #
# Output	    : call to updateroles function				                                  #
#######################################################################################################

		function _updateroles(){

 		$arr['role_name']=$this->_input['roles']['role_name'];
   		$arr['role_description']=$this->_input['roles']['role_description'];
   		$res=$this->obj_setting->update1("roles",$arr,"id_roles=".$this->_input['roles']['temp_id']);
        $msg=getmessage('COM_UPD_SUCC');
	    print "<script>callmsg('".$msg."');</script>";
        $this->_rolelist($_SESSION['id_company']);

	}

######################################################################################################
# Function Name : _deleteroles                                                                 #
# Description   : delete roles in roles table  					                      #
#		                      	                                                                      #
# Input         : id_roles                                                                        #
# Output	    : call to deleteroles function				                                  #
#######################################################################################################
	
	 function _deleteroles(){
  		if($_SESSION['id_company']){

           	$this->obj_setting->delete($this->_input['id_roles'],"id_roles","","roles");
    			$msg=getmessage('COM_DEL_SUCC');
			print "<script>callmsg('".$msg."');</script>";
		     $this->_rolelist($_SESSION['id_company']);

		}
	}
	
#######################################################################################################
# Function Name : _AssignRolefeatures                                                                  #
# Description   : fetch each role and each module features list 					                      #
#		                      	                                                                      #
# Input         : id_roles                                                                         #
# Output	    : call to asssginrolefeatures function				                                  #
#######################################################################################################
	function _assignrolefeatures() {
	    if($_SESSION['id_company']){
	    //echo $this->_input['id_modulefeatures'];
	   //Get Modules Detail

     $sql_property="select * from ".TABLE_PREFIX."roles where id_roles=".$this->_input['id']."";
      		$result=getsingleindexrow($sql_property,$err);
  		$this->_output['roles']=$result;

        $sql_property="select id_modules,module_name from ".TABLE_PREFIX."modules" ;
  		$res=getrows($sql_property,$err);
  		//print_r($res);
		$this->_output['assignroles']=$res;
		$this->_output['tpl']="setting/assignrolefeatures";
		// $this->_modulefeatures($_SESSION['id_company']);
        }

    	}
    	
    	
    	function _getmodulefeatures() {
	    if($_SESSION['id_company']){
	    if($this->_input['id']!='')
	    {
	    //$sql_property="select id_modules,module_name from ".TABLE_PREFIX."modules where id_modules=".$this->_input['id']." ";
	    $sql_property="select a.id_modules,a.module_name,b.id_modulefeatures,b.features_name,c.isvisible_".$this->_input['id_roles']." as isvisible,c.id_".$this->_input['id_roles']." as id_roles from ".TABLE_PREFIX."modules a,".TABLE_PREFIX."modulefeatures b,".TABLE_PREFIX."rolefeatures c where a.id_modules=".$this->_input['id']."  and a.id_modules=b.id_modules and c.id_modulefeatures=b.id_modulefeatures and c.id_".$this->_input['id_roles']."=".$this->_input['id_roles']."";
	    //echo $sql_property;
  		$res=getrows($sql_property,$err);
  		//print_r($res);
    	$this->_output['assignfeatures']=$res;
  			$this->_output['rolesfeatures'] =$this->_input['id_roles'];
    		$this->_output['tpl']="setting/getmodulefeatures";
		// $this->_modulefeatures($_SESSION['id_company']);
		}
        }

    	}
    	
    	function _insertassignrolefeatures(){
        $arr['id_'.$this->_input['id_roles']]=$this->_input['id_roles'];
        $arr['id_modulefeatures']=$this->_input['id_modulefeatures'];
   		$arr['isvisible_'.$this->_input['id_roles']]=$this->_input['isvisible'];
   		$arr['id_modules']=$this->_input['id_modules'];
   		$arr1['isvisible_'.$this->_input['id_roles']]=$this->_input['isvisible'];
   		//$modules= '"id_modules="'.$this->_input['id_modules'];

   		$result=$this->obj_setting->update1("rolefeatures",$arr1,"id_modules=".$this->_input['id_modules'] .' and '.  "id_".$this->_input['id_roles']."=".$this->_input['id_roles'] .' and '. "id_modulefeatures=".$this->_input['id_modulefeatures']);
      	//$sql_property="select * from ".TABLE_PREFIX."rolefeatures where id_modules=".$this->_input['id_modules']." and id_modulefeatures=".$this->_input['id_modulefeatures']." and id_roles=".$this->_input['id_roles']."";
        print_r($result);
        //$this->_output['tpl']="setting/adduser";
        $this->_getmodulefeatures($_SESSION['id_company']);

	}
	
	
		function _userlist($x=1) {
        if($_SESSION['id_company']){
	    $sql_property="select id_userdetails,email_id,displayname,isactive,add_date from ".TABLE_PREFIX."company";
      	//$result=getrows($sql_property,$err);
      	$uri = 'index.php/setting/userlist';
      	$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Users List";
		$this->_output['field'] = array("email_id"=>array("User Name", 1),"displayname"=>array("Display Name", 1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql_property;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "email_id";
		$result=getrows($sql_property,$err);
		$this->_input['qstart']=$this->_input['qstart'];
		if(isset($this->_input['qstart']) || $x){
			$this->_input['choice']='userslist';
			$this->setting_bl->page_listing($this,"setting/userlist");
		}

        }
         }

        
        
        function _addusers() {
     	if($_SESSION['id_company']){
     	$sql_property="select * from ".TABLE_PREFIX."roles" ;
  		$res=getrows($sql_property,$err);
  		//print_r($res);
		$this->_output['roles']=$res;
    	$this->_output['tpl']="setting/addusers";
		}else{
			redirect(LBL_SITE_URL);
		  }
        }

        function _insertusers()
        {
          if($_SESSION['id_company'])
          {
        $arr['displayname']=$this->_input['users']['display_name'];
        $arr['email_id']=$this->_input['users']['user_name'];
        $arr['password']=MD5($this->_input['users']['user_pwd']);
   		$arr['role']=$this->_input['users']['user_role'];
   		$arr['isactive']=$this->_input['users']['isactive'];
   		$arr['add_date']= date("Y-m-d H:i:s");
        $this->obj_setting->insertmodules($arr,"company");
        $msg=getmessage('COM_INS_SUCC');
	    print "<script>callmsg('".$msg."');</script>";
       $this->_userlist($_SESSION['id_company']);
        }
	  }
	
	
	function _editusers($id="")
        {
		if($_SESSION['id_company']){
         $sql_property="select * from ".TABLE_PREFIX."company where id_userdetails=".$this->_input['id'];
        $res=getsingleindexrow($sql_property,$err);
       	$this->_output['users_edit']=$res;
       	$sql_property="select * from ".TABLE_PREFIX."roles" ;
  		$res=getrows($sql_property,$err);
  		//print_r($res);
		$this->_output['roles']=$res;
       	$this->_output['tpl']="setting/addusers";
   		}else{
			redirect(LBL_SITE_URL);
		}
	}
	
	
	function _updateusers(){
    if($_SESSION['id_company']){
        $arr['displayname']=$this->_input['users']['display_name'];
        $arr['email_id']=$this->_input['users']['user_name'];
   		$arr['password']=MD5($this->_input['users']['user_pwd']);
   		$arr['role']=$this->_input['users']['user_role'];
     	$arr['isactive']=$this->_input['users']['isactive'];
   		$res=$this->obj_setting->update1("company",$arr,"id_userdetails=".$this->_input['users']['temp_id']);
        $msg=getmessage('COM_UPD_SUCC');
	    print "<script>callmsg('".$msg."');</script>";
       $this->_userlist($_SESSION['id_company']);
       }

	}
	
	 function _deleteusers(){
  		if($_SESSION['id_company']){
           	$this->obj_setting->delete($this->_input['id_users'],"id_userdetails","","company");
    		$msg=getmessage('COM_DEL_SUCC');
			print "<script>callmsg('".$msg."');</script>";
		     $this->_userlist($_SESSION['id_company']);
         		}
	}
	
	function _menu() {
    if($_SESSION['id_userdetails']){
    $myFile=TEMPLATE_DIR."default/common/menu.tpl.html";
    $fh = fopen($myFile, 'w') or die("can't open file");
    $stringData = "<div style=\"margin-top:27px;\">
    <ul class=\"menu\" id=\"menu\">";
    fwrite($fh,$stringData);
    $sql_property="select id_modules,module_name,module_value,b.role from ".TABLE_PREFIX."modules a,".TABLE_PREFIX."company b,".TABLE_PREFIX."roles c where b.id_company=".$_SESSION['id_company']." and b.role=c.id_roles and id_userdetails=".$_SESSION['id_userdetails']." and a.isactive=1 order by orderby asc";
    //echo $sql_property;
   	$result=getrows($sql_property,$err);
    foreach($result as $resultset)
     {
     $stringData1="
    <li class=\"openul\">
                    <div class=\"fltlft lft_prt\"></div>
                    <div class=\"fltlft mdl_prt\"><a class=\"menulink\" href=\"javascript:void(0);\">";
     fwrite($fh,$stringData1);
     $stringData2=$resultset['module_name']."</a></div>
                    <div class=\"fltlft rht_prt\"></div>";
     fwrite($fh,$stringData2);
                    $res1 = "select features_name,features_value from ".TABLE_PREFIX."modulefeatures a,".TABLE_PREFIX."rolefeatures b  where a.id_modules=".$resultset['id_modules']." and a.id_modulefeatures=b.id_modulefeatures and b.id_".$resultset['role']."=".$resultset['role']." and b.isvisible_".$resultset['role']."=1 group by features_name";
     // echo $res1;
         $result1=getrows($res1,$err);
         $stringData2="<ul>";
//print_r($result1);
         fwrite($fh,$stringData2);
         foreach($result1 as $resultset1)
         {
          $stringData3="<li><a href=\"##LBL_SITE_URL##index.php/".$resultset['module_value']."/".$resultset1['features_value']."\">";
                        //fwrite($fh,$stringData3);
                        $stringData4=$stringData3.$resultset1['features_name']."</a></li>";
           fwrite($fh,$stringData4);
          }

           $stringData5="</ul>
           </li>";
         fwrite($fh,$stringData5);
       }
     $stringData6="</ul>
     <div class=\"clrbth\"></div>
    </div>
   <div class=\"clrbth\"></div>
  {literal}
  <script type=\"text/javascript\">
   $(document).ready(function(){
	$('ul#menu li.openul').hover(function(){
		//$(this).find('ul').show();
		jQuery(this).find('> ul').stop(true, true).slideDown(300).css('width','150px');

	},function(){
		$(this).find('ul').slideUp(300);
	});
  });
   </script>
  {/literal}
  ";
  fwrite($fh,$stringData6);
  fclose($fh);
  $this->_output['tpl']="common/menu";
  }
  else
     { $this->_output['tpl']="common/menuemployee";
     }
  }
    

 ##################################################################################
### Function Name : companyInfo                                                ###
### Description   : This function show the company information listing or edit ###
### Input         : no input for listing and edit flag for edit information    ###
### Output         : Show company information listing or edit template         ###
##################################################################################
	function _companyInfo(){
		global $link;
		$sql_cinfo = 'CALL get_search_sql("'.TABLE_PREFIX.'company","id_company='.$_SESSION['id_company'].' LIMIT 1")';
		$this->_output['res'] = getsingleindexrow($sql_cinfo);

		$company_sql = $this->setting_bl->generalConf();
		$company_res = getsingleindexrow($company_sql);

		$this->_output['company_res'] = $company_res;

		if($this->_input['edit']){

			$timezone_sql ='CALL get_search_sql("'.TABLE_PREFIX.'timezone","")';
			$timezone_res = getindexrows($timezone_sql,"timezone_value","timezone_text");

			$this->_output['timezone']    = $timezone_res;
			$this->_output['currency']    = $GLOBALS['conf']['CURRENCY'];

			$this->_output['tpl'] = 'setting/editCompanyInfo';
		}else{
			$sql_cnt_emp="SELECT COUNT(*) AS cnt FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee WHERE IF(terminate_date!='',terminate_date > NOW(),1) AND id_company=".$_SESSION['id_company'];
			$res_cnt_emp = getsingleindexrow($sql_cnt_emp);

			$this->_output['res']['cnt'] = $res_cnt_emp['cnt'];
			$this->_output['tpl'] = 'setting/companyInfo';
		}
	}

###############################################################################
### Function Name : previewImage                                            ###
### Description   : Function to show preview image during edit company info ###
### Input         : Files array                                             ###
### Output         : Name of the image                                      ###
###############################################################################
	function _previewImage(){
		if ($_FILES['image']['name']){
			$time= strtotime("now");
			$rid= $time."_";
			$uploadDir= APP_ROOT.$GLOBALS['conf']['IMAGE']['preview_orig'];
			$thumbnailDir= APP_ROOT.$GLOBALS['conf']['IMAGE']['preview_thumb'];
			$thumb_height= $GLOBALS['conf']['IMAGE']['thumb_height'];
			$thumb_width= $GLOBALS['conf']['IMAGE']['thumb_width'];
			$fname = $rid.convert_me($_FILES['image']['name']);

			$file_tmp = $_FILES['image']['tmp_name'];
			$status	= copy($file_tmp, $uploadDir.$fname);
			$copy_thumb= copy($uploadDir.$fname, $thumbnailDir.$fname);
			$this->r = new thumbnail_manager($uploadDir.$fname,$thumbnailDir.$fname);
			$this->r->get_container_thumb($thumb_height,$thumb_width,0,0);
			print $fname;
		}
	}

##############################################################################################
### Function Name : editCompanyInfo                                      		   ###
### Description   : Function to edit company information  				   ###
### Input         : Form data as array                                                     ###
### Output        : Updated company information to table and redirect to company info page ###
##############################################################################################
	function _editCompanyInfo(){
		if($this->_input['previewimg']){
			$uploadDir = APP_ROOT.$GLOBALS['conf']['IMAGE']['companylogo_orig'];
			$thumbnailDir= APP_ROOT.$GLOBALS['conf']['IMAGE']['companylogo_image_thumb'];
			$thumb_height= $GLOBALS['conf']['IMAGE']['thumb_height'];
			$thumb_width= $GLOBALS['conf']['IMAGE']['thumb_width'];

			$img= trim(strstr($this->_input['previewimg'],'_'),'_');
			$fname= $_SESSION['id_company']."_".$img;
			$this->_input['company']['logo'] = $img;
			$_SESSION['logo'] = $_SESSION['id_company']."_".$img;

			$sourcefile= APP_ROOT.$GLOBALS['conf']['IMAGE']['preview_orig'].$this->_input['previewimg'];
			$status	= @copy($sourcefile, $uploadDir.$fname);
			$copy_thumb= @copy($uploadDir.$fname, $thumbnailDir.$fname);
			$this->r= new thumbnail_manager($uploadDir.$fname,$thumbnailDir.$fname);
			$this->r->get_container_thumb($thumb_height,$thumb_width,0,0);
			@unlink($uploadDir.$_SESSION['id_company']."_".$this->_input['hidimg']);
		}
		$r = $this->obj_setting->editCompany("company",$this->_input['company']);
		if($r){
			$_SESSION['company_name'] = $this->_input['company']['company_name'];
			$_SESSION['raise_message']['global'] = getmessage('COM_UPD_SUCC');
		}
		redirect(LBL_SITE_URL."index.php/setting/companyInfo");
	}

######################################################################################
### Function Name : addEditDivision                                                ###
### Description   : This function open addEditDivision modal form                  ###
### Input         : no input                                                       ###
### Ouput         : company addEditDivision template                               ###
######################################################################################
	function _addEditDivision(){
		$ch=$this->_input['ch'];
		$id=$this->_input['id'];
		if($ch=='edit'){
			$cond="id_division=".$id." AND id_company=".$_SESSION['id_company'];
			$sql='CALL get_search_sql("'.TABLE_PREFIX.'companyDivision","'.$cond.'")';
			$this->_output['res_division']=getsingleindexrow($sql);
		}
		$this->_output['start']=$this->_input['start'];
		$this->_output['tpl']='setting/addEditDivision';
	}
######################################################################################
### Function Name : divisions                                                      ###
### Description   : This function show the company divisions information           ###
### Input         : one status variable is taken for redirecting to                ###
###					divisionslisting or divisions              ###
### Ouput         : company divisions  or  divisionslisting template               ###
######################################################################################
	function _divisions($x=0){
		$sql="SELECT id_division, div_name,notes FROM ".TABLE_PREFIX."companyDivision";
		$uri ='index.php/setting/divisions';
		$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Divisions List";
		$this->_output['field'] = array("div_name"=>array("Division Name", 1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "id_division";
		$this->_input['qstart']=$this->_input['qstart'];
		$this->_output['res1']=$this->commonEmpCount('id_division','companyDivision','division');
		if(isset($this->_input['qstart']) || $x){
			$this->_input['choice']='divisions';
			$this->setting_bl->page_listing($this,"setting/divisionlisting");
		}else{
			$this->setting_bl->page_listing($this,"setting/division");
		}
	}
######################################################################################
### Function Name : commonEmpCount                                                 ###
### Description   : This function returns the nunber of employee associated with   ###
###                a particular division or department or team or jobtitle likewise###
### Input         : id table ,tableneme,groupby id                                 ###
### Ouput         : returns the result result in an array format                   ###
######################################################################################
	function commonEmpCount($id,$tbl,$group_by){
		$sql_cnt_emp="SELECT D.".$id.",COUNT(*) AS cnt,emp_status,id_employee,joined_date FROM (SELECT E.*,ETC.terminate_date FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee) AS TE , ".TABLE_PREFIX.$tbl." D WHERE TE.".$group_by."=D.".$id." AND IF(terminate_date!='',terminate_date > NOW(),1) AND TE.id_company=".$_SESSION['id_company']." GROUP BY TE.".$group_by;
		//print $sql_cnt_emp;
		return getindexrows($sql_cnt_emp,$id,'cnt');
	}
######################################################################################
### Function Name : insertdivision                                                 ###
### Description   : This function insert the company division data in database     ###
### Input         : form data                                                      ###
### Ouput         : redirect to the divisions function                             ###
######################################################################################
	function _insertdivision(){
	  // echo "test";
     //  exit;
		$arr['div_name']=$this->_input['division']['div_name'];
		$arr['id_company']=$_SESSION['id_company'];
		if($this->_input['division']['notes']){
			$arr['notes']=$this->_input['division']['notes'];
		}
	//	print_r($arr);
		$r=$this->obj_setting->insertcompany("companyDivision",$arr);
		if($r){
			print "<script>callmsg('".getmessage('COM_INS_SUCC')."');</script>";
			$this->_divisions(1);
		}
	}
######################################################################################
### Function Name : updatedivision                                                 ###
### Description   : This function update the company division data in database     ###
### Input         : form data                                                      ###
### Ouput         : redirect to the divisions function                             ###
######################################################################################
	function _updatedivision(){
		$condition=" id_division = ".$this->_input['id_division'] ;
		$r=$this->obj_setting->update_company("companyDivision",$this->_input['division'],$condition);
		print "<script>callmsg('".getmessage('COM_UPD_SUCC')."');</script>";
		$this->_divisions(2);
	}
######################################################################################
### Function Name : remove_division                                                ###
### Description   : This function delete one company division record in database   ###
### Input         : form data                                                      ###
### Ouput         : redirect to the divisions function                             ###
######################################################################################
	function _remove_division(){
		$cond=" id_division = '".$this->_input['id_division']."'";
		$r=$this->obj_setting->delete_dept("companyDivision",$cond);
		if($r){
			if(($this->_input['cnt']==1) && ($this->_input['qstart'])){
                               $this->_input['qstart']=$this->_input['qstart']-$GLOBALS['conf']['PAGINATE']['rec_per_page'];
                        }
                        print "<script>callmsg('".getmessage('COM_DEL_SUCC')."');</script>";
			$this->_divisions(2);
		}
	}
######################################################################################
### Function Name : addEditDepartment                                              ###
### Description   : This function open addEditDepartment modal form                ###
### Input         : no input                                                       ###
### Ouput         : company addEditDepartment template                             ###
######################################################################################
	function _addEditDepartment(){
		$ch=$this->_input['ch'];
		$id=$this->_input['id'];
		$this->_output['division']=$this->_getResult('companyDivision','id_division','div_name');
		if($ch=='edit'){
			$cond="id_department=".$id;
			$sql='CALL get_search_sql("'.TABLE_PREFIX.'companyDepartment","'.$cond.'")';
			$this->_output['res_department']=getsingleindexrow($sql);
		}
		$this->_output['tpl']='setting/addEditDepartment';
	}
######################################################################################
### Function Name : departments                                                    ###
### Description   : This function show the company departments information         ###
### Input         : one status variable is taken for redirecting to                ###
###					departmentslisting or departments          ###
### Ouput         : company departments  or  departmentslisting template           ###
######################################################################################
	function _departments($x=0){
		$sql="SELECT dt.id_department,dv.id_division,dv.div_name, dt.dept_name,dt.notes
FROM ".TABLE_PREFIX."companyDepartment dt, ".TABLE_PREFIX."companyDivision dv
WHERE dt.id_division = dv.id_division";
		$uri ='index.php/setting/departments';
		$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Department List";
		$this->_output['field'] = array("div_name"=>array("Division Name",1),"dept_name"=>array("Department Name", 1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "dt.id_department";
		$this->_input['qstart']=$this->_input['qstart'];
		$this->_output['res1']=$this->commonEmpCount('id_department','companyDepartment','department');
		if(isset($this->_input['qstart']) || $x){
			$this->_input['choice']='departments';
			$this->setting_bl->page_listing($this,"setting/departmentlisting");
		}else{
			$this->setting_bl->page_listing($this,"setting/department");
		}
	}
######################################################################################
### Function Name : insertdepartment                                               ###
### Description   : This function insert the company department data in database   ###
### Input         : form data                                                      ###
### Ouput         : redirect to the departments function                           ###
######################################################################################
	function _insertdepartment(){
		$arr['dept_name']=$this->_input['department']['dept_name'];
		$arr['id_division']=$this->_input['department']['id_division'];
		if($this->_input['department']['notes']){
			$arr['notes']=$this->_input['department']['notes'];
		}
		$r=$this->obj_setting->insertcompany("companyDepartment",$arr);
  		if($r){
			print "<script>callmsg('".getmessage('COM_INS_SUCC')."');</script>";
			$this->_departments(1);
		}
	}
######################################################################################
### Function Name : updatedepartment                                               ###
### Description   : This function update the company department data in database   ###
### Input         : form data                                                      ###
### Ouput         : redirect to the departments function                           ###
######################################################################################
	function _updatedepartment(){
		$condition="id_department = ".$this->_input['id_department'] ;
		$r=$this->obj_setting->update_company("companyDepartment",$this->_input['department'],$condition);
		print "<script>callmsg('".getmessage('COM_UPD_SUCC')."');</script>";
		$this->_departments(2);
	}
######################################################################################
### Function Name : remove_department                                              ###
### Description   : This function delete one company department record in database ###
### Input         : form data                                                      ###
### Ouput         : redirect to the departments function                           ###
######################################################################################
	function _remove_department(){
		$cond=" id_department = '".$this->_input['id_department']."'";
		$r=$this->obj_setting->delete_dept("companyDepartment",$cond);
		if($r){
				if(($this->_input['cnt']==1) && ($this->_input['qstart'])){
		                       $this->_input['qstart']=$this->_input['qstart']-$GLOBALS['conf']['PAGINATE']['rec_per_page'];
		                }
		                print "<script>callmsg('".getmessage('COM_DEL_SUCC')."');</script>";
				$this->_departments(2);
		}
	}
######################################################################################
### Function Name : addEditTeam                                                    ###
### Description   : This function open adddivision modal form                      ###
### Input         : no input                                                       ###
### Ouput         : company addEditTeam template                                   ###
######################################################################################
	function _addEditTeam(){
		$ch=$this->_input['ch'];
		$id=$this->_input['id'];
		$this->_output['div']=$this->_getResult('companyDivision','id_division','div_name');
		if($ch=='edit'){
			$cond="t.id_team=".$id;
			$sql="SELECT dt.id_department,dv.id_division,t.id_team,dv.div_name,dt.dept_name,t.team_name,t.notes
FROM ".TABLE_PREFIX."companyTeam t, ".TABLE_PREFIX."companyDepartment dt,".TABLE_PREFIX."companyDivision dv WHERE t.id_department=dt.id_department AND dt.id_division = dv.id_division AND ".$cond;
			$res_team=getsingleindexrow($sql);
			$this->_output['res_team']=$res_team;
			$this->_output['dept']=$this->_getResult('companyDepartment','id_department','dept_name',"id_department=".$res_team['id_department']);
		}
		$this->_output['tpl']='setting/addEditTeam';
	}
######################################################################################
### Function Name : team                                                   	   ###
### Description   : This function show the company teams information               ###
### Input         : $x is taken for the redirection purpose.initially take default ###
###			value then it take value provided.                         ###
### Ouput         : company departments  or  departmentslisting template           ###
######################################################################################
	function _team($x=0){
		$sql="SELECT dt.id_department,dv.id_division,t.id_team,dv.div_name,dt.dept_name,t.team_name,t.notes
FROM ".TABLE_PREFIX."companyTeam t, ".TABLE_PREFIX."companyDepartment dt,".TABLE_PREFIX."companyDivision dv WHERE t.id_department=dt.id_department AND dt.id_division = dv.id_division";

		$uri = 'index.php/setting/team';
		$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Team List";
		$this->_output['field'] = array("div_name"=>array("Division Name",1),"dept_name"=>array("Department Name", 1),"team_name"=>array("Team Name",1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "id_team";

		$this->_output['res1']=$this->commonEmpCount('id_team','companyTeam','team');
		if(isset($this->_input['qstart']) || $x){
			$this->_input['choice']='team';
			$this->setting_bl->page_listing($this,"setting/teamlisting");
		}else{
			$this->setting_bl->page_listing($this,"setting/team");
		}
	}
######################################################################################
### Function Name : insertteam                                                     ###
### Description   : This function insert the company team data in database         ###
### Input         : form data                                                      ###
### Ouput         : redirect to the team function                                  ###
######################################################################################
	function _insertteam(){
		$arr['team_name']=$this->_input['team']['team_name'];
		$arr['id_department']=$this->_input['team']['id_department'];
		if($this->_input['team']['notes']){
			$arr['notes']=$this->_input['team']['notes'];
		}
		$r=$this->obj_setting->insertcompany("companyTeam",$arr);
		if($r){
			print "<script>callmsg('".getmessage('COM_INS_SUCC')."');</script>";
			$this->_team(1);
		}
	}
######################################################################################
### Function Name : updateteam                                                     ###
### Description   : This function update the company team data in database         ###
### Input         : form data                                                      ###
### Ouput         : redirect to the team function                                  ###
######################################################################################
	function _updateteam(){
		$condition="id_team = ".$this->_input['id_team'] ;
		$arr['id_department']=$this->_input['team']['id_department'];
		$arr['team_name']=$this->_input['team']['team_name'];
		if($this->_input['team']['notes']){
			$arr['notes']=$this->_input['team']['notes'];
		}
		$r=$this->obj_setting->update_company("companyTeam",$arr,$condition);
		print "<script>callmsg('".getmessage('COM_UPD_SUCC')."');</script>";
		$this->_team(2);
	}
######################################################################################
### Function Name : removeteam                                                     ###
### Description   : This function delete one company team record in database       ###
### Input         : form data                                                      ###
### Ouput         : redirect to the team function                                  ###
######################################################################################
	function _removeteam(){
		$cond=" id_team = '".$this->_input['id_team']."'";
		$r=$this->obj_setting->delete_dept("companyTeam",$cond);
		if($r){
			if(($this->_input['cnt']==1) && ($this->_input['qstart'])){
	               			$this->_input['qstart']=$this->_input['qstart']-$GLOBALS['conf']['PAGINATE']['rec_per_page'];
			}
		       print "<script>callmsg('".getmessage('COM_DEL_SUCC')."');</script>";
			$this->_team(3);
		}
	}
######################################################################################
### Function Name : getResult                                                      ###
### Description   : This function return the result of a query in an index array   ###
###                     format                                                     ###
### Input         : table name,table id,particular field,condition on that         ###
### Ouput         : index array		                                           ###
######################################################################################
	function _getResult($tableName,$tableId,$fieldName,$cond=''){
		if($cond){
			$sql=get_search_sql($tableName,$cond);
		}else{
			$sql=get_search_sql($tableName);
		}
		$res=getindexrows($sql,$tableId,$fieldName,$err);
		return $res;
	}
######################################################################################
### Function Name : jobtitles		                                           ###
### Description   : This function show the company jobtitles information           ###
### Input         : one status variable is taken for redirecting to                ###
###					jobtitleslisting or jobtitles              ###
### Ouput         : company jobtitles  or  jobtitleslisting template               ###
######################################################################################
	function _jobtitles($x=0){
		$uri = 'index.php/page-setting-choice-jobtitles';
		$this->_output['div']=$this->_getResult('companyDivision','id_division','div_name');
		$this->_output['dept1']=$this->_getResult('companyDepartment','id_department','dept_name');
		$this->_output['team1']=$this->_getResult('companyTeam','id_team','team_name');
		$res4=$this->commonEmpCount('id_job_title','companyJobTitle','job_title');
		$this->_output['res4']=$res4;
		$sql="SELECT b.id_department, a.id_division, c.id_job_title, b.dept_name, a.div_name,d.team_name,c.job_title_name,d.id_team,c.notes
FROM ".TABLE_PREFIX."companyDivision AS a, ".TABLE_PREFIX."companyDepartment AS b,".TABLE_PREFIX."companyTeam AS d, ".TABLE_PREFIX."companyJobTitle AS c
WHERE a.id_division = b.id_division AND b.id_department = d.id_department AND d.id_team=c.id_team AND ";

		$id_division=$this->_input['id_division'];
		$id_department=$this->_input['id_department'];
		$id_team=$this->_input['id_team'];
		$job_title_name=$this->_input['job_title_name'];
		if($id_division!=''){
			$sql.="a.id_division = ".$id_division." AND ";
			$uri.="-id_division-".$id_division;
		}
		if($id_department!=''){
			$sql.="b.id_department =".$id_department." AND ";
			$uri.="-id_department-".$id_department;
		}
		if($id_team!=''){
			$sql.="d.id_team =".$id_team." AND ";
			$uri.="-".$key."-".$value;
		}
		if($job_title_name!=''){
			$sql.="c.job_title_name like '%".$job_title_name."%' AND ";
			$uri.="-job_title_name-".$job_title_name;
		}
		$sql=trim($sql,' AND');
		//print $sql;
		$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Team List";
		$this->_output['field'] = array("div_name"=>array("Division Name", 1),"dept_name"=>array("Department Name",1),"team_name"=>array("Team Name",1),"job_title_name"=>array("Job Title Name", 1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "id_job_title";
		if($this->_input['chk']){
			$this->_input['choice']='jobtitles';
			$this->setting_bl->page_listing($this,"setting/jobtitleslisting");
		}else{
			$this->setting_bl->page_listing($this,"setting/jobtitlesearch");
		}
	}

######################################################################################
### Function Name : addjobtitle                                                    ###
### Description   : This function open jobtitle modal form                         ###
### Input         : no input                                                       ###
### Ouput         : company addEditJobTitle template                               ###
######################################################################################
	function _addjobtitle(){
		$this->_output['div']=$this->_getResult('companyDivision','id_division','div_name');
		$this->_output['dept1']=$this->_getResult('companyDepartment','id_department','dept_name');
		$this->_output['team1']=$this->_getResult('companyTeam','id_team','team_name');
		$this->_output['status']="add";
		$this->_output['tpl']='setting/addEditJobTitle';
	}
######################################################################################
### Function Name : editjobtitle                                                   ###
### Description   : This function open editable jobtitle modal form                ###
### Input         : form data                                                      ###
### Ouput         : company addEditJobTitle template                               ###
######################################################################################
	function _editjobtitle(){
		$this->_output['res']=$this->_input;
		$this->_output['div']=$this->_getResult('companyDivision','id_division','div_name');
		$this->_output['dept1']=$this->_getResult('companyDepartment','id_department','dept_name',"id_division=".$this->_input['id_division']);
		$this->_output['team1']=$this->_getResult('companyTeam','id_team','team_name',"id_department=".$this->_input['id_department']);
		$this->_output['status']="add";
		$this->_output['editstatus']="1";
		$this->_output['flag']="1";
		$this->_output['tpl']='setting/addEditJobTitle';
	}
######################################################################################
### Function Name : insertjobtitles                                                ###
### Description   : This function insert the company jobtitles data in database    ###
### Input         : form data                                                      ###
### Ouput         : redirect to jobtitles function                                 ###
######################################################################################
	function _insertjobtitles(){
		$arr['id_team']=$this->_input['jobtitles1']['id_team'];
		$arr['job_title_name']=$this->_input['jobtitles1']['job_title_name'];
		if($this->_input['jobtitles1']['notes']){
			$arr['notes']=$this->_input['jobtitles1']['notes'];
		}
		$r=$this->obj_setting->insertcompany("companyJobTitle",$arr);
		if($r){
			print "<script>callmsg('".getmessage('COM_INS_SUCC')."');</script>";
			$this->_input['choice']="jobtitles";
			$this->_jobtitles(1);
		}
	}
######################################################################################
### Function Name : updatejobtitles                                                ###
### Description   : This function update the company jobtitles data in database    ###
### Input         : form data                                                      ###
### Ouput         : redirect to jobtitles function                                 ###
######################################################################################
	function _updatejobtitles(){
		$arr['id_team']=$this->_input['jobtitles1']['id_team'];
		$arr['job_title_name']=$this->_input['jobtitles1']['job_title_name'];
		if($this->_input['jobtitles1']['notes']){
			$arr['notes']=$this->_input['jobtitles1']['notes'];
		}
		$condition=" id_job_title = ".$this->_input['id_job_title'];
		$r=$this->obj_setting->update_company("companyJobTitle",$arr,$condition);
		print "<script>callmsg('".getmessage('COM_UPD_SUCC')."');</script>";
		$this->_input['choice']="jobtitles";
		$this->_jobtitles(2);
	}
######################################################################################
### Function Name : remove_jobtitle                                                ###
### Description   : This function delete one company jobtitle record in database   ###
### Input         : form data                                                      ###
### Ouput         : redirect to jobtitles function                                 ###
######################################################################################
	function _remove_jobtitle(){
		$cond=" id_job_title = '".$this->_input['id_job_title']."'";
		$r=$this->obj_setting->delete_dept("companyJobTitle",$cond);
		if($r){
			if(($this->_input['cnt']==1) && ($this->_input['qstart'])){
	               			$this->_input['qstart']=$this->_input['qstart']-$GLOBALS['conf']['PAGINATE']['rec_per_page'];
			}
	        	print "<script>callmsg('".getmessage('COM_DEL_SUCC')."');</script>";
			$this->_jobtitles(3);
		}
	}
######################################################################################
### Function Name : addHrForm                                                      ###
### Description   : This function open addhrForm modal form                        ###
### Input         : no input                                                       ###
### Ouput         : company addhrForm template                                     ###
######################################################################################
	function _addHrForm(){
		$this->_output['tpl']='setting/addhrForm';
	}
######################################################################################
### Function Name : hrForms                                                        ###
### Description   : This function show the company Hr Form information             ###
### Input         : one status variable is taken for redirecting to                ###
###					HrFormListing or hrForm                    ###
### Ouput         : company hrForm  or  hrFormListing template                     ###
######################################################################################
	function _hrForms($x=0){
		$sql="SELECT *,IF(sec<60,CONCAT(sec,' second'),IF(min<60,CONCAT(min,' minute'),IF(hours<24,CONCAT(hours,' hour'),CONCAT(day,' day')))) updt FROM (SELECT id_hr_form, form_name,file_name,add_date,TIMESTAMPDIFF(DAY,add_date,NOW()) day,TIMESTAMPDIFF(HOUR,add_date,NOW()) hours,TIMESTAMPDIFF(MINUTE,add_date,NOW()) min,TIMESTAMPDIFF(SECOND,add_date,NOW()) sec FROM ".TABLE_PREFIX."companyHrForm WHERE 1) T";

		$uri = 'index.php/setting/hrForms';
		$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Hrform List";
		$this->_output['field'] = array("form_name"=>array("Form Name", 1),"file_name"=>array("File Name", 1),"add_date"=>array("Date of upload", 1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "id_hr_form";
		$this->_input['choice']='hrForms';
		if($_SESSION['hrform_qs']!=''){
			$this->_input['qstart']=$_SESSION['hrform_qs'];
			$_SESSION['hrform_qs']='';
		}
		//$this->_input['qstart']=$this->_input['start'];
		if($this->_input['chk']){
			$this->setting_bl->page_listing($this,"setting/hrFormListing");
		}else{
			$this->setting_bl->page_listing($this,"setting/hrForm");
		}
	}
######################################################################################
### Function Name : insertHrform                                                   ###
### Description   : This function insert the company hrForm data in database       ###
### Input         : form data                                                      ###
### Ouput         : redirect to hrForm function                                    ###
######################################################################################
	function _insertHrform(){
		$file=$_FILES['fname']['tmp_name'];
		$dest_file=convert_me($_FILES['fname']['name']);
		$arr['form_name']=$this->_input['hrform']['form_name'];
		$arr['file_name']=$dest_file;
		$arr['id_company']=$_SESSION['id_company'];
		$arr['add_date']='NOW()';
		$arr['ip']=$_SERVER['REMOTE_ADDR'];
		$r=$this->obj_setting->insertcompany("companyHrForm",$arr);
		if($r){
			copy($file,APP_ROOT.'files/hr_form/'.$r.'_'.$dest_file);
			$_SESSION['raise_message']['global']=getmessage('COM_INS_SUCC');
			redirect(LBL_SITE_URL."index.php/setting/hrForms");
		}
	}
######################################################################################
### Function Name : editHrForm                                                     ###
### Description   : This function show the editable addhrForm ttemplate            ###
### Input         : form data                                                      ###
### Ouput         : company addhrForm template                                     ###
######################################################################################
	function _editHrForm(){
		$sql="SELECT id_hr_form,form_name,file_name,add_date FROM ".TABLE_PREFIX."companyHrForm WHERE id_hr_form=".$this->_input['id_hr_form'];
		$res=getrows($sql,$err);
		$this->_output['res_hrform'] = $res[0];
		$this->_output['tpl']='setting/addhrForm';
	}
######################################################################################
### Function Name : updateHrform                                                   ###
### Description   : This function update the company Hrform data in database       ###
### Input         : form data                                                      ###
### Ouput         : redirect to hrForm() function                                  ###
######################################################################################
	function _updateHrform(){
		$uploadDir = APP_ROOT."files/hr_form/";
		$arr['form_name']=$this->_input['hrform']['form_name'];
		$file=$_FILES['fname']['tmp_name'];
		$dest_file=$_FILES['fname']['name'];
		if($dest_file!=''){
			$arr['file_name']=convert_me($dest_file);
			@unlink($uploadDir.$this->_input['id_hr_form']."_".trim($this->_input['fl_nm']));
			copy($file,APP_ROOT.'files/hr_form/'.$this->_input['id_hr_form'].'_'.$arr['file_name']);
		}
		$condition=" id_hr_form = ".$this->_input['id_hr_form'];
		$r=$this->obj_setting->update_company("companyHrForm",$arr,$condition);
		if($r){
			$_SESSION['raise_message']['global']=getmessage('COM_UPD_SUCC');
		}
		$_SESSION['hrform_qs']=$this->_input['qstart'];
		redirect(LBL_SITE_URL."index.php/setting/hrForms");
	}
######################################################################################
### Function Name : remove_HrForm                                                  ###
### Description   : This function delete one HrForm from database table and server ###
### Input         : form data                                                      ###
### Ouput         : redirect to hrForm() function.                                 ###
######################################################################################
	function _remove_HrForm(){
		$uploadDir = APP_ROOT."files/hr_form/";
		$fname= $this->_input['id_hr_form']."_".trim($this->_input['file_name']);
		$cond=" id_hr_form = '".$this->_input['id_hr_form']."'";
		$r=$this->obj_setting->delete_dept("companyHrForm",$cond);
		if($r){
			if(($this->_input['cnt']==1) && ($this->_input['qstart'])){
	               			$this->_input['qstart']=$this->_input['qstart']-$GLOBALS['conf']['PAGINATE']['rec_per_page'];
			}
        	 print "<script>callmsg('".getmessage('COM_DEL_SUCC')."');</script>";
	      	 @unlink($uploadDir.$fname);
	      	 $this->_hrForms(2);
		}
	}
######################################################################################
### Function Name : downLoadHrForm                                                 ###
### Description   : This function download the file from the server                ###
### Input         : form data                                                      ###
### Ouput         : downloaded file                                                ###
######################################################################################
	function _downLoadHrForm(){
		if($_SESSION['id_company']){
			$sql="SELECT id_hr_form,file_name FROM ".TABLE_PREFIX."companyHrForm WHERE id_hr_form=".$this->_input['id_hr_form']." LIMIT 1";
			$res=getsingleindexrow($sql,$err);
		}
		$dfile=APP_ROOT.'files/hr_form/'.$res['id_hr_form'].'_';
		$this->downloadFile($dfile,$res['file_name']);
	}
######################################################################################
### Function Name : getdeptName                                                    ###
### Description   : This function put the department name according to division    ###
### Input         : form data                                                      ###
### Ouput         : deptname template                                              ###
######################################################################################
	function _getdeptName(){
		if($this->_input['id_division']){
			$this->_output['dept']=$this->_getResult('companyDepartment','id_department','dept_name',"id_division=".$this->_input['id_division']);
		}else{
			$this->_output['dept1']=$this->_getResult('companyDepartment','id_department','dept_name');
		}
		$this->_output['tpl']='setting/deptname';
	}
######################################################################################
### Function Name : getteamName                                                    ###
### Description   : This function put the team name according to department        ###
### Input         : form data                                                      ###
### Ouput         : deptname template                                              ###
######################################################################################
	function _getteamName(){
		if($this->_input['id_department']){
			$this->_output['dept']=$this->_getResult('companyTeam','id_team','team_name',"id_department = ".$this->_input['id_department']);
		}else{
			$this->_output['dept1']=$this->_getResult('companyTeam','id_team','team_name');
		}
		$this->_output['tpl']='setting/deptname';
	}
######################################################################################
### Function Name : findjobtitlename                                               ###
### Description   : This function find jobtitle name                               ###
### Input         : form data                                                      ###
### Ouput         : ajax_autocomp template                                         ###
######################################################################################
	function _findjobtitlename(){
		$sql="SELECT job_title_name from ".TABLE_PREFIX."companyJobTitle where job_title_name like '%".$this->_input['q']."%' order by job_title_name";
		$data=getrows($sql,$err);
		foreach($data as $key=>$value){
		$val[]=$value['job_title_name'];
		}
		$this->_output['title']=$val;
		$this->_output['tpl']='setting/ajax_autocomp';

	}
######################################################################################
### Function Name : downLoadfile                                                   ###
### Description   : This function is a download common function                    ###
### Input         : form data                                                      ###
### Ouput         : Downloaded file                                                ###
######################################################################################
	function downloadFile($dir="",$file_name=""){
		ob_clean();
		if(!file_exists($dir.$file_name)){
        		print $dir.$file_name." not found";exit;
    		}
		$file_extension = strtolower(substr(strrchr($file_name,'.'),1));

		switch($file_extension){
			case "pdf": $ctype="application/pdf"; break;
			case "exe": $ctype="application/octet-stream"; break;
			case "zip": $ctype="application/zip"; break;
			case "doc": $ctype="application/msword"; break;
			case "xls": $ctype="application/vnd.ms-excel"; break;
			case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
			case "gif": $ctype="image/gif"; break;
			case "png": $ctype="image/png"; break;
			case "jpg":
        		case "jpeg": $ctype="image/jpeg"; break;
        		case "bmp": $ctype="image/bmp"; break;
        		case "tif": $ctype="image/tif"; break;
			case "tiff": $ctype="image/tiff"; break;
        		case "txt": $ctype="text/plain";break;
        		case "css": $ctype="text/css"; break;
			case "csv": $ctype="application/csv";break;
			case "xml": $ctype="text/xml"; break;
			case "avi": $ctype="video/x-msvideo"; break;
			default: $ctype="application/force-download";
		}
		$fsize=filesize($dir.$file_name);

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Type: $ctype");
		header("Content-Disposition: attachment; filename=\"$file_name\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . $fsize);

		$fp = fopen($dir.$file_name, "r");
		fpassthru($fp);
	}



	}
