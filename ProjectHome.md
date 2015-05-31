A Calendar Object for a given month and year.

The calendar Class takes a date string (eg: "December, 2009"), and creates an array of weeks and days for that month.

This allows you to generate your own calendars in HTML or other markup.

There is also other useful properties and methods such as getting locale specific day names, etc.

## Example Usage ##

Get a array representation of the calendar for a given month
```
$cal = new Calendar(); // defaults to current month
$days = $cal->getCalenderMonthDays(); 

var_dump($days); // array of weeks and days

```

Get an array representation of days in particular week
```
$cal = new Calendar('1/1/2009'); // for first month of 2009
$days = $cal->getCalenderWeekDays(3); // week 3

var_dump($days); // array of days for week 3

```

Print a HTML Month calendar
```
$cal = new Calendar('now'); // for this month
$html = $cal->getMonthHTML(); 

echo $html;
```

Print a HTML Week calendar
```
$cal = new Calendar('+1 month'); // next month
$html = $cal->getWeekHTML(2); // week 2

echo $html;
```

## Source ##

The latest [source](http://code.google.com/p/php-calendar-class/source/browse/) can be retrieved from subversion repo.