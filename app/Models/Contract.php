<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'name',
       'description',
       'company_id',
       'date',
       'period',
       'terms'
   ];
   public function company()
   {
       return $this->belongsTo(MyCompany::class);
   }
   public function invoices()
   {
       return $this->hasMany(Invoice::class);
   }
}
