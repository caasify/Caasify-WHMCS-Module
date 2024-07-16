<!-- plan-->
<div v-if="SelectedRegion != null" class="row m-0 p-0 py-5 px-0 px-md-1 px-lg-4 mt-5" id="plans">
    <div class="col-12" style="--bs-bg-opacity: 0.1;">
        <div v-if="plansAreLoading" class="row mb-4">
            <div class="m-0 p-0">
                <span class="text-dark h3">
                    {{ lang('products') }}
                </span>
                <span class="text-dark h3 px-1">
                    {{ lang('in') }}
                </span>
                <span class="text-dark h3">
                    {{ SelectedRegion.name }} *
                </span>
            </div>
        </div>
        <!-- Selected but loading -->
        <div v-if="plansAreLoading" class="row">
            <div class="col-12 mb-5">
                <div class="d-flex flex-row justify-content-start align-items-center mt-4 text-primary">
                    <p class="h5 me-4">{{ lang('loadingmsg') }}</p>
                    <span>
                        <?php include('./includes/baselayout/threespinner.php'); ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- order details -->
        <div v-if="plansAreLoaded" class="row">
            <table class="table" style="direction: ltr">
                <thead>
                    <tr>
                        <th scope="col" class="fs-5 fw-medium">
                            <span>
                                {{ lang('Product Detail') }}
                            </span>
                            <span class="ps-1">
                                ({{ lang('Price is in') }}
                            </span>
                            <span class="ps-1">
                                {{userCurrencySymbolFromWhmcs}})
                            </span>
                        </th>
                        <th scope="col" style="width: 120px;" class="fs-5 fw-medium text-center">
                            <span>
                                {{ lang('hourly') }}
                            </span>
                        </th>
                        <th scope="col" style="width: 120px;" class="fs-5 fw-medium text-center">
                            <span >
                                <span>
                                    {{ lang('monthly') }}
                                </span>
                            </span>
                        </th>
                    </tr>
                </thead>
            </table>
            <div style="max-height: 500px;overflow: scroll" class="m-0 p-0">
                <table class="table table-borderless align-middle" style="direction: ltr">
                    <tbody class="text-center">
                        <tr v-if="plans.length > 0" v-for="plan, key in sortedPlans" :id="key">
                            <td class="m-0 p-0">
                                <div v-html="plan.description" :class="{ 'border-secondary border-2 text-dark': isPlan(plan) }"
                                    @click="selectPlan(plan)"
                                    class="d-flex flex-column flex-lg-row justify-content-between align-items-center border rounded-3 bg-white text-dark shadow-sm py-3 px-4 flex-grow-1 bg-body-secondary plans-childs btn my-1"
                                    style="--bs-bg-opacity: 0.1; direction: ltr;">
                                </div>
                            </td>
                            <td style="width: 120px;">
                                <div v-if="plan.hourly_price && plan.hourly_price != null && plan.hourly_price != NaN" 
                                    class="border rounded-3 bg-white text-dark shadow-sm py-3 px-4"
                                    :class="{ 'border-secondary border-2 text-dark': isPlan(plan) }"
                                    @click="selectPlan(plan)"
                                    style="cursor: pointer;"
                                >
                                    <span v-if="CommissionIsValid">
                                        {{ formatPlanPrice(plan.hourly_price) }}
                                    </span>
                                    <span v-else>
                                        Nan
                                    </span>
                                </div>
                            </td>
                            <td class="m-0 p-0" style="width: 120px;">
                                <div v-if="plan.price && plan.price != null && plan.price != NaN" 
                                    class="border rounded-3 bg-white text-dark shadow-sm py-3 px-4"
                                    :class="{ 'border-secondary border-2 text-dark': isPlan(plan) }"
                                    @click="selectPlan(plan)"
                                    style="cursor: pointer;"
                                >
                                    <span v-if="CommissionIsValid">
                                        {{ formatPlanPrice(plan.price) }}
                                    </span>
                                    <span v-else>
                                        Nan
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div> <!-- end order  -->
    </div>
</div>
<!-- end plan -->
<div id="configsPoint"></div>