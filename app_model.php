<?php

App::import('Lib', 'LazyModel.LazyModel');

class AppModel extends LazyModel {

	public $actsAs = array(
		'Ninja.MagickMethod',
		'Collectionable.Options',
		'Collectionable.VirtualFields',
		'Collectionable.ConfigValidation',
		'Collectionable.MultiValidation',
		'Ninja.CommonValidation',
		'Containable',
		'Cakeplus.AddValidationRule',
	);

	public $defaultOption = 'default';

	public function onError() {
		$message = $this->getDataSource()->error;
		throw new DatabaseError($message);
	}

	// TODO: test, move to common validation
	public function arrayNotEmpty($check) {
		$value = current((array)$check);

		if (!is_array($value)) {
			return Validation::notEmpty($check);
		}
		return !empty($value);
	}

	public function uniques($check) {
		$conditions = array();

		$args = func_get_args();
		foreach ($args as $field) {
			if (is_array($field)) {
				if (Set::countDim($field, true) === 1) {
					foreach ($field as $k => $v) {
						$conditions += array($this->escapeField($k) => $v);
					}
				}
			} else {
				if (!isset($this->data[$this->alias][$field])) {
					trigger_error($field . ' is not propery set in data on ' . $this->alias);
					return false;
				}
				$conditions += array($this->escapeField($field) => $this->data[$this->alias][$field]);
			}
		}

		return !$this->hasAny($conditions);
	}

	public static function filter($input) {
		if (is_array($input)) {
			foreach ($input as &$value) {
				if (is_array($value)) {
					$value = self::filter($value);
				}
			}
		}

		return Set::filter($input);
	}


}

class DatabaseError extends RuntimeException {
}