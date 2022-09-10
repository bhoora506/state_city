<?php
include 'functions.php';

$id = $_POST['id'];
$cities = selectcitydatatwo($id);
echo  '<option value="">Select_city</option>';
foreach ($cities as $city) {
  $selected = "";
  if (isset($_POST['cid'])) {
    if ($city['id'] == $_POST['cid']) {
      $selected = "selected";
    }
  } ?>
  <option value="<?php echo $city['id']; ?>" <?php echo $selected; ?>><?php echo $city['city']; ?></option>
<?php

}
