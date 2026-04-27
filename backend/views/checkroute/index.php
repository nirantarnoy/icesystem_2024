<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var array $data */
/** @var array $all_routes */
/** @var int|null $route_id */
/** @var string $view_type */

$this->title = 'ตรวจสอบสายส่ง';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Leaflet & Vis-Network Dependencies -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>

<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        border: none;
    }
    .card-header {
        background: linear-gradient(135deg, #17a2b8 0%, #007bff 100%);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
    }
    .card-title {
        font-weight: 700;
        margin: 0;
    }
    #map, #flow-network { 
        height: 650px; 
        border-radius: 12px; 
        border: 2px solid #eee;
        background: #fdfdfd;
    }
    .number-icon {
        background: #ff4757;
        border: 2px solid white;
        border-radius: 50%;
        color: white;
        font-weight: bold;
        text-align: center;
        line-height: 26px;
        font-size: 13px;
        width: 30px !important;
        height: 30px !important;
        box-shadow: 0 3px 6px rgba(0,0,0,0.3);
    }
    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    .route-num-badge {
        width: 30px;
        height: 30px;
        background: #007bff;
        color: white;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    .customer-tooltip {
        background-color: rgba(255, 255, 255, 0.9);
        border: 1px solid #007bff;
        border-radius: 4px;
        color: #333;
        font-weight: 600;
        padding: 2px 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        font-family: 'Kanit', sans-serif;
    }
</style>

<div class="delivery-route-check">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title"><i class="fas fa-shipping-fast mr-2"></i> ตรวจสอบลำดับการจัดส่ง</h3>
            <?= Html::a('<i class="fas fa-reply mr-1"></i> กลับไปหน้ารายการ', ['deliveryroute/index'], ['class' => 'btn btn-light btn-sm']) ?>
        </div>
        <div class="card-body">
            <form action="<?= Url::to(['checkroute/index']) ?>" method="get" class="mb-4">
                <input type="hidden" name="r" value="checkroute/index">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="small font-weight-bold text-muted">สายส่ง</label>
                        <select name="route_id" class="form-control select2" required>
                            <option value="">--- โปรดเลือกสายส่ง ---</option>
                            <?php foreach ($all_routes as $route): ?>
                                <option value="<?= $route->id ?>" <?= $route_id == $route->id ? 'selected' : '' ?>>
                                    <?= Html::encode($route->name) ?> (<?= Html::encode($route->code) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="small font-weight-bold text-muted">รูปแบบการแสดงผล</label>
                        <select name="view_type" class="form-control">
                            <option value="list" <?= $view_type == 'list' ? 'selected' : '' ?>>📋 แสดงแบบรายการ (List)</option>
                            <option value="map" <?= $view_type == 'map' ? 'selected' : '' ?>>📍 แสดงแบบบนแผนที่ (Map)</option>
                            <option value="flow" <?= $view_type == 'flow' ? 'selected' : '' ?>>🔄 แสดงลำดับแบบ Bubble (Flow)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block shadow-sm">
                            <i class="fas fa-search mr-1"></i> แสดงข้อมูล
                        </button>
                    </div>
                </div>
            </form>

            <?php if (!$route_id): ?>
                <div class="text-center py-5 bg-light rounded-lg border" style="border-style: dashed !important;">
                    <i class="fas fa-map-marked-alt fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">กรุณาเลือกสายส่งเพื่อตรวจสอบข้อมูลลูกค้า</h5>
                </div>
            <?php else: ?>
                <?php if (empty($data)): ?>
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i> ไม่พบข้อมูลลูกค้าในสายส่งที่เลือก
                    </div>
                <?php else: ?>
                    <?php if ($view_type == 'list'): ?>
                        <div class="table-responsive rounded-lg overflow-hidden border">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="100px" class="text-center">ลำดับส่ง</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th width="150px">รหัสลูกค้า</th>
                                        <th width="150px">พิกัดสถานที่</th>
                                        <th width="100px" class="text-center">สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $cust): ?>
                                        <tr>
                                            <td class="text-center">
                                                <span class="route-num-badge shadow-sm">
                                                    <?= Html::encode($cust['route_num'] ?: '-') ?>
                                                </span>
                                            </td>
                                            <td class="font-weight-bold text-dark"><?= Html::encode($cust['name']) ?></td>
                                            <td><?= Html::encode($cust['code']) ?></td>
                                            <td>
                                                <?php if($cust['location_info']): ?>
                                                    <span class="badge badge-light border">
                                                        <i class="fas fa-map-pin text-danger mr-1"></i> <?= Html::encode($cust['location_info']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted small">ไม่ได้ระบุพิกัด</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $cust['status'] == 1 ? '<span class="badge badge-success badge-pill px-3">ใช้งาน</span>' : '<span class="badge badge-secondary badge-pill px-3">ไม่ใช้งาน</span>' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php elseif ($view_type == 'map'): ?>
                        <div class="position-relative">
                            <div id="map"></div>
                        </div>
                    <?php elseif ($view_type == 'flow'): ?>
                        <div class="position-relative">
                            <div id="flow-network"></div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$json_data = json_encode($data);

if ($route_id && !empty($data)) {
    if ($view_type == 'map') {
        $markers = [];
        foreach ($data as $cust) {
            if ($cust['location_info']) {
                $coords = explode(',', $cust['location_info']);
                if (count($coords) == 2 && is_numeric($coords[0]) && is_numeric($coords[1])) {
                    $markers[] = [
                        'lat' => (float)trim($coords[0]),
                        'lng' => (float)trim($coords[1]),
                        'name' => $cust['name'],
                        'code' => $cust['code'],
                        'num' => $cust['route_num'] ?: '?'
                    ];
                }
            }
        }
        $markers_json = json_encode($markers);
        
        $js = <<<JS
            var markersData = $markers_json;
            var map = L.map('map');
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            if (markersData.length === 0) {
                 map.setView([13.7367, 100.5231], 6);
                 alert('พบข้อมูลลูกค้าแต่ไม่มีพิกัดแผนที่ในระบบ');
            } else {
                var bounds = [];
                var pathCoords = [];
                markersData.forEach(function(m) {
                    var icon = L.divIcon({
                        className: 'number-icon',
                        html: m.num
                    });

                    var marker = L.marker([m.lat, m.lng], {icon: icon})
                        .bindPopup('<div style="font-family:Kanit"><b>ลำดับที่: ' + m.num + '</b><br>' + m.name + '</div>')
                        .addTo(map);
                    
                    marker.bindTooltip(m.name, {
                        permanent: true, direction: 'right', offset: [15, 0], className: 'customer-tooltip'
                    });
                    
                    bounds.push([m.lat, m.lng]);
                    pathCoords.push([m.lat, m.lng]);
                });

                if (pathCoords.length > 1) {
                    var polyline = L.polyline(pathCoords, {
                        color: '#007bff', 
                        weight: 3, 
                        opacity: 0.6, 
                        dashArray: '8, 8'
                    }).addTo(map);
                }

                if (bounds.length > 0) {
                    map.fitBounds(bounds, {padding: [50, 50]});
                }
            }
JS;
        $this->registerJs($js);
    } elseif ($view_type == 'flow') {
        $js = <<<JS
            var rawData = $json_data;
            var nodes = new vis.DataSet();
            var edges = new vis.DataSet();

            var colorPalette = [
                '#ff4757', '#ff6b81', '#ffa502', '#ff7f50', '#2ed573', 
                '#1e90ff', '#3742fa', '#70a1ff', '#5352ed', '#eccc68'
            ];

            // Add starting node
            nodes.add({
                id: 'start', 
                label: 'START', 
                shape: 'circle',
                size: 30,
                color: { background: '#2f3542', border: '#2f3542' },
                font: { color: '#fff', size: 12, bold: true }
            });

            var prevId = 'start';
            rawData.forEach(function(cust, index) {
                var nodeId = 'cust_' + cust.id;
                var color = colorPalette[index % colorPalette.length];
                
                nodes.add({
                    id: nodeId,
                    label: (cust.route_num || (index + 1)).toString(),
                    title: cust.name + ' (' + cust.code + ')',
                    shape: 'circle',
                    size: 25,
                    color: {
                        background: color,
                        border: color,
                        highlight: { background: color, border: '#333' }
                    },
                    font: { color: '#fff', size: 16, bold: true, face: 'Kanit' },
                    // Display name below the circle
                    labelHighlightBold: true
                });

                edges.add({
                    from: prevId,
                    to: nodeId,
                    arrows: { to: { enabled: true, scaleFactor: 0.5 } },
                    color: { color: '#ced4da', opacity: 0.8 },
                    width: 2,
                    length: 100
                });

                // Add a separate hidden label or just use the title for name
                // To show name below the circle in vis-network, we can use a trick or just put it in the label
                // Let's put name below the number in the label
                nodes.update({id: nodeId, label: (cust.route_num || (index + 1)) + '\\n' + cust.name.substring(0, 15)});

                prevId = nodeId;
            });

            var container = document.getElementById('flow-network');
            var networkData = { nodes: nodes, edges: edges };
            var options = {
                physics: { enabled: false }, // No animation/movement
                interaction: {
                    hover: true,
                    zoomView: true,
                    dragView: true,
                    tooltipDelay: 100
                },
                layout: {
                    randomSeed: 2 // Keep layout consistent
                },
                nodes: {
                    margin: 10,
                    font: { multi: true }
                },
                edges: {
                    smooth: { type: 'continuous' }
                }
            };
            var network = new vis.Network(container, networkData, options);

            // Trigger fits to see all nodes
            network.once('stabilizationIterationsDone', function() {
                network.fit();
            });
JS;
        $this->registerJs($js);
    }
}
?>
