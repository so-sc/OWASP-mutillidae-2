<table class="hint-table">
	<tr class="hint-header" 
		id="idBufferOverflowHintHeader"
		title="Click to open this section"
		onclick="toggleBody(this, window.document.getElementById('idBufferOverflowHintBody'), window.document.getElementById('idBufferOverflowHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idBufferOverflowHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Buffer Overflow Hints" src="./images/down_arrow_16_16.png" />
			Buffer Overflow Hints
		</td>
	</tr>
	<tr id="idBufferOverflowHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Buffer Overflow may occcur when input is too large to fit inside the space
			allocated.
			<br/><br/>
			Variables and arguments are limited in the amount of information
		  	they can hold before the amount of data (or the cardinality) exceeds to capacity
		  	of the variable. An unsigned byte can hold the number 255, but the number 256 will
		  	either cause an error, be cast to a different representation, or "roll" the 
		  	variable back to zero.
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Inject very long string, integers larger than 32- and 64-bits, and other 
			overflow input into available parameters.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			Narrow down the exact length of input that overflows a vulnerable input
			parameter.
			<br/><br/>
			<span class="report-header">Example</span>
			<br/><br/>
			Page <a href="./index.php?page=repeater.php">Repeater</a> is vulnerable.
			<br/><br/>
		  	Note: the "Times to Repeat" has some protection as it is cast to an integer. Even
		  	if you overflow "Times to Repeat" by submitting a value larger than "int", the
		  	system should cast the number down to the biggest integer that can be represented
		  	on the system.
			<br/><br/>
			Try to overflow the variable which is created to hold the expanded "String to Repeat".
			The data type of this buffer is PHP:String.
			<br/><br/>
			PHP:String can hold a lot of data but the size is not infinite.
		</td>
	</tr>
</table>