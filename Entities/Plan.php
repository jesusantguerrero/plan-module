<?php

namespace Modules\Plan\Entities;

use App\Domains\AppCore\Models\Label;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $with = ['planType'];

    protected $casts = [
        "plan_type_name" => PlanTypes::class
    ];

    protected static function newFactory()
    {
        return \Modules\Plan\Database\factories\PlanFactory::new();
    }

    public function stages() {
        return $this->hasMany(PlanStage::class)->orderBy('order');
    }

    public function planType() {
        return $this->belongsTo(PlanType::class);
    }

    public function fields() {
        return $this->morphMany(Field::class, 'entity');
    }
    public function fieldRules() {
        return $this->morphMany(FieldRule::class, 'entity');
    }
    public function fieldValues() {
        return $this->morphMany(FieldValue::class, 'entity');
    }

    public function labels() {
        return $this->morphMany(Label::class, 'labelable');
    }

    public function template() {
        return $this->belongsTo(PlanTemplate::class);
    }

    public function boardType() {
        return $this->belongsTo('App\Models\BoardType');
    }

    public function createMainStage() {
        $this->stages()->create([
            'user_id' => $this->user_id,
            'team_id' => $this->team_id,
            'name' => $this->name
        ]);

        $this->setUp();
    }

    public function setUp() {
        $defaultTemplate = $this->template ?? PlanTemplate::find(1);
        $templateConfig = json_decode($defaultTemplate->config, true);
        $fields = $templateConfig['fields'];
        $stages = $templateConfig['stages'] ?? null;

        if (count($fields)) {
            foreach ($fields as $field) {
                $fieldDB = $this->fields()->create([
                    'user_id' => $this->user_id,
                    'team_id' => $this->team_id,
                    'name' => $field['name'],
                    'title' => $field['title'],
                    'type' => $field['type'],
                ]);

                if (isset($field['labels'])) {
                    foreach ($field['labels'] as $label) {
                        $fieldDB->labels()->create([
                            'user_id' => $fieldDB->user_id,
                            'team_id' => $fieldDB->team_id,
                            'board_id' => $fieldDB->board_id,
                            'name' => $label['name'],
                            'label' => $label['label'],
                            'color' => $label['color'],
                        ]);
                    }

                    $fieldDB->rules()->create([
                        'user_id' => $fieldDB->user_id,
                        'team_id' => $fieldDB->team_id,
                        'entity_id' => $fieldDB->entity_id,
                        'entity_type' => $fieldDB->entity_type,
                        'name'=> 'bg',
                        'reference' => 'options'
                    ]);
                }
            }
        }

        if ($stages) {
            $this->stages[0]->delete();
            foreach ($stages as $stageName) {
                $this->stages()->create([
                    'user_id' => $this->user_id,
                    'team_id' => $this->team_id,
                    'name' => $stageName
                ]);
            }
        }
    }

    public function findOrCreateField($fieldData) {
        $fieldToSearch = isset($fieldData['name']) ? 'name' : 'id';
        $valueToSearch = $fieldData['name'] ?? $fieldData['field_id'] ?? "";
        $field = $this->fields()->where(["$fieldToSearch" =>  "$valueToSearch"])->limit(1)->get();
        $field = count($field) ? $field[0] : null;
        if (!$field) {
            dd($field);
            $field = $this->fields()->create([
                'user_id' => $this->user_id,
                'team_id' => $this->team_id,
                'name' => $fieldData['name'],
                'title' => empty($fieldData['title']) ? \ucwords(str_replace("_", " ", $fieldData['name'])) : $fieldData['title'],
                'type' => $fieldData['type'] ?? 'text',
                'hide' => $fieldData['hide'] ?? 0,
            ]);
        }
        return $field;
    }

    public function deleteStages() {
        $stages = $this->stages();

        foreach ($stages as $stage) {
            $stage->deleteRelated();
        }
        $stages->delete();
    }
}
