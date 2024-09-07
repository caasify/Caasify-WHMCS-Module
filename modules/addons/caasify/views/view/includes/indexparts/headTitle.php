<?php include_once('modalcharge.php'); ?>
<?php include_once('successmodal.php'); ?>
<?php include_once('failmodal.php'); ?>
<div class="mt-5 px-3 px-md-4 d-block d-md-none">
    <div class="d-flex flex-row justify-content-between align-items-center ms-3">
        <p class="m-0 p-0 h3 fw-bolder text-dark">
            {{ lang('Cloud Account') }}
        </p>
        <div class="text-dark d-flex flex-row justify-content-center align-items-center p-0 mb-1" style="--bs-bg-opacity: 0.2">
            <?php include('./includes/baselayout/langbtn.php'); ?>
        </div>
    </div>
</div>
<div class="d-flex flex-row justify-content-between align-items-end px-2 px-md-4 mt-3 mt-md-5">
    <div class="row d-none d-md-block ms-3">
        <div class="d-flex flex-row justify-content-start align-items-center mt-5">
            <div class="row me-4">
                <p class="m-0 p-0 h3 fw-bolder text-dark">
                    {{ lang('Cloud Account') }}
                </p>
            </div>
        </div>
    </div>    
    <div class="row d-block d-md-none">
        <p> </p>
    </div>    
    <div class="d-flex flex-row justify-content-start align-items-end flex-wrap">
        <div class="me-1 mb-1">
            <a class="btn btn-outline-primary px-3 py-2" @click="openCreatePage" target='_top'>
                {{ lang('createorder') }}
            </a>
        </div>
        <div class="me-1 mb-1">
            <div class="btn-group">
                <a class="btn btn-outline-primary py-2" type="button" data-bs-toggle="modal" data-bs-target="#chargeModal">
                    <span v-if="user.balance != null && CurrenciesRatioCloudToWhmcs != null" class="">
                        <span class="fw-medium">
                            <span class="">
                                {{ formatUserBalance(user.balance - user.debt) }}
                            </span>
                            <span v-if="userCurrencySymbolFromWhmcs != null" class="px-1">
                                {{ userCurrencySymbolFromWhmcs }}
                            </span>
                        </span>
                    </span>
                    <span v-else class="fw-medium">
                        <?php include('./includes/baselayout/threespinner.php'); ?>
                    </span>
                </a>
                <button type="button" class="btn btn-primary py-2" data-bs-toggle="modal" data-bs-target="#chargeModal">
                    {{ lang('topup') }}
                </button>
            </div>
        </div>
        <div class="text-dark d-flex flex-row justify-content-center align-items-center p-0 mb-1 d-none d-md-block ms-2" style="--bs-bg-opacity: 0.2">
            <?php include('./includes/baselayout/langbtn.php'); ?>
        </div>
    </div>
</div> 