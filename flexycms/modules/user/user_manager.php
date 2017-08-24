<?php
/*
 * Class   : user_manager
 * Purpose : All company and employee login functionalities goes here
 */
class user_manager extends mod_manager {
#######################################################################################################
### Function Name : user_manager										  							###
### Description   : This is a constructor which  													###					 
### Input         : Reference of smarty,input and output parameters 	  							###
### Output		  : Initiates mod manager and initialize object and business class for user manager ###
#######################################################################################################
	function user_manager (& $smarty, & $_output, & $_input) {
		$this->mod_manager($smarty, $_output, $_input, 'user');
		$this->obj_user = new user;
		$this->user_bl = new user_bl;
 	}
 	
############################################################
### Function Name : get_module_name(Predefined Function) ###
############################################################
	function get_module_name() {
		return 'user';
	}

#############################################################
### Function Name : get_manager_name(Predefined Function) ###
#############################################################
	function get_manager_name() {
		return 'user';
	}

######################################################################
### Function Name : manager_error_handler						   ###
### Description   : Function to handle error when choice not found ###
### Input         : No input 						   			   ###
### Ouput		  : Error handling template.					   ###
######################################################################
	function manager_error_handler() {
		$call = "_".$this->_input['choice'];
		if (function_exists($call)) {
			$call($this);
		} else {
			//Put your own error handling code here
			$this->_output['tpl'] ='default/error_handler';
		}
	}
####################################################
### Function Name : default(Predefined Function) ###
### Description   : Handle default request 		 ###
####################################################
	function _default() {
		$this->_loginForm();
	}
#####################################################################
### Function Name : _phpinfo(Function to show php info of server) ###
#####################################################################
	function _phpinfo(){
		phpinfo();
	}
######################################################################################
### Function Name : loginForm													   ###
### Description   : Function to check for company/employee log in to system or not ###
######################################################################################
	function _loginForm(){
		setcookie('refer', $this->_input['refer'], time()+60*60*24*365, "/");
		$login = 1;
		if(isset($_COOKIE['username']) && isset($_COOKIE['password'])){
			$login = $this->getCheckCookie();
		}elseif($_SESSION['id_company'] && !$_SESSION['id_admin']) {
			redirect(LBL_SITE_URL."index.php/companyDashboard");
		}elseif($_SESSION['id_employee'] && !$_SESSION['id_admin']) {
			redirect(LBL_SITE_URL."index.php/employee/employeeDetail");
		}
	}
#########################################################################
### Function Name : getUserDetail									  ###
### Description   : Function to return user(company/employee) details ###
### Input         : $name(cookie username as set during log in) 	  ###
### Output		  : Result array of user   							  ###
#########################################################################
	function getUserDetail($name){
		global $link;
		$res_company = getsingleindexrow('CALL get_search_sql("'.TABLE_PREFIX.'company","email_id = \''.$name.'\' AND isactive = 1 LIMIT 1")');
		if($res_company) {
			$res_company['is_company'] = 1;
			$res_company['username'] = $res_company['email_id'];
  			return $res_company;
		}else {
			$sql_emp = "SELECT * FROM (SELECT E.*,ETC.terminate_date FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee) AS TE WHERE IF(terminate_date!='',terminate_date > NOW(),1) AND username = '".$name."' LIMIT 1";
			$res_emp = getsingleindexrow($sql_emp);
			if($res_emp) {
				return $res_emp;
			}else {
				return 0;
			}			
		}
	}

#########################################################################
### Function Name : setLogin									  	  ###
### Description   : Function to return user(company/employee) details ###
### Input         : $name(cookie username as set during log in) 	  ###
### Output		  : Result array of user   							  ###
#########################################################################
	function _setLogin($name="",$pass="") {
		if($_SESSION['id_user'])
			redirect(LBL_SITE_URL);
		global $link;
		if($name && $pass) {
			$uname = $name;
			$pwd = MD5($pass);
		}else {
			$uname = $this->_input['username'];
			$upwd = $this->_input['password'];
			$pwd = MD5($upwd);
		}

		//For Server Side Validation(When Javascript disable)
		$admin_url =  $this->_input['admin_st']; 
		if (empty($uname)||empty($pwd)){
			$_SESSION['raise_message']['global']=getmessage('USER_LOGIN');
			if($admin_url) {
				redirect(LBL_ADMIN_SITE_URL."index.php");
			}else {
				redirect(LBL_SITE_URL);
			}
		}//end

		//Checking For Company And Employee Record Exist Or Not
		$result= $this->getUserDetail($uname);
		//print_r($result);
		//exit;
		if($result != 0){
			if(($uname === $result['username']) && ($pwd === $result['password'])) {
				//Start Of Remember Me
				if($this->_input['rem']){
					$id_user = $result['is_company'] ? $result['id_company'] : $result['id_employee'];
					$info = array(
						'autologin' => 1,
						'id_user' 	=> $id_user,
						'username' 	=> $result['username'],
						'email' 	=> $result['username'],
						'password' 	=> $result['password']
						
					);
					$this->setAutoLogin($info);
				}//End
				if($result['is_company']){
					$_SESSION['id_company']=$result['id_company'];
					$_SESSION['id_user'] = $result['id_company'];
					$_SESSION['id_userdetails'] = $result['id_userdetails'];
					//echo "session" .$_SESSION['id_userdetails'];
					//exit;
					$_SESSION['username'] = $result['email_id'];
					$_SESSION['displayname']=$result['displayname'];
					$_SESSION['company_name'] = $result['company_name'];
					$_SESSION['logo'] = $result['id_company']."_".$result['logo'];
					$_SESSION['last_login'] = $result['last_login'];
					$_SESSION['ip'] = $result['ip'];

					$this->obj_user->lastLogin("company","id_company=".$result['id_company']);
					redirect(LBL_SITE_URL."index.php/companyDashboard");
				}else {
					if($result['random_num']=='0') {
						$_SESSION['id_employee'] = $result['id_employee'];
						$_SESSION['id_user'] = $result['id_employee'];
						$_SESSION['username'] = $result['username'];
						$_SESSION['firstname'] = $result['firstname'];
						// Employee's company information						
						$res_company = getsingleindexrow('CALL get_search_sql("'.TABLE_PREFIX.'company","id_company = \''.$result['id_company'].'\' LIMIT 1")');
						
						$_SESSION['company_name'] = $res_company['company_name'];
						$_SESSION['logo'] = $res_company['id_company']."_".$res_company['logo'];
						//end
						$this->obj_user->lastLogin("employee","id_employee=".$result['id_employee']);
						redirect(LBL_SITE_URL."index.php/employee/employeeDetail");
					}else{
						$_SESSION['raise_message']['global'] = getmessage('USER_MAIL_CONF');
						redirect(LBL_SITE_URL);
					}
				}
			}else {
				$_SESSION['raise_message']['global'] =getmessage('USER_PASS_CONF');
				if($admin_url) {
					redirect(LBL_ADMIN_SITE_URL."index.php");
				}else {
					redirect(LBL_SITE_URL);
				}
			}
		}else {
			$_SESSION['raise_message']['global'] = getmessage('USER_LOGIN');
			if($admin_url) {
				redirect(LBL_ADMIN_SITE_URL);
			}else {
				redirect(LBL_SITE_URL);
			}
		}
	}
	
############################################################################
### Function Name : setAutoLogin										 ###
### Description   : Function to set cookie for remember me functionality ###
### Input         : $info(Array with user(company/employee) information) ###
### Output		  : Set cookie for browser								 ###
############################################################################
	function setAutoLogin($info){
                $random = rand(2,10);
		$substring = substr($info['password'], 0, $random);
		$substring_encoded = base64_encode($substring);
		$v_user_password = md5($info['id_user'].$info['username'].$info['password']);

		setcookie('email', $info['email'], time()+60*60*24*365, "/");
		setcookie('username',$info['username'], time()+60*60*24*365, "/");
		setcookie('password', $v_user_password, time()+60*60*24*365, "/");
		setcookie('id_user', $info['id_user'], time()+60*60*24*365, "/");
	}
################################################################
### Function Name : getCheckCookie			     ###
### Description   : Function to check cookies are set or not ###
################################################################
	function getCheckCookie(){
		global $link;
		$result = $this->getUserDetail($_COOKIE['username']);
		if($result != 0){
			if($result['is_company'] == 1){
				$result['id_user'] =$result['id_company'];
				$result['email']   =$result['email_id'];
				$result['username']=$result['email_id'];
			}else{
				$result['id_user']=$result['id_employee'];
				$result['email']=$result['username'];
			}
			$checkpass=md5($result['id_user'].$result['username'].$result['password']);
			$substring = base64_encode($_COOKIE['v_sub_str']);
			$v_user_password = str_replace($substring,'',$_COOKIE['password']);
			if ($checkpass === $v_user_password) {							
				if($result['is_company']){
					$_SESSION['id_company']=$result['id_company'];
					$_SESSION['id_user'] = $result['id_company'];
					$_SESSION['username'] = $result['email_id'];
					$_SESSION['company_name'] = $result['company_name'];
					$_SESSION['logo'] = $result['id_company']."_".$result['logo'];
					$_SESSION['last_login'] = $result['last_login'];
					$_SESSION['ip'] = $result['ip'];
					redirect(LBL_SITE_URL."index.php/companyDashboard");
				}else{
					$_SESSION['id_employee'] = $result['id_employee'];
					$_SESSION['id_user'] = $result['id_employee'];
					$_SESSION['username'] = $result['username'];
					// Employee's company information
					$res_company = getsingleindexrow('CALL get_search_sql("'.TABLE_PREFIX.'company","id_company = \''.$result['id_company'].'\' LIMIT 1")');
					$_SESSION['company_name'] = $res_company['company_name'];
					$_SESSION['logo'] = $res_company['id_company']."_".$res_company['logo'];
					redirect(LBL_SITE_URL."index.php/employee/employeeDetail");
				}
			}
		}else {
			redirect(LBL_SITE_URL);
		}
	}
#############################################################
### Function Name : companyDashboard					  ###
### Description   : Function to display company dashboard ###
### Output		  : Template for company dashboard		  ###
#############################################################
	function _companyDashboard() {
		check_session();
		$this->_output['tpl']='user/companyDashboard';
	}

###################################################################
### Function Name : welcomeCompany					  			###
### Description   : Function to display Company Welcome Message ###
### Output		  : Template for Company Welcome Message 	    ###
###################################################################
	function _welcomeCompany() {
		check_session();
		$_SESSION['wel_flag'] = 0;
		$this->_output['tpl']='static/welcomeCompany';
	}
	
##############################################################
### Function Name : employeeDashboard					   ###
### Description   : Function to display employee dashboard ###
### Output		  : Template for employee dashboard		   ###
##############################################################
	function _employeeDashboard() {
		check_session();
		$this->_output['tpl']='user/employeeDashboard';
	}

########################################################
### Function Name : forgotPwd					     ###
### Description   : Function to show forgot password ###
### Output		  : Template for forgot password     ###
########################################################
	function _forgotPwd() {
		if($_SESSION['id_user']) {
			redirect(LBL_SITE_URL);
		}else{
			$this->_output['tpl']='user/forgotPwd';
		}
	}

#############################################################################
### Function Name : getForgotPwd				       					  ###
### Description   : Function to handle forgot password 					  ###
### Input         : Username from form input		   					  ###
### Output		  : Mail to user(company/employee) to reset password link ###
#############################################################################
	function _getForgotPwd() {
		$username = $this->_input['username'];
		if($username) {
			$result = $this->getUserDetail($username);
			if($result != 0) {				
				$info['name'] = $result['is_company'] ? $result['company_name'] : $result['firstname']." ".$result['lastname'];
				$uid          = $result['is_company'] ? $result['id_company'] : $result['id_employee'];
				$user_type    = $result['is_company'] ? "c" : "e";
				$to  = $result['username'];				
				$from = $GLOBALS['conf']['SITE_ADMIN']['email'];
				$subject="Forgot password \n\n";				
				$info['link'] = LBL_SITE_URL.'index.php/user/resetPwd/uid-'.md5($uid)."-utype-".$user_type;			
				$tpl = "user/forgotPassword";
				$this->smarty->assign('sm',$info);
				$body = $this->smarty->fetch($this->smarty->add_theme_to_template($tpl));
				$msg = sendmail($to,$subject,$body,$from);// also u can pass  $cc,$bcc
				$_SESSION['raise_message']['global'] = getmessage('USER_FORGOT_PASS');
				redirect(LBL_SITE_URL);
			}else {
				$_SESSION['raise_message']['global'] = getmessage('USER_ACCOUNT');
				redirect(LBL_SITE_URL);
			}
		}else {
			$_SESSION['raise_message']['global'] = getmessage('USER_UNAME');
			redirect(LBL_SITE_URL.'user/forgotPwd');
		}
	}

#######################################################
### Function Name : resetPwd					    ###
### Description   : Function to show reset password ###
### Input         : Username from url link		    ###
### Output		  : Template for reset password     ###
#######################################################
	function _resetPwd(){
		$this->_output['uid'] = $this->_input['uid'];
		$this->_output['utype']    = $this->_input['utype'];
		$this->_output['tpl']      = 'user/resetPwd';
	}

###############################################################
### Function Name : changePwd					    		###
### Description   : Function to show reset password 		###
### Input         : Form input								###
### Output		  : Updated user(company/employee) password ###
###############################################################
	function _changePwd(){
		$res = $this->obj_user->changePwd($this->_input['pwd']);
		$_SESSION['raise_message']['global'] = getmessage('USER_RESET_PASS');
		redirect(LBL_SITE_URL);
	}

####################################################################
### Function Name : checkUser					    			 ###
### Description   : Function for confirmation of employee		 ###
### Input         : random number created during adding employee ###
### Output		  : Confirmation of employee					 ###
####################################################################
	function _checkUser(){
		global $link;
		if($_SESSION['id_company']){
			$_SESSION['raise_message']['global']=  getmessage('USER_LOGIN_CONF_FAIL');
			redirect(LBL_SITE_URL);	
		}
		$res 	= getsingleindexrow('CALL get_search_sql("'.TABLE_PREFIX.'employee","random_num = \''.$this->_input['confirm'].'\' LIMIT 1")');
		if($res){
			$sql_update="UPDATE ".TABLE_PREFIX."employee SET random_num='0' WHERE id_employee='".$res['id_employee']."'";
			execute($sql_update,$err);
			$_SESSION['wel_flag_emp'] = 1;
			$name = $res['username'];
			$pass = $res['password'];
			$this->_setLogin($name,$pass);
		}else{
			$_SESSION['raise_message']['global']=  getmessage('USER_LOGIN_CONF');
			redirect(LBL_SITE_URL);	
		}		
	}
##########################################################################
### Function Name : logout					    					   ###
### Description   : Function to unset all session and cookie variables ###
##########################################################################
	function _logout(){
		$site = $_SESSION['site_used'];
		setcookie('username', '', time()-60*60*24*365,"/");
		setcookie('password','', time()-60*60*24*365,"/");	
		setcookie('email', '', time()-60*60*24*365,"/");
		setcookie('id_user','', time()-60*60*24*365,"/");		
		$_COOKIE = array('');
		
		$_SESSION = array('');
		unset($_SESSION);
		session_unset();
		session_destroy();
		
		session_start();
		if($this->_input['noses']) {	
			$_SESSION['raise_message']['global'] = getmessage('COM_NO_SESSION');
		}else{
			$_SESSION['raise_message']['global'] = getmessage('USER_LOGOUT');
		}
		if($this->_input['a']) {		
			redirect(LBL_ADMIN_SITE_URL."index.php");
		}else {
			redirect(LBL_SITE_URL);
		}
	}


######################################################
########Set language session #########################
######################################################
	function _setlang() {
		$_SESSION['multi_language']=$this->_input['lang']?$this->_input['lang']:'';
		if ($_SERVER['HTTP_REFERER']) {
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			redirect(LBL_SITE_URL);
		}
	}
	
		function _modulemenu(){
		//$this->_output['uid'] = $this->_input['uid'];
		//$this->_output['utype']    = $this->_input['utype'];
		$this->_output['tpl']      = 'common/menu';
	}
}
