<?php
class Config {
	// Path to the main configuration file
	private $conf;
	private $config_path = 'config.ini';

	private function getConfig() {
		if (!file_exists($this->config_path)) {
			throw new Exception('Configuration file \'' . $this->config_path . '\' not found');
		} else {
			$this->conf = parse_ini_file($this->config_path);
		}
	}

	public function getDatabaseConf() {
		return array(
			'host' => $this->getSetting('db_host', 'localhost'),
			'name' => $this->getSetting('db_name'),
			'user' => $this->getSetting('db_user', 'root'),
			'password' => $this->getSetting('db_password')
		);
	}

	public function getSetting($setting, $default = NULL) {
		if(isset($this->conf[$setting])) {
			return $this->conf[$setting];
		} else {
			return $default;
		}
	}

	public function getLanguage() {
		$setting = 'forum_language';
		$default = 'en';
		return $this->getSetting($setting, $default);
	}

	public function getTitle() {
		$setting = 'forum_title';
		$default = 'Untitled';
		return $this->getSetting($setting, $default) . ' - Miniboard';
	}

	public function getCharset() {
		$setting = 'forum_charset';
		$default = 'utf-8';
		return $this->getSetting($setting, $default);
	}

	public function __construct() {
		$this->getConfig();
	}
}
?>
