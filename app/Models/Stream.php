<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;

    protected $table = 'streams';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'stream_id',
        'preview'
    ];

}
