<?php
defined('BASEPATH') or exit('No direct script access allowed');
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['incoming/ecertin']['GET'] = 'incoming/ecertin';
$route['incoming/ephytoin']['GET'] = 'incoming/ephytoin';
$route['outgoing/ecertout']['GET'] = 'outgoing/ecertout';
$route['outgoing/ephytoout']['GET'] = 'outgoing/ephytoout';
$route['dashboard/stats']['GET'] = 'dashboard/stats';
$route['dashboard/tabledata']['GET'] = 'dashboard/tabledata';
$route['dashboard/monthly']['GET'] = 'dashboard/monthly';
$route['countryset']['POST'] = 'countryset/index';
$route['countryset']['GET'] = 'countryset/index';
