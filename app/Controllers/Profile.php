<?php

namespace App\Controllers;

use App\Controllers\AdminBaseController;

class Profile extends AdminBaseController
{

	public $title = 'Profile Management';
	public $menu = false;
	public $link = 'profile';
	private $view = 'admin/account/profile';
	private $dir = '';

	public function __construct()
	{
		$this->model = new \App\Models\UserModel();
		$this->dir = dirUploadUser();
	}

	public function index($tab = 'profile')
	{
		$this->permissionCheck('profile');

		$data = [
			'user' => $this->model->select('users.*, title')->join('roles', 'roles.id = users.role_id')->find(logged('id')),
			'tab' => $tab
		];
		return view($this->view, $data);
	}

	public function updateProfile()
	{
		$this->permissionCheck('profile');

		$id = logged('id');
		$res = $this->model->find($id);

		$rules = [
			'name' => 'required',
			'email' => 'required',
			// 'username' => 'required',
		];


		$input = $this->request->getVar();

		if ($res['email'] != $input['email']) {
			$rules['email'] = 'required|is_unique[users.email]|valid_email';
		}

		// if ($res['username'] != $input['username']) {
		// 	$rules['username'] = 'required|is_unique[users.username]';
		// }


		if (!$this->validateData($input, $rules)) {
			// return redirect()->back()->withInput();
			return redirect()->to('profile/edit')->withInput();
		}

		$data = [
			// 'role' => $this->request->getvar('role'),
			'name' => htmlspecialchars($this->request->getVar('name')),
			// 'username' => htmlspecialchars($this->request->getVar('username')),
			'email' => htmlspecialchars($this->request->getVar('email')),
			'phone' => htmlspecialchars($this->request->getVar('contact')),
			'address' => htmlspecialchars($this->request->getVar('address')),
		];

		$res = $this->model->update($id, $data);

		model('App\Models\ActivityLogModel')->add("User #$id updated the profile");
		setAlert('success', 'Profile has been Updated Successfully');

		return redirect()->to($this->link);
	}

	public function updatePassword()
	{
		$this->permissionCheck('profile');

		$id = logged('id');
		$user = $this->model->find($id);


		if ($this->request->getvar('password') !== $this->request->getvar('password_confirm')) {
			setAlert('warning', 'Password does not matches with Confirm Password !');
			return redirect()->to('profile/change_password');
		}

		if (strlen($this->request->getvar('password')) < 6) {
			setAlert('warning', 'Password must have atleast 6 Characters');
			return redirect()->to('profile/change_password');
		}

		if (passwordVerify($this->request->getvar('password'), $user['password'])) {
			setAlert('warning', 'Invalid Old Password !');
			return redirect()->to('profile/change_password');
		}


		$password = $this->request->getvar('password');

		$data['password'] = passwordHash($password);

		$res = $this->model->update($id, $data);

		model('App\Models\ActivityLogModel')->add("User #$id changed the password !");

		setAlert('success', 'Password Changed, You need to Login Again !');
		return redirect()->to('login');
	}

	public function updateProfilePic()
	{
		$this->permissionCheck('profile');

		if (!$this->validate([
			'image' => [
				'label' => 'Profile Image',
				'rules' => 'uploaded[image]'
					. '|is_image[image]'
					. '|mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
			],
		])) {

			setAlert('warning', $this->validator->getErrors()['image']);
			return redirect()->to('profile/change_picture');
		}

		$id = logged('id');
		$user = $this->model->find($id);

		$img = $this->request->getFile('image');

		if (!empty($_FILES['image']['name'])) {

			$ext = $img->getExtension();
			$fileName = $img->getRandomName();
			$upload = $img->move($this->dir, $fileName);
			if (!$upload) {
				setAlert('warning', 'Server Error Occured while Uploading Image !');
				return redirect()->to('profile/change_picture');
			}

			@unlink($this->dir . '/' . $user['image']);
			$this->model->update($id, ['image' => $fileName]);

			model('App\Models\ActivityLogModel')->add("User #$id Updated his/her Profile Image.");

			setAlert('success', 'Profile Image has been Updated Successfully');
			return redirect()->to('profile/change_picture');
		}

		setAlert('warning', 'Server Error Occured while Uploading Image !');
		return redirect()->to('profile/change_picture');
	}

	public function change_language($code = '')
	{
		$this->permissionCheck('profile');
		return redirect()->to(!empty($_REQUEST['back']) ? urldecode($_REQUEST['back']) : '/')->setCookie('current_lang', $code, time() + 86400 * 30);
	}
}
