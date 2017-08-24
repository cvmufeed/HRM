<?php
//include_once("/var/www/html/flexycms/flexycms_core/classes/common/validation.php");
/*
Modified on 02/09/2005 for humor cms .. 
1. Removed fk functions as they are not being used 
2. Modified get function to work only for one id 
3. Added error cheincg in get , insert , update and delete 
4. Changed the table heading to return #LBL_fieldname#
*/

class setting{
	// null args constructor g
	function setting(){
	}
	// Insert into database Return inserted id  if success , error message if failed 
	function insert($arr){
		global $link;
		$sql = "INSERT INTO ".TABLE_PREFIX."config";
		$fld_str_key = "";
		$fld_str_value = "";
		foreach($arr as $key => $value){
			$fld_str_key .= $key.","; 
		}
		$i=0;
		$fld_str_key = substr($fld_str_key,$i,strlen($fld_str_key)-1);
		foreach ($arr as $key => $value) {
			if(!isset($value) || $value == ""){
				$fld_str_value .= "NULL,";
			} else {
				$fld_str_value .= "'".$value."',";
			}
		}
		$fld_str_value = substr($fld_str_value,$i,strlen($fld_str_value)-1);
		$sql = $sql." (".$fld_str_key.") VALUES(".$fld_str_value.")";
		//print $sql;exit;
		$err = execute($sql,$err);
		$id_user = mysqli_insert_id($link);
		return $id_user;
	}
	function edit_config($data,$id_config){
		$sql = "UPDATE ".TABLE_PREFIX."config SET ";
		foreach($data as $k => $v) {
			$sql.= $k."='".$v."',";
		}
		$sql = trim($sql,',');
		$sql.=" WHERE id_config = {$id_config}";
		execute($sql,$err);
	}
	function insert_msg($data) {
		$field_key = '';
		$field_value = '';
		foreach($data as $k => $v) {
			if($v) {
				if($k == 'key_name') {
					$v = strtoupper($v);
				}
				$field_key .= $k.",";
				$field_value .= $v."','";
			}
		}
		$sql = "INSERT INTO ".TABLE_PREFIX."message (".trim($field_key,',').") 
			VALUES ('".trim($field_value,",'")."')";
		return $sql;
	}
	function edit_msg($data,$id_msg){
		$sql = "UPDATE ".TABLE_PREFIX."message SET ";
		foreach($data as $k => $v) {
			if($k == 'key_name') {
				$v = strtoupper($v);
			}
			$sql.= $k."='".$v."',";
		}
		$sql = trim($sql,',');
		$sql.=" WHERE id_message = {$id_msg}";
		return $sql;
	}
	function delete_msg($key_name){
		$sql="DELETE FROM ".TABLE_PREFIX."message WHERE key_name = '".$key_name."'";
		return $sql;
	}
	function insert1($table,$arr){
		global $link;
		$sql = "INSERT INTO ".TABLE_PREFIX.$table;
		$fld_str_key = "";
		$fld_str_value = "";
		foreach($arr as $key => $value){
			$fld_str_key .= $key.","; 
		}
		$fld_str_key = substr($fld_str_key,',',strlen($fld_str_key)-1);
		foreach ($arr as $key => $value) {
			if(!isset($value) || $value == ""){
				$fld_str_value .= "NULL,";
			} else {
				$fld_str_value .= "'".$value."',";
			}
		}
		$fld_str_value = substr($fld_str_value,',',strlen($fld_str_value)-1);
		$sql = $sql." (".$fld_str_key.") VALUES(".$fld_str_value.")";
		//print $sql;exit;
		$err = execute($sql,$err);
		$id_user = mysqli_insert_id($link);
		return $id_user;
	}
	function update1($table,$data,$condition="") {
		$sql="UPDATE ".TABLE_PREFIX.$table." SET ";
		foreach ($data as $key => $value) {
			$sql.=$key."='".$value."',";
		}
		$sql=trim($sql,',');
		//$sql.=" WHERE id_company= ".$_SESSION['id_company'];
		if($condition){
		$sql.=" WHERE ".$condition;
		}
   		execute($sql,$err);
		if($err) return $err;
		return TRUE;
	}
	function delete1($tblname,$cond){
		$sql="DELETE FROM ".TABLE_PREFIX.$tblname." WHERE ".$cond;
		execute($sql,$err);
		if($err) return $err;
		return TRUE;
	}
	
	function insertmodules($arr,$tbl,$flag='',$dt_fld='add_date'){
	    global $link;
		$sql = "INSERT INTO ".TABLE_PREFIX.$tbl;
		$fld_str_key = "";
		$fld_str_value = "";
		foreach($arr as $key => $value){
			$fld_str_key .= $key.",";
		}
		$fld_str_key = trim($fld_str_key,',');
		if($flag==1){
			$fld_str_key .= ",".$dt_fld;//",add_date,ip";
		}
		foreach ($arr as $key => $value) {
			if(!isset($value) || $value == ""){
				$fld_str_value .= "NULL,";
			} else {
				$fld_str_value .= "'".$value."',";
			}
		}
		$fld_str_value = trim($fld_str_value,',');
		if($flag==1){
			$fld_str_value .= ",NOW()";//,'".$_SERVER['REMOTE_ADDR']."'";
		}
		$sql = $sql." (".$fld_str_key.") VALUES(".$fld_str_value.")";
  		$err = execute($sql,$err);
      return mysqli_insert_id($link);
	}
	function delete($id_val,$id_key,$cond,$table){
		if(!$cond){
			$cond=1;
		}
	 	$sql="DELETE FROM ".TABLE_PREFIX."$table WHERE ".$id_key."=".$id_val." AND ".$cond;
		//print $sql;exit;
		execute($sql,$err);
		if($err) return $err;
		return TRUE;
	}
		function altercolumn($table,$col){

	 	$sql="alter table ".TABLE_PREFIX."$table add id_".$col." INT (5) NOT NULL default '".$col."',add isvisible_".$col." INT (5) NOT NULL default '0'";
       	execute($sql,$err);
		if($err) return $err;
		return TRUE;
	}
 function update($tbl,$arr,$cond){
		$sql="UPDATE ".TABLE_PREFIX.$tbl." SET ";
  foreach ($arr as $key => $value) {
			$sql.=$key."='".trim($value)."',";
 	}
		$sql=trim($sql,',');
		$sql.=" WHERE ".$cond;
		execute($sql,$err);
		if($err) return $err;
		return TRUE;
	}
	
	// Insert into database Return inserted id  if success , error message if failed
#########################################################################################
### Function Name : insert       			      	                      ###
### Description   : Function to insert data into the table                            ###
### Input         : table name and array of values to be inserted into the tables     ###
### Ouput	  : id of inserted record                                             ###
#########################################################################################
	function insertcompany($table,$arr){
		global $link;
		$sql = "INSERT INTO ".TABLE_PREFIX.$table;
		$fld_str_key = "";
		$fld_str_value = "";
		foreach($arr as $key => $value){
			$fld_str_key .= $key.",";
		}
 	$i="0";
 	$fld_str_key = substr($fld_str_key,$i,strlen($fld_str_key)-1);

		foreach ($arr as $key => $value) {
			if(!isset($value) || $value == "")
				$fld_str_value .= "NULL,";
			elseif($value=='NOW()')
				$fld_str_value .= $value.",";
			else
				$fld_str_value .= "'".$value."',";
		}
		$fld_str_value = substr($fld_str_value,$i,strlen($fld_str_value)-1);
		$sql = $sql." (".$fld_str_key.") VALUES(".$fld_str_value.")";
		//print $sql;exit;
		$err = execute($sql,$err);
		return mysqli_insert_id($link);
	}
	
	#########################################################################################
### Function Name : editCompany       			      	                      ###
### Description   : Function to update company table                                  ###
### Input         : table name and array of values to be updated into the tables      ###
### Ouput	  : number of rows affected                                           ###
#########################################################################################
	function editCompany($table,$data) {
		global $link;
		$sql="UPDATE ".TABLE_PREFIX.$table." SET ";
		foreach ($data as $key => $value) {
			$sql.=$key."='".$value."',";
		}
		$sql=trim($sql,',');
		$sql.=" WHERE id_company = ".$_SESSION['id_company'];
		execute($sql,$err);
		if($err) return $err;
		return TRUE;
	}
#########################################################################################
### Function Name : update_company    			      	                      ###
### Description   : Common function to update data into the tables except company     ###
### Input         : Table name and array of values to be updated into the tables      ###
### Ouput	  : number of rows affected                                           ###
#########################################################################################
	function update_company($table,$data,$condition){
		global $link;
		$sql="UPDATE ".TABLE_PREFIX.$table." SET ";
		foreach ($data as $key => $value) {
			$sql.=$key."='".$value."',";
		}
		$sql=trim($sql,',');
		$sql.=" WHERE ".$condition;
		//print $sql;exit;
		execute($sql,$err);
		if($err) return $err;
		return TRUE;
	}
#########################################################################################
### Function Name : delete_dept    			      	                      ###
### Description   : Common function to delete data from the tables                    ###
### Input         : Table name and conditions					      ###
### Ouput	  : error on failure and true on success                              ###
#########################################################################################
	function delete_dept($tblname,$cond){
		$sql="DELETE FROM ".TABLE_PREFIX.$tblname." WHERE ".$cond;
		execute($sql,$err);
		if($err) return $err;
		return TRUE;
	}
}
?>
