<?php

namespace App\Controllers;


use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;



/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class AdminBaseController extends Controller
{
  /**
   * Instance of the main Request object.
   *
   * @var CLIRequest|IncomingRequest
   */
  protected $request;

  /**
   * An array of helpers to be loaded automatically upon
   * class instantiation. These helpers will be available
   * to all other controllers that extend BaseController.
   *
   * @var array
   */
  protected $helpers = [
    'basic',
    'form',
    'url',
    'cookie',
  ];

  public $title = 'AdminPro';
  public $menu = 'dashboard';
  public $link = 'dashboard';
  public $submenu = '';
  public $model;
  public $data = [];
  public $settings;

  /**
   * Be sure to declare properties for any property fetch you initialized.
   * The creation of dynamic property is deprecated in PHP 8.2.
   */
  protected $session;

  /**
   * @return void
   */
  public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
  {
    // Do Not Edit This Line
    parent::initController($request, $response, $logger);

    // Preload any models, libraries, etc, here.
    $this->session = \Config\Services::session();

    $this->settings = setting_all();
    date_default_timezone_set($this->settings['timezone']);
    // helper('basic');
    setDefaultViewData();

    $this->setDefaultPageData();
    // service('request')->setLocale(getUserlang($this->settings['default_lang']));
  }



  public function setDefaultPageData()
  {
    setPageData([
      'title' => $this->title,
      'link' => $this->link,
      'settings' => $this->settings,
      'menu' => $this->menu,
      'submenu' => $this->submenu,
    ]);
  }

  public function updatePageData(array $newData)
  {
    $defaultData = [
      'title' => $this->title,
      'link' => $this->link,
      'settings' => $this->settings,
      'menu' => $this->menu,
      'submenu' => $this->submenu,
    ];

    setPageData(array_merge($defaultData, $newData));
  }

  public function permissionCheck($key = null)
  {

    if (!is_logged()) {
      $this->response->redirect(base_url('/login'));
    }

    // || $key != 'profile'
    if ($key != 'dashboard' && $key != 'profile') {
      if (!hasPermissions($key)) {
        $this->response->redirect(base_url('/errors/denied'));
      }
    }
  }

  public function checkId($id)
  {
    $id = htmlspecialchars($id);
    $res = $this->model->find($id);
    if (!$res) {
      setAlert('warning', 'Warning', 'NOT VALID');
      // return redirect()->to(base_url($this->link));
      $this->response->redirect(base_url($this->link));
    }

    return $res;
  }
}
