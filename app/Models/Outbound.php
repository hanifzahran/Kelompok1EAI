<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outbound extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'qty', 'total_price', 'receiver','phone','address','exit_time'];

    public function item(){
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
}
