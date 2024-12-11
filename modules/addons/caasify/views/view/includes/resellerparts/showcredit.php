<!-- Credit -->
<div class="row">
    <div v-if="ResellerUserCredit != null" class="input-group">
        <span class="input-group-text" id="WhmcsCredit" style="max-width: 140px; min-width: 130px;">
            User Credit
        </span>
        <input type="text" class="form-control border-1 bg-primary" :value="ResellerUserCredit + ' ' + WhmcsUserInfo?.currency"
            style="max-width: 280px; min-width: 90px; --bs-bg-opacity: 0.06;" disabled>
    </div>
</div>