<?php

function place_picture($picture,$width,$height)
{
	$name=$picture->name;
	$ext=$picture->ext;
	return 'pictures/'.$name.'_'.$width.'_'.$height.$ext;
}