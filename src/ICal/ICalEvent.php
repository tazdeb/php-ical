<?php

namespace ICal;

use ludovicm67\Strings\Strings;

class ICalEvent {

	public $dtstamp;
	public $dtstart;
	public $dtend;
	public $summary;
	public $location;
	public $description;
	public $uid;
	public $created;
	public $lastModified;
	public $sequence;

	public function __construct($init = []) {
		if($init && is_object($init)) {
			$init = (array) $init;
		}
		if($init && is_array($init)) {
			foreach ($init as $key => $value) {
				$var = Strings::toCamelCase($key);
				$this->{$var} = $value;
			}
		}
	}

	public function toArray() {
		return (array) $this;
	}

	public function toJSON($options = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) {
		return json_encode($this, $options);
	}

	public function toICal() {
		$str = "BEGIN:VEVENT\n";
		foreach ($this as $key => $value) {
			$keyEvent = Strings::fromCamelCase($key);
			$str .= strtoupper($keyEvent) .':' . str_replace("\n", '\n', $value) . "\n";
		}
		$str .= "END:VEVENT";
		return $str;
	}

}
