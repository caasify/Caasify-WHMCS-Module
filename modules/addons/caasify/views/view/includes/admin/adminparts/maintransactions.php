<?php 

    $tablePart01 = '
        <div class="mt-3">
            <div class="col-12 alert alert-primary me-3 h6 py-2 my-5">
                <p class="m-0 p-0">
                    <span>
                        Caasify Transactions (latest 100)
                    </span>
                    <a class="btn btn-secondary ms-4" href="' . $SystemUrl . '/' . $adminPath . '/systemactivitylog.php?description=E243">
                        see transactions logs
                    </a>
                </p>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Invoice (id)</th>
                    <th scope="col">User (id)</th>
                    <th scope="col">Real Charge Amount (€)</th>
                    <th scope="col">Invoice Amount</th>
                    <th scope="col">Ratio</th>
                    <th scope="col">Caasify Invoice ID</th>
                </tr>
            </thead>
            <tbody>
    ';


    $tablePart02 = ''; // Initialize the variable to hold all the rows
    $CaasidyInvoices = cassify_get_all_invoice_table();
    $SystemUrl = caasify_get_systemUrl();
    $url = $configs['AdminClientsSummaryLink'];
    preg_match("/^https?:\/\/[^\/]+\/(.*)\/clientssummary\.php$/", $url, $matches);
    if (isset($matches[1])) {
        $adminPath = $matches[1];
    } else {
        $adminPath = 'admin';
    }

    foreach($CaasidyInvoices as $invoice) {
        
        // Construct the user name (if found) or use 'Unknown User' as a fallback
        $userDetails = caasify_get_whuser_from_id($invoice->whuserid);
        $userName = $userDetails ? $userDetails->firstname . ' ' . $userDetails->lastname : 'Unknown User';
        

        // Invoice Info
        $invoiceInfo = caasify_get_invoice_info_from_invoiceid($invoice->invoiceid);
        
        if (!empty($invoice->transactionid) && $invoiceInfo['status'] == 'Paid') {
            $buttonClass = 'btn-success';
            $displayText = $invoice->transactionid;
        } else if (empty($invoice->transactionid) && $invoiceInfo['status'] == 'Paid') {
            $buttonClass = 'btn-danger';
            $displayText = 'failed';
        } else {
            $buttonClass = 'btn-warning';
            $displayText = '...';
        }

        // Build the table row with user ID and name
        if($invoiceInfo['status'] == 'Paid'){
            $tablePart02 .= '
                <tr>
                    <td>
                        <a target="_parent" class="text-decoration-none text-black" href="'. $SystemUrl . '/' . $adminPath .'/invoices.php?action=edit&id='. $invoice->invoiceid . '">' . $invoice->updated_at . '</a>
                    </td>
                    <td>
                        <a target="_parent" class="text-decoration-none" href="'. $SystemUrl . '/' . $adminPath .'/invoices.php?action=edit&id='. $invoice->invoiceid . '" style="' . (($invoiceInfo['status'] == 'Paid') ? '' : 'color:#96c6ed;') . '">' . $invoice->invoiceid  . ' (<span>' . $invoiceInfo['status'] . '</span>)</a>
                    </td>
                    <td>
                        <a target="_parent" class="text-decoration-none text-black" href="'. $SystemUrl . '/' . $adminPath .'/clientssummary.php?userid='. $invoice->whuserid . '">' . $userName . ' (' . $invoice->whuserid . ')</a>
                    </td>
                    <td>' . (!empty($invoice->real_charge_amount) ? $invoice->real_charge_amount : '...') . '</td>
                    <td>' .  $invoice->chargeamount . '</td>
                    <td>' . round($invoice->ratio, 6) . '</td>
                    <td>
                        <a target="_parent" style="width: 90px; padding: 5px; border-radius: 100px;" class="btn ' . $buttonClass . '" href="' . $SystemUrl . '/' . $adminPath . '/invoices.php?action=edit&id=' . $invoice->invoiceid . '">' . $displayText . '</a>
                    </td>
                </tr>
            ';
        }
    }


    $tablePart03 = '
            </tbody>
        </table>
    ';

    echo $tablePart01 . $tablePart02 . $tablePart03;


?>