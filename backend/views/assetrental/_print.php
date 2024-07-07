<?php
//print_r($model_min_max);
$from_date = date('Y-m-d');
$to_date = date('Y-m-d');

$cnt_arr = count($model_min_max);
if ($cnt_arr > 0) {
    $from_date = date('Y-m-d', strtotime($model_min_max[0]['date']));
    $to_date = date('Y-m-d', strtotime($model_min_max[$cnt_arr - 1]['date']));
}
$to_date_new = '';
$has_29_02 = 0;
$xxtodate = explode('-', $to_date);
if (count($xxtodate) > 1) {
    if ($xxtodate[1] == '02' && $xxtodate[2] == '29') {
        $has_29_02 = 1;
        $to_date_new = '29-02-' . ($xxtodate[0] + 543);
    } else {
        $to_date_new = ($xxtodate[0] + 543) . '/' . $xxtodate[1] . '/' . $xxtodate[2];
    }

}


?>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
    <link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
    <style>
        /*body {*/
        /*    font-family: sarabun;*/
        /*    !*font-family: garuda;*!*/
        /*    font-size: 18px;*/
        /*}*/
        #div1 {
            font-family: sarabun;
            /*font-family: garuda;*/
            font-size: 18px;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            #div1, #div1 * {
                visibility: visible;
            }
            #div1 {
                position: absolute;
                left: 0;
                top: 0;
                height: 100%;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            thead {
                display: table-header-group;
            }
            tfoot {
                display: none; /* Hide tfoot in print */
            }
        }


        table.table-header {
            border: 0px;
            border-spacing: 1px;
        }

        table.table-footer {
            border: 0px;
            border-spacing: 0px;
        }

        table.table-header td, th {
            border: 0px solid #dddddd;
            text-align: left;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        table.table-title {
            border: 0px;
            border-spacing: 0px;
        }

        table.table-title td, th {
            border: 0px solid #dddddd;
            text-align: left;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        table {
            border-collapse: collapse;
            /*width: 100%;*/
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            /*background-color: #dddddd;*/
        }

        table.table-detail {
            border-collapse: collapse;
            width: 100%;
        }

        table.table-detail td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 2px;
        }

    </style>
</head>
<body>
<div id="div1">
    <table style="border: none;">
        <!--    <table style="border: 0px;">-->
        <tr>
            <td style="text-align: left;border: none" colspan="2"><h3>รายงานสรุปการใช้ถัง (เช่า)</h3></td>
        </tr>
    </table>
    <br/>

    <table id="table-data" style="width: 100%">
        <tr>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">ลำดับ</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">ขนาดถัง</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">รหัสถัง</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;">ราคา</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;width: 15%">ชื่อร้าน</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;width: 15%">เบอร์โทร</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;width: 15%">ผู้รับถัง</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;width: 15%">ผู้จ่ายถัง</td>
            <td style="text-align: center;padding: 8px;border: 1px solid grey;width: 15%">หมายเหตุ</td>

        </tr>
<?php $num = 0;?>
        <?php foreach ($model_line as $value): ?>
            <?php
            $num += 1;
            ?>
            <tr>
                <td style="text-align: center;padding: 8px;border: 1px solid grey"><?= $num ?><input type="hidden" value="<?= $value->id; ?>">
                </td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey"><?=$value->remark?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey"><?=\backend\models\Assetsitem::findCode($value->asset_id) ?></td>
                <td style="text-align: center;padding: 8px;border: 1px solid grey"><?=\backend\models\Assetsitem::findPrice($value->asset_id) ?></td>
                <td style="text-align: center;padding: 8px;padding-right: 5px;border: 1px solid grey"></td>
                <td style="text-align: center;padding: 8px;padding-right: 5px;border: 1px solid grey"></td>
                <td style="text-align: center;padding: 8px;padding-right: 5px;border: 1px solid grey"></td>
                <td style="text-align: center;padding: 8px;padding-right: 5px;border: 1px solid grey"></td>
                <td style="text-align: center;padding: 8px;padding-right: 5px;border: 1px solid grey"></td>
            </tr>
        <?php endforeach; ?>

    </table>
</div>
<br/>

<table class="table-title">
    <td>
        <button class="btn btn-info" onclick="printContent('div1')">พิมพ์</button>
    </td>
    <td style="text-align: right">
        <button id="btn-export-excel-top" class="btn btn-secondary">Export Excel</button>
        <!--            <button id="btn-print" class="btn btn-warning" onclick="printContent('div1')">Print</button>-->
    </td>
</table>
</body>
</html>



<?php
$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/jquery.table2excel.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$js = <<<JS
 $("#btn-export-excel").click(function(){
  $("#table-data-2").table2excel({
    // exclude CSS class
    exclude: ".noExl",
    name: "Excel Document Name"
  });
});
$("#btn-export-excel-top").click(function(){
  $("#table-data").table2excel({
    // exclude CSS class
    exclude: ".noExl",
    name: "Excel Document Name"
  });
});
function printContentx(el)
      {
         var restorepage = document.body.innerHTML;
         var printcontent = document.getElementById(el).innerHTML;
         document.body.innerHTML = printcontent;
         window.print();
         document.body.innerHTML = restorepage;
     }
function printContent(el){
    // Clone the table to manipulate it before printing
    //   var tableClone = document.getElementById('printTable').cloneNode(true);
    //
    //   // Add the last-page class to tfoot
    //   tableClone.querySelector('tfoot').classList.add('last-page');
    //
    //   // Use printThis to print the table
    //   $(tableClone).printThis({
    //     importCSS: true,
    //     loadCSS: '',
    //     printContainer: true,
    //     pageTitle: '',
    //     removeInline: false,
    //     header: null,
    //     footer: null,
    //     base: false,
    //     formValues: true,
    //     canvas: false,
    //     doctypeString: '<!DOCTYPE html>',
    //     removeScripts: false,
    //     copyTagClasses: false
    //   });
    
    $('#div1').printThis({
                    importCSS: true,
                    loadCSS: "", // Additional CSS file to load if needed
                    pageTitle: "Print Area",
                    removeInline: false,
                    printContainer: true,
                    debug: false
                });
}     
JS;
$this->registerJs($js, static::POS_END);
?>

