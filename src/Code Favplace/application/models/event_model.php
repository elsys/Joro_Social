<?php
class Event_model extends MY_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function exists($event_id)
	{
		$query=$this->db->query("SELECT count(*) AS cnt FROM events WHERE id=?",
		array($event_id));
		
		return $query->row()->cnt;
	}
	
	function get_place_events($place_id)
	{
		$query=$this->db->query("SELECT *,
		(SELECT username FROM profiles WHERE id=profile_id) AS creator
		FROM events WHERE place_id=?",array($place_id));
		
		return $query;
	}
	
	function get($event_id,$escape=FALSE)
	{
		$query=$this->db->query("SELECT *,
		(SELECT username FROM profiles WHERE id=profile_id) AS creator
		FROM events WHERE id=?",array($event_id));
		
		$row=$query->row();
	
		if($escape) return $this->remove_html($row);
		else return $row;
	}
	
	function add($picture)
	{
		if($this->input->post("date_end"))
		{
			$end_date=$this->input->post("date_end").' '.$this->input->post("hour_end").':00:00';
		}
		else $end_date="";
		
		$this->db->query("INSERT INTO events 
		(profile_id,place_id,name,date_start,date_end,description,visible,picture,date) 
		VALUES(?,?,?,?,?,?,?,?,now())",
		array($this->profile_id, $this->input->post("place_id"), $this->input->post("name"),
		$this->input->post("date_start").' '.$this->input->post("hour_start").':00:00',
		$end_date, $this->input->post("description"),$this->input->post("visible"),$picture));
		
		return $this->db->insert_id();
	}
	
	function edit($event_id,$picture)
	{
		if($this->input->post("date_end"))
		{
			$end_date=$this->input->post("date_end").' '.$this->input->post("hour_end").':00:00';
		}
		else $end_date="";
		
		$this->db->query("UPDATE events SET
		place_id=?, name=?, date_start=?, date_end=?, description=?, visible=?, picture=? WHERE id=?",
		array($this->input->post("place_id"), $this->input->post("name"),
		$this->input->post("date_start").' '.$this->input->post("hour_start").':00:00',
		$end_date, $this->input->post("description"),$this->input->post("visible"),$picture,$event_id));
	}
	
	function delete_main_picture($event_id)
	{
		$this->db->query("UPDATE events SET picture='' WHERE id=?",
		array($event_id));
	}
	
	function will_go($profile_id,$event_id)
	{
		$this->db->query("INSERT INTO event_visits (event_id,profile_id,date) VALUES(?,?,now())",
		array($event_id, $profile_id));	
	}
	
	function said_will_go($profile_id,$event_id)
	{
		$query=$this->db->query("SELECT count(*) AS cnt FROM event_visits WHERE event_id=? AND profile_id=?",
		array($event_id, $profile_id));	
		
		if($query->row()->cnt) return TRUE;
		else return FALSE;
	}
}
