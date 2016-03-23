<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct()
    {
      parent::__construct();
    }
    protected $data = array();
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
      $this->load->helper('url');
      $search = $this->input->post();
      if ($this->input->server('REQUEST_METHOD') == 'POST')
        $this->data['resultData'] = $this->search($search);
      else
        $this->data['resultData'] = '';
      $this->data['daydropdown'] =
        $this->generateDayOptions($this->timetable->getDayKeys(),'Days');
      $this->data['coursedropdown'] =
        $this->generateDayOptions($this->timetable->getCourseKeys(),
          'Course');
      $this->data['timeslotdropdown'] =
        $this->generateDayOptions($this->timetable->getPeriodKeys(),
          'Time');
      $this->parser->parse('home', $this->data);
    }

    public function generateDayOptions($arr, $title)
    {
      $option = '';
      $temp = array();
      foreach ($arr as $value)
        $option .= '<option value="'.$value.'">'.$value.'</option>';
      $temp['options'] = $option;
      $temp['dropTitle'] = $title;
      return $this->parser->parse('daydropdown', $temp, true);
    }
    /**
     * Search stuff
     */
    public function search($arr)
    {
      $this->load->helper('url');
      $cDay = $arr['Days'];
      $cCourse = $arr['Course'];
      $cTime = $arr['Time'];
      $bookings = $this->timetable->queryDay($cDay);
      $table = '';
      $dataRow = '';
      $dataHeader = '<tr>';
      $bool = 0;
      foreach ($bookings as $booking)
      {
        $dataRow.='<tr>';
        foreach($booking as $data => $value)
        {
          if ($bool == 0)
            $dataHeader.='<th>'.$data.'</th>';
          $dataRow.='<td>'.$value.'</td>';
        }
        $dataRow.='</tr>';
        $bool = 1;
      }
      $dataHeader.='</tr>';
      $table.= $dataHeader.$dataRow;
      return $table;
    }
}
