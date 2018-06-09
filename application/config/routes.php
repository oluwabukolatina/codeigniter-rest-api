<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['post/add']['post'] = "api/postController/create";
$route['login-user']['post'] = "api/userController/userlogin";
$route['post/update/(:any)']['post'] = 'api/postController/edit/$1';
$route['user/update/(:any)']['put'] = 'api/userController/edit/$1';
$route['post/(:any)']['get'] = 'api/postController/view/$1';
$route['user/(:any)']['get'] = 'api/userController/view/$1';
$route['post/delete/(:any)']['post'] = 'api/postController/destroy/$1';
$route['user/delete/(:any)'] = 'api/userController/destroy/$1';
$route['posts']['get'] = 'api/postController/index';
$route['users']['get'] = 'api/userController/user';
$route['register']['post'] = 'api/authController/register';
$route['login']['post'] = 'api/authController/login';
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
// $route['tina'] = 'welcome';
// $route["hello"] = "api/postController/index";
// $route['posts/name'] = "api/postController/name";
