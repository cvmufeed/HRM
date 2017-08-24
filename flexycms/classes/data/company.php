<?php
/**
 * Class   : company
 * Purpose : All company module database operation is done here. 
 */
class company{
	function company(){
	}

	// Insert into database Return inserted id  if success , error message if failed 
#########################################################################################
### Function Name : insert       			      	                      ###
### Description   : Function to insert data into the table                            ###
### Input         : table name and array of values to be inserted into the tables     ###
### Ouput	  : id of inserted record                                             ###
#########################################################################################
	function insert($table,$arr){
		global $link;
		$sql = "INSERT INTO ".TABLE_PREFIX.$table;
		$fld_str_key = "";
		$fld_str_value = "";
		foreach($arr as $key => $value){
			$fld_str_key .= $key.",";
		}
	//	echo $fld_str_key;
	//	echo strlen($fld_str_key)-1;
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
}//end of class.
?>
