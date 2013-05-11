<?php

class Catalogue extends MY_Controller {

	function __construct()
	{
		parent::__construct();	
	}
	
	function index()
	{
		$this->load->view('catalogue');
	}
} 