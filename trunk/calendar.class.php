<?php

/**
 * A Generic Calender Class
 * It Generates an Array of weeks and days as well as other properties of the calendar given month and year
 * 
 * An Example HTML generation is included in function fijiCalendar->getHTML()
 * To get custom HTML, use the fijiCalendar->days property. It is an array of weeks that contains arrays of days
 * 
 * @copyright Creative-Commons 2.0
 * @author gabe@fijiwebdesign.com - Please send me your suggestions
 * 
 * Feel free to use as you wish, if you do show attribution please use http://www.fijiwebdesign.com/
 * 
 * Parts based on the following works and subject to their terms:
 * http://scripts.franciscocharrua.com/php-calendar.php
 * http://keithdevens.com/software/php_calendar/
 * 
 */
class Calendar {
	
	/**
	 * Construct
	 * 
	 * @param $month Int Month, eg: January = 1
 	 * @param $year Int Year eg: 2009
	 */
	function Calendar($month, $year) {
		
		$this_month = getDate(mktime(0, 0, 0, $month, 1, $year));
		$next_month = getDate(mktime(0, 0, 0, $month + 1, 1, $year));
		
		// http://scripts.franciscocharrua.com/php-calendar.php
		$this->day = $this_month["mday"];
        $this->month = $this_month["mon"];
        $this->month_name = $this_month["month"];
        $this->year = $this_month["year"];
		$this->first_day_offset = $this_month["wday"];
		$this->days_count = round(($next_month[0] - $this_month[0]) / (60 * 60 * 24));
		$this->days = array();
		
		// fill in days
		$week = 0;
		for($i = 0; $i < $this->days_count+$this->first_day_offset; $i++) {
			
			if ($i < $this->first_day_offset) {
				$this->days[$week][] = null;
			} else {
				$this->days[$week][] = $i-$this->first_day_offset+1;
			}
			
			if ($i%7 == 6) {
				$week++;
			}
		}
		
		// localized day names
		$this->day_names = $this->getFullDayNames();
		
	}
	
	/**
	 * Return the Array representing the calendar days
	 * @return Array
	 */
	function getCalenderMonthDays() {
		return $this->days;
	}
	
	/**
	 * Return the Array representing the days in the given week
	 * @param Int Week number
	 * @return Array
	 */
	function getCalenderWeekDays($week) {
		if (isset($this->days[$week])) {
			return $this->days[$week];
		}
		return false;
	}
	
	/**
	 * Generate a HTML display of the calendar
	 * @return String HTML
	 */
	function getHTML() {
		$days =& $this->getCalenderMonthDays();
		$html[] = '<table class="fiji_calendar"><tbody>';
		foreach($days as $i=>$week) {
			$html[] = '<tr class="week">';
			foreach($week as $j=>$day) {
				$html[] = '<td class="day ">'.$day.'</td>';
			}
			$html[] = '</tr>';
		}
		$html[] = '<tbody></table>';
		return implode("\n", $html);
	}
	
	/**
	 * Returns localized full day names
	 * @author http://keithdevens.com/software/php_calendar/
	 * @return Array
	 */
	function getFullDayNames() {
		$day_names = array();
    	for($n=1,$t=(3+$first_day)*86400; $n<=7; $n++,$t+=86400) {
    		$day_names[$n] = ucfirst(gmstrftime('%A',$t));
    	}
		return $day_names;
	}
	
	/**
	 * Retrieve a Day name given the number starting with Sunday as 1
	 * @return String
	 * @param $i Int
	 */
	function getDayName($i, $len = null) {
		if (!is_array($this->day_names)) {
			$this->day_names = $this->getFullDayNames();
		}
		return $len ? substr($this->day_names[$i], 0, $len) : $this->day_names[$i];
	}
	
}

?>