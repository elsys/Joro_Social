<?php

class Welcome extends MY_Controller {

	function __construct()
	{
		parent::__construct();	
	}
	
	function index()
	{
		if($this->user_logged)
		{
			$this->load->model("Profile_model","",TRUE);
			
			$options=array('all'=>TRUE);
			$data["wallstream"]=$this->Profile_model->get_wallstream($this->profile_id,$options);
			$this->load->view('welcome/r/index',$data);
		}
		else $this->load->view('welcome/index');
	}
	
	function ajax_wall($from)
	{
		$this->r_nlogged_ajax();
		
		$this->load->model("Profile_model","",TRUE);
		
		$from=intval($from);
		$options=array('all'=>TRUE);
		$data["wallstream"]=$this->Profile_model->get_wallstream($this->profile_id,$options,$from);
		$content=$this->load->view('welcome/r/ajax/wall',$data,TRUE);
		echo json_encode(array('status'=>'ok','content'=>$content,'count'=>$data["wallstream"]->num_rows()));
	}
	
	
	
	function test()
	{
		$ch = curl_init("http://img505.imageshack.us/img505/1413/mergeoi1.gif");
		
		curl_setopt ($ch, CURLOPT_HEADER, 1);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
		
		$result=explode("\r\n\r\n",curl_exec($ch));
		
		if( ! $result) exit;
		
		$headers=explode("\r\n",$result[0]);
		
		$content_type=$content_length="";
		
		foreach($headers as $key => $value)
		{
			$header=explode(":",$value);
			$header[0]=strtolower(trim($header[0]));
			
			if($header[0]=="content-type") $content_type=trim(strtolower($header[1]));
			if($header[0]=="content-length") $content_length=$header[1];
		}
		$fileContents = $result[1];
		curl_close($ch);
	
		if($content_length>500000) exit;
				
		$newImg = @imagecreatefromstring($fileContents);
		
		if( ! $newImg) exit;
		
		switch($content_type)
		{
			case 'image/jpeg': imagejpeg($newImg, "test.jpg",100); break;
			case 'image/jpg':  imagejpeg($newImg, "test.jpg",100); break;
			case 'image/png':  imagesavealpha($newImg, true); imagepng($newImg, "test.png",9); break;
			case 'image/gif':  imagegif($newImg, "test.gif",100); break;
			default: $ext="";
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */