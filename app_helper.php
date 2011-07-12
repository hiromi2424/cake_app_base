<?php

class AppHelper extends Helper {

	public function url($url, $full = false) {
		if (is_string($url) && preg_match(sprintf('/^%s.+/', preg_quote('//', '/')), $url)) {
			return h($url);
		}
		return parent::url($url, $full);
	}

}