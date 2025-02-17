<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Support\Carbon;
use PDO;
use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    CONST UPDATED_AT = null;

    protected $cast = [
        'status'=> InvoiceStatus::class,
        'created_at' => 'datetime',
        'due_date' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function(Invoice $invoice) {
            if ($invoice->isClean('due_date')) {
                $invoice->due_date = (new Carbon())->addDays(10);
            }
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
