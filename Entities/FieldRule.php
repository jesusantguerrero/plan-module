<?php

namespace Modules\Plan\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldRule extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'team_id', 'entity_id', 'entity_type', 'name', 'reference'];
}
