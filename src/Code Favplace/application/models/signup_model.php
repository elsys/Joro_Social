<?php
class Signup_model extends MY_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function is_username_free($username)
	{
		$routes=array('edit',
					  'followers',
					  'followed',
					  'ajax_wall',
					  'wall',
					  'comment',
					  'geotag',
					  'profile_city_sugg',
					  'unfollow',
					  'follow',
					  'favorite_places');
		
		for($i=0;$i<sizeof($routes);$i++)
		{
			if(strtolower($routes[$i])==strtolower($username)) return false;
		}
		
		if(isset($route[$username])) return false;
				
		$query=$this->db->query("SELECT count(*) AS cnt FROM profiles WHERE username=?",
		array($username));
		$username=$query->row();
		
		if($username->cnt) return false;
		else return true;
	}
	
	function is_email_free($email)
	{
		$query=$this->db->query("SELECT count(*) AS cnt FROM profiles WHERE email=?",
		array($email));
		$email=$query->row();
		
		if($email->cnt) return false;
		else return true;
	}
	
	function register()
	{
		$this->db->query(
		"INSERT INTO profiles (username,password,email,registered,status) VALUES(?,md5(?),?,now(),0)",
		array($this->input->post("username"),$this->input->post("password"),$this->input->post("email")));
		
		return $this->db->insert_id();
	}
	
	function confirm($profile_id)
	{
		$this->db->query("UPDATE profiles SET status=1 WHERE id=?",
		array($profile_id));
	}
}
