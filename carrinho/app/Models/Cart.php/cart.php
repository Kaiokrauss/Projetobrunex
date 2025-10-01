<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Não há mais user_id para preencher
    protected $fillable = [];

    // O RELACIONAMENTO COM USUÁRIO FOI REMOVIDO
    // public function user() { ... }

    // Relacionamento com itens permanece
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}