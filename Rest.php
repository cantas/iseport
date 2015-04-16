<?php

/*!
 * REST client (PHP)
 * Copyright (c) 2013 Eric Johnson
 * Version 0.5 
 * Licensed under the MIT license
 * http://ericjohnson.me
 * Requires: PHP 5.3.x or later
 */

class Rest {
	public  $url         = null;   // The current URL
	public  $http        = null;   // Container for the latest HTTP request info
	public  $type        = 'xml'; // Default content type for data transmission
	private $baseUrl     = '';     // The base URL for the request
	private $curl        = null;   // The cURL object
	private $validTypes  = array( 'json' => 'application/vnd.com.cisco.ise.identity.portal.2.0+xml', 'xml' => 'application/vnd.com.cisco.ise.identity.portal.1.0+xml' );
	private $preventHttp = true;   // Control variable to automatically prevent HTTP basic auth over port 80

	/* Constructor */
	public function __construct( $user, $pass, $baseUrl, $type = 'json', $preventHttp = true ) {

		// Set the base URL for the API
		if( $baseUrl ) $this->baseUrl = $baseUrl;

		// Fail if our control variable prevents http requests
		if( $preventHttp == false ) $this->preventHttp = $preventHttp;
		if( $this->preventHttp ):
			if( mb_eregi( 'http:(.*)', $this->baseUrl ) ):
				throw new Exception('Basic Authentication over HTTP is not allowed to protect your credentials. Override this behavior by changing the $preventHTTP property for testing.');
			endif;
		endif;
		
		// If a type variable is passed, make sure it's within bounds
		if( in_array($type, $this->validTypes ) ) $this->type = $type;

		// Initialize the cURL resource
		$this->curl = curl_init();

		// Set some global cURL options
		curl_setopt_array($this->curl, array(
			CURLOPT_USERPWD        => $user . ':' . $pass,
			CURLOPT_FOLLOWLOCATION => true, // Follow redirects
			CURLOPT_HTTPHEADER     => array('Accept: application/vnd.com.cisco.ise.identity.portal.2.0+xml'), // Set the type
			CURLOPT_RETURNTRANSFER => true, // Return response to variable
			CURLOPT_SSL_VERIFYPEER => false // Ease SSL connections
		));
	}

	/* REST Method-based calls */

	// GET - used for retrieving data from the server
	public function get( $path = null, $params = null ) {
		return $this->call( 'GET', $path, $params );
	}

	// POST - Used for complex operations
	public function post( $path, $params, $data ) {
		return $this->call( 'POST', $path, $params, $data );
	}

	// PUT - Used for idempotent writes (operations that change...
	// ... the server state only once, regardless of repetition)
	public function put( $path, $params, $data ) {
		return $this->call( 'PUT', $path, $params, $data );
	}

	// DELETE - Remove data from the server
	public function delete( $path = null, $params = null ) {
		return $this->call( 'DELETE', $path, $params );
	}

	/* Perform the cURL request */
	private function call( $method, $path, $params, $data = null ) {

		$this->url = $this->baseUrl . $path;

		if( gettype($params) == 'object' ):
			$this->url .= '?' . $this->formatParams($params);
		endif;

		// Set the full URL for the request
		curl_setopt($this->curl, CURLOPT_URL, $this->url );

		switch( $method ):
			case 'GET':
				curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
				break;
			case 'POST':
				curl_setopt_array($this->curl, array(
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS    => json_encode($data)
				));
				break;
			case 'PUT':
				curl_setopt_array($this->curl, array(
					CURLOPT_CUSTOMREQUEST => 'PUT',
					CURLOPT_POSTFIELDS    => json_encode($data)
				));
				break;
			case 'DELETE':
				curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
		endswitch;

		// Execute the request
		$this->http = new StdClass;
		$this->http->response = curl_exec($this->curl);
		$this->http->code     = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
		$this->http->time     = curl_getinfo($this->curl, CURLINFO_TOTAL_TIME);
		$this->http->error    = curl_error($this->curl);

		// Handle specific HTTP errors
		switch( $this->http->code ):
			case 0:
				trigger_error('Server returned error 0 ' . $this->http->error );
			case 401:
				trigger_error('Server returned error 401 Unauthorized: ' . $this->url);
				return false;
				break;
			case 403:
				trigger_error('Server returned error 403 Forbidden: ' . $this->url);
				return false;
				break;
			case 404:
				trigger_error('Server returned error 404 Not found: ' . $this->url);
				return false;
				break;
		endswitch;

		// Handle general HTTP errors
		if( $this->http->code > 400 ) {
			trigger_error('Server returned error ' . $this->http->code . ': ' . $this->url);
			return false;
		}

		// Handle the response based on type
		switch( $this->type ):
			case 'json':
				// Try to parse the response
				if( $json = json_decode($this->http->response) ):
					return $json;
				else:
					trigger_error('The response from the server was not valid JSON');
					return $this->http->response;
				endif;
				break;
			case 'xml':
				// Parse any XML server errors
				if( $xml = simplexml_load_string($this->http->response, null, LIBXML_NOERROR) ):
					return $xml;
				else:
					trigger_error('The response from the server was not valid XML');
					return $this->http->response;
				endif;
		endswitch;

	}

	/* Helper functions */

	// Build a valid query string
	public function formatParams( $params ) {
		if( gettype($params) != 'object' ):
			throw new Exception('Params must be an object');
		else:
			$pairs = array();
			foreach( $params as $name => $value ):
				$pair = urlencode($name);
				if( $value != '' ) $pair .= '=' . urlencode($value);
				$pairs[] = $pair;
			endforeach;
			$str =  implode('&', $pairs);
		endif;

		return $str;
	}

	/* Destructor */
	public function __destruct() {
		// Destroy the cURL object
		curl_close($this->curl);
	}
}