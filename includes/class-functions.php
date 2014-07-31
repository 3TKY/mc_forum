<?php
class Functions {
	public function timeAgoString($t) {
		$units = array("s", "m", "h", "d", "w", "m", "y");
		$unit_length = array("60","60","24","7","4.35","12");

		//Get time elapsed since timestamp
		$elapsed = time() - $t;

		//Get appropriate unit
		for ($unit = 0; $elapsed >= $unit_length[$unit] && $unit < count($unit_length)-1; $unit++) {
			$elapsed /= $unit_length[$unit];
		}

		$elapsed = round($elapsed);

		//Return elapsed time string
		if ($unit > 2) {
			return 'about ' . $elapsed . $units[$unit] . ' ago';
		} else {
			return $elapsed . $units[$unit] . ' ago';
		}
	}

	function getSalt() {
		$rand = str_replace('+', 'x', base64_encode(mcrypt_create_iv(22,MCRYPT_DEV_URANDOM)));
		$prefix = '$2a$07$';

		$salt = $prefix . $rand . '$';
	
		return $salt;
	}

	function hashPassword($password, $salt) {
		$hash = crypt($password, $salt);
		return $hash;
	}
}
?>