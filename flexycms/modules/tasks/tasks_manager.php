<?php
/**
 * Class   : adminstration_manager
 * Purpose : All administration coding done here. 
 */
class tasks_manager extends mod_manager {
#######################################################################################################
### Function Name : adminstration_manager	  						    ###
### Description   : This is a constructor 							    ###					 
### Input         : Reference of smarty,input and output parameters 	  			    ###
### Output	  : Initiates mod manager and initialize object and business class for user manager ###
#######################################################################################################
	function tasks_manager (& $smarty, & $_output, & $_input) {
		if($_REQUEST['ce']!='0'){
			if(!(($_REQUEST['choice'] =='cronJobNotification') || ($_REQUEST['choice'] =='cronJobReminder'))){
	    			check_session();
	    		}
	    	}else{
			//for autocomplete and fancybox
	    		if(!$_SESSION['id_user'] && $_REQUEST['for']=='auto'){
				exit("<span class='fcolor'>".getmessage('COM_NO_SESSION')."</span>|abc::".getmessage('COM_NO_SESSION'));
			}elseif(!$_SESSION['id_user'] && $_REQUEST['for']=='norauto'){
	    			exit("<span class='fcolor'>".getmessage('COM_NO_SESSION')."</span>|".getmessage('COM_NO_SESSION'));
	    		}elseif(!$_SESSION['id_user']){
	    			exit("<span class='fcolor'>".getmessage('COM_NO_SESSION')."Please <a href='javascript:void(0);' onclick=check_JSsession('nosession',0); style='text-decoration : underline;'>click</a> here to log in again</span>");
	    		}
	    	}
		$this->mod_manager($smarty, $_output, $_input, 'tasks');
  		$this->obj_tasks= new tasks;

		$this->tasks_bl = new tasks_bl;
 	}
#########################################################################################
### Function Name : get_module_name(Predefined Function)			      ###
#########################################################################################
	function get_module_name() { 
		return 'tasks';
	}
#########################################################################################
### Function Name : get_manager_name(Predefined Function) 			      ###
#########################################################################################
	function get_manager_name() {
		return 'tasks';
	}
#########################################################################################
### Function Name : default(Predefined Function) 		  		      ###
### Description   : Handle default request(if no choice specified)                    ###
#########################################################################################
	function _default() {
		return true;
	}
#########################################################################################
### Function Name : manager_error_handler					      ###
### Description   : Function to handle error when choice not found                    ###
### Input         : No input 						   	      ###
### Ouput         : Error handling template.		         		      ###
#########################################################################################
	function manager_error_handler() {
		$call = "_".$this->_input['choice'];
		if (function_exists($call)) {
			$call($this);
		} else {
			//Put your own error handling code here
			$this->_output['tpl'] ='default/error_handler';
		}
	}
	

function _tasks($id=''){

$employee=$_SESSION['id_employee'];
$sql_property="select ta.id_tasks,ta.task_name,ta.task_description,ta.task_date,ta.modified_date from ".TABLE_PREFIX."tasks ta where ta.id_employee=".$employee;
//echo $sql_property;
$res=getrows($sql_property,$err);
//print_r($res);
$this->_output['list']=$res;
$this->_output['tpl']="tasks/employeetasklist";
	}
	
function _addtask()
{     $this->_output['date']=date("d-m-Y");
      $this->_output['datesql']=date("Y-m-d");
      $this->_output['tpl']="tasks/addtask";
}


function _insertEmployeeTask()
{
$arr['task_name']=$this->_input['task']['name'];
$arr['task_description']=$this->_input['task']['description'];
$arr['task_date']=$this->_input['task']['date'];
$arr['id_employee']=$_SESSION['id_employee'];
$sql_property="select * from ".TABLE_PREFIX."tasks ta where task_date='".$arr['task_date']."' and ta.id_employee=".$arr['id_employee'];
$res=getindexrows($sql_property,$err);
 if($res)
 {
  $msg="Task has beed added already for this particular date";
 print "<script>callmsg('".$msg."');</script>";
 $this->_tasks($_SESSION['id_company']);
  //$this->_output['tpl']="tasks/addtask";
 }
 else
 {
$this->obj_tasks->insert($arr,"tasks");
$msg=getmessage('COM_INS_SUCC');
print "<script>callmsg('".$msg."');</script>";
$this->_tasks($_SESSION['id_company']);
  //$this->_output['tpl']="tasks/addtask";
 }
}

function _edittask()
{
$employee=$_SESSION['id_employee'];
$sql_property="select ta.id_tasks,ta.task_name,ta.task_description,ta.task_date from ".TABLE_PREFIX."tasks ta where id_tasks=".$this->_input['id']." and ta.id_employee=".$employee;

$res=getsingleindexrow($sql_property,$err);
  $this->_output['date']=date("d-m-Y");
$this->_output['datesql']=date("Y-m-d");
$this->_output['edit_task']=$res;
$this->_output['tpl']="tasks/addtask";
}

function _updateEmployeeTask(){

 $arr['task_name']=$this->_input['task']['name'];
 $arr['task_description']=$this->_input['task']['description'];
 $arr['modified_date']=date('Y-m-d');
 $this->obj_tasks->update("tasks",$arr,"id_tasks=".$this->_input['task']['temp_id']);
 $msg=getmessage('COM_UPD_SUCC');
 print "<script>callmsg('".$msg."');</script>";
 $this->_tasks();
 }
 
 function _taskdetails($x=1)
 {
 $sql_property="select ta.id_tasks,ta.task_name,ta.task_description,ta.task_date,ta.modified_date,concat(e.firstname,' ',e.lastname) as firstname from  ".TABLE_PREFIX."tasks ta,".TABLE_PREFIX."employee e where task_date between date_sub(now(),interval 7 day) and curdate() and e.id_employee=ta.id_employee";
 	$uri = 'index.php/tasks/taskdetails';
      	$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Task List";
		$this->_output['field'] = array("firstname"=>array("Employee Name", 1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql_property;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "firstname";
  		$this->_input['qstart']=$this->_input['qstart'];
		if(isset($this->_input['qstart']) || $x){
			$this->_input['choice']='taskdetails';
			$this->tasks_bl->page_listing($this,"tasks/tasklist");
        }
 }
}//end of class
