<?php

namespace App\Controllers;

use App\Controllers\AdminBaseController;
use App\Models\SettingModel;

class Settings extends AdminBaseController
{

	public $title = 'Settings';
	public $menu = 'settings';
	public $link = 'settings';
	public $view = 'admin/settings';
	protected $dir = 'public/uploads/apps';

	public function index()
	{
		return view($this->view . '/list');
	}

	public function general()
	{
		$this->permissionCheck('general_settings');

		$this->updatePageData(['submenu' => 'general']);

		$data = [
			'tab' => 'general'
		];

		return view($this->view . '/general', $data);
	}

	public function generalUpdate()
	{

		$this->permissionCheck('general_settings');

		$setting = new SettingModel();

		$setting->updateByKey('date_format', htmlspecialchars($this->request->getVar('date_format')));
		$setting->updateByKey('datetime_format', htmlspecialchars($this->request->getVar('datetime_format')));
		$setting->updateByKey('google_recaptcha_enabled', ((htmlspecialchars($this->request->getVar('google_recaptcha_enabled')) ? '1' : '0')));
		$setting->updateByKey('google_recaptcha_sitekey', htmlspecialchars($this->request->getVar('google_recaptcha_sitekey')));
		$setting->updateByKey('google_recaptcha_secretkey', htmlspecialchars($this->request->getVar('google_recaptcha_secretkey')));
		$setting->updateByKey('timezone', htmlspecialchars($this->request->getVar('timezone')));
		$setting->updateByKey('app_name', htmlspecialchars($this->request->getVar('app_name')));
		$setting->updateByKey('app_description', htmlspecialchars($this->request->getVar('app_description')));
		$setting->updateByKey('app_copyright', htmlspecialchars($this->request->getVar('app_copyright')));
		$setting->updateByKey('app_copyright_link', htmlspecialchars($this->request->getVar('app_copyright_link')));
		$setting->updateByKey('app_year', htmlspecialchars($this->request->getVar('app_year')));
		$setting->updateByKey('app_version', htmlspecialchars($this->request->getVar('app_version')));
		$setting->updateByKey('expired_password_reset', htmlspecialchars($this->request->getVar('expired_password_reset')));
		$setting->updateByKey('page_register', ((htmlspecialchars($this->request->getVar('page_register')) ? '1' : '0')));
		$setting->updateByKey('page_forgot', ((htmlspecialchars($this->request->getVar('page_forgot')) ? '1' : '0')));
		$setting->updateByKey('activity_record', ((htmlspecialchars($this->request->getVar('activity_record')) ? '1' : '0')));
		$setting->updateByKey('activity_error', ((htmlspecialchars($this->request->getVar('activity_error')) ? '1' : '0')));
		$setting->updateByKey('activity_forbidden', ((htmlspecialchars($this->request->getVar('activity_forbidden')) ? '1' : '0')));
		// $setting->updateByKey('default_lang', htmlspecialchars($this->request->getVar('default_lang')));


		$app_favicon = $this->request->getFile('app_favicon');
		if ($app_favicon->getError() != 4) {
			if (!$this->validate([
				'app_favicon' => [
					'label' => 'Profile Image',
					'rules' => 'uploaded[app_favicon]'
						. '|is_image[app_favicon]'
						. '|mime_in[app_favicon,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
				],
			])) {

				setAlert('warning', $this->validator->getErrors()['app_favicon']);
				return redirect()->back();
			}


			$old_image = setting('app_favicon');

			// $fileName = $dataBerkas->getName();
			$fileName = $app_favicon->getRandomName();

			if ($old_image != 'image.png') {
				@unlink($this->dir . '/' . $old_image);
			}

			$app_favicon->move($this->dir, $fileName);
			$setting->updateByKey('app_favicon', $fileName);
		}

		$app_image = $this->request->getFile('app_image');
		if ($app_image->getError() != 4) {
			if (!$this->validate([
				'app_image' => [
					'label' => 'Profile Image',
					'rules' => 'uploaded[app_image]'
						. '|is_image[app_image]'
						. '|mime_in[app_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
				],
			])) {

				setAlert('warning', $this->validator->getErrors()['app_image']);
				return redirect()->back();
			}

			$old_image = setting('app_image');

			// $fileName = $dataBerkas->getName();
			$fileName = $app_image->getRandomName();

			if ($old_image != 'image.png') {
				@unlink($this->dir . '/' . $old_image);
			}

			$app_image->move($this->dir, $fileName);
			$setting->updateByKey('app_image', $fileName);
		}



		model('App\Models\ActivityLogModel')->add("Company Settings Updated by User: #" . logged('id'));

		setAlert('success', 'Settings has been Updated Successfully');
		return redirect()->back();
	}

	public function company()
	{
		$this->permissionCheck('company_settings');

		$this->updatePageData(['submenu' => 'company']);

		$data = [
			'tab' => 'company'
		];

		return view($this->view . '/company', $data);
	}

	public function companyUpdate()
	{

		$this->permissionCheck('company_settings');

		$setting = new SettingModel();

		$setting->updateByKey('company_name', htmlspecialchars($this->request->getVar('company_name')));
		$setting->updateByKey('company_email', htmlspecialchars($this->request->getVar('company_email')));

		model('App\Models\ActivityLogModel')->add("Company Settings Updated by User: #" . logged('id'));

		setAlert('success', 'Settings has been Updated Successfully');
		return redirect()->back();
	}
}
