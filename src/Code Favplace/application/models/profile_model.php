<?
class Profile_model extends MY_Model{
	
	function __construct()
	{
		parent::__construct();	
	}
	
	function get($profile_id)
	{
		$query=$this->db->query("SELECT * FROM profiles WHERE id=? LIMIT 1",
		array($profile_id));
		
		return $query->row();
	}
	
	function get_id_by_username($username)
	{
		$query=$this->db->query("SELECT id FROM profiles WHERE username=? LIMIT 1",
		array($username));
		
		if($query->row()) return $query->row()->id;
	}
	
	function get_username_by_id($profile_id)
	{
		$query=$this->db->query("SELECT username FROM profiles WHERE id=? LIMIT 1",
		array($profile_id));
		
		if($query->row()) return $query->row()->username;
	}
	
	function get_place_name_by_id($place_id)
	{
		$query=$this->db->query("SELECT name FROM places WHERE id=?",
		array($place_id));
		
		if($query->row()) return $query->row()->name;
	}
	
	function get_event_name_by_id($event_id)
	{
		$query=$this->db->query("SELECT name FROM events WHERE id=?",
		array($event_id));
		
		if($query->row()) return $query->row()->name;
	}
	
	function get_by_username($username)
	{
		$query=$this->db->query("SELECT * FROM profiles WHERE username=?",
		array($username));
		
		return $query->row();
	}
	
	function is_following($follower_id,$to_follow_id)
	{
		$query=$this->db->query("SELECT count(*) AS cnt FROM profile_followers WHERE follower_id=? AND followed_id=?",
		array($follower_id,$to_follow_id));
		
		return $query->row()->cnt;
	}
	
	function follow($follower_id,$to_follow_id)
	{
		$this->db->query("INSERT INTO profile_followers (follower_id,followed_id,date) VALUES(?,?,now())",
		array($follower_id,$to_follow_id));
		
		return (bool) $this->db->affected_rows();
	}
	
	function unfollow($follower_id,$to_follow_id)
	{
		$this->db->query("DELETE FROM profile_followers WHERE follower_id=? AND followed_id=? LIMIT 1",
		array($follower_id,$to_follow_id));
		
		return (bool) $this->db->affected_rows();
	}
	
	function edit_info()
	{
		$this->db->query("UPDATE profiles SET name=?, sex_id=?, birthdate=?, description=?, personal_site=?, facebook=?, twitter=? WHERE id=?",
		array($this->input->post("name"),$this->input->post("sex_id"),
		$this->input->post("birth_year")."-".$this->input->post("birth_month")."-".$this->input->post("birth_day"),
		$this->input->post("description"),
		$this->input->post("personal_site"),$this->input->post("facebook"),$this->input->post("twitter"),
		$this->profile_id));
	}
	
	function set_avatar($ext)
	{
		$this->db->query("UPDATE profiles SET avatar=? WHERE id=?",
		array($ext,$this->profile_id));
	}
	
	function set_no_avatar()
	{
		$this->db->query("UPDATE profiles SET avatar=0 WHERE id=?",
		array($this->profile_id));
	}
	
	function edit_account_email()
	{
		$this->db->query("UPDATE profiles SET email=? WHERE id=?",
		array($this->input->post("email"),$this->profile_id));
	}
	
	function edit_account_password()
	{
		$this->db->query("UPDATE profiles SET password=md5(?) WHERE id=?",
		array($this->input->post("password"),$this->profile_id));
	}
	
	function is_new_email_free($email)
	{
		$query=$this->db->query("SELECT count(*) AS cnt FROM profiles WHERE email=? AND id!=?",
		array($email,$this->profile_id));
		$email=$query->row();
		
		if($email->cnt) return false;
		else return true;
	}
	
	function get_comment($comment_id)
	{
		$query=$this->db->query("SELECT *, TIMEDIFF(now(),date) AS date_diff FROM profile_comments WHERE id=?",
		array($comment_id));
		
		return $query->row();
	}
	
