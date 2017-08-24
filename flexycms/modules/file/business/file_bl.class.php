<?php
/*
 * Class   : files_bl 
 * Purpose : All business logic(Data Query) related to files_manager done here
 */
class file_bl extends business{
###############################################################################################################
### Function Name : countFF									   											   	###
### Description   : Function to number of folders or files												   	###
### Input         : $table(Table name),$field(Field of the given table),$fid(Folder or file primary key id) ###
### Output		  : Return number of folders or files				  										###
###############################################################################################################
	function countFF($table,$field,$fid){
		global $link;
		$sql_cnt_FF	= "SELECT COUNT(*) AS no_FF FROM ".TABLE_PREFIX.$table." WHERE ".$field." = ".$fid;
		$cnt_FF 	= getsingleindexrow($sql_cnt_FF);
		return $cnt_FF; 
	}
}
