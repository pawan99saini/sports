<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['admin/dashboard-content'] = 'admin/dashboardContent';
$route['about-us'] = 'home/about_us';

$route['my-account'] = 'home/my_account';
$route['profile'] = 'home/profile';
$route['profile/(:any)'] = 'home/profile/$1';
$route['team'] = 'home/team';
$route['team/(:any)'] = 'home/team/$1';
$route['team/(:any)/(:any)'] = 'home/team/$1/$2';
$route['team/(:any)/(:any)/(:any)'] = 'home/team/$1/$2/$3';
$route['team/(:any)/(:any)/(:any)/(:any)'] = 'home/team/$1/$2/$3/$4';
$route['players'] = 'home/our_players';
$route['login'] 	 = 'home/login';
$route['register'] 	 = 'home/register';
$route['register/(:any)'] 	 = 'home/register/$1';
$route['register/(:any)/(:any)'] 	 = 'home/register/$1/$2';
$route['forget-password'] = 'home/reset_password';
$route['reset-password'] = 'home/resetPassword';
$route['reset-password/(:any)'] = 'home/resetPassword/$1';
$route['videos'] 	 = 'home/videos';
$route['videos/(:any)'] = 'home/videos/$1';
$route['videos/(:any)/(:any)'] = 'home/videos/$1/$2';
$route['pricing'] = 'home/pricing';
$route['pricing/(:any)'] = 'home/pricing/$1';
$route['pricing/(:any)/(:any)'] = 'home/pricing/$1/$2';
$route['buy-credits'] = 'account/buy_credits';
$route['spectator'] = 'home/spectator';
$route['spectator/(:any)'] = 'home/spectator/$1';
$route['spectator/(:any)/(:any)']= 'home/spectator/$1/$2';
$route['tournaments'] = 'home/tournaments';
$route['tournaments/(:any)'] = 'home/tournaments/$1';
$route['tournaments/(:any)/(:any)'] = 'home/tournaments/$1/$2';
$route['tournaments/(:any)/(:any)/(:any)'] = 'home/tournaments/$1/$2/$3';
$route['tournaments/(:any)/(:any)/(:any)/(:any)'] = 'home/tournaments/$1/$2/$3/$4';
$route['admin/spectator-requests'] = 'admin/spectator_request';
$route['admin/spectator-requests/(:any)'] = 'admin/spectator_request/$1';
$route['admin/spectator-requests/(:any)/(:any)'] = 'admin/spectator_request/$1/$2';
$route['job-listing'] = 'admin/job_listing';
$route['job-listing/(:any)'] = 'admin/job_listing/$1';
$route['job-listing/(:any)/(:any)'] = 'admin/job_listing/$1/$2';
$route['admin/valorant-recruitment'] 		= 'admin/valorant_recruitment';
$route['admin/valorant-recruitment/(:any)'] = 'admin/valorant_recruitment/$1';
$route['admin/valorant-recruitment/(:any)/(:any)'] = 'admin/valorant_recruitment/$1/$2';
$route['admin/time-off'] 		= 'admin/leaves';
$route['admin/time-off/(:any)'] = 'admin/leaves/$1';
$route['member/spectator-requests'] = 'member/spectator_request';
$route['member/spectator-requests/(:any)'] = 'member/spectator_request/$1';
$route['member/spectator-requests/(:any)/(:any)'] = 'member/spectator_request/$1/$2';
$route['member/time-off'] 		= 'member/leaves';
$route['member/time-off/(:any)'] = 'member/leaves/$1';
$route['member/submit-work'] = 'member/submit_work/';
$route['member/submit-work/(:any)'] = 'member/submit_work/$1';
$route['careers'] 				= 'home/careers';
$route['careers/(:any)'] 		= 'home/careers/$1';
$route['careers/(:any)/(:any)'] = 'home/careers/$1/$2';
$route['team-recruitment'] 				= 'home/team_recruitment';
$route['team-recruitment/(:any)'] 		= 'home/team_recruitment/$1';
$route['team-recruitment/(:any)/(:any)'] = 'home/team_recruitment/$1/$2';
$route['valorant-recruitment'] 				= 'home/valorant_recruitment';
$route['team-recruitment'] 				= 'home/team_recruitment';
$route['team-recruitment/(:any)'] 				= 'home/team_recruitment/$1';
$route['support'] 				= 'home/support';
$route['support/(:any)'] 		= 'home/support/$1';
$route['support/(:any)/(:any)'] = 'home/support/$1/$2';
$route['community'] 				= 'home/community';
$route['live'] 		= 'home/live';
$route['checkout'] 		= 'home/checkout';
$route['thankyou'] 		= 'home/thankyou';
$route['thankyou/(:any)'] 		= 'home/thankyou/$1';
$route['thankyou/(:any)/(:any)'] 		= 'home/thankyou/$1/$2';
$route['dso-members'] 		= 'home/dso_members';
$route['dso-members/(:any)'] 		= 'home/dso_members/$1';
$route['dso-members/(:any)/(:any)'] 		= 'home/dso_members/$1/$2';
$route['account/spectate-tournament'] 		= 'account/spectate_tournament';
$route['account/spectate-tournament/(:any)'] 		= 'account/spectate_tournament/$1';
$route['account/spectate-tournament/(:any)/(:any)'] 		= 'account/spectate_tournament/$1/$2';
$route['account/spectate-tournament/(:any)/(:any)/(:any)'] 		= 'account/spectate_tournament/$1/$2/$3';

$route['404_override'] = 'notfound404';
$route['translate_uri_dashes'] = FALSE;
