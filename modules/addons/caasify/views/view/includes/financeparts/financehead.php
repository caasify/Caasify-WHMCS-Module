<!-- Finance Head --> 
<div class="row m-0 p-0 p-1 p-sm-2 p-md-3">
    <div class="col-12 m-0 p-0" style="--bs-bg-opacity: 0.1;">
        <!-- title -->
        <div class="row">
            <div class="col-12 mb-3">
                <p class="h4">
                    {{ lang('Select a Date') }} *
                </p>
            </div>
        </div>
        <!-- dates -->
        <div class="row">
            <div class="col-12 mb-5">
                <div v-if="expenseDatesIsLoaded == true" class="row align-items-center justify-content-start flex-wrap">
                    <div v-for="expenseDate, index in expenseDates"  :key="index"
                        class="col-12 col-sm-6 col-md-3 col-lg-2 col-xxl-2 text-center p-1">
                        <div class="bg-body-secondary border rounded-3 px-3 py-3" style="cursor: pointer;"
                            :class="{ 'shadow-lg border border-2 border-secondary': isExpenseDate(expenseDate) }" 
                            @click="selectExpenseDate(expenseDate)"
                            >
                            <p class="m-0 p-0">
                                <span>
                                    <span v-if="expenseDate?.month == 1">
                                        January
                                    </span>
                                    <span v-else-if="expenseDate?.month == 2">
                                        February
                                    </span>
                                    <span v-else-if="expenseDate?.month == 3">
                                        March
                                    </span>
                                    <span v-else-if="expenseDate?.month == 4">
                                        April
                                    </span>
                                    <span v-else-if="expenseDate?.month == 5">
                                        May
                                    </span>
                                    <span v-else-if="expenseDate?.month == 6">
                                        June
                                    </span>
                                    <span v-else-if="expenseDate?.month == 7">
                                        July
                                    </span>
                                    <span v-else-if="expenseDate?.month == 8">
                                        August
                                    </span>
                                    <span v-else-if="expenseDate?.month == 9">
                                        September
                                    </span>
                                    <span v-else-if="expenseDate?.month == 10">
                                        October
                                    </span>
                                    <span v-else-if="expenseDate?.month == 11">
                                        November
                                    </span>
                                    <span v-else-if="expenseDate?.month == 12">
                                        December
                                    </span>
                                    <span v-else>
                                        {{ expenseDate?.month }}
                                    </span>
                                </span>
                                <span>
                                    {{ expenseDate?.year }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div v-else class="d-flex flex-row justify-content-start align-items-center mt-4 text-primary">
                    <p class="h5 me-4 ps-2">{{ lang('loadingmsg') }}</p>
                    <span>
                        <?php include('./includes/baselayout/threespinner.php'); ?>
                    </span>
                </div>
            </div>
        </div>
        <!-- expenses -->
        <div class="row mt-5" v-if="SelectedExpenseDate">
            <div class="col-12 mb-5">
                <!-- title -->
                <div class="row">
                    <div class="col-12 mb-3">
                        <p>
                            <span class="h4">
                                {{ lang('Expenses in') }}
                            </span>
                            <span class="h5 text-primary ps-1">
                                <span>
                                    <span v-if="SelectedExpenseDate?.month == 1">
                                        January
                                    </span>
                                    <span v-else-if="SelectedExpenseDate?.month == 2">
                                        February
                                    </span>
                                    <span v-else-if="SelectedExpenseDate?.month == 3">
                                        March
                                    </span>
                                    <span v-else-if="SelectedExpenseDate?.month == 4">
                                        April
                                    </span>
                                    <span v-else-if="SelectedExpenseDate?.month == 5">
                                        May
                                    </span>
                                    <span v-else-if="SelectedExpenseDate?.month == 6">
                                        June
                                    </span>
                                    <span v-else-if="SelectedExpenseDate?.month == 7">
                                        July
                                    </span>
                                    <span v-else-if="SelectedExpenseDate?.month == 8">
                                        August
                                    </span>
                                    <span v-else-if="SelectedExpenseDate?.month == 9">
                                        September
                                    </span>
                                    <span v-else-if="SelectedExpenseDate?.month == 10">
                                        October
                                    </span>
                                    <span v-else-if="SelectedExpenseDate?.month == 11">
                                        November
                                    </span>
                                    <span v-else-if="SelectedExpenseDate?.month == 12">
                                        December
                                    </span>
                                    <span v-else>
                                        {{ SelectedExpenseDate?.month }}
                                    </span>
                                </span>
                                <span>
                                    {{ SelectedExpenseDate?.year }}
                                </span>
                            </span>
                        </p>
                    </div>
                </div>
                <!-- list -->
                <div class="row">
                    <!-- expenses table -->
                    <div v-if="expensesAreLoaded" class="col-12 gap-3 px-3">
                        <div class="row my-1 text-start">
                            <div class="d-flex flex-row align-items-center justify-content-between mb-2 text-secondary fs-5 fw-light px-1" style="--bs-text-opacity: 0.6;">
                                <!-- Machine id -->
                                <div class="">
                                    {{ lang('Order Name') }}
                                </div>
                                <!-- amount -->
                                <div class="">
                                    {{ lang('Amount') }} ({{ userCurrencySymbolFromWhmcs }})
                                </div>
                            </div>
                        </div>
                        <!-- items -->
                        <div class="row bg-body-secondary border rounded-2 p-3 my-1 text-start"
                            v-for="expense, index in expenses" :key="index"
                            >
                            <div class="d-flex flex-row align-items-center justify-content-between">
                                <!-- Machine id -->
                                <div class="">
                                    ({{ expense?.id }}) - 
                                    {{ expense?.note }}
                                </div>
                                <!-- amount -->
                                <div class="">
                                    {{ formatExpenseAmount(expense?.amount) }}
                                </div>
                            </div>
                        </div>
                        <!-- end each item -->
                    </div>
                    <div v-else class="col-12">
                        <div class="d-flex flex-row justify-content-start align-items-center mt-4 text-primary">
                            <p class="h5 me-4 ps-2">{{ lang('loadingmsg') }}</p>
                            <span>
                                <?php include('./includes/baselayout/threespinner.php'); ?>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>