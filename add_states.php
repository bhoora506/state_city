<?php
include('functions.php');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    $myinsert = array();
    $message = "";
    $error = array();
    $valid = true;  
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
        if ($valid) {
            $duplicatestate = array('state'=> $_POST['state']);
            $response = duplicatestate($duplicatestate);
            if ($response['message']== true) {
                $message =  "data already exist";
            } else {
                $myinsert['state'] = $_POST['state'];
                $myinsert['status'] = $_POST['status'];
                $response = insertdata("statedata", $myinsert);
                if ($response['succuss'] == true) {
                    header('location:states.php');
                } else {
                    $message = $response['message'];
                }
            }
        }
    }
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
    <div style="color: red;"><?php if (!empty($message)) {
                                    echo $message;
                                } ?></div>
    <div class=" container">
        <form action="" method="post">
            <label for="name">State </label>
            <input type="text" name="state" placeholder="Enter your state" value="<?php if (isset($_POST['state'])) {
                                                                                        echo $state;
                                                                                    } ?>">
            <span style="color: red;" id="mystate"> <?php if (!empty($error['state'])) {
                                                        echo $error['state'];
                                                    } ?></span><br><br>
            <label for="name">Status</label>
            <select name="status" id="">
                <option value="0">Select-status</option>
                <option value="Active" <?php if (isset($_POST['status'])) {
                                            if ($_POST['status'] == "Active") {
                                                echo "selected";
                                            }
                                        } ?>>Active</option>
                <option value="Inactive" <?php if (isset($_POST['status'])) {
                                                if ($_POST['status'] == "Inactive") {
                                                    echo "selected";
                                                }
                                            } ?>>Inactive</option>
            </select>
            <span style="color: red;" id="mystatus">
                <?php if (!empty($error['status'])) {
                    echo $error['status'];
                } ?></span>
            <br><br>
            <input type="submit" value="submit" name="submit">

        </form>
    </div>
</body>

</html>