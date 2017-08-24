
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

                <div class="fltrht" style="margin-top:-10px;margin-left:125px;float:left;text-align:center;"> <img  src="../templates/images/blue/logo1.png">

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
            <span class="error" id="install_msg"></span>
<form method="post" name="installationdb">
<?php
ini_set('display_errors','Off');
 $hostname=$_POST['mysqlhost'];
 $hostuser=$_POST['mysqluser'];
 $hostpwd=$_POST['mysqlpwd'];
 $hostdb= $_POST['mysqldb'];
 $servername=$_POST['servername'];
 $username=$_POST['adminname'];
 $userpwd=$_POST['adminpwd'];
//exec("mysql -u root -p testinstall < simplehrm.sql");
$dbconn = mysql_connect($hostname,$hostuser,$hostpwd);
if (!$dbconn)
  { ?>
  <script type="text/javascript">
  location.href ="install.php?error=Entered mysql details are wrong. Please enter correct mysql details!!!";
  </script>

<?php
  }
  else if(mysql_select_db($hostdb,$dbconn)!='1')
  {
   ?>
  <script type="text/javascript">
  location.href ="install.php?error=Provided mysql database not available. Create the DB and enter the same !!!";
  </script>
<?php }

else
{
   mysql_select_db($hostdb,$dbconn);
    $file = 'simplehrm.sql';
    //$fileprocedure='procedure.sql';

if($fp = file_get_contents($file)) {
  $var_array = explode(';',$fp);
  foreach($var_array as $value) {
    mysql_query($value.';',$dbconn);
  }
 /* if($fp = file_get_contents($fileprocedure)) {
  $var_array = explode(';',$fp);
  foreach($var_array as $value) {
    mysql_query($value.';',$dbconn);
  }
  }
  */
 $mysqlprocedure=mysql_query("CREATE PROCEDURE `get_search_sql`(IN tb_name VARCHAR(100),IN cond TEXT)
BEGIN
 IF cond ='' THEN
   SET @p := CONCAT('SELECT * FROM ' , tb_name);
 ELSE
   SET @p := CONCAT('SELECT * FROM ' , tb_name,' WHERE ', cond);
 END IF;
 PREPARE stmt FROM @p;
 EXECUTE stmt;
 DEALLOCATE PREPARE stmt;
END;");
 $mysqlprocedure=mysql_query("CREATE TRIGGER `insertrolefeatures` AFTER INSERT ON `hrm__modulefeatures`
 FOR EACH ROW BEGIN
insert into hrm__rolefeatures(id_modulefeatures,id_modules,isvisible) values(new.id_modulefeatures,new.id_modules,'0');
END");
$mysqlprocedure=mysql_query("INSERT INTO `hrm__timezone` (`id_timezone`, `timezone_value`, `timezone_text`) VALUES
(1, -12.0, '(GMT -12:00) Eniwetok, Kwajalein'),
(2, -11.0, '(GMT -11:00) Midway Island, Samoa'),
(3, -10.0, '(GMT -10:00) Hawaii'),
(4, -9.0, '(GMT -9:00) Alaska'),
(5, -8.0, '(GMT -8:00) Pacific Time (US &amp; Canada)'),
(6, -7.0, '(GMT -7:00) Mountain Time (US &amp; Canada)'),
(7, -6.0, '(GMT -6:00) Central Time (US &amp; Canada), Mexico City'),
(8, -5.0, '(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima'),
(9, -4.0, '(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz'),
(10, -3.5, '(GMT -3:30) Newfoundland'),
(11, -3.0, '(GMT -3:00) Brazil, Buenos Aires, Georgetown'),
(12, -2.0, '(GMT -2:00) Mid-Atlantic'),
(13, -1.0, '(GMT -1:00 hour) Azores, Cape Verde Islands'),
(14, 0.0, '(GMT) Western Europe Time, London, Lisbon, Casablanca'),
(15, 1.0, '(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris'),
(16, 2.0, '(GMT +2:00) Istanbul, Kaliningrad, South Africa'),
(17, 3.0, '(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg'),
(18, 3.5, '(GMT +3:30) Tehran'),
(19, 4.0, '(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi'),
(20, 4.5, '(GMT +4:30) Kabul'),
(21, 5.0, '(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent'),
(22, 5.5, '(GMT +5:30) Bombay, Calcutta, Madras, New Delhi'),
(23, 5.8, '(GMT +5:45) Kathmandu'),
(24, 6.0, '(GMT +6:00) Almaty, Dhaka, Colombo'),
(25, 7.0, '(GMT +7:00) Bangkok, Hanoi, Jakarta'),
(26, 8.0, '(GMT +8:00) Beijing, Perth, Singapore, Hong Kong'),
(27, 9.0, '(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk'),
(28, 9.5, '(GMT +9:30) Adelaide, Darwin'),
(29, 10.0, '(GMT +10:00) Eastern Australia, Guam, Vladivostok'),
(30, 11.0, '(GMT +11:00) Magadan, Solomon Islands, New Caledonia'),
(31, 12.0, '(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka');");
$mysqluserupdate=mysql_query("update hrm__company set email_id='".$username."',password=MD5('".$userpwd."')");
 
}
$serverconfig="../flexycms/configs/".$servername;
$renameconstants="../flexycms/configs/".$servername.".constants.php" ;
chmod("image/",0755);
chmod("var/",0755);
rename("../flexycms/configs/localhost.site_constants.php","../flexycms/configs/".$servername.".site_constants.php");
rename("../flexycms/configs/localhost.constants.php",$renameconstants);
rename("../flexycms/configs/localhost/","../flexycms/configs/".$servername."/");
rename("../var/localhost/","../var/".$servername."/");
rename("../index.html","../index###.html");
//$delfileinstall="install.php";
$delfileindex="../index###.html";
copy("index.php","../index.php");

//unlink($delfileinstall);
unlink($delfileindex);
//Creating the Configuration file
rename("install","install###");
// Define for Sub Directory
define("SUB_FOLD1", dirname($_SERVER['PHP_SELF']));
$arr_sub_dir = explode("/",SUB_FOLD1);
define("ARR_SUBDIR1", $arr_sub_dir[1]);

?>

 <table width="434px" align="center">
 <tr>
             <td colspan="2" align='center'><b>Application has been successfully installed. </b></td>
            </tr>
           <tr>
            <td align='right'><b> Please access the link to login for </b> </td>
            <td><a href=http://<?php echo $servername."/".ARR_SUBDIR1."/index.php";?> <u> SimpleHRM Application<u><a></b></td>
            </tr>
            <tr>
            <td align='right'><b>Application URL:</b></td>
            <td><b> <?php echo $servername."/".ARR_SUBDIR1."/index.php";?></b></td>
            </tr>
             <tr>
            <td align='right'><b>Admin User Name:</b></td>
            <td><b> <?php echo $username;?></b></td>
            </tr>
             <tr>
            <td align='right'><b>Admin Password:</b></td>
            <td><b> <?php echo $userpwd;?></b></td>
            </tr>
            
 </table>
<?php
$myFile = $serverconfig."/"."constants.php";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = "<?php
define(\"DB_HOST\",'".$hostname."');
define(\"DB_USER\",'".$hostuser."'); // MySql User nameg
define(\"DB_PASS\",'".$hostpwd."'); // MySql passwordg
define(\"DB_DB\",'".$hostdb."'); // MySql Database Nameg
define(\"AFIXI_THEME\",''); // Document root of application g
//define(\"TABLE_PREFIX\" ,'flexy__');g
define(\"TABLE_PREFIX\" ,'hrm__');
define(\"LINKS_PREFIX\",'links_');
define(\"ROLES_ROOT\",AFIXI_ROOT.'/configs/'.SITE_USED.'/');
?>";
fwrite($fh, $stringData);
fclose($fh);
}
 mysql_close($dbconn);
?>
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
