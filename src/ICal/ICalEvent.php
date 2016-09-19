<?php

namespace ICal;

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
				$var = IcalString::toCamelCase($key);
				$this->{$var} = $value;
			}
		}
	}

	public function toArray() {
		return (array) $this;
	}

	public function toJson($options = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) {
		return json_encode($this, $options);
	}

	public function toICal() {
		$str = "BEGIN:VEVENT\n";
		foreach ($this as $key => $value) {
			$keyEvent = ICalString::fromCamelCase($key);
			$str .= strtoupper($keyEvent) .':' . str_replace("\n", '\n', $value) . "\n";
		}
		$str .= "END:VEVENT";
		return $str;
	}

}
