<?php

/**
 * Example of uses
 *
 * @package DateTimeHelper
 * @author Morshed Alam <morshed201@gmail.com>
 * @link http://github.com/morshedalam/date_time_helper/
 * @website http://morshed-alam.com
 */

require 'date_time_helper.php';

$dth = new DateTimeHelper();

echo "<h3>Time details</h3>";
echo "<pre>";
print_r($dth->time_details);
print_r($dth->timeToInfo('2013-06-1'));
echo "</pre>";

echo "<h3>Time parts</h3>";
echo "<pre>",
$dth->year(), ', ', $dth->month(), ', ',
$dth->day(), ', ', $dth->hours(), ', ',
$dth->minutes(), ', ', $dth->seconds(), "</pre>";

echo "<h3>Time difference as an array</h3>";
echo "<pre>";
print_r($dth->timeDifference('2011-03-01 10:00:10'));
echo "</pre>";

echo "<h3>Time difference as a string</h3>";
echo "<pre>";
echo $dth->timeDiffAsWords('2011-03-01 10:00:10');
echo "</pre>";

echo "<h3>Repeat date</h3>";
echo "<pre>";

$date = '2011-03-01 10:10:10';
echo $dth->nextRepeatDate($date, -5, 'i') . "[-5i] < " . $date . " > [+5i]" . $dth->nextRepeatDate($date, 5, 'i') . PHP_EOL;
echo $dth->nextRepeatDate($date, -5, 'h') . "[-5h] < " . $date . " > [+5h]" . $dth->nextRepeatDate($date, 5, 'h') . PHP_EOL;
echo $dth->nextRepeatDate($date, -5, 'd') . "[-5d] < " . $date . " > [+5d]" . $dth->nextRepeatDate($date, 5, 'd') . PHP_EOL;
echo $dth->nextRepeatDate($date, -5, 'w') . "[-5w] < " . $date . " > [+5w]" . $dth->nextRepeatDate($date, 5, 'w') . PHP_EOL;
echo $dth->nextRepeatDate($date, -5, 'm') . "[-5m] < " . $date . " > [+5m]" . $dth->nextRepeatDate($date, 5, 'm') . PHP_EOL;
echo $dth->nextRepeatDate($date, -5, 'y') . "[-5y] < " . $date . " > [+5y]" . $dth->nextRepeatDate($date, 5, 'y') . PHP_EOL;

echo "</pre>";