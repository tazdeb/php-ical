<?php

namespace ICal;

class ICalParser {

	private $calendarFile = null;
	private $calendarContent = null;

	// Constructor
	public function __construct($file = null) {
		if ($file) $this->calendarFile = $file;
	}

	// Read the content of a file
	private function readFile($url) {
		$file = @file_get_contents($url);
		if ($file) return $file;
		else {
			$file = @file_get_contents($url);
			if ($file) return $file;
			else return null;
		}
	}


	// Parse calendar file
	private function parseContent($content) {
		$r = [];
		preg_match_all('/(?<=BEGIN:VEVENT).*?(?=END:VEVENT)/s', $content, $out);

		foreach ($out[0] as $event) {

			$eventText = preg_replace('/((\r?\n)|(\r\n?)) /', '', ICalString::cleanString($event));
			$e = [];

			foreach (preg_split("/((\r?\n)|(\r\n?))/s", $eventText) as $line) {

				if (preg_match('/^[a-zA-Z]/', $line)) {
					$parseLine = explode(':', $line);
					$key = ICalString::toCamelCase(ICalString::cleanString($parseLine[0]));
					unset($parseLine[0]);
					$val = implode(':', $parseLine);
					$val = str_replace('\n', "\n", $val);
					$e["$key"] = $val;
				}

			}

			$r[] = new ICalEvent($e);
		}

		return $r;
	}

	// set content
	public function setContent($content) {
		$this->calendarContent = $content;
	}


	// Get an array of all events
	public function getEvents() {
		if (!$this->calendarContent && $this->calendarFile) {
			$this->calendarContent = $this->readFile($this->calendarFile);
		}

		if ($this->calendarContent) {
			return $this->parseContent($this->calendarContent);
		} else {
			return [];
		}
	}

}
