<?php

class TimeTable extends CI_Model
{
  protected $day = null;
  protected $peroid = null;
  protected $class = null;

  protected $days = array();
  protected $periods = array();
  protected $courses = array();

  function __construct()
  {
    parent::__construct();
  }
}
