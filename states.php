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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <div>
        <button style="margin-top :10px; margin-left:5px;"><a href="add_states.php">Add_state</a></button>
        <table class="table table-striped" id="tablet1">
            <tr>
                <th>Id</th>
                <th>State</th>
                <th>Status</th>
                <th>Delete</th>
                <th>Edit</th>

            </tr>
            <tr>
                <?php $row = selectstatedata();
                foreach ($row as $result) { ?>
                    <td><?php echo $result['id']; ?></td>
                    <td><?php echo $result['state']; ?></td>
                    <td><?php echo $result['status']; ?></td>
                    <td><button class="btn btn-danger" id="button" onclick="return confirmation()" ;> <a href="delete_states.php?id=<?php echo $result['id']; ?>" style="color:white">Delete</a></button> <?php  ?></td>
                    <td> <button class="btn btn-primary"> <a href="edit_states.php?id=<?php echo $result['id']; ?>" style="color:white">Edit</a></button><?php  ?></td>
            </tr>
        <?php } ?>
        </table>
    </div>
    <script>
        function confirmation() {
            return confirm('Are you sure you want to delete this record');
        }
    </script>
</body>

</html>