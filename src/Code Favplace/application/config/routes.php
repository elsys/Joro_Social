<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "welcome";
$route['404_override'] = '';


$route['profile/edit/account_email']="profile/edit_account_email";
$route['profile/edit/account_password']="profile/edit_account_password";
$route['profile/edit/is_new_email_free']="profile/edit_is_new_email_free";
$route['profile/delete/avatar']="profile/delete_avatar";
$route['profile/edit/avatar']="profile/edit_avatar";
$route['profile/edit/info']="profile/edit_info";
$route['profile/edit']="profile/edit";

$route['followers/(:any)/(:num)']="profile/followers/$1/$2";
$route['followers/(:any)']="profile/followers/$1";
$route['followed/(:any)/(:num)']="profile/followed/$1/$2";
$route['followed/(:any)']="profile/followed/$1";

$route['profile/ajax_wall/(:num)/(:num)']='profile/ajax_wall/$1/$2';
$route['profile/wall/comment']="profile/wall_comment";
$route['profile/comment']="profile/comment";
$route['profile/comment/autocomplete']="profile/comment_autocomplete";
$route['profile/geotag/autocomplete']="profile/geotag_autocomplete";
$route['profile/profile_city_sugg']="profile/profile_city_sugg";
$route['profile/unfollow/(:any)']="profile/unfollow/$1";
$route['profile/follow/(:any)']="profile/follow/$1";
$route['profile/favorite_places/(:any)']="profile/favorite_places/$1";
$route['profile/favorite_place/add']="profile/favorite_place_add";
$route['profile/favorite_place/remove']="profile/favorite_place_remove";
$route['profile'] = "profile/index";
$route['profile/(:any)'] = "profile/index/$1";

$route['place/gallery/ajax_image/(:num)/(:num)']="place/gallery_ajax_image/$1/$2";
$route['place/(:num)/(:any)']="place/index/$1";
$route['place/add']="place/add";
$route['place/add/ajax']="place/add_ajax";
$route['place/add/pictures/(:any)/(:num)']="place/add_pictures/$1/$2";
$route['place/edit/(:num)']="place/edit/$1";

$route['business/request/(:num)']="business/request/$1";
$route['business/menu/edit/(:num)']="business/menu_edit/$1";
$route['business/customization/(:num)']="business/customization/$1";
$route['business/place_edit/(:num)']="business/place_edit/$1";


$route['event/place/autocomplete']="event/place_autocomplete";
$route['event/add/(:num)']="event/add/$1";
$route['event/edit/(:num)']="event/edit/$1";
$route['event/will_go']="event/will_go";
$route['event/delete_main_picture/(:num)']="event/delete_main_picture/$1";
$route['event/add']="event/add";
$route['event/(:num)/(:any)']="event/index/$1";
$route['event/index']="event/index";

$route['signin']='signin';
$route['signup']='signup';
$route['signup/confirm/(:num)/(:any)']='signup/confirm/$1/$2';
$route['forgotten']='signin/forgotten';
$route['signout']='signout';

$route['search/places']='search/places';
$route['search/places/(:any)']='search/places/$1';
$route['search/places/(:any)/(:num)']='search/places/$1/$2';

$route['signup/is_username_free']='signup/is_username_free';
$route['signup/is_email_free']='signup/is_email_free/';

$route['search/places_sugg']='search/places_sugg';

$route['welcome/ajax_wall/(:num)']='welcome/ajax_wall/$1';

$route["(:any)"]="profile/index/$1";



/* End of file routes.php */
/* Location: ./application/config/routes.php */