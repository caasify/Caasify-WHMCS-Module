<?php  include('./config.php'); ?>
<?php  include('./includes/baselayout/header.php');   ?>
<body class="container-fluid m-0 p-0" style="background-color: #ff000000 !important;">
    <div class="row py-5">
        <div class="col-12" id="app">
            <div class="bg-white rounded-4 border border-2 border-body-secondary" v-cloak>
            <?php include('./includes/indexparts/headtitle.php');     ?>
            <?php include('./includes/indexparts/orderslist.php');  ?>
        </div>
    </div>
</div> 

<?php include('./includes/baselayout/footer.php'); ?>

