<?php 
	$lParentPagePath = dirname($_SERVER['PHP_SELF']);
	$lStyleSheetRelativePath = "styles/global.css";
	$lStyleSheetAbsolutePath = $lParentPagePath . "/" . $lStyleSheetRelativePath;
?>
<table class="hint-table">
	<tr class="hint-header" 
		id="idPathRelativeStylesheetInjectionHintHeader"
		title="Click to open this section" 
		onclick="toggleBody(this, window.document.getElementById('idPathRelativeStylesheetInjectionHintBody'), window.document.getElementById('idPathRelativeStylesheetInjectionHintHeaderImage'));"
		onmouseover="this.style.backgroundColor='#cccccc';this.style.color='#ffffff';"
		onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000';"
	>
		<td><img id="idPathRelativeStylesheetInjectionHintHeaderImage" align="left" style="padding-right: 5px;" alt="Expand Path Relative Stylesheet Injection Hints" src="./images/down_arrow_16_16.png" />Path Relative Stylesheet Injection Hints</td>
	</tr>
	<tr id="idPathRelativeStylesheetInjectionHintBody" style="display: none;">
		<td class="hint-body">
			<br/><br/>
			<span class="report-header">Overview</span>
			<br/><br/>
			Web applications often link common code to avoid having multiple copies
			of the same source within a site. This is a best practice that allows
			a developer to correct a defect or add an upgrade into a single file
			and have that new code propogate through out the entire application.
			Stylesheets, JavaScript and other &quot;includes&quot; are often linked
			using &quot;link&quot; tags and &quot;script&quot; tags respectively. In the 
			case of a link tag, the &quot;href&quot; attribute specifies the path
			of the include file. For script tags the &quot;attribute&quot; does the 
			same.
			<br/><br/>
			Links can be &quot;relative&quot; or &quot;absolute&quot;. Absolute links
			specfify the full path to the resource file. An example would be
			<br/><br/>
			<span class="important-code">
			&lt;a href=&quot;<?php echo $lStyleSheetAbsolutePath; ?>&quot; target=&quot;_blank&quot;&gt;<a href="<?php echo $lStyleSheetAbsolutePath; ?>" target="_blank">
				<?php echo $lStyleSheetAbsolutePath; ?>
			</a>&lt;/a&gt;
			</span>
			<br/><br/>
			Relative links specify the path from the current page. The path for this page is 
			<span class="important-code"><?php echo $lParentPagePath ?></span>.
			A reference to the same stylesheet could be done with
			<br/><br/>
			<span class="important-code">
			&lt;a href=&quot;<?php echo $lStyleSheetRelativePath; ?>&quot; target=&quot;_blank&quot;&gt;<a href="<?php echo $lStyleSheetRelativePath; ?>" target="_blank">
				<?php echo $lStyleSheetRelativePath; ?>
			</a>&lt;/a&gt;
			</span>
			<br/><br/>
			Hover your mouse over the relative link above and look in your browsers
			status bar to see how the browser will resolve this relative link. The path
			of the parent page that is including the resource is the base URL.
			The browser will automatically append the base URL page with the 
			link specified in the &quot;href&quot; attribute resulting in a
			<span class="important">&quot;real&quot;</span> path of
			<br/><br/>
			<span class="important-code">
			<?php echo $lStyleSheetAbsolutePath; ?>
			</span>
			<br/><br/>
			The browser will make a request to the web server for the stylesheet
			using this path. You may want to observe this behavior using 
			<span class="important">Burp-Suite</span>
			or via the <span class="important">Developer --&gt; Network tool</span>
			in Firefox.
			<br/><br/>
			If the paths to include files are relative and the user can control the base URL
			then it may be possible to trick the browser into constructing the 
			path to the included file incorrectly.
			<br/><br/>
			<span class="report-header">Example</span>
			<br/><br/>
			The page in Mutillidae that implements path relative
			stylesheet injection (in addition to several other vulnerabilities)
			is styling.php. The page is framed by styling-frame.php. Assuming the 
			default installation, the direct URL to the styling.php page is
			<a href="http://localhost/mutillidae/styling.php" target="_blank">http://localhost/mutillidae/styling.php</a>
			. The styling.php page contains a path relative link to the global 
			styles page global-styles.css located in the &quot;styles&quot;
			directory. The link element is written similar to 
			<br/><br/>
			<span class="important-code">
			&lt;link rel=&quot;stylesheet&quot; type=&quot;text/css&quot; href=&quot;./styles/global-styles.css&quot; /&gt;
			</span>
			<br/><br/>
			When the browser loads URL
			<br/><br/>
			<span class="important-code">http://localhost/mutillidae/styling.php</span>
			<br/><br/>
			it will see the relative link to 
			<br/><br/>
			<span class="important-code">./styles/global-styles.css</span>
			<br/><br/>
			. To load global styles the browser determines the base
			URL from the parent page to be 
			<br/><br/>
			<span class="important-code">http://localhost/mutillidae/</span>
			<br/><br/>
			then appends the relative link for the 
			<br/><br/>
			<span class="important-code">global-styles.css</span>
			<br/><br/>
			page.
			The resulting URL for the stylesheet will be
			<br/><br/>
			<span class="important-code">
			<span style="color:black">http://localhost/mutillidae/</span><span style="color:dark red">styles/global-styles.css</span>
			</span>
			<br/><br/>
			The user may add additional directories beyond the end of the file name.
			This can cause significant confusion for the browser and may result
			in different behavior between the browser and the web server. One such
			URL may be
			<br/><br/>
			<span class="important-code"><span style="color:black">http://localhost/mutillidae/styling.php</span>/foo/bar</span>
			<br/><br/>
			The browser may calculate the base URL to be 
			<br/><br/>
			<span class="important-code"><span style="color:black">http://localhost/mutillidae/styling.php</span>/foo</span>
			<br/><br/>
			When this base URL is used to determine the URL for the global-styles.css 
			stylesheet, the resulting file path will be 
			<br/><br/>
			<span class="important-code"><span style="color:black">http://localhost/mutillidae/styling.php</span>/foo/styles/global-styles.css</span>
			<br/><br/>
			The browser will send a request to the web server to fetch the file	
			<span class="important-code"><span style="color:black">/mutillidae/styling.php</span>/foo/styles/global-styles.css</span>
			. The file does not exist but it turns out this may not matter. Web servers
			tend to determine file paths at least partially based on the file extention.
			The file extention in this case is &quot;.php&quot;. The Apache or IIS
			web server hosting Mutillidae will probably consider the file path to be
			<br/><br/>
			<span class="important-code">http://localhost/mutillidae/styling.php</span>
			<br/><br/>
			The web server will respond to the request for the stylesheet with a second 
			copy of page <span class="important">styling.php</span>. Page 
			<span class="important">styling.php</span>
			is an HTML document. HTML documents that are well-formed
			will send an HTTP response header of 
			&quot;<span class="important">Content-Type: text/html</span>&quot; 
			declaring the content to be HTML. However, the browser 
			(from its point of view) attempted to fetch a stylesheet (CSS document). 
			How the browser handles this situation will determine the outcome 
			of this 
			&quot;<span class="important">Relative Path Overwrite</span>&quot;
			(Credit: Gareth Heyes).
			<br/><br/>
			If the browser interprets the HTML document strictly, processing will
			stop since the document returned by the web server does not 
			have the required <span class="important">Content-Type</span> of 
			&quot;<span class="important">text/css&quot;</span>. Browsers
			may relax strictness if running in compatibility mode or processing
			files with older document types (i.e. &quot;transitional&quot;). View
			the source of the <span class="important">styling.php</span> page 
			in Mutillidae to see a document
			type set to <span class="important">Transitional</span>.
			The document type is declared at the top of the HTML document. 
			Note: See the Burp-Suite blog for a discusion on &quot;quirks mode&quot;.
			<br/><br/>
			In cases where the browser parses the HTML document, any CSS contained
			in the HTML document may be executed. Any CSS contained in the HTML
			document is not likely to be malicious of course; however, some 
			web application pages allow user input. If a malicious CSS is injected
			into the HTML document and that HTML document is fetched by a 
			browser attempting to load CSS, the injected CSS may be executed
			by the browser. 
			<br/><br/>
			<span class="report-header">Discovery Methodology</span>
			<br/><br/>
			Discovering pages with this vulnerability can be difficult because of 
			the number of variables that influence whether a page is vulnerable.
			The application framework and web server need to interpret the URL
			based on page name while the browser simultaneously interprets the
			URL based on the full path. The browser also has to be willing to 
			parse and execute CSS found inside of non-css documents. Also
			a would-be attacker will need some mechanism by which they can 
			inject malicious CSS into that non-css document. To set the 
			browser into compatibility mode, it may be neccesay to frame the 
			victim page in order to set compatibility mode within the framing
			page.
			<br/><br/>
			One possible approach is to identify pages which contain relative
			links to stylesheets and/or JavaScript include files. When found
			check if the page sets the Content-Type HTTP response header
			correctly. If the response header is present, it may still be possible
			to place the browser into compatibility mode by framing the page. 
			check if the page allows itself to be framed.
			<br/><br/>
			<span class="report-header">Exploitation</span>
			<br/><br/>
			TO DO
			<br/><br/>
			<span class="report-header">Example</span>
			<br/><br/>
			http://172.16.0.130/mutillidae/index.php?page=styling-frame.php&amp;page-to-frame=styling.php/foo/bar/%0A{}*{color:red;}///
			<br/><br/>
			<span class="report-header">References</span>
			<br/><br/>
			<a href="http://www.thespanner.co.uk/2014/03/21/rpo/" target="_blank">Relative Path Overwrite by Gareth Heyes</a>
			<br/>
			<a href="http://blog.portswigger.net/" target="_blank">PortSwigger Web Security Blog</a>
			<br/><br/>
		</td>
	</tr>
</table>