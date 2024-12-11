<!-- create order modal -->
<div class="modal fade modal-lg" id="failModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="failModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body m-0 p-0">
                <p class="bg-danger text-light h4 py-3 px-4 mt-5 rounded-end-5" style="width:200px">
                    <span>{{ lang('failed') }}</span>
                    <span class="px-1">!</span>
                </p>
                <div class="px-2 px-md-4 px-lg-5 mt-4 pt-4">
                    <p class="h5">
                        {{ lang('actiondidnotsucceed') }}
                    </p>
                </div>
                <div class="px-2 px-md-4 px-lg-5 mt-3 mb-5">
                    <p v-if="GlobalError != null" class="h6 text-danger">
                        <span>{{ lang('error') }}</span>
                        <span v-if="GlobalError == 1">
                            <span>1: </span>
                            <span>{{ lang('noaccessinvoice') }}</span>
                        </span>
                        <span v-if="GlobalError == 2">
                            <span>2: </span>
                            <span>{{ lang('noaccesscharge') }}</span>
                        </span>
                        <span v-if="GlobalError == 3">
                            <span>3: </span>
                            <span>{{ lang('noaccessapply') }}</span>
                        </span>
                    </p>
                </div>
                <div style="height:50px"></div>
                <div class="px-2 px-md-4 px-lg-5 mt-3 mb-5 text-end" v-if="ChargeMSG != null && ChargeMSG != ''">
                    <p class="alert alert-danger" style="direction:ltr">
                        Error 1360
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="reloadpage">
                    {{ lang('reload') }}
                </button>
            </div>
        </div>
    </div>
</div>