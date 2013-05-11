<?php

function profile_link($username)
{
	return $username;	
}



function profile_avatar($profile_id,$size=20)
{
	$ci =& get_instance();

	// if user uploaded avatar in favplace
	if(isset($ci->profileAvatars["$profile_id"])) $profile=$ci->profileAvatars["$profile_id"];
	else
	{
		$profile=$ci->db->query("SELECT avatar, email FROM profiles WHERE id=?",array($profile_id))->row();
		$ci->profileAvatars["$profile_id"]=$profile;
	}
	
	if($profile->avatar) return 'avatars/'.$profile_id."_$size".$profile->avatar;
	else // if not, then try finding gravatar
	{
		return get_gravatar($profile->email,$size);
	}
	
}

function get_gravatar( $email, $s = 20, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5( strtolower( trim( $email ) ) );
	$url .= "?s=$s&d=$d&r=$r";
	if ( $img ) {
		$url = '<img src="' . $url . '"';
		foreach ( $atts as $key => $val )
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}


function wall_date($date_diff,$date)
{
  $date_diff=explode(":",$date_diff);
  $date_diff[0]=intval($date_diff[0]);
  $date_diff[1]=intval($date_diff[1]);  
  $date_diff[2]=intval($date_diff[2]);  
  
  if($date_diff[0]>72) return date("d.m.Y" ,strtotime($date));
  else
  {
	  if($date_diff[0]>48 and $date_diff[0]<72) $date_str='преди 2 дни';
	  elseif($date_diff[0]>24 and $date_diff[0]<48) $date_str='преди 1 ден';
	  elseif($date_diff[0]>0  and $date_diff[0]<24)
	  {
		   if($date_diff[0]==1) $date_str="преди 1 час";
		   else $date_str="преди $date_diff[0] часа";
	  }
	  elseif($date_diff[0]===0 and $date_diff[1]>0)
	  {
		  if($date_diff[1]==1) $date_str="преди 1 минута";
		  else $date_str="преди $date_diff[1] минути";
	  }
	  else
	  {		
		  if($date_diff[2]==1) $date_str="преди 1 секундa";
		  else $date_str="преди $date_diff[2] секунди";
	  }
	  
	  return '<a title="'.date("H:i, d.m.Y",strtotime($date)).'" class="post-date">'.$date_str.'</a>';
  }
}

function set_checked($val,$val_2)
{
	if($val==$val_2) return 'checked="checked"';
}

function set_selected($val,$val_2)
{
	if($val==$val_2) return 'selected="selected"';
}

function wall_picture($file_name,$size=50)
{
	/*$file_name='./pictures/'.$file_name;
	
 	$this->load->library('Square_image');
	
	$this->square_image->square($file_name);	
	
	 $this->square_image->resize($file_name, $size, $size);*/
}