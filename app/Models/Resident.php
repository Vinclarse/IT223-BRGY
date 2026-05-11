<?php
// app/Models/Resident.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $table = 'resident';
    protected $primaryKey = 'resident_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'last_name',
        'first_name',
        'middle_name',
        'sex',
        'address',
        'contact_number',
        'email',
        'birth_date',
        'date_registered',
        'status'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'date_registered' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(UserAccount::class, 'user_id', 'user_id');
    }

    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class, 'resident_id', 'resident_id');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'resident_id', 'resident_id');
    }
}