<?php
include('functions.php');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    $valid = true;
    $message = "";
    $error = array();
    $id = isset($_GET['id']);
    $name  = $_POST['name'];
    $email  = $_POST['email'];
    $mobile_No  = $_POST['mobile_No'];
    $state  = $_POST['state'];
    $city  = $_POST['city'];
    $pincode  = $_POST['pincode'];

    if (empty($_POST['name'])) {
        $error['name'] = "name is required";
        $valid = false;
    } else {
        if (!preg_match("/^[a-zA-z_ ]*$/", $name)) {
            $error['name'] = "Only alphabets and whitespace are allowed.";
            $valid = false;
        }
    }
    if (empty($_POST['email'])) {
        $error['email'] = "email is required";
        $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Invalid email format";
        $valid = false;
    }
    if (empty($_POST['mobile_No'])) {
        $error['mobile_No'] = "mobile number is required";
        $valid = false;
    } else {
        $mobile = strlen($mobile_No);
        if ($mobile != 10) {
            $error['mobile_No'] = "Only 10 digit allowed";
            $valid = false;
        }
    }
    if (empty($_POST['state'])) {
        $error['state'] = "state is required";
        $valid = false;
    }
    if (empty($_POST['city'])) {
        $error['city'] = "city is required";
        $valid = false;
    }
    if (empty($_POST['pincode'])) {
        $error['pincode'] = "pincode is required";
        $valid = false;
    } else {
        $pin = strlen($pincode);
        if ($pin != 6) {
            $error['pincode'] = "Only six digit allowed";
            $valid = false;
        }
    }
    if ($valid) {
        $dupliaddress = array(
            'id' => $_GET['id'],
            'email' => $_POST['email'],
            'mobile_No' => $_POST['mobile_No'],
        );
        $response = countduplicateaddress($dupliaddress);
        if ($response['message'] == true) {
            $message = $response['message'];
        } else {
            $updateaddress = array(
                'id' => $_GET['id'],
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'mobile_No' => $_POST['mobile_No'],
                'state' => $_POST['state'],
                'city' => $_POST['city'],
                'pincode' => $_POST['pincode'],
            );
            $response = update_address($updateaddress);
            if ($response['succuss'] == true) {
                header('location:address.php');
            } else {
                $message = "something went wrong";
            }
        }
    }
}
if (isset($_GET['id'])) {
    $dbdata = array('id' => $_GET['id']);
    $result2 = selectdbdata($dbdata);
    foreach($result2 as $result){
        $dbname = $result['name'];
        $dbemail = $result['email'];
        $dbmobile_No = $result['mobile_No'];
        $dbstate = $result['state'];
        $dbcity = $result['city'];
        $dbpincode = $result['pincode'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <title>Edit_address</title>
</head>

<body>
    <div class="container">
        <span style="color: red;"><?php if (!empty($message)) {
                                        echo $message;
                                    } ?></span>
        <form action="" method="POST">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Enter your name" value="<?php if (isset($_POST['name'])) {
                                                                                    echo $name;
                                                                                } else {
                                                                                    echo $dbname;
                                                                                } ?>">
            <span style="color: red;"><?php if (!empty($error['name'])) {
                                            echo $error['name'];
                                        } ?></span>
            <br><br>
            <label for="email">Email</label>
            <input type="text" name="email" placeholder="Enter your email" value="<?php if (isset($_POST['email'])) {
                                                                                        echo $email;
                                                                                    } else {
                                                                                        echo $dbemail;
                                                                                    } ?>">
            <span style="color: red;"><?php if (!empty($error['email'])) {
                                            echo $error['email'];
                                        } ?></span>
            <br><br>
            <label for="mobile_No">Mobile</label>
            <input type="number" name="mobile_No" placeholder="Enter your mobile_No." value="<?php if (isset($_POST['mobile_No'])) {
                                                                                                    echo $mobile_No;
                                                                                                } else {
                                                                                                    echo $dbmobile_No;
                                                                                                } ?>">
            <span style="color: red;"><?php if (!empty($error['mobile_No'])) {
                                            echo $error['mobile_No'];
                                        } ?></span>
            <br><br>
            <label for="state">State</label>
            <select name="state" id="state">
                <option value="">Select_state </option>
                <?php
                $states = getallstates();
                foreach ($states as $state) {
                    $selected = "";
                    if (isset($_POST['state'])) {
                        if ($state['id'] == $_POST['state']) {
                            $selected =  "selected";
                        }
                    } elseif ($state['id'] == $result['state']) {
                        $selected = "selected";
                    } ?>
                    <option value="<?php echo $state['id']; ?>" <?php echo $selected; ?>><?php echo $state['state']; ?></option>
                <?php } ?>
            </select>
            <span style="color: red;"><?php if (!empty($error['state'])) {
                                            echo $error['state'];
                                        } ?></span>
            <br><br>
            <label for="city">City</label>
            <select name="city" id="city">
                <option value="" <?php ?>>Select_city</option>
            </select>
            <span style="color: red;"><?php if (!empty($error['city'])) {
                                            echo $error['city'];
                                        } ?></span>
            <br><br>
            <label for="pincode">Pincode</label>
            <input type="number" name="pincode" placeholder="Enter your pincode" value="<?php if (isset($_POST['pincode'])) {
                                                                                            echo $pincode;
                                                                                        } else {
                                                                                            echo $dbpincode;
                                                                                        } ?>">
            <span style="color: red;"><?php if (!empty($error['pincode'])) {
                                            echo $error['pincode'];
                                        } ?></span>
            <br><br>
            <input type="submit" value="submit" name="submit">
        </form>
    </div>
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            function loadData(state_id,city_id) {
                $.ajax({
                    url: "loaddata.php",
                    type: "POST",
                    data: {
                        id: state_id,
                        cid: city_id,
                    },
                    success: function(data) {
                        $("#city").html(data);
                    }
                });
            }
            $("#state").on("change", function() {
                var state = $("#state").val();
                var city = '<?php if(isset($_POST['city_id'])){ echo $_POST['city_id'];} ?>';
                if (state != "") {
                    loadData(state, city);
                } else {
                    $("#city").html('<option value="">Select_city</option>');
                }
            })
            loadData(<?php echo $dbstate; ?>, <?php echo $dbcity; ?>);
        });
    </script>
</body>

</html>