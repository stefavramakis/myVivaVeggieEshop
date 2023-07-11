<?php

class GetVoucherDiscount {
    static function getDiscount($voucher, $selectedItems, $grandTotal){
        $discount = 0;
        switch ($voucher) {
            case 'HAPPYBIRTHDAY':
                $newGrandTotal = 0.8 * $grandTotal;
                $discount = $grandTotal - $newGrandTotal;
                break;
            case 'SUMMER':
                $newGrandTotal = $grandTotal - 200;
                $discount = $grandTotal - $newGrandTotal;
                break;
            case 'ILIKEAPPLES':
                if(isset($selectedItems["d65d349b-2a77-4fdb-9d7a-0ab85eb84fd1"])){
                    $newGrandTotal = $grandTotal - 0.6 * $selectedItems["d65d349b-2a77-4fdb-9d7a-0ab85eb84fd1"]['price'] * $selectedItems["d65d349b-2a77-4fdb-9d7a-0ab85eb84fd1"]['quantity'];
                    $discount = $grandTotal - $newGrandTotal;
                }
                break;
            case 'ILIKEPEARS':
                if(isset($selectedItems["34d69140-d883-48d5-9af6-cecae5e653e2"])){
                    $newGrandTotal = $grandTotal - 0.4 * $selectedItems["34d69140-d883-48d5-9af6-cecae5e653e2"]['price'] * $selectedItems["34d69140-d883-48d5-9af6-cecae5e653e2"]['quantity'];
                    $discount = $grandTotal - $newGrandTotal;
                }
                break;
            case 'GREEN':
                $discount1 = 0;
                $discount2 = 0;
                if(isset($selectedItems["34d69140-d883-48d5-9af6-cecae5e653e2"])){
                    $newGrandTotal = $grandTotal - 0.3 * $selectedItems["34d69140-d883-48d5-9af6-cecae5e653e2"]['price'] * $selectedItems["34d69140-d883-48d5-9af6-cecae5e653e2"]['quantity'];
                    $discount1 = $grandTotal - $newGrandTotal;
                }
                if(isset($selectedItems["51405659-f333-4f68-871d-fe0fc4706678"])){
                    $newGrandTotal = $grandTotal - 0.3 * $selectedItems["51405659-f333-4f68-871d-fe0fc4706678"]['price'] * $selectedItems["51405659-f333-4f68-871d-fe0fc4706678"]['quantity'];
                    $discount2 = $grandTotal - $newGrandTotal;
                }
                $discount = $discount1 + $discount2;
                break;
        }

        return ['selectedItems' => $selectedItems, 'grandTotal' => $newGrandTotal, 'discount' => $discount];
    }
}