<?php

class Search extends MY_Controller {

	function __construct()
	{
		parent::__construct();	
	}
	
	function places($key='')
	{
		$this->load->model("Place_model","",TRUE);
		
		if($key=='')
		{
			$key=$this->Place_model->generate_search_key($_POST);
			redirect("search/places/$key");
		}
		else
		{
			$post=$this->Place_model->get_search_key($key);
			if( ! $post) exit;	
			foreach($post as $k => $value) $_POST[$k]=$value;
		}
		
		
		$rules=array(
			array('field'=>'name', 'rules'=>'trim|max_length[1000]')
		);	
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run())
		{		
			$page=intval($this->uri->segment(4,0));
			$limit=2;
			
			$config['base_url'] = "search/places/$key";
			$config['total_rows'] = $this->Place_model->get_search_count();
			$config['per_page'] = $limit;		
			$config['uri_segment'] = 4;
			$config['num_links'] = 3;
			$config['num_tag_open'] ='<li>';
			$config['num_tag_close']='</li>';
			$config['cur_tag_open'] ='<li><a href="#" class="act">';
			$config['cur_tag_close'] ='</a></li>';
			$config['first_link']=FALSE;
			$config['last_link']=FALSE;
			$config['next_link'] = '<span>Следваща</span><b class="arrow"></b>';
			$config['next_tag_open'] = '<li class="next">';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = '<b class="arrow"></b><span>Предишна</span>';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';

			$this->load->library('pagination',$config);
			 
			$data['places']=$this->Place_model->get_search_list($page,$limit);
			
			$this->load->view('search/places/list',$data);
		}
	}
	
	function places_sugg() // suggestions for the search
	{
		$this->load->model("Place_model","",TRUE);
		
		$rules=array(
			array('field'=>'name', 'rules'=>'trim|min_length[2]')
		);
		
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run())
		{
			
			
			$places=$this->Place_model->get_search_sugg_list($this->input->post('name'),10);

			foreach($places->result() as $place)
			{
				if($place->priority==1) $places_array[]=array('name'=>$place->name);
				if($place->priority==2) $places_array[]=array('name'=>$place->address);
			}
			
			if($places->num_rows()) $to_json=array('status'=>'ok','places'=>$places_array);
			else $to_json=array('status'=>'ok','places'=>array());
			
			echo json_encode($to_json);
		}
	}
	
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */