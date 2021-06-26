<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'begin',
        'end',
        'total',
        'status',
        'truck_id',
        'client_id',
    ];

    public function track_records(){
        return $this->hasMany(TrackRecord::class);
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function truck(){
        return $this->belongsTo(Truck::class);
    }
}
