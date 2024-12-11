<?php $parentFileName = basename(__FILE__, '.php'); ?>
<?php  include('./config.php'); ?>
<?php  include('./includes/baselayout/header.php');   ?>
<body class="container-fluid" style="background-color: #ff000000 !important;">
<div class="row bg-white rounded-4 border border-2 border-body-secondary">
    <div class="col-12 px-3 px-md-4 my-5" id="app">
        <div class="row m-0 p-0">
            <?php include('./includes/resellerparts/headtitle.php'); ?>    
            <?php include('./includes/resellerparts/modalcharge.php'); ?>
            <?php include('./includes/baselayout/balancealertmodal.php'); ?>    
            <?php include('./includes/resellerparts/failmodal.php'); ?>    
            <?php include('./includes/resellerparts/successmodal.php'); ?>    
            <div v-if="CaasifyResellerUserIsLoaded == true" class="d-flex flex-row justify-content-start align-items-start flex-wrap m-0 p-0 gap-5" style="max-width: 1000px !important;">
                <div class="" style="width: 400px;">
                    <?php include('./includes/resellerparts/userprofile.php'); ?>
                    <?php include('./includes/resellerparts/userfinance.php'); ?>
                </div>
                <div class="flex-grow-1">
                    <?php include('./includes/resellerparts/downloadlinks.php'); ?>
                </div>
            </div>
            <div v-if="CaasifyResellerUserIsLoaded == false" class="d-flex flex-row align-items-center justify-content-center h5" style="height:300px">
                <div class="text-primary">
                    <span>
                        Loadin data 
                    </span>
                    <span>
                        <?php  include('./includes/baselayout/threespinner.php');     ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div> 

<?php include('./includes/baselayout/footer.php'); ?>
