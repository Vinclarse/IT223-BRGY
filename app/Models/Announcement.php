<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcement';
    protected $primaryKey = 'announcement_id';
    public $incrementing = true;
    public $timestamps = false; // table uses date_posted, not created_at

    protected $fillable = [
        'official_id',
        'title',
        'content',
        'date_posted',
        'category',
    ];
}
