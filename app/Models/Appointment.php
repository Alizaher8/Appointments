<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use App\Models\Client;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use PhpParser\Node\Expr\Cast;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [

        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => AppointmentStatus::class,

    ];

    protected $appends = ['formatted_start_time','formatted_end_time'];


    public function client() :BelongsTo
    {

      return $this->belongsTo(Client::class);

    }

    public function formattedStartTime() :Attribute
    {
        return Attribute::make(

            get: fn () => $this->start_time->format(settings('date_format')),
         );

    }
    public function formattedEndTime() :Attribute
    {
        return Attribute::make(

            get: fn () => $this->end_time->format(settings('date_format')),
         );

    }
}
