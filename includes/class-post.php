<?php
class Post {
	private $dbh;
	private $config;

	public function create() {
		
	}

	public function display() {
		
	}

	public function delete() {
		
	}

	public function hide() {
		
	}

	public function edit() {
		
	}

	public function getTimeAgoString($t) {
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

	public function __construct(Config $config, PDO $dbh) {
		$this->config = $config;
		$this->dbh = $dbh;
	}
}
?>