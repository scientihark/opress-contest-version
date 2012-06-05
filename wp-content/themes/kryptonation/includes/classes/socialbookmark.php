<?php

class Padd_SocialBookmark {

	protected $network;
	protected $slug;
	protected $net_url;

	protected $ref_url;
	protected $title;
	protected $author;
	protected $excerpt;
	protected $content;
	

	function __construct($network,$net_url,$content='') {
		$this->network = $network;
		$this->net_url = $net_url;
		$this->content = $content;
	}

	public function get_network() {
		return $this->network;
	}

	public function set_network($network) {
		$this->network = $network;
	}

	public function get_slug() {
		return $this->slug;
	}

	public function set_slug($slug) {
		$this->slug = $slug;
	}

	public function get_net_url() {
		return $this->net_url;
	}

	public function set_net_url($net_url) {
		$this->net_url = $net_url;
	}

	public function get_ref_url() {
		return $this->ref_url;
	}

	public function set_ref_url($ref_url) {
		$this->ref_url = $ref_url;
	}

	public function get_title() {
		return $this->title;
	}

	public function set_title($title) {
		$this->title = $title;
	}

	public function get_author() {
		return $this->author;
	}

	public function set_author($author) {
		$this->author = $author;
	}

	public function get_excerpt() {
		return $this->excerpt;
	}

	public function set_excerpt($excerpt) {
		$this->excerpt = $excerpt;
	}

	public function get_content() {
		return $this->content;
	}

	public function set_content($content) {
		$this->content = $content;
	}

	public function __toString() {
		$url = str_replace('%url%',$this->ref_url,$this->net_url);
		$url = str_replace('%title%',$this->title,$url);
		$url = str_replace('%author%',$this->title,$url);
		$url = str_replace('%excerpt%',$this->excerpt,$url);
		return '<a href="' . $url . '">' . $this->content . '</a>';
	}

}
