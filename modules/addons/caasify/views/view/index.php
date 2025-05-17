<?php

$files = ['./config.php', './includes/baselayout/candy_header.php'];

foreach ($files as $file) {

    require_once($file);
}

?>

<div id="app">

<!-- Loading -->
<div v-if="CurrenciesRatioCloudToWhmcs == null" class="container py-4">

    <div class="d-flex justify-content-center">
    
        <?php
            require_once('./includes/baselayout/threespinner.php');
        ?>

    </div>
</div>

<!-- Order -->
<div v-else class="p-4">

<!-- Header -->
<div class="mt-3 mb-4">

<?php

$files = ['./includes/baselayout/balancealertmodal.php', './includes/indexparts/modalreseller.php', './includes/indexparts/headtitle.php'];

foreach ($files as $file) {

    require_once($file);
}

?>
</div>


<!-- Stats -->
<div class="row g-4 mb-4">

<!-- Balance -->
<div class="col-md-3">
    <div class="card text-center py-4">
        <div class="card-body">
            <h2 class="text-primary mb-5">
                {{ formatUserBalance(user?.available_balance) }} <span class="fs-5 text-secondary">{{ userCurrencySymbolFromWhmcs }}</span>
            </h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#chargeModal">
                <i class="bi bi-wallet2 me-1"></i> TopUp
            </button>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card text-center py-5">
        <div class="card-body">
            <h2 class="text-primary">
                {{ WhmcsUserInfo?.tickets }}
            </h2>
            <p class="fs-5 text-muted mb-0">
                {{ lang('Tickets') }}
            </p>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card text-center py-5">
        <div class="card-body">
            <h2 class="text-primary">
                {{ totalOrders }}
            </h2>
            <p class="fs-5 text-muted mb-0">
                {{ lang('Orders') }}
            </p>
        </div>
    </div>
</div>
  
<div class="col-md-3">
    <div class="card text-center py-5">
        <div class="card-body">
            <h2 class="text-primary">
                {{ formatUserBalance(totalExpense) }}
            </h2>
            <p class="fs-5 text-muted mb-0">
                {{ lang('Total Spend') }}
            </p>
        </div>
    </div>
</div>

</div>

<!-- Active Orders -->
<div v-if="isEmpty(activeorders)" class="card mb-4">
    <div class="card-header bg-white fw-semibold p-3 d-flex justify-content-between align-items-center">
        <span>{{ lang('Your Active Orders') }}</span>
        <button @click="openCreatePage" class="btn btn-sm btn-primary ms-auto">Create order</button>
    </div>
    <div class="card-body text-center">
        <img src="./includes/assets/img/default.jpg" width="64" class="mb-3">
        <p class="text-muted mb-3">
            {{ lang('No Active Orders Found') }}
        </p>
        <button type="button" @click="openCreatePage" class="btn btn-light text-primary text-decoration-none fw-semibold">
            {{ lang('Place New Order') }}
        </button>
    </div>
</div>

