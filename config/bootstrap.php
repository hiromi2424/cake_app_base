<?php

Configure::load('site');

App::import('Lib', 'Ninja.ExceptionHandler');
set_exception_handler(array('ExceptionHandler', 'process'));

CakeLog::config('file', array('engine' => 'FileLog'));

