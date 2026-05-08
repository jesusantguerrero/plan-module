<?php

namespace Modules\Plan\Entities;

use RRule\RRule;
use Illuminate\Database\Eloquent\Model;
use Modules\Plan\Entities\Traits\ItemScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanItem extends Model
{
    // 3-state model used by shopping lists. Other plan types (chores, kanban)
    // keep using the binary `is_done` and stay in `STATE_PENDING` / `STATE_BUY`
    // automatically via the boot sync below.
    const STATE_PENDING = 'pending';

    const STATE_BUY = 'buy';

    const STATE_SKIP = 'skip';

    protected $fillable = [
        'plan_id',
        'team_id',
        'stage_id',
        'resource_id',
        'rrule',
        'resource_type',
        'resource_origin',
        'title',
        'order',
        'user_id',
        'is_done',
        'state',
        'commit_date',
        'points',
    ];

    protected $with = ['fields', 'checklist'];

    use HasFactory;
    use ItemScopeTrait;

    protected static function boot()
    {
        parent::boot();

        // Two-way sync between binary `is_done` and 3-state `state` so legacy
        // callers that flip `is_done` keep working AND new shopping-list code
        // that sets `state` directly stays consistent.
        self::saving(function ($model) {
            if ($model->isDirty('state')) {
                $model->is_done = $model->state === self::STATE_BUY;
            } elseif ($model->isDirty('is_done')) {
                $model->state = $model->is_done ? self::STATE_BUY : self::STATE_PENDING;
            }
        });

        self::updating(function ($model) {
            if (! $model->commit_date && $model->is_done) {
                $model->commit_date = now()->format('Y-m-d');
            } elseif (! $model->is_done) {
                $model->commit_date = null;
            }
        });

        self::creating(function ($model) {
            $rrule = new RRule([
                'FREQ' => 'weekly',
                'INTERVAL' => 1,
                'BYDAY' => ['MO','TH', 'SA'],
                'DTSTART' => now()->format('Y-m-d'),
                'UNTIL' => '3099-12-31'
            ]);

            $model->rrule = $rrule->rfcString();
        });
    }

    public function fields() {
        return $this->hasMany(FieldValue::class, 'entity_id', 'id');
    }

    public function checklist() {
        return $this->hasMany(PlanChecklist::class, 'item_id', 'id')->orderBy('order');
    }

    public function stage() {
        return $this->belongsTo(PlanStage::class, 'stage_id', 'id');
    }

    public function saveFields($fields) {
        if ($fields) {
            foreach ($fields as $field) {
                $boardField = $this->stage->board->findOrCreateField($field);
                $fieldInstance = FieldValue::where(['field_id' => $boardField->id, 'entity_id' => $this->id])->first();
                if ($fieldInstance && isset($fieldInstance[0])) {
                    $fieldInstance->value = isset($field['value']) ? $field['value'] : '';
                    $fieldInstance->save();
                } else {
                    $this->fields()->create([
                        'user_id' => $this->user_id,
                        'team_id' => $this->team_id,
                        'resource' => 'item',
                        'field_id' => $boardField->id,
                        'field_name' => $boardField->name,
                        'value' => $field['value'] ?? '',
                        'hide' => $field['hide'] ?? 0
                    ]);
                }
            }
        }
    }

    public function saveChecklist($list) {
        if ($list) {
            PlanChecklist::where(['item_id' => $this->id])->delete();
            foreach ($list as $check) {
                $this->checklist()->create([
                    'user_id' => $this->user_id,
                    'team_id' => $this->team_id,
                    'item_id' => $this->id,
                    'title' => $check['title'],
                    'done' => $check['done'] ?? false,
                    'order' => $check['order'] ?? 0
                ]);
            }
        }

    }

    public function timeEntries() {
        return $this->hasMany('App\Models\TimeEntry', 'item_id', 'id');
    }

    /**
     * Advance through pending → buy → skip → pending. Used by the shopping
     * list chat-style UI where a tap cycles the row.
     */
    public function cycleState(): self
    {
        $this->state = match ($this->state) {
            self::STATE_PENDING => self::STATE_BUY,
            self::STATE_BUY => self::STATE_SKIP,
            default => self::STATE_PENDING,
        };
        $this->save();

        return $this;
    }

    /**
     * Set state explicitly. Validates the value to avoid silent-typos under
     * `Model::preventSilentlyDiscardingAttributes`.
     */
    public function setState(string $state): self
    {
        if (! in_array($state, [self::STATE_PENDING, self::STATE_BUY, self::STATE_SKIP], true)) {
            throw new \InvalidArgumentException("Invalid plan item state: {$state}");
        }
        $this->state = $state;
        $this->save();

        return $this;
    }

    public static function createEvent($eventData, $uniqueBy = null) {
        $isSaved = null;
        if ($uniqueBy) {
            $savedItem = self::where($uniqueBy)->limit(1)->get();
            $isSaved = count($savedItem);
        }

        if(!$isSaved) {
            $item = self::create($eventData);
            $item->saveFields($eventData['fields']);
        } else {
            $savedItem[0]->update($eventData);
            $savedItem[0]->saveFields($eventData['fields']);
        }
    }

    public static function getByCustomField($entry, $user) {
        return self::byCustomField($entry)->with('stage')->where([
            'team_id' => $user->current_team_id,
            'user_id' => $user->id,
        ])->whereNull('commit_date')->get();
    }
}
