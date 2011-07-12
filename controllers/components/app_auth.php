<?php

App::import('Component', 'Ninja.NinjaAuth');

class AppAuthComponent extends NinjaAuthComponent {

	public $authorize = 'controller';

	public $autoRedirect = false;
	public $logoutRedirect = '/';

	public $fields = array(
		'username' => 'email',
		'password' => 'password',
	);

	public function initialize($controller, $settings = array()) {
		$settings += array(
			'loginError' => 'メールアドレスかパスワードが正しくありません。',
			'authError' => '指定のURLにアクセスする権限がありませんでした。',
		);
		parent::initialize($controller, $settings);
	}

	public function login($data = null) {
		$result = parent::login($data);
		if ($result) {
			switch ($this->user('Group.name')) {
				case 'admin':
					// $loginRedirect = array('controller' => 'admin', 'action' => 'index');
					break;
				default:
					// $loginRedirect = array('controller' => 'front', 'action' => 'index', 'admin' => false);
			}

			if (isset($loginRedirect)) {
				if ($this->Session->read('Auth.redirect') === '/') {
					$this->Session->delete('Auth.redirect');
				}
				$this->loginRedirect = $loginRedirect;
			}
		}
		return $result;
	}

}