<?php
	if($_SESSION['loggedin'] == "True"){

		switch ($_SESSION["security-level"]){
	   		case "0": // This code is insecure
				$logged_in_user = $_SESSION['logged_in_user'];
				$logged_in_usersignature = $_SESSION['logged_in_usersignature'];
				$lSecurityLevelDescription = "Hosed";
	   		break;
	   		case "1": // This code is insecure
	   			// DO NOTHING: This is equivalent to using client side security		
				$logged_in_user = $_SESSION['logged_in_user'];
				$logged_in_usersignature = $_SESSION['logged_in_usersignature'];
				$lSecurityLevelDescription = "Arrogent";
	   		break;
		    
	   		case "2":
	   		case "3":
	   		case "4":
	   		case "5": // This code is fairly secure
	  			/* 
	  			 * NOTE: Input validation is excellent but not enough. The output must be
	  			 * encoded per context. For example, if output is placed in HTML,
	  			 * then HTML encode it. Blacklisting is a losing proposition. You 
	  			 * cannot blacklist everything. The business requirements will usually
	  			 * require allowing dangerous charaters. In the example here, we can 
	  			 * validate username but we have to allow special characters in passwords
	  			 * least we force weak passwords. We cannot validate the signature hardly 
	  			 * at all. The business requirements for text fields will demand most
	  			 * characters. Output encoding is the answer. Validate what you can, encode it
	  			 * all.
	  			 */
	   			// encode the entire message following OWASP standards
	   			// this is HTML encoding because we are outputting data into HTML
				$logged_in_user = $Encoder->encodeForHTML($_SESSION['logged_in_user']);
				$logged_in_usersignature = $Encoder->encodeForHTML($_SESSION['logged_in_usersignature']);
				$lSecurityLevelDescription = "Secure";
			break;
	   	}// end switch		

	   	$lUserAuthorizationLevelText = 'User';
	   	if ($_SESSION['is_admin'] == 'TRUE'){
	   		$lUserAuthorizationLevelText = 'Admin';
	   	}// end if

		$lAuthenticationStatusMessage = 
				'Logged In ' . 
				$lUserAuthorizationLevelText . ": " . 
				'<span style="color:#990000;font-weight:bold;">'.$logged_in_user . "</span> (" . 
				$logged_in_usersignature . ")";
	} else {
		$logged_in_user = "anonymous";
		$lAuthenticationStatusMessage = "Not Logged In";
	}// end if($_SESSION['loggedin'] == "True")

	if ($_SESSION["EnforceSSL"] == "True"){
		$lEnforceSSLLabel = "Drop SSL";
	}else {
		$lEnforceSSLLabel = "Enforce SSL";
	}//end if

	if ($BubbleHintHandler->hintsAreDispayed() == 1){
		$lPopupHintsLabel = "Hide Popup Hints";
	}else {
		$lPopupHintsLabel = "Show Popup Hints";
	}//end if

	switch ($_SESSION["security-level"]){
   		case "0": // This code is insecure
			$lSecurityLevelDescription = "Hosed";
   		break;
   		case "1": // This code is insecure
   			// DO NOTHING: This is equivalent to using client side security		
			$lSecurityLevelDescription = "Arrogent";
   		break;
	    
   		case "2":
   		case "3":
   		case "4":
   		case "5": // This code is fairly secure
			$lSecurityLevelDescription = "Secure";
		break;
   	}// end switch		
	
	$lHintsMessage = "Hints: ".$_SESSION["hints-enabled"];
	$lSecurityLevelMessage = "Security Level: ".$_SESSION["security-level"]." (".$lSecurityLevelDescription.")";
?>

