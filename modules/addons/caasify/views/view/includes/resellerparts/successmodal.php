<!-- create order modal -->
<div class="modal fade modal-lg" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body m-0 p-0">
                <p class="bg-primary text-light h4 py-3 px-4 mt-5 rounded-end-5" style="width:200px">
                    <span>{{ lang('successful') }}</span>
                    <span class="px-1">!</span>
                </p>
                <div class="px-5 mt-4 pt-4 mb-5">
                    <p class="h5">
                        {{ lang('chargingdonesuccessfully') }}
                    </p>
                    <p class="alert alert-primary py-2 mt-5">
                        {{ lang('taketimetoseeresult') }}
                    </p>
                </div>
                <div style="height:100px">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="reloadpage">{{ lang('reload') }}</button>
            </div>
        </div>
    </div>
</div>