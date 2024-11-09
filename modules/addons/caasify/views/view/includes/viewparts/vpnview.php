<!-- right: vpn tutorial -->
<div v-if="thisOrder?.type == 'vpn'" class="col-12 col-md-6 p-0 m-0 mb-2 flex-grow-1 pe-xl-1">
    <div class="border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0 me-xl-1 pb-5 h-100">
        <div class="m-0 p-0">
            <?php include('./includes/viewparts/vpntutorails.php');   ?>
        </div>
    </div>
</div>
<!-- left part vpn -->
<div v-if="thisOrder?.type == 'vpn'" class="col-12 col-md-6 d-flex flex-column  p-0 m-0 mb-2 flex-grow-1">
    <div class="row m-0 p-0">
        <div class="col-12 m-0 p-0">
            <?php include('./includes/viewparts/vpnextrainfo.php');   ?>
        </div>
    </div>
</div> 