<!-- Bubble hints code -->
<?php 
	try{
   		$lReflectedXSSExecutionPointBallonTip = $BubbleHintHandler->getHint("ReflectedXSSExecutionPoint");
   		$lCookieTamperingAffectedAreaBallonTip = $BubbleHintHandler->getHint("CookieTamperingAffectedArea"); 
	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatError($e, "Error attempting to execute query to fetch bubble hints.");
	}// end try	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
	<meta content="text/html; charset=us-ascii" http-equiv="content-type">

	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="./styles/global-styles.css" />
	<link rel="stylesheet" type="text/css" href="./styles/ddsmoothmenu/ddsmoothmenu.css" />
	<link rel="stylesheet" type="text/css" href="./styles/ddsmoothmenu/ddsmoothmenu-v.css" />

	<script type="text/javascript" src="./javascript/bookmark-site.js"></script>
	<script type="text/javascript" src="./javascript/ddsmoothmenu/ddsmoothmenu.js"></script>
	<script type="text/javascript" src="./javascript/ddsmoothmenu/jquery.min.js">
		/***********************************************
		* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
		* This notice MUST stay intact for legal use
		* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
		***********************************************/
	</script>
	<script type="text/javascript">
		ddsmoothmenu.init({
			mainmenuid: "smoothmenu1", //menu DIV id
			orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
			classname: 'ddsmoothmenu', //class added to menu's outer DIV
			//customtheme: ["#cccc44", "#cccccc"],
			contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
		});
	</script>
	<script type="text/javascript">
		$(function() {
			$('[ReflectedXSSExecutionPoint]').attr("title", "<?php echo $lReflectedXSSExecutionPointBallonTip; ?>");
			$('[ReflectedXSSExecutionPoint]').balloon();
			$('[CookieTamperingAffectedArea]').attr("title", "<?php echo $lCookieTamperingAffectedAreaBallonTip; ?>");
			$('[CookieTamperingAffectedArea]').balloon();
		});
	</script>
