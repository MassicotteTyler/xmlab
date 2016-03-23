<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
  <head>
  <title>4711 Lab8</title>
  </head>

  <body>
  <form method="post" name="values">
  <table>
  <tr>
    <td>Days</td>
    <td>Courses</td>
    <td>Time</td>
  </tr>
   <tr>
      <td>
        {daydropdown}
      </td>
      <td>
       {coursedropdown}
      </td>
      <td>
       {timeslotdropdown}
      </td>
      <td>
        <input type="submit">
      </td>
   </tr>
  </form>
  <table>
    {resultData}
  </table>
  </body>
</html>

