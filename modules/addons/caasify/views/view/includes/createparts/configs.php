<!-- Operation System -->
<div v-if="PlanSections != null" class="row text-dark mt-2">
    <div v-for="PlanSection in PlanSections" class="d-flex flex-column justify-content-start align-items-start flex-wrap"
        style="--bs-bg-opacity: 0.1;">
        <div v-if="PlanSection?.fields != null" v-for="(field, index) in PlanSection?.fields" class="m-0 p-0 py-1">
            <div class="d-flex flex-row justify-content-start align-items-center flex-wrap">
                <div class="m-0 p-0" style="min-width: 100px;">
                    <p class="text-dark fw-medium p-0 m-0 pe-2">
                        {{ lang(field?.label) }}
                    </p>
                </div>
                <!-- Type: DropDown -->
                <div v-if="field.type == 'dropdown'" class="d-flex flex-row justify-content-start align-items-start">
                    <div style="min-width:160px">
                        <select :name="field.name" class="form-select py-2" :aria-label="field.name" :key="index"
                            v-model="PlanConfigSelectedOptions[field.name]">
                            <option value="field.options[0]" selected disabled>
                                {{ lang('Please select') }}
                            </option>
                            <option v-for="option in field.options" :value="option">
                                {{ lang(option.name) }}
                            </option>
                        </select>
                    </div>
                    <div v-if="PlanConfigSelectedOptions[field.name]?.price > 0" class="text-secondary small pt-3 ps-2">
                        {{ formatConfigPrice(PlanConfigSelectedOptions[field.name].price) }} {{ userCurrencySymbolFromWhmcs }}
                    </div>
                </div>


                <!-- Type: Text -->
                <div v-if="field.type == 'text'" class="row m-0 p-0">
                    <div class="col-12 m-0 p-0 px-lg-4" style="--bs-bg-opacity: 0.1;">
                        <div class="m-0 p-0">
                            <div class="m-0 p-0">
                                <div class="m-0 p-0" style="min-width: 250px;">
                                    <p class="text-dark h3 m-0 p-0">
                                        {{ PlanConfigSelectedOptions[field.label] }}
                                    </p>
                                    <input v-model="PlanConfigSelectedOptions[field.name].options"
                                        @input="validateInput" type="text" class="form-control bg-white fs-6 py-2"
                                        style="--bs-bg-opacity: 0.5;" placeholder="Public key">
                                </div>
                                <p v-if="SshNameValidationError" class="mt-4 w-50 small text-danger">not valid</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- End Operation System -->