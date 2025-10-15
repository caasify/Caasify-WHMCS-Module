
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

<h5 class="mt-5 mb-3">List of Gifts</h5>

<div class="table table-responsive">

    <table class="table table-bordered table-striped">
        <thead>
            <th>Name</th>
            <th>Code</th>
            <th>Percent</th>
            <th>Total</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <tr v-for="gift in gifts">
                <td>{{ gift.name }}</td>
                <td>{{ gift.code }}</td>
                <td>{{ gift.percent }}</td>
                <td>{{ gift.total }}</td>
                <td>
                    <button v-if="isDeleting" class="btn btn-sm btn-danger" disabled>
                        Deleting
                    </button>

                    <button v-else class="btn btn-sm btn-danger" @click="deleteGift(gift.id)">
                        Delete
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<h5 class="mt-5 mb-3">Create Gift</h5>

<div class="card">
    <div class="card-body">

        <div v-if="giftFormError" class="alert alert-danger">
            {{ giftFormError }}
        </div>

        <form @submit.prevent="createGift">

            <div class="form-group mb-2">
                <label for="name">Name</label>
                <input type="text" class="form-control" v-model="giftForm.name" required>
            </div>

            <div class="form-group mb-2">
                <label for="code">Code</label>
                <input type="text" class="form-control" v-model="giftForm.code" required>
            </div>

            <div class="form-group mb-2">
                <label for="percent">Percent</label>
                <input type="number" class="form-control" v-model="giftForm.percent" required>
            </div>

            <div class="form-group mb-2">
                <label for="total">Total</label>
                <input type="number" class="form-control" v-model="giftForm.total" required>
            </div>

            <button v-if="isCreating" type="button" class="btn btn-primary" disabled>
                Creating
            </button>

            <button v-else type="submit" class="btn btn-primary">
                Create
            </button>
        </form>
    </div>
</div>


<h5 class="mt-5 mb-3">List of Invoices</h5>

<div class="table table-responsive">

    <table class="table table-bordered table-striped">

        <thead>
            <th>Invoice ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Amount</th>
            <th>Real Amount</th>
            <th>Ratio</th>
            <th>Commission</th>
            <th>Gift Percent</th>
            <th>Status</th>
        </thead>
        <tbody>
            <tr v-for="invoice in invoices">
                <td>
                    {{ invoice.invoice_id }}
                </td>
                <td>
                    {{ invoice.firstname }}
                </td>
                <td>
                    {{ invoice.lastname }}
                </td>
                <td>
                    {{ invoice.chargeamount }}
                </td>
                <td>
                    {{ invoice.real_charge_amount }}
                </td>
                <td>
                    {{ invoice.ratio }}
                </td>
                <td>
                    {{ invoice.commission }}
                </td>
                <td>
                    {{ invoice.gift_percent }}
                </td>
                <td>
                    <span v-if="isPaid(invoice)" class="badge bg-primary mx-1">
                        Paid
                    </span>

                    <span v-else class="badge bg-danger mx-1">
                        Unpaid
                    </span>

                    <span v-if="isCompleted(invoice)" class="badge bg-success mx-1">
                        Charged
                    </span>

                    <span v-else class="badge bg-danger mx-1">
                        Not Charged
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</div>

</div>


<script src="./assets/js/bootstrap.bundle.min.js"></script> 
<script src="./assets/js/vue.global.prod.js"></script>
<script src="./assets/js/lodash.min.js"></script> 
<script src="./assets/js/axios.min.js"></script>
<script src="./assets/js/app.js?v=1"></script>