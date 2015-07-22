			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Given an encrypted value, CBC Bit Flipping 
			can be used to alter the decrypted plain text. If the plain
			text is used by the system to make decisions (such as the
			user privilege level), the system can be influenced by
			CBC bit flipping.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Toggle bits and bytes of initialization vectors and observe changes to the
			plain text.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Alter the initialization vector only in the bits or bytes that affect
			the target plain text. Small amounts of plain text can be brute forced.
			For better results, calculate the value of initialization vector
			needed to produce the plain text desired.
			<br/><br/>
			<span class="report-header">Example</span>
			<br/><br/>				
		  	The view user privilege level page is vulnerable to cipher block chaining (CBC) bit flipping.
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
			<?php echo $YouTubeVideoHandler->getYouTubeVideo($YouTubeVideoHandler->IntroductiontoCBCBitFlippingAttack);?>
		  	<br/><br/>