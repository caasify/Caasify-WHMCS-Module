<div class="row mt-5">        
    <div class="col-12" style="--bs-bg-opacity: 0.09; --bs-border-opacity: 0.05;">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <div class="m-0 p-0 h5 fw-bold" style="--bs-text-opacity: 0.8; color: #293949;">
                Finance
            </div>
            <div v-if="CaasifyResellerUserInfo != null" class="d-flex flex-row justify-content-end align-items-center pe-2">
                <div>
                    <a class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#chargeModal">
                        {{ lang('topup') }}
                    </a>
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="mt-3 mb-4">
    <div v-if="CaasifyResellerUserInfo != null" class="row">
        <div class="col-12">
            <?php include('balanceview.php'); ?>
        </div>
        <div class="col-12 mt-1">
            <?php include('showcredit.php'); ?>
        </div>
    </div>
    <div v-if="CaasifyResellerUserInfo == null" class="row">
        <p class="alert alert-danger">
            Error 188: Call your admin
        </p>
    </div>    
</div>