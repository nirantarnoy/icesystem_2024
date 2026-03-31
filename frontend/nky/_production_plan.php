<?php
date_default_timezone_set('Asia/Bangkok');

use yii\helpers\Html;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

$this->title = 'รายงานแผนผลิตแยกสายส่ง';

// Fetch data from query_plan_by_route
$from_date_fmt = date('Y-m-d', strtotime($from_date));
$to_date_fmt = date('Y-m-d', strtotime($to_date));
$view_type = Yii::$app->request->post('view_type') ?? 1; // 1 = Draft (All), 2 = Actual (Transaction only)

// Always use LEFT JOIN to identify missing routes
$sql = "SELECT t1.id as route_id, t1.name as route_name, t1.is_two_rap, t1.prod_show_seq,
               t2.id as plan_id, t2.car_name, t2.fname, t2.lname, t2.code, t2.qty, t2.trans_date, t2.name as product_name, t2.round_no
        FROM delivery_route t1
        LEFT JOIN query_plan_by_route t2 ON t1.id = t2.route_id 
             AND date(t2.trans_date2) >= :from_date 
             AND date(t2.trans_date2) <= :to_date
        WHERE (t1.status = 1 OR t1.status IS NULL)
        AND t1.prod_show_seq > 0 AND t1.name != 'VP31'";

$params = [
    ':from_date' => $from_date_fmt,
    ':to_date' => $to_date_fmt
];

if ($company_id > 0) {
    $sql .= " AND t1.company_id = :company_id";
    $params[':company_id'] = $company_id;
}
if ($branch_id > 0) {
    $sql .= " AND t1.branch_id = :branch_id";
    $params[':branch_id'] = $branch_id;
}

$sql .= " ORDER BY IFNULL(t1.prod_show_seq, 999999) ASC, t1.name ASC, t2.trans_date ASC, t2.round_no ASC, t2.code ASC";

$data = Yii::$app->db->createCommand($sql, $params)->queryAll();

// Process data for pivoting
$routes = [];
$product_codes = [];
$product_names = []; // mapping code -> name
$m_counts = []; // track M counts per route and round

foreach ($data as $row) {
    $route_id = $row['route_id'];
    $route_name = $row['route_name'];
    $is_two_rap = $row['is_two_rap'];
    $plan_id = $row['plan_id'];
    $product_code = $row['code'];
    $qty = $row['qty'];

    $key = $route_name;
    
    if (!isset($routes[$key])) {
        $routes[$key] = [
            'route_name' => $route_name,
            'car_name' => '', 
            'driver_name' => '',
            'is_two_rap' => $is_two_rap,
            'plans' => []
        ];
    }

    if ($plan_id) {
        $car_name = $row['car_name'];
        $driver_name = trim(($row['fname'] ?? ''));

        $final_product_code = $product_code;

        // Identify plan key using round_no from database
        $p_idx = (int)($row['round_no'] ?? 1) - 1;
        $plan_id_base = $plan_id ? $plan_id : 'temp';
        $plan_key = $plan_id_base . '_' . $p_idx;

        // M vs Mม่วง logic: 
        // 1. ทุกสายขายกี่รอบก็ M เสมอ
        // 2. VP07: รอบ 1 เป็น M, รอบ 2 เป็น Mม่วง
        // 3. VP31: ทุกรอบเป็น Mม่วง
        if ($product_code == 'M') {
             if ($route_name == 'VP31') {
                $final_product_code = 'Mม่วง';
             } else if ($route_name == 'VP07') {
                $m_key = $route_id . '_' . $p_idx;
                $m_counts[$m_key] = ($m_counts[$m_key] ?? 0) + 1;
                if ($m_counts[$m_key] > 1 || $p_idx == 1) {
                    $final_product_code = 'Mม่วง';
                } else {
                    $final_product_code = 'M';
                }
             } else {
                $final_product_code = 'M';
             }
        }

        if (!empty($final_product_code) && !in_array($final_product_code, $product_codes)) {
            $product_codes[] = $final_product_code;
            $product_names[$final_product_code] = ($final_product_code == 'Mม่วง') ? 'Mม่วง' : ($row['product_name'] ?? '');
        }

        // Capture first non-empty car/driver for the route group
        if (empty($routes[$key]['car_name']) && !empty($car_name)) {
            $routes[$key]['car_name'] = $car_name;
        }
        if (empty($routes[$key]['driver_name']) && !empty($driver_name)) {
            $routes[$key]['driver_name'] = $driver_name;
        }

        $p_time = $row['trans_date'] ? date('H:i', strtotime($row['trans_date'])) : '';

        if (!isset($routes[$key]['plans'][$plan_key])) {
            $routes[$key]['plans'][$plan_key] = [
                'time' => $p_time,
                'full_time' => $row['trans_date'], // use for sorting
                'id' => $plan_id,
                'car_name' => $car_name,
                'driver_name' => $driver_name,
                'round_num' => $p_idx + 1, // Store which physical row this is
                'products' => []
            ];
        }

        if (!empty($final_product_code)) {
            $routes[$key]['plans'][$plan_key]['products'][$final_product_code] = ($routes[$key]['plans'][$plan_key]['products'][$final_product_code] ?? 0) + $qty;
        }
    }
}

