<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'author',
        'publication_year',
        'publisher',
        'status',
        'borrower_id',

    ];

    public function borrower()
    {
        return $this->belongsTo(Customer::class, 'borrower_id');
    }
}
