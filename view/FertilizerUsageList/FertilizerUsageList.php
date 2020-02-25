<?php
    session_start();

    $idUT = $_SESSION[md5('typeid')];
    $CurrentMenu = "FertilizerUsageList";

    include_once("../layout/LayoutHeader.php");
    include_once("./../../query/query.php");
    // include_once("./search.php");

    $FERTILISING[1] = array("dbID"=>1,"NameFarmer"=>"วิเชียร ธารสุวรรณ","NameFarm"=>"บจ.ซีพีไอ อะโกรเทค","NumSubf"=>2,
        "AreaRai"=>1,"NumTree"=>35,"NameFer"=>"สูตร2 15-5-25","HarvestVol"=>1422.22,"Vol1"=>50,"Vol2"=>25,"Vol3"=>25);

    $YearFer = getYearFer();
    $currentYear = date("Y") + 543;
    $backYear = date("Y") + 543 - 1;

    // $PROVINCE = getProvince();
    // $DISTRINCT_PROVINCE = getDistrinctInProvince($fpro); //fpro มาจาก search.php

    print_r(sizeof($FERTILISING));
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
                            <span class="link-active font-weight-bold" style="color:<?=$color?>;" >การใส่ปุ๋ย</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="#">หน้าแรก</a> 
                                <span> > </span>
                                <a class="link-path link-active" href="#" style="color:<?=$color?>;" >การใส่ปุ๋ย</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------------------- cards --------------------->
    <div class="row">
        <?php   
            creatCard( "card-color-one",   "ปริมาณที่ใส่ปุ๋ยรวม", getVolumeFertilising()." ก.ก", "panorama_vertical" ); 
            creatCard( "card-color-two",   "ผลผลิตรวม ปี".$backYear,  number_format(getHarvestBackYear())." ก.ก", "filter_vintage" );
            creatCard( "card-color-three",   "พื้นที่ทั้งหมด", getCountArea()." ไร่", "dashboard" ); 
            creatCard( "card-color-four",   "จำนวนต้นไม้ทั้งหมด", getCountTree()." ต้น", "format_size" ); 
        ?>
    </div>

    <!--------------------- Searching --------------------->
    <form action="FertilizerUsageList.php?isSearch=1" method="post">
        <div class="row">
            <div class="col-xl-12 col-12 mb-4">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header collapsed" 
                            id="headingOne" 
                            data-toggle="collapse"
                            data-target="#collapseOne" 
                            <?php 
                                if(isset($_GET['isSearch']) && $_GET['isSearch']==1)
                                    echo 'aria-expanded="true"';
                                else 
                                    echo 'aria-expanded="false"';
                            ?>
                            aria-controls="collapseOne"
                            style="cursor:pointer; background-color: <?=$color?>; color: white;">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fas fa-search"> ค้นหาขั้นสูง</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="collapseOne" 
                    <?php 
                        if(isset($_GET['isSearch']) && $_GET['isSearch']==1)
                            echo 'class="collapse show"';
                        else 
                            echo 'class="collapse"';
                    ?>
                    aria-labelledby="headingOne" 
                    data-parent="#accordion">
                    
                    <div class="card-header card-bg">
                        ตำแหน่งการใส่ปุ๋ยสวนปาล์มน้ำมัน
                    </div>
                    <div class="card-body" style="background-color: white; ">
                        <div class="row">
                            <div class="col-xl-6 col-12">
                                <div id="map" style="width:auto; height:75vh;"></div>
                            </div>
                            <div id="forMap" class="col-xl-6 col-12" >
                                
                                <div class="row">
                                    <div class="col-12">
                                        <span>ปี</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <select id="year" class="form-control">
                                            <?php
                                            for ($i = 1; $i < sizeof($YearFer); $i++) {
                                                
                                                echo '<option value='.$YearFer[$i]['Year2'].'>'.$YearFer[$i]['Year2'].'</option>';
                                            }
                                            // for($i=1;$i<sizeof($YearFer);$i++){ 
                                            //     if($year==$YearFer[$i]["Year2"])
                                            //         echo '<option value="'.$year[$i]["Year2"].'" selected>'.$year[$i]["Year2"].'</option>';
                                            //     else
                                            //         echo '<option value="'.$year[$i]["Year2"].'">'.$year[$i]["Year2"].'</option>';
                                            // }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 col-12">
                                        <div class="irs-demo">
                                            <b>ปริมาณการใส่ปุ๋ย (%)</b>
                                            <!-- <input type="text" id="palmvolsilder" value="" /> -->
                                            <input type="text" 
                                                id="palmvolsilder" name="palmvolsilder"  >
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

                                <div class="row">
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

                                <div class="row">
                                    <div class="col-12">
                                        <span>ชื่อเกษตรกร</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <!-- <input type="text" class="form-control" id="name"> -->
                                        <input type="text" class="form-control" 
                                            id="s_name" name="s_name"  
                                            <?php if($fullname!='') echo 'value="'.$fullname.'"'; ?>
                                        >
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <span>หมายเลขบัตรประชาชน</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <!-- <input type="password" class="form-control input-setting" id="idcard">
                                        <i class="far fa-eye-slash eye-setting"></i> -->
                                        <input type="password" class="form-control input-setting" 
                                            id="s_formalid" name="s_formalid"
                                            <?php if($idformal!='') echo 'value="'.$idformal.'"'; ?>
                                        >
                                        <i class="far fa-eye-slash eye-setting"></i>
                                    </div>
                                </div>

                                <div class="row mb-2 padding">
                                    <div class="col-12">
                                        <!-- <button type="button" id="btn_search" class="btn btn-success btn-sm form-control">ค้นหา</button> -->
                                        <button type="submit" id="btn_pass"
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
         
    <!--------------------- Resault Searched - DataTales --------------------->
    <div class="card shadow mb-4">
        <div class="card-header card-header-table py-3">
            <span class="getSelectYear " style="color:<?=$color?>;">การใส่ปุ๋ยสวนปาล์มน้ำมันในระบบปี <?=$currentYear;?></span>
            <!-- <h6 class="m-0 font-weight-bold" style="color:#006633;">การใส่ปุ๋ยสวนปาล์มน้ำมันในระบบปี</h6> -->
            <button type="button" id="btn-modal4" data-target="#modal-4" class="btn btn-success" data-toggle="modal" 
                    style="float:right;" ><i class="fas fa-plus"></i> เพิ่มการใส่ปุ๋ย</button>
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
                            <th rowspan="2">ชื่อเกษตรกร</th>
                            <th rowspan="2">ชื่อสวน</th>
                            <th rowspan="2">จำนวนแปลง</th>
                            <th rowspan="2">พื้นที่ปลูก (ไร่)</th>
                            <th rowspan="2">จำนวนต้น</th>
                            <th rowspan="2">ชนิดปุ๋ย</th>
                            <th class="getYear">ผลผลิตปี <?=$backYear;?></th>
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
                            <th>จำนวนแปลง</th>
                            <th>พื้นที่ปลูก<?php echo "<br>" ?>(ไร่)</th>
                            <th>จำนวนต้น</th>
                            <th>ชนิดปุ๋ย</th>
                            <th class="getYear">ผลผลิตปี <?=$backYear;?></th>
                            <th>ปริมาณที่ควรใส่</th>
                            <th>ปริมาณที่ใส่</th>
                            <th>ปริมาณที่ควรใส่เพิ่ม</th>
                            <th>รายละเอียด</th>
                        </tr>
                    </tfoot>

                    <tbody>
                        <?php 
                        for($i = 1 ;$i <= sizeof($FERTILISING) ;$i++){ 
                        ?>
                        <tr>
                            <td class="text-left"><?=$FERTILISING[$i]['NameFarmer']; ?></td>
                            <td class="text-left"><?=$FERTILISING[$i]['NameFarm']; ?></td>
                            <td class="text-right"><?=$FERTILISING[$i]['NumSubf']; ?></td>
                            <td class="text-right"><?=$FERTILISING[$i]['AreaRai']; ?></td>
                            <td class="text-right"><?=$FERTILISING[$i]['NumTree']; ?></td>
                            <td class="text-right"><?=$FERTILISING[$i]['NameFer']; ?></td>
                            <td class="text-right"><?=number_format($FERTILISING[$i]['HarvestVol'],2); ?></td>
                            <td class="text-right"><?=number_format($FERTILISING[$i]['Vol1'],4); ?></td>
                            <td class="text-right"><?=number_format($FERTILISING[$i]['Vol2'],4); ?></td>
                            <td class="text-right"><?=number_format($FERTILISING[$i]['Vol3'],4); ?></td>

                            <td style="text-align:center;">
                                <a href="#">
                                    <button type='button' id='btn_info' class="btn btn-info btn-sm btn_edit tt"
                                        data-toggle="tooltip" title="รายละเอียดข้อมูลการใส่ปุ๋ย">
                                        <i class='fas fa-bars'></i>
                                    </button>
                                </a>
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
<?php include_once("FertilizerUsageListModal.php"); ?>


<?php include_once("./import_Js.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMLhtSzox02ZCq2p9IIuihhMv5WS2isyo&callback=initMap&language=th" async defer></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../../croppie/croppie.js"></script>

<script src="FertilizerUsageList.js"></script>