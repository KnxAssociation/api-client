<?php
/**
 * KNX Api
 *
 * This file is a part of the KNX Api client
 *
 * @package KNX Api
 */
namespace KNX\Api;

class Language {

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
		$this->details = \KNX\Api\Client\Json::call('language/getById', [ 'id' => $this->id ]);
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
	 * Get selectable by customer
	 *
	 * @access public
	 */
	public static function get_selectable_by_customer() {
		$languages = self::get_all();
		foreach ($languages as $key => $language) {
			if (!$language->selectable_by_customer) {
				unset($languages[$key]);
			}
		}
		return $languages;
	}

	/**
	 * Get all
	 *
	 * @access public
	 * @return array $countries
	 */
	public static function get_all() {
		$classname = get_called_class();

		$data = \KNX\Api\Client\Json::call('language/getAll');
		$countries = [];
		foreach ($data as $row) {
			$language = new $classname();
			$language->id = $row['id'];
			$language->details = $row;
			$countries[] = $language;
		}
		return $countries;
	}

	/**
	 * get_by_name_short
	 *
	 * @access public
	 * @return KNX\Api\Language $language
	 */
	public static function get_by_name_short($name_short) {
		$languages = self::get_all();
		foreach ($languages as $language) {
			if ($language->name_short == $name_short) {
				return $language;
			}
		}
		throw new \Exception('Language not found');
	}

	/**
	 * Get by id
	 *
	 * @access public
	 * @param int $id
	 */
	public static function get_by_id($id) {
		$classname = get_called_class();
		return new $classname($id);
	}
}
