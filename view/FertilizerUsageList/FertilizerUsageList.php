<?php
    session_start();
    $idUT = $_SESSION[md5('typeid')];
    $CurrentMenu = "FertilizerUsageList";
    $currentYear = date("Y") + 543;
    $backYear = date("Y") + 543 - 1;
?>

<?php
    include_once("../layout/LayoutHeader.php");
    require_once("../../dbConnect.php");

    $sumFertilising = selectDataOne("SELECT SUM(`log-fertilising`.`Vol`) AS sumFertilising FROM `log-fertilising` 
        INNER JOIN `dim-time`ON `dim-time`.`ID` = `log-fertilising`.`DIMdateID` WHERE `log-fertilising`.`isDelete` = 0");
    $sumHarvest =  selectDataOne("SELECT SUM(`fact-farming`.`HarvestVol`) AS sumHarvest FROM `fact-farming` 
        INNER JOIN `dim-time` ON `dim-time`.`ID` = `fact-farming`.`DIMdateID` 
        WHERE `dim-time`.`Year2` = YEAR(CURDATE())+543-1 AND `fact-farming`.`isDelete` = 0 AND `fact-farming`.`DIMsubFID` IS NULL");

    $totalArea = selectDataOne("SELECT SUM(`db-subfarm`.`AreaRai`) AS totalArea FROM `db-subfarm`WHERE 1");
    $totalPalm = selectDataOne("SELECT (SUM(IF( lpt.`NumGrowth1` IS NULL , 0, lpt.`NumGrowth1`))
        +SUM(IF( lpt.`NumGrowth2` IS NULL , 0, lpt.`NumGrowth2`))-SUM(IF( lpt.`NumDead` IS NULL , 0, lpt.`NumDead`))) AS totalPalm
        FROM `log-planting` AS lpt
        WHERE lpt.`isDelete` = 0");

    $totalYear = selectData("SELECT `dim-time`.`Year2` FROM `log-fertilising`
        INNER JOIN `dim-time`ON `dim-time`.`ID` = `log-fertilising`.`DIMdateID`
        WHERE `log-fertilising`.`isDelete`= 0 
        GROUP BY `dim-time`.`Year2` 
        ORDER BY `dim-time`.`Year2` DESC");

    $checkFertilising = selectData("SELECT `log-fertilising`.`ID`,IF(`log-fertilising`.`FACTferID` IS NULL, 1,0) AS a
        FROM `log-fertilising`
        INNER JOIN `fact-fertilizer`
        WHERE `log-fertilising`.`isDelete` = 0
        GROUP BY `log-fertilising`.`ID` ");

    
    // echo $sumFertilising['sumFertilising'];
    //print_r($checkFertilising);
?>

<style>
    .img_scan {}

    .text-left {
        align: left;
    }

    .text-right {
        align: right;
    }

    .margin-photo {
        margin-top: 25px;
    }

    .set-images {
        width: 100%;
        height: 250px;
    }

    .padding {
        padding-top: 10px;
    }

    .export-button {
        background: white;
        margin-right: 7px;
        margin-bottom: 10px;
    }

    .mar {
        margin-top: 5px;
    }

    font {
        font-family: 'Kanit';
        font-weight: normal;
    }

    span.select2-container {
        box-sizing: border-box;
        display: block;
        margin: 0;
        position: relative;
    }

    .border-from-control {
        border: 3px solid rgba(78, 115, 223, 0.3);
        border-radius: .55rem;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        width: 100%;
        color: #6E707E;
        height: calc(1.5em + .75rem + 2px);
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #d1d3e2;
        border-radius: .35rem;
    }

    span.select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 15px;
    }

    span.select2-container--default .select2-selection--single {
        display: contents;
        background-color: #fff;
        border: 0px;
        border-radius: 4px;
    }

    span.select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #6E707E;
        line-height: 25px;
    }

    input.gj-textbox-md {
        border: 1px solid #d1d3e2;
        border-radius: .35rem;
        height: calc(1.5em + .75rem + 2px);
        padding: .375rem .9rem;
        color: #6e707e;
        font-family: 'Kanit', sans-serif;
    }

    .gj-datepicker-md [role=right-icon] {
        padding-top: 6.5px;
        padding-right: 6.5px;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../../croppie/croppie.css">

<div class="container">
    <!--------------------- Head Link --------------------->
    <div class="row">
        <div class="col-xl-12 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active" style="color: #006664;" >การใส่ปุ๋ย</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <!-- เข้าหน้า home page -->
                                <a class="link-path" href="#">หน้าแรก</a>
                                <span> > </span>
                                <!-- เข้าหน้า Fertilizer -->
                                <a class="link-path link-active" style="color: #006664;" href="#">การใส่ปุ๋ย</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------------------- cards --------------------->
    <div class="row">
        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-one shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">ปริมาณที่ใส่ปุ๋ยรวม</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($sumFertilising['sumFertilising'],4) . " "; ?>ก.ก</div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">panorama_vertical</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-two shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">ผลผลิตรวม ปี<?php echo $backYear ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($sumHarvest['sumHarvest'],2) . " "; ?>ก.ก</div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">filter_vintage</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-three shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">พื้นที่ทั้งหมด</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($totalArea['totalArea']) . " "; ?>ไร่</div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">dashboard</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-four shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">ต้นปาล์มทั้งหมด</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo number_format($totalPalm['totalPalm']) . " "; ?>ต้น</div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">format_size</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------------------- Searching --------------------->
    <div class="row">
        <div class="col-xl-12 col-12">
            <div id="accordion">
                <div class="card">
                    <div class="card-header collapsed" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="cursor:pointer; background-color: #006664; color: white;">
                        <div class="row">
                            <div class="col-3">
                                <i class="fas fa-search"> ค้นหาขั้นสูง</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="collapseOne" class="card collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-header card-bg">
                    ตำแหน่งการใส่ปุ๋ยสวนปาล์มน้ำมัน
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-12">
                            <div id="map" style="width:auto; height:75vh;"></div>
                        </div>
                        <div class="col-xl-6 col-12" id="forMap">
                            <div class="row">
                                <div class="col-12">
                                    <span>ปี</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <select id="year" class="form-control">
                                        <?php
                                        for ($i = 1; $i <= $totalYear[0]['numrow']; $i++) {
                                            echo "<option value='{$totalYear[$i]['Year2']}'>{$totalYear[$i]['Year2']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-12">
                                    <div class="irs-demo">
                                        <b>ปริมาณการใส่ปุ๋ย (%)</b>
                                        <input type="text" id="palmvolsilder" value="" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <span>จังหวัด</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <select id="province" class="js-example-basic-single">
                                        <option disabled selected>เลือกจังหวัด</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <span>อำเภอ</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <select id="amp" class="js-example-basic-single">
                                        <option disabled selected>เลือกอำเภอ</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <span>ชื่อเกษตรกร</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" id="name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <span>หมายเลขบัตรประชาชน</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="password" class="form-control input-setting" id="passport">
                                    <i class="far fa-eye-slash eye-setting"></i>
                                </div>
                            </div>
                            <div class="row mb-2 padding">
                                <div class="col-12">
                                    <button type="button" id="btn_search" class="btn btn-success btn-sm form-control">ค้นหา</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------------------- table gard --------------------->
    <div class="row mt-4 mb-4">
        <div class="col-xl-12 col-12">
            <div class="card">
                <div class="card-header card-bg">
                    <div>
                        <span class="getSelectYear">การใส่ปุ๋ยสวนปาล์มน้ำมันในระบบปี <?php echo $currentYear; ?></span>
                        <button type="button" id="btn-modal4" style="float:right;" class="btn btn-success" data-toggle="modal" data-target="#modal-4"><i class="fas fa-plus"></i> เพิ่มการใส่ปุ๋ย</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered table-striped table-hover table-data" width="100%">
                            <thead style="text-align:center;">
                                <tr>
                                    <th rowspan="2">ชื่อเกษตรกร</th>
                                    <th rowspan="2">ชื่อสวน</th>
                                    <th rowspan="2">ชื่อแปลง</th>
                                    <th rowspan="2">พื้นที่ปลูก (ไร่)</th>
                                    <th rowspan="2">จำนวนต้น</th>
                                    <th rowspan="2">ชนิดปุ๋ย</th>
                                    <th class="getYear">ผลผลิตปี <?php echo $backYear; ?></th> <!-- พ.ศ.ปีที่ผ่านมา  -->
                                    <th colspan="3">ปริมาณปุ๋ย(ก.ก.)</th>
                                    <th rowspan="2">รายละเอียด</th>
                                </tr>
                                <tr>
                                    <th>(ก.ก./ไร่)</th>
                                    <th>ที่ควรใส่</th>
                                    <th>ที่ใส่</th>
                                    <th>ที่ควรใส่เพิ่ม</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ชื่อเกษตรกร</th>
                                    <th>ชื่อสวน</th>
                                    <th>ชื่อแปลง</th>
                                    <th>พื้นที่ปลูก<?php echo "<br>" ?>(ไร่)</th>
                                    <th>จำนวนต้น</th>
                                    <th>ชนิดปุ๋ย</th>
                                    <th class="getYear">ผลผลิตปี <?php echo $backYear; ?></th>
                                    <th>ปริมาณปุ๋ยที่ควรใส่</th>
                                    <th>ปริมาณปุ๋ยที่ใส่</th>
                                    <th>ปริมาณที่ควรใส่เพิ่ม</th>
                                    <th>รายละเอียด</th>
                                </tr>
                            </tfoot>
                            <tbody id="fetchDatatable1"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!---------------------  Modal ADD --------------------->
    <div class="modal fade" id="modal-4" role="dialog">
        <form method="post" enctype="multipart/form-data" id="form">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header header-modal">
                        <h4 class="modal-title setTextEdit">เพิ่มการใส่ปุ๋ย</h4>
                    </div>
                    <div class="modal-body">
                        <div class="main">
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>วันที่</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <input class="form-control" width="auto" id="p_date" name="p_date" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>สวน</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <select class="js-example-basic-single" id="p_farm" name="p_farm"></select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>แปลง</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <select class="js-example-basic-single" id="p_subfarm" name="p_subfarm"></select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>ชนิดปุ๋ย</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <select class="js-example-basic-single" id="fertilizer1" name="fertilizer1"></select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>ปริมาณปุ๋ยที่ใส่ (ก.ก.)</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <input placeholder="ปริมาณปุ๋ยที่ใส่" type="text" class="form-control" id="p_vol" name="p_vol" onblur="check_num();" value=""></input>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>รูปภาพ</span>
                                </div>
                                <div class="col-xl-9 col-12">
                                    <div class="grid-img-multiple" id="p_insert_img"></div>
                                </div>
                            </div>
                            <input type="hidden" name="pestAlarmID" id="pestAlarmID" value="0" />
                        </div>
                        <div class="crop-img">
                            <center>
                                <div id="upload-demo" class="center-block"></div>
                            </center>
                        </div>
                        <input type="hidden" id="hidden_id" name="photo" value="insert" />
                        <div class="modal-footer normal-button">
                            <button id="m_success" type="button" class="btn btn-success">ยืนยัน</button>
                            <button id="m_not_success" type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                        </div>
                        <div class="modal-footer crop-button">
                            <button type="button" class="btn btn-success btn-crop">ยืนยัน</button>
                            <button type="button" class="btn btn-danger btn-cancel-crop">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!---------------------  Modal Button --------------------->
    <div class="modal fade" id="modal-3" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h4 class="modal-title">ข้อมูลสำคัญของศัตรูพืช</h4>
                </div>
                <div class="modal-body" id="noteModalBody">
                    <span id="Note"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<?php include_once("./import_Js.php"); ?>

</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMLhtSzox02ZCq2p9IIuihhMv5WS2isyo&callback=initMap&language=th" async defer></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../../croppie/croppie.js"></script>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $('.js-example-basic-single').on('select2:open', function(e) {
            $(this).next().addClass("border-from-control");
        });
        $('.js-example-basic-single').on('select2:close', function(e) {
            $(this).next().removeClass("border-from-control");
        });

        $('#p_date').datepicker({
            showOtherMonths: true,
            format: 'yyyy-mm-dd'
        });
        
        $('#e_p_date').datepicker({
            showOtherMonths: true,
            format: 'yyyy-mm-dd'
        });

    });

    pdfMake.fonts = {
        THSarabun: {
            normal: 'THSarabun.ttf',
            bold: 'THSarabun-Bold.ttf',
            italics: 'THSarabun-Italic.ttf',
            bolditalics: 'THSarabun-BoldItalic.ttf'
        }
    }

    // LoadMap
    function initMap() {
        // The location of Uluru
        //alert(coordinate[0].lat);
        var marker = {
            lat: 12.815300,
            lng: 101.490997
        };

        // The map, centered at Uluru
        var map = new google.maps.Map(
            document.getElementById('map'), {
                zoom: 16,
                center: marker
            });
        // The marker, positioned at Uluru
        var marker = new google.maps.Marker({
            position: marker,
            map: map
        });
        // Construct the polygon.
        var area = new google.maps.Polygon({
            paths: zone,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35
        });
        area.setMap(map);
    }

    let dataProvince;
    let dataDistrinct;
    let numProvince = 0;
    let ID_Province = null;
    let ID_Distrinct = null;
    let name = null;
    let passport = null;

    let dataFarm;
    let dataSubFarm;
    let ID_Farm = null;
    let ID_SubFarm = null;
    let dataFertilizer;
    let ID_Fertilizer = null;

    let data;
    let year = null;
    let score_From = 0;
    let score_To = 0;
    let time = new Date();
    let currentYear = time.getFullYear() //ค.ศ. ปัจจุบัน

    document.getElementById("province").addEventListener("load", loadProvince());
    document.getElementById("btn-modal4").addEventListener("load", loadFarm());

    // -------------------------- functions --------------------------
    // โหลดจังหวัด
    function loadProvince() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataProvince = JSON.parse(this.responseText);
                let text = "";
                //`<option value=null>เลือกจังหวัด</option>`
                for (i in dataProvince) {
                    text += ` <option value="${dataProvince[i].AD1ID}">${dataProvince[i].Province}</option> `
                    numProvince++;
                }
                $("#province").append(text);
            }
        };
        xhttp.open("GET", "./loadProvince.php", true);
        xhttp.send();
    }
    // โหลดอำเภอ
    function loadDistrinct(id) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataDistrinct = JSON.parse(this.responseText);
                let text = "<option disabled selected>เลือกอำเภอ</option>";
                for (i in dataDistrinct) {
                    text += ` <option value="${dataDistrinct[i].AD2ID}">${dataDistrinct[i].Distrinct}</option> `
                }
                $("#amp").append(text);
            }
        };
        xhttp.open("GET", "./loadDistrinct.php?id=" + id, true);
        xhttp.send();
    }
    // โหลด Farm
    function loadFarm() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataFarm = JSON.parse(this.responseText);
                let text = "<option disabled selected value='-1'>เลือกสวน</option>";
                for (i in dataFarm) {
                    text += ` <option value="${dataFarm[i].FMID}">${dataFarm[i].Name}</option> `
                }
                $("#p_farm").html(text);
            }
        };
        xhttp.open("GET", "./loadFarm.php", true);
        xhttp.send();
    }
    // โหลด SubFarm
    function loadSubFarm(farm, ID) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataSubFarm = JSON.parse(this.responseText);
                let text = "<option value='-1' disabled selected>เลือกแปลง</option>";
                for (i in dataSubFarm) {
                    text += ` <option value="${dataSubFarm[i].FSID}">${dataSubFarm[i].Name}</option> `
                }
                $(ID).html(text);
            }
        };
        xhttp.open("GET", "./loadSubFarm.php?farm=" + farm, true);
        xhttp.send();
    }

    function getFer() {
            $("#fertilizer1");
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    dataFarm = JSON.parse(this.responseText);
                    let text = "<option disabled selected value='-1'>เลือกชนิดปุ๋ย</option>";
                    for (i in dataFarm) {
                        text += ` <option value="${dataFarm[i].FMID}">${dataFarm[i].Name}</option> `
                    }
                    $("#fertilizer1").html(text);
                }
            };
            xhttp.open("GET", "./getFer.php", true);
            xhttp.send();
    }

    loadData((currentYear + 543  ))
    function loadData(year, data_search) {
        $('#example').DataTable().destroy();
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                data = JSON.parse(this.responseText);
                //console.log(this.responseText)
                let text = "";
                var NumSubFarm = [],
                    AreaRai = [],
                    NumTree = [],
                    HarvestVol = [],
                    Vol1 = [],
                    Vol2 = [],
                    Vol3 = []
                var nf = new Intl.NumberFormat();
                for (j in data) {
                    AreaRai[j] = nf.format(data[j].AreaRai);
                    NumTree[j] = nf.format(data[j].NumTree);
                    HarvestVol[j] = nf.format(data[j].weight);
                    Vol1[j] = nf.format(data[j].VOL1);
                    Vol2[j] = nf.format(data[j].VOL2);
                    Vol3[j] = nf.format(data[j].VOL3);
                }
                for (i in data) {
                    text += ` <tr>
                            <th class="text-left">${data[i].Alias}</th>
                            <th class="text-left">${data[i].nfarm}</th>
                            <th class="text-right">${data[i].nsubfarm}</th>
                            <th class="text-right">${AreaRai[i]}</th>
                            <th class="text-right">${NumTree[i]}</th>
                            <th class="text-right">${data[i].nfertilizer}</th>
                            <th class="text-right">${HarvestVol[i]}</th>
                            <th class="text-right">${Vol1[i]}</th>
                            <th class="text-right">${Vol2[i]}</th>
                            <th class="text-right">${Vol3[i]}</th>
                            <th style="text-align:center;">
                                <a href='FertilizerUsageListDetail.php?farmerID=${data[i].farmerID}&farmID=${data[i].farmID}&subfarmID=${data[i].subfarmID}&year=${data[i].year}&LFID=${data[i].LFID}&FFID=${data[i].FFID}&DFID=${data[i].DFID}'><button type="button" id="btn_info" class="btn btn-info btn-sm"><i class="fas fa-bars"></i></button></a>
                            </th>
                        </tr>`
                }
                $("#fetchDatatable1").html(text)
                $('#example').DataTable({
                    dom: '<"row"<"col-sm-6"B>>' +
                        '<"row"<"col-sm-6 mar"l><"col-sm-6 mar"f>>' +
                        '<"row"<"col-sm-12"tr>>' +
                        '<"row"<"col-sm-5"i><"col-sm-7"p>>',
                    buttons: [{
                            extend: 'excel',
                            text: '<i class="fas fa-file-excel"> <font> Excel</font> </i>',
                            className: 'btn btn-outline-success btn-sm export-button'
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fas fa-file-pdf"> <font> PDF</font> </i>',
                            className: 'btn btn-outline-danger btn-sm export-button',
                            pageSize: 'A4',
                            customize: function(doc) {
                                doc.defaultStyle = {
                                    font: 'THSarabun',
                                    fontSize: 16
                                };
                            }
                        }
                    ]
                });
            }
        };
       
        xhttp.open("POST", "./loadFertilizer.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`year=${year}`+ '&search=search' + data_search);
    }

    // โหลด Photo Edit [log-pestAlarm] -> PICS
    function loadPhoto_LogPestAlarm2(PICS, id) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let data1 = JSON.parse(this.responseText);
                let text = ``;
                for (i in data1) {
                    text += `<div class="card" width="70px" hight="70px">
                                    <div class="card-body" style="padding:0;">
                                        <img class="img_scan" src = "${PICS+"/"+data1[i]}" id="${i}_CropPhoto" width="100%" hight="100%" />
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-warning edit-img">แก้ไข</button>
                                        <button type="button" class="btn btn-danger delete-img">ลบ</button>
                                    </div>
                                </div>`
                }
                text += `<div class="img-reletive">
                            <img src="https://ast.kaidee.com/blackpearl/v6.18.0/_next/static/images/gallery-filled-48x48-p30-6477f4477287e770745b82b7f1793745.svg" width="50px" height="50px" alt="">
                            <input type="file" class="form-control" id="p_photo" name="p_photo[]" accept=".jpg,.png" multiple>
                        </div>`;
                $(id).html(text);
            }
        };
        xhttp.open("POST", "./scanDir.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`path=${PICS}`);
    }
    // -------------------------- functions --------------------------

    //Start Event Select_จังหวัด && Select_อำเภอ
    $("#province").on('change', function() {
        $("#amp").empty();
        let x = document.getElementById("province").value;
        for (let i = 0; i < numProvince; i++)
            if (dataProvince[i].AD1ID == x) {
                ID_Province = x;
                ID_Distrinct = null;
                loadDistrinct(dataProvince[i].AD1ID);
            }
    });
    $("#amp").on('change', function() {
        let x = document.getElementById("amp").value;
        ID_Distrinct = x;
    });
    // Start Event Select_สวน
    $("#p_farm").on('change', function() {
        $("#p_subfarm").empty();
        let x = document.getElementById("p_farm").value;
        ID_Farm = x;
        loadSubFarm(x, "#p_subfarm");
    });
    // Start Event Select_แปลง
    $("#p_subfarm").on('change', function() {
        let x = document.getElementById("p_subfarm").value;
        ID_SubFarm = x;
    });
    $("#fertilizer1").on('change', function() {
        let ID_fer = document.getElementById("fertilizer1").value;
    });

    // Start Event Create Modal && LoadFarm
    $("#btn-modal4").on('click', function() {
        let current_datetime = new Date()
        let formatted_date = (current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate());
        $('#p_date').val(formatted_date);
        loadFarm();
        $('#p_farm').val(-1).trigger('change').html("<option disabled selected>เลือกสวน</option>");
        $('#p_subfarm').html("<option disabled selected>เลือกแปลง</option>");
        getFer();
        $('#p_fertilizer').html("<option disabled selected>เลือกชนิดปุ๋ย</option>");
        $('#p_vol').html("<input disabled>ปริมาณปุ๋ย</input>");
        $('#p_insert_img').html(`<div class="img-reletive">
                                    <img src="https://ast.kaidee.com/blackpearl/v6.18.0/_next/static/images/gallery-filled-48x48-p30-6477f4477287e770745b82b7f1793745.svg" width="50px" height="50px" alt="">
                                    <input type="file" class="form-control" id="p_photo" name="p_photo[]" accept=".jpg,.png" multiple>
                                </div>`);
        
        $('#hidden_id').attr('value', "insert");
    });
    
    // Start Submit Create Modal
    $(document).on('click', '#m_success', function() {
        check_num()
        
        let form = new FormData($('#form')[0]);
        let pic_sc = new Array();
        $('.img_scan').each(function(i, obj) {
            pic_sc.push($(this).attr('src') + 'manu20');
        });
        form.append('pic', pic_sc);

        $.ajax({
            type: "POST",
            data: form,
            url: "insert_edit.php",
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.reload();
                // console.log(result);
            }
        });
    });

    // Start Edit Botton
    $(document).on('click', '.btn-edit', function() {
        // $(".setTextEdit").html("แก้ไขการใส่ปุ๋ย")
        let id = $(this).attr('id');
        let text = "";

        $('#p_date').val(data[id].Date);

        for (i in dataFarm)
            text += ` <option value="${dataFarm[i].FMID}">${dataFarm[i].Name}</option> `;
        $("#p_farm").html(text);
        $('#p_farm').val(data[id].FID).trigger('change');

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataSubFarm = JSON.parse(this.responseText);
                let text = "";
                for (i in dataSubFarm)
                    text += ` <option value="${dataSubFarm[i].FSID}">${dataSubFarm[i].Name}</option> `
                $("#p_subfarm").html(text);
                $('#p_subfarm').val(data[id].SFID).trigger('change');
            }
        };
        xhttp.open("GET", "./loadSubFarm.php?farm=" + data[id].FID, true);
        xhttp.send();

        $('#p_rank').html(`<option value="1">แมลงศัตรูพืช</option>
                            <option value="2">โรคพืช</option>
                            <option value="3">วัชพืช</option>
                            <option value="4">ศัตรูพืชอื่นๆ</option>`);
        $('#p_rank').val(data[id].dbpestTID).trigger('change');

        loadPest(data[id].dbpestTID, id, "#p_pest", "edit");

        document.getElementById("p_note").value = data[id].Note;

        loadPhoto_LogPestAlarm2(data[id].PICS, "#p_insert_img");

        $('#hidden_id').attr('value', "edit");
        $('#pestAlarmID').attr('value', data[id].ID);
    });

    $("#palmvolsilder").ionRangeSlider({
        type: "double",
        from: 0,
        to: 0,
        step: 1,
        min: 0,
        max: 100,
        grid: true,
        grid_num: 10,
        grid_snap: false,
        onFinish: function(data) {
            score_From = data.from;
            score_To = data.to;
            console.log(score_From + " " + score_To);
        }
    });


    /*<! ----------------------------------------------------- Function && Event All Photo ----------------------------------------------------------- !>*/
    let count = 0;
    let idImg;
    $('.crop-img').hide()
    $('.crop-button').hide()
    // Start Insert Photo
    $(document).on('change', '#p_photo', function() {
        img_Preview_Upload(this, '#p_insert_img');
    });

    // Show Preview Photo --> After Insert
    function img_Preview_Upload(input, Target) {
        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    console.log(count + "  *-*-*\n");
                    $(Target).prepend(`<div class="card" width="70px" hight="70px">
                                            <div class="card-body" style="padding:0;">
                                                <img class="img_scan" src = "${event.target.result}" id = "${count++}_CropPhoto" width="100%" hight="100%" />
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-warning edit-img">แก้ไข</button>
                                                <button type="button" class="btn btn-danger delete-img">ลบ</button>
                                            </div>
                                        </div>`)
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
        $(input).val('');
    }

    // Start Delete Photo
    $(document).on('click', '.delete-img', function() {
        $(this).parent().parent().remove()
    });

    // Start Edit-Crop Photo
    $(document).on('click', '.edit-img', function() {
        let me = $(this).parent().prev().children().attr('src');
        idImg = $(this).parent().prev().children().attr('id');
        //console.log(me + "  " + idImg)
        $('.main').hide();
        $('.normal-button').hide();
        $('.crop-img').show();
        $('.crop-button').show();
        let UC = $('#upload-demo').croppie({
            viewport: {
                width: 200,
                height: 200,
            },
            enforceBoundary: false,
            enableExif: true
        });
        UC.croppie('bind', {
            url: me
        }).then(function() {
            console.log('jQuery bind complete');
        });
    });

    // Start Submit Crop Photo
    $(document).on('click', '.btn-crop', function(ev) {
        $('#upload-demo').croppie('result', {
                type: 'canvas',
                size: 'viewport'
            })
            .then(function(r) {
                $('.main').show()
                $('.normal-button').show()
                $('.crop-img').hide()
                $('.crop-button').hide()
                $("#" + idImg).attr('src', r);
                console.log(idImg + " *-*");
            });
        $('#upload-demo').croppie('destroy');
    });

    // Start Cancel Crop Photo
    $(document).on('click', '.btn-cancel-crop', function(ev) {
        $('.main').show();
        $('.normal-button').show();
        $('.crop-img').hide();
        $('.crop-button').hide();
        $('#upload-demo').croppie('destroy');
    });
    /*<! ----------------------------------------------------- Function && Event All Photo ----------------------------------------------------------- !>*/
    
    $(document).on('click', '.btn-detail', function() {
        let id = $(this).attr('id');
        localStorage.setItem("data", JSON.stringify(data[id]));
        // let x = localStorage.getItem('data');
        // console.log(x);
        // console.log(JSON.parse(x).FullName);
        window.location.href = "http://localhost/KU-PALM-master/view/Water/WaterDetail.php";
    });

    $("#btn_search").on('click', function() {
        year = document.getElementById("year").value;
        name = document.getElementById("name").value;
        passport = document.getElementById("passport").value;

        $(".getYear").html("ผลผลิตปี " + (year - 1))
        $(".getSelectYear").html("การใส่ปุ๋ยสวนปาล์มน้ำมันในระบบปี " + year)

        console.log(" [ " + year + " " + score_From + " " + score_To +
            " " + ID_Province + " " + ID_Distrinct + " " + name + " " + passport + " ] ");
        let data_search = "";
        if (ID_Province != null) {
            data_search += "&ID_Province=" + ID_Province;
        }
        if (ID_Distrinct != null) {
            data_search += "&ID_Distrinct=" + ID_Distrinct;
        }
        if (name != "") {
            data_search += "&name=" + name;
        }
        if (passport != "") {
            data_search += "&passport=" + passport;
        }
        loadData(year, data_search);

        $("#collapseOne").children().children().addClass("collapsed");
        document.getElementById("headingOne").setAttribute("aria-expanded", "false");
        $("#collapseOne").removeClass("show");

    });


</script>