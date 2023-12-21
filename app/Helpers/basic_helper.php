<?php


function copyright($year = null)
{
  $tahun_start = ($year == null) ? '2023' : $year;
  $tahun_now = date('Y');
  if ($tahun_start == $tahun_now) {
    return $tahun_start;
  } else {
    return $tahun_start . '-' . $tahun_now;
  }
}

if (!function_exists('setting')) {

  function setting($key = '', $default = false)
  {
    return !empty($value = @model('\App\Models\SettingModel')->like('key', $key)->first()['value']) ? $value : $default;
  }
}

if (!function_exists('setting_all')) {

  function setting_all()
  {
    $data = model('\App\Models\SettingModel')->findAll();

    $new = [];
    foreach ($data as $value) {
      $new[$value['key']] = $value['value'];
    }

    return $new;
  }
}

if (!function_exists('is_logged')) {

  function is_logged()
  {
    $login_token_match = false;

    $isLogged = !empty(session()->get('login')) &&  !empty(session()->get('logged')) ? (object) session()->get('logged') : false;
    $_token = $isLogged && !empty(session()->get('login_token')) ? session()->get('login_token') : false;

    if (!$isLogged) {
      $isLogged = get_cookie('login') && !empty(get_cookie('logged')) ? json_decode(get_cookie('logged')) : false;
      $_token = $isLogged && !empty(get_cookie('login_token')) ? get_cookie('login_token') : false;
    }


    if ($isLogged) {
      $userModel = model('App\Models\UserModel');

      $user = $userModel->select('id, password')->find($isLogged->id);
      // verify login_token
      $login_token_match = (sha1($user['id'] . $user['password'] . $isLogged->time) == $_token);
    }

    return $isLogged && $login_token_match;
  }
}


function logged($key = false)
{

  if (!is_logged()) {
    return false;
  }

  $logged = !empty(session()->get('login')) ? model('App\Models\UserModel')->select($key)->find(session()->get('logged')['id']) : false;

  if (!$logged) {
    $logged = model('App\Models\UserModel')->select($key)->find(json_decode(get_cookie('logged'))->id);
  }

  return (!$key) ? $logged : $logged[$key];
}

if (!function_exists('hasPermissions')) {

  function hasPermissions($code = '')
  {
    return !empty(model('App\Models\RolePermissionModel')->select('role_id')->join('permissions', 'permissions.id = role_permissions.permission_id')->where('permissions.code', $code)->where(['role_id' => logged('role_id')])->findAll());
  }
}


function updateViewData($data)
{
  $view = \Config\Services::renderer();
  $view->setData($data);
}

function setPageData($data)
{
  // updateViewData(['_page' =>  $data]);
  updateViewData(['_page' => (object) $data]);
}

function setDefaultViewData()
{
  setPageData([
    'title' => '',
    'link' => '',
    'menu' => '',
    'submenu' => '',
  ]);
}


function joinSegment($segment)
{
  $segments = explode('_', $segment);
  if (count($segments) > 1) {
    return $segments[0] . ucfirst($segments[1]);
  } else {
    return $segment;
  }
}

if (!function_exists('breadcrumb')) {

  function breadcrumb($args = [])
  {
    $segments = service('request')->uri->getSegments();
    // $html = '<ol class="breadcrumb">';
    // $i = 0;
    // foreach ($args as $key => $value) {
    //   if (count($args) < $i)
    //     $html .= '<li><a href="' . url($key) . '">' . $value . '</a></li>';
    //   else
    //     $html .= '<li class="active">' . $value . '</li>';
    //   $i++;
    // }

    $html = '<ol class="breadcrumb">';
    $i = 1;
    $html .= '<li class="breadcrumb-item"><a href="' . base_url('dashboard') . '">Home</a></li>';
    $end = end($segments);
    $total = ($end == 'edit') ? count($segments) - 1 : count($segments);
    foreach ($segments as $segment) {
      if ($total > $i) {
        $html .= '<li class="breadcrumb-item text-capitalize"><a href="' . base_url($segment) . '">' . joinSegment($segment) . '</a></li>';
      } else {
        if ($end == $segment) {
          $html .= '<li class="breadcrumb-item text-capitalize active " aria-current="page">' . joinSegment($end) . '</li>';
        } else {
          // $html .= '<li class="breadcrumb-item text-capitalize active " aria-current="page">' . $segment . '</li>';
        }
      }
      $i++;
    }


    $html .= '</ol>';
    echo $html;
  }
}


