<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public $model;
    public $link = 'login';
    public $view = 'admin/auth';
    public $title = 'Login';
    protected $limitExpired = 5; // minute
    public function __construct()
    {
        $this->limitExpired = setting('expired_password_reset');
        $this->model = new \App\Models\UserModel();
    }

    public function index()
    {
        if (is_logged()) {
            return redirect()->to('dashboard');
        }

        $data = [
            'title' => $this->title,
            'link' => $this->link,
        ];

        return view($this->view . '/login', $data);
    }

    public function verify()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required|min_length[8]',
            'g-recaptcha-response' => 'validateRecaptcha[g-recaptcha-response]',
        ];

        $messageRules = [
            'username' => [
                // 'is_unique' => 'Sorry. That email has already been taken. Please choose another.',
                'required' => 'Please input username',
            ],
            'password' => [
                // 'is_unique' => 'Sorry. That email has already been taken. Please choose another.',
                'required' => 'Please input password',
                'min_length' => 'Min length 8',
            ],
            'g-recaptcha-response' => [
                'required' => 'Recaptcha is required',
                'validateRecaptcha' => 'Google Recaptcha not valid !'
            ]
        ];

        $input = $this->request->getVar();

        if (!$this->validateData($input, $rules, $messageRules)) {
            return redirect()->back()->withInput();
        }

        $username = htmlspecialchars($this->request->getVar('username'), true);
        $password = htmlspecialchars($this->request->getVar('password'), true);

        $user = $this->model->where('username', $this->request->getVar('username'))->orWhere('email', $this->request->getVar('username'))->first();

        if (!$user) {
            return redirect()->back()->with('_ci_validation_errors', [
                'username' => 'Invalid Username or Email'
            ]);
        }

        if (!passwordVerify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('_ci_validation_errors', [
                'password' => 'Invalid password'
            ]);
        }

        if ($user['is_active'] == 0) {
            return redirect()->back()->with('_ci_validation_errors', [
                'username' => 'Non active account ' . $username . ' '
            ]);
        }

        // set session
        $time = time();

        // encypting userid and password with current time $time
        $login_token = sha1($user['id'] . $user['password'] . $time);

        model('App\Models\ActivityLogModel')->add(ucfirst($user['name']) . " (" . $user['username'] . ") Logged in", $user['id']);

        $remember = $this->request->getVar('remember_me');

        if (empty($remember)) {
            $array = [
                'login' => true,
                // saving encrypted userid and password as token in session
                'login_token' => $login_token,
                'logged' => [
                    'id' => $user['id'],
                    'time' => $time,
                ]
            ];
            $this->session->set($array);
        } else {

            $data = [
                'id' => $user['id'],
                'time' => time(),
            ];
            // $expiry = strtotime("+" . setting('expired_cookie') . " minutes", strtotime(date('Y-m-d')));
            // $expiry = strtotime('+7 days');
            $expiry = strtotime("+" . setting('expired_cookie') . " minutes");

            setAlert('success', "Welcome " . $user['name']);

            setcookie('login', true, $expiry, '/');
            setcookie('logged',  json_encode($data), $expiry, '/');
            setcookie('login_token',  $login_token, $expiry, '/');

            return redirect()->to('dashboard');

            // redirect
            // return redirect()->to('dashboard')
            //     ->setCookie(
            //         'login',
            //         true,
            //         time() + 300
            //     )
            //     ->setCookie(
            //         'logged',
            //         json_encode($data),
            //         $expiry,
            //     )->setCookie(
            //         'login_token',
            //         $login_token,
            //         $expiry
            //     );
        }

        setAlert('success', "Welcome " . $user['name']);

        // redirect
        return redirect()->to('dashboard');
    }

    public function register()
    {
        if (setting('page_register') != '1') {
            return redirect()->to('login');
        }

        if (is_logged()) {
            return redirect()->to('dashboard');
        }

        $data = [
            'title' => 'Register',
        ];

        return view($this->view . '/register', $data);
    }


    public function registered()
    {
        if (setting('page_register') != '1') {
            return redirect()->to('login');
        }

        $rules = [
            'name' => 'required',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|min_length[8]|matches[password]',
            'email' => 'required|is_unique[users.email]|valid_email',
            'username' => 'required|is_unique[users.username]',
            'g-recaptcha-response' => 'validateRecaptcha[g-recaptcha-response]',
        ];

        $input = $this->request->getVar();

        if (!$this->validateData($input, $rules, [
            'g-recaptcha-response' => [
                'required' => 'Recaptcha is required',
                'validateRecaptcha' => 'Google Recaptcha not valid !'
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        $checkPassword = checkPasswordStrength($input['password']);
        if ($checkPassword['result'] == false) {
            return redirect()->back()->withInput()->with('_ci_validation_errors', [
                'password' => 'Password you must uppercase, lowercase, number, special char and min 8 char'
            ]);
        }

        $data = [
            'name' => htmlspecialchars($this->request->getVar('name'), true),
            'username' => htmlspecialchars($this->request->getVar('username'), true),
            'email' => htmlspecialchars($this->request->getVar('email'), true),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role_id' => 2,
            'is_active' => 1,
            'phone' => '',
            'address' => '',
            'image' => 'default.jpg',
        ];

        $res = $this->model->save($data);
        $user = $this->model->orderBy('id', 'DESC')->first();

        model('App\Models\ActivityLogModel')->add(ucfirst($user['name']) . " (" . $user['username'] . ") Registered in", $user['id']);

        if ($res) {
            setAlert('success', 'Success', 'Register Success');
            return redirect()->to($this->link);
        } else {
            setAlert('warning', 'Warning', 'Register Failed');
            return redirect()->to('/register');
        }
    }

    public function ajaxEmail()
    {
        $email = $this->request->getVar('email');
        if ($email) {
            $data = $this->model->where('email', $email)->first();
            if ($data) {
                $result = [
                    'result' => true,
                    'message' => 'Email Already Use'
                ];
            } else {
                $result = [
                    'result' => false,
                    'message' => 'Email Not Use'
                ];
            }
        } else {
            $result = [
                'result' => false,
                'message' => 'Not send email'
            ];
        }
        echo json_encode($result);
    }

    public function ajaxUsername()
    {
        $username = $this->request->getVar('username');
        if ($username) {
            $data = $this->model->where('username', $username)->first();
            if ($data) {
                $result = [
                    'result' => true,
                    'message' => 'Username Already Use'
                ];
            } else {
                $result = [
                    'result' => false,
                    'message' => 'Username Not Use'
                ];
            }
        } else {
            $result = [
                'result' => false,
                'message' => 'Not send username'
            ];
        }
        echo json_encode($result);
    }

    public function forgotPassword()
    {
        if (setting('page_forgot') != '1') {
            return redirect()->to('login');
        }

        if (is_logged()) {
            return redirect()->to('dashboard');
        }

        $data = [
            'title' => 'Forgot Password',
        ];

        return view($this->view . '/forgot-password', $data);
    }

    public function actionForgotPassword()
    {
        if (setting('page_forgot') != '1') {
            return redirect()->to('login');
        }

        $rules = [
            'email' => 'required|valid_email',
            'g-recaptcha-response' => 'validateRecaptcha[g-recaptcha-response]',
        ];

        $input = $this->request->getVar();

        if (!$this->validateData($input, $rules, [
            'g-recaptcha-response' => [
                'required' => 'Recaptcha is required',
                'validateRecaptcha' => 'Google Recaptcha not valid !'
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        $email = $this->request->getVar('email');
        $user = $this->model->where('email', $email)->first();
        if ($user) {
            // set session
            $time = time();

            // encypting userid and password with current time $time
            $token = sha1($time . $user['id'] . $user['password']);

            // SEND MAIL
            $data_parser['reset_link'] = base_url() . 'change-password?token=' . $token . '';
            $data_parser['name'] = $user['name'];
            $data_parser['username'] = $user['username'];
            $data_parser['email'] = $user['email'];
            $data_parser['company_name'] = setting('company_name');
            $data_parser['company_email'] = setting('company_email');
            $data_parser['expired_password_reset'] = setting('expired_password_reset');
            $parser = \Config\Services::parser();

            $template = (new \App\Models\EmailTemplateModel)->where('code', 'reset_password')->first();

            $to_email = (new \App\Models\EmailTemplateSendModel)->where('type', 'TO')->where('is_send', 1)->where('template_id', $template['id'])->findAll();
            $cc_email = (new \App\Models\EmailTemplateSendModel)->where('type', 'CC')->where('is_send', 1)->where('template_id', $template['id'])->findAll();
            $bcc_email = (new \App\Models\EmailTemplateSendModel)->where('type', 'BCC')->where('is_send', 1)->where('template_id', $template['id'])->findAll();
            $reply_email = (new \App\Models\EmailTemplateSendModel)->where('type', 'REPLY')->where('is_send', 1)->where('template_id', $template['id'])->findAll();

            $subject = $parser->setData($data_parser)->renderString($template['subject']);
            $html = $parser->setData($data_parser)->renderString($template['body']);

            $email = \Config\Services::email();

            // TO KE EMAIL YANG REQUEST
            $email->setTo($user['email']);

            foreach ($to_email as $d) {
                $email->setTo($d['email'], $d['name']);
            }

            foreach ($cc_email as $d) {
                $email->setCC($d['email'], $d['name']);
            }

            foreach ($bcc_email as $d) {
                $email->setBCC($d['email'], $d['name']);
            }

            foreach ($reply_email as $d) {
                $email->setReplyTo($d['email'], $d['name']);
            }

            $email->setSubject($subject);
            $email->setMessage($html);

            if (!$email->send()) {
                if (getenv('CI_ENVIRONMENT') == 'development' && EMAIL_DEBUG == 'true') {
                    dd($email->printDebugger(['headers']));
                }
                setAlert('warning', 'Warning', 'Unable to Send Email');
                return redirect()->back();
            }

            $this->model->addTokenReset($token, $user['email']);

            model('App\Models\ActivityLogModel')->add(ucfirst($user['name']) . " (" . $user['username'] . ") Request Reset Password in", $user['id']);

            setAlert('success', 'Please check your email for reset your password');
        } else {
            setAlert('warning', 'Email not found');
        }
        return redirect()->to('forgot-password');
    }

    public function changePassword()
    {
        $token = $this->request->getVar('token');
        if (!isset($token)) {
            return redirect()->to($this->link);
        }

        $result = $this->model->findTokenReset($token);
        if (!$result) {
            setAlert('warning', 'Token not valid ');
            return redirect()->to($this->link);
        }

        $created_at = $result['created_at'];
        // $expired_at = date('Y-m-d H:i:s', strtotime("+" . $this->limitExpired . " minutes", strtotime($created_at)));
        $expired_at = strtotime("+" . $this->limitExpired . " minutes", strtotime($created_at));
        if ($expired_at < time()) {
            // jika expired time < dari time now
            setAlert('warning', 'Token expired');
            return redirect()->to($this->link);
        }

        $data = [
            'title' => 'Change Password',
            'token' => $token,
            'email' => $result['email'],
        ];

        return view($this->view . '/change-password', $data);
    }

    public function updateChangePassword()
    {
        $token = $this->request->getVar('token');
        if (!isset($token)) {
            return redirect()->to($this->link);
        }

        $result = $this->model->findTokenReset($token);
        if (!$result) {
            setAlert('warning', 'Token not valid ');
            return redirect()->to($this->link);
        }

        $created_at = $result['created_at'];
        // $expired_at = date('Y-m-d H:i:s', strtotime("+" . $this->limitExpired . " minutes", strtotime($created_at)));
        $expired_at = strtotime("+" . $this->limitExpired . " minutes", strtotime($created_at));
        if ($expired_at < time()) {
            // jika expired time < dari time now
            setAlert('warning', 'Token expired');
            return redirect()->to($this->link);
        }

        $rules = [
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|min_length[8]|matches[password]',
        ];

        $input = $this->request->getVar();

        if (!$this->validateData($input, $rules)) {
            return redirect()->to('change-password?token=' . $token)->withInput();
        }

        $checkPassword = checkPasswordStrength($input['password']);
        if ($checkPassword['result'] == false) {
            return redirect()->back()->withInput()->with('_ci_validation_errors', [
                'password' => 'Password you must uppercase, lowercase, number, special char and min 8 char'
            ]);
        }

        $data = [
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];

        $res = $this->model->where('email', $result['email'])->update(null, $data);
        $user = $this->model->where('email', $result['email'])->first();

        model('App\Models\ActivityLogModel')->add(ucfirst($user['name']) . " (" . $user['username'] . ") Update Reset Password in", $user['id']);

        if ($res) {
            setAlert('success', 'Success', 'Update Reset Password Success');
            return redirect()->to($this->link);
        } else {
            setAlert('warning', 'Warning', 'Update Reset Password Failed');
            return redirect()->to($this->link);
        }
    }

    public function logout()
    {
        if (logged('id')) {
            $data_user = getProfile();

            // model('App\Models\ActivityLogModel')->add("User: " . logged('name') . "(" . logged('username') . ") Logged Out");
            model('App\Models\ActivityLogModel')->add("User: " . $data_user['name'] . "(" . $data_user['username'] . ") Logged Out");
            $id = $data_user['id'];
            $this->model->update($id, ['last_login' => date('Y-m-d H:i:s')]);

            // Deleting Sessions
            $this->session->remove('login');
            $this->session->remove('logged');
            $this->session->remove('login_token');

            // Deleting Cookie

            // delete_cookie('login');
            // delete_cookie('logged');
            // delete_cookie('login_token');
        }

        $expiry = strtotime('-7 days');

        return redirect()->to($this->link)->setCookie(
            'login',
            false,
            $expiry
        )
            ->setCookie(
                'logged',
                false,
                $expiry,
            )->setCookie(
                'login_token',
                false,
                $expiry
            );
    }
}
