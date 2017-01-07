
<div class="page-title">Installation Instructions</div>

<?php include_once (__ROOT__.'/includes/back-button.inc');?>

<span style="font-weight: bold;text-align: center;">Some Options to run Mutillidae</span>
<div>&nbsp;</div>
<div style="margin:20px">
	<span style="font-weight: bold;">a.	Samurai Web Testing Framework</span>
	<div style="margin:20px">
		i.	Samurai WTF 0.95 is a Linux "Live" DVD to which the users machine boots. 
		Within Samurai is several vulnerable web applications pre-configured to test for 
		vulnerabilities. One of the available applications is Mutillidae version 1. 
		Samurai is preparing to release version 1.0 which will include Mutillidae 2.x.
	</div>

	<span style="font-weight: bold;">b.	XAMPP (Windows , Linux , Mac OS X )</span>
	<div style="margin:20px">
		i.	XAMPP is a single installation package which bundles Apache web server, 
			PHP application server, and MySQL database. XAMPP installs Apache and 
			MySQL as either executable or services and can optionally start these 
			services automatically. Once installed XAMPP provides an "htdocs" 
			directory. This directory is "root" meaning that if you browse to 
			http://localhost/, the web site in that "htdocs" folder is what will 
			be served. Mutillidae is installed by placing the multillidae folder 
			into the htdocs folder. The result is that mutillidae is a sub-site 
			served from the mutillidae folder. This makes the URL for mutillidae
			http://localhost/mutillidae.
	</div>
	<div style="margin:20px">
			The mutillidae files are already in a folder called "mutillidae" when 
			the project is zipped. All that is required is to put the mutillidae 
			folder into the htdocs directory.
	</div>
	<div style="margin:20px">
			The	Mutillidae package can be unzipped into htdocs to install Mutillidae. 
			Simply unzip the compressed mutillidae folder right into the htdocs
			folder. When you are done, the "mutillidae" folder will be inside the 
			"htdocs" folder of XAMMP. All the Mutillidae files are inside that 
			"mutillidae" fodler. Assuming Apache and MySQL are running, the user 
			can open a browser and immediately begin using Mutillidae at 
			http://localhost/mutillidae. Apache automatically serves "index.php"
			which is located in the mutillidae folder. 
	</div>
	<div style="margin:20px">	
		ii.	Download and install "XAMPP" or "XAMPP Lite" for Windows or Linux. If 
			installing on Windows, when the installation asks if you want to install
			Apache and MySQL as services, answer "YES". This allows both to run as 
			Windows services and be controlled via services.msc. Run services.msc
			by typing "services.msc" at the command line. 
			(Start - Run - services.msc - Enter) 
	</div>
	<div style="margin:20px">
		iii. Download Mutillidae
	</div>
	<div style="margin:20px">
		iv.	Unzip Mutillidae. Note the mutillidae project is in a folder called "mutillidae"
	</div>
	<div style="margin:20px">
		v.	Place the entire "mutillidae" directory into XAMPP�s " htdocs" directory
	</div>
	<div style="margin:20px">
		vi.	Browse to mutillidae at http://localhost/mutillidae
	</div>
	<div style="margin:20px">
		vii.	Click the "Setup/reset the DB" link in the main menu.
	</div>
	<div style="margin:20px">
		viii.	Get rid of PHP "strict" errors. They are not compatible with the OWASP ESAPI 
		classes in use in Mutillidae 2.0. The error modifies headers disrupting functionality 
		so this is not simply an annoyance issue. To do this, go to the PHP.INI file  and change the line that reads 
		"error_reporting = E_ALL | E_STRICT" to "error_reporting = E_ALL &amp; ~E_NOTICE &amp; ~E_WARNING &amp; ~E_DEPRECIATED". 
		Once the modification is complete, restart the Apache service. If you are not sure how to restart 
		the service, reboot.
	</div>
	<div style="margin:20px">
		Important note: If you use XAMPP Lite or various version of XAMPP on various operating systems, the path for your 
		php.ini file may vary. You may even have multiple php.ini files in which case try to modify the one in the Apache
		directory first, then the one in the PHP file if that doesnt do the trick.
	</div>
	<div style="margin:20px">
		Windows possible default location C:\xampp\php\php.ini, C:\XamppLite\PHP\php.ini, others
		Linux possible default locations: /XamppLite/PHP/php.ini, /XamppLite/apache/bin/php.ini, others 
	</div>
	<div style="margin:20px">
		ix.	By default, Mutillidae tries to connect to MySQL on the localhost with the username 
		"root" and a blank password. To change this, edit "config.inc" with the correct 
		information for your environment.
	</div>
	<div style="margin:20px">
		x.	NOTE: Once PHP 6.0 arrives in XAMPP, E_ALL will include E_STRICT so the line 
		to change will probably read "error_reporting = E_ALL". In any case, change 
		the error_reporting line to 
		"error_reporting = E_ALL &amp; ~E_NOTICE &amp; ~E_DEPRECIATED".
	</div>
	<div style="margin:20px">
		xi. NOTE: Be sure magic quotes is disabled. In XAMMP it seems to be but using MMAP for
		Apple OS/X seems to have it enabled by default. Just make sure magic quotes is set to 
		off in whatever framework is being used. This setting is in PHP.ini. This includes 
		magic_quotes_gpc, magic_quotes_runtime, and magic_quotes_sybase. 
	</div>		

	<span style="font-weight: bold;">c.	Custom Linux ISO</span>
	<div style="margin:20px">
		i.	Using the Samurai Web Testing Framework as the base operating system, any version of Mutillidae 
		can be installed in addition to the version which comes standard with Samurai. From this custom set-up, 
		a custom ISO can be generated using the Remastersys  package.
	</div>
	<div style="margin:20px">
		With Samurai 0.95, Mutillidae is installed into the /srv/mutillidae directory. To install different 
		versions of Mutillidae and make a custom Linux ISO, the following recipe can be followed:
	</div>
	<div style="margin:40px">
			1.	Locate the default installation of Mutillidae in the /srv/mutillidae directory.<br />
			2.	Rename the current installation. For example rename the "mutillidae" folder to "mutillidae-1.5".<br />
			3.	Download the latest version from www.irongeek.com<br />
			4.	Unzip the "mutillidae" folder from the latest version to the /srv directory.<br />
			5.	Test that mutillidae is updated by browsing to http://localhost/mutillidae<br />
			6.	Test that the original version of mutillidae still works browsing to http://localhost/mutillidae-1.5<br /> 
			7.	Make any changes to Linux, Firefox, or other software desired. For example, the lab environment <br />
				created for the U of L information security course used an updated version of Firefox with several add-ons.<br />
			8.	Ensure the current Remastersys installation is clean by running the command "sudo remastersys clean"<br />
			9.	When ready to create the new ISO, run the command "sudo remastersys backup"<br />
			10.	The custom ISO will be found in the /home/remastersys/remastersys directory<br />
	</div>
	
	<span style="font-weight: bold;">d.	Virtual Machine</span>
	<div style="margin:40px">
		i.	Mutillidae has been tested in a Virtual Box  and VMware Workstation  virtual machines running 
		Windows XP SP3 and Ubuntu. Additionally, Virtual Box virtual machines have been booted from the 
		Samurai 0.95 WTF DVD and the Samurai 0.95/Mutillidae 2.x Custom ISO. The Windows XP SP3 
		installation ran Mutillidae 2.x in the XAMPP environment. The Ubuntu installation was 
		created by installing the Samurai 0.95 WTF to a Linux virtual machine. Basically any of the 
		previously mentioned installation options work equally well in virtual environments.
	</div>
</div>