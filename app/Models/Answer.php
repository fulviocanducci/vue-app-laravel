<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $table = "answers";

    protected $primaryKey = 'id';

    protected $casts = [
        'item_id' => 'integer',
        'text' => 'string',
        'status' => 'boolean'
    ];

    protected $fillable = [
        'item_id',
        'text',
        'status'
    ];

    public function item()
    {
        return $this->hasOne(Item::class, "item_id", "id");
    }
}
