<!-- set config here -->
<?php 
    include('./config.php');    
?>


<?php include('./includes/vpspricing/vpsheader.php'); ?>

<!-- Modal -->
<div class="modal fade" id="Register" tabindex="-1" aria-labelledby="RegisterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width:450px">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row text-center px-3 py-4 fs-6">
                    <p class="m-0 p-0 h5">
                        <span>
                            {{ lang('To continue, please log in') }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="modal-footer d-flex flex-row align-items-center justify-content-center">
                <a class="btn btn-primary px-4" href="<?php echo($systemUrl); ?>/register.php" target="_blanck">
                    {{ lang('Register') }}
                </a>
                <a class="btn btn-primary px-4" href="<?php echo($systemUrl); ?>/index.php?rp=/login" target="_blanck">
                    {{ lang('Log in') }}
                </a>
            </div>
        </div>
    </div>
</div>



<main class="container-fluid text-center" style="max-width:1400px">
    <div id="" class="row px-1 px-md-2 py-2 mx-auto" style="max-width: 1200px;">
        <div class="p-0 m-0" :class="{ loading: CreateIsLoading }" v-cloak>
            <div class="col-12 bg-white rounded-4 m-0 p-0 mt-5" style="min-height: 1800px">
                <!-- lang BTN     -->
                <div class="row">
                    <div class="col-12">
                        <div class="py-3 px-">
                            <div class="d-flex flex-row justify-content-between align-items-center">
                                <div class="">
                                    <span class="h5">
                                        {{ lang('Select a Category')}}
                                    </span>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <!-- parent categories -->
                <div class="row m-0 p-0">
                    <div class="col-12 px-2 px-md-2">
                        <!-- Data Centers -->
                        <div class="row">
                            <div v-for="Category in parentCategories" class="col-12 col-md-6 col-lg-3 m-0 p-0 mb-2">
                                <div class="d-flex flex-row align-items-center border border-2 mx-1 rounded-4 p-3" 
                                style="--bs-bg-opacity: 0.5 !important;"
                                :style="isCategory(Category) ?  'cursor: pointer' : 'color: #a2a2a2'"
                                :class="isCategory(Category) ? 'shadow-sm border border-2 border-secondary' : ''"
                                @click="selectCategory(Category)">
                                    <div class="m-0 p-0">
                                        <img :src="Category.icon" class="img-fluid rounded-top" :alt="Category.name" style="width:40px;">
                                    </div>
                                    <div class="text-start ps-3 pt-2" :style="Category.enabled ? 'color:#383636' : '' ">
                                        <p v-if="Category" class="h6 m-0 p-0">
                                            {{ lang(Category.name) }}
                                        </p>
                                        <p class="fs-6 m-0 p-0">
                                            <i v-if="!Category.enabled" class="bi bi-lock pe-1"></i>
                                            <span>
                                                {{ lang(Category.msg) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- filters -->
                <div class="row m-0 p-0">
                    <div class="col-12 col-md-3 px-2 px-md-0 py-1 pe-md-1 d-none d-md-block">
                        <div class="rounded-4 px-0 px-md-2 pt-4 bg-primary" style="min-height: 330px; --bs-bg-opacity: 0.06;">
                            <?php  include('./includes/vpspricing/filterterms.php');   ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 px-0 px-md-0 py-1 ps-md-1">
                        <div class="rounded-4 px-0 px-md-2 py-4" style="min-height: 330px;">
                            <?php  include('./includes/vpspricing/plans.php');         ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php include('./includes/vpspricing/vpsfooter.php'); ?>
