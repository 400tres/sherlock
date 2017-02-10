<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'welcome/login';
$route['signup'] = 'welcome/signup';
$route['provider-signup'] = 'welcome/provider_signup';

$route['about'] = 'home/about';
$route['user'] = 'home/edit';

$route['my/fingerprint'] = 'user/fingerprint';
$route['my/site'] = 'provider/my_site';

$route['authentication'] = 'sherlock/auth';

$route['get_user_profile'] = 'sherlock/send_user_profile';
