<?php
include('functions.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Display Address</title>
</head>

<body>
    <div class="container">
        <button><a href="add_address.php">Add_user</a> </button>
        <table class="table table-striped">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>State</th>
                <th>City</th>
                <th>Pincode</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>

            <?php $query = selectaddress();
            while ($resutl = mysqli_fetch_assoc($query)) { ?>
                <tr>
                    <td><?php echo $resutl['id']; ?></td>
                    <td><?php echo $resutl['name']; ?></td>
                    <td><?php echo $resutl['email']; ?></td>
                    <td><?php echo $resutl['mobile_No']; ?></td>
                    <td><?php echo $resutl['state']; ?></td>
                    <td><?php echo $resutl['city']; ?></td>
                    <td><?php echo $resutl['pincode']; ?></td>
                    <td><button class="btn btn-primary"><a  style="color: white;" href="edit_address.php?id=<?php echo $resutl['id']; ?>" > Edit</a></button></td>
                    <td><button class="btn btn-danger" onclick="return confirmation();" ><a  style="color: white;" href="deleteaddress.php?id=<?php echo $resutl['id'] ?>"> Delete</a></button></td>
                </tr>
            <?php }
            ?>

        </table>
    </div>
    <script>
        function confirmation(){
            return confirm('Are you sure you want to delete this record');
        }
    </script>
    
</body>

</html>