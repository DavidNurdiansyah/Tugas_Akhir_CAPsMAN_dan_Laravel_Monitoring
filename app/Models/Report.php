<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // protected $fillable = ['text', 'bandwidth'];
    protected $fillable = ['bandwidth', 'text'];
    public $timestamps = true; // Ini aktifkan otomatis created_at & updated_at
}