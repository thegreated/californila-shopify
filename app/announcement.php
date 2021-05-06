<?php require_once('../admin/initialize.php');
$announcement = new Announcement();
?>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

    <ul class="list-group">
    <?php  $announces = $announcement->find_all();
        foreach($announces as $announce){
    ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
    <?php echo $announce->announce;
     $date = date('l jS \of F Y', strtotime ($announce->date_created));
    ?>
        <span class="badge badge-primary badge-pill"><?=$date?></span>
    </li>
    <?php } ?>

    </ul>

</body>
</html>