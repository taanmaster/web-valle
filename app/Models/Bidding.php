<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function proposals()
    {
        return $this->hasMany(BiddingProposal::class, 'bidding_id');
    }

    public function contracts()
    {
        return $this->hasMany(BiddingContract::class, 'bidding_id');
    }

    public function checklists()
    {
        return $this->hasMany(BiddingDeliverable::class, 'bidding_id');
    }

    public function files()
    {
        return $this->hasMany(BiddingFile::class, 'bidding_id');
    }

    public function award()
    {
        return $this->hasOne(BiddingAward::class, 'bidding_id');
    }

    public function updateStatus()
    {
        // No actualizar si está en Validación Jurídica (estado manual)
        if ($this->status === 'Validación jurídica') {
            return;
        }

        // NUEVA LICITACIÓN (default)
        if ($this->status === null || $this->status === 'Nueva Licitación') {
            if ($this->proposals()->count() > 0) {
                $this->status = 'Recepción de Propuestas';
            }
        }

        // RECEPCIÓN DE PROPUESTAS → ADJUDICACIÓN
        if ($this->proposals()->where('status', 'Adjudicada')->exists()) {
            $this->status = 'Adjudicación';
        }

        // ADJUDICACIÓN → CONTRATO (automático)
        if ($this->contracts()->count() > 0) {
            $this->status = 'Contrato';
        }

        // CONTRATO → PROCESO DE ENTREGABLES
        if ($this->checklists()->exists()) {
            $this->status = 'Proceso entregables';
        }

        // PROCESO DE ENTREGABLES → CIERRE
        if (
            $this->checklists()->count() > 0 &&
            $this->checklists()->whereDoesntHave('files')->count() === 0
        ) {
            $this->status = 'Cierre';
        }

        $this->save();
    }
}
