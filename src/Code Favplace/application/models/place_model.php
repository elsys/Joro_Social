<?php
class Place_model extends MY_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function exists_id($place_id)
	{
		$query=$this->db->query("SELECT count(*) AS cnt FROM places WHERE id=?",array($place_id));
		
		return (bool) $query->row()->cnt;
	}
	
	function get($place_id,$escape=FALSE)
	{
		$query=$this->db->query("SELECT * FROM places WHERE id=?",array($place_id));
		
		$row=$query->row();		
		
		if($escape) return $this->remove_html($row);
		else return $row;
	}
	
	function get_for_edit($place_id,$escape=FALSE)
	{
		$query=$this->db->query("SELECT *,
		(SELECT name FROM coord_countries WHERE id=coord_country_id) AS country,
		(SELECT name FROM coord_districts WHERE id=coord_district_id) AS district,
		(SELECT name FROM coord_municipalities WHERE id=coord_municipality_id) AS municipality,
		(SELECT name FROM coord_cities WHERE id=coord_city_id) AS city
		FROM places WHERE id=?",array($place_id));
		
		$row=$query->row();		
		if($escape) $row=$this->remove_html($row);		
		$row->categories=$this->get_place_subcategories($place_id);
		$row->tags=$this->get_place_tags($place_id);
		
		return $row;
	}
	
	function get_place_subcategories($place_id)
	{		
		$categories=$this->get_categories_list();
		
		$place_sub_categories;
		
		foreach($categories->result() as $category)
		{
			$category_id=$category->id;
			
			$place_sub_categories["$category_id"]=$this->db->query(
			"
			SELECT * FROM (
				(SELECT DISTINCT t1.id, t1.name, 1 AS status FROM places_subcategories t1, places_categories_link t2 
				WHERE place_id=? AND t2.subcategory_id=t1.id AND t2.category_id=?)
			UNION
				(SELECT id,name, 0 AS status FROM places_subcategories WHERE category_id=?)
			) AS tf GROUP BY id ORDER BY id ASC",
			array($place_id, $category_id, $category_id));	
		}
		
		return $place_sub_categories;
	}
	
	
	function get_place_tags($place_id)
	{
		return $this->db->query(
		"
		SELECT * FROM (
			(SELECT DISTINCT t1.id, t1.name, 1 AS status FROM places_tags t1, places_tags_link t2 
			WHERE place_id=? AND t2.tag_id=t1.id)
		UNION
			(SELECT id,name, 0 AS status FROM places_tags WHERE status=1)
		) AS tf GROUP BY id ORDER BY id ASC",
		array($place_id));
	}
	
	////////////////
	
	function get_categories_list()
	{
		return $this->db->query("SELECT * FROM places_categories ORDER BY id ASC");	
	}
	
	function get_categories_count()
	{
		$query=$this->db->query("SELECT count(*) AS cnt FROM places_categories");
		
		return $query->row()->cnt;
	}
	
	function get_subcategories_list()
	{
		$categories=$this->get_categories_list();
		
		$place_sub_categories;
		
		foreach($categories->result() as $category)
		{
			$id=$category->id;
			
			$place_sub_categories["$id"]=$this->db->query(
			"SELECT * FROM places_subcategories WHERE category_id=? ORDER BY id ASC",array($id));	
		}
		
		return $place_sub_categories;
	}
	
	function get_approoved_tags_list()
	{
		return $this->db->query("SELECT * FROM places_tags ORDER BY id ASC");	
	}
	
	//////
	
	function add()
	{
		$coord_country=str_replace(" - ","-",$this->input->post("coord_country"));
		$coord_district=str_replace(" - ","-",$this->input->post("coord_district"));
		$coord_municipality=str_replace(" - ","-",$this->input->post("coord_municipality"));
		$coord_city=str_replace(" - ","-",$this->input->post("coord_city"));
		
		if($coord_city=="") $coord_city=$coord_municipality;
		
		$country_id=$this->get_country_for_place_add($coord_country);
		$district_id=$municipality_id=$city_id=0;

		if($country_id)
		{
			// if country is found, try finding district
			$district_id=$this->get_district_for_place_add($coord_district,$country_id);
			
			if($district_id)
			{
				// if district is found, try finding municipality
				$municipality_id=$this->get_municipality_for_place_add($coord_municipality,$district_id);
				
				if($municipality_id)
				{
					// if municipality is found, try finding city
					$city_id=$this->get_city_for_place_add($coord_city,$municipality_id);
				}
			}
		}

		// Add to places
		$this->db->query("INSERT INTO places
		(profile_id,name,address,coord_x,coord_y,coord_country_id,
		coord_district_id,coord_municipality_id,coord_city_id,description,work_time,date)
		VALUES(?,?,?,?,?,?,?,?,?,?,?,now())",
		array($this->profile_id,$this->input->post("name"),$this->input->post("address"),
		$this->input->post("coord_x"),$this->input->post("coord_y"),
		$country_id,$district_id,$municipality_id,$city_id,
		$this->input->post("description"),$this->input->post("work_time")));
		
		$place_id=$this->db->insert_id();
		
		// if place added successfully
		if($place_id)
		{
			// associate subcategories to this place
			$subcategories=$this->input->post("subcategories");
			foreach($subcategories as $key=>$subcategory_id)
			{
				$category_id=$this->get_category_by_subcategory($subcategory_id);
				if($category_id) // such subcategory really exists
				{
					$this->db->query("INSERT INTO places_categories_link 
					(place_id,category_id,subcategory_id) VALUES(?,?,?)",
					array($place_id,$category_id,$subcategory_id));
				}
			}
			
			// associate tags to this place
			$tags=$this->input->post("tags");
			if(is_array($tags))
			{
				foreach($tags as $key=>$tag_id)
				{
					$tag_id=$this->tag_exists($tag_id);
					if($tag_id)
					{
						$this->db->query("INSERT INTO places_tags_link (place_id,tag_id) VALUES(?,?)",
						array($place_id,$tag_id));	
					}
				}
			}
			
			return $place_id;
		}
	}
	
	function make_place_backup($place_id)
	{
		// 1. Copy main data from places
		$this->db->query("
		INSERT INTO places_h (place_id,profile_creator_id,profile_editor_id,
		owner_id,name,address,coord_x,coord_y,coord_country_id,
		coord_district_id,coord_municipality_id,coord_city_id,description,work_time,date,date_h)
		
       	SELECT id AS place_id,profile_id AS profile_creator_id, ? AS profile_editor_id,
		owner_id,name,address,coord_x,coord_y,coord_country_id,
		coord_district_id,coord_municipality_id,coord_city_id,description,work_time,date, now() AS date_h 
		FROM places WHERE id=?
		",array($this->profile_id,$place_id));
		
		$place_h_id=$this->db->insert_id();
		
		// 2. Copy place categories		
		$place=$this->db->query("
		INSERT INTO places_categories_link_h (place_id,category_id,subcategory_id)		
       	SELECT ? AS place_id,category_id,subcategory_id FROM places_categories_link WHERE place_id=?
		",array($place_h_id,$place_id));
		
		// 3. Copy place tags		
		$place=$this->db->query("
		INSERT INTO places_tags_link_h (place_id,tag_id)		
       	SELECT ? AS place_id,tag_id FROM places_tags_link WHERE place_id=?
		",array($place_h_id,$place_id));
	}
	
	function edit($place_id)
	{
		//print_r($this->input->post("tags"));
		//exit;
		// make backup first
		
		$this->make_place_backup($place_id);
		
		// and now we can safely edit		
		$coord_country=str_replace(" - ","-",$this->input->post("coord_country"));
		$coord_district=str_replace(" - ","-",$this->input->post("coord_district"));
		$coord_municipality=str_replace(" - ","-",$this->input->post("coord_municipality"));
		$coord_city=str_replace(" - ","-",$this->input->post("coord_city"));
		
		if($coord_city=="") $coord_city=$coord_municipality;
		
		$country_id=$this->get_country_for_place_add($coord_country);
		$district_id=$municipality_id=$city_id=0;

		if($country_id)
		{
			// if country is found, try finding district
			$district_id=$this->get_district_for_place_add($coord_district,$country_id);
			
			if($district_id)
			{
				// if district is found, try finding municipality
				$municipality_id=$this->get_municipality_for_place_add($coord_municipality,$district_id);
				
				if($municipality_id)
				{
					// if municipality is found, try finding city
					$city_id=$this->get_city_for_place_add($coord_city,$municipality_id);
				}
			}
		}
		
		// Edit info in places
		$this->db->query("UPDATE places SET
		profile_id=?,address=?,coord_x=?,coord_y=?,coord_country_id=?,
		coord_district_id=?,coord_municipality_id=?,coord_city_id=?,description=?,work_time=? WHERE id=?",
		array($this->profile_id,$this->input->post("address"),
		$this->input->post("coord_x"),$this->input->post("coord_y"),
		$country_id,$district_id,$municipality_id,$city_id,
		$this->input->post("description"),$this->input->post("work_time"),$place_id));
		
		// delete the old subcategories associated to this place		
		$this->db->query("DELETE FROM places_categories_link WHERE place_id=?",array($place_id));
		
		// delete the old tags associated to this place		
		$this->db->query("DELETE FROM places_tags_link WHERE place_id=?",array($place_id));

		// associate subcategories to this place
		$subcategories=$this->input->post("subcategories");
		foreach($subcategories as $key=>$subcategory_id)
		{
			$category_id=$this->get_category_by_subcategory($subcategory_id);
			if($category_id) // such subcategory really exists
			{
				$this->db->query("INSERT INTO places_categories_link 
				(place_id,category_id,subcategory_id) VALUES(?,?,?)",
				array($place_id,$category_id,$subcategory_id));
			}
		}

		// associate tags to this place
		$tags=$this->input->post("tags");
		foreach($tags as $key=>$tag_id)
		{
			$tag_id=$this->tag_exists($tag_id);
			if($tag_id)
			{
				$this->db->query("INSERT INTO places_tags_link (place_id,tag_id) VALUES(?,?)",
				array($place_id,$tag_id));	
			}
		}	
	}
	
	function get_category_by_subcategory($subcategory_id)
	{
		$query=$this->db->query("SELECT category_id FROM places_subcategories WHERE id=?",
		array($subcategory_id));
		
		if($query->row()) return $query->row()->category_id;
	}
	
	function tag_exists($tag_id)
	{
		$query=$this->db->query("SELECT count(*) AS cnt FROM places_tags WHERE id=?",
		array($tag_id));
		
		if($query->row()->cnt) return $tag_id;
	}
	
	function get_country_for_place_add($country)
	{
		if(empty($country)) return 0;
		
		$query=$this->db->query("SELECT id FROM coord_countries WHERE name=? LIMIT 1",array($country));
		
		// if that country already exists, return it's ID
		if($query->row()) return $query->row()->id;
		else
		{
			// add the country and return it's ID
			$this->db->query("INSERT INTO coord_countries (name) VALUES(?)",
			array($country));
			
			return $this->db->insert_id();
		}
	}
	
	function get_district_for_place_add($district,$country_id)
	{
		if(empty($district)||empty($country_id)) return 0;
		
		$query=$this->db->query(
		"SELECT id FROM coord_districts
		WHERE name=? AND country_id=?
		LIMIT 1",array($district,$country_id));
		
		// if that district already exists, return it's ID
		if($query->row()) return $query->row()->id;
		else
		{
			// add the district and return it's ID
			$this->db->query("INSERT INTO coord_districts (country_id,name) VALUES(?,?)",
			array($country_id,$district));
			
			return $this->db->insert_id();
		}
	}
	
	function get_municipality_for_place_add($municipality,$district_id)
	{
		if(empty($municipality)||empty($district_id)) return 0;
		
		$query=$this->db->query(
		"SELECT id FROM coord_municipalities
		WHERE name=? AND district_id=?
		LIMIT 1",array($municipality,$district_id));
		
		// if that municipality already exists, return it's ID
		if($query->row()) return $query->row()->id;
		else
		{
			// add the municipality and return it's ID
			$this->db->query("INSERT INTO coord_municipalities (district_id,name) VALUES(?,?)",
			array($district_id,$municipality));
			
			return $this->db->insert_id();
		}
	}
	
	function get_city_for_place_add($city,$municipality_id)
	{
		if(empty($city)||empty($municipality_id)) return 0;
		
		$query=$this->db->query(
		"SELECT id FROM coord_cities
		WHERE name=? AND municipality_id=?
		LIMIT 1",array($city,$municipality_id));
		
		// if that city already exists, return it's ID
		if($query->row()) return $query->row()->id;
		else
		{
			// add the city and return it's ID
			$this->db->query("INSERT INTO coord_cities (municipality_id,name)VALUES(?,?)",
			array($municipality_id,$city));
			
			return $this->db->insert_id();
		}
	}
	
	function get_search_sugg_list($name,$limit)
	{
		$words=array();
		
		foreach(explode(",",$name) as $key=>$value)
		{
			foreach(explode(" ",$value) as $key2=>$value2)
			{
				if($value2)	$words[]=$this->db->escape_like_str($value2);
			}
		}
		
		$sql_where_name='';
		$sql_where_address='';
		
		foreach($words as $key=>$value)
		{
			$sql_where_name.="name LIKE '%$value%' AND ";
			$sql_where_address.="address LIKE '%$value%' AND ";
		}
				
		$sql_where_name=substr($sql_where_name,0,-5);
		$sql_where_address=substr($sql_where_address,0,-5);
		
		$query=$this->db->query("
		SELECT * FROM (
			(SELECT *, 1 AS priority FROM places WHERE $sql_where_name)
			UNION
			(SELECT *, 2 AS priority FROM places WHERE $sql_where_address)
		) AS tf GROUP BY id ORDER BY priority ASC LIMIT ?
		",array($limit));
		
		return $query;
	}
	
	function get_all_visible_tags()
	{
		return $this->db->query("SELECT * FROM places_tags WHERE status=1");	
	}
	
	function get_search_list($from,$to)
	{
		
		$sql_where_name='1=1 AND ';
		$sql_where_address='1=1 AND ';
		$tables="places t1, ";
		
		$name=$this->input->post("name");		
		if($name)
		{			
			$words=array();
			
			foreach(explode(",",$name) as $key=>$value)
			{
				foreach(explode(" ",$value) as $key2=>$value2)
				{
					if($value2)	$words[]=$this->db->escape_like_str($value2);
				}
			}

			foreach($words as $key=>$value)
			{
				$sql_where_name.="t1.name LIKE '%$value%' AND ";
				$sql_where_address.="t1.address LIKE '%$value%' AND ";
			}
		}
		
		$subcategories=$this->input->post("h_subcategories");
		if($subcategories)
		{
			$tables.="places_categories_link t2, ";
			
			foreach($subcategories as $subcategory)
			{
				$subcategory=$this->db->escape_str($subcategory);
				$sql_where_name.="t1.id=t2.place_id AND t2.subcategory_id=$subcategory AND ";
				$sql_where_address.="t1.id=t2.place_id AND t2.subcategory_id=$subcategory AND ";	
			}
		}
		
		$tags=$this->input->post("h_tags");
		if($tags)
		{
			$tables.="places_tags_link t3, ";
			
			foreach($tags as $tag)
			{
				$tag=$this->db->escape_str($tag);
				$sql_where_name.="t1.id=t3.place_id AND t3.tag_id=$tag AND ";
				$sql_where_address.="t1.id=t3.place_id AND t3.tag_id=$tag AND ";	
			}
		}
		
		$city=$this->input->post("city");
		if($city)
		{
			$tables.="coord_cities t4, ";
			
			$city=$this->db->escape_str($city);
			$sql_where_name.="t1.coord_city_id=t4.id AND t4.name='$city' AND ";
			$sql_where_address.="t1.coord_city_id=t4.id AND t4.name='$city' AND ";	
		}
				
		$sql_where_name=substr($sql_where_name,0,-5);
		$sql_where_address=substr($sql_where_address,0,-5);
		$tables=substr($tables,0,-2);

		$query=$this->db->query("
		SELECT * FROM (
			(SELECT t1.*, 1 AS priority FROM $tables WHERE $sql_where_name)
			UNION
			(SELECT t1.*, 2 AS priority FROM $tables WHERE $sql_where_address)
		) AS tf GROUP BY id ORDER BY priority ASC LIMIT $from,$to
		");
		
		return $query;	
	}
	
	function get_search_count()
	{
		$name=$this->input->post("name");
		
		$words=array();
		
		foreach(explode(",",$name) as $key=>$value)
		{
			foreach(explode(" ",$value) as $key2=>$value2)
			{
				if($value2)	$words[]=$this->db->escape_like_str($value2);
			}
		}
		
		$sql_where_name='1=1 AND ';
		$sql_where_address='1=1 AND ';
		
		foreach($words as $key=>$value)
		{
			$sql_where_name.="name LIKE '%$value%' AND ";
			$sql_where_address.="address LIKE '%$value%' AND ";
		}
				
		$sql_where_name=substr($sql_where_name,0,-5);
		$sql_where_address=substr($sql_where_address,0,-5);
		
		$query=$this->db->query("
			SELECT sum(cnt) AS cnt FROM (
			(SELECT count(*) AS cnt FROM places WHERE $sql_where_name)
			UNION
			(SELECT count(*) AS cnt FROM places WHERE $sql_where_address)
			) AS tf
		");

		return $query->row()->cnt;	
	}
	
	function generate_search_key($post)
	{
		$post=serialize($post);		
		$key=md5($post);
		
		$query=$this->db->query("SELECT count(*) AS cnt FROM place_searches WHERE `key`=?",array($key));
		
		if($query->row()->cnt) return $key;
		else
		{
			$this->db->query("INSERT INTO place_searches (`key`,params,date) VALUES(?,?,now())",
			array($key,$post));
			
			return $key;
		}
	}
	
	function get_search_key($key)
	{
		$query=$this->db->query("SELECT params FROM place_searches WHERE `key`=? LIMIT 1",array($key));

		if($query->row()) return unserialize($query->row()->params);
	}
	
	
	function get_favorites_list($place_id,$from,$to)
	{
		$query=$this->db->query("SELECT t1.id, t1.username, t1.avatar 
		FROM profiles t1, favorite_places t2 WHERE t1.id=t2.profile_id AND t2.place_id=?
		ORDER BY t2.date DESC LIMIT ?,?",
		array($place_id,$from,$to));
		
		return $query;
	}
	
	function get_favorites_count($place_id)
	{
		$query=$this->db->query("SELECT count(*) AS cnt FROM favorite_places WHERE place_id=?",
		array($place_id));
		
		return $query->row()->cnt;
	}
	
	function register_place_pictures_add($place_id,$type)
	{
		// Try finding a not timed out registration for adding pictures
		$ref_id=$this->get_valid_place_pictures_add_registration($place_id,$type);
		if($ref_id) return $ref_id;
		else // If nothing is found, create a new one
		{	
			$this->db->query("INSERT INTO place_pictures (place_id,profile_id,type,date) VALUES(?,?,?,now())",
			array($place_id,$this->profile_id,$type));
			
			return $this->db->insert_id();
		}
	}
	
	function get_valid_place_pictures_add_registration($place_id, $type)
	{
		$query=$this->db->query("SELECT id FROM place_pictures
		WHERE place_id=? AND profile_id=? AND type=? 
		AND TIMESTAMPADD(MINUTE,10,`date`)>=now()",
		array($place_id, $this->profile_id, $type));
		
		if($query->row()) return $query->row()->id;
	}
	
	function add_user_picture($ref_id,$file_name,$file_ext)
	{
		$this->db->query("INSERT INTO pictures (ref_id,type,name,ext,date) VALUES(?,1,?,?,now())",
		array($ref_id,$file_name,$file_ext));	
	}

	function get_customization($place_id)
	{
		$query=$this->db->query("SELECT * FROM place_customization WHERE place_id=?",
		array($place_id));

		return $query->row();
	}
	
	function get_pictures($place_id,$from,$to)
	{
		$query=$this->db->query("SELECT t2.* FROM place_pictures t1, pictures t2
		WHERE t1.id=t2.ref_id AND t2.type=1 AND t1.place_id=? ORDER BY date DESC LIMIT ?,?",
		array($place_id,$from,$to));
		
		return $query;
	}
	
	function get_pictures_count($place_id)
	{
		$query=$this->db->query("SELECT count(*) As cnt FROM place_pictures t1, pictures t2
		WHERE t1.id=t2.ref_id AND t2.type=1 AND t1.place_id=?",array($place_id));
		
		return $query->row()->cnt;
	}
}