<?php

namespace ICal;

class ICalString {

	// Clean a string
	static function cleanString($str) {
		return stripslashes(
			trim(
				htmlspecialchars(
					addslashes(
						html_entity_decode($str)
					)
				)
			)
		);
	}

	// Unconvert a string from camelCase
	static function fromCamelCase($str) {
		return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^-])([A-Z][a-z])/'], '$1-$2', $str));
	}

	// Convert a string to camelCase
	static function toCamelCase($str) {
		return lcfirst(
			str_replace(' ', '', ucwords(
				str_replace('-', ' ', self::fromCamelCase($str))
			))
		);
	}

}
