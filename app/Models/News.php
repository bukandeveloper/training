<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'content',
        'publication_date'
    ];

    public function getPublicationDateAttribute($value){
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
}
