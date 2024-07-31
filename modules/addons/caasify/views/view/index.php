<?php $parentFileName = basename(__FILE__, '.php'); ?>
<?php  include('./config.php'); ?>
<?php  include('./includes/baselayout/header.php');   ?>
<body class="container-fluid m-0 p-0" style="background-color: #ff000000 !important;">
<div class="row py-5">
    <div class="col-12" id="app">
        <?php include('./includes/baselayout/balanceAlertModal.php');?>
        <div class="bg-white rounded-4 border border-2 border-body-secondary" v-cloak v-if="CommissionIsValid">
            <?php if(isset($DemoMode) && $DemoMode == 'on' ): ?>
                <?php  include('./includes/baselayout/demoHeader.php');   ?>
            <?php endif ?>
            <?php include('./includes/indexparts/headTitle.php');     ?>
            <?php include('./includes/indexparts/ordersList.php');    ?>
        </div>
        <div class="bg-white rounded-4 border border-2 border-body-secondary p-4" v-cloak v-else>
            <p class="h5 p-4 alert alert-danger">
                Error 670: Commission is not valid, enter a valid value (ENGLISH Number) in WHMCS Setting -> Addons
            </p>
        </div>
    </div>
</div>  

<?php include('./includes/baselayout/footer.php'); ?>
