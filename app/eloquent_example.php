<?php

declare(strict_types=1);

use App\Entity\Invoice;
use App\Enums\InvoiceStatus;
use App\Models\Invoice as ModelsInvoice;

require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../eloquent.php';

// $invoice = new App\Models\Invoice();
// $invoice->amount = 45;
// $invoice->invoice_number = '1';
// $invoice->status = App\Enums\InvoiceStatus::Pending;
// $invoice->due_date = (new Carbon\Carbon())->addDays(10);

// $invoice->save();

// $items = [[
//     'Item 1',
//     1,
//      45,
// ], [
//     'Item 2',
//     2,
//      4.5,
// ], [
//     'Item 3',
//     3,
//      34.5,
// ]];

// foreach ($items as [$description, $quantity, $unitPrice]) {
//    $item = new App\Models\InvoiceItem();
//    $item->description = $description;
//    $item->quantity = $quantity;
//    $item->unit_price = $unitPrice;

//    $item->invoice()->associate($invoice);
//    $item->save();
// }

$invoiceId = 3;
ModelsInvoice::query()->where('id', $invoiceId)->update(['status' => InvoiceStatus::Paid]);
