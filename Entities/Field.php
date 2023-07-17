<?php

namespace Modules\Plan\Entities;

use App\Domains\AppCore\Models\Label;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;
    protected $with = ['options','rules'];
    protected $fillable = ['name','board_id', 'title', 'type', 'options', 'user_id', 'team_id', "manual", 'hide'];

    public function options() {
        return $this->morphMany(Label::class, 'labelable');
    }

    public function rules() {
        return $this->hasMany(FieldRule::class, 'field_id', 'id');
    }

    public function fieldValues() {
        return $this->hasMany(FieldValue::class, 'field_id', 'id');
    }

    public function labels() {
        return $this->morphMany(Label::class, 'labelable');
    }

    public function deleteRelated() {
        $this->rules()->delete();
        $this->options()->delete();
        $this->labels()->delete();
        $this->fieldValues()->delete();
    }
}
