<?php 

/* Error output gets overlooked sometimes. On the one hand, no website
 * should actually output error diagnostic error information to 
 * the web page because the user can see it. However, that is not the responsibility
 * of this class anyway. This class is responsible for formatting the error. It is
 * up to the caller to decide where to output this information. Errors should be logged
 * then reported to the support team, but not shown on the web page. 
 * This error handler is responsible for outputting the information safety. If the 
 * input that caused the error is XSS for enample, then the log will have XSS in it.
 * If this error is emailed to support staff, then the email would have XSS in it.
 * So it is important that this error handler make sure all dynamic output is properly 
 * encoded. For both email and error logs, this typically calls for HTML encoding.
 * 
 * Known Vulnerabilities In This Class: Cross Site Scripting,
 * Cross Site Request Forgery, Application Exception,
 * SQL Exception
 */

class CustomErrorHandler{
	
	//default insecure: no output encoding.
	protected $encodeOutput = FALSE;
	protected $mSecurityLevel = 0;
	protected $ESAPI = null;
	protected $Encoder = null;

	private function FormatErrorTable(Exception $e, $pDiagnosticInformation){

		if (!$this->encodeOutput){
   			// encode the entire message following OWASP standards
   			// this is HTML encoding because we are outputting data into HTML
			$lLine = $e->getLine();
			$lCode = $e->getCode();
			$lFile = $e->getFile();
			$lMessage = $e->getMessage();
			$lTrace = $e->getTraceAsString();
			$lDiagnosticInformation = $pDiagnosticInformation;
		}else{
			/* Cross site scripting defense */
			$lLine = $this->Encoder->encodeForHTML($e->getLine());
			$lCode = $this->Encoder->encodeForHTML($e->getCode());
			$lFile = $this->Encoder->encodeForHTML($e->getFile());
			$lMessage = $this->Encoder->encodeForHTML($e->getMessage());
			$lTrace = $this->Encoder->encodeForHTML($e->getTraceAsString());
			$lDiagnosticInformation = $this->Encoder->encodeForHTML($pDiagnosticInformation);
		}// end if
		
		return
		'<fieldset>
			<legend>Error Message</legend>
			<table>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td colspan="2" class="error-header">Failure is always an option</td>
				</tr>
				<tr>
					<td class="error-label">Line</td><td class="error-detail">' . $lLine . '</td>
				</tr>
				<tr>
					<td class="error-label">Code</td><td class="error-detail">' . $lCode . '</td>
				</tr>
				<tr>
					<td class="error-label">File</td><td class="error-detail">' . $lFile . '</td>
				</tr>
				<tr>
					<td class="error-label">Message</td><td class="error-detail">' . $lMessage . '</td>
				</tr>
				<tr>
					<td class="error-label">Trace</td><td class="error-detail">' . $lTrace . '</td>
				</tr>
				<tr>
					<td class="error-label">Diagnotic Information</td><td class="error-detail">' . $lDiagnosticInformation . '</td>
				</tr>
				<tr>
					<td colspan="2" class="error-header" style="text-align: center;"><a href="set-up-database.php">Click here to reset the DB</a></td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
			</table>
		</fieldset>';

	}// end private function FormatErrorTable

	private function FormatErrorTableForUser(){
		$lMessage = 'Sorry. An error occured. Support has been notified.';
		return 
		'<table>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td colspan="2" class="error-header">Error: Failure is always an option and this situation proves it</td>
			</tr>
			<tr>
				<td class="error-label">Message</td><td class="error-detail">' . $lMessage . '</td>
			</tr>
			<tr>
				<td colspan="2" class="error-header" style="text-align: center;">Did you <a href="set-up-database.php">setup/reset the DB</a>?</td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
		</table>';
	}// end private function FormatErrorTableForUser()
	
	private function doSetSecurityLevel($pSecurityLevel){
		$this->mSecurityLevel = $pSecurityLevel;
		
		switch ($this->mSecurityLevel){
	   		case "0": // This code is insecure, we are not encoding output
	   		case "1": // This code is insecure, we are not encoding output
				$this->encodeOutput = FALSE;
	   		break;

	   		case "2":
			case "3":
			case "4":
	   		case "5": // This code is fairly secure
	  			// If we are secure, then we encode all output.
	   			$this->encodeOutput = TRUE;
	   		break;
	   	}// end switch		
	}// end function

	private function formatExceptionMessage(Exception $e, $pDiagnosticInformation){
		return sprintf("%s on line %d: %s %s (%d) [%s] <br />\n", $e->getFile(), $e->getLine(), $e->getMessage(), $pDiagnosticInformation, $e->getCode(), get_class($e));
	}// end private function formatExceptionMessage()
	
	public function __construct($pPathToESAPI, $pSecurityLevel){
		
		$this->doSetSecurityLevel($pSecurityLevel);
		
		//initialize OWASP ESAPI for PHP
		require_once $pPathToESAPI . 'ESAPI.php';
		$this->ESAPI = new ESAPI($pPathToESAPI . 'ESAPI.xml');
		$this->Encoder = $this->ESAPI->getEncoder();
	}// end function
	   	
	public function setSecurityLevel($pSecurityLevel){
		$this->doSetSecurityLevel($pSecurityLevel);
	}// end function setSecurityLevel

	public function getExceptionMessage(Exception $e, $pDiagnosticInformation){		
		$lExceptionMessage = "";
		
		/* getPrevious introduced in PHP 5.3.0 */
		if (method_exists($e,"getPrevious")){
			do {
	        	$lExceptionMessage .= $this->formatExceptionMessage($e, $pDiagnosticInformation);
	    	} while($e = $e->getPrevious());
		}else{
			$lExceptionMessage = $this->formatExceptionMessage($e, $pDiagnosticInformation);						
		}// end if method_exists
		
    	return $lExceptionMessage;
	}//end function getExceptionMessage
	
	public function FormatError(Exception $e, $pDiagnosticInformation){
	
		switch ($this->mSecurityLevel){
	   		case "0": // This code is insecure, we are not encoding output
	   		case "1": // This code is insecure, we are not encoding output
	   			$lErrorMessage = $this->FormatErrorTable($e, $pDiagnosticInformation); 
				return $lErrorMessage;
			break;
	   		
			case "2":
			case "3":
			case "4":
	   		case "5": // This code is fairly secure
	  			/* A secure error handler performs 3 critical functions but it does
	  			 * not tell the user about the error details
	  			 * 
	  			 * Error handlers perform these 3 basic functions
	  			 * 1. Log the error details
	  			 * 2. Tell the user what to do (i.e.e - try again, call help desk, etc.)
	  			 * 3. Notify support of error details (i.e. - email, page, etc.)
	  			 */
	   			// emailSupport(FormatErrorTable(Exception $e, $pDiagnosticInformation));
	   			// logError(FormatErrorTable(Exception $e, $pDiagnosticInformation));
	   			$lErrorMessage = $this->FormatErrorTableForUser($e, $pDiagnosticInformation); 
				return $lErrorMessage;
	   		break;
	   		
	   		default: 
	   			echo "Error in CustomErrorHandler->public function FormatError(Exception $e, $pDiagnosticInformation)";
	   		break;
	   		
	   	}// end switch		
	
	}// end public function FormatError()
	
}// end class

?>