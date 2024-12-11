<div class="row">
    <div v-if="ResellerUserBalance != null" class="input-group">
        <span class="input-group-text" id="CaasifyBalance" style="max-width: 140px; min-width: 130px;">
            Reseller Balance
        </span>
        <input type="text" class="form-control border-1 bg-primary" :value="ResellerUserBalance + ' €'"
            style="max-width: 280px; min-width: 90px; --bs-bg-opacity: 0.06;" disabled>
    </div>
</div>