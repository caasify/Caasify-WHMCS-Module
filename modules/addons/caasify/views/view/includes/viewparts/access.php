<div class="d-none row d-flex flex-row align-items-stretch text-start m-0 p-0">
    <!-- OrderDetails -->
    <div class="col-12 col-xl-6 p-0 m-0 mb-2 flex-grow-1">
        <div class="border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0 pb-5 h-100">
            <div class="m-0 p-0">

                <!--  BTN's -->
                <div class="row text-start m-0 p-0 mt-4">
                    <ul class="nav nav-tabs " id="myTab" role="tablist">

                        <!-- Graphs -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark active" id="graphs-tab" data-bs-toggle="tab"
                                data-bs-target="#graphs-tab-pane" type="button" role="tab"
                                aria-controls="graphs-tab-pane" aria-selected="false">{{ lang('Graphs') }}</button>
                        </li>

                        <!-- Change OS  -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="changeos-tab" data-bs-toggle="tab"
                                data-bs-target="#changeos-tab-pane" type="button" role="tab"
                                aria-controls="changeos-tab-pane" aria-selected="true">{{ lang('changeos') }}</button>
                        </li>


                        <!-- Network -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="network-tab" data-bs-toggle="tab"
                                data-bs-target="#network-tab-pane" type="button" role="tab"
                                aria-controls="network-tab-pane" aria-selected="false">{{ lang('network') }}</button>
                        </li>


                        <!-- Backup -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="BackUp-tab" data-bs-toggle="tab"
                                data-bs-target="#BackUp-tab-pane" type="button" role="tab"
                                aria-controls="BackUp-tab-pane" aria-selected="false">{{ lang('BackUp') }}</button>
                        </li>


                        <!-- Snapshot -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="Snapshot-tab" data-bs-toggle="tab"
                                data-bs-target="#Snapshot-tab-pane" type="button" role="tab"
                                aria-controls="Snapshot-tab-pane" aria-selected="false">{{ lang('Snapshot') }}</button>
                        </li>

                        <!-- Volume -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="Volume-tab" data-bs-toggle="tab"
                                data-bs-target="#Volume-tab-pane" type="button" role="tab"
                                aria-controls="Volume-tab-pane" aria-selected="false">{{ lang('Volume') }}</button>
                        </li>

                        <!-- Resize -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="Resize-tab" data-bs-toggle="tab"
                                data-bs-target="#Resize-tab-pane" type="button" role="tab"
                                aria-controls="Resize-tab-pane" aria-selected="false">{{ lang('Resize') }}</button>
                        </li>
                        
                        <!-- Setting -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="Setting-tab" data-bs-toggle="tab"
                                data-bs-target="#Setting-tab-pane" type="button" role="tab"
                                aria-controls="Setting-tab-pane" aria-selected="false">{{ lang('Setting') }}</button>
                        </li>

                        <!-- History -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="History-tab" data-bs-toggle="tab"
                                data-bs-target="#History-tab-pane" type="button" role="tab"
                                aria-controls="History-tab-pane" aria-selected="false">{{ lang('History') }}</button>
                        </li>
                    </ul>
                </div>

                <!-- graphs -->
                <div class="row tab-content justify-content-center m-0 p-0 pt-3 px-0" style="min-height: 450px;"
                    id="myTabContent">

                    <!-- graphs -->
                    <div class="col-12 m-0 p-0 px-2 px-md-0 tab-pane active show" id="graphs-tab-pane"
                        role="tabpanel" aria-labelledby="graphs-tab" tabindex="0">
                        <?php include('./includes/viewparts/accessparts/graphs.php'); ?>
                    </div>

                    <!-- Change OS -->
                    <div class="col-12 m-0 p-0 px-2 px-md-0 tab-pane fade" id="changeos-tab-pane"
                        role="tabpanel" aria-labelledby="changeos-tab" tabindex="0">
                        <?php include('./includes/viewparts/accessparts/changeos.php'); ?>
                    </div>


                    <!-- Network -->
                    <div class="col-12 m-0 p-0 px-3 px-md-0 tab-pane fade" id="network-tab-pane" role="tabpanel"
                        aria-labelledby="network-tab" tabindex="0">
                        <?php include('./includes/viewparts/accessparts/network.php'); ?>
                    </div>

                    <!-- BackUp -->
                    <div class="col-12 m-0 p-0 px-3 px-md-0 tab-pane fade" id="BackUp-tab-pane" role="tabpanel"
                        aria-labelledby="BackUp-tab" tabindex="0">
                        <?php include('./includes/viewparts/accessparts/backup.php'); ?>
                    </div>
                    
                    <!-- Snapshot -->
                    <div class="col-12 m-0 p-0 px-3 px-md-0 tab-pane fade" id="Snapshot-tab-pane" role="tabpanel"
                        aria-labelledby="Snapshot-tab" tabindex="0">
                        <?php include('./includes/viewparts/accessparts/snapshot.php'); ?>
                    </div>
                    
                    <!-- Volume -->
                    <div class="col-12 m-0 p-0 px-3 px-md-0 tab-pane fade" id="Volume-tab-pane" role="tabpanel"
                        aria-labelledby="Volume-tab" tabindex="0">
                        <?php include('./includes/viewparts/accessparts/volume.php'); ?>
                    </div>
                   
                    <!-- Resize -->
                    <div class="col-12 m-0 p-0 px-3 px-md-0 tab-pane fade" id="Resize-tab-pane" role="tabpanel"
                        aria-labelledby="Resize-tab" tabindex="0">
                        <?php include('./includes/viewparts/accessparts/resize.php'); ?>
                    </div>
                    
                    <!-- Setting -->
                    <div class="col-12 m-0 p-0 px-3 px-md-0 tab-pane fade" id="Setting-tab-pane" role="tabpanel"
                        aria-labelledby="Setting-tab" tabindex="0">
                        <?php include('./includes/viewparts/accessparts/setting.php'); ?>
                    </div>
                    
                    <!-- History -->
                    <div class="col-12 m-0 p-0 px-3 px-md-0 tab-pane fade" id="History-tab-pane" role="tabpanel"
                        aria-labelledby="History-tab" tabindex="0">
                        <?php include('./includes/viewparts/accessparts/history.php'); ?>
                    </div>

                </div>
            </div>
        </div>        
    </div>
</div>