<?php

class Profile extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index($username='')
	{
		$this->load->model("Profile_model","",TRUE);
		
		
		// If user is logged.
		if($username==''&&$this->username!='') $username=$this->username; 
		
		if( ! $username) redirect(""); // If user is not logged and no username is specified, then exit.
		
		$profile=$this->Profile_model->get_by_username($username);
		if(!$profile) // If no user with that username is found, then exit.
		{
			redirect(""); 
		}
		
		// All checked, do it!
		
		$data['favorites_count']=$this->Profile_model->get_all_favorites_count($profile->id);
		if($this->user_logged) 
		{
			$data['followed']=$this->Profile_model->is_following($this->profile_id,$profile->id);
			$options=array('all'=>TRUE);
			$data["wallstream"]=$this->Profile_model->get_profile_wallstream($profile->id,$options);
			$data['profile']=$profile;
			$this->load->view('profile/r/index',$data);
		}
		else
		{
			$data['profile']=$profile;
			$this->load->view('profile/index',$data);
		}
	}
	
	function ajax_wall($profile_id,$from)
	{
		$this->r_nlogged_ajax();
		
		$this->load->model("Profile_model","",TRUE);
		
		$profile=$this->Profile_model->get($profile_id);
		
		if( ! $profile)
		{
			echo json_encode(array('status'=>'error','description'=>'Няма такъв потребител.')); 	
		}
		
		$from=intval($from);
		$options=array('all'=>TRUE);
		$data["wallstream"]=$this->Profile_model->get_profile_wallstream($profile_id,$options,$from);
		$content=$this->load->view('profile/r/ajax/wall',$data,TRUE);
		echo json_encode(array('status'=>'ok','content'=>$content,'count'=>$data["wallstream"]->num_rows()));
	}
	
	function follow($username='')
	{
		$this->r_nlogged_ajax();
		
		$this->load->model("Profile_model","",TRUE);
		
		if($username==$this->username) 
		{
			echo json_encode(array('status'=>'error','description'=>'Не можеш да следиш себе си.')); 
			exit;
		}
		
		$to_follow_id=$this->Profile_model->get_id_by_username($username);
		
		// if there is no such user, then exit
		if( ! $to_follow_id) 
		{
			echo json_encode(array('status'=>'error','description'=>'Няма такъв потребител.')); 
			exit;
		}
		
		// if you're already following this user, then exit
		if($this->Profile_model->is_following($this->profile_id,$to_follow_id)) 
		{
			echo json_encode(array('status'=>'error','description'=>'Вeче следиш този потребител.')); 
			exit;
		}
		
		// All checked, do it!
		
		$followed=$this->Profile_model->follow($this->profile_id,$to_follow_id);	
		
		if($followed)
			echo json_encode(array('status'=>'ok'));
		else 
			echo json_encode(array('status'=>'error','description'=>'Грешка при свързване със сървъра.'));
	}
	
	function unfollow($username='')
	{
		$this->r_nlogged_ajax();
		
		$this->load->model("Profile_model","",TRUE);
		
		if($username==$this->username) 
		{
			echo json_encode(array('status'=>'error','description'=>'Не можеш да спреш да следиш себе си.')); 
			exit;
		}
		
		$to_follow_id=$this->Profile_model->get_id_by_username($username);
		
		// if there is no such user, then exit
		if( ! $to_follow_id) 
		{
			echo json_encode(array('status'=>'error','description'=>'Няма такъв потребител.')); 
			exit;
		}
		
		// if you're not following this user, then exit
		if(!$this->Profile_model->is_following($this->profile_id,$to_follow_id)) 
		{
			echo json_encode(array('status'=>'error','description'=>'Ти не следиш този потребител.')); 
			exit;
		}
		
		// All checked, do it!
		
		$followed=$this->Profile_model->unfollow($this->profile_id,$to_follow_id);	
		
		if($followed)
			echo json_encode(array('status'=>'ok'));
		else 
			echo json_encode(array('status'=>'error','description'=>'Грешка при свързване със сървъра.'));
	}
	
	function comment()
	{
		$this->r_nlogged_ajax();
		
		$this->load->model("Profile_model","",TRUE);
		
		$rules=array(
			array('field'=>'comment_json','rules'=>'trim|required')
		);
		
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run())
		{
			$comment_array=json_decode($this->input->post("comment_json"),TRUE);
			if($comment_array)
			{	
				if(trim($comment_array["comment"])=="")
				{
					echo json_encode(array('status'=>'error','description'=>'Няма коментар.'));
					exit;
				}
			
				$comment_id=$this->Profile_model->add_comment($comment_array);
				
				$comment=$this->Profile_model->get_comment($comment_id);
				$comment_rich=$this->Profile_model->insert_mentioned_in_comment($comment_id,$comment->comment);
				
				$comment->comment=$comment_rich;
				
				$data["item"]=$comment;
				$content=$this->load->view('profile/r/ajax/comment',$data,TRUE);
				
				echo json_encode(array('status'=>'ok','content'=>$content));
			}
			else echo json_encode(array('status'=>'error','description'=>'Невалиден JSON.'));
		}
		else echo json_encode(array('status'=>'error','description'=>'Няма коментар.'));
	}
	
	function comment_autocomplete()
	{
		$this->load->model("Profile_model","",TRUE);

		$rules=array(
			array('field'=>'term','rules'=>'trim|required')
		);	
		
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run())
		{	
			$suggestions_array=array();
			$suggestions=$this->Profile_model->comment_suggestions($this->input->post("term"));

			foreach($suggestions->result() as $suggestion)
			{
				$suggestions_array[] = array(
					"id"=>$suggestion->id, 
					"name"=>$suggestion->name, 
					"type"=>$suggestion->type
				);
			}
			
			echo json_encode($suggestions_array);
		}
	}
	
	function geotag_autocomplete()
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


			echo $this->db->last_query();
			
			foreach($suggestions->result() as $suggestion)
			{
				$suggestions_array[] = array(
					"id"=>$suggestion->id, 
					"name"=>$suggestion->name, 
				);
			}
			
			echo json_encode($suggestions_array);
		}
	}
	
	function wall_comment()
	{
		$this->r_nlogged_ajax();
		
		$this->load->model("Profile_model","",TRUE);
		$rules=array(
			array('field'=>'ref_id','rules'=>'required|numeric'),
			array('field'=>'w_type','rules'=>'required|numeric|min_value[1]|max_value[2]'),
			array('field'=>'comment','rules'=>'trim|required')
		);
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run())
		{
			$comment=$this->input->post("comment");
			
			$this->Profile_model->wall_comment($this->input->post("ref_id"),$this->input->post("w_type"),$comment);
			$data['comment']=$comment;
			$content=$this->load->view('profile/r/ajax/wall_comment',$data,TRUE);
			echo json_encode(array('status'=>'ok','content'=>$content));
		}
		else echo json_encode(array('status'=>'error','description'=>'Невалидни данни'));		
	}
	
	function edit()
	{
		$this->r_nlogged();
		
		$this->load->model("Profile_model","",TRUE);
		
		$data['profile']=$this->no_html($this->Profile_model->get($this->profile_id));
		$this->load->view('profile/r/edit',$data);
	}
	
	function edit_info()
	{		
		$this->r_nlogged_ajax();
	
		$this->load->model("Profile_model","",TRUE);
		
		$rules=array(
			array('field'=>'name',			'rules'=>'trim|max_length[150]'),
			array('field'=>'sex_id',		'rules'=>'numeric|min_value[1]|max_value[2]'),
			array('field'=>'birth_day',		'rules'=>'numeric|min_value[1]|max_value[31]'),
			array('field'=>'birth_month',	'rules'=>'numeric|min_value[1]|max_value[12]'),
			array('field'=>'birth_year',	
			'rules'=>'numeric|min_value['.(date("Y")-80).']|max_value['.(date("Y")-5).']'),
			array('field'=>'description',	'rules'=>'trim|max_length[1000]'),
			array('field'=>'personal_site',	'rules'=>'trim|max_length[67]'),
			array('field'=>'facebook',		'rules'=>'trim|max_length[200]'),
			array('field'=>'twitter',		'rules'=>'trim|max_length[30]'),
		);	
		
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run())
		{
			$this->Profile_model->edit_info();
			echo json_encode(array('status'=>'ok'));
		}
		else echo json_encode(array('status'=>'error','description'=>'Невалидни данни'));
	}
	
	function edit_avatar()
	{
		$this->load->model("Profile_model","",TRUE);
		
		$url=$this->input->post("url");
		
		$config['upload_path'] = './avatars/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = TRUE;
		$config['max_size']	= '1000';
		$config['max_width']  = '2000';
		$config['max_height']  = '2000';
		
		$this->load->library('upload', $config);	
		if ($this->upload->do_upload("avatar"))
		{		
			$file=$this->upload->data();
		
			$this->_format_avatar($file);
			
			$this->Profile_model->set_avatar($file['file_ext']);
			
			
			redirect("profile/edit");
		}
		elseif(preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url)) //
		{
			echo $url;
			// if valid url
			$ch = curl_init("$url");
		
			curl_setopt ($ch, CURLOPT_HEADER, 1);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
			
			$result=explode("\r\n\r\n",curl_exec($ch));

			if( ! $result) exit;
			
			echo 'cd';
			
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
			echo 'ab';
			switch($content_type)
			{
				case 'image/jpeg':
					imagejpeg($newImg, './avatars/'.$this->profile_id.".jpg",100);
					break;
				case 'image/jpg':
					imagejpeg($newImg, './avatars/'.$this->profile_id.".jpg",100);
					break;
				case 'image/png':  
					imagesavealpha($newImg, true);
					imagepng($newImg, './avatars/'.$this->profile_id.".png",9); 
					break;
				case 'image/gif':
					imagegif($newImg, './avatars/'.$this->profile_id.".gif",100); 
					break;
				default: exit;
			}
			
			$this->_format_avatar();
			
		}
		else
		{
			redirect("profile/edit");
		}
	}
	
	function edit_avatar_url()
	{
		
	}
	
	function _format_avatar($avatar)
	{
		 $profile=$this->Profile_model->get($this->profile_id);
			
		 if($profile->avatar)
		 {
			  $size_20='./avatars/'.$this->profile_id.'_20'.$profile->avatar;
			  if(file_exists($size_20))
			  {
				  @unlink($size_20);
			  }
			  
			  $size_50='./avatars/'.$this->profile_id.'_50'.$profile->avatar;
			  if(file_exists($size_50))
			  {
				  @unlink($size_50);
			  }
			  
			  $size_150='./avatars/'.$this->profile_id.'_150'.$profile->avatar;
			  if(file_exists($size_150))
			  {
				  @unlink($size_150);
			  }
			  
			  $size_200='./avatars/'.$this->profile_id.'_200'.$profile->avatar;
			  if(file_exists($size_200))
			  {
				  @unlink($size_200);
			  }
		  }
		  
		  $this->load->library('Square_image');
		  $this->square_image->square($avatar['full_path']);
		  
		  $this->square_image->resize($avatar['full_path'], 20, 20,
		  $avatar['file_path'].$this->profile_id."_20".$avatar['file_ext']);
		  
		  $this->square_image->resize($avatar['full_path'], 50, 50,
		  $avatar['file_path'].$this->profile_id."_50".$avatar['file_ext']);
		  
		  $this->square_image->resize($avatar['full_path'], 150, 150,
		  $avatar['file_path'].$this->profile_id."_150".$avatar['file_ext']);
		  
		  $this->square_image->resize($avatar['full_path'], 200, 200,
		  $avatar['file_path'].$this->profile_id."_200".$avatar['file_ext']);
		  
		  $this->square_image->delete($avatar['full_path']);	
	}
	
	function delete_avatar()
	{
		$this->load->model("Profile_model","",TRUE);
		$profile=$this->Profile_model->get($this->profile_id);
			
		if($profile->avatar)
		{
			$size_20='./avatars/'.$this->profile_id.'_20'.$profile->avatar;
			if(file_exists($size_20))
			{
				@unlink($size_20);
			}
			
			$size_50='./avatars/'.$this->profile_id.'_50'.$profile->avatar;
			if(file_exists($size_50))
			{
				@unlink($size_50);
			}
			
			$size_150='./avatars/'.$this->profile_id.'_150'.$profile->avatar;
			if(file_exists($size_150))
			{
				@unlink($size_150);
			}
			
			$size_200='./avatars/'.$this->profile_id.'_200'.$profile->avatar;
			if(file_exists($size_200))
			{
				@unlink($size_200);
			}
			
			$this->Profile_model->set_no_avatar();
		}
		
		redirect("profile/edit");
	}
	
	function edit_is_new_email_free()
	{
		$this->r_nlogged_ajax();
		
		$this->load->model("Profile_model","",TRUE);
		
		$rules=array(array('field'=>'email','rules'=>'trim|required|valid_email'));
		
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run())
		{
			if($this->Profile_model->is_new_email_free($this->input->post("email")))
			{
				echo json_encode(array('status'=>'ok'));	
			}
			else 
			{
				echo json_encode(array('status'=>'error','description'=>'Вече има регистрация с този email.'));
			}
		}
		else echo json_encode(array('status'=>'error','description'=>'Грешка при свързване със сървъра.'));
	}
	
	function edit_account_password()
	{
		$this->r_nlogged_ajax();
		
		$this->load->model("Profile_model","",TRUE);
		
		$rules=array(
		array('field'=>'old_password',  'rules'=>'min_length[6]|max_length[50]'),
		array('field'=>'password',		'rules'=>'min_length[6]|max_length[50]'),
		array('field'=>'password_r',	'rules'=>'min_length[6]|max_length[50]|matches[password]')
		);
		
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run())
		{
			$profile=$this->Profile_model->get($this->profile_id);
			
			if($profile->password!=md5($this->input->post('old_password')))
			{
				echo json_encode(array('status'=>'error','description'=>'Старата парола не е вярна.'));
				exit;
			}
			else
			{
				// change password	
				$this->Profile_model->edit_account_password();
				echo json_encode(array('status'=>'ok'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'error','description'=>'Грешка при свързване със сървъра.'));
		}
	}
	
	function edit_account_email()
	{
		$this->r_nlogged_ajax();
		
		$this->load->model("Profile_model","",TRUE);
		
		$rules=array(
			array('field'=>'email',	'rules'=>'trim|required|valid_email'),
		);
		
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run())
		{
			
			$profile=$this->Profile_model->get($this->profile_id);
			
			// is the new email free
			if( ! $this->Profile_model->is_new_email_free($this->input->post("email")))
			{
				echo json_encode(array('status'=>'error','description'=>'Вече има регистрация с този email.'));
				exit;
			}
			else
			{	// change account email
				$this->Profile_model->edit_account_email();	
				echo json_encode(array('status'=>'ok'));
			}
		}
		else
		{
			echo json_encode(array('status'=>'error','description'=>'Грешка при свързване със сървъра.'));
		}
	}
	
	function followers($username='')
	{
		$this->load->model("Profile_model","",TRUE);
		
		// If user is logged.
		if($username==''&&$this->username!='') $username=$this->username; 
		
		if( ! $username) redirect(""); // If user is not logged and no username is specified, then exit.
		
		$profile=$this->Profile_model->get_by_username($username);
		if(!$profile) // If no user with that username is found, then exit.
		{
			redirect(""); 
		}
		
		$from=intval($this->uri->segment(3,0));
		$limit=1;
		
		$config['base_url'] = "followers/$username/";
		$config['total_rows'] = $this->Profile_model->get_followers_count($profile->id);
		$config['per_page'] = $limit;		
		$config['uri_segment'] = 3;
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
		
		$data["followers"]=$this->Profile_model->get_followers($profile->id,$from,$limit);
		$this->load->view('profile/followers',$data);
	}
	
	function followed($username='')
	{
		$this->load->model("Profile_model","",TRUE);
		
		// If user is logged.
		if($username==''&&$this->username!='') $username=$this->username; 
		
		if( ! $username) redirect(""); // If user is not logged and no username is specified, then exit.
		
		$profile=$this->Profile_model->get_by_username($username);
		if(!$profile) // If no user with that username is found, then exit.
		{
			redirect(""); 
		}
		
		$from=intval($this->uri->segment(3,0));
		$limit=1;
		
		$config['base_url'] = "followed/$username/";
		$config['total_rows'] = $this->Profile_model->get_followed_count($profile->id);
		$config['per_page'] = $limit;		
		$config['uri_segment'] = 3;
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
		
		$data["followed"]=$this->Profile_model->get_followed($profile->id,$from,$limit);
		$this->load->view('profile/followed',$data);
	}	
	
	function profile_city_sugg()
	{		
		$this->load->model("Profile_model","",TRUE);
		
		$rules=array(
			array('field'=>'city','rules'=>'trim|required|max_length[250]'),
		);
		
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run())
		{		
			$cities_list=$this->Profile_model->get_cities_autocomplete_list($this->input->post("city"));	
			$cities_json=array();		
			foreach($cities_list->result() as $city) $cities_json[]=array('name'=>$city->name);
		
			echo json_encode(array('status'=>'ok','cities'=>$cities_json));
		}
		else echo json_encode(array('status'=>'error','description'=>'Грешка при свързване със сървъра.'));
	}
	
	function favorite_place_add()
	{
		$this->r_nlogged_ajax();
		
		$this->load->model("Profile_model","",TRUE);
		$this->load->model("Place_model","",TRUE);
		
		$rules=array(
			array('field'=>'place_id',           	'rules'=>'required|numeric'),
			array('field'=>'category_id',        	'rules'=>'numeric')
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{
			$place_id=$this->input->post("place_id");
			if( ! $this->Profile_model->is_place_favorite($place_id))
			{					
				if( ! $this->input->post("category_id")) $category_id=0;
				
				$this->Profile_model->favorite_place_add($place_id ,$category_id);
				$favorites_count=$this->Place_model->get_favorites_count($place_id);
				
				echo json_encode(array('status'=>'ok','favorites_count'=>$favorites_count));
			}
			else echo json_encode(array('status'=>'error','description'=>'Това място вече е добавено в любимите ви.'));
		}
		else echo json_encode(array('status'=>'error','description'=>'Грешка при свързване със сървъра.'));		
	}
	
	function favorite_place_remove()
	{
		$this->r_nlogged_ajax();
		
		$this->load->model("Profile_model","",TRUE);
		$this->load->model("Place_model","",TRUE);
		
		$rules=array(
			array('field'=>'place_id','rules'=>'required|numeric')
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run())
		{
			$place_id=$this->input->post("place_id");
			if($this->Profile_model->is_place_favorite($place_id))
			{									
				$this->Profile_model->favorite_place_remove($place_id);
				$favorites_count=$this->Place_model->get_favorites_count($place_id);
				
				echo json_encode(array('status'=>'ok','favorites_count'=>$favorites_count));
			}
			else echo json_encode(array('status'=>'error','description'=>'Това място вече е изтрито от  любимите ви.'));
		}
		else echo json_encode(array('status'=>'error','description'=>'Грешка при свързване със сървъра.'));		
	}
	
	function favorite_places($username='')
	{
		$this->load->model("Profile_model","",TRUE);
		// If user is logged.
		
		if($username==''&&$this->username!='') $username=$this->username; 
		
		if( ! $username) redirect(""); // If user is not logged and no username is specified, then exit.
		
		$profile=$this->Profile_model->get_by_username($username);
		if( ! $profile) // If no user with that username is found, then exit.
		{
			redirect(""); 
		}
		
		$data["places"]=$this->Profile_model->get_favorite_places_by_category($profile->id,0);
		
		$this->load->view("profile/favorites",$data);
	}
}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */