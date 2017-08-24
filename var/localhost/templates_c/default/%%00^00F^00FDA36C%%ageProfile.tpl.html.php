<?php /* Smarty version 2.6.7, created on 2017-08-24 10:48:54
         compiled from report/ageProfile.tpl.html */ ?>

<!-- Template: report/ageProfile.tpl.html Start 24/08/2017 10:48:54 --> 
 <?php echo '
<link rel="stylesheet" type="text/css" href="http://localhost/simplehrm/templates/css_theme/jquery.jqplot.css" />
<!-- BEGIN: load jqplot -->
<script language="javascript" type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/jquery.jqplot.js"></script>
<script language="javascript" type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/jqplot.pieRenderer.js"></script>
<script language="javascript" type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/jqplot.categoryAxisRenderer.js"></script>
<script language="javascript" type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/jqplot.barRenderer.js"></script>

<script type="text/javascript" src="http://localhost/simplehrm/libsext/jquery/json.js"></script>
<!-- END: load jqplot -->
<script type="text/javascript">
	$(document).ready(function(){
		var arr = \'';  echo $this->_tpl_vars['sm']['x'];  echo '\';
		if(arr)
			barAgeChart();
		else
			return true;
	 });
	function pieAgeChart(){
		$("#ageProfile").html(\'\');
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
	var ageData = [[\'18-25\',+json_arrb], [\'26-35\',+json_arrb1],[\'26-35\',+json_arrb1],[\'36-45\',+json_arrb2],[\'46-55\',+json_arrb3],[\'56-65\',+json_arrb4],[\'66-up\',+json_arrb5]];
		var agePlot = $.jqplot(\'ageProfile\', [ageData], {
			title:\'Age Pie Chart\',
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
    fill: false,
          showDataLabels: true,
          // Add a margin to seperate the slices.
          sliceMargin: 4,
          // stroke the slices with a little thicker line.
          lineWidth: 5
			     }
			 },
			legend: {
			    show: true,
			    rendererOptions: {
				numberRows: 2
			     },
			    location: \'s\'
			 }
		 });
		$("#ageBarPie").html(\'Click here for <a href="javascript:void(0);" onclick="barAgeChart()">Age Bar Chart</a>\');
	 }

	function barAgeChart(){
		$("#ageProfile").html(\'\');
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
        var ageData = [[\'18-25\',+json_arrb], [\'26-35\',+json_arrb1],[\'26-35\',+json_arrb1],[\'36-45\',+json_arrb2],[\'46-55\',+json_arrb3],[\'56-65\',+json_arrb4],[\'66-up\',+json_arrb5]];
		var agePlot = $.jqplot(\'ageProfile\', [ageData], {
   		    title:\'Age Bar Chart\',
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
		$("#ageBarPie").html(\'Click here for <a href="javascript:void(0);" onclick="pieAgeChart()">Age Pie Chart</a>\');
	 }
</script>
'; ?>

<?php if ($this->_tpl_vars['sm']['x']): ?>
	<table>
		<tr>
			<td>
				<div id="ageProfile" style="margin-top:20px; margin-left:20px; width:330px; height:370px; position:relative; z-index:0;"></div>
				<div id="ageBarPie" style="margin-top:10px;margin-left:20px;"></div>
			</td>
			</tr>

   	<tr><td align=center>
			<font size='2'>

        <div class="smlest_box">
                <div class="top"></div>
                <div class="mdl">
                        <div class="clear"></div>
                        <div class="a_cont wid84smlst">
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
				<?php echo $this->_tpl_vars['x']['0']; ?>
 :&nbsp;<?php echo $this->_tpl_vars['x']['1']; ?>
<br>
					<?php endfor; endif; ?>

                        </div>
                </div>
                <div class="btm"></div>
        </div>

		</tr>
	</table>
<?php else: ?>
	<div>Employee not found</div>
<?php endif; ?>

<!-- Template: report/ageProfile.tpl.html End --> 