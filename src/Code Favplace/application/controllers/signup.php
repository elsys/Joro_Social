<?php

class Signup extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->r_logged();
	}
	
	function index()
	{
		$this->load->model("Signup_model","",TRUE);
		
		$rules=array(
		array('field'=>'username','rules'=>		
		'alpha_numeric|required|min_length[3]|max_length[18]|callback__is_username_free'),
		array('field'=>'email',		'rules'=>'trim|required|valid_email|callback__is_email_free'),
		array('field'=>'password',	'rules'=>'required|min_length[6]|max_length[50]'),
		array('field'=>'password_r','rules'=>'required|min_length[6]|max_length[50]|matches[password]'),
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{
			$profile_id=$this->Signup_model->register();
			
			if($profile_id)
			{
				$key=md5($profile_id.$this->input->post("username").'t2uRETus');
				$url=base_url()."signup/confirm/$profile_id/$key";
				$content="Моля, потвърдете регистрацията си от <a href='$url'>тук</a>.";
				$this->send_mail($this->input->post("email"),'Потвърдете регистрацията си',$content);		
				$this->load->view('signup/signup_success');
			}
			else $this->load->view('signup/signup_error');
		}
		else
		{
			$this->load->view('signup/signup');
		}
	}
	
	// callback function
	function _is_username_free()
	{
		$this->load->model("Signup_model","",TRUE);
		$this->form_validation->set_message('_is_username_free', 'Този псевдоним е зает, избери друг.');
		return $this->Signup_model->is_username_free($this->input->post("username"));
	}
	
	// callback function
	function _is_email_free()
	{
		$this->load->model("Signup_model","",TRUE);
		$this->form_validation->set_message('_is_email_free', 'Вече има регистрация с този email.');
		return $this->Signup_model->is_email_free($this->input->post("email"));
	}
	
	function is_username_free()
	{
		$this->load->model("Signup_model","",TRUE);

		$rules=array(array('field'=>'username','rules'=>'trim|required'));
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{
			if($this->Signup_model->is_username_free($this->input->post("username")))
			{
				echo json_encode(array('status'=>'ok','usernameFree'=>'1'));	
			}
			else
			{
				echo json_encode(array('status'=>'ok','usernameFree'=>'0'));	
			}
		}
		else
		{
			echo json_encode(array('status'=>'error','description'=>'Грешка при свързване със сървъра.'));
		}
	}
	
	function is_email_free()
	{
		$this->load->model("Signup_model","",TRUE);
		
		$rules=array(array('field'=>'email','rules'=>'trim|required|valid_email'));
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{
			if($this->Signup_model->is_email_free($this->input->post("email")))
			{
				echo json_encode(array('status'=>'ok','emailFree'=>'1'));	
			}
			else
			{
				echo json_encode(array('status'=>'ok','emailFree'=>'0'));		
			}				
		}
		else
		{
			echo json_encode(array('status'=>'error','description'=>'Грешка при свързване със сървъра.'));
		}
	}
	
	function confirm($profile_id,$key)
	{
		$this->load->model("Signup_model","",TRUE);
		$this->load->model("Profile_model","",TRUE);
		
		$profile=$this->Profile_model->get($profile_id);		
		if( ! ($profile and $profile->status==0)) $this->load->view('signup/signup_confirm_invalid');
		else
		{
			$true_key=md5($profile->id.$profile->username."t2uRETus");
			if($key==$true_key)
			{
				$this->Signup_model->confirm($profile_id);
				$this->load->view('signup/signup_confirm_success');
			}
			else
			{
				$this->load->view('signup/signup_confirm_invalid');
			}
		}
	}
}
/* End of file signup.php */
/* Location: ./application/controllers/signup.php */