<?php

use yii\helpers\Html;

//$this->title = 'บันทึกการขาย (เปิดร้าน)';
$this->registerCss("
    h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    .info-table td {
        padding: 5px;
        vertical-align: top;
    }
    .bordered th, .bordered td {
        border: 1px solid #000;
        padding: 5px;
        text-align: center;
    }
    .checkbox {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 1px solid #000;
        vertical-align: middle;
        margin-right: 5px;
    }
    .checked {
        background-color: black;
    }
    .section {
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .small-text {
        font-size: 16px;
    }
    
    .horizontal-list {
    display: flex;
    gap: 20px; /* ระยะห่างระหว่างแต่ละรายการ */
    padding-left: 0;
    list-style: none;
    }
    
    @media print {
      body {
        margin: 20px;
        padding: 10;
        line-height: 1.5;
      }

      .page {
        width: 90%;
        page-break-after: always;
      }
    }
");


$product_data = \common\models\Product::find()->where(['status' => 1])->orderBy(['item_pos_seq' => SORT_ASC])->all();
$attatch_doc_data = \common\models\CustomerRequestAttatchDoc::find()->where(['status' => 1])->all();
$product_select_data = \common\models\CustomerRequestProduct::find()->where(['customer_req_id' => $model->id])->all();

// เพิ่มใน section query ข้อมูลด้านบน
// Query ข้อมูลเอกสารมาตรฐานที่บันทึกไว้
$selected_standard_items_sql = "
    SELECT 
        csa.id,
        cs.name as standard_name,
        csi.name as item_name,
        cs.id as standard_id,
        csi.id as item_id
    FROM cus_req_doc_standard_assign csa
    LEFT JOIN cus_req_doc_standard cs ON csa.cus_req_standard_id = cs.id
    LEFT JOIN cus_req_doc_standard_item csi ON csa.cus_req_standard_item_id = csi.id
    WHERE csa.cus_req_id = :cus_req_id
    ORDER BY cs.id ASC, csi.id ASC
";

$selected_standard_items = [];
if (!empty($model->id)) {
    $selected_standard_items = \Yii::$app->db->createCommand($selected_standard_items_sql)
        ->bindValue(':cus_req_id', $model->id)
        ->queryAll();
}

// จัดกลุ่มข้อมูลตาม standard
$grouped_selected_items = [];
foreach ($selected_standard_items as $item) {
    $grouped_selected_items[$item['standard_name']][] = $item;
}

?>

    <div id="div1" class="page">
        <table style="width: 100%;border: 1px solid gray">
            <tr>
                <td style="text-align: center;">
                    <h2>บริษัท วรภัทร จำกัด</h2>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="small-text" style="text-align: center;">
                        เลขที่ 167 หมู่ที่ 6 ตำบลห้วยจรเข้ อำเภอเมือง จังหวัดนครปฐม 73000
                    </div>
                </td>
            </tr>
        </table>
        <table style="width: 100%;border-left: 1px solid gray;border-right: 1px solid gray;border-bottom: 0;border-top: 0">
            <tr>
                <td rowspan="2" style="text-align: center;vertical-align: middle;width: 100%;border-bottom: none;"><h4>
                        <u>บันทึกการขาย
                            (เปิดร้าน)</u></h4></td>
                </td>
            </tr>
        </table>
        <table style="width: 100%;border-left: 1px solid gray;border-right: 1px solid gray;border-bottom: 1px solid gray;border-top: 0px;">
            <tr>
                <td style="width: 80%;border-top: none;"></td>
                <td style="border-top: none;"><strong>เลขที่:</strong> <?= $model->journal_no ?>
            </tr>
            <tr>
                <td style="width: 80%;border-top: none;"></td>
                <td style="border-top: none;">
                    <strong>รหัสลูกค้า:</strong> <?= \backend\models\Customer::findCode($model->customer_ref_id) ?>
                </td>
            </tr>
        </table>
        <table style="width: 100%;border-left: 1px solid gray;border-right: 1px solid gray;border-bottom: 1px solid gray;border-top: 0;font-size: 18px">
            <tr>
                <td style="padding: 10px;">
                    <div class="section"><strong><u>รายละเอียดลูกค้า</u></strong></div>
                    <table class="info-table">
                        <tr>
                            <td><strong>ชื่อลูกค้า:</strong> <?= $model->customer_name ?></td>
                            <td><strong>อายุ:</strong> <?= $model->age ?> ปี</td>
                            <td><strong>เลขที่บัตรประชาชน:</strong> <?= $model->idcard_no ?></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>ที่อยู่เลขที่:</strong> <?= $model->address ?>
                            </td>
                            <td>
                                <strong>หมู่ที่:</strong> <?= $model->moo ?>
                            </td>
                            <td>
                                <strong>ถนน:</strong> -
                            </td>
                            <td>
                                <strong>ตำบล:</strong> <?= \backend\models\District::findDistrictName($model->district_id) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>อำเภอ:</strong> <?= \backend\models\Amphur::findAmphurName($model->city_id) ?>
                            </td>
                            <td>
                                <strong>จังหวัด:</strong> <?= \backend\models\Province::findProvinceName($model->province_id) ?>
                            </td>
                            <td><strong>เบอร์โทร:</strong> <?= $model->phone ?></td>

                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: center;font-size: 22px">
                                <strong>ชื่อกิจการ:</strong> <?= $model->company_name ?></td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
        <table style="width: 100%;border-left: 1px solid gray;border-right: 1px solid gray;border-bottom: 1px solid gray;border-top: 0;font-size: 18px">
            <tr>
                <td style="padding: 10px;">
                    <div class="section"><strong><u>รายละเอียดการขาย</u></strong></div>
                    <table class="info-table">
                        <tr>
                            <td>
                                <strong><u>สายส่ง:</u></strong> <?= \backend\models\Deliveryroute::findName($model->route_id) ?>
                            </td>
                            <td><strong><u>ลำดับการส่ง:</u></strong> <?= $model->route_num ?></td>
                            <td>
                                <strong><u>วันที่เริ่มส่ง:</u></strong> <?= date('d-m-Y', strtotime($model->start_date)) ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong><u>ราคาขาย:</u></strong> <?= $model->sale_price ?></td>
                            <td colspan="2"><strong><u>หมายเหตุ:</u></strong> <?= $model->remark ?></td>
                        </tr>
                        <tr>
                            <td>
                                <strong><u>ประเภทสินค้า:</u></strong>
                            </td>
                            <td colspan="3" style="padding: 10px">
                                <?php foreach ($product_select_data as $value_prod): ?>
                                    <input type="checkbox" onclick="return false;"
                                           checked> <?= \backend\models\Product::findCode($value_prod->product_id) . ' <u>' . $value_prod['qty'] . '</u> pcs. ' ?>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong><u>ประเภทการขาย:</u></strong>

                            </td>
                            <td>
                                <table>
                                    <?php if ($model->payment_method_id == 1): ?>
                                        <tr>
                                            <td colspan="3">
                                                <input type="checkbox" <?= $model->payment_method_id == 1 ? 'checked' : '' ?>
                                                       onclick="return false;">
                                                ขายสด เงินสด
                                            </td>
                                        </tr>
                                    <?php elseif ($model->payment_method_id == 3): ?>
                                        <tr>
                                            <td colspan="3">
                                                <input type="checkbox" <?= $model->payment_method_id == 3 ? 'checked' : '' ?>
                                                       onclick="return false;">
                                                ขายสด โอนผ่าน บ/ช. บจ.วรภัทร เลขที่ 764-3010880
                                            </td>
                                        </tr>
                                    <?php elseif ($model->payment_method_id == 2): ?>
                                        <tr>
                                            <td colspan="3">
                                                <input type="checkbox" <?= $model->payment_method_id == 2 ? 'checked' : '' ?>
                                                       onclick="return false;">
                                                เครดิด วัน โอนผ่าน บ/ช. บจ.วรภัทร เลขที่
                                                764-3002984
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </table>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="padding: 10px;">
                    <!--                    <div class="section">-->
                    <!--                        <strong><u>เอกสารที่ต้องใช้ในการออกใบกำกับภาษี:</u></strong> ภพ.20 หรือ หนังสือรับรองบริษัทฯ-->
                    <!--                    </div>-->
                    <table style="width: 100%;border-left: 1px solid gray;border-right: 1px solid gray;border-bottom: 1px solid gray;border-top: 0;font-size: 18px">
                        <tr>
                            <td style="padding: 10px;">
                                <div class="section">
                                    <strong><u>เอกสารที่ต้องใช้:</u></strong>

                                    <?php if (!empty($grouped_selected_items)): ?>
                                        <?php $group_count = 0; ?>
                                        <?php foreach ($grouped_selected_items as $standard_name => $items): ?>
                                            <?php if ($group_count > 0) echo " | "; ?>

                                            <strong><?= Html::encode($standard_name) ?>:</strong>
                                            <?php foreach ($items as $index => $item): ?>
                                                <?php if ($index > 0) echo ", "; ?>
                                                <input type="checkbox" checked onclick="return false;"
                                                       style="margin-right: 3px;">
                                                <?= Html::encode($item['item_name']) ?>
                                            <?php endforeach; ?>

                                            <?php $group_count++; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span style="color: #666; font-style: italic;">ไม่มีเอกสารที่ระบุไว้</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table style="width: 100%;border-left: 1px solid gray;border-right: 1px solid gray;border-bottom: 1px solid gray;border-top: 0;font-size: 18px">
            <tr>
                <td>
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 30%;text-align: center;">
                                <?php
                                $use_box = '';
                                $not_use_box = '';
                                if ($model->user_box == 1) {
                                    $use_box = 'checked';
                                    $not_use_box = '';
                                } else {
                                    $not_use_box = 'checked';
                                    $use_box = '';
                                }
                                ?>
                                <input type="checkbox" <?= $not_use_box ?> onclick="return false;"> ไม่ใช้ถัง
                                <input type="checkbox" <?= $use_box ?> onclick="return false;"> ใช้ถัง
                            </td>
                            <td style="width: 30%;text-align: center;border-left: 1px solid grey;">
                                <?php
                                $is_approve = '';
                                $not_approve = '';
                                //                                if ($model->is_approve == 100) {
                                //                                    $is_approve = 'checked';
                                //                                    $not_approve = '';
                                //                                } else {
                                //                                    $not_approve = 'checked';
                                //                                    $is_approve = '';
                                //                                }
                                ?>
                                <input type="checkbox" <?= $not_approve ?> onclick="return false;"> ไม่อนุมัติ
                                <input type="checkbox" <?= $is_approve ?> onclick="return false;"> อนุมัติ
                            </td>
                            <td style="width: 30%;text-align: center;border-left: 1px solid grey;">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;height: 50px;vertical-align: bottom;">
                                _____________________________
                            </td>
                            <td style="text-align: center;border-left: 1px solid grey;vertical-align: bottom;">
                                _____________________________
                            </td>
                            <td style="text-align: center;border-left: 1px solid grey;vertical-align: bottom;">
                                _____________________________
                            </td>

                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <strong>เจ้าหน้าที่การตลาด</strong><br>
                                วันที่: <?php echo date('d-m-Y', strtotime($model->market_emp_date)).' '.date('H:i') ?>
                            </td>
                            <td style="text-align: center;border-left: 1px solid grey;">
                                <strong>หัวหน้าฝ่ายการตลาด</strong><br>
                                วันที่: _____________________________ <?php //echo date('d-m-Y', strtotime($model->market_emp_date)) ?>
                            </td>
                            <td style="text-align: center;border-left: 1px solid grey;">
                                <strong>เจ้าหน้าที่ธุรการ</strong>
                                <br>วันที่: _____________________________ <?php //echo date('d-m-Y', strtotime($model->market_emp_date)) ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>

        <?php if ($model->user_box == 1): ?>
            <table style="width: 100%;border-left: 1px solid gray;border-right: 1px solid gray;border-bottom: 1px solid gray;border-top: 0;font-size: 18px">
                <tr>
                    <td style="padding: 10px;">
                        <div class="section"><strong><u>ขนาดบรรจุของถัง:</u></strong> 100 ลิตร บรรจุ 4 แพ็ค 200 ลิตร
                            บรรจุ 8
                            แพ็ค 300 ลิตร บรรจุ 12 แพ็ค 500 ลิตร บรรจุ 18 แพ็ค
                        </div>
                    </td>
                </tr>
            </table>
        <?php endif; ?>

        <?php if ($model->user_box == 1): ?>
            <table style="width: 100%;border-left: 1px solid gray;border-right: 1px solid gray;border-bottom: 1px solid gray;border-top: 0;font-size: 18px">
                <thead>
                <tr>
                    <td colspan="6">
                        <div class="section" style="text-align: center"><strong><u>รายละเอียดการใช้ถัง</u></strong>
                        </div>
                    </td>
                </tr>

                </thead>
                <tbody>
                <tr>
                    <td style="padding: -1px;">
                        <table class="bordered" style="width: 100%">
                            <tr>
                                <th style="width: 5%">ลำดับ</th>
                                <th style="width: 10%">ขนาดถัง</th>
                                <th style="width: 5%">จำนวน</th>
                                <th style="width: 15%">วันที่ต้องการใช้</th>
                                <th style="">หมายเหตุ</th>
                                <th style="width: 15%">รหัสถัง</th>
                            </tr>
                            <?php if ($model_asset != null): ?>
                                <?php $row_no = 0; ?>
                                <?php foreach ($model_asset as $value): ?>
                                    <?php $row_no += 1; ?>
                                    <tr>
                                        <td><?= $row_no ?></td>
                                        <td><?= \backend\models\Assetsitem::findSize($value->product_id) ?></td>
                                        <td><?= $value->qty ?></td>
                                        <td><?= date('d-m-Y') ?></td>
                                        <td>-</td>
                                        <td><?= \backend\models\Assetsitem::findCode($value->product_id) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td style="height: 35px;"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="height: 35px;"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="height: 35px;"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        <?php endif; ?>
        <!-- แทนที่ส่วนเดิมของ "เอกสารที่ต้องใช้" -->
        <!--        <table style="width: 100%;border-left: 1px solid gray;border-right: 1px solid gray;border-bottom: 1px solid gray;border-top: 0;font-size: 18px">-->
        <!--            <tr>-->
        <!--                <td style="padding: 10px;">-->
        <!--                    <div class="section">-->
        <!--                        <strong><u>เอกสารที่ต้องใช้:</u></strong>-->
        <!---->
        <!--                        --><?php //if (!empty($selected_standard_items)): ?>
        <!--                            <br>-->
        <!--                            --><?php //foreach ($selected_standard_items as $item): ?>
        <!--                                <input type="checkbox" checked onclick="return false;" style="margin-right: 8px;">-->
        <!--                                --><?php //= Html::encode($item['item_name']) ?><!--<br>-->
        <!--                            --><?php //endforeach; ?>
        <!--                        --><?php //else: ?>
        <!--                            -->
        <!--                        --><?php //endif; ?>
        <!--                    </div>-->
        <!--                </td>-->
        <!--            </tr>-->
        <!--        </table>-->

        <div class="section" style="text-align:right;">
            FM-MK-02 แก้ไขครั้งที่: 03 <br/> วันที่ประกาศใช้: 01/05/2568
        </div>
    </div>

    <br/>
    <table width="100%" class="table-title">
        <td style="text-align: right">
            <button id="btn-export-excel" class="btn btn-secondary">Export Excel</button>
            <button id="btn-print" class="btn btn-warning" onclick="printContent('div1')">Print</button>
        </td>
    </table>
<?php
$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/jquery.table2excel.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$js = <<<JS
 $(function(){
    $("#btn-export-excel").click(function(){
          $("#table-data").table2excel({
            // exclude CSS class
            exclude: ".noExl",
            name: "Excel Document Name"
          });
    });
 });
function printContent(el)
      {
         var restorepage = document.body.innerHTML;
         var printcontent = document.getElementById(el).innerHTML;
         document.body.innerHTML = printcontent;
         window.print();
         document.body.innerHTML = restorepage;
     }
JS;
$this->registerJs($js, static::POS_END);
?>