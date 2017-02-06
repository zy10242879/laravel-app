<?php

namespace App\Http\Entity;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
  protected $table = 'cart_item';
  protected $guarded = [];
}
