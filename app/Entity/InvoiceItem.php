<?php
declare(strict_types=1);
namespace App\Entity;

use Doctrine\ORM\Mapping\Id;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\GeneratedValue;

#[Entity]
#[Table(name: 'invoice_items')]
class InvoiceItem
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column(type: 'integer', name: 'invoice_id')]
    private int $invoiceId;

    #[Column(type: 'string')]
    private string $description;

    #[Column(type: 'integer')]
    private int $quantity;

    #[Column(precision: 10, scale: 2, name: 'unit_price', type: Types::DECIMAL)]
    private int $unitPrice;

    #[ManyToOne(inversedBy:'items')]
    private Invoice $invoice;

    public function getId(): int
    {
        return $this->id;
    }

    public function getInvoiceId(): int
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(int $invoiceId): void
    {
        $this->invoiceId = $invoiceId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(int $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }

    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(Invoice $invoice): void
    {
        $this->invoice = $invoice;
    }
}
