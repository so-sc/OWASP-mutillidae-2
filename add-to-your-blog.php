<?php
	/* Known Vulnerabilities: 
		SQL injection, 
		Cross Site Scripting, 
		Cross Site Request Forgery,
		Application Exception Output,
		Known Vulnerable Output: Name, Comment, "Add blog for" title,
		HTML injection
	*/
	/* Defined our constants to use to tokenize allowed HTML characters */
	include_once './includes/constants.php';

	if (!isSet($logged_in_user)) {
		throw new Exception("$logged_in_user is not set. Page add-to-your-blog.php requires this variable.");
	}// end if

	switch ($_SESSION["security-level"]){
   		case "0": // This code is insecure
   			// DO NOTHING: This is insecure		
			$lEncodeOutput = FALSE;
			$lLoggedInUser = $logged_in_user;
			$lTokenizeAllowedMarkup = FALSE;
			$lProtectAgainstSQLInjection = FALSE;
			$lProtectAgainstCSRF = FALSE;
			$lCSRFTokenStrength = "NONE";
			$lEnableJavaScriptValidation = FALSE;
		break;	   		

   		case "1": // This code is insecure
   			// DO NOTHING: This is insecure		
			$lEncodeOutput = FALSE;
			$lLoggedInUser = $logged_in_user;
			$lTokenizeAllowedMarkup = FALSE;
			$lProtectAgainstSQLInjection = FALSE;
			$lProtectAgainstCSRF = TRUE;
			$lCSRFTokenStrength = "LOW";
			$lEnableJavaScriptValidation = TRUE;			
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
   			// encode the output following OWASP standards
   			// this will be HTML encoding because we are outputting data into HTML
			$lEncodeOutput = TRUE;
			
			/* Business Problem: Sometimes the business requirements define that users
			 * should be allowed to use some HTML  markup. If unneccesary, this is a
			 * bad idea. Output encoding will naturally kill any users attempt to use HTML
			 * in their input, which is exactly why we use output encoding. 
			 * 
			 * If the business process allows some HTML, then those HTML items are elevated
			 * from "mallicious input" to "direct object refernces" (a resource to be enjoyed).
			 * When we want to restrict a user to using to "direct object refernces" (a 
			 * resource to be enjoyed) responsibly, we use mapping. Mapping allows the user
			 * to chose from a "system generated" (that's us programmers) set of tokens
			 * to pick from. We need to assure that the user either chooses one of the tokens
			 * we offer, or our system rejects the request. To put it bluntly, either the user
			 * follows the rules, or their output is encoded. Period.
			 */
			$lTokenizeAllowedMarkup = TRUE;
			
			/* If we are in secure mode, we need to protect against SQLi */
			$lProtectAgainstSQLInjection = TRUE;

			/* Protecting against CSRF requires that we allow the server to know
			 * if the user intended to submit the request. For example, this page
			 * adds a blog entry. How does the server know that the current user
			 * intended to add a blog entry? Perhaps an agent caused the users
			 * browser to POST an "add" request without th$_SESSION['add-to-your-blog']['csrf-token']e users consent. CAPTCHA
			 * can help as can randomly generated math problems. Another method is 
			 * to have the server attach random tokens to forms, then verify the 
			 * token is returned upon submition. 
			 */
			$lProtectAgainstCSRF = TRUE;
			$lCSRFTokenStrength = "HIGH";
				
			/* Note that $MySQLHandler->escapeDangerousCharacters is ok but not the best defense. Stored
			 * Procedures are a much more powerful defense, run much faster, can be
			 * trapped in a schema, can run on the database, and can be called from
			 * any number of web applications. Stored procs are the true anti-pwn.
			 * There are 3 ways that stored procs can be made vulenrable by developers,
			 * but they are safe by default. Queries are vulnerable by default.
			 */
			$lLoggedInUser = $MySQLHandler->escapeDangerousCharacters($logged_in_user);

			/* 
			 * There is no security in JS validation. You must validate on the server.
			 * JS is easy to bypass.
			 */
			$lEnableJavaScriptValidation = TRUE;
   		break;
   	}// end switch
   	
   	$lNewCSRFTokenForNextRequest = "CSRFProtectionDisabled";
   	if($lProtectAgainstCSRF){
			/* Record the CSRF token that we saved in the session when we offered the ADD BLOG 
			 * page to the user. This was the token we created before the user POSTed to this page
			 * a new blog entry to be saved.
			 */
		$lPostedCSRFToken = "";
   		
		if (isset($_SESSION['add-to-your-blog']['csrf-token'])){
			$lExpectedTokenForThisRequest = $_SESSION['add-to-your-blog']['csrf-token'];
		}//end if
   		
		/* Store a new token in the session for the NEXT request to add a new blog entry.
		 * The user might be making a request right now, but this token is for the next
		 * request if it ever occurs.
		 */
		switch ($lCSRFTokenStrength){
			case "HIGH":
				$_SESSION['add-to-your-blog']['csrf-token'] = $lNewCSRFTokenForNextRequest = $ESAPIRandomizer->getRandomString(32, "ABCDEFGEHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890");
			break;
			case "MEDIUM":
				$_SESSION['add-to-your-blog']['csrf-token'] = $lNewCSRFTokenForNextRequest = mt_rand();
			break;
			case "LOW":
				if (!is_null($lExpectedTokenForThisRequest)) {
					$_SESSION['add-to-your-blog']['csrf-token'] = $lNewCSRFTokenForNextRequest = ($lExpectedTokenForThisRequest + 7777);
				}else{
					//initialize the tokens
					$_SESSION['add-to-your-blog']['csrf-token'] = $lNewCSRFTokenForNextRequest = 5323;
				}//end if
			break;
			default:break;
		}//end switch on $lCSRFTokenStrength

		/* Record the token which the user just passed in. If they used the page offered, the token
		 * should match. If the users browser was forced to make a request, the token sent should
		 * not match unless the attacker makes a good guess.
		 */
		if (isset($_POST['csrf-token'])){
			$lPostedCSRFToken = $_POST['csrf-token'];	
		}//end if
			
   	}// end if $lProtectAgainstCSRF

	/* ----------------------------------------
	 * Insert user's new blog entry 
	 * ----------------------------------------
	 * precondition: $logged_in_user is not null 
	 */
	if(isSet($_POST["add-to-your-blog-php-submit-button"])){
		try {
			if ($lProtectAgainstCSRF){
				if ($lPostedCSRFToken != $lExpectedTokenForThisRequest){
					throw (new Exception("Security Violation: Cross Site Request Forgery attempt detected.", 500));
				}// end if
			}// end if
			
			// Grab inputs
			if ($lProtectAgainstSQLInjection){
				// This might prevent SQL injection on the insert.
				$lBlogEntry = $MySQLHandler->escapeDangerousCharacters($_POST["blog_entry"]);
			}else{
				$lBlogEntry = $_REQUEST["blog_entry"];
			}// end if

			/* Some dangerous markup allowed. Here we tokenize it for storage. */
			if ($lTokenizeAllowedMarkup){
				$lBlogEntry = str_ireplace('<b>', BOLD_STARTING_TAG, $lBlogEntry);
				$lBlogEntry = str_ireplace('</b>', BOLD_ENDING_TAG, $lBlogEntry);
				$lBlogEntry = str_ireplace('<i>', ITALIC_STARTING_TAG, $lBlogEntry);
				$lBlogEntry = str_ireplace('</i>', ITALIC_ENDING_TAG, $lBlogEntry);
				$lBlogEntry = str_ireplace('<u>', UNDERLINE_STARTING_TAG, $lBlogEntry);
				$lBlogEntry = str_ireplace('</u>', UNDERLINE_ENDING_TAG, $lBlogEntry);				
			}// end if $lTokenizeAllowedMarkup			
			
			// weak server-side input validation. not good enough.
			if(strlen($lBlogEntry) > 0){
				$lValidationFailed = FALSE;
				
				try {
					$SQLQueryHandler->insertBlogRecord($lLoggedInUser, $lBlogEntry);	
				} catch (Exception $e) {
					echo $CustomErrorHandler->FormatError($e, "Error inserting blog for " . $lLoggedInUser);
				}//end try
				
				try {
					$LogHandler->writeToLog("Blog entry added by: " . $lLoggedInUser);	
				} catch (Exception $e) {
					// do nothing
				}//end try
				
			}else{
				$lValidationFailed = TRUE;
			}// end if(strlen($lBlogEntry) > 0)
		} catch (Exception $e) {
			echo $CustomErrorHandler->FormatError($e, "Error inserting blog");
		}// end try
	}else {
		$lValidationFailed = FALSE;
	}// end if isSet($_POST["add-to-your-blog-php-submit-button"])
