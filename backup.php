<?php 
include('connection.php');
if(isset($_POST['submit'])){
    $myinsert= array();
    $error =array();
    $valid = true;
    $name = $_POST['name'];
    $state = $_POST['state'];
    $status = $_POST['status'];

    if(empty($_POST['name'])){
        $error['name']="Name is required";
        $valid= false;
    }else{

        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)){
        $error['name'] = "Only letters and white space allowed";
        $valid= false;
        }
    }

    if(empty($_POST['state'])){
        $error['state'] = "State is required";
        $valid= false;
    }
    if(empty($_POST['status'])){
        $error['status'] = "status is required";
        $valid= false;
    }else{
        if (!preg_match("/^[a-zA-Z-' ]*$/",$status)){
            $error['name'] = "Only letters and white space allowed";
            $valid= false;
        }

    if($valid){

        $myconnect = connection();
        $sql = "SELECT * FROM `statedata` WHERE name = '$name' and state = '$state'"; 
        $query = mysqli_query($myconnect, $sql);
        $count = mysqli_num_rows($query);
        if($count > 0 ){
            echo "data already exist";
        }else{
        $myconnect = connection();
        $sql = " UPDATE `statedata` SET`name`='$name',`state`='$state', `status` '$status' WHERE id=$id";
        $query = mysqli_query($myconnect, $sql);
        if($query){
            header('location:states.php');
        }else{
           echo "error";
        }
    }
    }
}
}


if (isset($_GET['id'])) 
{
    $id = $_GET['id'];
    $myconnect = connection();
    $sql = "SELECT * FROM `statedata` WHERE id =$id";
    $result = mysqli_query($myconnect, $sql);
    $row = mysqli_fetch_assoc($result);
    $dbname = $row['name']; 
    $dbstate = $row['state']; 
    $dbstatus =$row['status'];

}




$myconnect = connection();
$sql = "SELECT `stateid` FROM `statedata`";
$query = mysqli_query($myconnect,$sql);
foreach($query as $res){?>
  <option value="<?php echo $res['stateid']."<br>";?>"></option> 
    
<?     } ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class=" container">
        <form action="" method="post">
            <label for="name">Name </label>
            <input type="text" name="name" placeholder="Enter your name" value="<?php if (isset($_POST['name'])){echo $name; }else{  echo $dbname; }?>">
            <span style="color: red;" id="myname"> <?php if (!empty($error['name'])) {echo $error['name'];} ?></span>
            <br><br>
            <label for="name">State </label>
            <input type="text" name="state" placeholder="Enter your state" value="<?php if(isset($_POST['state'])){ echo $state; } ?>">
            <span style="color: red;" id="myname"> <?php if (!empty($error['state'])) {echo $error['state'];} ?></span><br><br>
            <label for="name">Status </label>
            <select name="status" id="">
                <option value="0">Select-city</option>
                <option value="Active" <?php if($row['city']=="Active"){ echo "selected";}else{   if($_POST['status']=="Active"){echo "selected"; }  }?> >Active</option>
                <option value="Inactive" <?php if($row['city']=="Inactive"){ echo "selected";}else{   if($_POST['status']=="Inactive"){echo "selected"; }  }?> >Inactive</option>
            </select>
            <span style="color: red;" id="myname"> <?php if (!empty($error['state'])) {echo $error['state'];} ?></span>
            <br><br>
            <input type="submit" value="submit" name="submit">

        </form>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            function loadData(state_id) {
                $.ajax({
                    url: "loaddata.php",
                    type: "POST",
                    data: {
                        id: state_id
                    },
                    success: function(data) {
                        $("#city").html(data);
                    }
                });
            }
            $("#state").on("change", function() {
                var state = $("#state").val();

                if (state != "") {
                    loadData(state);
                } else {
                    $("#city").html('<option value="">Select_city</option>');
                }
            })
        });
    </script>
        <script type="text/javascript">
        $(document).ready(function() {
            var state = $("#state").val();
            var city = $("#city").val();
            function loadData(state_id,city_id) {
                $.ajax({
                    url: "loaddata.php",
                    type: "POST",
                    data: {
                        id: state_id,
                        cid:city_id,
                    },
                    success: function(data) {
                        $("#city").html(data);
                    }
                });
            }
            $("#state").on("change", function() {
              
                if (state != "") {
                    loadData(state,city_id);
                } else {
                    $("#city").html('<option value="">Select_city</option>');
                }
            })
        });
    </script>
</body>
</html>
<?
if (isset($_POST['submit'])) {
    $valid = true;
    $error = array();
    $statename = $_POST['statename'];
    $cityname = $_POST['cityname'];
    if (empty($_POST['statename'])) {
        $error['statename'] = "state is required";
        $valid = false;
    }
    if (empty($_POST['cityname'])) {
        $error['cityname'] = "city is required";
        $valid = false;
    }
    if ($valid) {
        $myconnect = connection();
        $sql = "INSERT INTO `add_address`( `statename`, `cityname`) VALUES ('$statename','$cityname')";
        mysqli_query($myconnect, $sql);
    }
}



include 'functions.php';
$myconnect = connection();
if ($_POST['type'] == "") {
  $states = getallstates();
  foreach ($states as $value) {
    
    echo "<option value ={$value['id']}> {$value['state']}</option>";
  }}else{
  if($_POST['type'] == "citydata") ;
  $row = selectcitydata();
  echo  '<option value="">Select_city</option>';
  foreach($row as $result){
    echo "<option value ='{$result['id']}'>{$result['city']}</option>";
  }
  }



