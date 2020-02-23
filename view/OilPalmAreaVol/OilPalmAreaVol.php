<?php
session_start();

$idUT = $_SESSION[md5('typeid')];
$idUTLOG = $_SESSION[md5('LOG_LOGIN')];
$CurrentMenu = "OilPalmAreaVol";
$currentYear = date("Y") + 543;
$backYear = date("Y") + 543 - 1;

include_once("../layout/LayoutHeader.php"); 
include_once("../../dbConnect.php"); 
include_once("import_Js.php");
include_once("./../../query/query.php");

$OILPALMAREAVOL = getTableAllHarvest();

?>

<body>

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-12 mb-4">
                <div class="card">
                    <div class="card-header card-bg">
                        <div class="row">
                            <div class="col-12">
                                <span class="link-active font-weight-bold"
                                    style="color:<?=$color?>;">ผลผลิตสวนปาล์มน้ำมัน</span>
                                <span style="float:right;">
                                    <i class="fas fa-bookmark"></i>
                                    <a class="link-path" href="#">หน้าแรก</a>
                                    <span> > </span>
                                    <a class="link-path link-active" href="#"
                                        style="color:#006633;">ผลผลิตสวนปาล์มน้ำมัน</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php   
            creatCard( "card-color-one",   "ผลผลิตปี ".$currentYear, number_format(getHarvestCurrentYear(), 0, '.', ',')." ก.ก.", "waves" ); 
            creatCard( "card-color-two",   "ผลผลิตปี".$backYear, number_format(getHarvestBackYear(),0,'.',',')." ก.ก.", "dashboard" ); 
            creatCard( "card-color-three",   "พื้นที่ทั้งหมด", getCountArea()." ไร่", "format_size" ); 
แ        ?>

        </div>

        <div class="row">
            <div class="col-xl-12 col-12">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header collapsed" id="headingOne" data-toggle="collapse"
                            data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"
                            style="cursor:pointer; background-color: #006664; color: white;">
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
                        ตำแหน่งสวนปาล์มน้ำมัน
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-12">
                                <div id="map" style="width:auto;height:60vh;"></div>
                            </div>
                            <div class="col-xl-6 col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <span>จังหวัด</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <select id="province" class="js-example-basic-single form-control">
                                            <option disabled selected value="0">เลือกจังหวัด</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row  mb-2">
                                    <div class="col-12">
                                        <span>อำเภอ</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <select id="amp" class="js-example-basic-single form-control">
                                            <option disabled selected value="0">เลือกอำเภอ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-11">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-11">
                                        <span>ชื่อเกษตรกร</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="name">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-11">
                                        <span>หมายเลขบัตรประชาชน</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="password" class="form-control input-setting" id="FormalID">
                                        <i class="fa fa-eye-slash eye-setting" id="hide1"></i>
                                    </div>
                                </div>
                                <div class="row mb-2 padding">
                                    <div class="col-12">
                                        <button type="button" id="btn_search"
                                            class="btn btn-success btn-sm form-control">ค้นหา</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-header card-bg">
                        <div>
                            <span>ผลผลิตสวนปาล์มน้ำมันในระบบ</span>
                            <span style="float:right;">ปี <?php echo $currentYear; ?></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-xl-3 col-12">
                                <button type="button" id="btn_comfirm" class="btn btn-outline-success btn-sm"><i
                                        class="fas fa-file-excel"></i> Excel</button>
                                <button type="button" id="btn_comfirm" class="btn btn-outline-danger btn-sm"><i
                                        class="fas fa-file-pdf"></i> PDF</button>

                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-data" width="100%">
                                <thead>
                                    <tr>
                                        <th>ชื่อเกษตรกร</th>
                                        <th>ชื่อสวน</th>
                                        <th>จำนวนแปลง</th>
                                        <th>พื้นที่ปลูก</th>
                                        <th>จำนวนต้น</th>
                                        <th>ผลผลิต</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ชื่อเกษตรกร</th>
                                        <th>ชื่อสวน</th>
                                        <th>จำนวนแปลง</th>
                                        <th>พื้นที่ปลูก</th>
                                        <th>จำนวนต้น</th>
                                        <th>ผลผลิต</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                            for($i=0;$i<sizeof($OILPALMAREAVOL);$i++){
                                ?>
                                    <tr>
                                        <td><?php echo $OILPALMAREAVOL[$i]["ownerName"]; ?></td>
                                        <td><?php echo $OILPALMAREAVOL[$i]["farmName"];?></td>
                                        <td style="text-align:right;"><?php echo $OILPALMAREAVOL[$i]["subFarm"]; ?> แปลง</td>
                                        <td style="text-align:right;"><?php echo $OILPALMAREAVOL[$i]["area"]; ?> ไร่</td>
                                        <td style="text-align:right;"><?php echo $OILPALMAREAVOL[$i]["tree"]; ?> ต้น</td>
                                        <td style="text-align:right;"><?php echo $OILPALMAREAVOL[$i]["weight"];?> ก.ก.</td>
                                        <td style="text-align:center;">
                                            <form method="post" id="ID" name="formID" action="OilPalmAreaVolDetail.php">
                                                <input type="text" hidden class="form-control" name="farmID" id="farmID"
                                                    value="<?php echo $OILPALMAREAVOL[$i]["farmID"]?>">
                                                <button type="submit" id="btn_info" class="btn btn-info btn-sm"
                                                    data-toggle="tooltip" title="รายละเอียด"><i
                                                        class="fas fa-bars"></i></button></a>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                            }
                                        
                                        ?>
                                    <!-- <tr>
                                    <td>บรรยาวัชร</td>
                                    <td>ไลอ้อน</td>
                                    <td>50</td>
                                    <td>210</td>
                                    <td>50</td>
                                    <td>150</td>
                                    <td>19/05/1996</td>
                                    <td style="text-align:center;">
                                        <button type="button" id="btn_info" class="btn btn-info btn-sm"><i class="fas fa-bars"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>บรรยาวัชร</td>
                                    <td>ไลอ้อน</td>
                                    <td>50</td>
                                    <td>210</td>
                                    <td>50</td>
                                    <td>150</td>
                                    <td>19/05/1996</td>
                                    <td style="text-align:center;">
                                        <button type="button" id="btn_info" class="btn btn-info btn-sm"><i class="fas fa-bars"></i></button>
                                    </td>
                                </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once("../layout/LayoutFooter.php"); ?>


    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwVxLnsuNM9mJUqDFkj6r7FSxVcQCh4ic&callback=map_create"
        async defer></script>
    <script src="OilPalmAreaVol.js"></script>
    <script src="OilPalmAreaVolModal.js"></script>

    <script>
    $("#map_area").css('height', $("#forMap").css('height'));
    // $("#card_add").click(function () {
    //     $("body").append(addModal);
    //     $("#addModal").modal('show');
    // });

    // $("#btn_info").click(function () {
    //     console.log("testefe");
    // });

    $("#btn_delete").click(function() {
        swal({
            title: "ยืนยันการลบข้อมูล",
            icon: "warning",
            buttons: ["ยกเลิก", "ยืนยัน"],
        });
    });
    </script>