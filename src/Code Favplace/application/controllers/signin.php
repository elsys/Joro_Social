<?php

class Signin extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->r_logged();
	}
	
	function index()
	{
		$this->load->model("Signin_model","",TRUE);
		
		$rules=array(
			array('field'=>'username','rules'=>'trim|required'),
			array('field'=>'password','rules'=>'trim|required')
		);
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run())
		{
			$status=$this->Signin_model->signin();

			switch($status)
			{
				case -1: // if user is not found
					$this->session->set_flashdata("signin_message","Несъществуваща комбинация псевдоним / парола.");
					redirect("signin");
					break;				
				case 0: // if registration is not confirmed
					$this->session->set_flashdata("signin_message","Моля потвърдете регистрацията си.");
					redirect("signin");
					break;	
				case 1: // if registration is okay
					$redirect_to=$this->session->flashdata("redirect_to");
					
					if($redirect_to) redirect($redirect_to);
					else redirect("");
					break;
			}
		}
		
		$this->session->set_flashdata("redirect_to",$this->session->flashdata("redirect_to"));
		
		$data["signin_message"]=$this->session->flashdata("signin_message");
		$this->load->view('signin/signin',$data);
	}
	
	// callback function
	function _is_email_registered()
	{
		$this->load->model("Signup_model","",TRUE);
		$this->form_validation->set_message('_is_email_registered', 'Няма регистрация с такъв email.');
		return ! $this->Signup_model->is_email_free($this->input->post("email"));
	}
	
	function forgotten()
	{
		$rules=array(
			array('field'=>'email','rules'=>'trim|required|valid_email|callback__is_email_registered')
		);
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run())
		{
			echo 'in';
			exit;
		}
		$this->load->view('signin/forgotten');
	}
}

/* End of file signin.php */
/* Location: ./application/controllers/signin.php */