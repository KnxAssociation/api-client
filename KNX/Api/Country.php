<?php
/**
 * KNX Api
 *
 * This file is a part of the KNX Api client
 *
 * @package KNX Api
 */
namespace KNX\Api;

class Country {
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
		$this->details = \KNX\Api\Client\Json::call('country/getById', [ 'id' => $this->id ]);
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
	 * @return array $countries
	 */
	public static function get_all() {
		$data = \KNX\Api\Client\Json::call('country/getAll');
		$countries = [];
		foreach ($data as $row) {
			$country = new self();
			$country->id = $row['id'];
			$country->details = $row;
			$countries[] = $country;
		}
		return $countries;
	}

	/**
	 * Get grouped
	 *
	 * @access public
	 * @return array $countries
	 */
	public static function get_grouped() {
		$all_countries = self::get_all();

		$countries = [	'european' => [], 'rest' => [] ];
		foreach ($all_countries as $country) {
			if ($country->european_continent) {
				$countries['european'][] = $country;
			} else {
				$countries['rest'][] = $country;
			}
		}

		return $countries;
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
}