	function add_comment($comment_array)
	{
		$params_ready=array();
		
		// finding, checking and remembering the position of the special strings
		$comment=$comment_array["comment"];
		foreach($comment_array['params'] as $param)
		{
			if(is_int($param["id"])&&is_int($param["type"]))
			{
				if($param["type"]===1) // if it's a user that is mentioned i.e: @yordanoff
				{
					// check if username with this id exists
					$username=$this->get_username_by_id($param["id"]);
					if($username)
					{
						 $needle=0;
						 while(TRUE)
						 {
							$needle=stripos($comment,$username,$needle);
							if($needle===FALSE) break;
							else
							{
								$params_ready[]=array(
									'id'=>$param["id"],
									'type'=>$param["type"],
									'pos'=>$needle,
									'str'=>$username
								);

								$needle=$needle+1;
							}
						 }
					}
				}
				if($param["type"]===2) // if it's a place that is mentioned i.e: @НДК
				{
					// check if place with this id exists
					$name=$this->get_place_name_by_id($param["id"]);
					if($name)
					{
						 $needle=0;
						 while(TRUE)
						 {
							$needle=stripos($comment,$name,$needle);
							if($needle===FALSE) break;
							else
							{
								$params_ready[]=array(
									'id'=>$param["id"],
									'type'=>$param["type"],
									'pos'=>$needle,
									'str'=>$name
								);

								$needle=$needle+1;
							}
						 }
					}
				}
			}
		}
		
		// delete the special strings, once we know their position
		foreach($params_ready as $param)
		{
			$comment=str_replace($param["str"],'',$comment);
		}
		
		$geotag_place_id=isset($comment_array["geotag_place_id"])?$comment_array["geotag_place_id"]:0;
		$geotag_type=isset($comment_array["geotag_type"])?$comment_array["geotag_type"]:0;
		// insert the comment without the special strings
		$this->db->query("INSERT INTO profile_comments (profile_id,place_id,comment,type,date) 
		VALUES(?,?,?,?,now())",
		array($this->profile_id,$geotag_place_id,$comment,$geotag_type));
		
		$comment_id=$this->db->insert_id();
		
		// insert the special strings with their position
		foreach($params_ready as $param)
		{
			$this->db->query("INSERT INTO profile_comment_params 
			(profile_comment_id,param_id,param_type,param_pos)VALUES(?,?,?,?)",
			array($comment_id,$param["id"],$param["type"],$param["pos"]));
		}
		
		if($geotag_place_id and $geotag_type==1) 
		// if the user has checked at a place, increment the statistics for the user
		{
			$this->increment_place_visited($this->profile_id);
		}
		
		if($geotag_place_id and $geotag_type==2) 
		// if the user has checked at a place, increment the statistics for the user
		{
			$this->increment_place_will_visit($this->profile_id);
		}
		
		return $comment_id;
	}
	
	function increment_place_visited($profile_id)
	{
		$this->db->query("UPDATE profiles SET places_visited=places_visited+1 WHERE id=?",
		array($profile_id));
	}
	
	function increment_place_will_visit($profile_id)
	{
		$this->db->query("UPDATE profiles SET places_will_visit=places_will_visit+1 WHERE id=?",
		array($profile_id));
	}
	
