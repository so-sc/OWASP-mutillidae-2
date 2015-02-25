<?php 
	try{
    	switch ($_SESSION["security-level"]){
    		case "0": // This code is insecure
    		case "1": // This code is insecure
				$lProtectAgainstMethodTampering = FALSE;
				$lEncodeOutput = FALSE;
			break;
	    		
			case "2":
			case "3":
			case "4":
    		case "5": // This code is fairly secure
				$lProtectAgainstMethodTampering = TRUE;
				$lEncodeOutput = TRUE;
			break;
    	};//end switch

    	$lParameterSubmitted = FALSE;
		if (isset($_GET["page-title"]) || isset($_POST["page-title"]) || isset($_REQUEST["page-title"])) {
			$lParameterSubmitted = TRUE;
		}// end if

		$lPageTitle = "Styling with Mutillidae";
		if ($lParameterSubmitted){
	    	if ($lProtectAgainstMethodTampering) {
				$lPageTitle = $_GET["page-title"];
	    	}else{
				$lPageTitle = $_REQUEST["page-title"];
	    	};// end if $lProtectAgainstMethodTampering
	    	
	    	if($lEncodeOutput){
	    		$lPageTitle = $Encoder->encodeForHTML($lPageTitle);
	    	};// end if	    	
		};// end if $lFormSubmitted

   	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatError($e, $lQueryString);
   	};// end try;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./styles/global-styles.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<title><?php echo $lPageTitle?></title>
</head>
<body>
	<table style="margin-left:auto; margin-right:auto;">
		<tr><td>&nbsp;</td></tr>
		<tr><td><div class="page-title"><?php echo $lPageTitle?></div></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td colspan="2" class="form-header">
				This page implements Path Relative Style Sheet Injection
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td class="informative-message">
			Hint: Toggle through the security levels. What happens at security level 5?<br/>
			Is there a new HTTP header at security level 5? Burp-Suite might be useful.
			</td>
		</tr>
		<tr>
			<td>
				<div style="text-align: center;">
					<img src="./images/coykillericon.png" width="65px" height="50px" style="vertical-align: middle;" />
					&nbsp;&nbsp;
					<a href="index.php" style="text-decoration: none; font-weight: bold; font-size: 18pt;">Return to Mutillidae</a>
				</div>
			</td>
		</tr>
		<tr><td></td></tr>
	</table>
</body>
</html>