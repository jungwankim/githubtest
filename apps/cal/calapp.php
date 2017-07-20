<?php
  session_start();
    if (!isset($_SESSION['user'])) {
        $_SESSION['msg'] = "Log in first";
        header('Location: ../../login.php');
    }
    
class Calendar {
    public $year;
    public $month;
    public $first_day;
    public $number_days;
    
    public function __construct($monthI = null, $yearI = null) {
        $this->year = $yearI;
        $this->month = $monthI;

        if ($yearI == null) {
            $this->year = date('Y');
        }
        if ($monthI == null) {
            $this->month = date('n');
        }
  
        $this->first_day = date('D',mktime(0,0,0,$this->month,1,$this->year));
        $this->number_days = date('t', mktime(0,0,0,$this->month,1,$this->year)); 
    }

    public function getFirstDay() {
        $start = 0;
        switch ($this->first_day) {
        case "Sun":
            $start = 0;
            break;
        case "Mon":
            $start = 1;
            break;
        case "Tue":
            $start = 2;
            break;
        case "Wed":
            $start = 3;
            break;
        case "Thu":
            $start = 4;
            break;
        case "Fri":
            $start = 5;
            break;
        case "Sat":
            $start = 6;
            break;
        default:
            $start = 0;
        }
        return $start;
    }
    
    public function getSeason() {
      if($this->month == 1 or $this->month == 2 or $this->month == 12) {
        return "winter";
      }
      elseif($this->month == 3 or $this->month == 4 or $this->month == 5) {
        return "spring";
      }
      elseif($this->month == 6 or $this->month == 7 or $this->month == 8) {
        return "summer";
      }
      else {
        return "fall";
      }
    }
    
    public function nextMonth() {
      $this->month = $this->month + 1;
      if ($this->month > 12) {
        $this->month = 1;
        $this->year = $this->year + 1;
      }
      $this->first_day = date('D',mktime(0,0,0,$this->month,1,$this->year));
      $this->number_days = date('t', mktime(0,0,0,$this->month,1,$this->year)); 
    }
    public function preMonth() {
      $this->month = $this->month - 1;
      if ($this->month < 1) {
        $this->month = 12;
        $this->year = $this->year - 1;
      }
      $this->first_day = date('D',mktime(0,0,0,$this->month,1,$this->year));
      $this->number_days = date('t', mktime(0,0,0,$this->month,1,$this->year)); 
    }
    
    public function isToday() {
      if($this->year == date('Y') and $this->month == date('n')){
        return 1;
      }
      else {
        return 0;
      }
    }
}

class CalendarView {    
    private $calendar;
    
    public function __construct(Calendar $calendarI){
        $this->calendar = $calendarI;
    }
    
    public function output() {
        echo "<table class = \"calendar\">
                <tr class=\"year\">
                    <th colspan=7 >".$this->calendar->year."</th>
                </tr>
                <tr class=\"month\">
                    <th colspan=7>
                      <form action = \"calendar.php?action=change\" method = \"POST\">
                        <button type = \"submit\" name = \"pre\"><i class=\"material-icons\" style=\"font-size: 50px\">keyboard_arrow_left</i></button>".$this->calendar->month."<button type=\"submit\" name= \"next\"><i class=\"material-icons\" style=\"font-size: 50px\">keyboard_arrow_right</i></button>
                      </form>
                    </th>
                </tr>
                <tr class = \"days\">
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>";
        $iterate = 0;
        $startingday = $this->calendar->getFirstDay();
        $endcondition = ($startingday + $this->calendar->number_days);

        if ($endcondition % 7 == 0){
          $maxiterate = $endcondition;
        }
        else {
         $maxiterate = $endcondition + (7 - ($endcondition % 7));
        }
        while ($iterate < $maxiterate) {
                    $week = $iterate % 7;
                    if ($week == 0 ){
                        echo "<tr class=\"week\">";
                    }
                    if ($iterate < $startingday) {
                        echo "<td> </td>";
                    }
                    elseif ($iterate < $endcondition) {
                      if($week == 6) {
                        echo "<td class = \"sat\">".($iterate-$startingday+1)."</td>";
                      }
                      elseif($week ==0) {
                        echo "<td class = \"sun\">".($iterate-$startingday+1)."</td>";
                      }
                      else {
                        echo "<td>".($iterate-$startingday+1)."</td>";
                      }
                    }
                    else {
                      echo "<td> </td>";
                    }
                    $iterate = $iterate + 1;
                    if($iterate == 7) {
                        echo "</tr>";
                    }
        }
        echo "</table>";
           
    }
    
}


class CalendarController {
    private $calendar;
    
    public function __construct(Calendar $calendar) {
        $this->calendar = $calendar;
    }
    
    public function change($data) {
      if(isset($data['pre'])) {
        $this->calendar->preMonth();
      }
      elseif(isset($data['next'])){
        $this->calendar->nextMonth();
      }
    }
    
    public function today() {
      $this->calendar->month = date('n');
      $this->calendar->year = date("Y");
    }
}


?>
