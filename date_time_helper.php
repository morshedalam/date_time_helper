<?php

/**
 * A DateTime Helper class
 *
 * @package DateTimeHelper
 * @author Morshed Alam <morshed201@gmail.com>
 * @link http://github.com/morshedalam/date_time_helper/
 * @website http://morshed-alam.com
 */
class DateTimeHelper extends DateTime
{
    private $keys = array(
        'y' => array('year', 31104000),
        'm' => array('month', 2592000),
        'd' => array('day', 86400),
        'h' => array('hour', 3600),
        'i' => array('minute', 60)
    );

    /**
     * Class constructor     *
     * @param $time
     * @param String  $zone, timezone
     */
    public function __construct($time = "now", $zone = NULL)
    {
        //Set the time zone as 'Asia/Shanghai' for null
        $zone = $zone ? $zone : 'Asia/Shanghai';
        parent::__construct($time, new DateTimeZone($zone));
    }

    /**
     * Time difference between two dates
     * @param $from
     * @param $to
     * @return Time, difference in the two DateTime objects
     */
    public function timeDifference($from = 'now', $to = NULL)
    {
        $from = new DateTime($from);
        $to = new DateTime($to);
        return $to->diff($from);
    }

    /**
     * Get the time difference as words
     * @param DateTime $from
     * @param DateTime $to
     * @param String $prefix, to add as a prefix
     * @param String $suffix, to add as a suffix
     * @return the time difference as string
     */
    public function timeDiffAsWords($from = NULL, $to = NULL, $prefix = 'about', $suffix = 'ago')
    {
        $words = array();
        $diff_in_seconds = 0;

        $difference = '';
        if ($from) {
            $diffs = $this->timeDifference($from, $to);
            foreach ($diffs as $index => $value) {
                $diff_in_seconds += $value * intval($this->keys[$index][1]);
            }

            if ($diff_in_seconds < 60) { //less than a minute
                $difference = 'less than a minute ' . $suffix;
            } elseif ($diff_in_seconds > 1500 & $diff_in_seconds < 2100) { //25 - 35 minutes
                $difference = $prefix . ' half an hour ' . $suffix;
            } elseif ($diff_in_seconds > 3300 & $diff_in_seconds < 3900) { //55 - 65 minutes
                $difference = $prefix . ' an hour ' . $suffix;
            } else {
                foreach ($this->timeDifference($from, $to) as $index => $value) {
                    $words[] = $this->_stringify($this->keys[$index][0], $value);
                }
                $difference = $prefix . ' ' . implode($words, ' ') . ' ' . $suffix;
            }
        }

        return trim($difference);
    }

    /**
     * Get integer datetime and return details as an array
     * @param int $time to return time details as array
     * @return Array(Year, Month, Day, WeekOfTheMonth, Day Position, Day name)
     */
    function timeToInfo($time)
    {
        $year = intval(date("Y", $time));
        $month = intval(date("m", $time));
        $day = intval(date("d", $time));

        for ($i = 0; $i < 7; $i++) {
            $days[] = date("l", mktime(0, 0, 0, $month, ($i + 1), date("Y", $time)));
        }

        $day_position = array_search(date("l", $time), $days);
        $day_of_month = array_search($days[0], $days) - $day_position;
        $week_of_the_month = (($day + $day_of_month + 6) / 7);

        return array($year, $month, $day, $week_of_the_month, $day_position, $days[$day_position]);
    }

    /**
     * Repeat date of a week
     * @param Date $date
     * @param int $week
     * @return Repeated date after $week week
     */
    function repeatDateByWeek($date, $week = 1)
    {
        $date_time = strtotime($date);
        $date_details = $this->timeToInfo($date_time);

        $key = $week > 0 ? 'next' : 'previous';
        for ($i = 0; $i < abs($week); $i++) {
            $date_time = strtotime("$key $date_details[5]", $date_time);
            $date_details = $this->timeToInfo($date_time);
        }

        return date('Y-m-d', $date_time);
    }

    /**
     * Convert time to string and pluralize
     * @param String $word, ex: hour, minute
     * @param int $value
     * @return pluralized word with string conversion
     */
    private function _stringify($word, $value = 0)
    {
        $str = '';
        if ($word) {
            if ($value == 1) {
                $str = $value . ' ' . $word;
            } elseif ($value > 1) {
                $str = $value . ' ' . $word . 's';
            }
        }

        return $str;
    }

}

?>
