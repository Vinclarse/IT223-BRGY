<?php
// app/Models/Complaint.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $table = 'complaint';
    protected $primaryKey = 'complaint_id';
    public $timestamps = false;

    protected $fillable = [
        'resident_id',
        'subject',
        'description',
        'date_filed',
        'status',
        'handled_by',
        'resolution',
        'supporting_document'
    ];

    protected $casts = [
        'date_filed' => 'datetime',
    ];

    // Allow null values for these fields
    protected $attributes = [
        'handled_by' => null,
        'resolution' => null,
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id', 'resident_id');
    }
}