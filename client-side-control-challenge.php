<?php

	class ClientField{

		private $mFieldname = "";
		private $mValue = "";
		private $mIsCorrect = FALSE;
		
		function __construct ($pFieldname, $pValue){
			$this->mFieldname = $pFieldname;
			$this->mValue = $pValue;
		}//end constructor
		
		function getFieldname(){
			return $this->mFieldname;
		}//end method

		function getValue(){
			return $this->mValue;
		}//end method
		
	}// end class

	class ClientFields{
	
		private $mQueue = NULL;

		function __construct (){
			$this->mQueue = new SplDoublyLinkedList();
			$this->mQueue->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO|SplDoublyLinkedList::IT_MODE_KEEP);
		}//end constructor

		function addField($pClientField){
			$this->mQueue->enqueue($pClientField);
		}//end method

		function prettyPrintFields(){
			$lHTMLElements = "";
			for ($this->mQueue->rewind(); $this->mQueue->valid(); $this->mQueue->next()) {
				$lHTMLElements .= '<tr class="report-data"><td>'.$this->mQueue->current()->getFieldname().'</td><td>'.$this->mQueue->current()->getValue().'</td></tr>';
			}//end for
			return $lHTMLElements;
		}//end method

	}// end class
	
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
	   	}//end if !$lProtectAgainstMethodSwitching
	   	
	   	if($lSubmitButtonClicked){

			// if we want to enforce POST method, we need to be careful to specify $_POST
		   	if(!$lProtectAgainstMethodSwitching){
		   		$lTextbox = isset($_REQUEST["textbox"])?$_REQUEST["textbox"]:0;
		   		$lReadonlyTextbox = isset($_REQUEST["readonly_textbox"])?$_REQUEST["readonly_textbox"]:0;
		   		$lShortTextbox = isset($_REQUEST["short_textbox"])?$_REQUEST["short_textbox"]:0;
		   		$lDisabledTextbox = isset($_REQUEST["disabled_textbox"])?$_REQUEST["disabled_textbox"]:0;
		   		$lHiddenTextbox = isset($_REQUEST["hidden_textbox"])?$_REQUEST["hidden_textbox"]:0;
		   		$lDefectiveTextbox = isset($_REQUEST["defective_textbox"])?$_REQUEST["defective_textbox"]:0;
		   		$lTrickyTextbox = isset($_REQUEST["tricky_textbox"])?$_REQUEST["tricky_textbox"]:0;
		   		$lVanishingTextbox = isset($_REQUEST["vanishing_textbox"])?$_REQUEST["vanishing_textbox"]:0;
		   		$lShyTextbox = isset($_REQUEST["shy_textbox"])?$_REQUEST["shy_textbox"]:0;
		   		$lPassword = isset($_REQUEST["password"])?$_REQUEST["password"]:0;
		   		$lCheckbox = isset($_REQUEST["checkbox"])?$_REQUEST["checkbox"]:0;
		   		$lRadio = isset($_REQUEST["radio"])?$_REQUEST["radio"]:0;
		   		$lEmail = isset($_REQUEST["email"])?$_REQUEST["email"]:0;
		   		$lFile = isset($_REQUEST["file"])?$_REQUEST["file"]:0;
		   		$lNumber = isset($_REQUEST["number"])?$_REQUEST["number"]:0;
		   		$lRange = isset($_REQUEST["range"])?$_REQUEST["range"]:0;
		   		$lSearch = isset($_REQUEST["search"])?$_REQUEST["search"]:0;
		   		$lSubmitButton = isset($_REQUEST["client-side-control-challenge-php-submit-button"])?$_REQUEST["client-side-control-challenge-php-submit-button"]:0;
		   	}else{
		   		$lTextbox = isset($_POST["textbox"])?$_POST["textbox"]:0;
		   		$lReadonlyTextbox = isset($_POST["readonly_textbox"])?$_POST["readonly_textbox"]:0;
		   		$lShortTextbox = isset($_POST["short_textbox"])?$_POST["short_textbox"]:0;
		   		$lDisabledTextbox = isset($_POST["disabled_textbox"])?$_POST["disabled_textbox"]:0;
		   		$lHiddenTextbox = isset($_POST["hidden_textbox"])?$_POST["hidden_textbox"]:0;
		   		$lDefectiveTextbox = isset($_POST["defective_textbox"])?$_POST["defective_textbox"]:0;
		   		$lTrickyTextbox = isset($_POST["tricky_textbox"])?$_POST["tricky_textbox"]:0;
		   		$lVanishingTextbox = isset($_POST["vanishing_textbox"])?$_POST["vanishing_textbox"]:0;
		   		$lShyTextbox = isset($_POST["shy_textbox"])?$_POST["shy_textbox"]:0;
		   		$lPassword = isset($_POST["password"])?$_POST["password"]:0;
		   		$lCheckbox = isset($_POST["checkbox"])?$_POST["checkbox"]:0;
		   		$lRadio = isset($_POST["radio"])?$_POST["radio"]:0;
		   		$lEmail = isset($_POST["email"])?$_POST["email"]:0;
		   		$lFile = isset($_POST["file"])?$_POST["file"]:0;
		   		$lNumber = isset($_POST["number"])?$_POST["number"]:0;
		   		$lRange = isset($_POST["range"])?$_POST["range"]:0;
		   		$lSearch = isset($_POST["search"])?$_POST["search"]:0;
		   		$lSubmitButton = isset($_POST["client-side-control-challenge-php-submit-button"])?$_POST["client-side-control-challenge-php-submit-button"]:0;
		   	}//end if !$lProtectAgainstMethodSwitching	

		   	$lFields = new ClientFields();
		   	
		   	$lFields->addField(new ClientField("Textbox", $lTextbox));
		   	$lFields->addField(new ClientField("Readonly Textbox", $lReadonlyTextbox));
		   	$lFields->addField(new ClientField("Short Textbox", $lShortTextbox));
		   	$lFields->addField(new ClientField("Disabled Textbox", $lDisabledTextbox));
		   	$lFields->addField(new ClientField("Hidden Textbox", $lHiddenTextbox));
		   	$lFields->addField(new ClientField("Defective Textbox", $lDefectiveTextbox));
		   	$lFields->addField(new ClientField("Tricky Textbox", $lTrickyTextbox));
		   	$lFields->addField(new ClientField("Vanishing Textbox", $lVanishingTextbox));
		   	$lFields->addField(new ClientField("Shy Textbox", $lShyTextbox));
		   	$lFields->addField(new ClientField("Password Textbox", $lPassword));
		   	$lFields->addField(new ClientField("Checkbox", $lCheckbox));
		   	$lFields->addField(new ClientField("Radio Button", $lRadio));
		   	$lFields->addField(new ClientField("Email Control", $lEmail));
		   	$lFields->addField(new ClientField("File Control", $lFile));
		   	$lFields->addField(new ClientField("Number Control", $lNumber));
		   	$lFields->addField(new ClientField("Range Control", $lRange));
		   	$lFields->addField(new ClientField("Search Textbox", $lSearch));
		   	$lFields->addField(new ClientField("Submit Button", $lSubmitButton));
		   	
	   	}//end if $lSubmitButtonClicked

	} catch(Exception $e){
		$lSubmitButtonClicked = FALSE;
		echo $CustomErrorHandler->FormatError($e, "Error creating client-side challenge");
	}// end try	
