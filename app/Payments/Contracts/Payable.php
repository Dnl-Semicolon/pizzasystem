<?php

namespace App\Payments\Contracts;

interface Payable
{
    public function payableId(): string|int;
    public function currency(): string;
    public function amountDue(): int;
    public function description(): string;
    public function customerId(): string|int|null;
}
