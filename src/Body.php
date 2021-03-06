<?php
namespace phpgt\fetch;

use React\Promise\Promise;
use React\Promise\Deferred;

use StdClass;

/**
 * Represents the body of the response/request, allowing you to declare what
 * its content type is and how it should be handled.
 *
 * Body is implemented by both Request and Response — this provides these
 * objects with an associated body (a byte stream), a used flag (initially
 * unset), and a MIME type (initially the empty byte sequence).
 */
trait Body {

/**
 * Returns a promise that resolves with an ArrayBuffer containing response data.
 */
public function arrayBuffer():Promise {

}

/**
 * Returns a promise that resolves with a Blob representation of response data.
 */
public function blob():Promise {

}

/**
 * Returns a promise that resolves with a FormData response object.
 */
public function formData():Promise {

}

/**
 * Returns a promise that resolves with a StdClass object containing JSON data.
 */
public function json():Promise {
	$deferredJson = new Deferred();
	$promise = $deferredJson->promise();
	$this->readRawBodyDeferredArray []= $deferredJson;
	$this->readRawBodyDeferredTransformArray []= function($data) {
		return json_decode($data);
	};

	return $promise;
}

/**
 * Returns a promise that resolves with a UTF-8 encoded string.
 */
public function text():Promise {
	$deferredText = new Deferred();
	$promise = $deferredText->promise();
	$this->readRawBodyDeferredArray []= $deferredText;
	$this->readRawBodyDeferredTransformArray []= function($data) {
		$charset = $this->getCharset();
		$toEncoding = "utf-8";
		return mb_convert_encoding($data, $toEncoding, $charset);
	};

	return $promise;
}

}#