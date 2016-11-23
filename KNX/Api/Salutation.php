<?php
/**
 * KNX Api
 *
 * This file is a part of the KNX Api client
 *
 * @package KNX Api
 */
namespace KNX\Api;

class Salutation {
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
	 * @return array $salutations
	 */
	public static function get_all() {
		$data = \KNX\Api\Client\Json::call('salutation/getAll');
		$salutations = [];

		foreach ($data as $details) {
			$salutation = new self();
			$salutation->id = $details['id'];
			$salutation->details = $details;
			$salutations[] = $salutation;
		}
		return $salutations;
	}

	/**
	 * get_by_id
	 *
	 * @access public
	 * @param int $id
	 * @return Salutation $salutation
	 */
	public static function get_by_id($id) {
		$data = [
			'id' => $id
		];
		$details = \KNX\Api\Client\Json::call('salutation/getById', $data);
		$salutation = new self();
		$salutation->id = $details['id'];
		$salutation->details = $details;
		return $salutation;
	}

}
