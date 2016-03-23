<?php

/**
 * Model for all of the timetable data
 *
 * @category Idk
 * @package  Here
 * @author   Us <ye@ye.ye>
 * @license  None fake.link.com
 * @link     Lonk 
 */
/**
 * Timetable class
 *
 * @category Idk
 * @package  Here
 * @author   Us <ye@ye.ye>
 * @license  None fake.link.com
 * @link     Lonk 
 */
class TimeTable extends CI_Model
{
    protected $timeTable = null;

    protected $days = array();
    protected $periods = array();
    protected $courses = array();

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->_load();
    }

    /**
     *  Load in the document data
     *
     * @return null
     */
    function _load()
    {
        $doc = simplexml_load_file(DATAPATH . 'schedule.xml');
        $doc->registerXPathNamespace(
            "xsi", "http://www.w3.org/2001/XMLSchema-instance"
        );

        foreach($doc->days->dayoftheweek as $day)
        {
            $dayoftheweek = array();
            foreach($day->class as $class)
            {
                $booking = new Booking();
                $booking->room = (string) $class->room;
                $booking->time = (string) $class->starttime;
                $booking->instructor = (string) $class->instructor;
                $booking->classType = (string) $class->classtype;
                $booking->course = (string) $class->coursecode;
                $booking->day = (string) $class->day;

                array_push($dayoftheweek, $booking);
            }
            $this->days[(string) $day['day']] = $dayoftheweek;
        }

        foreach($doc->courses->course as $course)
        {
            $tempCourse = array();
            foreach($course->class as $class)
            {
                $booking = new Booking();
                $booking->room = (string) $class->room;
                $booking->time = (string) $class->starttime;
                $booking->instructor = (string) $class->instructor;
                $booking->classType = (string) $class->classtype;
                $booking->course = (string) $class->coursecode;
                $booking->day = (string) $class->day;

                array_push($tempCourse, $booking);
            }
            $this->courses[(string) $course['coursecode']] = $tempCourse;
        }

        foreach($doc->periods->timeslot as $timeslot)
        {
            $tempSlot = array();
            foreach($timeslot->class as $class)
            {
                $booking = new Booking();
                $booking->room = (string) $class->room;
                $booking->time = (string) $class->starttime;
                $booking->instructor = (string) $class->instructor;
                $booking->classType = (string) $class->classtype;
                $booking->course = (string) $class->coursecode;
                $booking->day = (string) $class->day;

                array_push($tempSlot, $booking);
            }
            $this->periods[(string) $timeslot['time']] = $tempSlot;
        }
    }

    /**
     * Gets days
     *
     * @return all of the days
     */
    function getDays()
    {
        return $this->days;
    }

    /**
     * Get keys for the days array
     *
     * @return array of day keys
     */
    function getDayKeys()
    {
        return array_keys($this->days);
    }

    /**
     * Gets periods
     *
     * @return all of the periods
     */
    function getPeriods()
    {
        return $this->periods;
    }

    /**
     * Get keys for the periods array
     *
     * @return array of period keys
     */
    function getPeriodKeys()
    {
        return array_keys($this->periods);
    }
    /**
     * Gets courses
     *
     * @return all of the courses
     */
    function getCourses()
    {
        return $this->courses;
    }
    /**
     * Get keys for the courses array
     *
     * @return array of course keys
     */
    function getCourseKeys()
    {
        return array_keys($this->courses);
    }

    function queryDay($day)
    {
      return $this->days[$day];
    }

    /**
     * Get booking entity for selected course
     */
    function queryCourse($course)
    {
      return $this->courses[$course];
    }

    function queryTime($time)
    {
      return $this->periods[$time];
    }

    function query($day, $time, $course)
    {
        $result = array();
        $dayResult = array();
        $courseResult = array();
        $periodResult = array();

        if ($day !== "void")
            $dayResult = $this->queryDay($day);
        if ($time !== "void")
            $periodResult = $this->queryTime($time);
        if ($course !== "void")
            $courseResult = $this->queryCourse($course);

        array_push($result, $dayResult);
        array_push($result, $periodResult);
        array_push($result, $courseResult);

        return $result;
    }
}
/**
 * Booking class
 *
 * @category Idk
 * @package  Here
 * @author   Us <ye@ye.ye>
 * @license  None fake.link.com
 * @link     Lonk 
 */
class Booking
{
    public $course;
    public $instructor;
    public $classType;
    public $room;
    public $day;
    public $time;
}
