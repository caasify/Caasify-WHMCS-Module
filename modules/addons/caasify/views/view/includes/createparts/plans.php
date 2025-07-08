<!-- plan-->
<div class="row m-0 p-0 px-0 px-md-1 pt-2" id="plans">
    <div class="col-12" style="--bs-bg-opacity: 0.1;">
        <div v-if="plansAreLoading" class="row">
            <div class="col-12 mb-5">
                <div class="row">
                    <table class="table table-light">
                        <thead>
                            <tr>
                                <th scope="col" class="fs-6 fw-medium">
                                    <span>
                                        {{ lang('Product Details') }}
                                    </span>
                                </th>
                                <th scope="col" style="width: 110px;" class="fs-6 fw-medium text-center">
                                    <span>
                                        <span style="text-wrap:nowrap;">
                                            {{ lang('Cost') }} 
                                        </span>
                                        <span v-if="userCurrencySymbolFromWhmcs">
                                            ({{userCurrencySymbolFromWhmcs}})
                                        </span>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <div class="m-0 p-0" :style="'opacity: ' + opacity">
                        <table class="align-middle" style="width:100%;">
                            <tbody class="text-center">
                                <tr v-for="i in Array.from({ length: 3 }, (v, k) => k + 1)">
                                    <td class="m-0 p-0 pe-1 py-1">
                                        <div class="row w-100 border rounded-3 bg-white text-dark shadow-sm py-2 px-2 bg-white plans-childs btn my-1"
                                            style="--bs-bg-opacity: 0.1; --bs-text-opacity: 0.2; direction:ltr">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                        <p class="m-0 p-0"> CPU: <span class="text-primary" style="--bs-text-opacity: 0.2;">2 Core </span> Intel-Shared</p>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                        <p class="m-0 p-0"> Memory: <span class="text-primary" style="--bs-text-opacity: 0.2;">4GB</span></p>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                        <p class="m-0 p-0"> Disk: <span class="text-primary" style="--bs-text-opacity: 0.2;">20GB</span> SSD</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                        <p class="m-0 p-0">Turkey-Istanbul</p>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                        <p class="m-0 p-0"> Traffic: 1TB </p>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                        <p class="m-0 p-0"> IP Version: IPv4</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="m-0 p-0 ps-1 py-1" style="width: 110px;">
                                        <div class="border rounded-3 bg-white text-dark shadow-sm py-2 px-4" style="cursor: pointer; --bs-text-opacity: 0.2;">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <p class="m-0 p-0" style="text-wrap: nowrap; --bs-text-opacity: 0.2;">2 Monthly </p>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <p class="m-0 p-0 small" style="text-wrap: nowrap; --bs-text-opacity: 0.2;">0.0030 Hourly </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div> <!-- end order  -->
            </div>
        </div>
        <!-- order details -->
        <div v-if="plansAreLoaded" class="row mt-2">
            <table class="table table-light">
                <thead>
                    <tr>
                        <th scope="col" class="fs-6 fw-medium">
                            <div class="d-flex flex-row align-items-center justify-content-start">
                                <span>
                                    {{ lang('Product Details') }}
                                </span>
                                <button class="btn btn-primary px-4 mx-3 d-block d-md-none rounded-0 py-2 rounded-2" data-bs-toggle="modal" data-bs-target="#filtersModal"> 
                                    {{ lang('Filter Products') }}
                                </button>
                            </div>
                        </th>
                        <th scope="col" style="width: 110px;" class="fs-6 fw-medium text-center">
                            <div class="d-flex flex-row align-items-center justify-content-start">
                                <span>
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Monthly price is based on 640 hours">
                                        {{ lang('Cost') }} ({{userCurrencySymbolFromWhmcs}})
                                    </span>
                                </span>
                            </div>
                        </th>
                    </tr>
                </thead>
            </table>
            <div class="m-0 p-0" style="">
                <div v-if="noPlanToShow" class="row mt-3 ps-1">
                    <div class="col-12">
                        <p class="alert alert-primary">
                            {{ lang('There is no product with this filters') }}
                        </p>
                    </div>
                </div>
                <table v-if="AllPlansSorted" class="align-middle" style="width:100%;">
                    <tbody class="text-center">
                        <div class="" v-if="AllPlansSorted">
                            <tr v-for="plan, key in AllPlansSorted" :id="key" v-show="isAvailableByCapacity(plan)">
                                <td class="m-0 p-0 pe-1 py-2">
                                    <div
                                        :class="thePlansClass(plan)"
                                        :style="thePlansStyle(plan)"
                                        @click="selectPlan(plan)" data-bs-toggle="modal" data-bs-target="#configModal"
                                        class="row w-100 border rounded-3 text-dark shadow-sm py-2 px-2 plans-childs btn my-1 position-relative"
                                        style="direction:ltr;"
                                        >
                                        <div class="col-12 py-2">
                                            <div class="row">
                                                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                    <p class="m-0 p-0">
                                                        <span :class="thePlansTextClass(plan)"> {{ plan.detail.cpu_core }} Core </span> {{ plan.detail.cpu_type }}
                                                    </p>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                    <p class="m-0 p-0">
                                                        Memory: <span :class="thePlansTextClass(plan)">{{ plan.detail.memory_size }}GB</span>
                                                    </p>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                    <p class="m-0 p-0">
                                                        Disk: <span :class="thePlansTextClass(plan)">{{ plan.detail.disk_size }}GB</span> {{ plan.detail.disk_type }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 py-1">
                                            <div class="row">
                                                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                    <p class="m-0 p-0 d-flex align-items-center gap-2">
                                                        <img :src="`./includes/assets/img/countries/${plan.detail.dc_country}.svg`" width="20" :title="plan.detail.dc_country" :alt="plan.detail.dc_country"> {{ plan.detail.dc_city }} - {{ plan.detail.dc_name }}
                                                    </p>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                    <p class="m-0 p-0">
                                                        Traffic: <span :class="thePlansTextClass(plan)">{{ plan.traffic_limit/1000 }}TB</span>
                                                    </p>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                    <p class="m-0 p-0">
                                                        IP Version: <span :class="thePlansTextClass(plan)">{{ plan.detail.ip_type }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- badge -->
                                        <div class="" v-if="!isPlan(plan)">
                                            <span 
                                                v-if="!plan.hasOwnProperty('suggested') && plan?.detail?.vm_type.toLowerCase() == 'spot'"
                                                class="bg-success text-white position-absolute top-0 start-10 translate-middle badge rounded-pill px-2" 
                                                style="width:auto; --bs-bg-opacity: 0.8;"
                                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title = "SPOT" style="cursor: pointer;">
                                                    <span class="small">
                                                        Spot        
                                                    </span>
                                            </span>
                                            <span 
                                                v-if="plan.hasOwnProperty('suggested') && plan?.detail?.vm_type.toLowerCase() != 'spot'"
                                                class="bg-primary text-white position-absolute top-0 start-10 translate-middle badge rounded-pill px-2" 
                                                style="width:auto; --bs-bg-opacity: 0.8;"
                                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title = "Recommended" style="cursor: pointer;">
                                                    <span class="small">
                                                        RMD 
                                                    </span>
                                            </span>
                                            <span 
                                                v-if="plan.hasOwnProperty('suggested') && plan?.detail?.vm_type.toLowerCase() == 'spot'" 
                                                class="bg-success text-white position-absolute top-0 start-10 translate-middle badge rounded-pill px-2" style="width:auto;"
                                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title = "Recommended/SPOT" style="cursor: pointer;">
                                                    <span class="small">
                                                        * SPOT
                                                    </span>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="m-0 p-0 ps-1 py-2" style="width: 110px;">
                                    <div v-if="plan.price && plan.price != null && plan.price != NaN"
                                        class="border rounded-3 text-dark shadow-sm py-2 px-4"
                                        :class="thePlansClass(plan)"
                                        :style="thePlansStyle(plan)"
                                        @click="selectPlan(plan)" data-bs-toggle="modal" data-bs-target="#configModal" style="cursor: pointer;">
                                        <div class="row" v-if="CommissionIsValid">
                                            <div class="col-12 py-2">
                                                <div class="row">
                                                    <p class="m-0 p-0" style="text-wrap: nowrap;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Based on 640 hours">
                                                        {{ formatPlanPrice(plan.price) }} Monthly
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-12 py-1">
                                                <div class="row">
                                                    <p class="m-0 p-0 small" style="text-wrap: nowrap;">
                                                        {{ formatPlanPrice(plan.hourly_price) }} Hourly
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else>
                                            Nan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- end plan -->