?>

<!-- Bubble hints code -->
<?php 
	try{
   		$lReflectedXSSExecutionPointBallonTip = $BubbleHintHandler->getHint("ReflectedXSSExecutionPoint");
   		$lXSRFVulnerabilityAreaBallonTip = $BubbleHintHandler->getHint("XSRFVulnerabilityArea");
   		$lHTMLandXSSandSQLInjectionPointBallonTip = $BubbleHintHandler->getHint("HTMLandXSSandSQLInjectionPoint");   		
	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatError($e, "Error attempting to execute query to fetch bubble hints.");
	}// end try	
?>

<script type="text/javascript">
	$(function() {
		$('[ReflectedXSSExecutionPoint]').attr("title", "<?php echo $lReflectedXSSExecutionPointBallonTip; ?>");
		$('[ReflectedXSSExecutionPoint]').balloon();
		$('[XSRFVulnerabilityArea]').attr("title", "<?php echo $lXSRFVulnerabilityAreaBallonTip; ?>");
		$('[XSRFVulnerabilityArea]').balloon();
		$('[HTMLandXSSandSQLInjectionPoint]').attr("title", "<?php echo $lHTMLandXSSandSQLInjectionPointBallonTip; ?>");
		$('[HTMLandXSSandSQLInjectionPoint]').balloon();		
	});
