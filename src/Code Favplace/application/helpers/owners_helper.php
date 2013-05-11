<?php
define("OWNER_PATH","etcr/owners/");

// Owners (free/basic) features


// Business features
function get_customize_tools()
{
	$ci =& get_instance();

	$ci->load->view(OWNER_PATH."customize_tools");
} 