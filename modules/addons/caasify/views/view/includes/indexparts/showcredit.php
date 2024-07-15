<!-- Credit -->                        
<span class="d-flex flex-row align-items-center justify-content-center">
    <span class="text-dark fw-medium">
        <span>{{ lang('accountcredit') }}</span>
        <span class="px-1">:</span>
    </span>
    
    <!-- Dollar -->    
    <span v-if="userCreditinWhmcs" class="text-primary fw-medium ps-2">
        <span class="px-1">
            {{ showCreditWhmcsUnit(userCreditinWhmcs) }}
        </span>
        <span v-if="userCurrencySymbolFromWhmcs">
            {{userCurrencySymbolFromWhmcs}}
        </span>
    </span>    
    
    <span v-else class="text-primary fw-medium ps-2">
        --- 
    </span>
</span> 
