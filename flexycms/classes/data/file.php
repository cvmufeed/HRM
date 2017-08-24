<?php
/*
 * Class   : files 
 * Purpose : All business logic(Data Manipulation) related to files_manager done here
 */
class file{
###########################################################################
### Function Name : insert				   								###
### Description   : Function to insert new record to table 				###
### Input         : $table(table name),$arr(form input with array type) ###
### Output		  : Insert new folder or file to table			   	    ###
###########################################################################
	function insert($table,$arr){
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
		$err = execute($sql,$err);		
		return mysqli_insert_id($link);
	}
	
###################################################################################################
### Function Name : delete				   														###
### Description   : Function to delete existing record to table									###
### Input         : $table(table name),$field(field name of table),$id(primary key id of table) ###
### Output		  : Insert new folder or file to table			   	   	 						###
###################################################################################################
	function delete($table,$field,$id){
		global $link;
		$sql="DELETE FROM ".TABLE_PREFIX.$table." WHERE ".$field." = ".$id." AND id_company=".$_SESSION['id_company'];
		execute($sql,$err);
		return mysqli_affected_rows($link);
	}
#####################################################################################################
# Function Name : update		                                                            #
# Description   : common function to update record 					            #
#					                                                            #
# Input         : table name,array of info,condition				                    #
# Output	: Returns true/false		  				                    #
#####################################################################################################
	function update($tbl,$arr,$cond){
		$sql="UPDATE ".TABLE_PREFIX.$tbl." SET ";
		foreach ($arr as $key => $value) {
			$sql.=$key."='".trim($value)."',";
		}
		$sql=trim($sql,',');
		$sql.=" WHERE ".$cond;
		//print $sql;exit;
		$r=execute($sql,$err);
		return $r;
	}
}
