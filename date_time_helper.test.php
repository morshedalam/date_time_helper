<?php

require 'date_time_helper.php';
$dHelper = new DateTimeHelper();

echo $dHelper->timeDiffAsWords('2011-03-01 10:00:10', '2011-03-01 10:00:01') . "<br />";
echo $dHelper->timeDiffAsWords('2011-03-01 10:00:10', '2011-03-01 10:26:10') . "<br />";
echo $dHelper->timeDiffAsWords('2011-03-01 10:00:10', '2011-03-01 11:00:10') . "<br />";
echo $dHelper->timeDiffAsWords('2011-03-01 10:00:10', '2011-03-02 10:00:10') . "<br />";
echo $dHelper->timeDiffAsWords('2011-03-01 10:00:10') . "<br />";
echo $dHelper->timeDiffAsWords('2010-03-01') . "<br />";
echo $dHelper->timeDiffAsWords() . "<br />";

print_r($dHelper->timeDifference('2011-03-01 10:00:10', '2011-03-02 10:00:10'));
?>
