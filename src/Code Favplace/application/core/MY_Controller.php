<?php

class MY_Controller extends CI_Controller{
	
	public $session_id;
	public $user_logged;
	public $profile_id;
	public $username;
	public $profile_email;
	public $profile_avatar;
	
	function __construct($control=0)
	{
		parent::__construct();
		
		$this->session_id=$this->session->userdata('session_id');
		$this->user_logged=$this->session->userdata("user_logged");
		$this->profile_id=$this->session->userdata("profile_id");
		$this->username=htmlspecialchars($this->session->userdata("username"));
		$this->profile_email=$this->session->userdata("profile_email");
		$this->profile_avatar=$this->session->userdata("profile_avatar");
				
		// user should be logged
		if($control==1)
		{
			if(!$this->is_logged()) redirect("signin");
		}
	}
	
	function restore_session($session_id)
	{
		$query=$this->db->query("SELECT * FROM ci_sessions WHERE session_id=? LIMIT 1",array($session_id));
		$row=$query->row();
	
		if($row){
			$user_data=$row->user_data;
			$user_data=stripslashes($user_data);
			$user_data=unserialize($user_data);
				
			foreach($user_data as $key => $value) $this->session->set_userdata($key,$value);
		}
	}
	
	function is_logged()
	{
		if($this->profile_id) return true;
		else return false;			
	}
	
	function r_nlogged()
	{
		$this->session->set_flashdata("redirect_to",$this->uri->uri_string());
		if(!$this->is_logged()) redirect("signin");
	}
	
	function r_nlogged_ajax()
	{
		if(!$this->is_logged())
		{
			 echo json_encode(array('status'=>'error','description'=>'Влезте за да използвате тази функция.'));
			 exit;
		}
	}
	
	function r_logged()
	{
		if($this->profile_id) redirect("profile");		
	}
	
	function no_html($obj)
	{
		if(is_object($obj))
		{
			foreach($obj as $key=>$value) $arr->$key=htmlspecialchars($value);
			return $obj;
		}
		else
		{
			return htmlspecialchars($obj);	
		}
	}
	
	function send_mail($to,$subject,$content)
	{
		$this->load->library('email');
		$config['mailtype'] = "html";
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['charset'] = 'utf-8';
		$this->email->initialize($config);
				
        $this->email->from('no-reply@favplace.bg', 'Favplace.bg');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($content);
        $this->email->send();
	}
}