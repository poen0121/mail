<?php
/*
>> Information

	Title		: hpl_mail function
	Revision	: 2.10.2
	Notes		:

	Revision History:
	When			Create		When		Edit		Description
	---------------------------------------------------------------------------
	05-24-2013		Poen		05-24-2013	Poen		Create the program.
	08-08-2016		Poen		08-08-2016	Poen		Reforming the program.
	09-07-2016		Poen		09-19-2017	Poen		Improve the program.
	09-29-2016		Poen		11-21-2016	Poen		Debug the program error messages.
	02-22-2017		Poen		02-22-2017	Poen		Debug isp function.
	02-22-2017		Poen		02-22-2017	Poen		Debug sender_name function.
	02-22-2017		Poen		02-22-2017	Poen		Debug send function.
	03-27-2017		Poen		03-27-2017	Poen		Improve send function.
	12-08-2017		Poen		12-08-2017	Poen		Additional MX authentication mechanism.
	---------------------------------------------------------------------------

>> About

	Send HTML formatted messages based on SMTP, only one recipient.

	About php.ini Options :

	SMTP - ISP

	smtp_port - port number

	sendmail_from - sender mail

	Use the mb_send_mail function to send mail.

>> Usage Function

	==============================================================
	Include file
	Usage : include('mail/main.inc.php');
	==============================================================

	==============================================================
	Create new Class.
	Usage : Object var name=new hpl_mail();
	Return : object
	--------------------------------------------------------------
	Example :
	$hpl_mail=new hpl_mail();
	==============================================================

	==============================================================
	Set SMTP ISP, the default from php.ini.
	Usage : Object->isp($host);
	Param : string $host (ISP host)
	ISP - IP >>
	 	(Hinet): msa.hinet.net [168.95.4.211]
	 	(SeedNet): tpts5.seed.net.tw [139.175.54.240]
	 	(Giga): smtp.giga.net.tw [203.133.1.121]
	 	(So-net): so-net.net.tw [61.64.127.16]
	 	(SPARQ): mail.sparqnet.net [211.78.130.150]
		(TFN): smtp.anet.net.tw [61.31.233.92]
	 	(APT): mail.apol.com.tw [203.79.224.61]
	 	(EBT): ethome.net.tw [210.58.94.72]
	 	(Seeder): smtp.seeder.net [202.43.64.73]
	Return : boolean
	Return Note : Returns FALSE on error.
	--------------------------------------------------------------
	Example :
	$hpl_mail->isp('msa.hinet.net');
	==============================================================

	==============================================================
	Set SMTP port, the default from php.ini.
	Usage : Object->port($number);
	Param : integer $number (port number)
	Return : boolean
	Return Note : Returns FALSE on error.
	--------------------------------------------------------------
	Example :
	$hpl_mail->port(25);
	==============================================================

	==============================================================
	Set sender's name, the default is `Service`.
	Usage : Object->sender_name($name);
	Param : string $name (sender name)
	Return : boolean
	Return Note : Returns FALSE on error.
	--------------------------------------------------------------
	Example :
	$hpl_mail->sender_name('Service');
	==============================================================

	==============================================================
	Set sender's e-mail, the default from php.ini.
	Usage : Object->sender_mail($mail);
	Param : string $mail (sender e-mail)
	Return : boolean
	Return Note : Returns FALSE on error.
	--------------------------------------------------------------
	Example :
	$hpl_mail->sender_mail('service@system.com');
	==============================================================

	==============================================================
	Add CC mail waiting to send.
	Usage : Object->cc($mail);
	Param : string $mail (target e-mail)
	Return : boolean
	Return Note : Returns FALSE on error.
	--------------------------------------------------------------
	Example :
	$hpl_mail->cc('user01@hotmal.com');
	==============================================================

	==============================================================
	Add BCC mail waiting to send.
	Usage : Object->bcc($mail);
	Param : string $mail (target e-mail)
	Return : boolean
	Return Note : Returns FALSE on error.
	--------------------------------------------------------------
	Example :
	$hpl_mail->bcc('user02@hotmal.com');
	==============================================================

	==============================================================
	Use the php.ini options to send messages in HTML format.
	Usage : Object->send($toMail,$subject,$message)
	Param : string $mail (to mail)
	Param : string $subject (letter subject)
	Param : string $message (letter message)
	Return : boolean
	Return Note : Returns FALSE on error.
	--------------------------------------------------------------
	Example :
	$hpl_mail->send('user@hotmal.com','title','html code');
	==============================================================

>> Example

	$hpl_mail=new hpl_mail();
	$hpl_mail->isp('msa.hinet.net');
	$hpl_mail->port(25);
	$hpl_mail->sender_name('Service');
	$hpl_mail->sender_mail('service@system.com');
	$hpl_mail->cc('user01@hotmal.com');
	$hpl_mail->bcc('user02@hotmal.com');
	$hpl_mail->send('user@hotmal.com','title','html code');

*/
?>