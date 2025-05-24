
<link href="./assets/css/bootstrap.min.css" rel="stylesheet">

<div id="app">

<p>
Caasify is an unique solution for Data Centers and Hosting companies to meet in unified hosting marketplace.
</p>

<div class="d-flex gap-3">

<a href="https://github.com/caasify/Caasify-WHMCS-Module" target="blank" class="btn btn-primary">
    Github
</a>

<a href="https://caasify.com/docs/" target="blank" class="btn btn-primary">
    Documentation
</a>

</div>

<div class="card bg-secondary mt-3">
    <div class="card-body text-center">
        <h5 class="card-title mb-3">Latest Version</h5>
        <h3>{{ latestVersion }}</h3>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body text-center">

        <h5 class="card-title mb-3">Current Version</h5>
        <h3 class="mb-4">{{ localVersion }}</h3>

        <div class="d-flex justify-content-center gap-3">

            <button v-if="isUpdating" type="button" class="btn btn-primary disabled">
                Updating
            </button>
            <button v-else type="button" @click="updateModule" class="btn btn-primary">
                Update
            </button>

            <button v-if="isUpdatingPermission" type="button" class="btn btn-secondary disabled">
                Updating
            </button>
            <button v-else type="button" @click="updatePermission" class="btn btn-secondary">
                Update Permissions
            </button>
        </div>
    </div>
</div>

</div>

</div>


<script src="./assets/js/bootstrap.bundle.min.js"></script> 
<script src="./assets/js/vue.global.prod.js"></script>
<script src="./assets/js/lodash.min.js"></script> 
<script src="./assets/js/axios.min.js"></script>
<script src="./assets/js/app.js"></script>