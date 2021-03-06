<?php
include_once("../../dbConnect.php");
session_start();

$idUT = $_SESSION[md5('typeid')];
if(isset($_GET['farmerID']))
    $ufid = $_GET['farmerID'];
$CurrentMenu = "FarmerList";

include_once("../layout/LayoutHeader.php");
include_once("./../../query/query.php");

$FARMER = getFarmerByUFID($ufid);
$OWNERFARM = getOwnerFarm($ufid);
//map
$FARMEROWNER = getFarmOwnerID($ufid);

// print_r($FARMEROWNER);

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
<!-- ----------------------- crop photo ------------------------- -->
<link href="../../croppie/croppie.css" rel="stylesheet" />
<link href="style.css" rel="stylesheet" />

<body>

    <div class="container">

        <div class="row">
            <div class="col-xl-12 col-12 mb-4">
                <div class="card">
                    <div class="card-header card-bg">
                        <div class="row">
                            <div class="col-12">
                                <span class="link-active  font-weight-bold"
                                    style="color:<?=$color?>;">รายละเอียดเกษตรกร</span>
                                <span style="float:right;">
                                    <i class="fas fa-bookmark"></i>
                                    <a class="link-path" href="#">หน้าแรก</a>
                                    <span> > </span>
                                    <a class="link-path" href="FarmerList.php">รายชื่อเกษตรกร</a>
                                    <span> > </span>
                                    <a class="link-path link-active" href="#"
                                        style="color:<?=$color?>;">รายละเอียดเกษตรกร</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $sql = "SELECT `db-farmer`.`UFID` , sum.`f` FROM `db-farmer`
        LEFT JOIN (SELECT `UFID` , COUNT(CASE WHEN `UFID` IN (`UFID`) THEN 1 END) f FROM `db-farm` GROUP BY `UFID`) AS sum
        ON sum.`UFID` = `db-farmer`.`UFID` Where `db-farmer`.`UFID` = $ufid GROUP BY `UFID`";
        $myConDB = connectDB();
        $result = $myConDB->prepare($sql);
        $result->execute();
        ?>

        <div class="row">
            <?php   
            creatCard( "card-color-one",   "จำนวนสวน", getCountOwnerFarm($ufid)." สวน", "waves" ); 
            creatCard( "card-color-two",   "จำนวนแปลง",  getCountOwnerSubFarm($ufid)." แปลง", "group" );
            creatCard( "card-color-three",   "พื้นที่ทั้งหมด", getCountOwnerAreaRai($ufid)." ไร่", "format_size" ); 
            creatCard( "card-color-four",   "จำนวนต้นไม้", getCountOwnerTree($ufid)." ต้น", "format_size" ); 
        ?>
        </div>
        <div class="row">
            <div class="col-xl-6 col-12 mb-4">
                <div class="row">
                    <div class="col-xl-12 col-12">
                        <div class="card">
                            <div class="card-header card-bg font-weight-bold" style="color:<?=$color?>;">
                                <div>
                                    <span>ข้อมูลเกษตรกร</span>

                                </div>

                            </div>
                            <div class="card-body">

                                <div align="center">

                                    <img src=<?php 
                                            if ($FARMER[1]["Icon"] != NULL)
                                                echo $src = "../../icon/farmer/".$ufid."/".$FARMER[1]["Icon"]; 
                                            else if($FARMER[1]['Title']=='นาย') 
                                                echo $src = "../../icon/farmer/man.jpg" ;
                                            else 
                                                echo $src = "../../icon/farmer/woman.jpg" ;
                                            ?> alt="User" style="border-radius: 100%;width: 300px;height: 300px;">
                                </div>

                                <div class="row mb-4 mt-3">
                                    <div class="col-xl-3 col-12 text-right font-weight-bold" style="color:<?=$color?>;">
                                        <span>คำนำหน้า</span>
                                    </div>
                                    <div class="col-xl-9 col-12">
                                        <input type="text" class="form-control" id="rank"
                                            value="<?php echo $FARMER[1]['Title'] ?>" disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-xl-3 col-12 text-right font-weight-bold" style="color:<?=$color?>;">
                                        <span>ชื่อ</span>
                                    </div>
                                    <div class="col-xl-9 col-12">

                                        <input type="text" class="form-control" id="firstname"
                                            value="<?php echo $FARMER[1]["FirstName"] ?>" disabled>

                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-xl-3 col-12 text-right font-weight-bold" style="color:<?=$color?>;">
                                        <span>นามสกุล</span>
                                    </div>
                                    <div class="col-xl-9 col-12">
                                        <input type="text" class="form-control" id="lastname"
                                            value="<?php echo $FARMER[1]["LastName"] ?>" disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-xl-3 col-12 text-right font-weight-bold" style="color:<?=$color?>;">
                                        <span>ที่อยู่</span>
                                    </div>
                                    <div class="col-xl-9 col-12">
                                        <input type="text" class="form-control" id="address"
                                            value="<?php echo $FARMER[1]["Address"] ?>" disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-xl-3 col-12 text-right font-weight-bold" style="color:<?=$color?>;">
                                        <span>ตำบล</span>
                                    </div>
                                    <div class="col-xl-9 col-12">
                                        <input type="text" class="form-control" id="subdistrict"
                                            value="<?php echo $FARMER[1]["subDistrinct"] ?>" disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-xl-3 col-12 text-right font-weight-bold" style="color:<?=$color?>;">
                                        <span>อำเภอ</span>
                                    </div>
                                    <div class="col-xl-9 col-12">
                                        <input type="text" class="form-control" id="district"
                                            value="<?php echo $FARMER[1]["Distrinct"] ?>" disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-xl-3 col-12 text-right font-weight-bold" style="color:<?=$color?>;">
                                        <span>จังหวัด</span>
                                    </div>
                                    <div class="col-xl-9 col-12">
                                        <input type="text" class="form-control" id="province"
                                            value="<?php echo $FARMER[1]["Province"] ?>" disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-xl-3 col-12 text-right">
                                    </div>
                                    <div class="col-xl-9 col-12">

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-12 mb-4">
                <div class="card">
                    <div class="card-header card-bg font-weight-bold" style="color:<?=$color?>;">
                        ตำแหน่งสวนปาล์ม
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-12 mb-2">
                                <div id="map" style="width:auto; height:765px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-header card-bg" style="color:#006633;">
                        รายชื่อสวนของ<?php echo $FARMER[1]["FirstName"] . " " . $FARMER[1]["LastName"]; ?>
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
                                        <th>ชื่อสวน</th>
                                        <th>จังหวัด</th>
                                        <th>อำเภอ</th>
                                        <th>จำนวนแปลง</th>
                                        <th>พื้นที่ปลูก</th>
                                        <th>จำนวนต้น</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ชื่อสวน</th>
                                        <th>จังหวัด</th>
                                        <th>อำเภอ</th>
                                        <th>จำนวนแปลง</th>
                                        <th>พื้นที่ปลูก</th>
                                        <th>จำนวนต้น</th>
                                    </tr>
                                </tfoot>

                                <tbody>
                                    <?php 
                                for($i=1;$i<sizeof($OWNERFARM);$i++) {
                                    ?>
                                    <tr>
                                        <td><a href='./../OilPalmAreaList/OilPalmAreaListDetail.php?fmid=<?php echo $ufid; ?>'>
                                        <?php echo $OWNERFARM[$i]["Name"]; ?></td>
                                        <td><?php echo $OWNERFARM[$i]["Province"]; ?></td>
                                        <td><?php echo $OWNERFARM[$i]["Distrinct"]; ?></td>
                                        <td class="text-right">
                                            <?php if($OWNERFARM[$i]["NumSubFarm"] != NULL) echo $OWNERFARM[$i]["NumSubFarm"]; else echo "0"?>
                                            แปลง</td>
                                        <td class="text-right">
                                            <?php if($OWNERFARM[$i]["AreaRai"] != NULL) echo $OWNERFARM[$i]["AreaRai"]; else echo "0" ?>
                                            ไร่</td>
                                        <td class="text-right">
                                            <?php if($OWNERFARM[$i]['NumTree'] != NULL) echo $OWNERFARM[$i]['NumTree']; else echo "0" ?>
                                            ต้น</td>

                                    </tr>
                                    <?php
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php include_once("../layout/LayoutFooter.php"); ?>

        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMLhtSzox02ZCq2p9IIuihhMv5WS2isyo&callback=initMap&language=th"
            async defer></script>
        <script src="FarmerList.js"></script>
        <script src="FarmerListModal.js"></script>

        <script>
        function initMap() {
                var startLatLng = new google.maps.LatLng( <?php
                    if ($FARMEROWNER[1]["Latitude"] != NULL) echo $FARMEROWNER[1]["Latitude"];
                    else echo "13.7244416" ?> , <?php
                    if ($FARMEROWNER[1]["Longitude"] != NULL) echo $FARMEROWNER[1]["Longitude"];
                    else echo "100.3529157" ?> );

            mapdetail = new google.maps.Map(document.getElementById('map'), {
                // center: { lat: 13.7244416, lng: 100.3529157 },
                center: startLatLng,
                zoom: 8,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            mapdetail.markers = [];
            
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng( <?php echo $FARMEROWNER[1]["Latitude"] ?> , <?php echo $FARMEROWNER[1]["Longitude"] ?> ),
                    map: mapdetail,
                    title: "<?php echo $FARMEROWNER[1]["Name"]?>"
                });
                mapdetail.markers.push(marker);
        }
        </script>