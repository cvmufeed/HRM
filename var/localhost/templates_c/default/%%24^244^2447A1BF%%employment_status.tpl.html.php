<?php /* Smarty version 2.6.7, created on 2017-08-24 10:48:59
         compiled from report/employment_status.tpl.html */ ?>

<!-- Template: report/employment_status.tpl.html Start 24/08/2017 10:48:59 --> 
 <?php echo '
<link rel="stylesheet" type="text/css" href="http://localhost/simplehrm/templates/css_theme/jquery.jqplot.css" />
<!-- BEGIN: load jqplot -->
<script language="javascript" type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/jquery.jqplot.js"></script>
<script language="javascript" type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/jqplot.pieRenderer.js"></script>
<script language="javascript" type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/jqplot.categoryAxisRenderer.js"></script>
<script language="javascript" type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/jqplot.barRenderer.js"></script>

<script type="text/javascript" src="http://localhost/simplehrm/libsext/jquery/json.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var arr = \'';  echo $this->_tpl_vars['sm']['x'];  echo '\';
		if(arr)
			pieEmpStatusChart();
		else
			return false;
	 });
	function pieEmpStatusChart(){
		$("#empStatus").html(\'\');
 	var arr1 = \'';  unset($this->_sections['s1']);
$this->_sections['s1']['name'] = 's1';
$this->_sections['s1']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['arr']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['s1']['show'] = true;
$this->_sections['s1']['max'] = $this->_sections['s1']['loop'];
$this->_sections['s1']['step'] = 1;
$this->_sections['s1']['start'] = $this->_sections['s1']['step'] > 0 ? 0 : $this->_sections['s1']['loop']-1;
if ($this->_sections['s1']['show']) {
    $this->_sections['s1']['total'] = $this->_sections['s1']['loop'];
    if ($this->_sections['s1']['total'] == 0)
        $this->_sections['s1']['show'] = false;
} else
    $this->_sections['s1']['total'] = 0;
if ($this->_sections['s1']['show']):

            for ($this->_sections['s1']['index'] = $this->_sections['s1']['start'], $this->_sections['s1']['iteration'] = 1;
                 $this->_sections['s1']['iteration'] <= $this->_sections['s1']['total'];
                 $this->_sections['s1']['index'] += $this->_sections['s1']['step'], $this->_sections['s1']['iteration']++):
$this->_sections['s1']['rownum'] = $this->_sections['s1']['iteration'];
$this->_sections['s1']['index_prev'] = $this->_sections['s1']['index'] - $this->_sections['s1']['step'];
$this->_sections['s1']['index_next'] = $this->_sections['s1']['index'] + $this->_sections['s1']['step'];
$this->_sections['s1']['first']      = ($this->_sections['s1']['iteration'] == 1);
$this->_sections['s1']['last']       = ($this->_sections['s1']['iteration'] == $this->_sections['s1']['total']);
?>
					<?php $this->assign('x', $this->_tpl_vars['sm']['arr'][$this->_sections['s1']['index']]);  echo $this->_tpl_vars['x']['1']; ?>
,<?php endfor; endif;  echo '\';
     var json_arrb = arr1.split(",")[0];
     var json_arrb1 = arr1.split(",")[1];
     var json_arrb2 = arr1.split(",")[2];
     var json_arrb3 = arr1.split(",")[3];
     var json_arrb4 = arr1.split(",")[4];
     var json_arrb5 = arr1.split(",")[5];
	var empStatusData = [[\'Full time permanent\',+json_arrb], [\'Terminated\',+json_arrb1],[\'Part time permanent\',+json_arrb1],[\'Internship\',+json_arrb2],[\'Part time contract\',+json_arrb3],[\'Full time contract\',+json_arrb4],[\'Temporary status\',+json_arrb5]];
		var empStatusData = $.jqplot(\'empStatus\', [empStatusData], {
			title:\'Employment Status Pie Chart\',
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
				numberRows: 6
			     },
			    location: \'s\'
			 }
		 });
		$("#empStatusBarPie").html(\'Click here for <a href="javascript:void(0);" onclick="barEmpStatusChart()">Employment Status Bar Chart</a>\');
	 }

	function barEmpStatusChart(){
		$("#empStatus").html(\'\');
  	var arr1 = \'';  unset($this->_sections['s1']);
$this->_sections['s1']['name'] = 's1';
$this->_sections['s1']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['arr']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['s1']['show'] = true;
$this->_sections['s1']['max'] = $this->_sections['s1']['loop'];
$this->_sections['s1']['step'] = 1;
$this->_sections['s1']['start'] = $this->_sections['s1']['step'] > 0 ? 0 : $this->_sections['s1']['loop']-1;
if ($this->_sections['s1']['show']) {
    $this->_sections['s1']['total'] = $this->_sections['s1']['loop'];
    if ($this->_sections['s1']['total'] == 0)
        $this->_sections['s1']['show'] = false;
} else
    $this->_sections['s1']['total'] = 0;
if ($this->_sections['s1']['show']):

            for ($this->_sections['s1']['index'] = $this->_sections['s1']['start'], $this->_sections['s1']['iteration'] = 1;
                 $this->_sections['s1']['iteration'] <= $this->_sections['s1']['total'];
                 $this->_sections['s1']['index'] += $this->_sections['s1']['step'], $this->_sections['s1']['iteration']++):
$this->_sections['s1']['rownum'] = $this->_sections['s1']['iteration'];
$this->_sections['s1']['index_prev'] = $this->_sections['s1']['index'] - $this->_sections['s1']['step'];
$this->_sections['s1']['index_next'] = $this->_sections['s1']['index'] + $this->_sections['s1']['step'];
$this->_sections['s1']['first']      = ($this->_sections['s1']['iteration'] == 1);
$this->_sections['s1']['last']       = ($this->_sections['s1']['iteration'] == $this->_sections['s1']['total']);
?>
					<?php $this->assign('x', $this->_tpl_vars['sm']['arr'][$this->_sections['s1']['index']]);  echo $this->_tpl_vars['x']['1']; ?>
,<?php endfor; endif;  echo '\';
     var json_arrb = arr1.split(",")[0];
     var json_arrb1 = arr1.split(",")[1];
     var json_arrb2 = arr1.split(",")[2];
     var json_arrb3 = arr1.split(",")[3];
     var json_arrb4 = arr1.split(",")[4];
     var json_arrb5 = arr1.split(",")[5];
	var empStatusData = [[\'Full time permanent\',+json_arrb], [\'Terminated\',+json_arrb1],[\'Part time permanent\',+json_arrb1],[\'Internship\',+json_arrb2],[\'Part time contract\',+json_arrb3],[\'Full time contract\',+json_arrb4],[\'Temporary status\',+json_arrb5]];
		var empStatusData = $.jqplot(\'empStatus\', [empStatusData], {
		    title:\'Employment Status Bar Chart\',
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
		                    tickOptions: {show: true, showLabel: false },
		                    showTicks: false }
		          }
		  });
		$("#empStatusBarPie").html(\'Click here for <a href="javascript:void(0);" onclick="pieEmpStatusChart()">Employment Status Pie Chart</a>\');
	 }
	
</script>
'; ?>

<?php if ($this->_tpl_vars['sm']['x']): ?>
	<table>
		<tr>
			<td>
				<div id="empStatus"  style="margin-top:20px; margin-left:20px; width:350px; height:350px; position:relative; z-index:0"></div>
				<div id="empStatusBarPie" style="margin-top:10px;margin-left:20px;"></div>
			</td>
			<td>
				<table>
					<?php unset($this->_sections['s1']);
$this->_sections['s1']['name'] = 's1';
$this->_sections['s1']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['arr']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['s1']['show'] = true;
$this->_sections['s1']['max'] = $this->_sections['s1']['loop'];
$this->_sections['s1']['step'] = 1;
$this->_sections['s1']['start'] = $this->_sections['s1']['step'] > 0 ? 0 : $this->_sections['s1']['loop']-1;
if ($this->_sections['s1']['show']) {
    $this->_sections['s1']['total'] = $this->_sections['s1']['loop'];
    if ($this->_sections['s1']['total'] == 0)
        $this->_sections['s1']['show'] = false;
} else
    $this->_sections['s1']['total'] = 0;
if ($this->_sections['s1']['show']):

            for ($this->_sections['s1']['index'] = $this->_sections['s1']['start'], $this->_sections['s1']['iteration'] = 1;
                 $this->_sections['s1']['iteration'] <= $this->_sections['s1']['total'];
                 $this->_sections['s1']['index'] += $this->_sections['s1']['step'], $this->_sections['s1']['iteration']++):
$this->_sections['s1']['rownum'] = $this->_sections['s1']['iteration'];
$this->_sections['s1']['index_prev'] = $this->_sections['s1']['index'] - $this->_sections['s1']['step'];
$this->_sections['s1']['index_next'] = $this->_sections['s1']['index'] + $this->_sections['s1']['step'];
$this->_sections['s1']['first']      = ($this->_sections['s1']['iteration'] == 1);
$this->_sections['s1']['last']       = ($this->_sections['s1']['iteration'] == $this->_sections['s1']['total']);
?>
					<?php $this->assign('x', $this->_tpl_vars['sm']['arr'][$this->_sections['s1']['index']]); ?>
					<tr>
					    	<td><font size='4'><?php echo $this->_tpl_vars['x']['0']; ?>
</font></td>
						<td> : </td>
						<td><font size='4'><?php echo $this->_tpl_vars['x']['1']; ?>
</font></td>
					</tr>
					<?php endfor; endif; ?>
				</table>
			</td>
		</tr>
	</table>
<?php else: ?>
	<div>Employee not found</div>
<?php endif; ?>

<!-- Template: report/employment_status.tpl.html End --> 