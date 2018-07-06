<?php

function password_strength($password, $password_length) {
	$returnVal = true;
	if ( strlen($password) < $password_length ) {
		$returnVal = false;
	}

	if ( !preg_match("#[a-z]+#", $password) ) {
		$returnVal = false;
	}
	if ( !preg_match("#[A-Z]+#", $password) and !preg_match("#[0-9]+#", $password)) {
		$returnVal = false;
	}

	return $returnVal;
}
?>