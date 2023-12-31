<?php

namespace Modules\Plan\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanStage extends Model
{
    use HasFactory;
    protected $with = ['items'];
    protected $fillable = ['name','order', 'color', 'board_id', 'user_id', 'team_id'];

    public function board() {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function items() {
        return $this->hasMany(PlanItem::class, 'stage_id', 'id');
    }

    public function deleteRelated() {
        $fields = $this->fields();
        foreach ($fields as $field) {
            $field->deleteRelated();
            $field->delete();
        }

        $this->items()->delete();
    }
}
