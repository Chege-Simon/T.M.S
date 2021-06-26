<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'expense_id',
       'truck_id',
       'amount',
       'date',
   ];

   public function expense()
   {
       return $this->belongsTo(Expense::class);
   }
   public function truck()
   {
       return $this->belongsTo(Truck::class);
   }
}
