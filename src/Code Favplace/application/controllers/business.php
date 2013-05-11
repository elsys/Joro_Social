<?php

class Business extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->r_nlogged();
		
		$this->load->helper('business_helper');	
		
		$this->load->model('Place_model', '', TRUE);
		$this->load->model('Business_model', '', TRUE);
	}
	
	function request($place_id)
	{
		$place = $this->Place_model->get($place_id);
		if( ! $place) redirect("");
		
		$rules = array(
			array("field"=>"request", "rules"=>"trim|required|max_length[5000]")
		);
		
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run()) 
		{
			$this->Business_model->send_request($place_id);
		}
		
		$data["place"] = $place;
		$this->load->view('business/request', $data);
	}
	
	function menu_edit($place_id)
	{
		// if the logged user is not the owner, exit
		if( ! $this->Business_model->is_place_owner($place_id)) redirect("");
		
		$rules = array(
			array("field"=>"main_cat[]", "rules"=>"trim|required|max_length[1000]")
		);
		
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run()) 
		{
			// add category if any
			$main_cats=$this->input->post("main_cat");
			foreach($main_cats as $key=>$main_cat)
			{				
				$main_cat_id=$this->Business_model->add_menu_category($place_id,$main_cat);

				// add subcategory if any
				$sub_cats=$this->input->post("sub_cat_$key");
				if( ! sizeof($sub_cats)) continue;
				
				foreach($sub_cats as $key2=>$sub_cat)
				{
					$sub_cat_id=$this->Business_model->add_menu_subcategory($main_cat_id,$sub_cat);
					
					// get item arrays
					$sub_cat_items=$this->input->post('item_'.$key.'_'.$key2);
					$sub_cat_amounts=$this->input->post('amount_'.$key.'_'.$key2);
					$sub_cat_prices=$this->input->post('price_'.$key.'_'.$key2);
					$sub_cat_descriptions=$this->input->post('description_'.$key.'_'.$key2);
					
					if(sizeof($sub_cat_items)==sizeof($sub_cat_amounts) && 
					sizeof($sub_cat_items)==sizeof($sub_cat_prices) &&
					sizeof($sub_cat_items)==sizeof($sub_cat_descriptions) &&
					sizeof($sub_cat_items)!=0) // check if size of arrays match and it's not zero
					{						
						foreach($sub_cat_items as $key3=>$item)
						{						
							$amount=$sub_cat_amounts[$key3];
							$price=$sub_cat_prices[$key3];	
							$description=$sub_cat_descriptions[$key3];	
		
							$this->Business_model->add_menu_item($sub_cat_id,$item,$amount,$price,$description);							
						}
					}
				}
			}
			echo 'done';
			exit;
		}
		$this->load->view('business/menu/edit');
	}

	function customization($place_id)
	{	
		if( ! $place_id) redirect("");
		
		$this->load->model("Place_model","",TRUE);
		$place=$this->Place_model->get($place_id);
		
		if( ! $place) redirect("");
		
		$rules = array(
			array("field"=>"css", "rules"=>"trim|required")
		);
		
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run()) 
		{
			$this->Business_model->save_style($place_id);			
			echo json_encode(array('status'=>'ok'));
		}
		else 
		{
			$data['place']=$place;
			$data['place_favorites_count']=$this->Place_model->get_favorites_count($place_id);
			$data['place_tags']=$this->Place_model->get_place_tags($place_id); 
			$data['customization']=$this->Place_model->get_customization($place_id);
			
			$this->load->view('business/customization/index', $data);
		}
	}
}

/* End of file business.php */
/* Location: ./application/controllers/business.php */