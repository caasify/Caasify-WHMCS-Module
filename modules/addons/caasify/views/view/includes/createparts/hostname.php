<!-- Host Name -->
<div v-if="SelectedPlan != null" class="row m-0 p-0 py-5 px-4 mt-5"> 
    <div class="col-12 m-0 p-0" style="--bs-bg-opacity: 0.1;">
        <div class="m-0 p-0">
            <div class="m-0 p-0">
                <div class="m-0 p-0">
                    <p class="text-dark h3">
                        {{ lang('nameofhost') }}
                    </p>
                    <input v-model="themachinename" @input="validateInput" type="text" class="form-control py-3 bg-white fs-6 ps-4" style="--bs-bg-opacity: 0.5;" placeholder="Machine-1">
                </div>
                <p v-if="MachineNameValidationError" class="mt-4 w-50 small text-danger">{{ lang('onlyenglishletters') }}</p>
            </div>
            
        </div>
    </div> 
</div> 
<!-- End Name -->


