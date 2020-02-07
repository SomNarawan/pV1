<?php
include_once("./../../dbConnect.php");
$myConDB = connectDB();

function creatCard( $styleC, $headC, $textC, $iconC ) { 
    echo "<div class='col-xl-3 col-12 mb-4'>
        <div class='card border-left-primary $styleC shadow h-100 py-2'>
            <div class='card-body'>
                <div class='row no-gutters align-items-center'>
                    <div class='col mr-2'>
                        <div class='font-weight-bold  text-uppercase mb-1'>$headC</div>
                        <div class='h5 mb-0 font-weight-bold text-gray-800'>$textC</div>
                    </div>
                    <div class='col-auto'>
                        <i class='material-icons icon-big'>$iconC</i>
                    </div>
                </div>
            </div>
        </div>
    </div>";
}
function getDepartment(){
    $sql = "SELECT * FROM `db-department`";
    $DEPARTMENT = selectData($sql);
    return $DEPARTMENT;
}

function getEmailtype(){
    $sql = "SELECT * FROM `db-emailtype`";
    $EMAILTYPE = selectData($sql);
    return $EMAILTYPE;
}
function getProvince(){
    $sql = "SELECT * FROM `db-province` ORDER BY `db-province`.`Province`  ASC";
    $PROVINCE = selectData($sql);
    return $PROVINCE;
}
function getDistrinctInProvince($fpro){
    $sql = "SELECT * FROM `db-distrinct` WHERE `AD1ID`=$fpro ORDER BY `db-distrinct`.`Distrinct`  ASC";
    $DISTRINCT_PROVINCE = selectData($sql);
    return $DISTRINCT_PROVINCE;
}
function getAllDepartment(){
    $sql = "SELECT `db-department`.`DID`,`db-department`.`Department`,`db-department`.`Alias`,`db-department`.`Note`,COUNT(`db-user`.`DID`) AS count_de FROM `db-department` 
    LEFT JOIN `db-user` ON `db-department`.DID = `db-user`.DID GROUP BY `db-department`.`DID`,`db-department`.`Department`,`db-department`.`Alias`,`db-department`.`Note`";
    $ALLDEPARTMENT = selectData($sql);
    return $ALLDEPARTMENT;

}
function getCountDepartment(){
    $sql = "SELECT COUNT(*) AS countDepartment FROM `db-department`";
    $countDepartment = selectData($sql)[1]['countDepartment'];
    return $countDepartment;
}

function getCountUser(){
    $sql = "SELECT COUNT(*) AS countUser FROM `db-user`";
    $countUser = selectData($sql)[1]['countUser'];
    return $countUser;
}

function getCountAdmin(){
    $sql = "SELECT COUNT(*) AS countAdmin FROM `db-user` WHERE IsAdmin = 1 ";
    $countAdmin = selectData($sql)[1]['countAdmin'];
    return $countAdmin;
}
function getCountFarmer(){
    $sql = "SELECT COUNT(*) AS countFarmer FROM `db-farmer`";
    $countFarmer = selectData($sql)[1]['countFarmer'];
    return $countFarmer;    
}

?>