<!-- OrderViewFromAPI -->
<div v-if="thisOrder" class="row m-0 p-0 px-2">
    <div v-if="viewsAreLoaded" class="m-0 p-0">
        <div v-if="NoValidViewItems != true" class="col-12 m-0 p-0">
            <div v-for="(item, index) in ValidViewItems"
                class="row d-flex flex-row align-items-center justify-content-center" v-html="item.content"
                :key="index">
            </div>
        </div>
        <div v-if="!Is40SecondPassed(thisOrder?.created_at) && ValidViewItems == null" class="alert alert-primary">
            <span>
                {{ lang('Views Are Loading') }}
            </span>
            <?php  include('./includes/baselayout/threespinner.php');      ?>
        </div>
    </div>
</div>
