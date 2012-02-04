<?php

/**
 * A DateTime Helper class
 *
 * @package DateTimeHelper
 * @author Morshed Alam <morshed201@gmail.com>
 * @link http://github.com/morshed-alam/date_time_helper/
 * @website http://morshed-alam.com
 * @version 0.1
 */
class DateTimeHelper extends DateTime {

    private $keys = array(
        'y' => array('year', 31104000),
        'm' => array('month', 2592000),
        'd' => array('day', 86400),
        'h' => array('hour', 3600),
        'i' => array('minute', 60)
    );

    public function __construct($time = "now", $zone = NULL) {
        //Set the time zone as 'Asia/Shanghai' for null
        $zone = $zone ? $zone : 'Asia/Shanghai';
        parent::__construct($time, new DateTimeZone($zone));
    }

    /**
     *  Finds the time difference between two dates
     *  @param from DateTime
     *  @param to DateTime
     *  @return the difference in the two DateTime objects
     */
    public function timeDifference($from, $to = NULL) {
        $from = new DateTime($from);
        $to = new DateTime($to);
        return $to->diff($from);
    }

    /**
     *  Get the time difference as words
     *  @param from DateTime
     *  @param to DateTime
     *  @prefix to String to add as a prefix
     *  @suffix to String to add as a suffix
     *  @return the time difference as string
     */
    public function timeDiffAsWords($from = NULL, $to = NULL, $prefix = 'about', $suffix = 'ago') {
        $words = array();
        $diff_in_seconds = 0;

        $difference = '';
        if ($from) {
            $diffs = $this->timeDifference($from, $to);
            foreach ($diffs as $index => $value) {
                $diff_in_seconds += $value * intval($this->keys[$index][1]);
            }

            if ($diff_in_seconds < 60) { //less than a minute
                $difference = trim($prefix . ' one minute ' . $suffix);
            } elseif ($diff_in_seconds > 1500 & $diff_in_seconds < 2100) { //25 - 35 minutes
                $difference = trim($prefix . ' half an hour ' . $suffix);
            } elseif ($diff_in_seconds > 3300 & $diff_in_seconds < 3900) { //55 - 65 minutes
                $difference = trim($prefix . ' an hour ' . $suffix);
            } else {
                foreach ($this->timeDifference($from, $to) as $index => $value) {
                    $words[] = $this->_stringify($this->keys[$index][0], $value);
                }
                $difference = trim($prefix . ' ' . implode($words, ' ') . ' ' . $suffix);
            }
        }
        return $difference;
    }

    /**
     *  Convert time to string and pluralize
     *  @param word string, ex: hour, minute
     *  @param value int
     *  @return pluralized word with string convertion
     */
    private function _stringify($word, $value = 0) {
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
