<?php 
/**
 * Compress and caches asset files: js, css (can be altered for other assets)
 *
 * Written by Miles Johnson (http://www.milesj.me), snippets from original CakePHP team
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
 
// No cake installation
if (!defined('CAKE_CORE_INCLUDE_PATH')) { 
	header('HTTP/1.1 404 Not Found');
	exit('File Not Found'); 
} 

// Get asset type
$ext = trim(strrchr($url, '.'), '.');
$assetType = ($ext === 'css') ? 'css' : 'js';

// Wrong file
$crack = preg_match('|\.\.|', $url);
$matched = preg_match('|^c'. $assetType .'/(.+)$|i', $url, $regs);
$isPluginOrTheme = false;

if (!$matched) {
	$matched = preg_match('|^(.+?)/c'. $assetType .'/(.+)$|i', $url, $regs);
	$isPluginOrTheme = true;
}

if ($crack || !$matched) {
	header('HTTP/1.1 404 Not Found');
	exit('File Not Found'); 
}

$plugin = $isPluginOrTheme ? $regs[1] : null;
$name = $isPluginOrTheme ? $regs[2] : $regs[1];
$path = $isPluginOrTheme ? $plugin . '-' . $name : $name;

$cachePath = CACHE .'assets'. DS . str_replace(array('/','\\'), '-', $path);
$fileName = $assetType . '/' . $name;

if ($isPluginOrTheme) {
	$basePath = $plugin === 'theme' ? App::themePath($plugin) : App::pluginPath($plugin);
	$basePath .= 'webroot' . DS . $assetType . DS;
}

if ($assetType == 'css') {
	$filePath = $isPluginOrTheme ? $basePath . $name : CSS . $name;
	$fileType = 'text/css';
} else {
	$filePath = $isPluginOrTheme ? $basePath . $name : JS . $name;
	$fileType = 'text/javascript';
}

if (!file_exists($filePath)) {
	header('HTTP/1.1 404 Not Found');
	exit('File Not Found'); 
}

/**
 * Compress the asset
 * @param string $path
 * @param string $name
 * @return string
 */
function compress($path, $name, $type, $webroot) {
	ob_start();
	include $path;
	$input = ob_get_contents();
	ob_end_clean();
	
	if ($type == 'css') {
		$stylesheet = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $input);
		$stylesheet = str_replace(array("\r\n", "\r", "\n", "\t", '/\s\s+/', '  ', '   '), '', $stylesheet);
		$stylesheet = str_replace(array(' {', '{ '), '{', $stylesheet);
		$stylesheet = str_replace(array(' }', '} '), '}', $stylesheet);
		$output = $stylesheet;
	} else {
		App::import('Vendor', 'jsmin');
		$output = JSMin::minify($input);
	}
	
	$ratio = 100 - (round(strlen($output) / strlen($input), 3) * 100);
	$output = "/* File: $name, Ratio: $ratio% */\n". $output;
	return $output;
}	

/**
 * Cache the asset
 * @param string $path
 * @param string $content
 * @return string
 */
function cacheAsset($path, $content) {
	if (!is_dir(dirname($path))) {
		mkdir(dirname($path));
		chmod($path, 0777);
	}
	
	if (!class_exists('File')) {
		uses('file');
	}
	
	$cached = new File($path);
	return $cached->write($content);
}

$isCached = file_exists($cachePath);
$templateModified = $isCached ? $templateModified = filemtime($filePath) : time();
if ($isCached && $templateModified <= filemtime($cachePath))  {
	$output = file_get_contents($cachePath);
} else {
	$output = compress($filePath, $fileName, $assetType, $this->webroot);
	cacheAsset($cachePath, $output);
}

header("Date: ". date("D, j M Y G:i:s", $templateModified) ." GMT");
header("Content-Type: ". $fileType);
if (Configure::read() == 0) {
	header("Expires: ". gmdate("D, j M Y H:i:s", time() + DAY) ." GMT");
	header("Cache-Control: max-age=86400, must-revalidate"); // HTTP/1.1
	header("Pragma: cache_asset");        // HTTP/1.0
}
print $output; ?>