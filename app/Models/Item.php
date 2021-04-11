<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, HasTimestamps, SoftDeletes;

    protected $table = "items";

    protected $primaryKey = 'id';

    protected $casts = [
        'form_id' => 'integer',
        'name' => 'string',
        'type' => 'integer',
        'status' => 'boolean'
    ];

    protected $fillable = [
        'form_id',
        'name',
        'type',
        'status'
    ];

    public function form()
    {
        return $this->hasOne(Form::class, "form_id", "id");
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, "item_id", "id");
    }
}