	function comment_suggestions($term)
	{
		$profile_term=$this->db->escape_like_str($term).'%';
		
		//
		
		$words=array();
		
		foreach(explode(",",$term) as $key=>$value)
		{
			foreach(explode(" ",$value) as $key2=>$value2)
			{
				if($value2)	$words[]=$this->db->escape_str($value2);
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
		
		//
		$query=$this->db->query("
		SELECT * FROM
		(
			(SELECT id, username AS name, '1' AS type FROM profiles WHERE username LIKE '$profile_term' LIMIT 4)
			UNION
			(SELECT id, name, '2' AS type FROM places WHERE $sql_where_name LIMIT 4)
			UNION
			(SELECT id, name, '2' AS type FROM places WHERE $sql_where_address LIMIT 2)
		) tmp LIMIT 10",
		array($term));
		
		return $query;
	}
	
	function place_suggestions($term)
	{
		$profile_term=$this->db->escape_like_str($term).'%';
		
		//
		
		$words=array();
		
		foreach(explode(",",$term) as $key=>$value)
		{
			foreach(explode(" ",$value) as $key2=>$value2)
			{
				if($value2)	$words[]=$this->db->escape_str($value2);
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
		
		//
		$query=$this->db->query("
		SELECT * FROM
		(
			(SELECT id, name, coord_x, coord_y FROM places WHERE $sql_where_name LIMIT 7)
			UNION
			(SELECT id, name, coord_x, coord_y FROM places WHERE $sql_where_address LIMIT 3)
		) tmp LIMIT 10",
		array($term));
		
		return $query;
	}
	
	function get_wallstream($profile_id,$options=array(),$limit=0)
	{
		
		$limit=intval($limit);
		$profile_id=intval($profile_id);
		
		$sql_parts=array();

		if(isset($options["all"])&&$options["all"]==TRUE)
		{
			$sql_parts[]="
			SELECT * FROM
			(
				SELECT 1 AS w_type, t2.id, t2.profile_id AS from_id, place_id AS to_id, type AS sub_type,
				(SELECT username FROM profiles WHERE id=t2.profile_id) AS from_name,
				(SELECT name FROM places WHERE to_id!=0 AND id=to_id) AS to_name,
				t2.comment AS content, t2.date, TIMEDIFF(now(),t2.date) AS date_diff FROM 
				(
					(SELECT DISTINCT profile_comment_id AS id 
					FROM profile_comment_params WHERE param_type=1 AND param_id=$profile_id)
					UNION
					(SELECT st1.id FROM profile_comments st1,profile_followers st2
					WHERE st1.profile_id=$profile_id 
					OR (st1.profile_id=st2.followed_id AND st2.follower_id=$profile_id))
				) t1, profile_comments t2 WHERE t1.id=t2.id GROUP BY t1.id
			) tmp1
			";
			
			$sql_parts[]="
			SELECT * FROM
			(
				SELECT 2 AS w_type, t2.id, profile_id AS from_id, place_id AS to_id, 0 AS sub_type,
				(SELECT username FROM profiles WHERE id=profile_id) AS from_name,
				(SELECT name FROM places WHERE id=place_id) AS to_name,'' AS content,
				
				(SELECT date FROM place_pictures t1 
				WHERE t1.profile_id=t2.profile_id AND t1.place_id=t2.place_id ORDER BY date ASC LIMIT 1) AS date,
				
				TIMEDIFF(now(),t2.date) AS date_diff
				FROM place_pictures t2, profile_followers t3
				WHERE profile_id=$profile_id 
				OR (t2.profile_id=t3.followed_id AND t3.follower_id=$profile_id)
			) tmp2 
			";
			
			$sql_parts[]="
			SELECT * FROM
			(
				 SELECT 5 AS w_type, t2.id, profile_id AS from_id, place_id AS to_id, 0 AS sub_type,
				(SELECT username FROM profiles WHERE id=profile_id) AS from_name,
				(SELECT name FROM places WHERE id=place_id) AS to_name,
				t2.name AS content, t2.date,				
				TIMEDIFF(now(),t2.date) AS date_diff
				FROM events t2, profile_followers t3
				WHERE profile_id=$profile_id 
				OR (t2.profile_id=t3.followed_id AND t3.follower_id=$profile_id)
			) tmp6
			";
			
			$sql_parts[]="
			SELECT * FROM
			(
				 SELECT 6 AS w_type, t2.id, profile_id AS from_id, place_id AS to_id, 0 AS sub_type,
				(SELECT username FROM profiles WHERE id=profile_id) AS from_name,
				(SELECT name FROM places WHERE id=place_id) AS to_name,
				'' AS content, t2.date,				
				TIMEDIFF(now(),t2.date) AS date_diff
				FROM favorite_places t2, profile_followers t3
				WHERE profile_id=$profile_id 
				OR (t2.profile_id=t3.followed_id AND t3.follower_id=$profile_id)
			) tmp6
			";
			
			$sql_parts[]="
			SELECT * FROM
			(
				 SELECT 7 AS w_type, t2.id, profile_id AS from_id, event_id AS to_id, 0 AS sub_type,
				(SELECT username FROM profiles WHERE id=profile_id) AS from_name,
				(SELECT name FROM events WHERE id=event_id) AS to_name,
				'' AS content, t2.date,				
				TIMEDIFF(now(),t2.date) AS date_diff
				FROM event_visits t2, profile_followers t3
				WHERE profile_id=$profile_id 
				OR (t2.profile_id=t3.followed_id AND t3.follower_id=$profile_id)
			) tmp6
			";
		}
		
		$sql="
		SELECT * FROM
		(
		";
		
		
		if( ! sizeof($sql_parts)) return;
		
		foreach($sql_parts as $sql_part)
		{
			$sql.=$sql_part." UNION ";
		}
		$sql=substr($sql,0,-7);
		
		$sql.=") t_all ORDER BY date_diff ASC LIMIT $limit,10";
		
		
		$query=$this->db->query($sql);
		
		foreach($query->result() as $item)
		{
			$item->to_name=$this->remove_html($item->to_name);
			$item->content=$this->remove_html($item->content);
				
			switch($item->w_type)
			{
				case 1:
					$item->content=$this->insert_mentioned_in_comment($item->id,$item->content);
					
					break;
				case 2:
					$item->pictures=$this->db->query("SELECT * FROM pictures WHERE ref_id=? AND type=1",
					array($item->id));
					
					if($item->pictures->num_rows()>1)
					{
						$item->content='качи снимки за <a href="place/'.$item->to_id.'/'.url_title($item->to_name).'">'.$item->to_name.'</a>';	
					}
					else
					{
						$item->content='качи снимка за <a href="place/'.$item->to_id.'/'.url_title($item->to_name).'">'.$item->to_name.'</a>';
					}
					
					break;
				case 5:
					$item->content='създаде ново събитие: <a href="event/'.$item->id.'/'.url_title($item->content).'">'.$item->content.'</a> към <a href="place/'.$item->to_id.'/'.url_title($item->to_name).'">'.$item->to_name.'</a>';
					
					break;
				case 6:
					$item->content='добави <a href="place/'.$item->to_id.'/'.url_title($item->to_name).'">'.
					$item->to_name.'</a> в любими';
					//$item->pictures=$this->db->query("SELECT * FROM pictures WHERE ref_id=? AND type=1",
					//array($item->id));
					
					break;
				case 7:
					$item->content='ще посети <a href="event/'.$item->to_id.'/'.url_title($item->to_name).'">'.$item->to_name.'</a>';
					break;
				default:continue;
			}

			$item->comments=$this->wallstream_item_comments($item->w_type,$item->id);
		}

		return $query;
	}
	
	function get_profile_wallstream($profile_id,$options=array(),$limit=0)
	{		
		$limit=intval($limit);
		$profile_id=intval($profile_id);
		
		$sql_parts=array();

				if(isset($options["all"])&&$options["all"]==TRUE)
		{
			$sql_parts[]="
			SELECT * FROM
			(
				SELECT 1 AS w_type, t2.id, t2.profile_id AS from_id, place_id AS to_id, type AS sub_type,
				(SELECT username FROM profiles WHERE id=t2.profile_id) AS from_name,
				(SELECT name FROM places WHERE to_id!=0 AND id=to_id) AS to_name,
				t2.comment AS content, t2.date, TIMEDIFF(now(),t2.date) AS date_diff FROM 
				(
					(SELECT DISTINCT profile_comment_id AS id 
					FROM profile_comment_params WHERE param_type=1 AND param_id=$profile_id)
					UNION
					(SELECT st1.id FROM profile_comments st1,profile_followers st2
					WHERE st1.profile_id=$profile_id)
				) t1, profile_comments t2 WHERE t1.id=t2.id GROUP BY t1.id
			) tmp1
			";
			
			$sql_parts[]="
			SELECT * FROM
			(
				SELECT 2 AS w_type, t2.id, profile_id AS from_id, place_id AS to_id, 0 AS sub_type,
				(SELECT username FROM profiles WHERE id=profile_id) AS from_name,'' AS to_name,
				(SELECT name FROM places WHERE id=place_id) AS content,
				
				(SELECT date FROM place_pictures t1 
				WHERE t1.profile_id=t2.profile_id AND t1.place_id=t2.place_id ORDER BY date ASC LIMIT 1) AS date,
				
				TIMEDIFF(now(),t2.date) AS date_diff
				FROM place_pictures t2
				WHERE profile_id=$profile_id
			) tmp2 
			";
			
			$sql_parts[]="
			SELECT * FROM
			(
				 SELECT 5 AS w_type, t2.id, profile_id AS from_id, place_id AS to_id, 0 AS sub_type,
				(SELECT username FROM profiles WHERE id=profile_id) AS from_name,
				(SELECT name FROM places WHERE id=place_id) AS to_name,
				t2.name AS content, t2.date,				
				TIMEDIFF(now(),t2.date) AS date_diff
				FROM events t2
				WHERE profile_id=$profile_id 
			) tmp6
			";
			
			$sql_parts[]="
			SELECT * FROM
			(
				 SELECT 6 AS w_type, t2.id, profile_id AS from_id, place_id AS to_id, 0 AS sub_type,
				(SELECT username FROM profiles WHERE id=profile_id) AS from_name,
				(SELECT name FROM places WHERE id=place_id) AS to_name,
				'' AS content, t2.date,				
				TIMEDIFF(now(),t2.date) AS date_diff
				FROM favorite_places t2
				WHERE profile_id=$profile_id 
			) tmp6
			";
			
			$sql_parts[]="
			SELECT * FROM
			(
				 SELECT 7 AS w_type, t2.id, profile_id AS from_id, event_id AS to_id, 0 AS sub_type,
				(SELECT username FROM profiles WHERE id=profile_id) AS from_name,
				(SELECT name FROM events WHERE id=event_id) AS to_name,
				'' AS content, t2.date,				
				TIMEDIFF(now(),t2.date) AS date_diff
				FROM event_visits t2, profile_followers t3
				WHERE profile_id=$profile_id 
				OR (t2.profile_id=t3.followed_id AND t3.follower_id=$profile_id)
			) tmp6
			";
		}
		
		$sql="
		SELECT * FROM
		(
		";
		
		
		if( ! sizeof($sql_parts)) return;
		
		foreach($sql_parts as $sql_part)
		{
			$sql.=$sql_part." UNION ";
		}
		$sql=substr($sql,0,-7);
		
		$sql.=") t_all ORDER BY date_diff ASC LIMIT $limit,10";
		
		
		$query=$this->db->query($sql);
		
		foreach($query->result() as $item)
		{
			$item->to_name=$this->remove_html($item->to_name);
			$item->content=$this->remove_html($item->content);
				
			switch($item->w_type)
			{
				case 1:
					$item->content=$this->insert_mentioned_in_comment($item->id,$item->content);
					
					break;
				case 2:					
					$item->pictures=$this->db->query("SELECT * FROM pictures WHERE ref_id=? AND type=1",
					array($item->id));
					
					if($item->pictures->num_rows()>1)
					{
						$item->content='качи снимки за <a href="place/'.$item->to_id.'/'.url_title($item->to_name).'">'.$item->to_name.'</a>';	
					}
					else
					{
						$item->content='качи снимка за <a href="place/'.$item->to_id.'/'.url_title($item->to_name).'">'.$item->to_name.'</a>';
					}
					
					break;
				case 5:
					$item->content='създаде ново събитие: <a href="event/'.$item->id.'/'.url_title($item->content).'">'.$item->content.'</a> към <a href="place/'.$item->to_id.'/'.url_title($item->to_name).'">'.$item->to_name.'</a>';
					
					break;
				case 6:
					$item->content='добави <a href="place/'.$item->to_id.'/'.url_title($item->to_name).'">'.
					$item->to_name.'</a> в любими';
					//$item->pictures=$this->db->query("SELECT * FROM pictures WHERE ref_id=? AND type=1",
					//array($item->id));
					
					break;
				case 7:
					$item->content='ще посети <a href="event/'.$item->to_id.'/'.url_title($item->to_name).'">'.$item->to_name.'</a>';
					break;
				default:continue;
			}

			$item->comments=$this->wallstream_item_comments($item->w_type,$item->id);
		}


		return $query;
	}
	
	function wallstream_item_comments($w_type,$ref_id)
	{
		$wall_id=$this->get_item_in_wall_id($w_type,$ref_id);

		if($wall_id)
		{
			
			$query=$this->db->query("SELECT t1.*,
			(SELECT username FROM profiles WHERE id=t1.profile_id) AS username
			FROM profile_wall_comments t1 WHERE t1.profile_wall_id=?",
			array($wall_id));
			
			return $query;
		}
	}
	
	function insert_mentioned_in_comment($comment_id,$comment_text)
	{
		$comment_text=nl2br(htmlspecialchars($comment_text));
		
		$query=$this->db->query("
		SELECT * FROM
		(
		(SELECT DISTINCT  t1.id AS p_id, t2.id, t1.param_pos, t2.username AS str, 1 AS type 
		FROM profile_comment_params t1, profiles t2 
		WHERE t1.profile_comment_id=? AND t1.param_type=1 AND t1.param_id=t2.id)
		
		UNION
		
		(SELECT DISTINCT  t1.id AS p_id, t2.id, t1.param_pos, t2.name AS str, 2 AS type
		FROM profile_comment_params t1, places t2 
		WHERE t1.profile_comment_id=? AND t1.param_type=2 AND t1.param_id=t2.id)
		) t_all GROUP BY p_id ORDER BY param_pos
		",
		array($comment_id,$comment_id));

		$pos=0;
		foreach($query->result() as $mentioned)
		{
			$mentioned->str=htmlspecialchars($mentioned->str);
			
			
			switch($mentioned->type)
			{
				case 1:
					$str='<a href="'.profile_link($mentioned->str).'">'.$mentioned->str.'</a>';
					break;
				case 2:
					$str='<a href="place/'.$mentioned->id.'/'.url_title($mentioned->str).'">'.$mentioned->str.'</a>';
					break;
				default: $str=$mentioned->str;
			}
			
			$comment_text=substr_replace($comment_text, $str, $mentioned->param_pos+$pos, 0);
			
			$pos+=strlen($str)-strlen($mentioned->str);
		}

		return $comment_text;
	}
	
	function get_item_in_wall_id($w_type,$ref_id)
	{
		$query=$this->db->query("SELECT id FROM profile_walls WHERE ref_id=? AND type=?",
		array($ref_id,$w_type));
		
		if($query->row()) return $query->row()->id;
	}
	
	function wall_comment($ref_id,$w_type,$comment)
	{		
		$wall_id=$this->get_item_in_wall_id($w_type,$ref_id);
		
		// if this item is not registered in the wall yet, register it
		if( ! $wall_id)
		{
			$this->db->query("INSERT INTO profile_walls (ref_id,type) VALUES(?,?)",
			array($ref_id,$w_type));
			
			$wall_id=$this->db->insert_id();
		}
		
		$this->db->query("INSERT INTO profile_wall_comments 
		(profile_wall_id,profile_id,comment,date) VALUES(?,?,?,now())",
		array($wall_id,$this->profile_id,$comment));
		
		return $this->db->insert_id(); 
	}
	
	function get_followers_count($profile_id)
	{
		$query=$this->db->query("SELECT count(*) AS cnt	FROM profile_followers t1, profiles t2
		WHERE followed_id=? AND t1.follower_id=t2.id",
		array($profile_id));
		
		return $query->row()->cnt;
	}
	
	function get_followers($profile_id,$from,$to)
	{
		return $this->db->query("SELECT *,
		(SELECT count(*) FROM profile_followers WHERE followed_id=t1.follower_id) AS followed
		FROM profile_followers t1, profiles t2
		WHERE followed_id=? AND t1.follower_id=t2.id ORDER BY date DESC LIMIT ?,?",
		array($profile_id,$from,$to));	
	}
	
	function get_followed_count($profile_id)
	{
		$query=$this->db->query("SELECT count(*) AS cnt FROM profile_followers t1, profiles t2
		WHERE follower_id=? AND t1.followed_id=t2.id",
		array($profile_id));	
		
		return $query->row()->cnt;
	}
	
	function get_followed($profile_id,$from,$to)
	{
		return $this->db->query("SELECT *
		FROM profile_followers t1, profiles t2
		WHERE follower_id=? AND t1.followed_id=t2.id ORDER BY date DESC LIMIT ?,?",
		array($profile_id,$from,$to));	
	}
	
	// Favorites
	
	function is_place_favorite($place_id)
	{
		$query=$this->db->query("SELECT count(*) AS cnt FROM favorite_places WHERE profile_id=? AND place_id=?",
		array($this->profile_id,$place_id));
		
		if($query->row()->cnt) return TRUE;
		else return FALSE;
	}
		
	function favorite_place_add($place_id,$category_id)
	{
		$this->db->query("INSERT INTO favorite_places 
		(profile_id,place_id,category_id,date) VALUES(?,?,?,now())",
		array($this->profile_id,$place_id,$category_id));	
	}
	
	function favorite_place_remove($place_id)
	{
		$this->db->query("DELETE FROM favorite_places WHERE profile_id=? AND place_id=? LIMIT 1",
		array($this->profile_id, $place_id));	
	}
	
	function get_favorite_places_by_category($profile_id,$category_id)
	{
		$query=$this->db->query("SELECT t2.* FROM favorite_places t1, places t2
		WHERE t1.profile_id=? AND t1.category_id=? AND t1.place_id=t2.id ORDER BY date DESC",
		array($profile_id,$category_id));
		
		return $query;
	}
	
	function get_all_favorites_count($profile_id)
	{
		$query=$this->db->query("SELECT count(*) AS cnt FROM favorite_places WHERE profile_id=?",
		array($profile_id));
		
		return $query->row()->cnt;
	}
	
	function get_cities_autocomplete_list($city)
	{
		$city=$this->db->escape_like_str($city);
		
		$query=$this->db->query("SELECT * FROM coord_cities WHERE type=1 AND status=1 
		AND name LIKE '$city%' LIMIT 10");	
		
		return $query;
	}
	
	function get_near_users()
	{
		$last_user_pos=$this->db->query("SELECT * FROM places t1, profile_comments t2
		WHERE t2.profile_id=? AND t1.id=t2.place_id AND t2.place_id!=0 AND t2.type=1 ORDER BY t2.date DESC",
		array($this->profile_id));
		
		if($last_user_pos->row())
		{
			$last_user_pos=$last_user_pos->row();
			$last_user_x=$last_user_pos->coord_x;
			$last_user_y=$last_user_pos->coord_y;
			
			$radius=10;
		
			// get the users who checked themselfs in the last 30 minutes in a radius specified by $radius
			$query=$this->db->query("
			SELECT profiles.id, profiles.username FROM profiles,
			(			
				SELECT DISTINCT t2.profile_id FROM places t1, profile_comments t2 
				WHERE distance(coord_x, coord_y, ?, ?)<?
				AND t2.place_id=t1.id AND t2.type=1 AND TIMESTAMPADD(MINUTE,30,t2.date)>now()
				ORDER BY t2.date DESC
			) t_comb WHERE profiles.id=t_comb.profile_id AND profiles.id!=?
			",
			array($last_user_x,$last_user_y,$radius,$this->profile_id));
			
			return $this->remove_html($query);
		}
	}
}