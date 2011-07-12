<?php

App::import('Component', 'Ninja.DisableActions');

class AppDisableActionsComponent extends DisableActionsComponent {

	public $components = array();

	public function blackHole() {
		$this->cakeError('error404');
	}

}