<?php
class Signin_model extends MY_Model{
	
	function __constructl()
	{
		parent::__construct();
	}
	
	function signin()
	{
		$query=$this->db->query("SELECT * FROM profiles WHERE username=? AND password=md5(?)",
		array($this->input->post("username"),$this->input->post("password")));
		
		$profile=$query->row();
		
		// if there is no such username / password combination
		if(!$profile) return -1;
		
		// if the user did not confirm his registration yet
		if($profile->status==0) return 0;
		
		// if the user is active
		if($profile->status==1){
			$this->session->set_userdata("user_logged",TRUE);
			$this->session->set_userdata("profile_id",$profile->id);
			$this->session->set_userdata("username",$profile->username);
			$this->session->set_userdata("profile_email",$profile->email);
			$this->session->set_userdata("profile_avatar",$profile->avatar);
			return  1;		
		}
	}
}
