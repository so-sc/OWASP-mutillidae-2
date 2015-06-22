<table class="hint-table">
	<tr class="hint-header" 
		id="idClientSideSecurityControlBypassHintHeader"
		title="Click to open this section" 
		onclick="toggleBody(this, window.document.getElementById('idClientSideSecurityControlBypassHintBody'), window.document.getElementById('idClientSideSecurityControlBypassHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idClientSideSecurityControlBypassHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Client-side Security Control Bypass Hints" src="./images/down_arrow_16_16.png" />Client-side Security Control Bypass Hints</td>
	</tr>
	<tr id="idClientSideSecurityControlBypassHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Some web applications rely on client-side controls such as disabling form fields,
			limiting field size, JavaScript validation or other controls to prevent the 
			user from sending malicious input. In all cases, any client-side control can be bypassed
			or ignored entirely.
			<br/><br/>
			Not all applications that use client-side controls are vulnerable.
			Application which pair all client-side controls with an equivalent server-side version of
			the control may be secure. Quality applications often mirror all server-side 
			controls with the client-side counterpart to reduce network traffic, prevent honest users
			from sending known-bad values and provide guidance.  
			<br/><br/>
			However applications depending solely on client-side controls are
			often vulnerable to injection and/or attacks on application logic.
			<br/><br/>
			<span class="report-header">Discovery Methodology (Static source-code analysis)</span>
			<br/><br/>
			Applications using client-side controls will write the controls using client-side
			languages such as HTML, JavaScript, Cascading Style Sheets and other technologies. By 
			examining the source code for keywords, it is possible to locate client-side controls. While
			not an exhaustive list, the following keywords may be helpful to locate client-side
			controls.
			<br/><br/>
			<span class="label">HTML</span>
			<br/><br/>
			<ul>
			<li>Button, input, select, textarea, optgroup, option or fieldset elements that have a "disabled" attribute</li>
			<li>Input elements with the "required","maxlength","readonly","pattern" or "hidden" attribute</li>
			</ul>
			<br/><br/>
			This gives to us the following list of keywords
			<ul>
				<li>disabled</li>
				<li>required</li>
				<li>maxlength</li>
				<li>readonly</li>
				<li>pattern</li>
				<li>hidden</li>
				<li>attribute</li>
			</ul>			
			<br/><br/>
			Text boxes allow any characters so tend to be paired with the controls above. 
			Some HTML input elements are are restrictive by their nature.
			
			
			<br/><br/>
			<span class="label">CSS</span>
			<br/><br/>
			
			<br/><br/>
			<span class="label">JavaScript</span>
			<br/><br/>
			
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>

			<br/><br/>
			<span class="report-header">Example</span>
			<br/><br/>				
			<br/><br/> 
		  	The goal is to modify the 
		  	initialization vector (IV) in order to cause the user ID and group ID
		  	to both be "000". When this occurs a message will appear.
			<br/><br/>
			Note that in security level 0 the user ID and group ID are already "100". 
			Only the first
			character ("1") needs to be modified. Try to leave the "00" alone.
			<br/><br/>
	  		First, determine which of the bytes affects the user ID and group ID respectively.
	  		Modify each byte until the user ID and group ID are affected. Note the position
	  		of the bytes carefully. One byte in the IV will affect the "1" in the user
	  		ID and another byte will affect the "1" in the group ID.
			<br/><br/>
	  		A byte can only have 255 distinct values. One way to solve this problem
	  		is to brute force the answer by trying all 255 bytes until a "0" appears
	  		where the "1" is currently shown.
			<br/><br/>
	  		A much better way is to XOR the value you input with the value that appears
	  		in the User ID or Group ID. This is the respective byte of the cipher text.
	  		Next, XOR this byte of cipher text with the byte you want to appear; "0" which
	  		is 0X30. Input this result into the IV in the same position that was tampered
	  		with to modify the "1" in the User ID or Group ID.
			<br/><br/>
		  	The answer is "6bc24fc1aa650b24b4114e93a98f1eba" for security level 0 but
		  	not for security level 1. Note the initial user ID in security level
		  	1 is more challenging to change correctly.
			<br/><br/>
			<span class="report-header">Videos</span>
			<br/><br/>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->IntroductiontolocatingReflectedCrosssiteScripting);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->IntroductiontoHTMLInjectionHTMLiandCrossSiteScriptingXSSUsingMutillidae);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->TwoMethodstoBypassJavaScriptValidation);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->XSSbypassingJavaScriptValidation);?>
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->HowtoBypassMaxlengthRestrictionsonHTMLInputFields);?>
			<br/><br/>
		</td>
	</tr>
</table>