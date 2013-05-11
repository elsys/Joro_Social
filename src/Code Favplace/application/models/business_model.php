<?php
class Business_model extends MY_Model{
	
	function __constructl()
	{
		parent::__construct();
	}
	
	function is_place_owner($place_id)
	{
		$query=$this->db->query("SELECT count(*) AS cnt FROM places WHERE id=? AND owner_id=?",
		array($place_id,$this->profile_id));
		
		return (bool) $query->row()->cnt;
	}
	
	function send_request($place_id)
	{
		$this->db->query("INSERT INTO place_request (place_id, content, date) 
		VALUES (?,?,now())", array($place_id, $this->input->post("request")));
	}
	
	function get_all_business_places()
	{
		$query = $this->db->query("SELECT * FROM places WHERE owner_id=?", array($this->profile_id));
		return $query;
	}
	
	function add_menu_category($place_id,$main_cat)
	{
		$this->db->query("INSERT INTO place_menu_categories (place_id, name, date) 
		VALUES (?,?,now())", array($place_id,$main_cat));
		
		return $this->db->insert_id();
	}
	
	function add_menu_subcategory($main_cat_id,$sub_cat)
	{
		$this->db->query("INSERT INTO place_menu_subcategories (category_id, name, date) 
		VALUES (?,?,now())", array($main_cat_id,$sub_cat));
		
		return $this->db->insert_id();
	}
	
	function add_menu_item($sub_cat_id,$item,$amount,$price,$description)
	{
		$this->db->query("INSERT INTO place_menu_items 
		(subcategory_id, name, amount, price, description, date) 
		VALUES (?,?,?,?,?,now())", array($sub_cat_id,$item,$amount,$price,$description));
		
		return $this->db->insert_id();
	}
	
	
	function save_style($place_id)
	{
		$query = $this->db->query("SELECT id FROM place_customization WHERE place_id=?", 
		array($place_id));
		
		if($query->row()) 
		{
			$customization_id = $query->row()->id;
		}
		else
		{
			$customization_id = 0;
		}
		
		if($customization_id)
		{
			$this->db->query("UPDATE place_customization SET css=? WHERE id=?",
			array($this->input->post("css"), $customization_id));
		}
		else
		{
			$this->db->query("INSERT INTO place_customization (place_id, css, date) VALUES(?, ?, now())",
			array($place_id, $this->input->post("css")));
		}
	} 
	
	function get_style($place_id)
	{
		$query = $this->db->query("SELECT css FROM place_customization WHERE place_id=?", 
		array($place_id));
		
		if($query->row()) return $query->row();
	}
	
	function get_menu($place_id)
	{
		$categories=$this->db->query("SELECT * FROM place_menu_categories WHERE place_id=?",
		array($place_id));
		
		$categories=$this->remove_html($categories);
		
		foreach($categories->result as $category)
		{
			$subcategories=$this->db->query("SELECT * FROM place_menu_subcategories WHERE category_id=?",
			array($category->id));			
			$subcategories=$this->remove_html($subcategories);

			foreach($subcategories->result as $subcategory)
			{
				$items=$this->db->query("SELECT * FROM place_menu_items WHERE subcategory_id=?",
				array($subcategory->id));
				$items=$this->remove_html($items);
				
				$subcategory->items=$items;
			}
			
			$category->subcategories=$subcategories;
		}
		
		return $categories;	
	}
}
