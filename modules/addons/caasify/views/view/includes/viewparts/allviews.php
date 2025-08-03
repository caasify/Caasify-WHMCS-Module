<!-- OrderViewfromOrder -->
<div class="row"> 
    <div class="col-12 m-0 p-0">
        <div v-if="ordeIsLoaded != true"
            class="d-flex flex-row justify-content-start align-items-center mt-5 text-primary">
            <p class="h5 me-4 ">
                {{ lang('Order is Loading') }}
            </p>
            <span>
                <?php include('./includes/baselayout/threespinner.php'); ?>
            </span>
        </div>
        <div v-if="ordeIsLoaded == true">
            <div v-if="thisOrder?.status == 'passive'">
                <p class="h4">
                    {{ lang('This Order has been deleted') }}
                </p>
            </div>
            <div v-else-if="thisOrder?.type == 'vps'">
                <?php include('./includes/viewparts/hostname.php');  ?>
                <?php include('./includes/viewparts/apiview.php');   ?>
                <?php include('./includes/viewparts/userview.php');  ?>
                <?php include('./includes/viewparts/access.php');  ?>
            </div>
            <div v-else-if="thisOrder?.type == 'vpn'">
                <?php include('./includes/viewparts/hostname.php');  ?>
                <?php include('./includes/viewparts/userview.php');  ?>
            </div>
            <div v-else-if="thisOrder?.type == 'host'">
                <?php include('./includes/viewparts/apiview.php');   ?>
                <?php include('./includes/viewparts/userview.php');  ?>
            </div>
        </div>
    </div>
</div>

<?php include('./includes/viewparts/failed.php');?>