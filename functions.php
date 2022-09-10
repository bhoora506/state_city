<?php
//    connection();
function connection()
{
    $myconnect = mysqli_connect("localhost", "root", "", "states");
    if ($myconnect) {
        // echo "conneted succussfully";
    } else {
        echo mysqli_connect_error();
    }
    return $myconnect;
}

// insertdata statedata
function insertdata($table, $myinsert)
{
    $response = array(
        'succuss' => false,
        'message' => '',
    );
    $myconnect = connection();
    $sql = "INSERT INTO $table (`state`,`status`) VALUES ('{$myinsert['state']}','{$myinsert['status']}')";
    $query = mysqli_query($myconnect, $sql);
    if ($query) {
        $response['succuss'] = true;
    } else {
        $response['message'] = "somethingh went wrong";
    }
    return $response;
}

// updatedata statedata
function updatestatedata($updatestate)
{
    $response = array(
        'succuss' => false,
        'message' => '',
    );
    $myconnect = connection();
    $sql = "UPDATE `statedata` SET `state`='{$updatestate['state']}',`status`='{$updatestate['status']}' WHERE id = '{$updatestate['id']}'";
    $query = mysqli_query($myconnect, $sql);
    if ($query) {
        $response['succuss'] = true;
    } else {
        $response['message'] = "somethingh went wrong";
    }
    return $response;
}
// deletestatedata
function deletestatedata()
{
    $id = $_GET['id'];
    $myconnect = connection();
    $sql = "DELETE FROM `statedata` WHERE  id = $id";
    $query = mysqli_query($myconnect, $sql);
    if ($query) {
        header('location:states.php');
    }
    return $query;
}
// selectstatedata
function selectstatedata()
{
    $row = array();
    $myconnect = connection();
    $sql = "SELECT * FROM `statedata`";
    $query = mysqli_query($myconnect, $sql);
    while ($data = mysqli_fetch_assoc($query)) {
        $row[] = $data;
    }
    return $row;
}
// selectcitydata
function selectcitydata()
{
    $row = array();
    $myconnect = connection();
    $sql = "SELECT citiesdata.*,statedata.state AS statename FROM `citiesdata` LEFT JOIN statedata ON statedata.id = citiesdata.statename WHERE statename";
    $query = mysqli_query($myconnect, $sql);
    while ($data = mysqli_fetch_assoc($query)) {
        $row[] = $data;
    }
    return $row;
}

// insertcitydata
function insertcitydata($table, $myinsert)
{
    $response = array(
        'succuss' => false,
        'message' => '',
    );
    $myconnect = connection();
    $sql = "INSERT INTO $table (`city`, `statename`,`status`) VALUES ('{$myinsert['city']}','{$myinsert['statename']}','{$myinsert['status']}')";
    $query = mysqli_query($myconnect, $sql);
    if ($query) {
        $response['succuss'] = true;
    } else {
        $response['message'] = "somethingh went worng";
    }
    return $response;
}
// deletecitydata
function deletecitydata()
{
    $id = $_GET['id'];
    $myconnect = connection();
    $sql = " DELETE FROM `citiesdata` WHERE  id = $id";
    $query = mysqli_query($myconnect, $sql);
    if ($query) {
        header('location: cities.php');
    }
    return $query;
}
// updatecitydata
function updatecitydata($cityupdate)
{
    $response = array(
        'succuss' => false,
        'message' => '',
    );
    $myconnect = connection();
    $sql = "UPDATE `citiesdata` SET `city`= '{$cityupdate['city']}' ,`statename`= '{$cityupdate['statename']}' ,`status`= '{$cityupdate['status']}' WHERE id = '{$cityupdate['id']}'";
    $query = mysqli_query($myconnect, $sql);
    if ($query) {
        $response['succuss'] = true;
    } else {
        $response['message'] = "somethingh went worng";
    }
    return $response;
}
// countduplicatecity 
function duplicatecity($duplicatedata)
{
    $response = array(
        'message' => false,
    );
    $id = $duplicatedata['id'];
    $myconnect = connection();
    $sql = "SELECT * FROM `citiesdata` WHERE `city` = '{$duplicatedata['city']}' AND `statename` = '{$duplicatedata['statename']}'";
    if (!empty($id)) {
        $sql = "SELECT * FROM `citiesdata` WHERE `city` = '{$duplicatedata['city']}' AND `statename` = '{$id}'";
    }
    $query = mysqli_query($myconnect, $sql);
    $count = mysqli_num_rows($query);
    if ($count > 0) {
        $response['message'] = true;
        $response['message'] = "data already exist";
    }
    return $response;
}

