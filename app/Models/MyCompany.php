<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyCompany extends Model
{
    use HasFactory;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'name',
       'email',
       'phone_number',
       'address',
       'bank_account',
   ];
   public function contracts()
   {
       return $this->hasMany(Contract::class);
   }
}
