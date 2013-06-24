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
$dHelper = new DateTimeHelper();

echo "<h1>Time difference as Word</h1>";
echo ('2011-03-01 10:00:10 to 2011-03-01 10:00:01 => ').$dHelper->timeDiffAsWords('2011-03-01 10:00:10', '2011-03-01 10:00:01') . "<br />";
echo ('2011-03-01 10:00:10 to 2011-03-01 10:26:10 => ').$dHelper->timeDiffAsWords('2011-03-01 10:00:10', '2011-03-01 10:26:10') . "<br />";
echo ('2011-03-01 10:00:10 to 2011-03-01 11:00:10 => ').$dHelper->timeDiffAsWords('2011-03-01 10:00:10', '2011-03-01 11:00:10') . "<br />";
echo ('2011-03-01 10:00:10 to 2011-03-02 10:00:10 => ').$dHelper->timeDiffAsWords('2011-03-01 10:00:10', '2011-03-02 10:00:10') . "<br />";
echo ('2011-03-01 10:00:10 => ').$dHelper->timeDiffAsWords('2011-03-01 10:00:10') . "<br />";
echo ('2010-03-01 => ').$dHelper->timeDiffAsWords('2010-03-01') . "<br />";
echo ('Nil => ').$dHelper->timeDiffAsWords() . "<br />";

echo "<h1>Time difference as Array</h1>";
print_r($dHelper->timeDifference('2011-03-01 10:00:10', '2011-03-02 10:00:10'));

echo "<h1>Repeated Date</h1>";
echo ('3 weeks advance after 2011-03-01 => ').$dHelper->repeatDateByWeek('2011-03-01', 3) . "<br />";
echo ('3 weeks back before 2011-03-01 => ').$dHelper->repeatDateByWeek('2011-03-01', -3) . "<br />";


?>
