<?php
// check date
$restrict_date = date('Y-m-d H:i:s', strtotime('-2 months'));
$date1 = new DateTime($from_date);
$date2 = new DateTime($to_date);
$diff = $date1->diff($date2);
$diff_month = ($diff->y * 12) + $diff->m;

if($is_admin == 1){
    $from_date = $from_date;
    $to_date = $to_date;
}else{
    if ($to_date < $restrict_date) {
        $from_date = null;
        $to_date = null;
    } else {
        if ($diff_month >= 2) {
            if ($from_date < $restrict_date) {
                $from_date = $restrict_date;
                $to_date = $to_date;
            } else {
                $from_date = $from_date;
                $to_date = $to_date;
            }

        }else if(date('Y-m-d',strtotime($from_date)) == date('Y-m-d',strtotime($to_date)) || $diff_month <= 1){
            if ($from_date < $restrict_date) {
                $from_date = $restrict_date;
                $to_date = $to_date;
            }else{
                $from_date = $from_date;
                $to_date = $to_date;
            }
        } else {
            $from_date = $restrict_date;
            $to_date = $to_date;
        }
    }
}
// end check date
?>