<div v-else class="card mb-4">
    <div class="card-header bg-white fw-semibold p-3 d-flex justify-content-between align-items-center">
        <span>{{ lang('Your Active Orders') }}</span>
        <button @click="openCreatePage" class="btn btn-sm btn-primary ms-auto">Create order</button>
    </div>
    <div class="card-body text-center p-0">
        <div class="table-responsive">
            <table class="table align-middle m-0">
                <thead>
                    <tr>
                        <th class="text-secondary">
                            {{ lang('ID') }}
                        </th>
                        <th class="text-secondary">
                            {{ lang('Name') }}
                        </th>
                        <th class="text-secondary">
                            {{ lang('Alive') }}
                        </th>
                        <th class="text-secondary">
                            {{ lang('Price') }}
                        </th>
                        <th class="text-secondary">
                            {{ lang('Type') }}
                        </th>
                        <th class="text-secondary">
                            {{ lang('View') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in activeorders">
                        <td>{{ order.id }}</td>
                        <td>{{ order.note }}</td>
                        <td>{{ order.created_at }}</td>
                        <td>
                            <span v-for="record in order.records">
                                {{ formatPlanPrice(record.price) }} {{ userCurrencySymbolFromWhmcs }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm text-capitalize" :class="orderTypeClass(order.type)">
                                {{ order.type }}
                            </button>
                        </td>
                        <td>
                            <button @click="open(order)" class="btn btn-sm text-capitalize" :class="orderTypeClass(order.type)">
                                {{ lang('View') }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bottom -->
<div class="row g-4">

<!-- Tickets -->
<div v-if="isEmpty(WhmcsUserTickets)" class="col-md-6">
    <div class="card text-center shadow-sm">
        <div class="card-header bg-white fw-semibold p-3">
            {{ lang('Recent Support Tickets') }}
        </div>
        <div class="card-body">
            <img src="./includes/assets/img/default.jpg" width="64" class="mb-3">
            <p class="text-muted mb-3">
                {{ lang('No Tickets Found') }}
            </p>
            <button type="button" @click="openTicketPage" class="btn btn-light text-primary text-decoration-none fw-semibold">
                {{ lang('Open Ticket') }}
            </button>
        </div>
    </div>
</div>

<div v-else class="col-md-6">
    <div class="card text-center shadow-sm">
        <div class="card-header bg-white fw-semibold p-3">
            {{ lang('Recent Support Tickets') }}
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                        <tr>
                            <th class="text-secondary">
                                {{ lang('ID') }}
                            </th>
                            <th class="text-secondary">
                                {{ lang('Subject') }}
                            </th>
                            <th class="text-secondary">
                                {{ lang('Priority') }}
                            </th>
                            <th class="text-secondary">
                                {{ lang('Status') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="ticket in WhmcsUserTickets">
                            <td>{{ ticket.id }}</td>
                            <td class="truncate">
                                {{ ticket.subject }}
                            </td>
                            <td>
                                <span v-if="valueIs('Low', ticket.priority)" class="badge bg-primary">
                                    {{ lang('Low') }}
                                </span>

                                <span v-if="valueIs('Medium', ticket.priority)" class="badge bg-warning">
                                    {{ lang('Medium') }}
                                </span>

                                <span v-if="valueIs('High', ticket.priority)" class="badge bg-danger">
                                    {{ lang('High') }}
                                </span>
                            </td>
                            <td>
                                <span v-if="valueIs('Open', ticket.status)" class="badge bg-primary">
                                    {{ lang('Open') }}
                                </span>

                                <span v-if="valueIs('Answered', ticket.status)" class="badge bg-info">
                                    {{ lang('Answered') }}
                                </span>

                                <span v-if="valueIs('Customer-Reply', ticket.status)" class="badge bg-warning">
                                    {{ lang('Customer Reply') }}
                                </span>

                                <span v-if="valueIs('On Hold', ticket.status)" class="badge bg-secondary">
                                    {{ lang('On Hold') }}
                                </span>

                                <span v-if="valueIs('In Progress', ticket.status)" class="badge bg-success">
                                    {{ lang('In Progress') }}
                                </span>

                                <span v-if="valueIs('Closed', ticket.status)" class="badge bg-dark">
                                    {{ lang('Closed') }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Domain -->
<div class="col-md-6">
    <div class="card bg-primary text-white">
        <div class="card-body">
            <h6 class="fw-semibold mb-3">
                {{ lang('Register Domain') }}
            </h6>
            <input type="text" class="form-control mb-3 p-2" placeholder="Find your new domain name">
            <div class="d-flex justify-content-between gap-3">
                <button class="w-100 p-3 btn btn-light text-primary fw-semibold">
                    {{ lang('Transfer Domain') }}
                </button>
                <button class="w-100 p-3 btn btn-light text-primary fw-semibold">
                    {{ lang('Register Domain') }}
                </button>
            </div>
        </div>
    </div>
</div>

</div>

</div>
</div>
<style>
.table th,
.table td{
    white-space: nowrap;
}

.card{
    border: none;
    box-shadow: 0 0 15px #ddd;
}

.truncate{
    max-width: 60px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<?php 
$files = ['includes/baselayout/footer.php'];

foreach ($files as $file) {

    require_once($file);
}

?>