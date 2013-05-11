<?php

class Signout extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->r_nlogged();
	}
	
	function index()
	{
		$kadabra=$this->session->userdata("kadabra");
		$this->session->sess_destroy();
		
		if($kadabra) $this->session->set_userdata("kadabra",1);
		
		redirect("");
	}
}

/* End of file signout.php */
/* Location: ./system/application/controllers/signout.php */