?>

<script type="text/javascript">
<!--
	<?php
		if($lSubmitButtonClicked){
			echo "var lSubmitOccured = true" . PHP_EOL;
		}else{
			echo "var lSubmitOccured = false" . PHP_EOL;
		}// end if		

		if($lEnableJavaScriptValidation){
			echo "var lValidateInput = true" . PHP_EOL;
		}else{
			echo "var lValidateInput = false" . PHP_EOL;
		}// end if		
	?>

	function onSubmitOfForm(/*HTMLFormElement*/ theForm){
		try{
			if(lValidateInput){
				var lValidationPattern = RegExp("^[A-Za-z]$","gi");
				var lMessage = 'Only letters are allowed into fields which is weird considering you are supposed to enter a number';

				if (theForm.id_textbox.value.match(lValidationPattern) == null){
					alert("Textbox: "+lMessage);return false;
				}// end if
				if (theForm.id_readonly_textbox.value.match(lValidationPattern) == null){
					alert("Read-only Textbox: "+lMessage);return false;
				}// end if
				if (theForm.id_short_textbox.value.match(lValidationPattern) == null){
					alert("Short Textbox: "+lMessage);return false;
				}// end if
				if (theForm.id_disabled_textbox.value.match(lValidationPattern) == null){
					alert("Disabled Textbox: "+lMessage);return false;
				}// end if
				if (theForm.id_hidden_textbox.value.match(lValidationPattern) == null){
					alert("Hidden Textbox: "+lMessage);return false;
				}// end if
				if (theForm.id_defective_textbox.value.match(lValidationPattern) == null){
					alert("Defective Textbox: "+lMessage);return false;
				}// end if
				if (theForm.id_tricky_textbox.value.match(lValidationPattern) == null){
					alert("Tricky Textbox: "+lMessage);return false;
				}// end if
				if (theForm.id_vanishing_textbox.value.match(lValidationPattern) == null){
					alert("Vanishing Textbox: "+lMessage);return false;
				}// end if
				if (theForm.id_shy_textbox.value.match(lValidationPattern) == null){
					alert("Shy Textbox: "+lMessage);return false;
				}// end if
				if (theForm.id_password.value.match(lValidationPattern) == null){
					alert("Password Textbox: "+lMessage);return false;
				}// end if
				if (theForm.id_checkbox.value.match(lValidationPattern) == null){
					alert("Checkbox: "+lMessage);return false;
				}// end if
				if (theForm.id_radio.value.match(lValidationPattern) == null){
					alert("Radio: "+lMessage);return false;
				}// end if
				if (theForm.id_email.value.match(lValidationPattern) == null){
					alert("Email: "+lMessage);return false;
				}// end if
				if (theForm.id_file.value.match(lValidationPattern) == null){
					alert("File: "+lMessage);return false;
				}// end if
				if (theForm.id_number.value.match(lValidationPattern) == null){
					alert("Number: "+lMessage);return false;
				}// end if
				if (theForm.id_range.value.match(lValidationPattern) == null){
					alert("Range: "+lMessage);return false;
				}// end if	
				if (theForm.id_search.value.match(lValidationPattern) == null){
					alert("Search Textbox: "+lMessage);return false;
				}// end if
				if (theForm.id_client-side-control-challenge-php-submit-button.value.match(lValidationPattern) == null){
					alert("Submit Button: "+lMessage);return false;
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

<style>
	input.box:hover {
	    left: 200px;
	}
	input.box {
	    position: relative;
	    left: 0px;
	}
</style>

<div class="page-title">Client-side Control Challenge (Prototype Only - Just Testing)</div>

<?php include_once (__ROOT__.'/includes/back-button.inc');?>
<?php include_once (__ROOT__.'/includes/hints-level-1/level-1-hints-wrapper.inc'); ?>

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
					<input HTMLandXSSInjectionPoint="1" type="text" name="readonly_textbox" id="id_readonly_textbox" size="15" maxlength="15" required="true" autofocus="1" readonly="1" value="42" />
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
				<td class="label" style="text-align: left;">Shy Text Box</td>
				<td style="text-align: left;">
					<input HTMLandXSSInjectionPoint="1" type="text" name="shy_textbox" id="id_shy_textbox" size="15" maxlength="15" required="true" class="box" />
				</td>
			</tr>
			
			<tr>
				<td class="label" style="text-align: left;">Password</td>
				<td style="text-align: left;">
					<input HTMLandXSSInjectionPoint="1" type="password" name="password" id="id_password" size="15" maxlength="15" required="true" />
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
			<tr>
				<td class="label" style="text-align: left;">Email Control</td>
				<td style="text-align: left;">
					<input type="email" name="email" id="id_email" required="true" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" />
				</td>
			</tr>
			<tr>
				<td class="label" style="text-align: left;">File Upload</td>
				<td style="text-align: left;">
					<input type="file" name="file" id="id_file" required="true" />
				</td>
			</tr>
			<tr>
				<td class="label" style="text-align: left;">Number</td>
				<td style="text-align: left;">
					<input type="number" name="number" id="id_number" min="0" max="999" step="1" required="true" />
				</td>
			</tr>
			<tr>
				<td class="label" style="text-align: left;">Range</td>
				<td style="text-align: left;">
					<input type="range" name="range" id="id_range" min="0" max="999" step="1" required="true" />
				</td>
			</tr>
			<tr>
				<td class="label" style="text-align: left;">Search Textbox</td>
				<td style="text-align: left;">
					<input type="search" name="search" id="id_search" pattern="[a-zA-z]" required="true" />
				</td>
			</tr>		
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<input name="client-side-control-challenge-php-submit-button" id="id_client-side-control-challenge-php-submit-button" class="button" type="submit" value="Submit" />
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
		</table>
	</form>
</div>

<div id="id-client-side-control-challenge-output-div" style="text-align: center; display: none;">
	<table class="main-table-frame" id="idClientFields">	
		<tr class="report-header">
		    <td>Field</td>
		    <td>Value Submitted</td>
		    <td>Correct?</td>
		</tr>
		<?php $lFields->prettyPrintFields(); ?>		
	</table>	
</div>

<script type="text/javascript">
	if (lSubmitOccured){
		document.getElementById("id-client-side-control-challenge-output-div").style.display="";		
	}// end if lSubmitOccured	
</script>

<?php
	if ($_SESSION["showhints"] == 2) {
		include_once './includes/hints-level-2/cross-site-scripting-tutorial.inc';
	}// end if
?>

