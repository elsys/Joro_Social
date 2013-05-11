<?php

class MY_Model extends CI_Model{
		
	function __construct($control=0)
	{
		parent::__construct();
	}
	
	function remove_html($obj)
	{
		if(is_string($obj))
		{
			 return stripslashes(htmlspecialchars($obj));
		}
		elseif(get_class($obj)=="CI_DB_mysql_result")
		{
			$obj_n->result=$obj->result();
			$obj_n->num_rows=$obj->num_rows();
			
			foreach($obj_n->result as $row)
			{
				foreach($row as $key=>$value) $row->$key=stripslashes(htmlspecialchars($value));	
			}
			
			return $obj_n;
		}
		elseif(is_object($obj))
		{		
			foreach($obj as $key=>$value) $obj->$key=stripslashes(htmlspecialchars($value));
			return $obj;
		}		
	}
	
}