</script>

<!-- BEGIN HTML OUTPUT  -->
<script type="text/javascript">
	var onSubmitBlogEntry = function(/* HTMLForm */ theForm){

		<?php 
			if($lEnableJavaScriptValidation){
				echo "var lInvalidBlogPattern = /\'/;";
			}else{
				echo "var lInvalidBlogPattern = /*/;";
			}// end if
		?>
		
		if(theForm.blog_entry.value.search(lInvalidBlogPattern) > -1){
			alert('Single-quotes are not allowed. Dont listen to security people. Everyone knows if we just filter dangerous characters, XSS is not possible.\n\nWe use JavaScript defenses combined with filtering technology.\n\nBoth are such great defenses that you are stopped in your tracks.');
			return false;
		}
	};// end JavaScript function onSubmitBlogEntry()
</script>

<div class="page-title">Welcome To The Blog</div>

<?php include_once (__ROOT__.'/includes/back-button.inc'); ?>
<?php include_once (__ROOT__.'/includes/hints-level-1/level-1-hints-wrapper.inc'); ?>

<fieldset>
	<legend>Add New Blog Entry</legend>
	<form 	action="index.php?page=add-to-your-blog.php" 
			method="post" 
			enctype="application/x-www-form-urlencoded" 
			onsubmit="return onSubmitBlogEntry(this);"
			id="idBlogForm"
			>		
		<input name="csrf-token" type="hidden" value="<?php echo $lNewCSRFTokenForNextRequest; ?>" />
		<span>
			<a href="./index.php?page=view-someones-blog.php" style="text-decoration: none;">
			<img style="vertical-align: middle;" src="./images/magnifying-glass-icon.jpeg" height="32px" width="32px" />
			<span style="font-weight:bold;">&nbsp;View Blogs</span>
			</a>
		</span>
		<table style="margin-left:auto; margin-right:auto;">
			<tr id="id-bad-blog-entry-tr" style="display: none;">
				<td class="error-message">
					Validation Error: Blog entry cannot be blank
				</td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td id="id-blog-form-header-td" ReflectedXSSExecutionPoint="1" class="form-header">Add blog for <?php echo $lLoggedInUser?></td>
			</tr>
			<tr><td></td></tr>
			<tr><td class="report-header">Note: &lt;b&gt;,&lt;/b&gt;,&lt;i&gt;,&lt;/i&gt;,&lt;u&gt; and &lt;/u&gt; are now allowed in blog entries</td></tr>
			<tr>
				<td><textarea name="blog_entry" HTMLandXSSandSQLInjectionPoint="1" rows="10" cols="65"></textarea></td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td style="text-align:center;">
					<input name="add-to-your-blog-php-submit-button" XSRFVulnerabilityArea="1" class="button" type="submit" value="Save Blog Entry" />
				</td>
			</tr>
			<tr><td></td></tr>
		</table>
	</form>
</fieldset>

<?php
	if ($lValidationFailed) {
		echo '<script>document.getElementById("id-bad-blog-entry-tr").style.display="";</script>'; 
	}// end if ($lValidationFailed)
?>

