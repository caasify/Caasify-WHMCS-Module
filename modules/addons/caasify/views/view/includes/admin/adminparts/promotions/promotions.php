<?php
$promotions = cassify_get_all_promotion_table();
?>
<table class="table"  style="margin-top:3em;">
    <thead>
        <tr>
            <th scope="col">Row</th>
            <th scope="col">Code</th>
            <th scope="col">Type</th>
            <th scope="col">Value (%/€)</th>
            <th scope="col">Start Date</th>
            <th scope="col">Expiration Date</th>
            <th scope="col">Allowed user</th>
            <th scope="col">Recurre time</th>
            <th scope="col">Min Price</th>
            <th scope="col">Max Price</th>
            <th scope="col">Operations</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($promotions as $promotionRow) {
        $valueSign = $promotionRow->type == "percent" ? "%" : "€";
        $conditions = unserialize($promotionRow->conditions);
    ?>
        <tr>
            <td><?=$promotionRow->id?></td>
            <td><?=$promotionRow->code?></td>
            <td><?=$promotionRow->type?></td>
            <td><?=$promotionRow->value . $valueSign?></td>
            <td><?=$promotionRow->start_date?></td>
            <td><?=$promotionRow->expiration_date?></td>
            <td>
                <?php
                if($promotionRow->user_type == "specific_users"){
                ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#allowdUserModal" @click="getAllowedUserList('<?=$promotionRow->id?>', '<?=$promotionRow->code?>')">
                        Specific users
                    </a>
                <?php
                } else if($promotionRow->user_type == "all_users"){
                    echo "All users";
                } else if($promotionRow->user_type == "new_users"){
                    echo "New users";
                }
                ?>
            </td>
            <td><?=$promotionRow->recurring_no?></td>
            <td><?=$conditions["min_amount"]?></td>
            <td><?=$conditions["max_amount"]?></td>
            <td>
                <?php
                if($promotionRow->status == true){
                ?>
                <button class="btn btn-danger" @click="deactivatePromotionCode('<?=$promotionRow->id?>')">Deactivate</button>
                <?php
                }
                else {
                ?>
                <button class="btn btn-success" @click="activatePromotionCode('<?=$promotionRow->id?>')">Active</button>
                <?php
                }
                ?>
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#usedDetailModal" @click="getUsedDetail('<?=$promotionRow->id?>' , '<?=$promotionRow->code?>')">Used Detail</button>
                <button class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#editPromotionModal" @click="editPromotionButton('<?=$promotionRow->id?>' , '<?=$promotionRow->code?>')">Edit</button>
            </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>

<?php include_once __DIR__ . "/modals/usedDetail.php";  ?>
<?php include_once __DIR__ . "/modals/allowed_users.php";  ?>
<?php include_once __DIR__ . "/modals/edit_modal.php";  ?>