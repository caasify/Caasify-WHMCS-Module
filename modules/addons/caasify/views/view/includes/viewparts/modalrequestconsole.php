<!-- for Three action (start, stop, reboot) -->
<div class="modal fade" id="RequestConsoleModal" tabindex="-1" aria-labelledby="RequestConsoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">  
        <div class="modal-content">
            <div class="modal-header" v-if="!ConsoleLinkIsValid">
                <h1 class="modal-title fs-5" id="actionModalLabel">
                    {{ lang('Reguest Console Link') }}
                </h1>
            </div>

            <!-- Product MODE -->
            <div class="modal-body py-5" v-if="actionWouldBeHappened != null">
                <!-- before request and have no data -->
                <div v-if="!ConsoleLinkIsValid && !WaitForConsoleRoute">
                    <div class="h5">
                        <p>
                            {{ lang('requestgetlink') }} 
                        </p>
                        <p>
                            {{ lang('confirmtext') }}
                        </p>
                    </div>
                </div>
                
                <!-- requested and wait for result -->
                <div class="h5" v-if="WaitForConsoleRoute">
                    <p>
                        <span>
                            {{ lang('Console Is Running') }}
                        </span>
                        <span>
                            <?php include('./includes/baselayout/threespinner.php'); ?>
                        </span>
                    </p>
                    <p>
                        {{ lang('waittofetch') }}
                    </p>
                </div>

                <!-- Get successfully resul and have time of 60 second -->
                <div class="fs-5 fw-light text-center" v-if="ConsoleLinkIsValid && !WaitForConsoleRoute">
                    <p>
                        {{ lang('accessconsole') }}
                    </p>
                    <div class="col-12 text-end py-4 px-5">
                        <button class="col-12 btn btn-primary me-4" @click="OpenConsoleUrl">
                            {{ lang('openconsole') }}
                        </button>
                    </div>
                    <p v-if="ConsoleTimer != null && ConsoleTimer > 0">
                        <span>
                            {{ lang('Link is Valid for') }}
                        </span>
                        <span class="px-1">
                            {{ ConsoleTimer }}
                        </span>
                         <span>
                            {{ lang('seconds') }}
                         </span>
                    </p>
                </div>
            </div>
            <div class="m-0 p-0">
                <div class="d-flex flex-row modal-footer justify-content-end">
                    <div class="m-0 p-0">
                        <button type="button" class="btn btn-secondary px-4 mx-2 border-0" data-bs-dismiss="modal">
                            {{ lang('close') }}
                        </button>
                    </div>
                        <!-- DemoMode -->
                    <?php if(isset($DemoMode) && $DemoMode == 'on' ): ?>
                        <!-- others -->
                        <div class="m-0 p-0">
                            <button type="button" class="btn btn-primary px-4 border-0" disabled>
                                <span v-if="actionWouldBeHappened != null">
                                    {{ lang(actionWouldBeHappened.toUpperCase()) }}
                                </span>
                            </button>
                        </div>
                    <?php else: ?>
                        <!-- ProMode -->
                        <div v-if="actionWouldBeHappened" class="m-0 p-0">
                            <button @click="PushButtonConsole" type="button" class="btn btn-primary px-4 border-0" :disabled="WaitForConsoleRoute">
                                <span v-if="actionWouldBeHappened != null && !ConsoleLinkIsValid">
                                    {{ lang('consoleaction') }}
                                </span>
                                <span v-if="actionWouldBeHappened != null && ConsoleLinkIsValid">
                                    {{ lang('tryagain') }}
                                </span>
                                <span v-if="WaitForConsoleRoute" class="ps-2">
                                    <div class="spinner-border spinner-border-sm" role="status"></div>
                                </span>
                            </button>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div><!-- end modal -->