// Sort plans for each route by time
foreach ($routes as &$r) {
    if (!empty($r['plans'])) {
        uasort($r['plans'], function($a, $b) {
            if ($a['round_num'] != $b['round_num']) {
                return $a['round_num'] - $b['round_num'];
            }
            $ta = !empty($a['full_time']) ? strtotime($a['full_time']) : 0;
            $tb = !empty($b['full_time']) ? strtotime($b['full_time']) : 0;
            return $ta - $tb;
        });
    }
}
unset($r);

// Sort product codes if needed, or use a specific order if requested
// The user showed: PB, PS, PC, Mแดง, Mม่วง, R, K, P2, B, S
// The user showed: PB, PS, PC, Mแดง, Mม่วง, M, M (duplicate), R, K, P2, B, S
$preferred_order = ['PB', 'PS', 'PC', 'Mแดง', 'M', 'Mม่วง', 'R', 'K', 'P2']; // Mม่วง following M
usort($product_codes, function($a, $b) use ($preferred_order) {
    $last_items = ['B', 'S'];
    
    // If both are in the last_items list, sort them relative to each other
    if (in_array($a, $last_items) && in_array($b, $last_items)) {
        return array_search($a, $last_items) - array_search($b, $last_items);
    }
    // If only $a is in the last_items, it should come after $b
    if (in_array($a, $last_items)) return 1;
    // If only $b is in the last_items, it should come after $a
    if (in_array($b, $last_items)) return -1;

    $pos_a = array_search($a, $preferred_order);
    $pos_b = array_search($b, $preferred_order);
    
    if ($pos_a === false && $pos_b === false) return strcmp($a, $b);
    if ($pos_a === false) return 1;
    if ($pos_b === false) return -1;
    return $pos_a - $pos_b;
});

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= Html::encode($this->title) ?></title>
    <style>
        @font-face {
            font-family: 'Sarabun';
            src: url('fonts/THSarabunNew.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: "Sarabun", "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-size: 14px; /* Reduced from 16px */
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .table-responsive {
            display: block;
            width: 100%;
            overflow: visible; /* Better for printing */
        }
        table {
            border-collapse: collapse !important;
            width: 100%;
            background-color: #fff;
            table-layout: fixed;
            border: 3px solid #000 !important;
        }
        th, td {
            border: 3px solid #000 !important;
            outline: 1px solid #000 !important; /* Secondary line to reinforce thickness */
            text-align: center;
            padding: 0 !important;
            line-height: 1.2 !important;
            vertical-align: middle !important;
            word-wrap: break-word;
            color: #000 !important;
        }
        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #000;
        }
        .bg-round {
            font-size: 0.85em;
            color: #000;
        }
        .qty-cell {
            font-weight: 500;
            width: 45px;
            white-space: nowrap;
        }
        .white-nowrap {
            white-space: nowrap;
        }
        .qty-zero {
            background-color: #707070 !important;
            color: #707070 !important; 
            font-weight: 300;
        }
        .qty-active {
            color: #000; /* Standard black for print */
            font-weight: bold;
        }
        .row-yellow {
            background-color: #ffff00 !important;
        }
        .bg-green-light {
            background-color: #e2f0d9 !important; /* Light green */
        }
        .row-total {
            background-color: #f2f2f2;
            font-weight: bold;
            width: 60px;
        }
        .grand-total {
            background-color: #ffeb3b !important;
            color: #000 !important;
            font-weight: bold;
        }
        .header-info {
            margin-bottom: 15px; /* Reduced */
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }
        @media print {
            @page {
                size: A4 landscape;
                margin: 5mm;
            }
            .no-print {
                display: none !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            body {
                font-size: 11px; /* Smaller for print */
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            th, td {
                padding: 1px !important;
                line-height: normal !important;
                border: 1px solid #333 !important; /* Thinner border */
                color: #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            table {
                border: 1px solid #333 !important;
                border-collapse: collapse !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            /* Robust color printing for rows and cells */
            .row-yellow, 
            tr.row-yellow td, 
            .row-yellow td {
                background-color: #ffff00 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .bg-green-light, 
            td.bg-green-light {
                background-color: #e2f0d9 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .qty-zero, 
            td.qty-zero {
                background-color: #707070 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color: #707070 !important;
            }
            .grand-total, 
            .grand-total td {
                background-color: #ffeb3b !important;
                color: #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .manual-row td {
                height: auto; 
            }
        }
        .manual-row td {
            height: auto;
        }
        .signature-section {
            margin-top: 30px;
            width: 100%;
        }
        .signature-table {
            width: 100%;
            border: none !important;
        }
        .signature-table td {
            border: none !important;
            text-align: center;
            padding: 10px !important;
            width: 33.33%;
            vertical-align: top !important;
        }
    </style>
</head>
<body>

<div class="no-print" style="margin-bottom: 20px;">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-search"></i> ค้นหาแผนการผลิต</h3>
        </div>
        <div class="card-body">
            <form action="<?= Url::to(['plan/productionplan']) ?>" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>จากวันที่</label>
                            <?= DateRangePicker::widget([
                                'name' => 'from_date',
                                'value' => $from_date,
                                'pluginOptions' => [
                                    'singleDatePicker' => true,
                                    'showDropdowns' => true,
                                    'locale' => ['format' => 'DD-MM-YYYY']
                                ],
                                'options' => ['class' => 'form-control']
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>ถึงวันที่</label>
                            <?= DateRangePicker::widget([
                                'name' => 'to_date',
                                'value' => $to_date,
                                'pluginOptions' => [
                                    'singleDatePicker' => true,
                                    'showDropdowns' => true,
                                    'locale' => ['format' => 'DD-MM-YYYY']
                                ],
                                'options' => ['class' => 'form-control']
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>รูปแบบการดึงข้อมูล</label>
                            <select name="view_type" class="form-control">
                                <option value="1" <?= $view_type == 1 ? 'selected' : '' ?>>แผนผลิต (แสดงทั้งหมด)</option>
                                <option value="2" <?= $view_type == 2 ? 'selected' : '' ?>>รายการเบิกจริง (เฉพาะที่มีรายการ)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4" style="padding-top: 32px;">
                        <button type="submit" class="btn btn-primary shadow-sm"><i class="fas fa-search"></i> ค้นหา</button>
                        <button type="button" class="btn btn-success shadow-sm" onclick="window.print()"><i class="fas fa-print"></i> พิมพ์รายงาน</button>
                        <a href="<?= Url::to(['plan/exportproductionplan', 'from_date' => $from_date, 'to_date' => $to_date, 'view_type' => $view_type]) ?>" class="btn btn-info shadow-sm"><i class="fas fa-file-excel"></i> Export Excel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card card-outline card-info shadow">
    <div class="card-body p-1">
        <div class="header-info m-2">
            <h3 style="margin: 0; color: #333; display: inline-block;">รายการเบิกของประจำวัน (Production Plan)</h3>
            <span style="font-size: 1.2em; margin-left: 15px;">
                วันที่: <strong><?= date('d/m/Y', strtotime('+ 1 day', strtotime($from_date))) ?></strong>
                <?php if ($from_date != $to_date): ?> ถึง <strong><?= date('d/m/Y', strtotime('+ 1 day', strtotime($to_date))) ?></strong><?php endif; ?>
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 35px;">ลำดับ</th>
                        <th style="width: 100px;">เวลา</th>
                        <th style="width: 110px;">สาย</th>
                        <th style="width: 75px;">ทะเบียน</th>
                        <th style="width: 100px;">พนักงานขับรถ</th>
                        <th style="width: 65px;">แผน/รอบ</th>
                        <?php foreach ($product_codes as $code): ?>
                            <th class="qty-cell"><?= $code ?></th>
                        <?php endforeach; ?>
                        <th class="row-total">รวม</th>
                        <th style="width: 140px;">หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total_products = array_fill_keys($product_codes, 0);
                    $grand_total_all = 0;

                    if (empty($routes)): ?>
                        <tr>
                            <td colspan="<?= count($product_codes) + 7 ?>" class="text-center p-5 text-muted">
                                ไม่พบข้อมูลแผนการผลิต
                            </td>
                        </tr>
                    <?php else:
                        $main_idx = 1;
                        foreach ($routes as $route_key => $route_data): 
                            // If Actual view, skip routes with no plans
                            if ($view_type == 2 && empty($route_data['plans'])) continue;

                            $is_two_rap = $route_data['is_two_rap'] ?? 0;
                            $raw_plans = array_values($route_data['plans'] ?? []);
                            // Show at least 2 rows if is_two_rap=1, otherwise as many as we have data for
                            $display_rows = max(($is_two_rap == 1 ? 2 : 1), count($raw_plans));
                            
                        for ($row_idx = 0; $row_idx < $display_rows; $row_idx++):
                                $plan_info = $raw_plans[$row_idx] ?? null;
                                $plan_total = 0;
                                $round_label = 'รอบที่ ' . ($row_idx + 1);
                                $row_class = ($row_idx > 0) ? 'row-yellow' : '';
                    ?>
                        <tr>
                            <?php if ($row_idx == 0): ?>
                                <td rowspan="<?= $display_rows ?>" class="align-middle"><?= $main_idx++ ?></td>
                                <td rowspan="<?= $display_rows ?>" class="align-middle"></td>
                                <td rowspan="<?= $display_rows ?>" class="font-weight-bold align-middle white-nowrap"><?= $route_data['route_name'] ?></td>
                                <td rowspan="<?= $display_rows ?>" class="align-middle <?= empty($route_data['car_name']) ? 'qty-zero' : '' ?>"><?= $route_data['car_name'] ?></td>
                                <td rowspan="<?= $display_rows ?>" class="align-middle text-left bg-green-light <?= empty($route_data['driver_name']) ? 'qty-zero' : '' ?>" style="padding-left: 5px;"><?= $route_data['driver_name'] ?></td>
                            <?php endif; ?>
                            <td class="bg-round align-middle <?= $row_class ?>">
                                <?= $round_label ?>
                            </td>
                            <?php foreach ($product_codes as $code): 
                                $display_product_name = ($code == 'Mม่วง') ? 'Mม่วง' : ($product_names[$code] ?? $code);
                                $qty = $plan_info['products'][$code] ?? 0;
                                $plan_total += $qty;
                                $grand_total_products[$code] += $qty;
                            ?>
                                <td class="qty-cell <?= $row_class ?> <?= $qty > 0 ? 'qty-active' : 'qty-zero' ?>">
                                    <?= $qty > 0 ? number_format($qty) : '' ?>
                                </td>
                            <?php endforeach; ?>
                            <td class="row-total align-middle <?= $row_class ?> <?= $plan_total > 0 ? '' : 'qty-zero' ?>">
                                <?= $plan_total > 0 ? number_format($plan_total) : '' ?>
                            </td>
                            <td class="align-middle"></td>
                        </tr>
                    <?php 
                                $grand_total_all += $plan_total;
                            endfor; 
                        endforeach; 
                    endif; ?>
                </tbody>
                <?php if (!empty($routes)): ?>
                <tfoot>
                    <tr class="grand-total">
                       
                        <td colspan="6" class="text-right pr-2">รวมทั้งสิ้น</td>
                        <?php foreach ($product_codes as $code): ?>
                            <td class="<?= $grand_total_products[$code] > 0 ? '' : 'qty-zero' ?>"><?= number_format($grand_total_products[$code]) ?></td>
                        <?php endforeach; ?>
                        <td style="background-color: #ffc107; color: #000; <?= $grand_total_all > 0 ? '' : 'background-color: #dfdfdf !important;' ?>"><?= number_format($grand_total_all) ?></td>
                        <td></td>
                    </tr>
                    <tr class="manual-row" style="font-weight: bold;">
                         <td colspan="4" style="text-align: left;">PB เซทละ 190 แพ็ค</td>
                        <td colspan="2" class="text-right pr-2">ยอดคงเหลือ</td>
                        <?php foreach ($product_codes as $code): ?>
                            <td></td>
                        <?php endforeach; ?>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="manual-row" style="font-weight: bold;">
                        <td colspan="4" style="text-align: left;">PS เซทละ 95 แพ็ค</td>
                        <td colspan="2" class="text-right pr-2">ยอดผลิตจริง</td>
                        <?php foreach ($product_codes as $code): ?>
                            <td></td>
                        <?php endforeach; ?>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="manual-row" style="font-weight: bold;">
                        <td colspan="4" style="text-align: left;">P2 เซทละ 1,200 แพ็ค</td>
                        <td colspan="2" class="text-right pr-2">-/+</td>
                        <?php foreach ($product_codes as $code): ?>
                            <td></td>
                        <?php endforeach; ?>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>

        <?php if ($view_type == 2): 
            $missing_routes = [];
            foreach ($routes as $r) {
                if (empty($r['plans'])) $missing_routes[] = $r['route_name'];
            }
            if (!empty($missing_routes)): ?>
            <div class="no-print" style="margin-top: 15px; padding: 10px; border: 1px dashed #f0ad4e; background-color: #fffcf5;">
                <b class="text-warning"><i class="fas fa-exclamation-triangle"></i> สายส่งที่ไม่มีรายการเบิก (ยังไม่ได้ทำรายการ):</b>
                <div style="margin-top: 5px; color: #666;">
                    <?= implode(', ', $missing_routes) ?>
                </div>
            </div>
        <?php endif; endif; ?>

        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td>
                        <div style="margin-bottom: 5px;">ผู้บันทึกเบิก .................................</div>
                        <div style="font-weight: bold;">( ธุรการ )</div>
                    </td>
                    <td>
                        <div style="margin-bottom: 5px;">ผู้บันทึกยอดยกมา ...................................</div>
                        <div style="font-weight: bold;">( เสมียนกะบ่าย )</div>
                    </td>
                    <td>
                        <div style="margin-bottom: 5px;">ผู้บันทึกยอดผลิตจริง ................................</div>
                        <div style="font-weight: bold;">( เสมียนกะดึก/เช้า )</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

</body>
</html>
