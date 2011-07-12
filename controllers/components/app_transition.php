<?php

App::import('Component', 'Utilities.Transition');

class AppTransitionComponent extends TransitionComponent {

	public function initialize(&$controller, $settings = array()) {
		$settings += array(
			'messages' => array(
				'invalid' => '登録内容が正しくありません',
				'prev' => '不正なページ遷移です',
			),
		);

		return parent::initialize($controller, $settings);

	}

}