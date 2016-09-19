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

}