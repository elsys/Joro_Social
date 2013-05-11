<?php
define("N_REG_PATH","etc/");
define("REG_PATH","etcr/");

function get_header()
{
	$ci =& get_instance();
	
	$ci->load->model("Place_model","",TRUE);
	
	$ci->load->model("Business_model","",TRUE);

	$data['h_search_categories']=$ci->Place_model->get_categories_list();
	$data['h_search_subcategories']=$ci->Place_model->get_subcategories_list();
	$data['h_search_tags']=$ci->Place_model->get_all_visible_tags();
	if($ci->user_logged) 
	{
		$data['business_places']=$ci->Business_model->get_all_business_places();
	}
	
	$ci->load->view(N_REG_PATH."header",$data);
}

function get_footer()
{
	$ci =& get_instance();

	$ci->load->view(N_REG_PATH."footer");
}

function get_rglobal_nav()
{	
	$ci =& get_instance();

	$ci->load->view(REG_PATH."global_nav");
}

function get_popular_box()
{	
	$ci =& get_instance();

	$ci->load->view(REG_PATH."popular_box");
}

function get_near_users()
{	
	$ci =& get_instance();

	$ci->load->model("Profile_model","",TRUE);
	$data['near_users']=$ci->Profile_model->get_near_users();
	
	if($data['near_users'] && $data['near_users']->num_rows > 0)
	{
		$ci->load->view(REG_PATH."near_users",$data);
	}
}

function get_tour_widget()
{	
	$ci =& get_instance();

	$ci->load->view(REG_PATH."tour_widget");
}

function get_user_helper()
{	
	$ci =& get_instance();

	$ci->load->view(REG_PATH."user_helper");
}

function event_thumb($event)
{
	if($event->picture)
	{
		$picture_ext=explode(".",$event->picture);
		return "pictures/".$event->id."_event_thumb.".$picture_ext[1];		
	}
}

function event_info_date($date)
{
	$date=strtotime($date);
	
	$month_num=intval(date("n",$date));
	switch($month_num)
	{
		case 1:  $month='януари'; break;
		case 2:  $month='февруари'; break;
		case 3:  $month='март'; break;
		case 4:  $month='април'; break;
		case 5:  $month='май'; break;
		case 6:  $month='юни'; break;
		case 7:  $month='юли'; break;
		case 8:  $month='август'; break;
		case 9:  $month='септември'; break;
		case 10: $month='октомври'; break;
		case 11: $month='ноември'; break;
		case 12: $month='декември'; break;
		default: return;
	}
	
	$day_en=date("l",$date);
	switch($day_en)
	{
		case 'Monday':    $day='Понеделник'; break;
		case 'Tuesday':   $day='Вторник'; break;
		case 'Wednesday': $day='Сряда'; break;
		case 'Thursday':  $day='Четвъртък'; break;
		case 'Friday':    $day='Петък'; break;
		case 'Saturday':  $day='Събота'; break;
		case 'Sunday':    $day='Неделя'; break;
		default: return;
	}
	
	return date("j $month Y, $day",$date);
}

function event_info_time($date)
{
	return date("H:00",strtotime($date));
}

function event_info_date_exists($date)
{
	return $date!=='0000-00-00 00:00:00';
}

function event_info_visibility($visible)
{
	switch(intval($visible))
	{
		case 1:  $text='Публично'; break;
		case 2:  $text='Само за приятели'; break;
		default: $text='';
	}
	
	return $text;
}

function event_link($event)
{
	return 'event/'.$event->id.'/'.url_title($event->name);
}