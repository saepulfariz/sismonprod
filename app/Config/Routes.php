<?php

use CodeIgniter\Router\RouteCollection;


$routes->set404Override(function () {
  if (setting('activity_error') == '1') {
    $request = \Config\Services::request();
    model('App\Models\ActivityLogModel')->add("Not Found Url : " . base_url($request->uri->getPath()) . " By user #");
  }
  $data = [
    'title' => '404 Not Found',
    'back' => urlBack()
  ];
  return view('admin/template/404', $data);
});
/**
 * @var RouteCollection $routes
 */

$routes->get('/', '\App\Controllers\Auth::index');
$routes->get('/site.webmanifest', function () {

  $settings = setting_all();

  // $favicon = 'public/uploads/apps/' . $settings['app_favicon'];
  // $favicon_info = getimagesize($favicon);
  $image = 'public/uploads/apps/' . $settings['app_image'];
  $image_info = getimagesize($image);

  $data = [
    'name' => $settings['app_name'],
    'short_name' => $settings['app_name'],
    'start_url' => base_url(),
    'orientation' => 'portrait-primary',
    'theme_color' => '#1f2424',
    'background_color' => '#1f2424',
    'display' => 'standalone',
    'icons' => [
      [
        'src' => base_url() . $image,
        'sizes' => $image_info[0] . 'x' . $image_info[1],
        'type' => $image_info['mime'],
      ],
    ]
  ];
  echo json_encode($data);
});

$routes->get('/errors', '\App\Controllers\Errors::index');
$routes->get('/errors/denied', '\App\Controllers\Errors::denied');

$routes->get('/ajax-email', '\App\Controllers\Auth::ajaxEmail');
$routes->get('/ajax-username', '\App\Controllers\Auth::ajaxUsername');

$routes->get('/login', '\App\Controllers\Auth::index');
$routes->post('/auth/verify', '\App\Controllers\Auth::verify');

$routes->get('/register', '\App\Controllers\Auth::register');
$routes->post('/register', '\App\Controllers\Auth::registered');

$routes->get('/forgot-password', '\App\Controllers\Auth::forgotPassword');
$routes->post('/forgot-password', '\App\Controllers\Auth::actionForgotPassword');

$routes->get('/change-password', '\App\Controllers\Auth::changePassword');
$routes->post('/change-password', '\App\Controllers\Auth::updateChangePassword');

$routes->get('/logout', '\App\Controllers\Auth::logout');

$routes->get('/dashboard', '\App\Controllers\Dashboard::index', []);
$routes->get('/backup', '\App\Controllers\Backup::index');
$routes->get('/backup/exportDB', '\App\Controllers\Backup::exportDB');

$routes->get('/activitylogs', '\App\Controllers\ActivityLogs::index');
$routes->get('/activitylogs/(:any)', '\App\Controllers\ActivityLogs::show/$1');

$routes->resource('permissions', ['controller' => '\App\Controllers\Permissions']);
$routes->resource('roles', ['controller' => '\App\Controllers\Roles']);

$routes->get('/users/change_status/(:any)', '\App\Controllers\Users::change_status/$1', []);
$routes->resource('users', ['controller' => '\App\Controllers\Users',]);

$routes->put('profile/update', '\App\Controllers\Profile::updateProfile', []);
$routes->put('profile/updatePassword', '\App\Controllers\Profile::updatePassword', []);
$routes->put('profile/updatePicture', '\App\Controllers\Profile::updateProfilePic', []);
$routes->get('profile', '\App\Controllers\Profile::index', []);
$routes->get('profile/edit', '\App\Controllers\Profile::index/edit', []);
$routes->get('profile/change_password', '\App\Controllers\Profile::index/change_password', []);
$routes->get('profile/change_picture', '\App\Controllers\Profile::index/change_picture', []);

$routes->get('/settings', '\App\Controllers\Settings::general');
$routes->get('/settings/general', '\App\Controllers\Settings::general');
$routes->get('/settings/company', '\App\Controllers\Settings::company');
$routes->put('/settings/general', '\App\Controllers\Settings::generalUpdate');
$routes->put('/settings/company', '\App\Controllers\Settings::companyUpdate');

$routes->group('settings/email_templates', function ($routes) {
  $routes->group('send', function ($routes) {
    $routes->get('active/(:any)/(:any)', '\App\Controllers\EmailTemplateSend::active/$1/$2');
    $routes->get('(:any)/new', '\App\Controllers\EmailTemplateSend::new/$1');
    $routes->get('(:any)/edit', '\App\Controllers\EmailTemplateSend::edit/$1');
    $routes->get('(:any)', '\App\Controllers\EmailTemplateSend::index/$1');
    $routes->post('(:any)', '\App\Controllers\EmailTemplateSend::create/$1');
    $routes->put('(:any)', '\App\Controllers\EmailTemplateSend::update/$1');
    $routes->delete('(:any)', '\App\Controllers\EmailTemplateSend::delete/$1');
  });

  $routes->group('variables', function ($routes) {
    $routes->get('(:any)/new', '\App\Controllers\EmailTemplateVariables::new/$1');
    $routes->get('(:any)/edit', '\App\Controllers\EmailTemplateVariables::edit/$1');
    $routes->get('(:any)', '\App\Controllers\EmailTemplateVariables::index/$1');
    $routes->post('(:any)', '\App\Controllers\EmailTemplateVariables::create/$1');
    $routes->put('(:any)', '\App\Controllers\EmailTemplateVariables::update/$1');
    $routes->delete('(:any)', '\App\Controllers\EmailTemplateVariables::delete/$1');
  });
});
$routes->resource('settings/email_templates', ['controller' => '\App\Controllers\EmailTemplates',]);

$routes->post('planned_materials/import', '\App\Controllers\PlannedMaterials::import');
$routes->get('planned_materials/ajax_ipcode', '\App\Controllers\PlannedMaterials::ajaxIpCode');
$routes->resource('planned_materials', ['controller' => '\App\Controllers\PlannedMaterials']);

$routes->resource('departments', ['controller' => '\App\Controllers\Departments']);
