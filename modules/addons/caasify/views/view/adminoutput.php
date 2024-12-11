
<?php $parentFileName = basename(__FILE__, '.php'); ?>
<?php  include('config.php');   ?>
<?php  include_once('./includes/baselayout/header.php');   ?>
<body class="container-fluid m-0 p-0" style="background-color: #ff000000 !important;">
    <div class="bg-white p-0 m-0" style="width:99%;">
        <div class="adminoutputapp col-12" v-cloak>
            <?php  include_once('./includes/admin/main.php');   ?>
        </div>
    </div>
<?php include_once('./includes/baselayout/footer.php'); ?>