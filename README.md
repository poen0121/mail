# mail
PHP Library ( PHP >= 5.2 ) CLI,CGI

> About

	Send HTML formatted messages based on SMTP, only one recipient.

	About php.ini Options :

	SMTP - ISP

	smtp_port - port number

	sendmail_from - sender mail

	Use the mb_send_mail function to send mail.

> Learning Documents

    Please read `readme.php` document.

> Example

	$hpl_mail=new hpl_mail();
	$hpl_mail->isp('msa.hinet.net');
	$hpl_mail->port(25);
	$hpl_mail->sender_name('Service');
	$hpl_mail->sender_mail('service@system.com');
	$hpl_mail->cc('user01@hotmal.com');
	$hpl_mail->bcc('user02@hotmal.com');
	$hpl_mail->send('user@hotmal.com','title','html code');
