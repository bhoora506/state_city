<?php
include('functions.php');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if (isset($_POST['submit'])) {
    $myinsert = array();
    $message = "";
    $validation = true;
    $error = array();
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
            'city' => $_POST['city'],
            'statename' => $_POST['statename'],
        );
        $response = duplicatecity($duplicatedata);
        if ($response['message'] == true) {
            $message = $response['message'];
        } else {
            $myinsert['city'] = $_POST['city'];
            $myinsert['statename'] = $_POST['statename'];
            $myinsert['status'] = $_POST['status'];
            $response = insertcitydata("citiesdata", $myinsert);
            if ($response['succuss'] == true) {
                header('location:cities.php');
            } else {
                $message = $response['message'];
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

    <div class="container">
        <div style="color: red;"><?php if (!empty($message)) {
                                        echo $message;
                                    } ?></div>
        <form action="" method="POST">
            <label for="city">City</label>
            <input type="text" name="city" placeholder="Enter your city" value="<?php if (isset($_POST['city'])) {
                                                                                    echo $city;
                                                                                } ?>">
            <span style="color: red;"> <?php if (!empty($error['city'])) {
                                            echo $error['city'];
                                        } ?></span><br><br>
            <label for="statename">Statename</label>
            <select name="statename" id="">
                <option value=""> Select-Statename</option>
                <?php
                $states = getallstates();
                print_r($states);
                foreach ($states as $state) { ?>
                    <option value="<?php echo $state['id']; ?>" <?php if (!empty($_POST['statename']) && $state['id'] == $_POST['statename']) {
                                                                    echo "selected";
                                                                } ?>><?php echo $state['state']; ?></option>
                <?php } ?>
            </select>
            <span style="color: red;"> <?php if (!empty($error['statename'])) {
                                            echo $error['statename'];
                                        } ?></span><br><br>
            <label for="status">Status</label>
            <select name="status" id="">
                <option value="0">Select-status</option>
                <option value="Active" <?php if (isset($_POST['status'])) {
                                            if ($_POST['status'] == "Active") {
                                                echo "selected";
                                            }
                                        } ?>> Active</option>
                <option value="Inactive" <?php if (isset($_POST['status'])) {
                                                if ($_POST['status'] == "Inactive") {
                                                    echo "selected";
                                                }
                                            } ?>> Inactive</option>
            </select>
            <span style="color: red;"> <?php if (!empty($error['status'])) {
                                            echo $error['status'];
                                        } ?></span><br><br>
            <input type="submit" value="submit" name="submit">

        </form>
    </div>
</body>

</html>