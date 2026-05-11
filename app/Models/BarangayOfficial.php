<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayOfficial extends Model
{
    use HasFactory;

    protected $table = 'barangay_official';

    protected $fillable = [
        'full_name',
        'position',
        'contact_number',
        'email',
        'term_start',
        'term_end',
        'status'
    ];
}
