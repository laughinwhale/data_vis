<?php 
// HELLO WORLD COMPONENT
//
// Copyright (c) 2010 Nagios Enterprises, LLC.  All rights reserved.
//  
// $Id: data_vis.inc.php 115 2010-08-16 16:15:26Z mguthrie $

//include the helper file
require_once(dirname(__FILE__).'/../componenthelper.inc.php');


/**
*	BEWARE, EVERYTHING YOU DO IN THIS FILE IS IN THE GLOBAL SCOPE OF XI. 
*	Syntax errors here will break most pages in XI. 
*	Prepend all function names with the component name to prevent duplicates
*	Don't create new global variables if possible, keep them all local to functions
*/ 


//echo $myemptyvar; 

// respect the name
$data_vis_component_name="data_vis";

// run the initialization function
data_vis_component_init();

////////////////////////////////////////////////////////////////////////
// COMPONENT INIT FUNCTIONS
////////////////////////////////////////////////////////////////////////

function data_vis_component_init(){
	global $data_vis_component_name;
	
	//boolean to check for latest version
	$versionok=data_vis_component_checkversion();
	
	//component description
	$desc=gettext("This component allows for greater data visualization functionality. ");
	
	if(!$versionok)
		$desc="<b>".gettext("Error: This component requires Nagios XI 2012R2.8C or later.")."</b>";
	
	//all components require a few arguments to be initialized correctly.  
	$args=array(

		// need a name
		COMPONENT_NAME => $data_vis_component_name,
		COMPONENT_VERSION => '1.0', 
		COMPONENT_DATE => '04/16/2014',

		// informative information
		COMPONENT_AUTHOR => "Sam Lansing. Nagios Enterprises, LLC",
		COMPONENT_DESCRIPTION => $desc,
		COMPONENT_TITLE => "Data Visualization",

		// configuration function (optional)
		COMPONENT_CONFIGFUNCTION => "data_vis_component_config_func",
		);
	
	//register this component with XI 
	register_component($data_vis_component_name,$args);
	
	// register the addmenu function
	if($versionok)
		register_callback(CALLBACK_MENUS_INITIALIZED,'data_vis_component_addmenu');
		register_callback(CALLBACK_SERVICE_TABS_INIT,'data_vis_component_addtab');
		register_callback(CALLBACK_HOST_TABS_INIT,'data_vis_component_addtab');
	}
	



///////////////////////////////////////////////////////////////////////////////////////////
// MISC FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////////////

function data_vis_component_checkversion(){

	if(!function_exists('get_product_release'))
		return false;
	//requires greater than 2012R2.8C
	if(get_product_release()<114)
		return false;

	return true;
	}
	
function data_vis_component_addmenu($arg=null){
	global $data_vis_component_name;
	//retrieve the URL for this component
	$urlbase=get_component_url_base($data_vis_component_name);
	//figure out where I'm going on the menu	
	$mi=find_menu_item(MENU_HOME,"menu-home-all-host-graphs","id");
	if($mi==null) //bail if I didn't find the above menu item 
		return;
		
	$order=grab_array_var($mi,"order","");  //extract this variable from the $mi array 
	if($order=="")
		return;
		
	$neworder=$order+0.1; //determine my menu order 

	//add this to the main home menu 
	add_menu_item(MENU_HOME,array(
		"type" => "link",
		"title" => gettext("Data Visualization"),
		"id" => "menu-home-data_vis",
		"order" => $neworder,
		"opts" => array(
			//this is the page the menu will actually point to.
			//all of my actual component workings will happen on this script
			"href" => $urlbase."/data_vis.php",      
			)
		));

}

////////////////////////////////////////////////////////////////////////
// CONFIG FUNCTION
////////////////////////////////////////////////////////////////////////

function data_vis_component_config_func($mode="",$inargs,&$outargs,&$result){

	// initialize return code and output
	$result=0;
	$output="";
	
	$component_name="data_vis";
	
	switch($mode){
		case COMPONENT_CONFIGMODE_GETSETTINGSHTML:
		
			//all settings for this component contained in one storage array
			$settings_raw=get_option("data_vis_options");
			if(empty($settings_raw))
				$settings=array();
			else	//serialize turns an array into a string, and unserialize turns it back into an array
				$settings=unserialize($settings_raw);
				
			// initial values
			$opt=grab_array_var($settings,"opt","myoption");
			
			// values passed to us from form
			$opt=grab_array_var($inargs,"opt",$opt);


			$component_url=get_component_url_base($component_name);

			$output='
			
	<div class="sectionTitle">'.gettext('Hello World Settings').'</div>
	
	<table>

	<tr>
	<td valign="top">
	<label for="enabled">'.gettext('Enable Hello World').':</label><br class="nobr" />
	</td>
	<td>
	<input type="checkbox" class="checkbox" id="opt" name="opt" '.is_checked($opt,"on").'>
<br class="nobr" />
	'.gettext('Enables display of the hello world in the Nagios XI interface...actually it doesnt, you cant escape the hello world component muahahaha!').'<br><br>
	</td>
	</tr>

	</table>

			';
			break;
			
		case COMPONENT_CONFIGMODE_SAVESETTINGS:
		
			// get variables
			$opt=grab_array_var($inargs,"opt","");
			
			// validate variables
			/** no validation necessary here
			$errors=0;
			$errmsg=array();
			if($enabled==1){
				if(have_value($logo)==false){
					$errmsg[$errors++]="No logo image specified.";
					}
				if(have_value($logo_url)==false){
					$errmsg[$errors++]="No target URL specified.";
					}
				}
			
			// handle errors
			if($errors>0){
				$outargs[COMPONENT_ERROR_MESSAGES]=$errmsg;
				$result=1;
				return '';
				}
			*/ //end validation 
			
			// save settings
			$settings=array(
				"opt" => $opt,
				);
			set_option("data_vis_options",serialize($settings));
						
			break;
		
		default:
			break;
			
	}
		
	return $output;
}	




///////////////////////////CALLBACK FUNCTIONS/////////////////////////

/**
*	callback function that passes new tab data to the host/service details tabs
*	@param string $cbtype: the callback type, host or service tab?
*	@param mixed $cbdata: REFERENCE variable to the callback array, used as a storage array to push data into
*	@return null
*/ 
function data_vis_component_addtab($cbtype,&$cbdata){

	// get host/service name
	$hostname=grab_array_var($cbdata,"host");
	$servicename=grab_array_var($cbdata,"service",false);
	
	//array_dump($cbdata); 

	$content="";
	
	$content.="<div> Hello world Host: ".htmlentities($hostname)."</div>\n"; 
	if($servicename)
		$content.="<div> Hello world Service: ".htmlentities($servicename)."</div>\n";
	

	//build a new entry for the callback array
	$newtab=array(
		"id" => "data_vis",
		"title" => "Hello World",
		"content" => $content,
		);

	// add new tab
	$cbdata["tabs"][]=$newtab;
}

//don't put a closing tag in this filee
//ESPECIALLY don't put closing tags + line breaks, you'll break stuff 
