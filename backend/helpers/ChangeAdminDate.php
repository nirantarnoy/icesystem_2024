<?php
//// check date
//$restrict_date = date('Y-m-d H:i', strtotime('-2 months'));
//$date1 = new DateTime($this->from_date);
//$date2 = new DateTime($this->to_date);
//$diff = $date1->diff($date2);
//$diff_month = ($diff->y * 12) + $diff->m;
//
//if($is_admin == 1){
//    $this->from_date = $this->from_date;
//    $this->to_date = $this->to_date;
//}else{
//    if ($this->to_date < $restrict_date) {
//        $this->from_date = null;
//        $this->to_date = null;
//    } else {
//        if ($diff_month >= 2) {
//            if ($this->from_date < $restrict_date) {
//                $this->from_date = $restrict_date;
//                $this->to_date = $this->to_date;
//            } else {
//                $this->from_date = $this->from_date;
//                $this->to_date = $this->to_date;
//            }
//
//        }else if(date('Y-m-d',strtotime($this->from_date)) == date('Y-m-d',strtotime($this->to_date))){
//            $this->from_date = $this->from_date;
//            $this->to_date = $this->to_date;
//        } else {
//            $this->from_date = $restrict_date;
//            $this->to_date = $this->to_date;
//        }
//    }
//}
//// end check date
///
///
///
///
// check date
$restrict_date = date('Y-m-d H:i', strtotime('-2 months'));
$date1 = new DateTime($this->from_date);
$date2 = new DateTime($this->to_date);
$diff = $date1->diff($date2);
$diff_month = ($diff->y * 12) + $diff->m;

if($is_admin == 1){
    $this->from_date = $this->from_date;
    $this->to_date = $this->to_date;
}else{
    if ($this->to_date < $restrict_date) {
        $this->from_date = null;
        $this->to_date = null;
    } else {
        if ($diff_month >= 2) {
            if ($this->from_date < $restrict_date) {
                $this->from_date = $restrict_date;
                $this->to_date = $this->to_date;
            } else {
                $this->from_date = $this->from_date;
                $this->to_date = $this->to_date;
            }

        }else if(date('Y-m-d',strtotime($this->from_date)) == date('Y-m-d',strtotime($this->to_date)) || $diff_month <= 1){
            if ($this->from_date < $restrict_date) {
                $this->from_date = $restrict_date;
                $this->to_date = $this->to_date;
            }else{
                $this->from_date = $this->from_date;
                $this->to_date = $this->to_date;
            }

        }else {
            $this->from_date = $restrict_date;
            $this->to_date = $this->to_date;
        }
    }
}
// end check date
?>