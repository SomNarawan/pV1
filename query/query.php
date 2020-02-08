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
function getDepartmentUser($did){
    $sql = "SELECT * FROM `db-department` WHERE DID = $did ";
    $DEPARTMENTUSER = selectData($sql);
    return $DEPARTMENTUSER;
}

function getEmailtype(){
    $sql = "SELECT * FROM `db-emailtype`";
    $EMAILTYPE = selectData($sql);
    return $EMAILTYPE;
}

function getEmailtypeUser($etid){
    $sql = "SELECT * FROM `db-emailtype` WHERE ETID = $etid ";
    $EMIALTYPEUSER= selectData($sql);
    return $EMIALTYPEUSER;
}
function getUser($id_u){
    $sql ="SELECT * FROM `db-user` WHERE `UID`=$id_u";
    $USER= selectData($sql);
    return $USER;
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

// จำนวนสวน
function getCountFarm(){
    $sql = "SELECT COUNT(ID) AS CountFarm FROM `log-farm` WHERE ISNULL(`EndT`) AND ISNULL(`DIMSubfID`)";
    $countFarm = selectData($sql)[1]['CountFarm'];
    return $countFarm;
}
// จำนวนแปลง
function getCountSubfarm(){
    $sql = "SELECT COUNT(ID) AS CountSubfarm FROM `log-farm` WHERE ISNULL(`EndT`) AND !ISNULL(`DIMSubfID`)";
    $countSubfarm = selectData($sql)[1]['CountSubfarm'];
    return $countSubfarm;
}
// จำนวนไร่ 
function getAreaRai(){
    $sql = "SELECT SUM(`AreaRai`) AS AreaRai FROM `db-subfarm`";
    $areaRai = selectData($sql)[1]['AreaRai'];
    return $areaRai;
}
// จำนวนต้นไม้
function getCountTree(){
    $sql = "SELECT sum(`log-farm`.`NumTree`) AS numTree FROM `log-farm` where `log-farm`.`EndT` is null AND `log-farm`.`DIMSubfID` is null";
    $numTree = selectData($sql)[1]['numTree'];
    return $numTree;
}
// ตารางสวนปาล์มน้ำมันในระบบ
function getOilPalmAreaList(){
    $sql = "SELECT `log-farm`.`ID`,`dim-farm`.`dbID` AS FMID ,
    `dim-address`.`Province`,`dim-address`.`Distrinct`,
    `dim-user`.`FullName`, `dim-user`.`Alias`, `dim-farm`.`Name`, `log-farm`.`NumSubFarm`,
    `log-farm`.`AreaRai`, `log-farm`.`AreaNgan`,`log-farm`.`NumTree` 
    FROM `log-farm` 
    INNER JOIN `dim-user`ON `dim-user`.`ID` = `log-farm`.`DIMownerID`
    INNER JOIN `dim-address`ON `dim-address`.`ID` =`log-farm`.`DIMaddrID`
    INNER JOIN `dim-farm`ON `dim-farm`.`ID` = `log-farm`.`DIMfarmID`
    WHERE `log-farm`.`DIMSubfID` IS NULL AND`log-farm`.`EndT`IS NULL
    ORDER BY `dim-address`.`Province`,`dim-address`.`Distrinct`,`dim-user`.`Alias`";
    $OilPalmAreaList = selectData($sql);
    return $OilPalmAreaList;
}
// ตารางรายการแปลงปลูกปาล์มน้ำมัน ต้องมีการส่งค่า DIMfarmID มาด้วย
function getOilPalmAreaListDetail($DIMfarmID){
    $sql = "SELECT `db-subfarm`.`Name`,`db-subfarm`.`AreaRai`,`log-farm`.`NumTree` , FLOOR(TIMESTAMPDIFF(DAY,`dim-time`.`Date`,CURRENT_TIME)% 30.4375 )as day, FLOOR(TIMESTAMPDIFF( MONTH,`dim-time`.`Date`,CURRENT_TIME)% 12 )as month, FLOOR(TIMESTAMPDIFF( YEAR,`dim-time`.`Date`,CURRENT_TIME))as year 
    from `log-farm` INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-farm`.`DIMSubfID` INNER JOIN `log-planting` ON `dim-farm`.`ID` =`log-planting`.`DIMsubFID` INNER JOIN `dim-time` on `log-planting`.`DIMdateID` = `dim-time`.`ID` INNER JOIN `db-subfarm` ON `db-subfarm`.`FSID` = `dim-farm`.`dbID` 
    WHERE ISNULL(`log-farm`.`EndID`) AND `log-farm`.`DIMfarmID` = '$DIMfarmID'";
    $OilPalmAreaListDetail = selectData($sql);
    return $OilPalmAreaListDetail;
}

// function getCountFarmer()
// {
//     $sql = "SELECT COUNT(*) AS countFarmer 
//     FROM (SELECT `UFID`FROM `db-farmer` JOIN `dim-user` ON `dim-user`.`dbID`=`db-farmer`.`UFID`WHERE `dim-user`.`Type`='F') AS farmer";
//     $countFarmer = selectData($sql)[1]['countFarmer'];
//     return $countFarmer;
// }

// function getCountFarm()
// {
//     $sql = "SELECT COUNT(*) AS countFarm 
//     FROM (SELECT `DIMownerID`, `DIMfarmID`, `NumSubFarm`,`NumTree`,`AreaRai`, `AreaNgan`FROM `log-farm`
//     WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL) AS farm";
//     $countFarm = selectData($sql)[1]['countFarm'];
//     return $countFarm;
// }

// function getCountsubFarm()
// {
//     $sql = "SELECT SUM(`AreaRai`) AS countsubFarm 
//     FROM (SELECT `DIMownerID`, `DIMfarmID`, `NumSubFarm`,`NumTree`,`AreaRai`, `AreaNgan`FROM `log-farm`
//     WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL) AS farm";
//     $countsubFarm = selectData($sql)[1]['countsubFarm'];
//     return $countsubFarm;
// }

// function getCountTree()
// {
//     $sql = "SELECT SUM(`NumTree`) AS countTree
//     FROM (SELECT `DIMownerID`, `DIMfarmID`, `NumSubFarm`,`NumTree`,`AreaRai`, `AreaNgan`FROM `log-farm`
//     WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL) AS farm";
//     $countTree = selectData($sql)[1]['countTree'];
//     return $countTree;
// }

function getCountArea(){
    $sql = "SELECT SUM(`AreaRai`) AS countArea FROM `db-subfarm`";
    return selectData($sql)[1]['countArea'];
}

//Farmer Table
function getFarmer()
{
    $myConDB = connectDB();
    if (isset($_POST['s_formalid']))  $idformal = rtrim($_POST['s_formalid']);
    if (isset($_POST['s_province']))  $fpro     = $_POST['s_province'];
    if (isset($_POST['s_distrinct'])) $fdist    = $_POST['s_distrinct'];
    if (isset($_POST['s_name'])) {
        $fullname = rtrim($_POST['s_name']);
        $fullname = preg_replace('/[[:space:]]+/', ' ', trim($fullname));
        $namef = explode(" ", $fullname);
        if (isset($namef[1])) {
            $fnamef = $namef[0];
            $lnamef = $namef[1];
        } else {
            $fnamef = $fullname;
            $lnamef = $fullname;
        }
    }

    $sql = "SELECT UFID,Title,FirstName,LastName,FormalID,Icon,`Address`,`db-farmer`.`AD3ID`,IsBlock,`db-farmer`.`ModifyDT`,`db-distrinct`.AD2ID,`db-distrinct`.AD1ID,subDistrinct,Distrinct,Province FROM `db-farmer` 
                INNER JOIN `db-subdistrinct` ON `db-farmer`.`AD3ID`=  `db-subdistrinct`.AD3ID
                INNER JOIN `db-distrinct` ON `db-subdistrinct`.`AD2ID`=  `db-distrinct`.AD2ID
                INNER JOIN `db-province` ON `db-distrinct`.`AD1ID`=  `db-province`.AD1ID
                WHERE 1 ";

    if ($idformal != '') $sql = $sql . " AND FormalID LIKE '%" . $idformal . "%' ";
    if ($fullname != '') $sql = $sql . " AND (FirstName LIKE '%" . $fnamef . "%' OR LastName LIKE '%" . $lnamef . "%') ";
    if ($fpro    != 0)  $sql = $sql . " AND `db-distrinct`.AD1ID = '" . $fpro . "' ";
    if ($fdist   != 0)  $sql = $sql . " AND `db-distrinct`.AD2ID = '" . $fdist . "' ";

    //echo $sql;

    $result2 = $myConDB->prepare($sql);
    $result2->execute();


    //INFO
    $sql = "SELECT `UFID`,`FirstName`,`LastName`,`Distrinct`,`Province`, 
    `dim-user`.`FullName`, `dim-user`.`ID` AS dimFID
     FROM `db-farmer` 
     JOIN `dim-user` ON `dim-user`.`dbID`=`db-farmer`.`UFID`
     JOIN `db-subdistrinct` ON `db-subdistrinct`.`AD3ID` = `db-farmer`.`AD3ID` 
     JOIN `db-distrinct` ON `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
     JOIN `db-province` ON `db-province`.`AD1ID` = `db-distrinct`.`AD1ID` 
     WHERE `dim-user`.`Type`='F' ";
    if ($idformal != '') $sql = $sql . " AND FormalID LIKE '%" . $idformal . "%' ";
    if ($fullname != '') $sql = $sql . " AND (FirstName LIKE '%" . $fnamef . "%' OR LastName LIKE '%" . $lnamef . "%') ";
    if ($fpro    != 0)  $sql = $sql . " AND `db-distrinct`.AD1ID = '" . $fpro . "' ";
    if ($fdist   != 0)  $sql = $sql . " AND `db-distrinct`.AD2ID = '" . $fdist . "' ";
    $sql = $sql . " ORDER BY  `dim-user`.`FullName`";
    //echo $sql;

    $myConDB = connectDB();
    $result = $myConDB->prepare($sql);
    $result->execute();
    $numFermer = 0;
    foreach ($result as $tmp => $tmpDATA) {
        //print_r($tmpDATA);
        if ($tmpDATA['UFID'] > 0) {
            $FARMER[$numFermer]['dbID']    = $tmpDATA['UFID'];
            $FARMER[$numFermer]['dimID']    = $tmpDATA['dimFID'];
            $FARMER[$numFermer]['FullName']    = $tmpDATA['FullName'];
            $FARMER[$numFermer]['Province']    = $tmpDATA['Province'];
            $FARMER[$numFermer]['Distrinct']    = $tmpDATA['Distrinct'];
            $FARMER[$numFermer]['numFarm']    = 0;
            $FARMER[$numFermer]['numSubFarm']    = 0;
            $FARMER[$numFermer]['numTree']    = 0;
            $FARMER[$numFermer]['numArea1']    = 0;
            $FARMER[$numFermer]['numArea2']    = 0;
            $fermerINDEX[$tmpDATA['dimFID']]   = $numFermer;
            $numFermer++;
        }
    }
    $sql1 = "SELECT `DIMownerID`, `DIMfarmID`, `NumSubFarm`,`NumTree`,`AreaRai`, `AreaNgan`FROM `log-farm`
    WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL";
    $myConDB = connectDB();
    $result1 = $myConDB->prepare($sql1);
    $result1->execute();
    foreach ($result1 as $tmp => $tmpDATA) {
        $tmpID = $fermerINDEX[$tmpDATA['DIMownerID']];
        if ($tmpID >= 0) {
            //print_r($tmpDATA);
            $FARMER[$tmpID]['numFarm']++;
            $FARMER[$tmpID]['numSubFarm']   += $tmpDATA['NumSubFarm'];
            $FARMER[$tmpID]['numTree']      += $tmpDATA['NumTree'];
            $FARMER[$tmpID]['numArea1']     += $tmpDATA['AreaRai'];
            $FARMER[$tmpID]['numArea2']     += $tmpDATA['AreaNgan'];
        }
    }

    return $FARMER;
}

//-----------------------FarmerList--------------------------

//-----------------------FarmerListDetail--------------------------

function getCountownerFarm($ufid)
{
    $sql = "SELECT COUNT(*) AS countFarm 
    FROM (SELECT `dim-user`.`dbID`, `DIMownerID`, `DIMfarmID`, `NumSubFarm`,`NumTree`,`AreaRai`, `AreaNgan`FROM `log-farm`
    INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-farm`.`DIMownerID` AND `dim-user`.`Type` = 'F'
    WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL AND `dim-user`.`dbID` = $ufid) AS farm";
    $countownerFarm = selectData($sql)[1]['countownerFarm'];
    return $countownerFarm;
}

function getCountownersubFarm($ufid)
{
    $sql = "SELECT SUM(`AreaRai`) AS countsubFarm 
    FROM (SELECT `dim-user`.`dbID`, `DIMownerID`, `DIMfarmID`, `NumSubFarm`,`NumTree`,`AreaRai`, `AreaNgan`FROM `log-farm`
    INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-farm`.`DIMownerID` AND `dim-user`.`Type` = 'F'
    WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL AND `dim-user`.`dbID` = $ufid) AS farm";
    $countownerFarm = selectData($sql)[1]['countownerFarm'];
    return $countownerFarm;
}

function getCountownerAreaRai($ufid)
{
    $sql = "SELECT SUM(`AreaRai`) AS countAreaRai
    FROM (SELECT `dim-user`.`dbID`, `DIMownerID`, `DIMfarmID`, `NumSubFarm`,`NumTree`,`AreaRai`, `AreaNgan`FROM `log-farm`
    INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-farm`.`DIMownerID` AND `dim-user`.`Type` = 'F'
    WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL AND `dim-user`.`dbID` = $ufid) AS farm";
    $countownerAreaRai = selectData($sql)[1]['countownerAreaRai'];
    return $countownerAreaRai;
}

function getCountownerTree($ufid)
{
    $sql = "SELECT SUM(`NumTree`) AS countTree
    FROM (SELECT `dim-user`.`dbID`, `DIMownerID`, `DIMfarmID`, `NumSubFarm`,`NumTree`,`AreaRai`, `AreaNgan`FROM `log-farm`
    INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-farm`.`DIMownerID` AND `dim-user`.`Type` = 'F'
    WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL AND `dim-user`.`dbID` = $ufid) AS farm";
    $countownerTree = selectData($sql)[1]['countownerTree'];
    return $countownerTree;
}

//OwnerFarm Table
function getownerFarm($ufid)
{
    $sql = "SELECT `dim-farm`.`Name`,`db-province`.`Province`,`db-distrinct`.`Distrinct`,`NumSubFarm`,`AreaRai`,`AreaNgan`,`NumTree`FROM `log-farm`
    INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-farm`.`DIMfarmID`
    INNER JOIN `db-farm` ON `db-farm`.`FMID` = `dim-farm`.`dbID`
    INNER JOIN `db-subdistrinct` ON `db-subdistrinct`.`AD3ID` = `db-farm`.`AD3ID` 
    INNER JOIN `db-distrinct` ON `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
    INNER JOIN `db-province` ON `db-province`.`AD1ID` = `db-distrinct`.`AD1ID` 
    INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-farm`.`DIMownerID` AND `dim-user`.`Type` = 'F'
    WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL AND `dim-user`.`dbID` = $ufid  ";
    $ownerFarm = selectData($sql);
    return $ownerFarm;
}

?>