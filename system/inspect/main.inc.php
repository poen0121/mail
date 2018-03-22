<?php
if (!class_exists('hpl_inspect')) {
	include (strtr(dirname(__FILE__), '\\', '/') . '/system/func_arg/main.inc.php');
	/**
	 * @about - inspect data format.
	 */
	class hpl_inspect {
		/** Iconv encoding type code verification.
		 * @access - public function
		 * @param - string $data (encoding type code)
		 * @return - boolean
		 * @usage - hpl_inspect::is_iconv_encoding($data);
		 */
		public static function is_iconv_encoding($data = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				if (function_exists('iconv')) {
					if ($data) {
						$errorLevel = error_reporting();
						if (ini_set('error_reporting', 0) !== false) { //avoid showing error message
							$result = iconv('utf-8', $data, '');
							ini_set('error_reporting', $errorLevel);
						} else {
							$result = @ iconv('utf-8', $data, ''); //avoid showing error message
						}
						return ($result === false ? false : true);
					}
				} else {
					hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Call to undefined iconv()', E_USER_ERROR, 1);
				}
			}
			return false;
		}
		/** IP format verification.
		 * @access - public function
		 * @param - string $data (ip)
		 * @param - boolean $shield (shield private ip and reserved ip) : Default false
		 * @return - boolean
		 * @usage - hpl_inspect::is_ip($data,$shield);
		 */
		public static function is_ip($data = null, $shield = false) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0) && !hpl_func_arg :: bool2error(1)) {
				if (!$shield) {
					return (bool) filter_var($data, FILTER_VALIDATE_IP);
				} else {
					return (bool) filter_var($data, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
				}
			}
			return false;
		}
		/** Date format verification, if YYYY beyond calculation range 1 ~ 32767 returns false on failure.
		 * @access - public function
		 * @param - string $data (date YYYY-MM-DD)
		 * @return - boolean
		 * @usage - hpl_inspect::is_date($data);
		 */
		public static function is_date($data = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				$result = (preg_match('/^[1-9]{1}[0-9]*-[0-1]{1}[0-9]{1}-[0-3]{1}[0-9]{1}$/', $data) ? true : false);
				if ($result) {
					$dataInfo = explode('-', $data);
					$result = checkdate((int) $dataInfo[1], (int) $dataInfo[2], (int) $dataInfo[0]); //year 1 ~ 32767
				}
				return $result;
			}
			return false;
		}
		/** Time format verification.
		 * @access - public function
		 * @param - string $data (time hh:mm:ss)
		 * @return - boolean
		 * @usage - hpl_inspect::is_time($data);
		 */
		public static function is_time($data = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				$result = (preg_match('/^[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}$/', $data) ? true : false);
				if ($result) {
					$dataInfo = explode(':', $data);
					$result = ($result && (int) $dataInfo[0] > 23 ? false : $result);
					$result = ($result && (int) $dataInfo[1] > 59 ? false : $result);
					$result = ($result && (int) $dataInfo[2] > 59 ? false : $result);
				}
				return $result;
			}
			return false;
		}
		/** Datetime format verification, if YYYY beyond calculation range 1 ~ 32767 returns false on failure.
		 * @access - public function
		 * @param - string $data (datetime YYYY-MM-DD hh:mm:ss)
		 * @return - boolean
		 * @usage - hpl_inspect::is_datetime($data);
		 */
		public static function is_datetime($data = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				$result = (preg_match('/^[1-9]{1}[0-9]*-[0-1]{1}[0-9]{1}-[0-3]{1}[0-9]{1}[ \f\r\t\n]{1}[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}$/', $data) ? true : false);
				if ($result) {
					$dataInfo = explode(' ', $data);
					$result = (self :: is_date($dataInfo[0]) && self :: is_time($dataInfo[1]) ? true : false);
				}
				return $result;
			}
			return false;
		}
		/** E-Mail format verification.
		 * @access - public function
		 * @param - string $data (e-mail)
		 * @return - boolean
		 * @usage - hpl_inspect::is_mail($data);
		 */
		public static function is_mail($data = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				return (bool) filter_var($data, FILTER_VALIDATE_EMAIL);
			}
			return false;
		}
		/** URL format verification.
		 * @access - public function
		 * @param - string $data (URL)
		 * @return - boolean
		 * @usage - hpl_inspect::is_url($data);
		 */
		public static function is_url($data = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				return (bool) filter_var($data, FILTER_VALIDATE_URL);
			}
			return false;
		}
		/** Taiwan id card number format verification.
		 * @access - public function
		 * @param - string $data (taiwan id card number)
		 * @return - boolean
		 * @usage - hpl_inspect::is_taiwan_id_card($data);
		 */
		public static function is_taiwan_id_card($data = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				$id = strtoupper($data);
				$len = strlen($id);
				//Check the status word format is correct
				if (preg_match('/^[A-Z][1-2][0-9]+$/', $id) && $len == 10) {
					//Array of establishment of letters Score
					$headPoint = array ('A' => 1,'I' => 39,'O' => 48,'B' => 10,'C' => 19,'D' => 28,
						'E' => 37,'F' => 46,'G' => 55,'H' => 64,'J' => 73,'K' => 82,'L' => 2,'M' => 11,
						'N' => 20,'P' => 29,'Q' => 38,'R' => 47,'S' => 56,'T' => 65,'U' => 74,'V' => 83,
						'W' => 21,'X' => 3,'Y' => 12,'Z' => 30
					);
					//Array of establishment weighted base
					$multiply = array (8,7,6,5,4,3,2,1);
					//Cut string
					for ($i = 0; $i < $len; $i++) {
						$stringArray[$i] = substr($id, $i, 1);
					}
					//Obtaining letter score
					$total = $headPoint[array_shift($stringArray)];
					//Than the code obtained
					$point = array_pop($stringArray);
					//Number of points obtained
					$len = count($stringArray);
					for ($j = 0; $j < $len; $j++) {
						$total += $stringArray[$j] * $multiply[$j];
					}
					//Check the ratio of the code
					if ((($total % 10 == 0) ? 0 : 10 - $total % 10) == $point) {
						return true;
					}
				}
			}
			return false;
		}
		/** Taiwan uniform number format verification.
		 * @access - public function
		 * @param - string $data (taiwan uniform number)
		 * @return - boolean
		 * @usage - hpl_inspect::is_taiwan_ban($data);
		 */
		public static function is_taiwan_ban($data = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				if (!preg_match('/[0-9]{8}/', $data)) {
					return false;
				}
				$tbl = array (1,2,1,2,1,2,4,1);
				$sum = 0;
				for ($i = 0; $i < count($tbl); $i++) {
					$multiply = substr($data, $i, 1) * $tbl[$i];
					$sum += (floor($multiply / 10) + ($multiply % 10));
				}
				//Check the ratio of the code
				if ((($sum % 10 == 0) || ($sum % 10 == 9 && substr($data, 6, 1) == 7))) {
					return true;
				}
			}
			return false;
		}
		/** Taiwan phone format verification.
		 * @access - public function
		 * @param - string $data (taiwan phone)
		 * @return - boolean
		 * @usage - hpl_inspect::is_taiwan_phone($data);
		 */
		public static function is_taiwan_phone($data = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				return (bool) preg_match('/^[0][1-9]{1,3}[0-9]{6,8}$/', $data);
			}
			return false;
		}
		/** Taiwan mobile phone format verification.
		 * @access - public function
		 * @param - string $data (taiwan mobile phone)
		 * @return - boolean
		 * @usage - hpl_inspect::is_taiwan_mobile($data);
		 */
		public static function is_taiwan_mobile($data = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				return (bool) preg_match('/^[0][9][0-9]{8}$/', $data);
			}
			return false;
		}
	}
}
?>