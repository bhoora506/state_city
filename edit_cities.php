<?php
include('functions.php');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if (isset($_POST['submit'])) {
    $message = "";
    $cityupdate = array();
    $validation = true;
    $error = array();
    $id = $_GET['id'];
    $city = $_POST['city'];
    $statename = $_POST['statename'];
    $status = $_POST['status'];

    if (empty($_POST['city'])) {
        $error['city'] = "city is required";
        $validation = false;
    }
    if (!preg_match("/^[a-zA-z]*$/", $city)) {
        $error['city'] = "only character are allowed";
        $validation = false;
    }

    if (empty($_POST['statename'])) {
        $error['statename'] = "statename is required";
        $validation = false;
    }
    if (empty($_POST['status'])) {
        $error['status'] = "Status is required";
        $validation = false;
    }

    if ($validation) {

        $duplicatedata = array(
            'id'=> $_GET['id'],
            'city' => $_POST['city'],
            'statename' => $_POST['statename']
        );
        $response = duplicatecity($duplicatedata);
        if ($response['message'] == true) {
            $message = $response['message'];
        } else {
            $cityupdate['id'] = $_GET['id'];
            $cityupdate['city'] = $_POST['city'];
            $cityupdate['statename'] = $_POST['statename'];
            $cityupdate['status'] = $_POST['status'];
            $response = updatecitydata($cityupdate);
            if ($response['succuss'] == true) {
                header('location:cities.php');
            } else {
                $message = $response['message'];
            }
        }
    }
}


if (isset($_GET['id'])) {
    $myconnect = connection();
    $id = $_GET['id'];
    $sql = "SELECT * FROM `citiesdata` WHERE id =$id";
    $query = mysqli_query($myconnect, $sql);
    $row = mysqli_fetch_assoc($query);
    $dbid = $row['id'];
    $dbcity = $row['city'];
    $statename = $row['statename'];
    $dbstatus = $row['status'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="container">
        <div style="color: red;"><?php if (!empty($message)) {
                                        echo $message;
                                    } ?></div>
        <form action="" method="POST">
            <label for="city">City</label>
            <input type="text" name="city" placeholder="Enter your city" value="<?php if (isset($_POST['city'])) {
                                                                                    echo $city;
                                                                                } else {
                                                                                    echo $dbcity;
                                                                                } ?>">
            <span style="color: red;" id="mycity"> <?php if (!empty($error['city'])) {
                                                        echo $error['city'];
                                                    } ?></span><br><br>
            <label for="statename">Statename</label>
            <select name="statename" id="">
                <option value=""> Select-Statename</option>
                <?php
                $states = getallstates();
                foreach ($states as $state) {
                    $selected = "";
                    if (!empty($_POST['statename']) && $state['id'] == $_POST['statename']) {
                        $selected = "selected";
                    } elseif ($state['id'] == $row['statename']) {
                        $selected = "selected";
                    } ?>
                    <option value="<?php echo $state['id']; ?>" <?php echo $selected;  ?>><?php echo $state['state']; ?></option>
                <?php } ?>
            </select>
            <span style="color: red;" id="mycity"> <?php if (!empty($error['statename'])) {
                                                        echo $error['statename'];
                                                    } ?></span><br><br>
            <label for="status">Status</label>
            <select name="status" id="">
                <option value="0">Select-status</option>
                <option value="Active" <?php if ($row['status'] == "Active") {
                                            echo "selected";
                                        } else {
                                            if ($_POST['status'] == "Active") {
                                                echo "selected";
                                            }
                                        } ?>> Active</option>
                <option value="Inactive" <?php if ($row['status'] == "Inactive") {
                                                echo "selected";
                                            } else {
                                                if (isset($_POST['status']) == "Inactive") {
                                                    echo "selected";
                                                }
                                            } ?>> Inactive</option>
            </select>
            <span style="color: red;" id="mystatus"> <?php if (!empty($error['status'])) {
                                                            echo $error['status'];
                                                        } ?></span><br><br>
            <input type="submit" value="submit" name="submit">

        </form>
    </div>
</body>

</html>