</head>
<body onload="onLoadOfBody(this);">
<table class="main-table-frame" border="1px" cellspacing="0px" cellpadding="0px">
	<tr>
		<td bgcolor="#ccccff" align="center" colspan="7">
			<table width="100%">
				<tr>
					<td style="text-align:center;">
						<span style="text-align:center; font-weight: bold; font-size:30px; text-align: center;">
						<img style="vertical-align: middle; margin-right: 10px;" border="0px" width="50px" height="40px" align="top" src="./images/coykillericon.png"/>
							OWASP Mutillidae II: Web Pwn in Mass Production 
						</span>
					</td>
				</tr>		
			</table>
		</td>
	</tr>
	<tr>
		<td bgcolor="#ccccff" align="center" colspan="7">
			<?php /* Note: $C_VERSION_STRING in index.php */ ?>
			<span class="version-header"><?php echo $C_VERSION_STRING;?></span>
			<span id="idSecurityLevelHeading" class="version-header" style="margin-left: 40px;"><?php echo $lSecurityLevelMessage; ?></span>
			<span id="idHintsStatusHeading" CookieTamperingAffectedArea="1" class="version-header" style="margin-left: 40px;"><?php echo $lHintsMessage; ?></span>
			<span id="idSystemInformationHeading" ReflectedXSSExecutionPoint="1" class="version-header" style="margin-left: 40px;"><?php echo $lAuthenticationStatusMessage ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="header-menu-table">
			<table class="header-menu-table">
				<tr>
					<td><a href="index.php?page=home.php&popUpNotificationCode=HPH0">Home</a></td>
					<td>|</td>
					<td>
						<?php
							if ($_SESSION['loggedin'] == 'True'){
								echo '<a href="index.php?do=logout">Logout</a>';
							} else {
								echo '<a href="index.php?page=login.php">Login/Register</a>';
							}// end if
						?>		
					</td>
					<td>|</td>
					<?php 
						if ($_SESSION['security-level'] == 0){
							echo '<td><a href="index.php?do=toggle-hints&page='.$lPage.'">Toggle Hints</a></td><td>|</td>';
						}// end if
					?>
					<td><a href="index.php?do=toggle-security&page=<?php echo $lPage?>">Toggle Security</a></td>
					<td>|</td>
					<td><a href="set-up-database.php">Reset DB</a></td>
					<td>|</td>
					<td><a href="index.php?page=show-log.php">View Log</a></td>
					<td>|</td>
					<td><a href="index.php?page=captured-data.php">View Captured Data</a></td>
					<td>|</td>
					<td><a href="index.php?do=toggle-bubble-hints&page=<?php echo $lPage?>"><?php echo $lPopupHintsLabel; ?></a></td>
					<td>|</td>
					<td><a href="index.php?do=toggle-enforce-ssl&page=<?php echo $lPage?>"><?php echo $lEnforceSSLLabel; ?></a></td>
				</tr>
			</table>	
		</td>
	</tr>
	<tr>
		<td style="vertical-align:top;text-align:left;background-color:#ccccff;width:10%">
		<div id="smoothmenu1" class="ddsmoothmenu">
			<ul>
				<li style="border-color: #ffffff;border-style: solid;border-width: 1px">
					<a href="#">OWASP Top 10</a>
					<ul>
						<li>
							<a href="http://www.owasp.org/index.php/Top_10_2010-A1" target="_blank">A1 - SQL Injection</a>
							<ul>
								<li>
									<a href="">SQLi - Extract Data</a>
									<ul>
										<li><a href="index.php?page=user-info.php">User Info</a></li>
									</ul>
								</li>
								<li>
									<a href="">SQLi - Bypass Authentication</a>
									<ul>
										<li><a href="index.php?page=login.php">Login</a></li>
									</ul>
								</li>
								<li>
									<a href="">SQLi - Insert Injection</a>
									<ul>
										<li><a href="index.php?page=register.php">Register</a></li>
										<li><a href="index.php?page=captured-data.php">View Captured Data</a></li>
									</ul>
								</li>
								<li>
									<a href="">Blind SQL via Timing</a>
									<ul>
										<li><a href="index.php?page=login.php">Login</a></li>
										<li><a href="index.php?page=user-info.php">User Info</a></li>
									</ul>
								</li>
								<li>
									<a href="">SQLMAP Practice</a>
									<ul>
										<li><a href="index.php?page=sqlmap-targets.php">SQLMAP Practice Targets</a></li>
										<li><a href="index.php?page=login.php">Login</a></li>
										<li><a href="index.php?page=view-someones-blog.php">View Someones Blog</a></li>
										<li><a href="index.php?page=user-info.php">User Info</a></li>
									</ul>
								</li>
								<li>
									<a href="">Via JavaScript Object Notation (JSON)</a>
									<ul>
										<li><a href="index.php?page=pen-test-tool-lookup.php">Pen Test Tool Lookup</a></li>
										<li><a href="index.php?page=pen-test-tool-lookup-ajax.php">Pen Test Tool Lookup (AJAX)</a></li>
									</ul>
								</li>
								<li>
									<a href="">Via Web Service</a>
									<ul>
										<li><a href="./webservices/ws-lookup-user-information.php">Lookup User</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<a href="http://www.owasp.org/index.php/Top_10_2010-A1" target="_blank">A1 - Other Injection</a>
								<ul>
								<li>
									<a href="">HTML Injection (HTMLi)</a>
									<ul>
										<li><a href="?page=add-to-your-blog.php">Add to your blog</a></li>
										<li><a href="index.php?page=dns-lookup.php">DNS Lookup</a></li>
										<li><a href="index.php?page=pen-test-tool-lookup.php">Pen Test Tool Lookup</a></li>
										<li><a href="index.php?page=text-file-viewer.php">Text File Viewer</a></li>
										<li><a href="index.php?page=user-info.php">User Info</a></li>
										<li><a href="index.php?page=set-background-color.php">Set Background Color</a></li>
										<li><a href="index.php?page=html5-storage.php">HTML5 Storage</a></li>
										<li><a href="index.php?page=capture-data.php">Capture Data Page</a></li>
										<li><a href="index.php?page=captured-data.php">View Captured Data</a></li>
										<li><a href="index.php?page=document-viewer.php&PathToDocument=documentation/how-to-access-Mutillidae-over-Virtual-Box-network.php">Document Viewer</a></li>
										<li><a href="index.php?page=arbitrary-file-inclusion.php">Arbitrary File Inclusion</a></li>
										<li><a href="index.php?page=user-poll.php">Poll Question</a></li>
										<li><a href="index.php?page=register.php">Register User</a></li>
										<li><a href="index.php?page=login.php">Login</a></li>
									</ul>
								</li>
								<li>
									<a href="">HTMLi via HTTP Headers</a>
									<ul>
										<li><a href="index.php?page=browser-info.php">Browser Info</a></li>
										<li><a href="index.php?page=site-footer-xss-discussion.php">Site Footer</a><li>
										<li><a href="">HTTP Response Splitting (Hint: Difficult)</a></li>
									</ul>
								</li>
								<li>
									<a href="">HTMLi Via DOM Injection</a>
									<ul>
										<li><a href="index.php?page=html5-storage.php">HTML5 Storage</a></li>
									</ul>
								</li>								
								<li>
									<a href="">HTMLi Via Cookie Injection</a>
									<ul>
										<li><a href="index.php?page=capture-data.php">Capture Data Page</a></li>
									</ul>
								</li>
								<li>
									<a href="">Frame Source Injection</a>
									<ul>
										<li><a href="index.php?page=document-viewer.php&PathToDocument=documentation/how-to-access-Mutillidae-over-Virtual-Box-network.php">Document Viewer</a></li>
									</ul>
								</li>
								<li>
									<a href="">Command Injection</a>
									<ul>
										<li><a href="index.php?page=dns-lookup.php">DNS Lookup</a></li>
										<li><a href="./webservices/ws-lookup-dns-record.php">DNS Lookup (Web Service)</a></li>
									</ul>
								</li>
								<li>
									<a href="">JavaScript Injection</a>
									<ul>
										<li><a href="index.php">Those "Back" Buttons</a></li>
										<li>
											<a href="index.php?page=password-generator.php&username=<?php echo $logged_in_user ?>">
												Password Generator
											</a>
										</li>
										<li><a href="index.php?page=browser-info.php">Browser Info</a></li>
									</ul>
								</li>
								<li>
									<a href="">HTTP Parameter Pollution</a>
									<ul>
										<li><a href="index.php?page=user-poll.php">Poll Question</a></li>
										<li><a href="index.php?page=document-viewer.php&PathToDocument=documentation/how-to-access-Mutillidae-over-Virtual-Box-network.php">Document Viewer</a></li>
									</ul>
								</li>
								<li>
									<a href="">Cascading Style Injection</a>
									<ul>
										<li><a href="index.php?page=set-background-color.php">Set Background Color</a></li>
									</ul>
								</li>
								<li>
									<a href="">JavaScript Object Notation (JSON) Injection</a>
									<ul>
										<li><a href="index.php?page=pen-test-tool-lookup.php">Pen Test Tool Lookup</a></li>
										<li><a href="index.php?page=pen-test-tool-lookup-ajax.php">Pen Test Tool Lookup (AJAX)</a></li>
									</ul>
								</li>
								<li>
									<a href="">Buffer Overflow</a>
									<ul>
										<li><a href="index.php?page=repeater.php">Repeater</a></li>
									</ul>
								</li>
								<li>
									<a href="">Parameter Addition</a>
									<ul>
										<li><a href="index.php?page=repeater.php">Repeater</a></li>
										<li><a href="index.php?page=view-user-privilege-level.php&iv=6bc24fc1ab650b25b4114e93a98f1eba">View User Privileges</a></li>								
									</ul>
								</li>
								<li>
									<a href="">XML External Entity Injection</a>
									<ul>
										<li><a href="index.php?page=xml-validator.php">XML Validator</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<a href="http://www.owasp.org/index.php/Top_10_2010-A2" target="_blank">A2 - Cross Site Scripting (XSS)</a>
							<ul>
								<li>
									<a href="">Reflected (First Order)</a>
									<ul>
										<li><a href="index.php?page=dns-lookup.php">DNS Lookup</a></li>
										<li><a href="index.php?page=pen-test-tool-lookup.php">Pen Test Tool Lookup</a></li>
										<li><a href="index.php?page=text-file-viewer.php">Text File Viewer</a></li>
										<li><a href="index.php?page=user-info.php">User Info</a></li>
										<li><a href="index.php?page=set-background-color.php">Set Background Color</a></li>
										<li><a href="index.php?page=html5-storage.php">HTML5 Storage</a></li>
										<li><a href="index.php?page=capture-data.php">Capture Data Page</a></li>
										<li><a href="index.php?page=document-viewer.php&PathToDocument=documentation/how-to-access-Mutillidae-over-Virtual-Box-network.php">Document Viewer</a></li>
										<li><a href="index.php?page=arbitrary-file-inclusion.php">Arbitrary File Inclusion</a></li>
										<li><a href="index.php?page=xml-validator.php">XML Validator</a></li>
										<li><a href="index.php?page=user-poll.php">Poll Question</a></li>
										<li><a href="index.php?page=register.php">Register User</a></li>
									</ul>
								</li>
								<li>
									<a href="">Persistent (Second Order)</a>
									<ul>
										<li><a href="index.php?page=add-to-your-blog.php">Add to your blog</a></li>
										<li><a href="index.php?page=view-someones-blog.php">View someone's blog</a></li>
										<li><a href="index.php?page=show-log.php">Show Log</a><li>
									</ul>
								</li>
								<li>
									<a href="">DOM Injection</a>
									<ul>
										<li><a href="index.php?page=html5-storage.php">HTML5 Storage</a></li>
									</ul>
								</li>								
								<li>
									<a href="">Via "Input" (GET/POST)</a>
									<ul>
										<li><a href="index.php?page=add-to-your-blog.php">Add to your blog</a></li>
										<li><a href="index.php?page=view-someones-blog.php">View someone's blog</a></li>
										<li><a href="index.php?page=show-log.php">Show Log</a><li>
										<li><a href="index.php?page=text-file-viewer.php">Text File Viewer</a></li>
										<li><a href="index.php?page=dns-lookup.php">DNS Lookup</a></li>
										<li><a href="index.php?page=user-info.php">User Info</a></li>
										<li><a href="index.php">Missing HTTPOnly Attribute</a></li>
										<li><a href="index.php?page=set-background-color.php">Set Background Color</a></li>
										<li><a href="index.php?page=pen-test-tool-lookup.php">Pen Test Tool Lookup</a></li>
										<li><a href="index.php?page=document-viewer.php&PathToDocument=documentation/how-to-access-Mutillidae-over-Virtual-Box-network.php">Document Viewer</a></li>
									</ul>
								</li>
								<li>
									<a href="">Via HTTP Headers</a>
									<ul>
										<li><a href="index.php?page=browser-info.php">Browser Info</a></li>
										<li><a href="index.php?page=show-log.php">Show Log</a><li>
										<li><a href="index.php?page=site-footer-xss-discussion.php">Site Footer</a><li>
										<li><a href="index.php?page=html5-storage.php">Those &quot;BACK&quot; Buttons</a></li>
									</ul>
								</li>
								<li>
									<a href="">Via HTTP Attribute</a>
									<ul>
										<li><a href="index.php?page=document-viewer.php&PathToDocument=documentation/how-to-access-Mutillidae-over-Virtual-Box-network.php">Document Viewer</a></li>
									</ul>								
								</li>								
								<li>
									<a href="">Via Misconfiguration</a>
									<ul>
										<li><a href="index.php">Missing HTTPOnly Attribute</a></li>
									</ul>
								</li>
								<li>
									<a href="">Against HTML 5 Storage</a>
									<ul>
										<li><a href="index.php?page=html5-storage.php">HTML5 Storage</a></li>
									</ul>
								</li>
								<li>
									<a href="">Against JSON</a>
									<ul>
										<li><a href="index.php?page=pen-test-tool-lookup.php">Pen Test Tool Lookup</a></li>
									</ul>
								</li>
								<li>
									<a href="">Via Cookie Injection</a>
									<ul>
										<li><a href="index.php?page=capture-data.php">Capture Data Page</a></li>
									</ul>
								</li>
								<li>
									<a href="">Via XML Injection</a>
									<ul>
										<li><a href="index.php?page=xml-validator.php">XML Validator</a></li>
									</ul>
								</li>
								<li>
									<a href="">BeeF Framework Targets</a>
									<ul>
										<li><a href="index.php?page=add-to-your-blog.php">Add to your blog</a></li>
										<li><a href="index.php?page=view-someones-blog.php">View someone's blog</a></li>
										<li><a href="index.php?page=show-log.php">Show Log</a><li>
										<li><a href="index.php?page=dns-lookup.php">DNS Lookup</a></li>
										<li><a href="index.php?page=pen-test-tool-lookup.php">Pen Test Tool Lookup</a></li>
										<li><a href="index.php?page=text-file-viewer.php">Text File Viewer</a></li>
										<li><a href="index.php?page=user-info.php">User Info</a></li>
										<li><a href="index.php?page=set-background-color.php">Set Background Color</a></li>
										<li><a href="index.php?page=html5-storage.php">HTML5 Storage</a></li>
										<li><a href="index.php?page=capture-data.php">Capture Data Page</a></li>
										<li><a href="index.php?page=document-viewer.php&PathToDocument=documentation/how-to-access-Mutillidae-over-Virtual-Box-network.php">Document Viewer</a></li>
										<li><a href="index.php?page=arbitrary-file-inclusion.php">Arbitrary File Inclusion</a></li>
										<li><a href="index.php?page=xml-validator.php">XML Validator</a></li>
										<li><a href="index.php?page=user-poll.php">Poll Question</a></li>
										<li><a href="index.php?page=register.php">Register User</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<a href="http://www.owasp.org/index.php/Top_10_2010-A3" target="_blank">
								A3 - Broken Authentication and Session Management
							</a>
							<ul>
								<li><a href="index.php">Cookies</a></li>
								<li><a href="index.php?page=login.php">Login</a></li>
								<li><a href="index.php?page=view-user-privilege-level.php&iv=6bc24fc1ab650b25b4114e93a98f1eba">View User Privileges</a></li>
							</ul>
						</li>
						<li>
							<a href="http://www.owasp.org/index.php/Top_10_2010-A4" target="_blank">A4 - Insecure Direct Object References</a>
							<ul>
								<li><a href="index.php?page=text-file-viewer.php">Text File Viewer</a></li>
								<li><a href="index.php?page=source-viewer.php">Source Viewer</a></li>
								<li><a href="index.php?page=credits.php">Credits</a></li>
								<li><a href="index.php">Cookies</a></li>
								<li><a href="index.php?page=arbitrary-file-inclusion.php">Arbitrary File Inclusion</a></li>
							</ul>
						</li>
						<li>
							<a href="http://www.owasp.org/index.php/Top_10_2010-A5" target="_blank">A5 - Cross Site Request Forgery (CSRF)</a>
							<ul>
								<li><a href="index.php?page=add-to-your-blog.php">Add to your blog</a></li>
								<li><a href="index.php?page=register.php">Register User</a></li>
								<li><a href="index.php?page=user-poll.php">Poll Question</a></li>
							</ul>
						</li>
						<li>
							<a href="http://www.owasp.org/index.php/Top_10_2010-A6" target="_blank">A6 - Security Misconfiguration</a>
							<ul>								
								<li><a href="index.php?page=secret-administrative-pages.php">"Secret" Administrative Pages</a></li>
								<li><a href="index.php?page=directory-browsing.php">Directory Browsing</a></li>
								<li>
									<a href="">Method Tampering (GET for POST)</a>
									<ul>
										<li><a href="index.php?page=user-info.php">User Info</a></li>
										<li><a href="index.php?page=user-poll.php">Poll Question</a></li>
										<li><a href="index.php?page=dns-lookup.php">DNS Lookup</a></li>
									</ul>
								</li>
								<li>
									<a href="">Information Disclosure</a>
									<ul>
										<li><a href="index.php?page=phpmyadmin.php">PHP MyAdmin Console</a></li>
										<li><a href="index.php?page=phpinfo.php">PHP Info Page</a></li>
										<li><a href="index.php?page=robots-txt.php">Robots.txt</a></li>
										<li><a href="index.php?page=secret-administrative-pages.php">"Secret" Administrative Pages</a></li>
									</ul>
								</li>
								<li>
									<a href="">Application Path Disclosure</a>
									<ul>
										<li><a href="index.php?page=phpmyadmin.php">PHP MyAdmin Console</a></li>
										<li><a href="index.php?page=phpinfo.php">PHP Info Page</a></li>
										<li><a href="index.php?page=robots-txt.php">Robots.txt</a></li>
									</ul>
								</li>
								<li>
									<a href="">Platform Path Disclosure</a>
									<ul>
										<li><a href="index.php?page=phpmyadmin.php">PHP MyAdmin Console</a></li>
										<li><a href="index.php?page=phpinfo.php">PHP Info Page</a></li>
									</ul>
								</li>
								<li>
									<a href="index.php?page=user-agent-impersonation.php">User-Agent Impersonation</a>
								</li>								
							</ul>
						</li>
						<li>
							<a href="http://www.owasp.org/index.php/Top_10_2010-A7" target="_blank">A7 - Insecure Cryptographic Storage</a>
							<ul>
								<li><a href="index.php?page=user-info.php">User Info</a></li>
								<li><a href="index.php?page=html5-storage.php">HTML5 Storage</a></li>
								<li><a href="index.php?page=view-user-privilege-level.php&iv=6bc24fc1ab650b25b4114e93a98f1eba">View User Privileges</a></li>
							</ul>
						</li>
						<li>
							<a href="http://www.owasp.org/index.php/Top_10_2010-A8" target="_blank">A8 - Failure to Restrict URL Access</a>
							<ul>
								<li><a href="index.php?page=phpmyadmin.php">PHP MyAdmin Console</a></li>
								<li><a href="index.php?page=source-viewer.php">Source Viewer</a></li>
								<li><a href="index.php?page=secret-administrative-pages.php">"Secret" Administrative Pages</a></li>
								<li><a href="index.php?page=robots-txt.php">Robots.txt</a></li>
								<li><a href="index.php?page=arbitrary-file-inclusion.php">Arbitrary File Inclusion</a></li>
								<li><a href="index.php?page=phpinfo.php">PHP Info Page</a></li>					
							</ul>
						</li>
						<li>
							<a href="http://www.owasp.org/index.php/Top_10_2010-A9" target="_blank">A9 - Insufficient Transport Layer Protection</a>
							<ul>
								<li><a href="index.php?page=ssl-misconfiguration.php">SSL Misconfiguration</a></li>
								<li><a href="index.php?page=login.php">Login</a></li>
								<li><a href="index.php?page=user-info.php">User Info</a></li>
							</ul>
						</li>
						<li>
							<a href="http://www.owasp.org/index.php/Top_10_2010-A10" target="_blank">A10 - Unvalidated Redirects and Forwards</a>
							<ul>
								<li><a href="?page=credits.php">Credits</a></li>
								<?php if (isset($_COOKIE["uid"]) && $_COOKIE["uid"]==1) { ?>		
								<li><a href="set-up-database.php">Setup/reset the DB</a></li>
								<?php } else { ?>
								<a href="#">Setup/reset the DB (Disabled: Not Admin)</a></li>
								<?php }; ?>		
							</ul>
						</li>
					</ul>
				</li>
				<li style="border-color: #ffffff; border-style: solid;border-width: 1px">
					<a href="#">Web Services</a>
					<ul>
						<li>
							<a href="">Test Page</a>
							<ul>
								<li><a href="./webservices/ws-hello-world.php">Hello World</a></li>
							</ul>
						</li>
						<li>
							<a href="">Command Injection</a>
							<ul>
								<li><a href="./webservices/ws-lookup-dns-record.php">DNS Lookup</a></li>
							</ul>
						</li>
						<li>
							<a href="">SQL Injection</a>
							<ul>
								<li><a href="./webservices/ws-lookup-user-information.php">Lookup User</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li style="border-color: #ffffff; border-style: solid;border-width: 1px">
					<a href="#">HTML 5</a>
					<ul>
						<li>
							<a href="">HTML 5 Web Storage</a>
							<ul>
								<li><a href="index.php?page=html5-storage.php">HTML5 Storage</a></li>
							</ul>
						</li>
						<li>
							<a href="">JavaScript Object Notation (JSON)</a>
							<ul>
								<li><a href="index.php?page=pen-test-tool-lookup.php">Pen Test Tool Lookup</a></li>
								<li><a href="index.php?page=pen-test-tool-lookup-ajax.php">Pen Test Tool Lookup (AJAX)</a></li>
							</ul>
						</li>
						<li>
							<a href="">Asyncronous JavaScript and XML (AJAX)</a>
							<ul>
								<li><a href="index.php?page=pen-test-tool-lookup-ajax.php">Pen Test Tool Lookup (AJAX)</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li style="border-color: #ffffff; border-style: solid;border-width: 1px">
					<a href="#">Others</a>
					<ul>
						<li>
							<a href="http://www.owasp.org/index.php/Top_10_2007-A3" target="_blank">OWASP 2007 A3 - Malicious File Execution</a>
							<ul>
								<li><a href="?page=text-file-viewer.php">Text File Viewer</a></li>
								<li><a href="?page=source-viewer.php">Source Viewer</a></li>
							</ul>		
						</li>
						<li>
							<a href="http://www.owasp.org/index.php/Top_10_2007-A6" target="_blank">OWASP 2007 A6 - Information Leakage</a>
							<ul>
								<li><a href="index.php">Cache-Control</a></li>
								<li><a href="index.php">X-Powered-By HTTP Header</a></li>
								<li><a href="index.php">HTML/JavaScript Comments</a></li>
								<li><a href="index.php?page=framing.php">Click-Jacking</a></li>
								<li><a href="framer.html">Cross-Site Framing (Third-Party Framing)</a></li>
								<li><a href="index.php?page=html5-storage.php">HTML5 Storage</a></li>
								<li><a href="index.php?page=phpmyadmin.php">PHP MyAdmin Console</a></li>
								<li><a href="index.php?page=phpinfo.php">PHP Info Page</a></li>
								<li><a href="index.php?page=robots-txt.php">Robots.txt</a></li>
							</ul>		
						</li>
						<li>
							<a href="http://www.owasp.org/index.php/Top_10_2007-A6" target="_blank">OWASP 2007 A6 - Improper Error Handling</a>
							<ul>
								<li><a href="index.php?page=user-info.php">User Info</a></li>
								<li><a href="index.php?page=login.php">Login</a></li>
								<li><a href="index.php?page=register.php">Register</a></li>
								<li><a href="index.php?page=pen-test-tool-lookup.php">Pen Test Tool Lookup</a></li>
								<li><a href="index.php?page=pen-test-tool-lookup-ajax.php">Pen Test Tool Lookup (AJAX)</a></li>
								<li><a href="./webservices/ws-lookup-user-information.php">Lookup User Web Service</a></li>
							</ul>		
						</li>
						<li>
							<a href="">Unrestricted File Upload</a>
							<ul>
								<li><a href="index.php?page=upload-file.php">File Upload</a></li>
							</ul>
						</li>
						<li>
							<a href="">XML External Entity Injection</a>
							<ul>
								<li><a href="index.php?page=xml-validator.php">XML Validator</a></li>
							</ul>
						</li>
						<li>
							<a href="">Local File Inclusion</a>
							<ul>
								<li><a href="index.php?page=arbitrary-file-inclusion.php">Arbitrary File Inclusion</a></li>
							</ul>
						</li>
						<li>
							<a href="">Remote File Inclusion</a>
							<ul>
								<li><a href="index.php?page=arbitrary-file-inclusion.php">Arbitrary File Inclusion</a></li>
							</ul>
						</li>
						<li>
							<a href="">Denial of Service</a>
							<ul>
								<li><a href="?page=text-file-viewer.php">Text File Viewer</a></li>
								<li><a href="?page=show-log.php">Show Web Log</a><li>
							</ul>		
						</li>
						<li>
							<a href="">JavaScript "Security"</a>
							<ul>
								<li><a href="index.php?page=login.php">Login</a></li>
								<li><a href="index.php?page=user-info.php">User Info</a></li>
								<li><a href="index.php?page=add-to-your-blog.php">Add to your blog</a></li>
								<li><a href="index.php?page=html5-storage.php">HTML5 Storage</a></li>
							</ul>		
						</li>
						<li>
							<a href="index.php?page=user-agent-impersonation.php">User-Agent Impersonation</a>
						</li>
						<li>
							<a href="">Data Capture Pages</a>
							<ul>
								<li><a href="index.php?page=capture-data.php">Data Capture</a></li>
								<li><a href="index.php?page=captured-data.php">View Captured Data</a></li>
							</ul>		
						</li>
						
					</ul>
				</li>
				<li style="border-color: #ffffff;border-style: solid;border-width: 1px">
					<a href="">Documentation</a>
					<ul>
						<li><a href="index.php?page=documentation/change-log.html">Change Log</a></li>
						<li><a href="index.php?page=credits.php">Credits</a></li>
						<li>
							<a href="index.php?page=documentation/how-to-access-Mutillidae-over-Virtual-Box-network.php">
								How to Access Mutillidae over Virtual Box "Host Only" Network
							</a>
						</li>
						<li><a href="index.php?page=installation.php">Installation Instructions</a></li>
						<li><a href="/mutillidae/documentation/mutillidae-installation-on-xampp-win7.pdf">Installation Instructions: Windows 7 (PDF)</a></li>
						<li><a href="index.php?page=documentation/vulnerabilities.php">Listing of Vulnerabilities</a></li>
					</ul>
				</li>
				<li style="border-color: #ffffff;border-style: solid;border-width: 1px">
					<a href="#">Resources</a>
					<ul>
						<li>
							<a onclick="bookmarkSite();" href="">
								Bookmark Site
							</a>
						</li>
						<li>
							<a href="http://sourceforge.net/projects/mutillidae/files/mutillidae-project/" target="_blank">
								Latest Version of OWASP Mutillidae II
							</a>
						</li>
						<li>
							<a href="https://www.owasp.org/index.php/Top_Ten" target="_blank">
								OWASP Top Ten
							</a>
						</li>
						<li>
							<a href="https://addons.mozilla.org/en-US/firefox/collections/jdruin/pro-web-developer-qa-pack/" target="_blank">
								Professional Web Application Developer Quality Assurance Pack
							</a>
						</li>
						<li>
							<a href="http://samurai.inguardians.com/" target="_blank">
								Samurai Web Testing Framework
							</a>
						</li>
					</ul>
				</li>
			</ul>
			<br style="clear: left" />
		</div>
		<div style="text-align: center;">
			<a href="https://www.owasp.org" target="_blank">
				<img alt="OWASP" style="border-width: 0px;" height="90px" width="120px" src="./images/owasp-logo-400-300.png" />
			</a>
		</div>
		<div>&nbsp;</div>
		<div class="label" style="text-align: center;">
			<a href="https://twitter.com/webpwnized" target="_blank">
				<img align="middle" alt="Webpwnized Twitter Channel" src="./images/twitter-bird-48-48.png" width="48px" height="48px" />
				<br/>
				Release Announcements
			</a>
		</div>		
		<div>&nbsp;</div>
		<div>&nbsp;</div>
		<div class="label" style="text-align: center;">
			<a href="http://www.youtube.com/user/webpwnized" style="white-space:nowrap;" target="_blank">
				<img align="middle" alt="Webpwnized YouTube Channel" src="./images/youtube-48-48.png" width="48px" height="48px" />
				<br/>
				Video<br/>Tutorials
			</a>
		</div>		
	</td>

<td valign="top">
	<blockquote>
	<!-- Begin Content -->