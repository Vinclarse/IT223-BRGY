<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransparencyReport extends Model
{
    protected $table = 'transparency_report';
    protected $primaryKey = 'report_id';
    protected $fillable = ['title', 'description', 'category', 'report_date'];
    public $timestamps = true;
}
