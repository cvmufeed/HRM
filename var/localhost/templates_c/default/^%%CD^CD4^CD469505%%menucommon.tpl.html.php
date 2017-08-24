<?php /* Smarty version 2.6.7, created on 2017-08-24 10:54:46
         compiled from common/menucommon.tpl.html */ ?>

<!-- Template: common/menucommon.tpl.html Start 24/08/2017 10:54:46 --> 
 <div  id="setting_userlist"> </div>
                <?php if ($_SESSION['id_company']): ?>    <?php echo '
<script type="text/javascript">
var url = "http://localhost/simplehrm/index.php/";
$.post(url,{page:"setting",choice:"menu",ce:0 },function(res){
 	$("#setting_userlist").html(res);
	 });
</script>
'; ?>

<?php elseif ($_SESSION['id_employee']): ?>
<?php echo '
<script type="text/javascript">
var url = "http://localhost/simplehrm/index.php/";
$.post(url,{page:"setting",choice:"menu",ce:0 },function(res){
 	$("#setting_userlist").html(res);
	 });
</script>
'; ?>

<?php endif; ?>



<!-- Template: common/menucommon.tpl.html End --> 