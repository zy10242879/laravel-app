<?php

namespace App\Http\Entity;

use Illuminate\Database\Eloquent\Model;

class TempPhone extends Model
{
  protected $table = 'temp_phone';
  public $timestamps = false;
  protected $guarded = [];
}
