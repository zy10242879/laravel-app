<?php

namespace App\Http\Entity;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
  protected $table = 'order_item';
  protected $guarded = [];
  public $timestamps = false;
}
