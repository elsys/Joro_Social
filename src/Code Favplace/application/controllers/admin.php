<?php

class Admin extends MY_Controller {

	function __construct()
	{
		parent::__construct();	
	}
	
	function index()
	{
		$this->load->view('admin/index');
	}
	
	function dashboard()
	{
		$this->load->view('admin/dashboard');
	}
	
	function line()
	{
		$this->load->view('admin/line');
	}
} 