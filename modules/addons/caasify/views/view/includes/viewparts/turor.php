<div>
    <p class="fw-medium pt-3 pb-2 mb-0">Using Subscription Link</p>
    <ol>
        <li class="py-2">Copy Subscription Link form this page bellow the qrCode <span @click="copyVpnCode(thisVpnOrder?.subscription)" class="btn btn-sm btn-primary ms-2"> Copy </span> </li>
        
        <li class="py-2">Open Hiddify and Look for an option like "Add Subscription", "Import from URL", or similar.</li>
        <li class="py-2">Paste the subscription URL into the provided field</li>
        <li class="py-2">Select and connect</li>
    </ol>
</div>
<div>
    <p class="fw-medium pt-3 pb-2 mb-0">Using QR Code</p>
    <ol>
        <li class="py-2">In Hiddify, Look for an option like "Import from QR Code" or "Scan QR Code."</li>
        <li class="py-2">Scan the QR code using your camera</li>
        <li class="py-2">Select and  connect</li>
    </ol>
</div>