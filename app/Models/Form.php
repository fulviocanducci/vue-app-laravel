<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $table = "forms";

    protected $primaryKey = 'id';

    protected $casts = [
        'question' => 'string',
        'status' => 'boolean'
    ];

    protected $fillable = [
        'question',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(Item::class, "form_id", "id");
    }
}
