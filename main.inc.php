<?php
if (!class_exists('hpl_mail')) {
	include (str_replace('\\', '/', dirname(__FILE__)) . '/system/inspect/main.inc.php');
	/**
	 * @about - HTML mail send.
	 * @return - object
	 * @usage - Object var name=new hpl_mail();
	 */
	class hpl_mail {
		private $SIGN_SENDER_NAME, $BCC_LIST, $CC_LIST;
		function __construct() {
			$this->CC_LIST = array ();
			$this->BCC_LIST = array ();
			$this->SIGN_SENDER_NAME = 'Service';
			hpl_func_arg :: delimit2error();
		}
		/** Error handler.
		 * @access - private function
		 * @param - integer $errno (error number)
		 * @param - string $message (error message)
		 * @return - boolean|null
		 * @usage - set_error_handler(__CLASS__.'::ErrorHandler');
		 */
		private static function ErrorHandler($errno = null, $message = null) {
			if (!(error_reporting() & $errno)) {
				// This error code is not included in error_reporting
				return;
			}
			//replace message target function
			$caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
			$caller = end($caller);
			$message = __CLASS__ . '::' . $caller['function'] . '(): ' . $message;
			//response message
			hpl_error :: cast($message, $errno, 3);
			/* Don't execute PHP internal error handler */
			return true;
		}
		/** Set SMTP ISP, the default from php.ini.
		 * @access - public function
		 * @param - string $host (ISP host)
		 * ISP - IP >>
		 * 	(Hinet): msa.hinet.net [168.95.4.211]
		 * 	(SeedNet): tpts5.seed.net.tw [139.175.54.240]
		 * 	(Giga): smtp.giga.net.tw [203.133.1.121]
		 * 	(So-net): so-net.net.tw [61.64.127.16]
		 * 	(SPARQ): mail.sparqnet.net [211.78.130.150]
		 * 	(TFN): smtp.anet.net.tw [61.31.233.92]
		 * 	(APT): mail.apol.com.tw [203.79.224.61]
		 * 	(EBT): ethome.net.tw [210.58.94.72]
		 * 	(Seeder): smtp.seeder.net [202.43.64.73]
		 * @return - boolean
		 * @usage - Object->isp($host);
		 */
		public function isp($host = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				if (!isset ($host { 0 })) {
					hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Empty SMTP ISP host supplied as input', E_USER_NOTICE, 1);
				} else {
					if (ini_set('SMTP', $host) !== false) {
						return true;
					} else {
						hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Invalid on the server', E_USER_NOTICE, 1);
					}
				}
			}
			return false;
		}
		/** Set SMTP port, the default from php.ini.
		 * @access - public function
		 * @param - integer $number (port number)
		 * @return - boolean
		 * @usage - Object->port($number);
		 */
		public function port($number = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: int2error(0)) {
				if ($number < 0) {
					hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): The SMTP port number should be >= 0', E_USER_NOTICE, 1);
				} else {
					if (ini_set('smtp_port', $number) !== false) {
						return true;
					} else {
						hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Invalid on the server', E_USER_NOTICE, 1);
					}
				}
			}
			return false;
		}
		/** Set sender's name, the default is `Service`.
		 * @access - public function
		 * @param - string $name (sender name)
		 * @return - boolean
		 * @usage - Object->sender_name($name);
		 */
		public function sender_name($name = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				if (!isset ($name { 0 })) {
					hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Empty sender name supplied as input', E_USER_NOTICE, 1);
				} else {
					$this->SIGN_SENDER_NAME = $name;
					return true;
				}
			}
			return false;
		}
		/** Set sender's e-mail, the default from php.ini.
		 * @access - public function
		 * @param - string $mail (sender e-mail)
		 * @return - boolean
		 * @usage - Object->sender_mail($mail);
		 */
		public function sender_mail($mail = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				if (!hpl_inspect :: is_mail($mail)) {
					hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Incorrect e-mail format', E_USER_NOTICE, 1);
				} else {
					if (ini_set('sendmail_from', $mail) !== false) {
						return true;
					} else {
						hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Invalid on the server', E_USER_NOTICE, 1);
					}
				}
			}
			return false;
		}
		/** Add CC mail waiting to send.
		 * @access - public function
		 * @param - string $mail (target e-mail)
		 * @return - boolean
		 * @usage - Object->cc($mail);
		 */
		public function cc($mail = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				if (hpl_inspect :: is_mail($mail)) {
					if (count($this->CC_LIST) < 2147483647) {
						$this->CC_LIST[] = $mail;
						return true;
					} else {
						hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Cannot add element to the array as the next element is already occupied', E_USER_WARNING, 1);
					}
				} else {
					hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Incorrect e-mail format', E_USER_NOTICE, 1);
				}
			}
			return false;
		}
		/** Add BCC mail waiting to send.
		 * @access - public function
		 * @param - string $mail (target e-mail)
		 * @return - boolean
		 * @usage - Object->bcc($mail);
		 */
		public function bcc($mail = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				if (hpl_inspect :: is_mail($mail)) {
					if (count($this->BCC_LIST) < 2147483647) {
						$this->BCC_LIST[] = $mail;
						return true;
					} else {
						hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Cannot add element to the array as the next element is already occupied', E_USER_WARNING, 1);
					}
				} else {
					hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Incorrect e-mail format', E_USER_NOTICE, 1);
				}
			}
			return false;
		}
		/** Use the php.ini options to send messages in HTML format.
		 * @access - public function
		 * @param - string $mail (to mail)
		 * @param - string $subject (letter subject)
		 * @param - string $message (letter message)
		 * @return - boolean
		 * @usage - Object->send($toMail,$subject,$message)
		 */
		public function send($toMail = null, $subject = null, $message = null) {
			$result = false;
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0) && !hpl_func_arg :: string2error(1) && !hpl_func_arg :: string2error(2)) {
				if (hpl_inspect :: is_mail($toMail)) {
					$SIGN_SENDER_MAIL = ini_get('sendmail_from');
					if (!preg_match('/^[0-9]+$/i', ini_get('smtp_port'))) {
						hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): SMTP port number should be >= 0', E_USER_WARNING, 1);
					}
					elseif (strlen(ini_get('SMTP')) == 0) {
						hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Empty SMTP ISP host', E_USER_WARNING, 1);
					}
					elseif (!hpl_inspect :: is_mail($SIGN_SENDER_MAIL)) {
						hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Incorrect sender e-mail format', E_USER_WARNING, 1);
					} else {
						$oldTimeout = ini_get('max_execution_time');
						ini_set('max_execution_time', '0'); //set timeout
						mb_internal_encoding('UTF-8'); //set internal encoding
						//HTML
						$headers = "MIME-Version: 1.0" . PHP_EOL;
						$headers .= "Content-type: text/html; charset=utf-8" . PHP_EOL;
						$headers .= "From: " . mb_encode_mimeheader($this->SIGN_SENDER_NAME, 'UTF-8') . " <" . $SIGN_SENDER_MAIL . ">" . PHP_EOL;
						//CC mail group
						$this->CC_LIST = array_unique($this->CC_LIST);
						if (count($this->CC_LIST) > 0) {
							$headers .= "CC: " . implode(',', $this->CC_LIST) . PHP_EOL;
							$this->CC_LIST = array ();
						}
						//BCC mail group
						$this->BCC_LIST = array_unique($this->BCC_LIST);
						if (count($this->BCC_LIST) > 0) {
							$headers .= "BCC: " . implode(',', $this->BCC_LIST) . PHP_EOL;
							$this->BCC_LIST = array ();
						}
						set_error_handler(__CLASS__ . '::ErrorHandler');
						$result = mb_send_mail($toMail, $subject, $message, $headers); //send mail
						restore_error_handler();
						ini_set('max_execution_time', $oldTimeout); //reset timeout
					}
				} else {
					hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Incorrect e-mail format', E_USER_NOTICE, 1);
				}
			}
			return $result;
		}
	}
}
?>