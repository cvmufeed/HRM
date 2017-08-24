<?php
class employee{
	function employee(){
		
	}
#####################################################################################################
# Function Name : insert		                                                            #
# Description   : common function to insert records					            #
#					                                                            #
# Input         : table name,array of info,flag(optional),date_field(optional)                      #
# Output	: Returns inserted id		  				                    #
#####################################################################################################
	function insert($tbl,$arr,$flag='',$dt_fld='add_date'){
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
				$fld_str_value .= "'".trim($value)."',";
			}
		}
		$fld_str_value = trim($fld_str_value,',');
		if($flag==1){
			$fld_str_value .= ",NOW()";//,'".$_SERVER['REMOTE_ADDR']."'";
		}
		$sql = $sql." (".$fld_str_key.") VALUES(".$fld_str_value.")";
		//print $sql;exit;
		$link->query($sql);
		$id = mysqli_insert_id($link);
		return $id;
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
#####################################################################################################
# Function Name : delete		                                                            #
# Description   : common function to delete record(s) 					            #
#					                                                            #
# Input         : table name,condition						                    #
# Output	: No Output			  				                    #
#####################################################################################################
	function delete($table,$condition){
		$sql="DELETE FROM ".TABLE_PREFIX.$table." WHERE ".$condition;
		//print "<br>sql:".$sql;exit;
		$r=execute($sql,$err);
		return $r;
	}
#####################################################################################################
# Function Name : insertDefaultBenefits                                                             #
# Description   : Inserted default benefit records against an employee			            #
#					                                                            #
# Input         : id_employee,default validity					                    #
# Output	: No Output			  				                    #
#####################################################################################################
	function insertDefaultBenefits($id_employee,$interval){
		global $link;
		$sql = "INSERT INTO ".TABLE_PREFIX."employeeBenefits(id_employee,id_benefits,eligibility,from_date,to_date,coverage) SELECT '".$id_employee."' AS id_employee,id_benefits,1 AS eligibility,NOW() AS from_date,DATE_ADD(NOW(),INTERVAL ".$interval." DAY) AS to_date,1 FROM ".TABLE_PREFIX."companyBenefits WHERE id_company=".$_SESSION['id_company']." AND is_set=1";
		$link->query($sql);
	}
#####################################################################################################
# Function Name : updateModifyDate                                                                  #
# Description   : updated modify date in employee table					            #
#					                                                            #
# Input         : id_employee(optional)					        	            #
# Output	: No Output			  				                    #
#####################################################################################################
	function updateModifyDate($flg=''){
		global $link;
		if($_SESSION['id_employee']){
			$id=$_SESSION['id_employee'];
		}elseif($_SESSION['cur_emp_id']){
			$id=$_SESSION['cur_emp_id'];
		}
		if($flg=="view"){
			$upd_fld="view_date";
		}else{
			$upd_fld="modify_date";
		}
		$sql_upd="UPDATE ".TABLE_PREFIX."employee SET ".$upd_fld."=NOW() WHERE id_employee='".$id."' LIMIT 1";
		//print $sql_upd;exit;
		$link->query($sql_upd);
	}
}
?>
