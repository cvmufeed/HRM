<?php /* Smarty version 2.6.7, created on 2017-08-24 10:53:19
         compiled from report/genderProfile.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'report/genderProfile.tpl.html', 108, false),)), $this); ?>

<!-- Template: report/genderProfile.tpl.html Start 24/08/2017 10:53:19 --> 
 <?php echo '
<link rel="stylesheet" type="text/css" href="http://localhost/simplehrm/templates/css_theme/jquery.jqplot.css" />
<!-- BEGIN: load jqplot -->
<script language="javascript" type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/jquery.jqplot.js"></script>
<script language="javascript" type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/jqplot.pieRenderer.js"></script>
<script language="javascript" type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/jqplot.categoryAxisRenderer.js"></script>
<script language="javascript" type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/jqplot.barRenderer.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		var male=\'';  echo $this->_tpl_vars['sm']['male'];  echo '\';
		var female=\'';  echo $this->_tpl_vars['sm']['female'];  echo '\';
		if(male || female)
			pieGenderChart();
		else
			return true;
	 });

	function pieGenderChart(){
		$("#genderProfile").html(\'\');
		var male=\'';  echo $this->_tpl_vars['sm']['male'];  echo '\';
		var female=\'';  echo $this->_tpl_vars['sm']['female'];  echo '\';
		var gender = [[\'Male\',+male], [\'Female\',+female]];
		var genderPlot = $.jqplot(\'genderProfile\', [gender], {
			title:\'Gender group pie chart\',
			grid: {
			    drawBorder: true, 
			    drawGridlines: true,
			    background: \'#ffffff\',
			    shadow:true
			 },
			axesDefaults: {
			    
			 },
			seriesDefaults:{
			    renderer:$.jqplot.PieRenderer,
			    rendererOptions: {
				showDataLabels: true
			     }
			 },
			legend: {
			    show: true,
			    rendererOptions: {
				numberRows: 1
			     },
			    location: \'s\'
			 }
		 });
		$("#genderBarPie").html(\'Click here for <a href="javascript:void(0);" onclick="barGenderChart()">Gender Bar Chart</a>\');
	 }

	function barGenderChart(){
		$("#genderProfile").html(\'\');
		var male=\'';  echo $this->_tpl_vars['sm']['male'];  echo '\';
		var female=\'';  echo $this->_tpl_vars['sm']['female'];  echo '\';
		var gender = [[\'Male\',+male], [\'Female\',+female]];		
		 gender = $.jqplot(\'genderProfile\', [gender], {
		    title:\'Gender group bar chart\',
		     seriesDefaults:{
		       renderer:$.jqplot.BarRenderer, 
		       rendererOptions:{
		         barWidth:25, 
		         barPadding:-15, 
		         barMargin:15, 
		         barDirection: \'vertical\',
		         varyBarColor: true
		        }, 
		       shadow:true
		      },
		     legend: {show:false },
		     axes:{
		         yaxis:{min:0, tickOptions: {formatString: \'%.0f\',showGridLine: true } },
		         xaxis:{show: true, renderer: $.jqplot.CategoryAxisRenderer,
		                    tickOptions: {show: true, showLabel: true },
		                    showTicks: false }
		          }
		  });
		$("#genderBarPie").html(\'Click here for <a href="javascript:void(0);" onclick="pieGenderChart()">Gender Pie Chart</a>\');
	 }
</script>
'; ?>

<?php if ($this->_tpl_vars['sm']['male'] || $this->_tpl_vars['sm']['female']): ?>





<table border="0">

<tr>
		<td valign="middle">
			<div id="genderProfile" style="margin-top:20px; margin-left:20px; width:350px; height:350px; position:relative; z-index:0"></div>
			<div id="genderBarPie" style="margin-left:20px;"></div>
			</font>
		</td>
	</tr>
		<tr>
		<td align=center>
			<font size='2'>

        <div class="smlest_box">
                <div class="top"></div>
                <div class="mdl">
                        <div class="clear"></div>
                        <div class="a_cont wid84smlst">
			<div id="genderProfileData">Number of male employees: <b><?php echo ((is_array($_tmp=@$this->_tpl_vars['sm']['male'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</b><br/>Number of female employees: <b><?php echo ((is_array($_tmp=@$this->_tpl_vars['sm']['female'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</b></div>

                        </div>
                </div>
                <div class="btm"></div>
        </div>






		</td>
  </tr>
</table>
<?php else: ?>
	<div>Employee not found</div>
<?php endif; ?>
</div>

<!-- Template: report/genderProfile.tpl.html End --> 