

<div v-if="thisOrder?.type == 'vpn'" class="col-12 border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0">
    <!-- header -->
    <div class="row">
        <div class="d-flex flex-row justify-content-between align-items-center mb-2">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <img src="<?php echo($systemUrl); ?>/modules/addons/caasify/views/view/includes/assets/img/osicon.svg" width="18">
                <span class="m-0 p-0 text-secondary ps-2" style="font-size: 1.15rem !important;">
                    {{ lang('Order Info') }}
                </span>
                <button v-if="thisOrder?.id" class="small btn bg-primary btn-sm p-0 m-0 px-3 ms-3 py-2 text-primary" style="--bs-bg-opacity: 0.2;">
                    <span class="p-0 m-0">
                        {{ thisOrder?.id }}
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="m-0 p-0 pb-2">
        <hr class="text-secondary border-2 border-secondary m-0 p-0">
    </div>
    
    <!-- VPN code to copy -->
    <div class="p-0 m-0 py-2">
        <!-- qrcode img -->
        <div v-if="!qrcodeIsLoaded" class="text-primary">
            <span class="pe-2">
                {{ lang('loadingmsg') }}
            </span>
            <span>
                <?php include('./includes/baselayout/threespinner.php'); ?>
            </span>    
        </div>
        <div id="qrcode" class="img-fluid m-0 p-2 p-md-3"></div>

        <div v-if="vpnShowIsLoaded == true"  class="d-flex flex-row justify-content-start align-items-center px-2 px-md-3 py-4">
            <span class="text-secondary me-3" style="font-size: 1.1rem !important;">
                Link Profile :
            </span>
            <span v-if="vpnShowIsLoaded == true && thisVpnOrder" class="">
                <button class="btn btn-primary px-4 fs-6" @click="copyVpnCode(thisVpnOrder?.subscription)" style="width: 80px;">
                    <span v-if="!BtnCopyVpnPushed">
                        Copy
                    </span>
                    <span v-if="BtnCopyVpnPushed">
                        <i class="col-auto m-0 p-0 bi bi-check2-circle"></i>
                    </span>
                </button>
            </span>
        </div>
    </div>
    
</div>