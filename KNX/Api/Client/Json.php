<?php
/**
 * KNX Api
 *
 * This file is a part of the KNX Api client
 *
 * @package KNX Api
 */
namespace KNX\Api\Client;

class Json {

	/**
	 * Call
	 *
	 * @access public
	 * @param string $method
	 * @param array $variables
	 * @return array $data
	 */
	public static function call($method, $variables = []) {
		list($module, $method) = explode('/', $method);

		$key = \KNX\Api\Config::$key;
		$url = \KNX\Api\Config::$url;

		$variables['api_key'] = $key;

		if (substr($url, -1) == '/') {
			$url = substr($url, 0, -1);
		}

		$return = @file_get_contents($url . '/call/' . $module . '?call=' . $method . '&' . http_build_query($variables));

		if ($return === false) {
			echo $url . '/call/' . $module . '?call=' . $method . '&' . http_build_query($variables);
			throw new \Exception('Problem when calling ' . $module . '/' . $method);
		}
		return json_decode($return, true);
	}
}
