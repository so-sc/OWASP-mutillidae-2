<?php 
	try{
    	switch ($_SESSION["security-level"]){
    		case "0": // This code is insecure.
				$lEnableJavaScriptValidation = TRUE;
				$lEnableHTMLControls = TRUE;
				$lProtectAgainstMethodSwitching = FALSE;
				$lEncodeOutput = FALSE;
    		break;

    		case "1": // This code is insecure.
				$lEnableJavaScriptValidation = TRUE;
				$lEnableHTMLControls = TRUE;
				$lProtectAgainstMethodSwitching = FALSE;
				$lEncodeOutput = FALSE;
    		break;

	   		case "2":
	   		case "3":
	   		case "4":
    		case "5": // This code is fairly secure
    			$lEnableJavaScriptValidation = TRUE;
				$lEnableHTMLControls = TRUE;
				$lProtectAgainstMethodSwitching = TRUE;
				$lEncodeOutput = TRUE;
    		break;
    	}// end switch
    	
    	/*
    	 * Create a random value for the user to submit.
    	 */
    	$lRandomFlag = $_SESSION['cscc-random-flag'] = mt_rand(0, mt_getrandmax());
    	
		// if we want to enforce POST method, we need to be careful to specify $_POST
	   	if(!$lProtectAgainstMethodSwitching){
			$lSubmitButtonClicked = isset($_REQUEST["client-side-control-challenge-php-submit-button"]);
	   	}else{
			$lSubmitButtonClicked = isset($_POST["client-side-control-challenge-php-submit-button"]);
	   	}//end if    	

	   	if($lSubmitButtonClicked){

			// if we want to enforce POST method, we need to be careful to specify $_POST
		   	if(!$lProtectAgainstMethodSwitching){
		   		$lStringToRepeat = $_REQUEST["string_to_repeat"];
		   		$lTimesToRepeatString = $_REQUEST["times_to_repeat_string"];
		   	}else{
		   		$lStringToRepeat = $_POST["string_to_repeat"];
		   		$lTimesToRepeatString = $_POST["times_to_repeat_string"];
		   	}//end if    	
	   		
	    	if($lEnableBufferOverflowProtection){
	   			/* NOTE: We expect total integer that is less than 134,217,728 when mutilplied 
	   			 * by length of the string.
	   			 * Validate positive integer.
	   			 * Regex pattern makes sure the user doesnt send in characters that
	   			 * are not actually digits but can be cast to digits.
	   			 */
	    		$lMaximumPHPStringBufferSize = 134217728;
	    		$lLengthOfNullTerminator = 1;
	    		$lMaximumPHPStringBufferSize = $lMaximumPHPStringBufferSize - $lLengthOfNullTerminator;
	    		$lTimesToRepeatStringIsDigits = (preg_match("/^[0-9]{1,9}$/", $lTimesToRepeatString) == 1);
	    		$lStringToRepeatIsReasonable = (preg_match("/^[A-Za-z0-9\.\!\@\#\$\%\^\&\*\(\)\{\}\,\<\.\>\/\?\=\+\-\_]{1,256}$/", $lStringToRepeat) == 1);
	    		$lErrorMessage = "See exception for error message";
	
	    		if(!$lTimesToRepeatStringIsDigits){
	    			$lErrorMessage = "The times to repeat string does not appear to be an integer.";
	    			throw new Exception($lErrorMessage);	
	    		}// end if

	    		if(!$lStringToRepeatIsReasonable){
	    			$lErrorMessage = "The string to repeat does not appear to be reasonable.";
	    			throw new Exception($lErrorMessage);	
	    		}// end if

	    		if(($lTimesToRepeatString * strlen($lStringToRepeat)) > $lMaximumPHPStringBufferSize){
	    			$lErrorMessage = "The buffer that would need to be allocated exceeds the PHP maximum string buffer size.";
	    			throw new Exception($lErrorMessage);	
	    		}// end if

	    	}// end if($lEnableBufferOverflowProtection)

	    	/* Cast second number to integer to make the hack easier to pull off. Users will be tempted
	    	 * put in a number so large, that	   	if($lSubmitButtonClicked){
 the $lTimesToRepeatString number will overflow
	    	 * before the str_repeat function gets a chance to run.
	    	 */
 			$lBuffer = str_repeat($lStringToRepeat, (integer)$lTimesToRepeatString);
    	
	   	}//end if $lSubmitButtonClicked

	} catch(Exception $e){
		$lSubmitButtonClicked = FALSE;
		echo $CustomErrorHandler->FormatError($e, "Error creating client-side challenge");
	}// end try	
?>

