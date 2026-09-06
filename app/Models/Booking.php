<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
     protected $fillable = [
            'user_id',
            'car_id',
            'booking_date',
            'booking_time',
            'message',
            'status',
     ];

     protected $casts = [
            'booking_date' => 'date',
     ];


     public function user(){

        return $this->belongsTo(User::class);

     }
     
     public function car(){

        return $this->belongsTo(Car::class);

     }



}
