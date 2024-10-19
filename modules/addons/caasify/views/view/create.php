<?php $parentFileName = basename(__FILE__, '.php'); ?>
<?php  include('./config.php');   ?>
<?php  include('./includes/baselayout/header.php');   ?>

<body class="container-fluid p-1 p-md-3" style="background-color: #ff000000 !important;">
    <div id="app" class="row px-1 px-md-2 py-2 mx-auto" style="max-width: 1200px;">
        <div class="p-0 m-0" :class="{ loading: CreateIsLoading }" v-cloak v-if="CommissionIsValid">
            <?php include('./includes/baselayout/balancealertmodal.php');     ?>
            <?php  include('./includes/baselayout/backflash.php');     ?>
            <?php  include('./includes/createparts/modalconfigs.php');     ?>
            <?php  include('./includes/createparts/modalcreate.php');     ?>
            <?php if(isset($DemoMode) && $DemoMode == 'on' ): ?>
                <?php  include('./includes/baselayout/modaldemo.php');     ?>
            <?php endif ?>
            <div class="col-12 bg-white rounded-4 m-0 p-0 mt-5"
                style="min-height: 1800px">
                <?php if(isset($DemoMode) && $DemoMode == 'on' ): ?>
                    <?php  include('./includes/baselayout/demoheader.php');   ?>
                <?php endif ?>
                <!-- lang BTN     -->
                <div class="row">
                    <div class="col-12">
                        <div class="py-3 px-">
                            <div class="d-flex flex-row justify-content-between align-items-center" id="topSelect">
                                <div class="">
                                    <span class="h5">
                                        {{ lang('Select a Category') }}
                                    </span>
                                </div>
                                <div class="">
                                    <div class="col-auto m-0 p-0">
                                        <?php include('./includes/baselayout/langbtn.php'); ?>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <!-- parent categories -->
                <div class="row m-0 p-0">
                    <div class="col-12 px-2 px-md-2">
                        <?php  include('./includes/createparts/parentcategories.php');  ?>
                    </div>
                </div>
                <!-- filters -->
                <div class="row m-0 p-0">
                    <div class="col-12 col-md-3 px-2 px-md-0 py-1 pe-md-1 d-none d-md-block">
                        <div class="rounded-4 px-0 px-md-2 pt-4 bg-primary" style="min-height: 330px; --bs-bg-opacity: 0.06;">
                            <?php  include('./includes/createparts/filterterms.php');   ?>
                        </div>
                        <!-- <div v-if="FilterTermsAreLoaded" class="row">
                            <div class="col-12 px-1">
                                <button class="btn btn-primary col-12 mt-4" @click="selectedTermsSave">
                                    {{ lang('Filter') }}
                                </button>
                            </div>        
                        </div> -->
                    </div>
                    <div class="col-12 col-md-9 px-0 px-md-0 py-1 ps-md-1">
                        <div class="rounded-4 px-0 px-md-2 py-4" style="min-height: 330px;">
                            <?php  include('./includes/createparts/plans.php');         ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-4 border border-2 border-body-secondary p-4" v-cloak v-else>
            <p class="h5 p-4 alert alert-danger">
                Error 670: Commission is not valid, enter a valid value (ENGLISH Number) in WHMCS Setting -> Addons
            </p>
        </div>
    </div>
    <?php include('./includes/baselayout/footer.php'); ?>