<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_OCCUPIED = 'occupied';
    public const STATUS_READY_FOR_SERVICE = 'ready_for_service';
    public const STATUS_PENDING_PAYMENT = 'pending_payment';

    public const STATUSES = [
        self::STATUS_AVAILABLE,
        self::STATUS_OCCUPIED,
        self::STATUS_READY_FOR_SERVICE,
        self::STATUS_PENDING_PAYMENT,
    ];

    protected $fillable = [
        'number',
        'capacity',
        'status',
        'qr_token',
    ];

    public function hasActiveService(): bool
    {
        return in_array($this->status, [
            self::STATUS_OCCUPIED,
            self::STATUS_READY_FOR_SERVICE,
            self::STATUS_PENDING_PAYMENT,
        ], true);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_AVAILABLE => 'Disponible',
            self::STATUS_OCCUPIED => 'Ocupada',
            self::STATUS_READY_FOR_SERVICE => 'Cliente listo',
            self::STATUS_PENDING_PAYMENT => 'Pendiente de pago',
            default => 'Sin estado',
        };
    }

    public function statusClass(): string
    {
        return match ($this->status) {
            self::STATUS_AVAILABLE => 'table-available',
            self::STATUS_OCCUPIED => 'table-occupied',
            self::STATUS_READY_FOR_SERVICE => 'table-ready',
            self::STATUS_PENDING_PAYMENT => 'table-payment',
            default => 'table-muted',
        };
    }
}
