<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'event_id';
    public $incrementing = false; // event_id is a varchar
    public $timestamps = false; // disable Eloquent automatic timestamps (table doesn't have updated_at)
    /**
     * Cast date fields to DateTime so JSON uses ISO-8601 strings
     */
    protected $casts = [
        'event_date' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected $fillable = [
        'event_id',
        'title',
        'event_date',
        'location',
    ];
}
