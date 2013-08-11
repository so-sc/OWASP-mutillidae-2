
<!-- Bubble hints code -->
<?php 
	try{
   		$lArbitraryRedirectionPointBallonTip = $BubbleHintHandler->getHint("ArbitraryRedirectionPoint");
	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatError($e, "Error attempting to execute query to fetch bubble hints.");
	}// end try
?>

<script type="text/javascript">
	$(function() {
		$('[ArbitraryRedirectionPoint]').attr("title", "<?php echo $lArbitraryRedirectionPointBallonTip; ?>");
		$('[ArbitraryRedirectionPoint]').balloon();
	});
</script>

<div class="page-title">Credits</div>

<?php include_once (__ROOT__.'/includes/back-button.inc');?>
<?php include_once (__ROOT__.'/includes/hints-level-1/level-1-hints-wrapper.inc'); ?>

<?php 
   	switch ($_SESSION["security-level"]){
   		case "0": // This code is insecure
   		case "1": // This code is insecure
   			/* This code is insecure. Direct object references in the form of the "forwardurl"
   			 parameter give the user complete control of the input. Contrary to popular belief, 
   			 input validation, blacklisting, etc is not the best defense. The best defenses are 
   			 probably secure 100% of the time. For direct object references, there are two defenses.
   			 Authorization via ACL or Entitlements is used when transaction requires authentication.
   			 This transaction (forwarding URL) does not require authentication so the other method is used;
   			 mapping. Mapping substitutes a harmless token for the direct object. The direct object in 
   			 this case is the page the user is being forwarded to. We will use mapping to secure this code.
   			
   			 Note: For static links, the best defense is to simply hardcode the links in an anchor tag.
   			 This exercise will use mapping to show how it works, but it should be recognized that 
   			 for giving the user links to click, hardcoding is the best defense.
   			*/ 
   			echo '
				<div class="label">Developed by <a href="mailto:webpwnized@gmail.com">Jeremy "webpwnized" Druin</a>. Based on Mutillidae 1.0 from Adrian &quot;<a href="http://www.irongeek.com" target="_blank">Irongeek</a>&quot; Crenshaw.</div>
				<div>&nbsp;</div>
				<div class="label" ArbitraryRedirectionPoint=\"1\"><a href="index.php?page=redirectandlog.php&forwardurl=http://www.owasp.org">OWASP</a></div>
				<div class="label" ArbitraryRedirectionPoint=\"1\"><a href="index.php?page=redirectandlog.php&forwardurl=http://www.issa-kentuckiana.org/">ISSA Kentuckiana</a></div>
				<div class="label" ArbitraryRedirectionPoint=\"1\"><a href="index.php?page=redirectandlog.php&forwardurl=http://www.owasp.org/index.php/Louisville">OWASP Louisville</a></div>
				<div class="label" ArbitraryRedirectionPoint=\"1\"><a href="index.php?page=redirectandlog.php&forwardurl=https://addons.mozilla.org/en-US/firefox/collections/jdruin/pro-web-developer-qa-pack/">Professional Web Application Developer Quality Assurance Pack</a> by <a href="mailto:mutillidae-development@gmail.com">Jeremy Druin</a></div>
   			';
   		break;
    		
   		case "2":
   		case "3":
   		case "4":
   		case "5": // This code is fairly secure
   			echo '
				<div class="label">Developed by <a href="mailto:webpwnized@gmail.com">Jeremy Druin</a></div>
				<div>&nbsp;</div>
				<div class="label" ArbitraryRedirectionPoint=\"1\"><a href="index.php?page=redirectandlog.php&forwardurl=2">OWASP</a></div>
				<div class="label" ArbitraryRedirectionPoint=\"1\"><a href="index.php?page=redirectandlog.php&forwardurl=3">ISSA Kentuckiana</a></div>
				<div class="label" ArbitraryRedirectionPoint=\"1\"><a href="index.php?page=redirectandlog.php&forwardurl=4">OWASP Louisville</a></div>
				<div class="label" ArbitraryRedirectionPoint=\"1\"><a href="index.php?page=redirectandlog.php&forwardurl=10">Professional Web Application Developer Quality Assurance Pack</a> by <a href="mailto:mutillidae-development@gmail.com">Jeremy Druin</a></div>
			';
  		break;
   	}// end switch
?>