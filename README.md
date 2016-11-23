# api-client

## Description

This packages allows you to communicate with the KNX API.

## Installation

Installation via composer:

    composer require knx/api-client

## Howto

Set the KNX API key and API url:

    <?php
	\KNX\Api\Config::$key = YOUR_KEY_HERE';
	\KNX\Api\Config::$url = 'http://api.knx.org/';

You are now ready to use the library.
