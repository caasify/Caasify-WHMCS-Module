<?php $parentFileName = basename(__FILE__, '.php'); ?>
<?php  include('./config.php'); ?>
<?php  include('./includes/baselayout/header.php');   ?>

<body class="container-fluid p-1 p-md-3 bg-body-secondary">
    <div id="app" class="row py-5 mx-auto px-0 px-md-2 px-lg-4" style="max-width: 1200px;">
        <div class="" v-cloak>
            <?php include('./includes/baselayout/balancealertmodal.php');     ?>
            <?php if(isset($DemoMode) && $DemoMode == 'on' ): ?>
                <?php  include('./includes/baselayout/DemoHeader.php');   ?>
                <p class="mt-4"></p>
            <?php endif ?>
            <?php  include('./includes/baselayout/backflash.php');     ?>
            <div class="col-12 m-0 p-0 mt-5" style="min-height: 1000px">
                <div class="row m-0 p-0">
                    <div class="col-12 m-0 p-0">
                        <div class="py-5 px-1" v-if="CommissionIsValid">
                            <?php include('./includes/viewparts/modalActions.php');  ?>
                            <?php include('./includes/viewparts/allViews.php');     ?>
                        </div>
                        <div class="py-5 px-1" v-else>
                            <p class="h5 p-4 alert alert-danger">
                                Error 670: Commission is not valid, enter a valid value (ENGLISH Number) in WHMCS Setting -> Addons
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('./includes/baselayout/footer.php'); ?>