if (!function_exists('getProfile')) {

  function getProfile()
  {
    $id = logged('id');
    $data = model('App\Models\UserModel')->select('users.*, title')->join('roles', 'roles.id = users.role_id')->find($id);
    return $data;
  }
}

if (!function_exists('dirUploadUser')) {

  function dirUploadUser()
  {
    return 'public/uploads/users';
  }
}

function passwordHash($password)
{
  return password_hash($password, PASSWORD_DEFAULT);
}

function passwordVerify($password, $hash)
{
  return (password_verify($password, $hash));
}

function checkPasswordStrength($password)
{
  // Define password strength requirements using regular expressions
  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $number = preg_match('@[0-9]@', $password);
  $specialChar = preg_match('@[^\w]@', $password);

  // Define minimum length for the password
  $minLength = 8;
  $result = [];

  // Check if the password meets all the requirements
  if ($uppercase && $lowercase && $number && $specialChar && strlen($password) >= $minLength) {
    // return true;
    $result['result'] = true;
    $result['uppercase'] = $uppercase;
    $result['lowercase'] = $lowercase;
    $result['number'] = $number;
    $result['specialChar'] = $specialChar;
    $result['minLength'] = 1;
  } else {
    // return false;
    $result['result'] = false;
    $result['uppercase'] = $uppercase;
    $result['lowercase'] = $lowercase;
    $result['number'] = $number;
    $result['specialChar'] = $specialChar;
    $result['minLength'] = (strlen($password) >= $minLength);
  }

  return $result;
}

function urlBack()
{
  return session()->get('_ci_previous_url');
}

if (!function_exists('ip_address')) {

  function ip_address()
  {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
      $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
      $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
      $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }
}

function setAlert($icon, $title, $text = '', $type = 'sweetalert', $url = null)
{

  $session = session();

  $session->setFlashdata('iconFlash', $icon);
  $session->setFlashdata('titleFlash', $title);
  $session->setFlashdata('textFlash', $text);
  $session->setFlashdata('typeFlash', $type);
  $session->setFlashdata('urlFlash', $url);
}

function initAlert()
{
  $session = session();
  return "

  <div id='flash' data-icon='" . $session->getFlashdata('iconFlash') . "' data-title='" . $session->getFlashdata('titleFlash') . "' data-text='" . $session->getFlashdata('textFlash') . "' data-url='" . $session->getFlashdata('urlFlash') . "' data-type='" . $session->getFlashdata('typeFlash') . "'></div>

  <script>

  const Swal2 = Swal.mixin({
    customClass: {
      input: 'form-control'
    }
  })
  
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  
  
  function deleteTombol(e){
    const ket = e.getAttribute('data-ket');
    const href = e.getAttribute('data-href') ? e.getAttribute('data-href') : e.getAttribute('href');
    Swal.fire({
      title: 'Are you sure?',
      text: ket,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        if(href){
          window.location.href = href;
        }else{
          e.parentElement.submit();
        }
      }
    })
    e.preventDefault();
  }
  
  const iconFlash = document.getElementById('flash').getAttribute('data-icon');
  const titleFlash = document.getElementById('flash').getAttribute('data-title');
  const textFlash = document.getElementById('flash').getAttribute('data-text');
  const urlFlash = document.getElementById('flash').getAttribute('data-url');
  const typeFlash = document.getElementById('flash').getAttribute('data-type');


  if(typeFlash == 'sweetalert'){
    
    if (iconFlash && urlFlash) {
      Swal.fire({
        icon: iconFlash,
        title: titleFlash,
        text: textFlash
      }).then((result) => {
        if (result.value) {
          window.location.href = urlFlash;
        }
      })
    } else if (iconFlash) {
      Swal.fire({
        icon: iconFlash,
        title: titleFlash,
        text: textFlash
      })
    }

  }else if(typeFlash =='toast'){
    Toast.fire({
      icon: iconFlash,
      title: titleFlash
    })
  }

  </script>
  
  
  ";
}


function getDatesFromRange($start, $end, $format = 'Y-m-d')
{
  if ($start == $end) {
    $data[] = $start;
    return $data;
  }
  return array_map(
    function ($timestamp) use ($format) {
      return date($format, $timestamp);
    },
    range(strtotime($start) + ($start <= $end ? 4000 : 8000), strtotime($end) + ($start <= $end ? 8000 : 4000), 86400)
  );
}


function setLimit($count, $limit)
{
  if ($count < $limit) {
    return $count / 2;
  } else {
    return $limit;
  }
}
