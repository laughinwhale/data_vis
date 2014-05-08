<?php  //data_vis.php 
//
// Data Vis
//
// Copyright (c) 2014 Nagios Enterprises, LLC.  All rights reserved.
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
		<script src="/includes/js/bootstrap.min.js"></script>
		<title>Nagios XI - Data Visualization</title>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />	
<?php		do_page_head_links();  ?>
		<style>
		body {background:url("background.jpg") no-repeat center center fixed; background-size: cover;}
		</style>
		</head>
		</html>
<?php 

//////////////////////GRAPHS//////////////////
?>
		<script type='text/javascript' src="graphs.js"></script>
<!-- loads JS defined graphs for display in below div's -->
		<div id="graph1" style="width:800px; height:250px; margin: 0 auto; padding-top:30px;"></div>

<?php
//////////////////////////////////////MAIN//////////////////////////////

route_request(); 

do_page_end(true); 

////////////////FUNCTIONS//////////////

function route_request() {

	$cmd = grab_request_var('cmd','default'); 
	$args = array(); 
	

}


?>