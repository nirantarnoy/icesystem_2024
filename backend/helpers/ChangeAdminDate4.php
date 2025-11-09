<?php
// check date
$restrict_date = date('Y-m-d H:i:s', strtotime('-2 months'));
$date1 = new DateTime($from_date_time);
$date2 = new DateTime($to_date_time);
$diff = $date1->diff($date2);
$diff_month = ($diff->y * 12) + $diff->m;
//echo $diff_month;

if($is_admin == 1){
    $from_date_time = $from_date_time;
    $to_date_time = $to_date_time;
}else{
    if ($to_date_time < $restrict_date) {
        $from_date_time = date('Y-m-d H:i:s');
        $to_date_time = date('Y-m-d H:i:s');
    } else {
        if ($diff_month >= 2) {
            if ($from_date_time< $restrict_date) {
                $from_date_time = $restrict_date;
                $to_date_time = $to_date_time;
            } else {
                $from_date_time = $from_date_time;
                $to_date_time = $to_date_time;
            }

        }else if(date('Y-m-d',strtotime($from_date_time)) == date('Y-m-d',strtotime($to_date_time)) || $diff_month <= 1){
            if ($from_date_time < $restrict_date) {
                $from_date_time = $restrict_date;
                $to_date_time = $to_date_time;
            }else{
                $from_date_time = $from_date_time;
                $to_date_time = $to_date_time;
            }
        } else {
            $from_date_time = $restrict_date;
            $to_date_time = $to_date_time;
        }
    }
}
// end check date
?>