<script type="text/javascript">
<!--
	<?php 
		if ($lSubmitButtonClicked) {
			echo "var l_submit_occured = true;" . PHP_EOL;
		}else {
			echo "var l_submit_occured = false;" . PHP_EOL;
		}// end if

		if($lEnableJavaScriptValidation){
			echo "var lValidateInput = true" . PHP_EOL;
		}else{
			echo "var lValidateInput = false" . PHP_EOL;
		}// end if		
	?>

	function onSubmitOfForm(/*HTMLFormElement*/ theForm){
		try{
			var lTimesToRepeatStringAcceptablePattern = RegExp("^[0-9]{1,9}$","gi");
			var lStringToRepeatAcceptablePattern = RegExp("^[A-Za-z0-9\.\!\@\#\$\%\^\&\*\(\)\{\}\,\<\.\>\/\?\=\+\-\_]{1,256}$", "gi");

			if(lValidateInput){
				
				if (theForm.string_to_repeat.value.match(lStringToRepeatAcceptablePattern) == null){
							alert('Dangerous characters detected in string to repeat. We can\'t allow these. This all powerful blacklist will stop such attempts.\n\nMuch like padlocks, filtering cannot be defeated.\n\nBlacklisting is l33t like l33tspeak.');
							return false;
					}// end if

				if (theForm.times_to_repeat_string.value.match(lTimesToRepeatStringAcceptablePattern) == null){
							alert('Times to repeat string does not appear to be a number.');
							return false;
					}// end if

			}// end if(lValidateInput)
			
			return true;
		}catch(e){
			alert("Error: " + e.message);
		}// end catch
	}// end function onSubmitOfForm(/*HTMLFormElement*/ theForm)
//-->
</script>

<!-- Bubble hints code -->
<?php 
	try{
   		$lReflectedXSSExecutionPointBallonTip = $BubbleHintHandler->getHint("ReflectedXSSExecutionPoint");
   		$lBufferOverflowInjectionPointBalloonTip = $BubbleHintHandler->getHint("BufferOverflowInjectionPoint");
		$lHTMLandXSSInjectionPointBalloonTip = $BubbleHintHandler->getHint("HTMLandXSSInjectionPoint");
	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatError($e, "Error attempting to execute query to fetch bubble hints.");
	}// end try
?>

<script type="text/javascript">
	$(function() {
		$('[ReflectedXSSExecutionPoint]').attr("title", "<?php echo $lReflectedXSSExecutionPointBallonTip; ?>");
		$('[ReflectedXSSExecutionPoint]').balloon();
		$('[BufferOverflowInjectionPoint]').attr("title", "<?php echo $lBufferOverflowInjectionPointBalloonTip; ?>");
		$('[BufferOverflowInjectionPoint]').balloon();		
		$('[HTMLandXSSInjectionPoint]').attr("title", "<?php echo $lHTMLandXSSInjectionPointBalloonTip; ?>");
		$('[HTMLandXSSInjectionPoint]').balloon();		
	});
</script>

<div class="page-title">Client-side Control Challenge (Prototype Only - Just Testing)</div>

<?php include_once (__ROOT__.'/includes/back-button.inc');?>
<?php include_once (__ROOT__.'/includes/hints-level-1/level-1-hints-wrapper.inc'); ?>

<?php 
	if ($lEncodeOutput) {
		echo "<!-- Diagnostics: Request Parameters - ";
		echo var_dump($_REQUEST);
		echo "-->";
	}// end if
?>

