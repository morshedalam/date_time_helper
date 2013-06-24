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
        'w' => array('week', 604800),
        'd' => array('day', 86400),
        'h' => array('hour', 3600),
        'i' => array('minute', 60),
        's' => array('second', 0)
    );

    /**
     * Current DateTime
     * @var Object
     */
    private $now = null;

    /**
     * Time details
     * @var Object
     */
    public $time_details = null;


    /**
     * Class constructor
     * @param $date_time
     * @param String  $zone, timezone
     */
    public function __construct($date_time = "now", $zone = NULL)
    {
        //Set the time zone as 'Asia/Shanghai' for null
        $zone = $zone ? $zone : 'Asia/Shanghai';
        parent::__construct($date_time, new DateTimeZone($zone));

        $this->now = $this->_date($date_time);
        $this->time_details = $this->timeToInfo($date_time);
    }

    /**
     * Get DateTime and return details as an object
     * @param string $date_time
     * @return Object with (Year, Month, Day, WeekOfTheMonth, Day Position, Day name)
     */
    function timeToInfo($date_time = '')
    {
        if ($date_time == '')
            return $this->time_details;

        $time = $this->getTimestamp($date_time);

        $time_details = new stdClass();
        $time_details->y = ($y = intval(date("Y", $time))) ? $y : null;
        $time_details->m = ($m = intval(date("m", $time))) ? $m : null;
        $time_details->d = ($d = intval(date("d", $time))) ? $d : null;
        $time_details->h = ($h = intval(date("h", $time))) ? $h : null;
        $time_details->i = ($i = intval(date("i", $time))) ? $i : null;
        $time_details->s = ($s = intval(date("s", $time))) ? $s : null;
        $time_details->day_position = date('N', $time);
        $time_details->week_of_the_month = ceil(date('j', $time) / 7);

        return $time_details;
    }

    /**
     * Time difference between two dates
     * @param String $from
     * @param String $to
     * @return Time, difference in the two DateTime objects
     */
    public function timeDifference($from = '', $to = '')
    {
        $from = $this->_date($from);
        $to = $this->_date($to);

        return $to->diff($from);
    }

    /**
     * Get the time difference as words
     * @param String $from
     * @param String $to
     * @param String $prefix, to add as a prefix
     * @param String $suffix, to add as a suffix
     * @return the time difference as string
     */
    public function timeDiffAsWords($from = '', $to = '', $prefix = 'about', $suffix = 'ago')
    {
        $words = array();
        $difference = '';
        $diff_in_seconds = 0;

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

                $difference = trim($prefix . ' ' . implode($words, ' ')) . ' ' . $suffix;
            }
        }

        return trim($difference);
    }

    /**
     * Next Repeat date
     *
     * @param String $date
     * @param int $interval
     * @param string $key, repetition type
     * @return Repeated date before/after ($day) day
     */
    public function nextRepeatDate($date = '', $interval = 1, $key = 'm')
    {
        $date = $date ? $date : date('Y-m-d h:i:s');
        $key = $this->keys[$key][0] . 's';

        return date('Y-m-d h:i:s', strtotime("$date $interval $key"));
    }

    /**
     * Repeat date by week
     * For backward compatibility, will be remove from next year
     *
     * @param String $date
     * @param int $week
     * @return Repeated date after/before ($week) week
     */
    function repeatDateByWeek($date, $week = 1)
    {
        $this->nextRepeatDate($date, $week, 'w');
    }

    public function getTimestamp($date = '')
    {
        if ($date == '') {
            return parent::getTimestamp();
        }

        return strtotime($date);
    }

    /**
     * Specific date attribute
     * @param string $date_time
     * @return mixed
     */
    public function year($date_time = '')
    {
        return $this->_datePart('y', $date_time);
    }

    public function month($date_time = '')
    {
        return $this->_datePart('m', $date_time);
    }

    public function day($date_time = '')
    {
        return $this->_datePart('d', $date_time);
    }

    public function hours($date_time = '')
    {
        return $this->_datePart('h', $date_time);
    }

    public function minutes($date_time = '')
    {
        return $this->_datePart('i', $date_time);
    }

    public function seconds($date_time = '')
    {
        return $this->_datePart('s', $date_time);
    }

    private function _datePart($key, $date_time = '')
    {
        if (!$key)
            return null;

        if ($date_time == '') {
            return $this->time_details->$key;
        }

        return date($key, $this->getTimestamp($date_time));
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

    private function _date($date = '')
    {
        return $date == '' ? $this->now : new DateTime($date);
    }

}

?>
