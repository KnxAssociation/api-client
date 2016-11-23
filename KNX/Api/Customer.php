<?php
/**
 * KNX Api
 *
 * This file is a part of the KNX Api client
 *
 * @package KNX Api
 */
namespace KNX\Api;

class Customer {
	/**
	 * ID
	 *
	 * @access public
	 * @var int $id
	 */
	public $id;

	/**
	 * Details
	 *
	 * @var $details
	 * @access private
	 */
	public $details;

	/**
	 * Contructor
	 *
	 * @access private
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($id = null) {
		if ($id !== null) {
			$this->id = $id;
		}
	}

	/**
	 * Get a field
	 *
	 * @access public
	 * @param string $field
	 * @return mixed
	 */
	public function __get($key) {
		return $this->details[$key];
	}

	/**
	 * Set a field
	 *
	 * @access public
	 * @param string $key
	 * @param mixes value
	 */
	public function __set($key, $value) {
		$this->details[$key] = $value;
	}

	/**
	 * Isset
	 *
	 * @access public
	 * @param string $key
	 * @return bool $isset
	 */
	public function __isset($key) {
		if (isset($this->details[$key])) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get all
	 *
	 * @access public
	 * @param string $username
	 * @return Customer $customer
	 */
	public static function get_by_username($username) {
		$details = \KNX\Api\Client\Json::call('customer/getInfo', [ 'username' => $username ]);

		$customer = new Customer();
		$customer->id = $details['number'];
		$customer->details = $details;
		return $customer;
	}

	/**
	 * Authenticate
	 *
	 * @access public
	 * @param string $username
	 * @param string $password
	 * @return bool $authenticated
	 */
	public static function authenticate($username, $password) {
		$data = [
			'username' => $username,
			'password' => $password
		];
		$authenticated = \KNX\Api\Client\Json::call('customer/authenticate', $data);
		return $authenticated;
	}

}
