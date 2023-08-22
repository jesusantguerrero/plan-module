<?php

namespace Modules\Plan\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanChecklist extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'user_id', 'title', 'order', 'done'];
}