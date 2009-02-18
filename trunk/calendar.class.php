<?php

define('LANG_CAL_WEEK', 'week');

/**
 * A Generic Calender Class
 * It Generates an Array of weeks and days as well as other properties of the calendar given month and year
 * 
 * An Example HTML generation is included in function Calendar->getHTML()
 * To get custom HTML, use the Calendar->days property. It is an array of weeks that contains arrays of days
 * 
 * @copyright Creative-Commons 2.0
 * @author gabe@fijiwebdesign.com - Please send me your suggestions
 * @version $Id$
 * 
 * Feel free to use as you wish, if you do show attribution please link to http://www.fijiwebdesign.com/
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
		$this->day_names = $this->_getFullDayNames();
		
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
	 * Generate a HTML display of the calendar month
	 * @return String HTML
	 * @param $header Bool[optional] Show the year and month header
	 * @param $day_names String[optional] Show the day names
	 * @param $day_name_lengh Int[optional] Length of day names
	 */
	function getMonthHTML($header = true, $day_names = true, $day_name_lengh = 3) {
		$days =& $this->getCalenderMonthDays();
		$html[] = '<table class="calendar"><tbody>';
		// print year and month
		if ($header) {
			$html[] = '<tr class="header">';
			$html[] = '<th colspan="7" align="center">'.$this->month_name.' '.$this->year.'</th>';
			$html[] = '</tr>';
		}
		// print the day names
		if ($day_names) {
			$html[] = '<tr class="day_names">';
			for($i = 1; $i <= 7; $i++) {
				$name = $this->getDayName($i, $day_name_lengh);
				$html[] = '<th class="day_name '.$name.'">'.$name.'</th>';
			}
			$html[] = '</tr>';
		}
		// print the calendar days
		foreach($days as $i=>$week) {
			$html[] = '<tr class="week week'.$i.'">';
			foreach($week as $j=>$day) {
				$html[] = '<td class="day '.$day_names[$j%7].'" rel="day'.$j.'">'.$day.'</td>';
			}
			$html[] = '</tr>';
		}
		$html[] = '<tbody></table>';
		return implode("\n", $html);
	}
	
	/**
	 * Generate a HTML display of the calendar week
	 * @return String HTML
	 * @param $week Int The week number
	 * @param $header Bool[optional] Show the year and month header
	 * @param $day_names String[optional] Show the day names
	 * @param $day_name_lengh Int[optional] Length of day names
	 */
	function getWeekHTML($week, $header = true, $day_names = true, $day_name_lengh = 3) {
		$days =& $this->getCalenderWeekDays($week);
		$html[] = '<table class="calendar"><tbody>';
		// print year and month
		if ($header) {
			$html[] = '<tr class="header">';
			$html[] = '<th colspan="7" align="center">'.$this->month_name.' '.$this->year.': '.ucfirst(LANG_CAL_WEEK).' '.$week.'</th>';
			$html[] = '</tr>';
		}
		// print the day names
		if ($day_names) {
			$html[] = '<tr class="day_names">';
			for($i = 1; $i <= 7; $i++) {
				$name = $this->getDayName($i, $day_name_lengh);
				$html[] = '<th class="day_name '.$name.'">'.$name.'</th>';
			}
			$html[] = '</tr>';
		}
		// print the calendar days
		$html[] = '<tr class="week week'.$week.'">';
		foreach($days as $i=>$day) {
			$html[] = '<td class="day '.$day_names[$j%7].'" rel="day'.$j.'">'.$day.'</td>';
		}
		$html[] = '</tr>';
		$html[] = '<tbody></table>';
		return implode("\n", $html);
	}
	
	/**
	 * Returns localized full day names
	 * @private
	 * @author http://keithdevens.com/software/php_calendar/
	 * @return Array
	 */
	function _getFullDayNames() {
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
		return $len ? substr($this->day_names[$i], 0, $len) : $this->day_names[$i];
	}
	
}

?>