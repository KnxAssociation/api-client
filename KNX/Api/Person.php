<?php
/**
 * KNX Api
 *
 * This file is a part of the KNX Api client
 *
 * @package KNX Api
 */
namespace KNX\Api;

class Person {
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
			$this->get_details();
		}
	}

	/**
	 * Get the details via Soap
	 *
	 * @access private
	 */
	private function get_details() {
		$this->details = \KNX\Api\Client\Json::call('person/getById', [ 'id' => $this->id ]);
	}

	/**
	 * Get a field
	 *
	 * @access public
	 * @param string $field
	 * @return mixed
	 */
	public function __get($key) {
		if ($key == 'salutation') {
			return \KNX\Api\Salutation::get_by_id($this->salutation_id);
		} elseif ($key == 'language') {
			$interface = \Skeleton\I18n\Config::$language_interface;
			return $interface::get_by_id($this->language_id);
		} else {
			return $this->details[$key];
		}
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
		if ($key == 'salutation') {
			return true;
		} elseif ($key == 'language') {
			return true;
		} elseif (isset($this->details[$key])) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get by id
	 *
	 * @access public
	 * @param int $id
	 */
	public static function get_by_id($id) {
		return new self($id);
	}

	/**
	 * Get by email
	 *
	 * @access public
	 * @param String $email
	 */
	public static function get_by_email($email) {
		$person = \KNX\Api\Client\Json::call('person/getByEmail', [ 'email' => $email ]);
		return new self($person['id']);
	}
}
