<?php
/**
 * KNX Api
 *
 * This file is a part of the KNX Api client
 *
 * @package KNX Api
 */
namespace KNX\Api;

class Email {

	/**
	 * Send an email
	 *
	 * @access public
	 * @param string $username
	 * @param string $email_type
	 * @param string $email_from (
	 *		email_default
	 *		email_support
	 *		email_onlinecatalog
	 *		email_app_development
	 *		email_ecampus
	 */
	public static function send($username, $email_type, $from) {
		$data = [
			'username' => $username,
			'email_type_short_name' => $email_type,
			'from' => $from
		];
		$data = \KNX\Api\Client\Json::call('email/send', $data );
		if ($data['success'] !== true) {
			throw new \Exception('Mail could not be sent');
		}
	}
}
