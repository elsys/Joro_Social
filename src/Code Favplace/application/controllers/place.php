<?php

class Place extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('business_helper');	
	}
	
	function index($place_id=0)
	{
		if( ! $place_id) redirect("");
		
		$this->load->model("Profile_model","",TRUE);
		$this->load->model("Business_model","",TRUE);
		$this->load->model("Place_model","",TRUE);
		$this->load->model("Event_model","",TRUE);
		
		$place=$this->Place_model->get($place_id);
		
		if( ! $place) redirect("");
		
		$data['place']=$place;
		$data['place_favorites']=$this->Place_model->get_favorites_list($place_id,0,6);
		$data['place_favorites_count']=$this->Place_model->get_favorites_count($place_id);
		$data['place_tags']=$this->Place_model->get_place_tags($place_id);
		$data['place_menu']=$this->Business_model->get_menu($place_id);
		$data['place_customization']=$this->Business_model->get_style($place_id);
		$data['page_place_view']=TRUE;
		
		$data['place_favorite']=$this->Profile_model->is_place_favorite($place_id);
		$data['place_pictures']=$this->Place_model->get_pictures($place_id,0,6);
		$data['place_events']=$this->Event_model->get_place_events($place_id,0,6);
		$data['pictures_count']=$this->Place_model->get_pictures_count($place_id);
		
		$this->load->view('place/index',$data);
	}
	
	function add()
	{
		$this->r_nlogged();
		$this->load->model("Place_model","",TRUE);
		
		$data['place_categories']=$this->Place_model->get_categories_list();
		$data['place_subcategories']=$this->Place_model->get_subcategories_list();
		$data['place_tags']=$this->Place_model->get_approoved_tags_list();
		$this->load->view('place/add',$data);
	}
	
	function add_ajax()
	{
		$this->r_nlogged_ajax();
		
		$this->load->model("Place_model","",TRUE);
		
		$rules=array(
			array('field'=>'name',           	'rules'=>'trim|required|min_length[2]|max_length[1000]'),
			array('field'=>'address',        	'rules'=>'trim|required|min_length[2]|max_length[1000]'),
			array('field'=>'subcategories[]',	'rules'=>'required|numeric'),
			array('field'=>'tags[]',			'rules'=>'numeric'),
			array('field'=>'description',		'rules'=>'trim'),
			array('field'=>'work_time',			'rules'=>'trim'),
			array('field'=>'coord_x',			'rules'=>'trim|required|is_float'),
			array('field'=>'coord_y',			'rules'=>'trim|required|is_float'),
			array('field'=>'coord_country',		'rules'=>'trim|strtoupper'),
			array('field'=>'coord_district',	'rules'=>'trim'),
			array('field'=>'coord_municipality','rules'=>'trim'),
			array('field'=>'coord_city',		'rules'=>'trim')
		);

		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{
			$place_id=$this->Place_model->add();
			$name=url_title($this->input->post("name"));
			
			echo json_encode(array(
				'status'=>'ok',
				'place_id'=>$place_id,
				'url'=>	"place/$place_id/$name")
			);
		}
		else
		{
			echo json_encode(array(
				'status'=>'error',
				'description'=>'Невалидни данни.')
			);	
		}
	}
	
	function add_pictures($session_id,$place_id=0)
	{
		$this->restore_session($session_id);
		$this->r_nlogged_ajax();
		$place_id=intval($place_id);
		
		$config['upload_path'] = './pictures/';
		$config['allowed_types'] = 'jpg';
		$config['max_size']	= '1000';
		$config['max_width']  = '2000';
		$config['max_height']  = '2000';
		$config['encrypt_name'] = TRUE;		
		$this->load->library('upload', $config);
		
		if($this->upload->do_upload("picture"))
		{
			$this->load->model("Place_model","",TRUE);
			$ref_id=$this->Place_model->register_place_pictures_add($place_id,0);
			
			$picture=$this->upload->data();
			$this->load->library('Square_image');
			
			// 600x400
			$newWidth=600;
			$newHeight=400;
			$thumb_path=$picture['file_path'].$picture['raw_name'].'_600_400'.$picture['file_ext'];
			
			$this->square_image->resize_to_min($picture['full_path'],$newWidth+5,$newHeight+5,$thumb_path);
			$this->square_image->rectangle($thumb_path,'',$newWidth,$newHeight);	
			
			// 100x100
			$sq_image=$picture['file_path'].$picture['raw_name'].'_100_100'.$picture['file_ext'];
			$this->square_image->square($picture['full_path'],$sq_image);		  
			$this->square_image->resize($sq_image, 100, 100);
			
			$this->Place_model->add_user_picture($ref_id,$picture['raw_name'],$picture['file_ext']);
			echo json_encode(array('status'=>'ok'));
		}
	}
	
	function edit($place_id=0)
	{
		$this->r_nlogged();
		
		$this->load->model("Place_model","",TRUE);
		$place=$this->Place_model->get_for_edit($place_id,TRUE);
		
		if( ! $place) redirect("");
		else
		{
			if($place->owner_id==$this->profile_id) redirect("business/place_edit/$place_id");
			elseif($place->owner_id) redirect("");
		}
		

		$rules=array(
			array('field'=>'address',        	'rules'=>'trim|required|min_length[2]|max_length[1000]'),
			array('field'=>'subcategories[]',	'rules'=>'required|numeric'),
			array('field'=>'tags[]',			'rules'=>'numeric'),
			array('field'=>'description',		'rules'=>'trim'),
			array('field'=>'work_time',			'rules'=>'trim'),
			array('field'=>'coord_x',			'rules'=>'trim|required'),
			array('field'=>'coord_y',			'rules'=>'trim|required'),
			array('field'=>'coord_country',		'rules'=>'trim|strtoupper'),
			array('field'=>'coord_district',	'rules'=>'trim'),
			array('field'=>'coord_municipality','rules'=>'trim'),
			array('field'=>'coord_city',		'rules'=>'trim')
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{
			$this->Place_model->edit($place_id);
			redirect("place/edit/$place_id");
		}
		
		$data['place_categories']=$this->Place_model->get_categories_list();
		$data['place_subcategories']=$this->Place_model->get_subcategories_list();
		$data['place_tags']=$this->Place_model->get_approoved_tags_list();
		$data['place']=$place;
		$this->load->view('place/edit',$data);
	}
	
	function menu()
	{
		$this->load->view('place/menu/index');
	}
	
	function gallery_ajax_image($place_id=0, $num=0)
	{
		$this->r_nlogged_ajax();
		
		$this->load->model("Place_model","",TRUE);
		
		$num=intval($num);
		
		if( ! $this->Place_model->exists_id($place_id))
		{
			echo json_encode(array(
				'status'=>'error',
				'description'=>'This place doesn\'t exist.')
			);
			exit;
		}
		
		$picture=$this->Place_model->get_pictures($place_id,$num,$num+1)->row();
		
		if( ! $picture)
		{
			echo json_encode(array(
				'status'=>'error',
				'description'=>'This picture doesn\'t exist.')
			);
			exit;
		}
		
		echo json_encode(array(
			'status'=>'ok',
			'picture'=>place_picture($picture,600,400),
			'position'=>$num)
		);
	}
}

/* End of file place.php */
/* Location: ./application/controllers/place.php */