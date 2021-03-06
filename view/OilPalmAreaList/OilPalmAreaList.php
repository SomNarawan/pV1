<?php 
    session_start();
    
    $idUT = $_SESSION[md5('typeid')];
    $CurrentMenu = "OilPalmAreaList";

    include_once("./../layout/LayoutHeader.php");
    include_once("./../../query/query.php");

    $idformal = '';
    $fullname = '';
    $fpro = 0;
    $fdist = 0;

    $PROVINCE = getProvince();
    $DISTRINCT_PROVINCE = getDistrinctInProvince($fpro);

    $OILPALMAREALIST = getOilPalmAreaList();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">

<div class="container">
    <div class="row">
        <div class="col-xl-12 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active font-weight-bold"
                                style="color:<?=$color?>;">รายชื่อสวนปาล์มน้ำมัน</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="#">หน้าแรก</a>
                                <span> > </span>
                                <a class="link-path link-active" href="#"
                                    style="color:<?=$color?>;">รายชื่อสวนปาล์มน้ำมัน</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <?php   
        creatCard( "card-color-one",   "จำนวนสวน",  getCountFarm()." สวน ".getCountSubfarm()." แปลง", "waves" );
        creatCard( "card-color-two",   "พื้นที่ทั้งหมด", getCountArea()." ไร่", "group" );
        creatCard( "card-color-three", "จำนวนต้น",  getCountTree()." ต้น", "dashboard" );
        ?>

        <div class="col-xl-3 col-12 mb-4">
            <div class="card border-left-primary card-color-four shadow h-100 py-2" id="add"
                style="cursor:pointer;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold  text-uppercase mb-1">เพิ่มสวน</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">+1 คน</div>
                        </div>
                        <div class="col-auto">
                            <i class="material-icons icon-big">add_location</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <form action="OilPalmAreaList.php?isSearch=1" method="post">
        <div class="row">
            <div class="col-xl-12 col-12 mb-4">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header collapsed" id="headingOne" data-toggle="collapse"
                            data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"
                            style="cursor:pointer; background-color: <?=$color?>; color: white;">
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
                                        <select id="s_province" name="s_province" class="form-control">
                                            <option selected value=0>เลือกจังหวัด</option>
                                            <?php 
                                    for($i=1;$i<sizeof($PROVINCE);$i++){ 
                                        if($fpro==$PROVINCE[$i]["AD1ID"])
                                            echo '<option value="'.$PROVINCE[$i]["AD1ID"].'" selected>'.$PROVINCE[$i]["Province"].'</option>';
                                        else
                                            echo '<option value="'.$PROVINCE[$i]["AD1ID"].'">'.$PROVINCE[$i]["Province"].'</option>';
                                    }
                                    ?>
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
                                        <select id="s_distrinct" name="s_distrinct" class="form-control">
                                            <option selected value=0>เลือกอำเภอ</option>>
                                            <?php 
                                    if($fpro!=0){
                                        for($i=1;$i<sizeof($DISTRINCT_PROVINCE);$i++){ 
                                            if($fdist==$DISTRINCT_PROVINCE[$i]["AD2ID"])
                                                echo '<option value="'.$DISTRINCT_PROVINCE[$i]["AD2ID"].'" selected>'.$DISTRINCT_PROVINCE[$i]["Distrinct"].'</option>';
                                            else
                                                echo '<option value="'.$DISTRINCT_PROVINCE[$i]["AD2ID"].'">'.$DISTRINCT_PROVINCE[$i]["Distrinct"].'</option>';
                                        }
                                    }
                                    ?>

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
                                        <input type="text" class="form-control" id="s_name" name="s_name"
                                            <?php if($fullname!='') echo 'value="'.$fullname.'"'; ?>>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-11">
                                        <span>หมายเลขบัตรประชาชน</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="password" class="form-control input-setting" id="s_formalid"
                                            name="s_formalid" <?php if($idformal!='') echo 'value="'.$idformal.'"'; ?>>
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
    </form>



    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header card-header-table py-3">
            <h6 class="m-0 font-weight-bold" style="color:#006633;">สวนปาล์มน้ำมันในระบบ</h6>
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
                <table class="table table-bordered table-data" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>จังหวัด</th>
                            <th>อำเภอ</th>
                            <th>ชื่อเกษตรกร</th>
                            <th>ชื่อสวน</th>
                            <th>จำนวนแปลง</th>
                            <th>พื้นที่ปลูก</th>
                            <th>จำนวนต้น</th>
                            <th>รายละเอียด</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>จังหวัด</th>
                            <th>อำเภอ</th>
                            <th>ชื่อเกษตรกร</th>
                            <th>ชื่อสวน</th>
                            <th>จำนวนแปลง</th>
                            <th>พื้นที่ปลูก</th>
                            <th>จำนวนต้น</th>
                            <th>รายละเอียด</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php 
                            for($i=1;$i<sizeof($OILPALMAREALIST);$i++){
                        ?>
                        <tr>
                            <td class="text-left"><?php echo $OILPALMAREALIST[$i]['Province']; ?></td>
                            <td class="text-left"><?php echo $OILPALMAREALIST[$i]['Distrinct']; ?></td>
                            <td class="text-left"><?php echo $OILPALMAREALIST[$i]['FullName']; ?></td>
                            <td class="text-left"><?php echo $OILPALMAREALIST[$i]['Name']; ?></td>
                            <td class="text-right"><?php echo $OILPALMAREALIST[$i]['NumSubFarm']; ?> แปลง</td>
                            <td class="text-right"><?php echo $OILPALMAREALIST[$i]['AreaRai']; ?> ไร่
                                <?php $OILPALMAREALIST[$i]['AreaNgan']; ?> งาน</td>
                            <td class="text-right"><?php echo $OILPALMAREALIST[$i]['NumTree']; ?> ต้น</td>
                            <td style='text-align:center;'>
                                <a href='./OilPalmAreaListDetail.php?fmid=<?php echo $OILPALMAREALIST[$i]['FMID']; ?>'>
                                    <button type='button' id='btn_info' class="btn btn-info btn-sm btn_edit tt"
                                        data-toggle="tooltip" title="รายละเอียดข้อมูลสวน">
                                        <i class='fas fa-bars'></i>
                                    </button>
                                </a>
                                <button type='button' id='btn_delete' class="btn btn-danger btn-sm btn_edit tt"
                                    data-toggle="tooltip" title="ลบสวน" style="margin-right:10px;"
                                    onclick="delfunction('<?php echo $OILPALMAREALIST[$i]['Name']; ?>' , '<?php echo $OILPALMAREALIST[$i]['FMID']; ?>')">
                                    <i class='far fa-trash-alt'></i>
                                </button>
                            </td>
                        </tr>
                        <?php 
                            }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="Modal">

    </div>

</div>


<?php include_once("../layout/LayoutFooter.php"); ?>
<?php include_once("OilPalmAreaListModal.php"); ?>

<script src="OilPalmAreaList.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMLhtSzox02ZCq2p9IIuihhMv5WS2isyo&callback=initMap&language=th"
    async defer></script>