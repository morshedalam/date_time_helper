<?php

require_once('simpletest/autorun.php');
require_once('date_time_helper.php');

class TestOfDateTimeHelper extends UnitTestCase {

    private function printTestInfo($func) {
        print ucfirst(preg_replace('/^test /', '',
                                strtolower(preg_replace('/(?<!\ )[A-Z]/', ' $0', $func))
                )) . "<br />";
    }

    function testTimeDifferenceShouldBeZero() {
        $this->printTestInfo(__FUNCTION__);
        $helper = new DateTimeHelper();
        $this->assertEqual($helper->timeDifference(), new DateInterval('PT0S'));
    }

    function testTimeDiffAsWordsShouldBeNull() {
        $this->printTestInfo(__FUNCTION__);
        $helper = new DateTimeHelper();
        $this->assertEqual($helper->timeDiffAsWords(), '');
    }

    function testTimeDiffAsWordsShouldBeLessThanAMinute() {
        $this->printTestInfo(__FUNCTION__);
        $helper = new DateTimeHelper();
        $this->assertEqual($helper->timeDiffAsWords(date('Y-m-d H:i:s')), 'less than a minute ago');
    }

    function testTimeDiffAsWordsShouldBeAboutOneHour() {
        $this->printTestInfo(__FUNCTION__);
        $helper = new DateTimeHelper();
        $this->assertEqual($helper->timeDiffAsWords('2012-02-01 10:00:10', '2012-02-01 11:00:01'), 'about an hour ago');
    }

}

?>