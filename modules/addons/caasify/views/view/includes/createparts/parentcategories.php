<!-- Data Centers -->
<div class="row m-0 p-0 pb-5 px-4 px-md-2 px-lg-4">
    <div class="col-12 m-0 p-0" style="--bs-bg-opacity: 0.1;">
        <div class="row">
            <div class="col-12 mb-5">
                <span class="h3">
                    Select a Category
                </span>
            </div>
        </div> 
        <div class="row" style="direction: ltr;">
            <div v-for="Category in parentCategories" class="col-12 col-md-6 col-lg-4 m-0 p-0 mb-4">
                <div class="d-flex flex-row align-items-center shadow-lg mx-1 rounded-4 p-3" 
                style="--bs-bg-opacity: 0.5 !important; direction: ltr;"
                :style="isCategory(Category) ?  'cursor: pointer' : 'color: #a2a2a2'"
                :class="isCategory(Category) ? 'shadow-lg border border-2 border-secondary' : ''"
                @click="selectCategory(Category)">
                    <div class="m-0 p-0">
                        <i class="h1 p-4" :class="Category.icon"></i>                        
                    </div>
                    <div class="text-start ps-3 pt-2">
                        <p v-if="Category" class="h3 m-0 p-0">
                            {{ Category.name }}
                        </p>
                        <p class="fs-6 m-0 p-0">
                            <span v-if="!isCategory(Category)">
                                <i class="bi bi-lock pe-1 h5"></i>
                                <span>
                                    Comming soon ...
                                </span>
                            </span>
                            <span v-if="isCategory(Category)">
                                <span>
                                    4300 products
                                </span>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="RegionsPoint"></div>