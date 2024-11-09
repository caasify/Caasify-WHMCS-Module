<div class="col-12 pt-5">
    <p class="h4 fw-medium">
        {{ lang('Product Details') }}
    </p>
</div>
<div class="col-12 p-0 mt-1">    
    <hr class="w-100 text-dark pt-0 pb-0 mt-0">
    <div v-if="VpnPlansAreLoaded && !noVpnPlanToShow && !VpnPlansAreLoading" >
        <div 
        v-for="plan in VpnPlans" 
        class="bg-secondary w-100 border rounded-3 text-dark shadow-sm py-3 px-3 px-md-4 plans-childs btn my-1 position-relative" 
        style="--bs-bg-opacity: 0.01;"
        :class="thePlansClass(plan)"
        :style="thePlansStyle(plan)"
        @click="selectPlan(plan)" data-bs-toggle="modal" data-bs-target="#configModal"
        >
            <div class="row justify-content-between align-items-center flex-wrap">
                <div class="col-12 col-sm-6 col-lg-3 py-2">
                    <span class="text-secondary">
                        {{ lang('Locations') }}
                    </span>
                    <span class="px-1">
                        :
                    </span>
                    <span>
                        {{ lang('Germany, Netherland') }}
                    </span>
                </div>
                <div v-if="plan?.traffic_limit" class="col-12 col-sm-6 col-lg-3 py-2">
                    <span class="text-secondary">
                        {{ lang('Free Traffic') }}
                    </span>
                    <span class="px-1">
                        :
                    </span>
                    <span>
                        {{ plan?.traffic_limit }} {{ lang('MB') }} {{ lang('monthly') }}
                    </span>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 py-2">
                    <span class="text-secondary">
                        {{ lang('Duration') }}
                    </span>
                    <span class="px-1">
                        :
                    </span>
                    <span>
                        {{ lang('Unlimited') }}
                    </span>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 py-2">
                    <span class="text-secondary">
                        {{ lang('Traffic Price') }}
                    </span>
                    <span class="px-1">
                        :
                    </span>
                    <span>
                        {{ formatTotalMachinePrice(plan?.traffic_price) }} {{ userCurrencySymbolFromWhmcs }} /{{ lang('GB') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4" v-if="VpnPlansAreLoaded && noVpnPlanToShow">
        <p class="alert alert-primary">
            {{ lang('There is no product with this filters') }}
        </p>
    </div>
    <div class="mt-4" v-if="VpnPlansAreLoading">
        <p class="alert alert-primary" :style="'opacity: ' + opacity">
            <span class="">
                {{ lang("loadingmsg") }}
            </span>
            <span class="m-0 p-0 ps-2">
                <?php include('./includes/baselayout/threespinner.php'); ?>
            </span>
        </p>
    </div>
</div>