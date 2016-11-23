<?php
/**
 * KNX Api
 *
 * This file is a part of the KNX Api client
 *
 * @package KNX Api
 */
namespace KNX\Api;

class Contact {
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
 	 * Load array
	 *
	 * @access public
	 * @param array $data
	 */
	public function load_array($data) {
		foreach ($data as $key => $value) {
			$this->$key = $value;
		}
	}

	/**
	 * Validate
	 *
	 * @access public
	 * @param array $errors
	 * @return bool $validated
	 */
	public function validate(&$errors) {
		$data = \KNX\Api\Client\Json::call('contact/validate', $this->details);
		$errors = $data['validate_errors'];
		return $data['success'];
	}

	/**
	 * Save
	 *
	 * @access public
	 */
	public function save() {
		$data = \KNX\Api\Client\Json::call('contact/insert', $this->details);
		if (!$data['success']) {
			throw new \Exception('Contact not saved, unvalidated fields: ' . implode(', ', array_keys($data['validate_errors'])));
		}
		$this->id = $data['contact_id'];
	}

}
