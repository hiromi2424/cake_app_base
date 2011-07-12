<?php

App::import('Datasource', 'Datasources.ArraySource');

Class AppArraySource extends ArraySource {

	public function name($name) {
		return $name;
	}

}

