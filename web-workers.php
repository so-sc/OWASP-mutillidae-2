<?php 

	try{
		switch ($_SESSION["security-level"]){
	   		case "0": // This code is insecure
	   		case "1": // This code is insecure
	   			// DO NOTHING: This is insecure		
				$lEncodeOutput = FALSE;
				$luseSafeJavaScript = "false";
			break;

			case "2":
			case "3":
			case "4":
	   		case "5": // This code is fairly secure
	  			/* 
	  			 * NOTE: Input validation is excellent but not enough. The output must be
	  			 * encoded per context. For example, if output is placed	 in HTML,
	  			 * then HTML encode it. Blacklisting is a losing proposition. You 
	  			 * cannot blacklist everything. The business requirements will usually
	  			 * require allowing dangerous charaters. In the example here, we can 
	  			 * validate username but we have to allow special characters in passwords
	  			 * least we force weak passwords. We cannot validate the signature hardly 
	  			 * at all. The business requirements for text fields will demand most
	  			 * characters. Output encoding is the answer. Validate what you can, encode it
	  			 * all.
	  			 * 
	  			 * For JavaScript, always output using innerText (IE) or textContent (FF),
	  			 * Do NOT use innerHTML. Using innerHTML is weak anyway. When 
	  			 * attempting DHTML, program with the proper interface which is
	  			 * the DOM. Thats what it is there for.
	  			 */
	   			// encode the output following OWASP standards
	   			// this will be HTML encoding because we are outputting data into HTML
				$lEncodeOutput = TRUE;
				$luseSafeJavaScript = "true";
	   		break;
	   	}// end switch
    } catch (Exception $e) {
		echo $CustomErrorHandler->FormatError($e, "Error collecting browser information");
    }// end try;
?>

<!-- Bubble hints code -->
<?php 
	try{
   		$lJavaScriptInjectionPointBallonTip = $BubbleHintHandler->getHint("JavaScriptInjectionPoint");
	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatError($e, "Error attempting to execute query to fetch bubble hints.");
	}// end try	
?>

<script type="text/javascript">
	$(function() {
		$('[JavaScriptInjectionPoint]').attr("title", "<?php echo $lJavaScriptInjectionPointBallonTip; ?>");
		$('[JavaScriptInjectionPoint]').balloon();
	});
</script>

<div class="page-title">Web Workers</div>

<?php include_once (__ROOT__.'/includes/back-button.inc');?>
<?php include_once (__ROOT__.'/includes/hints-level-1/level-1-hints-menu-wrapper.inc'); ?>

<button onclick="unknownCmd()">Send command</button>
<output id="result"></output>

<script>

  function unknownCmd() {
    worker.postMessage({'cmd': 'foobard', 'msg': '???'});
  }

  var worker = new Worker('javascript/web-worker.js');

  worker.addEventListener('message', function(e) {
    document.getElementById('result').textContent = e.data;
  }, false);

</script>

<script id="idWebWorker" type="javascript/worker">
	self.addEventListener('message', function(e) {
		try{
			var lXMLHTTP;
			var lURL = "http://localhost/mutillidae/includes/config.inc";
			var lRequestMethod = "GET";
			var lAsyncronousRequestFlag = true;
			
			lXMLHTTP = new XMLHttpRequest();
			
			lXMLHTTP.onreadystatechange=function(){
				if (lXMLHTTP.readyState==4 && lXMLHTTP.status==200){
					try{
						self.postMessage("Page Contents: " + lXMLHTTP.response);
					}catch(e){
						lErrorMessage.style.display="";
						self.postMessage(lXMLHTTP.response);
					}// end catch
				}; // end if
			}; //end function
			lXMLHTTP.open(lRequestMethod, lURL, lAsyncronousRequestFlag);
			lXMLHTTP.send(); 
		}catch(e){
			self.postMessage("Error: " + e.message);
		}// end catch
			
	}, false);
</script>

<script>

	//Depending on browser/version we get the browser context for the object
	// The "Blob()" object will be available in the future
	var BlobBuilder = window.BlobBuilder || window.WebKitBlobBuilder || window.MozBlobBuilder || window.MSBlobBuilder;
	window.URL = window.URL || window.webkitURL;

	/*
	[Constructor]
	interface BlobBuilder {
	    Blob getBlob (optional DOMString contentType);
	    void append (DOMString text, optional DOMString endings);
	    void append (Blob data);
	    void append (ArrayBuffer data);
	};
	*/
	var bb = new BlobBuilder();

	bb.append(document.getElementById("idWebWorker").textContent);
	var workerURL = window.URL.createObjectURL(bb.getBlob());

	var webWorker = new Worker(workerURL);

	webWorker.addEventListener('message', function(e) {
	    document.getElementById('result').textContent = e.data;
	}, false);	

	webWorker.postMessage("StartWebWorker");

</script>

<fieldset>
	<legend>Web Worker</legend>
	<div>
		<a href="http://localhost/mutillidae/index.php?page=captured-data.php" style="text-decoration: none;">
		<img style="vertical-align: middle;" src="./images/cage.png" height="50px" width="50px" />
		<span style="font-weight:bold; cursor: pointer;">&nbsp;View Captured Data</span>
		</a>
	</div>
	<div>&nbsp;</div>
	<table border="1px" width="95%" class="main-table-frame">
		<tr><td colspan="3" id="id_result"></td></tr>
	   	<tr><td colspan="3"></td></tr>
	</table>
</fieldset>

<?php
	// Begin hints section
	if ($_SESSION["showhints"]) {
		echo '
			<br/ >
			<table style="width:90%">
				<tr><td class="hint-header">Hints</td></tr>
				<tr>
					<td class="hint-body">
						<ul class="hints">
						  	<li>This page is vulnerable to XSS via JavaScript string injection.
						  	Change the string for user-agent (for example) to a script.
							</li>
						</ul>
					</td>
				</tr>
			</table>'; 
	}//end if ($_SESSION["showhints"])

	if ($_SESSION["showhints"] == 2) {
		include_once (__ROOT__.'/includes/hints-level-2/cross-site-scripting-tutorial.inc');
	}// end if
?>