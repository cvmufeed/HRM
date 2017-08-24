
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SimpleHRM - Open Source Human Resource Management .::</title>


<script type="text/javascript" src="../libsext/jquery/jquery.js"></script>
<script type="text/javascript" src="../libsext/jquery/jquery.validate.js"></script>
<script type="text/javascript" src="../libsext/jquery/jquery-ui.js"></script>

	<script type="text/javascript" src="../libsext/jquery/jquery-ui-1.7.1.custom.min.js"></script>
	<script type="text/javascript" src="../libsext/jquery/daterangepicker.jQuery.js"></script>

<script type="text/javascript" src="../libsext/fancybox/jquery.fancybox-1.3.2.pack.js"></script>

<script language="javascript" type="../text/javascript" src="templates/flexyjs/excanvas.js"></script>

<script type="text/javascript" src="../templates/flexyjs/flexymessage.js"></script>
<script type="text/javascript" src="../libsext/jquery/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../libsext/jquery/ajaxfileupload.js"></script>
<script type="text/javascript" src="../templates/flexyjs/scrollable.js"></script>
<script type="text/javascript" src="../libsext/jquery/overlib.js"></script>


<link rel="stylesheet" type="text/css" href="../templates/css_theme/fancybox/jquery.fancybox-1.3.2.css"/>
<link rel="stylesheet" type="text/css" href="../templates/css_theme/mainpg.css"/>
<link rel="stylesheet" type="text/css" href="../templates/css_theme/css/flexy.css"/>
<link rel="stylesheet" type="text/css" href="../templates/css_theme/css/flexymenu.css"/>
<link rel="stylesheet" type="text/css" href="../templates/css_theme/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../templates/css_theme/jquery-ui-1.7.3.css"/>

<link href="../templates/css_theme/ui.daterangepicker.css" rel="stylesheet">
<link rel="stylesheet" href="../templates/css_theme/jquery-ui-1.7.1.custom.css" type="text/css" title="ui-theme" />

<div class="form" id="add_installation" style="height:700px;">

    	<div class="fltlft">
        	<div class="form_hdrbg_lft fltlft"></div>
            <div class="form_hdrbg_mdl fltlft">

                <div class="fltrht" style="margin-top:-10px;margin-left:125px;float:left;text-align:left;"> <img  src="../templates/images/blue/logo1.png">

                </div>
                <div class="clear"></div>
			</div>
            <div class="form_hdrbg_rht fltlft"></div>
        </div>
        <div class="clrbth"></div>
        <div class="form_bg_mdl">
        	<div  class="login_blue_hdr">
                <div class="login_hdrlft fltlft"></div>
                <div class="login_hdrmdl fltlft" style="text-align:center;">Welcome To SimpleHRM</div>
                <div class="login_hdrrht fltlft"></div>
            </div>
              <div class="clrbth" style="text-align:center;"></div>
              <div>
            <span class="error" id="install_msg" style="padding-left:20px;color:red;font-type:bold;text-align:center;">
            <?php
            if(!empty($_GET['error']))
            {
                echo $_GET['error'];
            }
            ?></span>
    <form  method="post" name="install" id="install" action="installdb.php" onSubmit="return validate();">
        <table width="434px" align="center">

            <tr>
                <td align='right'><b>Server Name: </b></td>
                <td><input type="text"  id="servername" name="servername" class="text"></td>
            </tr>
            <tr>
                <td align='right'><b>Mysql Host: </b></td>
                <td><input type="text" id="mysqlhost" name="mysqlhost"  class="text"></td>
            </tr>
            <tr>
                <td align='right'><b>Mysql Username: </b></td>
                <td><input type="text" id="mysqluser" name="mysqluser"  class="text"></td>
            </tr>
            <tr>
                <td align='right'><b>Mysql Password: </b></td>
                <td><input type="text" id="mysqlpwd" name="mysqlpwd"   class="text"></td>
            </tr>
            <tr>
                <td align='right'><b>Mysql DB: </b></td>
                <td><input type="text" id="mysqldb" name="mysqldb"   class="text"></td>
            </tr>
            <tr>
                <td align='right'><b>Admin User Name: </b></td>
                <td><input type="text" id="adminname" name="adminname" class="text"></td>
            </tr>
            <tr>
                <td align='right'><b>Admin Password: </b></td>
                <td><input type="password" id="adminpwd" name="adminpwd"  class="text"></td>
            </tr>
            <tr>
                <td></td>
                <td align="left"><input type="submit" value="Submit" style="margin-top:25px;" onclick="validate();" class="login_btn"/></td>
            </tr>
        </table>
    </form>
                <div  class="login_blue_hdr">
                <div class="login_hdrlft fltlft"></div>
                <div class="login_hdrmdl fltlft"></div>
                <div class="login_hdrrht fltlft"></div>
            </div>
            <div class="clrbth"></div>
            <div>
            </div>
        </div>
        <div class="form_bg_btm"></div>
    </div>

<script type="text/javascript">
function validate(){
	$("#install_msg").html("");
	var res = assignProperty();
	var data=$("#install").serialize();
    var url="##LBL_SITE_URL##index.php/adminstration/createinst?"+data;
  $.post(url);
  }

function assignProperty(){
 	var validator_assign_property=$("#install").validate({
		rules: {
			"servername": {
				required:true
			},
			"mysqlhost": {
				required:true
			},
            "mysqluser": {
				required:true
			},
			"mysqlpwd": {
				required:true
			},
			"mysqldb": {
				required:true
			},
            "adminname": {
				required:true,
                email:true
			},
			"adminpwd": {
				required:true,
				minlength: 6
			}
		},
		messages: {
			"servername":{
				required:flexymsg.required
			},
			"mysqlhost":{
				required:flexymsg.required
			},
			"mysqluser":{
				required:flexymsg.required
			},
			"mysqlpwd":{
				required:flexymsg.required
			},
				"mysqldb":{
				required:flexymsg.required
			},
			"adminname":{
				required:flexymsg.required,
				email:'Please enter a valid email address.'
			},
            "adminpwd":{
				required:flexymsg.required,
				minlength:'Minimum password length is 6'
			}
		}
	});
	return validator_assign_property.form();
}
</script>
<style type="text/css">
#forgotform .text {
	width:200px;
	margin-right:10px;
	padding:3px;
	border:1px solid #ccc; 9BC7D5
	letter-spacing:1px;
}
#forgotform .select {
	border:1px solid #ccc;
	width:209px;
	padding:4px;
}

</style>


