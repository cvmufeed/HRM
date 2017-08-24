<?php
class setting_bl extends business
{
##########################################################
### Function Name : generalConf			       ###
### Description   : Function to select comapnt details ###
### Input         : No input 			       ###
### Ouput 	  : sql query		      	       ###
##########################################################
  	function generalConf(){
		$sql = "SELECT c.*,t.* FROM ".TABLE_PREFIX."company AS c,".TABLE_PREFIX."timezone AS t
			WHERE c.id_company = ".$_SESSION['id_company']."
				AND c.timezone = t.timezone_value
				LIMIT 1";
		return $sql;
	}
};
?>
