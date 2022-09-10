<?php

include 'functions.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <div>
        <button><a href="add_cities.php">Add_city</a></button>
    </div>
    <div class="container">
        <table class="table table-striped">
            <tr>
                <th>Id</th>
                <th>City</th>
                <th>Statename</th>
                <th>Status</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
            <tr>
                <?php $row = selectcitydata();
                foreach ($row as $result) { ?>
                    <td><?php echo $result['id']; ?></td>
                    <td><?php echo $result['city']; ?></td>
                    <td><?php echo $result['statename']; ?></td>
                    <td><?php echo $result['status']; ?></td>
                    <td><button class="btn btn-danger" id="button" onclick="return confirmation()" ;> <a href="delete_cities.php?id=<?php echo $result['id']; ?>" style="color:white">Delete</a></button> </td>
                    <td> <button class="btn btn-primary"> <a href="edit_cities.php?id=<?php echo $result['id']; ?>" style="color:white">Edit</a></button></td>
            </tr>
        <?php } ?>
        </table>
    </div>
    <script>
        function confirmation() {
            return confirm('Are you sure you want to record this record');
        }
    </script>
    
</body>

</html>