<?php

Configure::load('site');
Configure::load('mail');

App::import('Lib', 'Ninja.ExceptionHandler');
set_exception_handler(array('ExceptionHandler', 'process'));

CakeLog::config('file', array('engine' => 'FileLog'));
CakeLog::config('file', array('engine' => 'Mailer.MailLog'));

