<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number_plate',
        'manufacturer',
        'model',
        'color',
    ];

    public function track_records(){
        return $this->hasMany(TrackRecord::class);
    }
    public function driver(){
        return $this->hasOne(Driver::class);
    }
}
