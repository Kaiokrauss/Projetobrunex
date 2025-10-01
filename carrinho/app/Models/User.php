<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // ... (propriedades fillable, hidden, etc.)

    // O RELACIONAMENTO COM O CARRINHO FOI REMOVIDO
    // public function cart() { ... }

    // Relacionamento com Pedidos permanece, pois um pedido pertence a um usuário
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}