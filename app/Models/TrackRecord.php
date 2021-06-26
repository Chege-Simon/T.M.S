<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackRecord extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'truck_id',
        'region_id',
        'destination',
        'client_id',
        'track_record_receipt_number',
        'date',
        'invoice_id',
    ];

    public function truck(){
        return $this->belongsTo(Truck::class);
    }
    public function region(){
        return $this->belongsTo(Region::class);
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
