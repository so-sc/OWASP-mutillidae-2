<?php
	require_once (__ROOT__.'/classes/YouTubeVideoHandler.php');
	$YouTubeVideoHandler = new YouTubeVideoHandler("owasp-esapi-php/src/", $_SESSION["security-level"]);

	if ($_SESSION["showhints"] > 0) {
		require_once 'level-1-hints.js.inc';
		$lDisplayHintStyle = "block";
	}else{
		$lDisplayHintStyle = "none";
	}//end if
?>

<div  	class="hint-wrapper-header" 
		id="idHintWrapperHeader"
		title="Click to open this section"
		onclick="toggleBody(this, window.document.getElementById('idHintWrapperBody'), window.document.getElementById('idHintWrapperHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
		style="display: <?php echo $lDisplayHintStyle; ?>";
>
	<img id="idHintWrapperHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Hints" src="./images/down_arrow_16_16.png" />
	Hints
</div>
<div id="idHintWrapperBody" class="hint-wrapper-body" style="display: none;">
	<?php 
		if ($_SESSION["showhints"] > 0) {
			$lPageName = $_GET["page"];
			$lIncludeFileRecords = $SQLQueryHandler->getPageLevelOneHelpIncludeFiles($lPageName);
			
			if ($SQLQueryHandler->affected_rows()>0) {
				while($lRecord = $lIncludeFileRecords->fetch_object()){
					include_once (__ROOT__.'/includes/hints-level-1/'.$lRecord->level_1_help_include_file);
				}// end while
			}else{
				include_once (__ROOT__.'/includes/hints-level-1/hints-not-found.inc');
			}// end if
		}//end if $_SESSION["showhints"] > 0
	?>
</div>