<div id="id-client-side-control-challenge-form-div" style="text-align:center;">
	<form 	action="index.php?page=client-side-control-challenge.php" 
			method="post" 
			enctype="application/x-www-form-urlencoded" 
			onsubmit="return onSubmitOfForm(this);"
			id="idclient-side-control-challengeForm"
			style="margin-left:auto; margin-right:auto; width:600px;">
		<table>
			<tr>
				<td colspan="2" class="form-header">Please enter flag into all form fields</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="text-align: left;" colspan="2">
					Please enter the following flag into each field and choose the flag in each control.
					For example enter the flag into all text fields and choose the flag in the drop down,
					check the box next to the flag, and select the radio button for the flag.
					<br />
					<br />
					Be certain <span style="font-weight: bold;">every</span> control contains the value of the flag.
					<br />
					<br />
					When all controls have the value of the flag submit the form.
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td class="label" style="text-align: left;">Flag</td>
				<td class="label" style="color: blue;text-align: left;"><?php echo $lRandomFlag;?></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td class="label" style="text-align: left;">Text Box</td>
				<td style="text-align: left;">
					<input HTMLandXSSInjectionPoint="1" type="text" name="textbox" id="id_textbox" size="15" maxlength="15" required="true" autofocus="1" />
				</td>
			</tr>			<tr>
				<td class="label" style="text-align: left;">Read-only Text Box</td>
				<td style="text-align: left;">
					<input HTMLandXSSInjectionPoint="1" type="text" name="textbox" id="id_textbox" size="15" maxlength="15" required="true" autofocus="1" readonly="1" value="42" />
				</td>
			</tr>			
			<tr>
				<td class="label" style="text-align: left;">Short Text Box</td>
				<td style="text-align: left;">
					<input HTMLandXSSInjectionPoint="1" type="text" name="short_textbox" id="id_short_textbox" size="3" maxlength="3" required="true" />
				</td>
			</tr>
			<tr>
				<td class="label" style="text-align: left;">Disabled Text Box</td>
				<td style="text-align: left;">
					<input HTMLandXSSInjectionPoint="1" type="text" name="disabled_textbox" id="id_disabled_textbox" size="15" maxlength="15" required="true" disabled="1" style="background-color:#dddddd;" />
				</td>
			</tr>
			<tr>
				<td class="label" style="text-align: left;">Hidden Text Box</td>
				<td style="text-align: left;">
					<input HTMLandXSSInjectionPoint="1" type="hidden" name="hidden_textbox" id="id_hidden_textbox" size="15" maxlength="15" required="true" />
				</td>
			</tr>
			<tr>
				<td class="label" style="text-align: left;">Defective Text Box</td>
				<td style="text-align: left;">
					<input HTMLandXSSInjectionPoint="1" type="text" name="defective_textbox" id="id_defective_textbox" size="3" maxlength="0" required="true" />
				</td>
			</tr>
			<tr>
				<td class="label" style="text-align: left;">Tricky Text Box</td>
				<td style="text-align: left;">
					<input HTMLandXSSInjectionPoint="1" type="text" name="tricky_textbox" id="id_tricky_textbox" size="15" maxlength="15" required="true" onfocus="javascript:this.blur();" />
				</td>
			</tr>
			<tr>
				<td class="label" style="text-align: left;">Vanishing Text Box</td>
				<td style="text-align: left;">
					<input HTMLandXSSInjectionPoint="1" type="text" name="vanishing_textbox" id="id_vanishing_textbox" size="15" maxlength="15" required="true" onmouseover="javascript:this.type='hidden';" />
				</td>
			</tr>
			<tr>
				<td class="label" style="text-align: left;">Password</td>
				<td style="text-align: left;">
					<input HTMLandXSSInjectionPoint="1" type="password" name="password" id="id_password" size="15" maxlength="15" required="true" />
				</td>
			</tr>
			<tr>
				<td class="label" style="text-align: left;">Button</td>
				<td style="text-align: left;">
					<input HTMLandXSSInjectionPoint="1" type="button" name="button" id="id_button" value="Button" />
				</td>
			</tr>
			<tr>
				<td class="label" style="text-align: left;">Checkbox</td>
				<td style="text-align: left;">
					<input type="checkbox" name="checkbox" id="id_checkbox" value="<?php echo $lRandomFlag;?>" required="true" disabled="1" /><span class="label">Select <?php echo $lRandomFlag;?>?</span><br/>
				</td>
			</tr>
			<tr>
				<td class="label" style="text-align: left;">Radio Button</td>
				<td style="text-align: left;">
					<input type="radio" name="radio" id="id_radio" value="1" required="true" checked="1" /><span class="label">1</span><br/>
					<input type="radio" name="radio" id="id_radio" value="2" required="true" /><span class="label">2</span><br/>
					<input type="radio" name="radio" id="id_radio" value="<?php echo $lRandomFlag;?>" required="true" disabled="1" /><span class="label"><?php echo $lRandomFlag;?></span><br/>
				</td>
			</tr>
						
checkbox
color
date
datetime
datetime-local
email
file
hidden
image
month
number
radio
range
reset
search
tel
time
url
week 			
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<input name="client-side-control-challenge-php-submit-button" class="button" type="submit" value="Submit" />
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
		</table>
	</form>
</div>

<div id="id-client-side-control-challenge-output-div" style="text-align: center; display: none;">
	<table align="center">
		<tr><td></td></tr>
		<tr>
			<td ReflectedXSSExecutionPoint="1" colspan="2" class="hint-header"><?php echo $lBuffer; ?></td>
		</tr>
		<tr><td></td></tr>
	</table>	
</div>

<script type="text/javascript">
	if (l_submit_occured){
		document.getElementById("id-client-side-control-challenge-output-div").style.display="";		
	}// end if l_submit_occured	
</script>

<?php
	if ($_SESSION["showhints"] == 2) {
		include_once './includes/hints-level-2/cross-site-scripting-tutorial.inc';
	}// end if
?>
