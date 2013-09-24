<?php
	/*  --------------------------------
	 *  We use the session on this page 
	 *  --------------------------------*/
	if (!isset($_SESSION["security-level"])){
		session_start();
	}// end if

	/* ----------------------------------------
	 *	initialize security level to "insecure"
	 * ----------------------------------------*/
	if (!isset($_SESSION['security-level'])){
		$_SESSION['security-level'] = '0';
	}// end if
	
	/* ------------------------------------------
	 * Constants used in application
	 * ------------------------------------------ */
	require_once('../../includes/constants.php');
	require_once('../../includes/minimum-class-definitions.php');

	try{
		
		$lVerb = $_SERVER['REQUEST_METHOD'];
		
		switch($lVerb){
			case "GET":
							
				break;
			case "POST":
				break;
			case "PUT":
				break;
			case "DELETE": 
				break;
			default:
				throw new Exception("Could not understand HTTP REQUEST_METHOD verb");
				break;
		}// end switch
		
	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatErrorJSON($e, "Unable to process request to web service ws-user-account");
	}// end try;
	
?>