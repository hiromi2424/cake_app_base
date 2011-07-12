<?php
App::import('Datasource', 'DboMysql');

class DboAppMysql extends DboMysql {
	function __construct($config = null, $autoConnect = true) {
		$this->columns['binary']['name'] = 'mediumblob';
		parent::__construct($config, $autoConnect);
	}
}
