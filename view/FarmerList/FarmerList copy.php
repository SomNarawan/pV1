<?php 
    session_start();
    
    $idUT = $_SESSION[md5('typeid')];
    $CurrentMenu = "FarmerList";

    include_once("../layout/LayoutHeader.php");
    include_once("./../../query/query.php");
    include_once("./search.php");

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">

<div class="container">
    <div class="row">
        <div class="col-xl-12 col-12 mb-4">
            <div class="card">
                <div class="card-header card-bg">
                    <div class="row">
                        <div class="col-12">
                            <span class="link-active font-weight-bold" style="color:<?=$color?>;">รายชื่อเกษตรกร</span>
                            <span style="float:right;">
                                <i class="fas fa-bookmark"></i>
                                <a class="link-path" href="#">หน้าแรก</a>
                                <span> > </span>
                                <a class="link-path link-active" href="#" style="color:<?=$color?>;">รายชื่อเกษตรกร</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <?php   
            creatCard( "card-color-one",   "จำนวนเกษตรกร", getcountFarmer()." คน", "waves" ); 
            creatCard( "card-color-two",   "จำนวนสวน",  getCountFarm()." สวน ".getCountSubfarm()." แปลง", "group" );
            creatCard( "card-color-three",   "พื้นที่ทั้งหมด", getCountArea()." ไร่", "format_size" ); 
            creatCard( "card-color-four",   "จำนวนต้นไม้", getCountTree()." ต้น", "format_size" ); 

        ?>
    </div>

    <form action="FarmerList.php?isSearch=1" method="post">
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

                    <div class="card-body" style="background-color: white; ">
                        <div class="row mb-4 ">
                            <div class="col-xl-4 col-12 text-right">
                                <span>หมายเลขบัตรประชาชน</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <input type="password" class="form-control input-setting" 
                                    id="s_formalid" name="s_formalid"
                                    <?php if($idformal!='') echo 'value="'.$idformal.'"'; ?>
                                >
                                <i class="far fa-eye-slash eye-setting"></i>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-4 col-12 text-right">
                                <span>ชื่อเกษตรกร</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <input type="text" class="form-control" 
                                    id="s_name" name="s_name"  
                                    <?php if($fullname!='') echo 'value="'.$fullname.'"'; ?>
                                >
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-4 col-12 text-right">
                                <span>จังหวัด</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <select id="s_province" name="s_province" class="form-control">
                                    <option selected value=0>เลือกจังหวัด</option>        
                                    <?php 
                                    $sql = "SELECT * FROM `db-province`";
                                    $myConDB = connectDB();
                                    $result = $myConDB->prepare($sql);
                                    $result->execute();

                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
                                        if($fpro==$row["AD1ID"])
                                            echo '<option value="'.$row["AD1ID"].'" selected>'.$row["Province"].'</option>';
                                        else
                                            echo '<option value="'.$row["AD1ID"].'">'.$row["Province"].'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-4 col-12 text-right">
                                <span>อำเภอ</span>
                            </div>
                            <div class="col-xl-6 col-12">
                                <select id="s_distrinct" name="s_distrinct" class="form-control"> 
                                    <option selected value=0>เลือกอำเภอ</option>>        
                                    <?php 
                                    if($fpro!=0){
                                        $sql = "SELECT * FROM `db-distrinct` WHERE `AD1ID`=".$fpro;
                                        $myConDB = connectDB();
                                        $result = $myConDB->prepare($sql);
                                        $result->execute();
                                    
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
                                            if($fdist==$row["AD2ID"])
                                                echo '<option value="'.$row["AD2ID"].'" selected>'.$row["Distrinct"].'</option>';
                                            else
                                                echo '<option value="'.$row["AD2ID"].'">'.$row["Distrinct"].'</option>';
                                    }
                                    ?>
                                    
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-xl-4 col-12 text-right">
                            </div>
                            <div class="col-xl-6 col-12">
                                <button type="submit" id="btn_pass"
                                    class="btn btn-success btn-sm form-control">ค้นหา</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row mt-4">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-header card-bg" >
                    <h6 class="m-0 font-weight-bold" style="color:#006633;">รายชื่อเกษตรกร</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-xl-3 col-12">
                                <button type="button" id="btn_comfirm" class="btn btn-outline-success btn-sm"><i class="fas fa-file-excel"></i> Excel</button>
                                <button type="button" id="btn_comfirm" class="btn btn-outline-danger btn-sm"><i class="fas fa-file-pdf"></i> PDF</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id= table class="table table-bordered table-striped table-hover table-data" width="100%">
                                <thead>
                                    <tr>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>จังหวัด</th>
                                        <th>อำเภอ</th>
                                        <th>จำนวนสวน</th>
                                        <th>จำนวนแปลง</th>
                                        <th>พื้นที่ปลูก</th>
                                        <th>จำนวนต้น</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>จังหวัด</th>
                                        <th>อำเภอ</th>
                                        <th>จำนวนสวน</th>
                                        <th>จำนวนแปลง</th>
                                        <th>พื้นที่ปลูก</th>
                                        <th>จำนวนต้น</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </tfoot>

                                
                                <tbody>
                                <?php 
                                //while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                                for($i=0;$i<$numFermer;$i++) {
                                ?>
                                    <tr>
                                        <td><?php echo $FARMER[$i]['FullName']; ?></td>
                                        <td><?php echo $FARMER[$i]["Province"] ?></td>
                                        <td><?php echo $FARMER[$i]["Distrinct"] ?></td>
                                        <td class = "text-right"><?php echo $FARMER[$i]['numFarm']; ?> สวน</td>
                                        <td class = "text-right"><?php echo $FARMER[$i]['numSubFarm']; ;?> แปลง</td>
                                        <td class = "text-right"><?php echo $FARMER[$i]['numArea1']; ?> ไร่ <?php echo $FARMER[$i]['numArea2']; ?> งาน</td>
                                        <td class = "text-right"><?php echo $FARMER[$i]['numTree']; ?> ต้น</td>
                                        <td style="text-align:center;">
                                            <a href='FarmerListDetail.php?farmerID=<?php echo $FARMER[$i]['dbID'];?>'>
                                            <button type='button' id='btn_info' 
                                                class="btn btn-info btn-sm btn_edit tt"
                                                data-toggle="tooltip" title="รายละเอียดข้อมูลเกษตรกร" >
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
            </div>
        </div>

    <div class="Modal">

    </div>

</div>


<?php include_once("../layout/LayoutFooter.php"); ?>

<script src="FarmerListAdmin.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>