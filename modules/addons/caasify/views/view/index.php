<?php $parentFileName = basename(__FILE__, '.php'); ?>
<?php  include('./config.php'); ?>
<?php  include('./includes/baselayout/header.php');   ?>
<body class="m-0 p-0 px-1" style="background-color: #ff000000 !important; width:99%">
<div class="row py-2" style="overflow: hidden !important;">
    <div class="col-12" id="app">
        <div class="" v-cloak>
            <?php include('./includes/baselayout/balancealertmodal.php');?>
            <?php include('./includes/indexparts/modalreseller.php');    ?>
            <div class="bg-white rounded-4 border border-2 border-body-secondary" v-if="CommissionIsValid" style="height:650px;">
                <?php if(isset($DemoMode) && $DemoMode == 'on' ): ?>
                    <?php  include('./includes/baselayout/demoheader.php');   ?>
                <?php endif ?>
                <?php include('./includes/indexparts/headtitle.php');     ?>
                <?php include('./includes/indexparts/orderslist.php');    ?>
            </div>
            <div class="bg-white rounded-4 border border-2 border-body-secondary p-4" v-else>
                <p class="h5 p-4 alert alert-danger">
                    Error 670: Commission is not valid, enter a valid value (ENGLISH Number) in WHMCS Setting -> Addons
                </p>
            </div>
        </div>
    </div>
</div>  

<?php include('./includes/baselayout/footer.php'); ?>
