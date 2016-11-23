<?php
/**
 * KNX Api
 *
 * This file is a part of the KNX Api client
 *
 * @package KNX Api
 */
namespace KNX\Api;

class Tag {
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
	 * Get details
	 *
	 * @access public
	 */
	private function get_details() {
		try {
			$details = \KNX\Api\Client\Json::call('tag/getById', [ 'id' => $this->id ]);
		} catch (\Exception $e) {
			throw new \Exception('Tag with ID ' . $this->id . ' does not exist');
		}

		$this->details = $details;
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
	 * @return array $tags
	 */
	public static function get_all() {
		$data = \KNX\Api\Client\Json::call('tag/getAll');
		$tags = [];

		foreach ($data as $details) {
			$tag = new self();
			$tag->id = $details['id'];
			$tag->details = $details;
			$tags[] = $tag;
		}
		return $tags;
	}

	/**
	 * get_by_id
	 *
	 * @access public
	 * @param int $id
	 * @return Tag $tag
	 */
	public static function get_by_id($id) {
		return new self($id);
	}

	/**
	 * Search
	 *
	 * @access public
	 * @param string $search
	 * @return array $tags
	 */
	public static function search($search) {
		$data = \KNX\Api\Client\Json::call('tag/search', [ 'search' => $search ]);
		$tags = [];
		foreach ($data as $details) {
			$tag = new self();
			$tag->details = $details;
			$tag->id = $details['id'];
			$tags[] = $tag;
		}
		return $tags;

	}

}
