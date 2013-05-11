<?php

class Event extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index($event_id=0)
	{
		$this->load->model('Event_model', '', TRUE);
		
		if( ! $event_id) redirect("");
		
		$event=$this->Event_model->get($event_id,TRUE);
		
		if( ! $event) redirect("");
				
		$data["event"]=$event;
		$data["will_go"]=$this->Event_model->said_will_go($this->profile_id,$event_id);	
		$this->load->view('event/index',$data);
	}
	
	function will_go()
	{
		$this->load->model('Event_model', '', TRUE);
		
		$rules=array(
			array('field'=>'event_id', 		'rules'=>'required|numeric')
		);
		$this->form_validation->set_rules($rules);

		

		if($this->form_validation->run())
		{			
			$event_id=$this->input->post("event_id");
			
			if( ! $this->Event_model->exists($event_id))
			{
				echo json_encode(array('status'=>'error','description'=>'Такова събитие не съществува.')); 
				exit;
			}
			
			if( ! $this->Event_model->said_will_go($this->profile_id,$event_id))
			{
				$this->Event_model->will_go($this->profile_id,$event_id);
				echo json_encode(array('status'=>'ok'));
			}
			else
			{
				echo json_encode(array('status'=>'error','description'=>''));
			}
		}
		else 
		{
			echo json_encode(array('status'=>'error','description'=>'Невалидна заявка.')); 	
		}
	}
	
	function add($place_id=0)
	{
		$this->r_nlogged();
		
		$this->load->model('Place_model', '', TRUE);
		$this->load->model('Event_model', '', TRUE);
		
		$rules=array(
			array('field'=>'name', 			'rules'=>'trim|required|max_length[1000]'),
			array('field'=>'date_start', 	'rules'=>'trim|required|exact_length[10]'),
			array('field'=>'hour_start', 	'rules'=>'trim|required|exact_length[10]'),
			array('field'=>'date_end', 		'rules'=>'trim|exact_length[2]'),
			array('field'=>'hour_end', 		'rules'=>'trim|exact_length[2]'),
			array('field'=>'description', 	'rules'=>'trim|max_length[20000]'),
			array('field'=>'place_id', 		'rules'=>'required|numeric'),
			array('field'=>'visible', 		'rules'=>'required|numeric')
		);
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run())
		{
			$place_id=intval($this->input->post("place_id"));
			
			if( ! $this->Place_model->exists_id($place_id)) redirect("");
			
			$config['upload_path'] = './pictures/';
			$config['allowed_types'] = 'jpg|png';
			$config['encrypt_name'] = TRUE;
			$config['max_size']	= '1000';
			$config['max_width']  = '2000';
			$config['max_height']  = '2000';
			
			$this->load->library('upload', $config);	
			if ($this->upload->do_upload("picture"))
			{		
				$file=$this->upload->data();
				$picture=$file['file_name'];
			}
			else $picture="";
			
			$event_id=$this->Event_model->add($picture);
			
			if($picture)
			{
				$thumb_width=200;
				$thumb_height=260;
				$thumb_path=$file['file_path'].$event_id.'_event_thumb'.$file['file_ext'];
							
				$this->load->library('Square_image');
				$this->square_image->resize_to_min($file['full_path'],$thumb_width+5,$thumb_height+5,$thumb_path);
				$this->square_image->rectangle($thumb_path,'',$thumb_width,$thumb_height);	
			}
		}
		else
		{
			$data=array();
		
			if($place_id)
			{
				$place=$this->Place_model->get($place_id);
				
				if( ! $place) redirect("");
				
				$data['place']=$place;
			}
			$this->load->view('event/add',$data);
		}
	}
	
	function edit($event_id=0)
	{
		$this->r_nlogged();
		
		$this->load->model("Event_model","",TRUE);
		$this->load->model("Place_model","",TRUE);
		
		if( ! $event_id) redirect("");
		
		$event=$this->Event_model->get($event_id,TRUE);
		
		if( ! $event) redirect("");
		
		$place_id=$event->place_id;
		
		if($event->profile_id!=$this->profile_id) redirect("");
		
		$rules=array(
			array('field'=>'name', 			'rules'=>'trim|required|max_length[1000]'),
			array('field'=>'date_start', 	'rules'=>'trim|required|max_length[100]'),
			array('field'=>'hour_start', 	'rules'=>'trim|required|max_length[100]'),
			array('field'=>'date_end', 		'rules'=>'trim|max_length[100]'),
			array('field'=>'hour_end', 		'rules'=>'trim|max_length[100]'),
			array('field'=>'description', 	'rules'=>'trim|max_length[20000]'),
			array('field'=>'place_id', 		'rules'=>'trim|required|numeric'),
			array('field'=>'visible', 		'rules'=>'trim|required|numeric')
		);
		$this->form_validation->set_rules($rules);
		//
		if($this->form_validation->run())
		{
			$place_id=intval($this->input->post("place_id"));
			
			if( ! $this->Place_model->exists_id($place_id)) redirect("");			
			
			$config['upload_path'] = './pictures/';
			$config['allowed_types'] = 'jpg';
			$config['encrypt_name'] = TRUE;
			$config['max_size']	= '1000';
			$config['max_width']  = '2000';
			$config['max_height']  = '2000';
			
			$this->load->library('upload', $config);	
			if ($this->upload->do_upload("picture"))
			{		
				@unlink('pictures/'.$event->picture);
			
				$file=$this->upload->data();
				$picture=$file['file_name'];
			}
			else $picture=$event->picture;
			
			$this->Event_model->edit($event_id,$picture);
			
			if($picture!=$event->picture)
			{
				$this->load->library('Square_image');
				
				$this->square_image->delete('./pictures/'.$event->picture);
				$this->square_image->delete(event_thumb($event));
				
				$thumb_width=200;
				$thumb_height=260;
				$thumb_path=$file['file_path'].$event_id.'_event_thumb'.$file['file_ext'];
							
				$this->load->library('Square_image');
				$this->square_image->resize_to_min($file['full_path'],$thumb_width+5,$thumb_height+5,$thumb_path);
				$this->square_image->rectangle($thumb_path,'',$thumb_width,$thumb_height);	
			}
			
			redirect("event/edit/$event_id");	
		}
		

		$data["place"]=$this->Place_model->get($place_id,TRUE);
		$data['event']=$event;
		$this->load->view('event/edit',$data);	
	}
	
	function delete_main_picture($event_id=0)
	{
		$this->load->model("Event_model","",TRUE);
		
		if( ! $event_id) redirect("");
		
		$event=$this->Event_model->get($event_id);	
		
		if( ! $event) redirect("");
			
		if($event->profile_id!=$this->profile_id) redirect("");
		
		// do it
		
		$this->load->library('Square_image');
		$this->square_image->delete(event_thumb($event));
		$this->Event_model->delete_main_picture($event_id);
		
		redirect("event/edit/$event_id");
	}
	
	function place_autocomplete()
	{
		$this->load->model("Profile_model","",TRUE);

		$rules=array(
			array('field'=>'term','rules'=>'trim|required')
		);	
		
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run())
		{	
			$suggestions_array=array();
			$suggestions=$this->Profile_model->place_suggestions($this->input->post("term"));

			foreach($suggestions->result() as $suggestion)
			{
				$suggestions_array[] = array(
					"id"=>$suggestion->id, 
					"name"=>$suggestion->name, 
					"coord_x"=>$suggestion->coord_x,
					"coord_y"=>$suggestion->coord_y
				);
			}
			
			echo json_encode($suggestions_array);
		}
	}
}

/* End of file event.php */
/* Location: ./application/controllers/event.php */