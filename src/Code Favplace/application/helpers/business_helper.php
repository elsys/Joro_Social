<?php
define("BUSINESS_PATH","etcr/owners/");

// Business features
function get_customize_tools()
{
	$ci =& get_instance();

	$ci->load->view(BUSINESS_PATH."customize_tools");
} 