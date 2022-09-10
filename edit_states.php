<?php
include('functions.php');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if (isset($_POST['submit'])) {
    $error = array();
    $message = "";
    $valid = true;
    $id = $_GET['id'];
    $state = $_POST['state'];
    $status = $_POST['status'];

    if (empty($_POST['state'])) {
        $error['state'] = "State is required";
        $valid = false;
    }
    if (empty($_POST['status'])) {
        $error['status'] = "Status is required";
        $valid = false;
    } else {
        if (!preg_match("/^[a-zA-Z-' ]*$/", $status)) {
            $error['name'] = "Only letters and white space allowed";
            $valid = false;
        }
    }

    if ($valid) {
        $duplicatestatedata = array(
            'state' => $_POST['state'],
            'id' => $_GET['id'],
        );
        $response = duplicatestate($duplicatestatedata);
        if ($response['message'] == true) {
            $message =  "data already exist";
        } else {
            $updatestate = array(
                'id' => $_GET['id'],
                'state' => $_POST['state'],
                'status' => $_POST['status'],
            );
            $response = updatestatedata($updatestate);
            if ($response['succuss'] == true) {
                header('location:states.php');
            } else {
                $message = $response['message'];
            }
        }
    }
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $myconnect = connection();
    $sql = "SELECT * FROM `statedata` WHERE id =$id";
    $result = mysqli_query($myconnect, $sql);
    $row = mysqli_fetch_assoc($result);
    $dbstate = $row['state'];
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

    <div class=" container">
        <div style="color: red;"><?php if (!empty($message)) {
                                        echo $message;
                                    } ?></div>
        <form action="" method="post">
            <label for="name">State </label>
            <input type="text" name="state" placeholder="Enter your state" value="<?php if (isset($_POST['state'])) {
                                                                                        echo $state;
                                                                                    } else {
                                                                                        echo $dbstate;
                                                                                    } ?>">
            <span style="color: red;" id="mystate"> <?php if (!empty($error['state'])) {
                                                        echo $error['state'];
                                                    } ?></span><br><br>
            <label for="name">Status </label>
            <select name="status" id="">
                <option value="0">Select-status</option>
                <option value="Active" <?php if ($row['status'] == "Active") {
                                            echo "selected";
                                        } else {
                                            if ($_POST['status'] == "Active") {
                                                echo "selected";
                                            }
                                        } ?>>Active</option>
                <option value="Inactive" <?php if ($row['status'] == "Inactive") {
                                                echo "selected";
                                            } else {
                                                if (isset($_POST['status']) == "Inactive") {
                                                    echo "selected";
                                                }
                                            } ?>>Inactive</option>
            </select>
            <span style="color: red;" id="mystatus"> <?php if (!empty($error['status'])) {
                                                            echo $error['status'];
                                                        } ?></span>
            <br><br>
            <input type="submit" value="submit" name="submit">

        </form>
    </div>
</body>

</html>