// countduplicatestate 
function duplicatestate($duplicatestatedata)
{
    $response = array(
        'message' => false,
    );
    $id = $duplicatestatedata['id'];
    $myconnect = connection();
    $sql = "SELECT * FROM `statedata` WHERE state = '{$duplicatestatedata['state']}'";
    if (!empty($id)) {
        $sql = "SELECT * FROM `statedata` WHERE state = '{$duplicatestatedata['state']}' AND id != '{$id}'";
    }
    $query = mysqli_query($myconnect, $sql);
    $count = mysqli_num_rows($query);
    if ($count > 0) {
        $response['message'] = true;
        $response['message'] = "data already exist";
    }
    return $response;
}

function getallstates()
{
    $states = array();
    $myconnect = connection();
    $sql = "SELECT `id`, `state` FROM `statedata` WHERE status = 'Active' ";
    $query = mysqli_query($myconnect, $sql);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $states[] = $fetch;
    }
    return $states;
}

// selectcitydatatwo
function selectcitydatatwo($id)
{   $cities = array();
    $myconnect = connection();
    $sql = "SELECT * FROM citiesdata WHERE statename = {$id}";
    $query = mysqli_query($myconnect, $sql);
    while($data= mysqli_fetch_assoc($query)){
        $cities[]=$data;
    }
    return $cities;
}


// insertaddaddress
function insertadd_address($insertaddress)
{
    $response = array(
        'succuss' => false,
        'message' => '',
    );
    $myconnect = connection();
    $sql = "INSERT INTO `add_address`(`name`, `email`, `mobile_No`, `state`, `city`, `pincode`) VALUES ('{$insertaddress['name']}','{$insertaddress['email']}','{$insertaddress['mobile_No']}','{$insertaddress['state']}','{$insertaddress['city']}','{$insertaddress['pincode']}')";
    $query = mysqli_query($myconnect, $sql);
    if ($query) {
        $response['succuss'] = true;
    } else {
        $response['message'] = "somethingh went worng";
    }
    return $response;
}

// countduplicataddress
function countduplicateaddress($dupliaddress)
{
    $response = array(
        'message' => false,
    );
    $myconnect = connection();
    $sql = "SELECT * FROM `add_address` WHERE email = '{$dupliaddress['email']}' AND mobile_No = '{$dupliaddress['mobile_No']}'";
    if (!empty($dupliaddress['id'])) {
        $sql = "SELECT * FROM `add_address` WHERE email = '{$dupliaddress['email']}' AND mobile_No = '{$dupliaddress['mobile_No']}' AND id != '{$dupliaddress['id']}'";
    }
    $query = mysqli_query($myconnect, $sql);
    $count = mysqli_num_rows($query);
    if ($count > 0) {
        $response['message'] = true;
        $response['message'] = "data already exist";
    }
    return $response;
}

// selectaddress
function selectaddress()
{
    $myconnect = connection();
    $sql = "SELECT * FROM `add_address`";
    $query = mysqli_query($myconnect, $sql);
    return $query;
}
// updateaddress
function update_address($updateaddress)
{
    $response = array(
        'succuss' => false,
        'message' => '',
    );
    $myconnect = connection();
    $sql = "UPDATE `add_address` SET `name`='{$updateaddress['name']}',`email`='{$updateaddress['email']}',`mobile_No`='{$updateaddress['mobile_No']}',`state`='{$updateaddress['state']}',`city`='{$updateaddress['city']}',`pincode`='{$updateaddress['pincode']}' WHERE id = '{$updateaddress['id']}'";
    $query = mysqli_query($myconnect, $sql);
    if ($query) {
        $response['succuss'] = true;
    } else {
        $response['message'] = "something went wrong";
    }
    return $response;
}

// selectdatafromdatabase
function selectdbdata($dbdata)
{   $result2 =array();
    $myconnect = connection();
    // $id = $_GET['id'];
    $sql = "SELECT * FROM `add_address` WHERE id = '{$dbdata['id']}'";
    $query = mysqli_query($myconnect, $sql);
    while ($data = mysqli_fetch_assoc($query)) {
        $result2[]=$data;
    }
    return $result2;
}
// deleteaddress
function deleteaddress()
{
    $response = array(
        'succuss' => false,
        'message' => '',
    );
    $id = $_GET['id'];
    $myconnect = connection();
    $sql = "DELETE FROM `add_address` WHERE id =  $id";
    $query = mysqli_query($myconnect, $sql);
    if ($query) {
        $response['succuss'] = true;
    } else {
        $response['message'] = "something went wrong";
    }
    return $response;
}
