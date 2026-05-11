<?php
// app/Models/DocumentRequest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $table = 'request';
    protected $primaryKey = 'request_id';
    public $timestamps = false;

    protected $fillable = [
        'resident_id',
        'request_date',
        'document_type',
        'purpose',
        'preferred_date',
        'submitted_date',
        'status',
        'processed_by',
        'remarks',
        'supporting_document'
    ];

    protected $casts = [
        'request_date' => 'date',
        'preferred_date' => 'date',
        'submitted_date' => 'datetime',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id', 'resident_id');
    }
}