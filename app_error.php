<?php
class AppError extends ErrorHandler {

	public function _outputMessage($template) {
		$this->controller->beforeFilter();
		$this->controller->set('referer', $this->controller->referer());
		$this->controller->render($this->__dispatch($template));
		$this->controller->afterFilter();
		$this->controller->Component->shutdown($this->controller);
		echo $this->controller->output;
	}

	function __dispatch($name) {
		$debug = Configure::read('debug') > 0;
		if ($debug) {
			var_dump(Debugger::trace());
			$this->controller->layout = 'cakephp';
		}
		if (empty($this->controller->viewVars['name'])) {
			$this->controller->set('name', __('Not Found', true));
			$this->controller->set('message', $debug ? h(Router::normalize($this->controller->here)) : '');
		}
		switch ($name) {
			case 'error500':
			case 'forbidden':
				return $name;
			default:
			if (Configure::read() === 0) {
				return 'error404';
			} else {
				return $name;
			}
		}
	}

	public function forbidden($params) {
		extract($params, EXTR_OVERWRITE);

		if (!isset($url)) {
			$url = $this->controller->here;
		}
		$url = Router::normalize($url);
		$this->controller->header("HTTP/1.0 403 Forbidden");
		$this->controller->set(array(
			'code' => '403',
			'name' => __('Forbidden', true),
			'message' => h($url),
			'base' => $this->controller->base
		));
		$this->_outputMessage('forbidden');
	}
}
