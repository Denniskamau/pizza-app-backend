<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //
    public $fillable = ['pizza','toppings', 'size', 'location', 'quantity'];
}
