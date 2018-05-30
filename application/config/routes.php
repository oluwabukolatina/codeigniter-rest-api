<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['post/add']['post'] = "api/postController/create";
$route['post/update/(:any)'] = 'api/postController/edit/$1';
$route['post/(:any)']['get'] = 'api/postController/view/$1';
$route['post/delete/(:any)'] = 'api/postController/destroy/$1';
$route['posts']['get'] = 'api/postController/index';
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
// $route['tina'] = 'welcome';
// $route["hello"] = "api/postController/index";
// $route['posts/name'] = "api/postController/name";
