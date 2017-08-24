<?php
/**
 * Class   : adminstration
 * Purpose : All data manupulation(DML) of administration manager done here. 
 */
class adminstration{
###################################################################################
### Function Name : insert      						###	
### Description   : This is a common insert function for Administration Manager ###
### Input         : $arr(InsertArray),$tbl(tablename),$ad date,falg             ###
### Output	  : Insert Result Set						###
###################################################################################
	function insert($arr,$tbl,$flag='',$dt_fld='add_date'){
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
###################################################################################
### Function Name : Updateall      						###	
### Description   : This is a company Update function for Administration Manager###
### Input         : $tbl(Tablename),$dataArray(Updatearray),$cond(extracontion) ###
### Output	  : Updated Result Set						###
###################################################################################
	function updateall($tbl,$arr,$cond){
		$sql="UPDATE ".TABLE_PREFIX.$tbl." SET ";
		foreach ($arr as $key => $value) {
			$sql.=$key."='".trim($value)."',";
		}
		$sql=trim($sql,',');
		$sql.=" WHERE id_company=".$_SESSION['id_user']." AND ".$cond;
		execute($sql,$err);
		if($err) return $err;
		return TRUE;
	}
	###################################################################################
### Function Name : Updateall      						###
### Description   : This is a company Update function for Administration Manager###
### Input         : $tbl(Tablename),$dataArray(Updatearray),$cond(extracontion) ###
### Output	  : Updated Result Set						###
###################################################################################
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
###################################################################################
### Function Name : delete      						###	
### Description   : This is a common delete function for Administration Manager ###
### Input         : $id_val(value of id),$id_key(id name),$cond(extracontion)   ### 
###                   $table(table name)                                        ###
### Output	  : Delete Result Set						###
###################################################################################	
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
###################################################################################
### Function Name : changeStatus      						###	
### Description   : This is a function to set status in reminder table          ###
### Input         : $id(value of id),$val(status value)                         ###
### Output	  : error on failure or true otherwise    			###
###################################################################################
	function changeStatus($id,$val){
		$sql="UPDATE ".TABLE_PREFIX."companyReminder SET status=".$val." WHERE id_reminder =".$id;
		execute($sql,$err);
		if($err) return $err;
		return TRUE;
	}
}// End of class.
