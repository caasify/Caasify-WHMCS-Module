<!-- for Three action (start, stop, reboot) -->
<div class="modal fade" id="actionsModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">  
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="actionModalLabel">
                    {{ lang('Confirmation') }}
                </h1>
            </div>

            <!-- Product MODE -->
            
            <div class="modal-body py-5" v-if="actionWouldBeHappened != null">
                <p class="mb-5 py-5 fs-5 fw-light">
                    <span>
                        {{ lang('You are going to') }}
                    </span>
                    <span v-if="actionWouldBeHappened != null">
                        {{ lang(actionWouldBeHappened.toUpperCase()) }}
                    </span>
                    <span>
                        {{ lang('your machine, are you sure ?') }}
                    </span>

                    <?php if(isset($DemoMode) && $DemoMode == 'on' ): ?>
                        <p class="alert alert-danger" v-if="actionWouldBeHappened.toLowerCase() == 'delete'">
                            {{ lang('DeleteIsNotAllowed') }}
                        </p>
                    <?php endif ?>
                </p>
            </div>
            <div class="m-0 p-0">
                <div class="d-flex flex-row modal-footer justify-content-end">
                    <div class="m-0 p-0 mx-2">
                        <button @click="closeConfirmDialog" type="button" class="btn btn-secondary px-4 mx-2 border-0" data-bs-dismiss="modal">
                            {{ lang('close') }}
                        </button>
                    </div>
                    <!-- DemoMode -->
                    <?php if(isset($DemoMode) && $DemoMode == 'on' ): ?>
                        <!-- others -->
                        <div v-if="actionWouldBeHappened && actionWouldBeHappened.toLowerCase() != 'delete'" class="m-0 p-0">
                            <button @click="acceptConfirmDialog" type="button" class="btn btn-primary px-4 mx-2 border-0" data-bs-dismiss="modal">
                                <span v-if="actionWouldBeHappened != null">
                                    {{ lang(actionWouldBeHappened.toUpperCase()) }}
                                </span>
                            </button>
                        </div>
                        <!-- DELETE Exception -->
                        <div v-if="actionWouldBeHappened && actionWouldBeHappened.toLowerCase() == 'delete'" class="m-0 p-0">
                            <button type="button" class="btn btn-primary px-4 mx-2 border-0" data-bs-dismiss="modal" disabled>
                                <span v-if="actionWouldBeHappened != null">
                                    {{ lang(actionWouldBeHappened.toUpperCase()) }}
                                </span>
                            </button>
                        </div>
                    <?php else: ?>
                        <!-- ProMode -->
                        <div v-if="actionWouldBeHappened" class="m-0 p-0">
                            <button @click="acceptConfirmDialog" type="button" class="btn btn-primary px-4 mx-2 border-0" data-bs-dismiss="modal">
                                <span v-if="actionWouldBeHappened != null">
                                    {{ lang(actionWouldBeHappened.toUpperCase()) }}
                                </span>
                            </button>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div><!-- end modal -->



<!-- Simple alert Pop Up -->
<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 300px;">  
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex flex-column justify-content-between align-items-center">
                    <div class="">
                        <p class="h5 p-0 m-0 pb-5 pt-3">
                            {{ lang('Something is in queue !') }}
                        </p>
                    </div>
                    <div class="m-0 p-0 mx-2">
                        <button type="button" class="btn btn-secondary px-4 mx-2 border-0" data-bs-dismiss="modal" @click="showAlertModal = false">
                            {{ lang('close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end modal -->

