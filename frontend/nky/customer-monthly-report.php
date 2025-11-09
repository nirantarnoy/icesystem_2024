<?php

use yii\helpers\Html;

$this->title = "รายงานยอดขายรายเดือน $year";

$month_data = [['id'=>1,'name'=>'ม.ค.'],['id'=>2,'name'=>'ก.พ.'],['id'=>3,'name'=>'มี.ค.'],['id'=>4,'name'=>'เม.ย.'],['id'=>5,'name'=>'พ.ค.'],['id'=>6,'name'=>'มิ.ย.'],['id'=>7,'name'=>'ก.ค.'],['id'=>8,'name'=>'ส.ค.'],['id'=>9,'name'=>'ก.ย.'],['id'=>10,'name'=>'ต.ค.'],['id'=>11,'name'=>'พ.ย.'],['id'=>12,'name'=>'ธ.ค.']]
?>
<form action="<?= \yii\helpers\Url::to(['adminreport/customer-monthly-report'], true) ?>" method="post">
    <div class="row">
        <div class="col-lg-3">
            <?php
            echo \kartik\select2\Select2::widget([
                'name' => 'route_id',
                'value' => $route_id,
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveryroute::find()->where(['status' => 1, 'branch_id' => 1])->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => 'เลือกสายส่ง'
                ],
                'pluginOptions' => ['allowClear' => true, 'multiple' => true,],]);
            ?>
        </div>
        <div class="col-lg-2">
            <?php
            echo \kartik\select2\Select2::widget([
                'name' => 'customer_group_id',
                'value' => $customer_group_id,
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customergroup::find()->where(['status' => 1])->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => 'เลือกกลุ่มลูกค้า'
                ],'pluginOptions' => ['allowClear' => true, 'multiple' => true,],]);
            ?>
        </div>
        <div class="col-lg-2">
            <?php
            echo \kartik\select2\Select2::widget([
                'name' => 'from_month',
                'value' => $from_month,
                'data' => \yii\helpers\ArrayHelper::map($month_data, 'id', 'name'),
                'options' => [
                    'placeholder' => 'เลือกเริ่มเดือน'
                ],'pluginOptions' => ['allowClear' => true, 'multiple' => false,],]);
            ?>
        </div>
        <div class="col-lg-2">
            <?php
            echo \kartik\select2\Select2::widget([
                'name' => 'to_month',
                'value' => $to_month,
                'data' => \yii\helpers\ArrayHelper::map($month_data, 'id', 'name'),
                'options' => [
                    'placeholder' => 'เลือกเดือนสิ้นสุด'
                ],'pluginOptions' => ['allowClear' => true, 'multiple' => false,],]);
            ?>
        </div>
        <div class="col-lg-3">
            <button class="btn btn-sm btn-primary">
                <i class="fa fa-search"></i> ค้นหา
            </button>
        </div>
    </div>
</form>

