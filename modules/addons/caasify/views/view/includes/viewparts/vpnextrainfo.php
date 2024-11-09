<div class="row m-0 p-0 h-100">
    <!-- vpn qrcode -->
    <?php include('./includes/viewparts/vpnorderinfo.php');   ?>
    <!-- vps traffic -->
    <div v-if="thisOrder?.type == 'vps'" class="col-12 border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0 h-100" style="height: 150px;">
        <!-- header -->
        <div class="row">
            <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <img src="<?php echo($systemUrl); ?>/modules/addons/caasify/views/view/includes/assets/img/bandwidth.svg" width="18">
                    <span class="m-0 p-0 text-secondary ps-2" style="font-size: 1.15rem !important;">
                        {{ lang('traffics') }}
                    </span>
                </div>
                <div class="text-end text-primary fw-medium p-0 m-0">
                    <span v-if="TrafficTotal" class="" style="font-size: 1.15rem !important;">
                        {{ TrafficTotal }}
                    </span>
                </div>
            </div>
        </div>
        <div class="m-0 p-0 pb-2">
            <hr class="text-secondary border-2 border-secondary m-0 p-0">
        </div>
        
        <!-- inbound outbond -->
        <div v-if="trafficsIsLoaded == true" class="row pt-2">
            <div class="row fw-medium py-1">
                <span>
                    <span class="text-secondary">
                        <i class="bi bi-cloud-arrow-down fs-5 pe-2"></i>
                    </span>
                    <span class="ps-1 text-secondary">
                        {{ lang('Inbound') }}
                    </span>
                    <span class="px-1 text-secondary">:</span>
                    
                    <span class="text-primary" v-if="TrafficInbound">
                        {{ TrafficInbound }}
                    </span>
                    <span class="text-primary" v-else>
                        0 MB
                    </span>
                </span>
            </div>
            <div class="row fw-medium py-1">
                <span>
                    <span class="text-secondary">
                        <i class="bi bi-cloud-arrow-up-fill fs-5 pe-2"></i>
                    </span>
                    <span class="ps-1 text-secondary">
                        {{ lang('Outbound') }}
                    </span>
                    <span class="px-1 text-secondary">:</span>
                    <span class="text-primary" v-if="TrafficOutbound">
                        {{ TrafficOutbound }}
                    </span>
                    <span class="text-primary" v-else>
                        0 MB
                    </span>
                </span>
            </div>
        </div>
        
        <!-- extra traffic -->
        <div class="row pt-5" v-if="thisOrder?.records[thisOrder.records.length-1]?.traffic_price && trafficsIsLoaded == true">
            <div class="d-flex flex-row justify-content-between align-items-center border py-3 px-3 rounded-3">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <span class="m-0 p-0 text-secondary ps-2">
                        {{ lang('extraTraffic') }}
                    </span>
                </div>
                <div class="text-end text-primary fw-medium p-0 m-0">
                    <span>
                    {{ formatUserBalance(thisOrder?.records[thisOrder.records.length-1]?.traffic_price) }}
                    </span>
                    <span class="px-1">
                        {{ userCurrencySymbolFromWhmcs }}/{{ lang('gb') }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Loading -->
        <div v-if="trafficsIsLoaded != true" class="row pt-2 text-primary">
            <span>
                <span class="pe-2">
                    {{ lang('loadingmsg') }}
                </span>
                <span>
                    <?php include('./includes/baselayout/threespinner.php'); ?>
                </span>    
            </span>
        </div>
    </div>
    <!-- vpn traffic -->
    <div v-if="thisOrder?.type == 'vpn'" class="col-12 border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0">
        <div v-if="vpnShowIsLoaded != true" class="p-0 m-0 py-2">
            <span class="text-primary">
                <span class="pe-2">
                    {{ lang('loadingmsg') }}
                </span>
                <span>
                    <?php include('./includes/baselayout/threespinner.php'); ?>
                </span>    
            </span>
        </div>

        <!-- VPN Traffic Usage -->
        <div v-if="vpnShowIsLoaded == true" class="p-0 m-0 py-2">
            <span class="pe-2 text-secondary" style="font-size: 1.1rem !important;">
                Traffic Usage :
            </span>
            <span v-if="vpnShowIsLoaded == true && trafficUsage">
                <span v-if="trafficUsage" class="text-primary h5">
                    {{ trafficUsage }}
                </span>
            </span>
        </div>

        <!-- VPN Price -->
        <div v-if="vpnShowIsLoaded == true" class="p-0 m-0 py-2">
            <span class="pe-2 text-secondary" style="font-size: 1.1rem !important;">
                Price :
            </span>
            <span v-if="vpnTrafficPrice > 0">
                <span class="text-primary h5">
                    {{ formatPlanPrice(vpnTrafficPrice) }}
                </span>
            </span>
            <span v-else>
                -
            </span>
        </div>
    </div>
    
</div>

