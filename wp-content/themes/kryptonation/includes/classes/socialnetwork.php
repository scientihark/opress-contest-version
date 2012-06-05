<?php

class Padd_SocialNetwork {

	protected $network;
	protected $url;
	protected $username;

	function __construct($network, $url, $username='') {
		$this->network = $network;
		$this->url = $url;
		$this->username = $username;
	}

	public function get_network() {
		return $this->network;
	}

	public function set_network($network) {
		$this->network = $network;
	}

	public function get_url() {
		return $this->url;
	}

	public function set_url($url) {
		$this->url = $url;
	}

	public function get_username() {
		return $this->username;
	}

	public function set_username($username) {
		$this->username = $username;
	}

	public function __toString() {
		$string = str_replace('%u%',$this->username,$this->url);
		return $string;
	}

}

?>
