<!-- Host Name -->
<div v-if="SelectedPlan != null" class="row"> 
    <div class="col-12">
        <div class="d-flex flex-row align-items-center justify-content-start">
            <p class="text-dark p-0 m-0 pe-2 fw-medium" style="text-wrap: nowrap; min-width: 100px;">
                {{ lang('nameofhost') }}
            </p>
            <input v-model="themachinename" @input="validateInput" type="text" class="form-control py-2 bg-white fs-6 ps-4" style="--bs-bg-opacity: 0.5; width:160px;" placeholder="Machine-1">
        </div>
    </div>
    <p v-if="MachineNameValidationError" class="mt-4 w-50 small text-danger">{{ lang('onlyenglishletters') }}</p>
</div> 
<!-- End Name -->


