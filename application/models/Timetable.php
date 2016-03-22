<?php

class TimeTable extends CI_Model
{
  protected $timeTable = null;

  protected $days = array();
  protected $periods = array();
  protected $courses = array();

  function __construct()
  {
    parent::__construct();
    $doc = new DOMDocument();
    $doc->load('data/schedule.xml');
  }

  function getDays()
  {
    return $this->days;
  }

  function getPeriods()
  {
    return $this->periods;
  }

  function getCourses()
  {
    return $this->courses;
  }
}
class Booking
{
  public $room;
  public $time;
  public $instructor;
  public $classType;
  public $course;
  public $day;
  public $year;
}
