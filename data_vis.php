<?php  //data_vis.php 
//
// Hello World
//
// Copyright (c) 2011 Nagios Enterprises, LLC.  All rights reserved.
//  
// 

require_once(dirname(__FILE__).'/../../common.inc.php');

// initialization stuff
pre_init();
// start session
init_session();
// grab GET or POST variables 
grab_request_vars();
// check prereqs
check_prereqs();
// check authentication
check_authentication(false);

//if you don't need your own html head section with custom CSS and JS, use do_page_start() 
?>
<!DOCTYPE html>
		<html>
			<!-- Produced by Nagios XI.  Copyyright (c) 2008-2009 Nagios Enterprises, LLC (www.nagios.com). All Rights Reserved. -->
			<!-- Powered by the Nagios Synthesis Framework -->

		<head>
		<title>Nagios XI - Data Visualization</title>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		
<?php		do_page_head_links();  ?>
		<style type='text/css'>
		
		</style>
		<script type="text/javascript">
		src="/usr/local/nagiosxi/html/includes/js/jquery/jquery-1.8.2.min.js"></script>
		
		<style>
		body {background:url("background.jpg") no-repeat center center fixed; background-size: cover;}
		</style>
		</head>
		</html>
<?php 

//////////////////////////////////////MAIN//////////////////////////////

route_request(); 

do_page_end(true); 

////////////////FUNCTIONS//////////////

function route_request() {

	$cmd = grab_request_var('cmd','default'); 
	$args = array(); 
	
	switch($cmd) {
	
		case 'submitstuff':
			//this function handles a form submission and returns data for the default display
			$args = submit_stuff();
			//now we can show the default page with some user feedback
			show_default($args); 
		break; 
		
		default:
			show_default($args); 
		break; 
	
	}

}

function submit_stuff() {
	
	//declare globals
	global $cfg; 
	
	//process input variables
	$var = grab_request_var('var',false); 
	$error=false; 
	$msg = "Your stuff is good!"; 
	
	//do function stuff
	if($var=='bad') {
		$error = true;
		$msg = "Your stuff is BAD!"; 
	}

	//pass an array long to the main display function
	$array = array(	'error' => $error,
					'msg' => $msg,
					'misc' => 'Other stuff can go here',
					); 
	return $array; 				
	
} 









?>