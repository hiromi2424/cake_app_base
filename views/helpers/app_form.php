<?php

App::import('Helper', 'Form');

class AppFormHelper extends FormHelper {

	public function create($model = null, $options = array()) {
		$defaults = array(
			'inputDefaults' => array(
				'label' => false,
				'div' => false,
			),
		);
		return parent::create($model, $options);
	}

	public function backButton($url, $label = '', $options = array()) {
		$button = $this->submit($label, $options + array('type' => 'button'));
		return $this->Html->link($button, $url, array('escape' => false));
	}

}