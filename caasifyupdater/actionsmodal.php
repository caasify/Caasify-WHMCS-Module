<div class="modal fade" id="actionsmodal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">  
        <div class="modal-content text-dark">
            <div class="modal-header">
                <p class="modal-title h6" id="actionModalLabel">Confirmation</p>
            </div>

            <div class="modal-body py-5">
                <p class="mb-5 fw-light">
                    You are going to 
                    <span class="fw-medium">
                        {{ actionWouldBeHappened }}
                    </span>
                     Caasify Module, are you sure ?
                </p>
            </div>
            
            <div class="m-0 p-0">
                <div class="d-flex flex-row modal-footer justify-content-end">
                    <div class="m-0 p-0 mx-2">
                        <button @click="closeConfirmDialog" type="button" class="btn btn-secondary px-4 mx-2 border-0 btn-sm" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                    <div v-if="actionWouldBeHappened" class="m-0 p-0">
                        <button @click="acceptConfirmDialog" type="button" class="btn btn-info px-4 mx-2 border-0 btn-sm" data-bs-dismiss="modal">
                            {{ actionWouldBeHappened }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end modal -->






