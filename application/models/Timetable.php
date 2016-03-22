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
     * Gets periods
     *
     * @return all of the periods
     */
    function getPeriods()
    {
        return $this->periods;
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
    public $room;
    public $time;
    public $instructor;
    public $classType;
    public $course;
    public $day;
}