<br/>
<?php
$c_month = date('m');
?>
<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
    <thead>
    <tr>
        <td style="text-align: center;">#</td>
        <td style="text-align: center;">รหัส</td>
        <td>ลูกค้า</td>
        <td style="text-align: center;">สายส่ง</td>
        <?php if ($c_month >= 1): ?>
            <td style="text-align: center;">ม.ค.</td>
        <?php endif; ?>
        <?php if ($c_month >= 2): ?>
            <td style="text-align: center;">ก.พ.</td>
        <?php endif; ?>
        <?php if ($c_month >= 3): ?>
            <td style="text-align: center;">มี.ค.</td>
        <?php endif; ?>
        <?php if ($c_month >= 4): ?>
            <td style="text-align: center;">เม.ย.</td>
        <?php endif; ?>
        <?php if ($c_month >= 5): ?>
            <td style="text-align: center;">พ.ค.</td>
        <?php endif; ?>
        <?php if ($c_month >= 6): ?>
            <td style="text-align: center;">มิ.ย.</td>
        <?php endif; ?>
        <?php if ($c_month >= 7): ?>
            <td style="text-align: center;">ก.ค.</td>
        <?php endif; ?>
        <?php if ($c_month >= 8): ?>
            <td style="text-align: center;">ส.ค.</td>
        <?php endif; ?>
        <?php if ($c_month >= 9): ?>
            <td style="text-align: center;">ก.ย.</td>
        <?php endif; ?>
        <?php if ($c_month >= 10): ?>
            <td style="text-align: center;">ต.ค.</td>
        <?php endif; ?>
        <?php if ($c_month >= 11): ?>
            <td style="text-align: center;">พ.ย.</td>
        <?php endif; ?>
        <?php if ($c_month >= 12): ?>
            <td style="text-align: center;">ธ.ค.</td>
        <?php endif; ?>
        <td style="text-align: center;">คาดว่า</td>
        <td style="text-align: center;">ประเภท</td>
        <td style="text-align: center;">ส่วนต่าง</td>
        <!--        <th>รวม</th>-->
    </tr>
    </thead>
    <tbody>
    <?php
    $c_month = date('n'); // เดือนปัจจุบัน (1-12)
    $c_day = date('j'); // วันที่ปัจจุบัน (1-31)
    $c_year = date('Y'); // ปีปัจจุบัน
    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $c_month, $c_year);
    ?>
    <?php foreach ($data as $key => $row): ?>
        <?php
        $expect_amount = 0;
        $before_current_month_amount = 0;
        $diff_amonth = 0;

        // หาชื่อ column เดือน เช่น Jan, Feb, ...
        $month_map = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];

        // คอลัมน์ยอดขายของเดือนปัจจุบัน
        $current_month_name = $month_map[$c_month];
        $current_amount = isset($row[$current_month_name]) ? $row[$current_month_name] : 0;

        //เดือนก่อนหน้า 1 เดือน
        $current_month_name_before = $month_map[(int)$c_month - 1];
        $current_month_before_amount = isset($row[$current_month_name_before]) ? $row[$current_month_name_before] : 0;

        //เดือนก่อนหน้า 2 เดือน
        $current_month_name_before2 = $month_map[(int)$c_month - 2];
        $current_month_before_amount2 = isset($row[$current_month_name_before2]) ? $row[$current_month_name_before2] : 0;

        // ถ้าเป็นเดือนปัจจุบัน → คำนวณ Projection
        if ($current_amount > 0) {
            $expect_amount = ($current_amount / $c_day) * $days_in_month;
        }
        $line_diff_amount = $current_month_before_amount - $expect_amount;

        $customer_type_name = '';
        if ($expect_amount > 0 && $current_month_before_amount > 0 && $line_diff_amount > 0) {
            $customer_type_name = 'ลูกค้าประจำ (+)';
        } else if ($expect_amount > 0 && $current_month_before_amount > 0 && $line_diff_amount < 0) {
            $customer_type_name = 'ลูกค้าประจำ (-)';
        } else if ($expect_amount > 0 && $current_month_before_amount == 0 && $current_month_before_amount2 > 0) {
            $customer_type_name = 'ลูกค้ากลับมาซื้อ';
        } else if ($current_month_before_amount > 0 && $expect_amount == 0) {
            $customer_type_name = 'ลูกค้าใกล้หาย';
        } else if ($expect_amount == 0 && $current_month_before_amount == 0) {
            $customer_type_name = 'ลูกค้าหาย';
        } else if ($expect_amount > 0 && $current_month_before_amount == 0 && $current_month_before_amount2 == 0) {
            $customer_type_name = 'ลูกค้าใหม่';
        }

        ?>
        <tr>
            <td style="text-align: center;"><?= $key + 1 ?></td>
            <td style="text-align: center;"><?= Html::encode($row['customer_code']) ?></td>
            <td><?= Html::encode($row['customer_name']) ?></td>
            <td style="text-align: center;"><?= Html::encode($row['route_name']) ?></td>

            <?php if ($c_month >= 1): ?>
                <td align=" right
            "><?= number_format($row['Jan'], 2) ?></td><?php endif; ?>
            <?php if ($c_month >= 2): ?>
                <td align="right"><?= number_format($row['Feb'], 2) ?></td><?php endif; ?>
            <?php if ($c_month >= 3): ?>
                <td align="right"><?= number_format($row['Mar'], 2) ?></td><?php endif; ?>
            <?php if ($c_month >= 4): ?>
                <td align="right"><?= number_format($row['Apr'], 2) ?></td><?php endif; ?>
            <?php if ($c_month >= 5): ?>
                <td align="right"><?= number_format($row['May'], 2) ?></td><?php endif; ?>
            <?php if ($c_month >= 6): ?>
                <td align="right"><?= number_format($row['Jun'], 2) ?></td><?php endif; ?>
            <?php if ($c_month >= 7): ?>
                <td align="right"><?= number_format($row['Jul'], 2) ?></td><?php endif; ?>
            <?php if ($c_month >= 8): ?>
                <td align="right"><?= number_format($row['Aug'], 2) ?></td><?php endif; ?>
            <?php if ($c_month >= 9): ?>
                <td align="right"><?= number_format($row['Sep'], 2) ?></td><?php endif; ?>
            <?php if ($c_month >= 10): ?>
                <td align="right"><?= number_format($row['Oct'], 2) ?></td><?php endif; ?>
            <?php if ($c_month >= 11): ?>
                <td align="right"><?= number_format($row['Nov'], 2) ?></td><?php endif; ?>
            <?php if ($c_month >= 12): ?>
                <td align="right"><?= number_format($row['Dec'], 2) ?></td><?php endif; ?>

            <td align="right"><b><?= number_format($expect_amount, 2) ?></b></td>
            <td style="text-align: center;"><?= $customer_type_name ?></td>
            <td><?= number_format($line_diff_amount, 2) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
