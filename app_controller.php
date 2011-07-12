<?php

App::import('Core', 'Sanitize');

class AppController extends Controller {

	public $components = array(
		'RequestHandler' => array(
			// 'enabled' => false,
		),
		'DebugKit.Toolbar' => array(
			'history' => 5,
			'panels' => array(
				'Interactive.interactive',
			),
		),
		'Secured.Ssl' => array(
			'autoRedirect' => __SSL__REDIRECT,
			'prefixes' => array(
			),
			'secured' => array(
			),
			'allowed' => array(
			),
		),
		'Security',
		'Cookie' => array(
			// 'name' => '',
		),
		'Session',
		'Hack.Alias' => array(
			'Auth' => 'AppAuth',
			'Transition' => 'AppTransition',
			'DisableActions' => 'AppDisableActions',
		),
		'Ninja.PageTitle',
		'Ninja.ConfigViewCache',
		'Maintenance.Maintenance' => array(
			'maintenanceUrl' => array(
				'controller' => 'pages',
				'action' => 'maintenance',
			),
		),
		'Ninja.RoleAuthorize',
		'Ninja.AllowDeny',
	);

	public $helpers = array(
		'Hack.alias' => array(
			'Html' => 'AppHtml',
			'Form' => 'AppForm',
		),
		'Text',
		'Time',
		'Session',
		'Js',
		'Ninja.Auth',
		'Ninja.Menu',
		'Cache',
	);

	protected function _redirectAction($action = 'index') {
		$args = func_get_args();
		array_shift($args);
		$args['action'] = $action;
		return $this->redirect($args);
	}

	public function beforeFilter() {
		$this->disableCache();
	}

	protected function _forbidden() {
		$this->cakeError('forbidden');
		$this->_stop();
	}

	protected function _notFound() {
		$this->cakeError('error404');
		$this->_stop();
	}

	public function isAuthorized($user, $controller, $action) {
		return $this->RoleAuthorize->authorize($user, $controller, $action);
	}

	protected function _renderJson($json = null) {
		if ($json !== null) {
			$this->set(compact('json'));
		}
		$this->view = 'Json';
		$this->disableCache();
		Configure::write('debug', 0);
		$this->RequestHandler->respondAs('json', array('charset' => Configure::read('App.encoding')));
	}

}
