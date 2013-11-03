<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace calendartype_jalali;
use core_calendar\type_base;

/**
 * Handles calendar functions for the jalali calendar.
 *
 * @package calendartype_jalali
 * @copyright 2008 onwards Foodle Group {@link http://foodle.org}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class structure extends type_base {

    /** @var array number of days each Gregorian month would have in a non-leap year */
    private $gdaysinmonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    /** @var array number of days each Jalali month would have in a non-leap year */
    private $jdaysinmonth = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

    /**
     * Returns the name of the calendar.
     *
     * This is the non-translated name, usually just
     * the name of the folder.
     *
     * @return string the calendar name
     */
    public function get_name() {
        return 'jalali';
    }

    /**
     * Returns a list of all the possible days for all months.
     *
     * This is used to generate the select box for the days
     * in the date selector elements. Some months contain more days
     * than others so this function should return all possible days as
     * we can not predict what month will be chosen (the user
     * may have JS turned off and we need to support this situation in
     * Moodle).
     *
     * @return array the days
     */
    public function get_days() {
        $days = array();

        for ($i = 1; $i <= 31; $i++) {
            $days[$i] = $i;
        }

        return $days;
    }

    /**
     * Returns a list of all the names of the months.
     *
     * @return array the month names
     */
    public function get_months() {
        $months = array();

        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = get_string('month' . $i, 'calendartype_jalali');
        }

        return $months;
    }

    /**
     * Returns the minimum year for the calendar.
     *
     * @return int The minimum year
     */
    public function get_min_year() {
        return 1278;
    }

    /**
     * Returns the maximum year for the calendar.
     *
     * @return int The maximum year
     */
    public function get_max_year() {
        return 1429;
    }

    /**
     * Returns an array of years.
     *
     * @param int $minyear
     * @param int $maxyear
     * @return array the years
     */
    public function get_years($minyear = null, $maxyear = null) {
        if (is_null($minyear)) {
            $minyear = $this->get_min_year();
        }

        if (is_null($maxyear)) {
            $maxyear = $this->get_max_year();
        }

        $years = array();
        for ($i = $minyear; $i <= $maxyear; $i++) {
            $years[$i] = $i;
        }

        return $years;
    }

    /**
     * Returns a multidimensional array with information for day, month, year
     * and the order they are displayed when selecting a date.
     * The order in the array will be the order displayed when selecting a date.
     * Override this function to change the date selector order.
     *
     * @param int $minyear The year to start with
     * @param int $maxyear The year to finish with
     * @return array Full date information
     */
    public function get_date_order($minyear = null, $maxyear = null) {
        $dateinfo = array();
        $dateinfo['day'] = $this->get_days();
        $dateinfo['month'] = $this->get_months();
        $dateinfo['year'] = $this->get_years($minyear, $maxyear);

        return $dateinfo;
    }

    /**
     * Returns the number of days in a week.
     *
     * @return int the number of days
     */
    public function get_num_weekdays() {
        return 7;
    }

    /**
     * Returns an indexed list of all the names of the weekdays.
     *
     * The list starts with the index 0. Each index, representing a
     * day, must be an array that contains the indexes 'shortname'
     * and 'fullname'.
     *
     * @return array array of days
     */
    public function get_weekdays() {
        return array(
            0 => array(
                'shortname' => get_string('wday0', 'calendartype_jalali'),
                'fullname' => get_string('weekday0', 'calendartype_jalali')
            ),
            1 => array(
                'shortname' => get_string('wday1', 'calendartype_jalali'),
                'fullname' => get_string('weekday1', 'calendartype_jalali')
            ),
            2 => array(
                'shortname' => get_string('wday2', 'calendartype_jalali'),
                'fullname' => get_string('weekday2', 'calendartype_jalali')
            ),
            3 => array(
                'shortname' => get_string('wday3', 'calendartype_jalali'),
                'fullname' => get_string('weekday3', 'calendartype_jalali')
            ),
            4 => array(
                'shortname' => get_string('wday4', 'calendartype_jalali'),
                'fullname' => get_string('weekday4', 'calendartype_jalali')
            ),
            5 => array(
                'shortname' => get_string('wday5', 'calendartype_jalali'),
                'fullname' => get_string('weekday5', 'calendartype_jalali')
            ),
            6 => array(
                'shortname' => get_string('wday6', 'calendartype_jalali'),
                'fullname' => get_string('weekday6', 'calendartype_jalali')
            ),
        );
    }

    /**
     * Returns the index of the starting week day.
     *
     * This may vary, for example some may consider Monday as the start of the week,
     * where as others may consider Sunday the start.
     *
     * @return int
     */
    public function get_starting_weekday() {
        global $CFG;

        if (isset($CFG->calendar_startwday)) {
            $firstday = $CFG->calendar_startwday;
        } else {
            $firstday = get_string('firstdayofweek', 'langconfig');
        }

        if (!is_numeric($firstday)) {
            $startingweekday = 6; // saturday
        } else {
            $startingweekday = intval($firstday) % 7;
        }

        return get_user_preferences('calendar_startwday', $startingweekday);
    }

    /**
     * Returns the index of the weekday for a specific calendar date.
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @return int
     */
    public function get_weekday($year, $month, $day) {
        $gdate = $this->convert_to_gregorian($year, $month, $day);
        return intval(date('w', mktime(12, 0, 0, $gdate['month'], $gdate['day'], $gdate['year'])));
    }

    /**
     * Returns the number of days in a given month.
     *
     * @param int $year
     * @param int $month
     * @return int the number of days
     */
    public function get_num_days_in_month($year, $month) {
        if ($month <= 6)
            return 31;
        elseif ($month != 12 or $this->isleap_solar($year))
            return 30;

        return 29;    // $month is 12 and $year is a leap year
    }

    /**
     * Get the previous month.
     *
     * If the current month is Farvardin, it will get the last month of the previous year.
     *
     * @param int $year
     * @param int $month
     * @return array previous month and year
     */
    public function get_prev_month($year, $month) {
        if ($month == 1) {
            return array(12, $year - 1);
        } else {
            return array($month - 1, $year);
        }
    }

    /**
     * Get the next month.
     *
     * If the current month is Esfand, it will get the first month of the following year.
     *
     * @param int $year
     * @param int $month
     * @return array the following month and year
     */
    public function get_next_month($year, $month) {
        if ($month == 12) {
            return array(1, $year + 1);
        } else {
            return array($month + 1, $year);
        }
    }

    /**
     * Returns a formatted string that represents a date in user time.
     *
     * Returns a formatted string that represents a date in user time
     * <b>WARNING: note that the format is for strftime(), not date().</b>
     * Because of a bug in most Windows time libraries, we can't use
     * the nicer %e, so we have to use %d which has leading zeroes.
     * A lot of the fuss in the function is just getting rid of these leading
     * zeroes as efficiently as possible.
     *
     * If parameter fixday = true (default), then take off leading
     * zero from %d, else maintain it.
     *
     * @param int $time the timestamp in UTC, as obtained from the database
     * @param string $format strftime format
     * @param int|float|string $timezone the timezone to use
     *        {@link http://docs.moodle.org/dev/Time_API#Timezone}
     * @param bool $fixday if true then the leading zero from %d is removed,
     *        if false then the leading zero is maintained
     * @param bool $fixhour if true then the leading zero from %I is removed,
     *        if false then the leading zero is maintained
     * @return string the formatted date/time
     */
    public function timestamp_to_date_string($time, $format, $timezone, $fixday, $fixhour) {
        global $CFG;

        $amstring = get_string('am', 'calendartype_jalali');
        $pmstring = get_string('pm', 'calendartype_jalali');
        $AMstring = get_string('am_caps', 'calendartype_jalali');
        $PMstring = get_string('pm_caps', 'calendartype_jalali');

        if (empty($format)) {
            $format = get_string('strftimedaydatetime', 'langconfig');
        }

        if (!empty($CFG->nofixday)) {  // Config.php can force %d not to be fixed.
            $fixday = false;
        }

        $jdate = $this->timestamp_to_date_array($time, $timezone);
        //this is not sufficient code, change it. but it works correctly.
        $format = str_replace( array(
            '%a',
            '%A',
            '%b',
            '%B',
            '%d',
            '%m',
            '%y',
            '%Y',
            '%p',
            '%P'
        ), array($jdate['weekday'],
            $jdate['weekday'],
            $jdate['month'],
            $jdate['month'],
            (($jdate['mday'] < 10 && !$fixday) ? '0' : '') . $jdate['mday'],
            ($jdate['mon'] < 10 ? '0' : '') . $jdate['mon'],
            $jdate['year'] % 100,
            $jdate['year'],
            ($jdate['hours'] < 12 ? $AMstring : $PMstring),
            ($jdate['hours'] < 12 ? $amstring : $pmstring)
            ), $format);

        $gregoriancalendar = \core_calendar\type_factory::get_calendar_instance('gregorian');
        return $gregoriancalendar->timestamp_to_date_string($time, $format, $timezone, $fixday, $fixhour);
    }

    /**
     * Given a $time timestamp in GMT (seconds since epoch), returns an array that
     * represents the date in user time.
     *
     * @param int $time Timestamp in GMT
     * @param float|int|string $timezone offset's time with timezone, if float and not 99, then no
     *        dst offset is applied {@link http://docs.moodle.org/dev/Time_API#Timezone}
     * @return array an array that represents the date in user time
     */
    public function timestamp_to_date_array($time, $timezone = 99) {
        $gregoriancalendar = \core_calendar\type_factory::get_calendar_instance('gregorian');

        $date = $gregoriancalendar->timestamp_to_date_array($time, $timezone);
        $jdate = $this->convert_from_gregorian($date['year'], $date['mon'], $date['mday']);

        $date['month'] = get_string("month{$jdate['month']}", 'calendartype_jalali');
        $date['weekday'] = get_string("weekday{$date['wday']}", 'calendartype_jalali');
        $date['yday'] = ( ($jdate['month'] > 6 ? 6 : $jdate['month'] -1) + ($jdate['month']-1) * 30) + $jdate['day'];
        $date['year'] = $jdate['year'];
        $date['mon'] = $jdate['month'];
        $date['mday'] = $jdate['day'];

        return $date;
    }

    /**
     * Provided with a day, month, year, hour and minute in Gregorian
     * convert it into the equivalent Jalali date.
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @param int $hour
     * @param int $minute
     * @return array the converted date
     */
    public function convert_from_gregorian($year, $month, $day, $hour = 0, $minute = 0) {
        $gy = $year - 1600;
        $gm = $month - 1;
        $gd = $day - 1;

        $g_day_no = 365*$gy+$this->div($gy+3,4)-$this->div($gy+99,100)+$this->div($gy+399,400);

        for ($i=0; $i < $gm; ++$i) {
            $g_day_no += $this->gdaysinmonth[$i];
        }
        if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0))) {
            /* leap and after Feb */
            ++$g_day_no;
        }
        $g_day_no += $gd;
        
        $j_day_no = $g_day_no-79;

        $j_np = $this->div($j_day_no, 12053);
        $j_day_no %= 12053;

        $jy = 979+33*$j_np+4*$this->div($j_day_no,1461);

        $j_day_no %= 1461;

        if ($j_day_no >= 366) {
            $jy += $this->div($j_day_no-1, 365);
            $j_day_no = ($j_day_no-1)%365;
        }

        for ($i = 0; $i < 11 && $j_day_no >= $this->jdaysinmonth[$i]; ++$i) {
          $j_day_no -= $this->jdaysinmonth[$i];
        }
        $jm = $i+1;
        $jd = $j_day_no+1;

        $date = array();
        $date['year'] = $jy;
        $date['month'] = $jm;
        $date['day'] = $jd;
        $date['hour'] = $hour;
        $date['minute'] = $minute;

        return $date;
    }

    /**
     * Provided with a day, month, year, hour and minute in Jalali
     * convert it into the equivalent Gregorian date.
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @param int $hour
     * @param int $minute
     * @return array the converted date
     */
    public function convert_to_gregorian($year, $month, $day, $hour = 0, $minute = 0) {
        $jy = $year-979;
        $jm = $month-1;
        $jd = $day-1;

        $j_day_no = 365*$jy + $this->div($jy, 33)*8 + $this->div($jy%33+3, 4);
        for ($i=0; $i < $jm; ++$i)
            $j_day_no += $this->jdaysinmonth[$i];

        $j_day_no += $jd;

        $g_day_no = $j_day_no+79;

        $gy = 1600 + 400*$this->div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
        $g_day_no = $g_day_no % 146097;

        $leap = true;
        if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
        {
            $g_day_no--;
            $gy += 100*$this->div($g_day_no,  36524); /* 36524 = 365*100 + 100/4 - 100/100 */
            $g_day_no = $g_day_no % 36524;

            if ($g_day_no >= 365)
                $g_day_no++;
            else
                $leap = false;
        }

        $gy += 4*$this->div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */
        $g_day_no %= 1461;

        if ($g_day_no >= 366) {
            $leap = false;

            $g_day_no--;
            $gy += $this->div($g_day_no, 365);
            $g_day_no = $g_day_no % 365;
        }

        for ($i = 0; $g_day_no >= $this->gdaysinmonth[$i] + ($i == 1 && $leap); $i++)
            $g_day_no -= $this->gdaysinmonth[$i] + ($i == 1 && $leap);
        $gm = $i+1;
        $gd = $g_day_no+1;

        $date = array();
        $date['year'] = $gy;
        $date['month'] = $gm;
        $date['day'] = $gd;
        $date['hour'] = $hour;
        $date['minute'] = $minute;

        return $date;
    }

    /**
     * This return locale for windows os.
     *
     * @return string locale
     */
    public function locale_win_charset() {
        return 'utf-8';
    }

    private function isleap_solar($year) {
        /* 33-year cycles, it better matches Iranian rules */
        return (($year+16)%33+33)%33*8%33 < 8;
    }

    private function div($a,$b) {
        return (int) ($a / $b);
    }
}
