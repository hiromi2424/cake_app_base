<?php

App::import('Component', 'Mailer.Mailer');

abstract class AdminMailerComponent extends MailerComponent {

	public $layout = 'admin';

	public function detectTo($params) {
		if (Environment::isProduction()) {
			return Configure::read('Mail.addresses.admin');
		} else {
			return Configure::read('Mail.addresses.debug');
		}
	}

}