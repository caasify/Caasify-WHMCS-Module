<!-- modalDemo -->
<div class="modal fade" id="DemotModalCreateSuccess" tabindex="-1" aria-labelledby="DemotModalCreateSuccessLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top" style="max-width: 550px; padding-top: 250px">  
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="h5 text-dark p-0 m-0">DEMO Mode Alert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column justify-content-between align-items-center">
                    <div class="">
                        <p class="h4 p-0 m-0 text-dark lh-lg text-center my-5">
                            {{ lang('CreateDemoText') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex flex-column justify-content-end align-items-center">
                    <div class="m-0 p-0 mx-2">
                        <button type="button" class="btn btn-secondary px-4 border-0" data-bs-dismiss="modal">
                            {{ lang('close') }}
                        </button>
                        <button class="btn btn-primary px-4 ms-2 border-0" data-bs-dismiss="modal" @click="openIndexPage">
                            {{ lang('Go to index Page') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end modal -->