<?php
	/* Display current user's blog entries */
	try {		
	    	    
		try {
			/* Note that the logged in user could be used for SQL injection */
			$lQueryResult = $SQLQueryHandler->getBlogRecord($lLoggedInUser);
		} catch (Exception $e) {
			echo $CustomErrorHandler->FormatError($e, "Error selecting blog entries for " . $lLoggedInUser . ": " . $lQuery);
		}//end try

		try {
			$LogHandler->writeToLog("Selected blog entries for " . $lLoggedInUser);	
		} catch (Exception $e) {
			echo $CustomErrorHandler->FormatError($e, "Error writing selected blog entries to log");
		}// end try
				
		echo '<div>&nbsp;</div>
				<span>
					<a href="./index.php?page=view-someones-blog.php">
						<img style="vertical-align: middle;" src="./images/magnifying-glass-icon.jpeg" height="32px" width="32px" />
						<span style="font-weight:bold; text-decoration: none;">View Blogs</span>
					</a>
				</span>';
		echo '<table border="1px" width="90%" class="main-table-frame">';
	    echo ' 	<tr class="report-header">
		    		<td colspan="4">'.$lQueryResult->num_rows.' Current Blog Entries</td>
		    	</tr>
		    	<tr class="report-header">
		    		<td>&nbsp;</td>
				    <td>Name</td>
				    <td>Date</td>
				    <td>Comment</td>
			    </tr>';

	    $lRowNumber = 0;
	    while($lRecord = $lQueryResult->fetch_object()){
	    	
	    	$lRowNumber++;
	    	
			if(!$lEncodeOutput){
				$lBloggerName = $lRecord->blogger_name;
				$lDate = $lRecord->date;
				$lComment = $lRecord->comment;
			}else{
				$lBloggerName = $Encoder->encodeForHTML($lRecord->blogger_name);
				$lDate = $Encoder->encodeForHTML($lRecord->date);
				$lComment = $Encoder->encodeForHTML($lRecord->comment);
			}// end if

			/* Some dangerous markup allowed. Here we restore the tokenized output. 
			 * Note that using GUIDs as tokens works well because they are 
			 * fairly unique plus they encode to the same value. 
			 * Encoding wont hurt them.
			 * 
			 * Note: Mutillidae is weird. It has to be broken and unbroken at the same time.
			 * Here we un-tokenize our output no matter if we are in secure mode or not.
			 */
			$lComment = str_ireplace(BOLD_STARTING_TAG, '<span style="font-weight:bold;">', $lComment);
			$lComment = str_ireplace(BOLD_ENDING_TAG, '</span>', $lComment);
			$lComment = str_ireplace(ITALIC_STARTING_TAG, '<span style="font-style: italic;">', $lComment);
			$lComment = str_ireplace(ITALIC_ENDING_TAG, '</span>', $lComment);
			$lComment = str_ireplace(UNDERLINE_STARTING_TAG, '<span style="border-bottom: 1px solid #000000;">', $lComment);
			$lComment = str_ireplace(UNDERLINE_ENDING_TAG, '</span>', $lComment);

			echo "<tr>
					<td>{$lRowNumber}</td>
					<td ReflectedXSSExecutionPoint=\"1\">{$lBloggerName}</td>
					<td>{$lDate}</td>
					<td ReflectedXSSExecutionPoint=\"1\">{$lComment}</td>
				</tr>\n";
		}//end while $lRecord
		echo "</table><div>&nbsp;</div>";		

	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatError($e, $lQuery);
	}// end try	
?>

<?php 
	if ($lProtectAgainstCSRF){
		echo('<div>&nbsp;</div>'.PHP_EOL);
		echo('<div>&nbsp;</div>'.PHP_EOL);
		echo('<fieldset>'.PHP_EOL);
		echo('<legend>CSRF Protection Information</legend>'.PHP_EOL);
		echo('<table style="margin-left:auto; margin-right:auto;">'.PHP_EOL);				
		echo('<tr><td></td></tr>'.PHP_EOL);
		echo('<tr><td class="report-header">Posted Token: '.$lPostedCSRFToken.'</td></tr>'.PHP_EOL);
		echo('<tr><td>Expected Token For This Request: '.$lExpectedTokenForThisRequest.'</td></tr>'.PHP_EOL);
		echo('<tr><td>Token Passed By User For This Request: '.$lPostedCSRFToken.'</td></tr>'.PHP_EOL);	
		echo('<tr><td>&nbsp;</td></tr>'.PHP_EOL);
		echo('<tr><td>New Token For Next Request: '.$lNewCSRFTokenForNextRequest.'</td></tr>'.PHP_EOL);
		echo('<tr><td>Token Stored in Session: '.$_SESSION['add-to-your-blog']['csrf-token'].'</td></tr>'.PHP_EOL);
		echo('<tr><td></td></tr>'.PHP_EOL);
		echo('</table>'.PHP_EOL);
		echo('</fieldset>'.PHP_EOL);
	}// end if $lProtectAgainstCSRF

	if ($_SESSION["showhints"] == 2) {
		include_once '/includes/hints-level-2/cross-site-scripting-tutorial.inc';
		include_once '/includes/hints-level-2/cross-site-request-forgery-tutorial.inc';
	}// end if
?>

<script type="text/javascript">
	try{
		document.getElementById("idBlogForm").blog_entry.focus();
	}catch(e){
		alert('Error trying to set focus on field blog_entry: ' + e.message);
	}// end try
</script>
