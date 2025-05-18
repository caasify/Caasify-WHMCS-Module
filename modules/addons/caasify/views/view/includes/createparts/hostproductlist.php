<div class="col-12 pt-5">
    <p class="h4 fw-medium">
        {{ lang('Product Details') }}
    </p>
</div>
<div class="col-12 p-0 mt-1">    
    <hr class="w-100 text-dark pt-0 pb-0 mt-0">
    <div v-if="HostPlansAreLoaded && !noHostPlanToShow && !HostPlansAreLoading" >
        <div v-for="plan in HostPlans" 
        class="bg-white w-100 border rounded-3 text-dark shadow-sm py-3 px-3 px-md-4 plans-childs btn my-2 position-relative" 
        :class="thePlansClass(plan)"
        :style="thePlansStyle(plan)"
        @click="selectPlan(plan)" data-bs-toggle="modal" data-bs-target="#configModal"
        >
            <div class="d-flex flex-row justify-content-between align-items-center flex-wrap gap-5">

                <div class="d-flex flex-row justify-content-between align-items-center flex-wrap gap-5" v-html="plan.description"></div>
                
                <div class="">
                    <span class="text-secondary">
                        {{ lang('Cost') }}
                    </span>
                    <span class="px-1">
                        :
                    </span>
                    <span>
                        {{ formatPlanPrice(plan?.price) }} {{ userCurrencySymbolFromWhmcs }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4" v-if="HostPlansAreLoaded && noHostPlanToShow">
        <p class="alert alert-primary">
            {{ lang('There is no product with this filters') }}
        </p>
    </div>
    <div class="mt-4" v-if="HostPlansAreLoading">
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