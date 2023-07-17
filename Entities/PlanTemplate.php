<?php

namespace Modules\Plan\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class PlanTemplate extends Model
{
    use HasFactory;


    public static function run() {
        // Board
        DB::table('board_types')->insert([
            'name' => 'board',
            'title' => 'Board'
        ]);

        // Board Types
        DB::table('board_templates')->insert([
            'board_type_id' => 1,
            'name' => 'heisenhower',
            'title' => 'Heisenhower Matrix',
            'config' => json_encode([
                "fields" => [
                    [
                        "name" => 'owner',
                        "title" => "Owner",
                        "type" => "person"
                    ],
                    [
                        "name" => 'status',
                        "title" => "Status",
                        "type" => "label",
                        "labels" => [
                            [
                                "name" => "backlog",
                                "label" => "Backlog",
                                "color" => "white"
                            ],
                            [
                                "name" => "todo",
                                "label" => "Todo",
                                "color" => "green"
                            ],
                            [
                                "name" => "schedule",
                                "label" => "Schedule",
                                "color" => "blue"
                            ],
                            [
                                "name" => "delegate",
                                "label" => "Delegate",
                                "color" => "yellow"
                            ],
                            [
                                "name" => "delete",
                                "label" => "Delete",
                                "color" => "red"
                            ]
                        ]
                    ],
                    [
                        "name" => 'due_date',
                        "title" => "Due Date",
                        "type" => "date"
                    ],
                    [
                        "name" => 'priority',
                        "title" => "Priority",
                        "type" => "label",
                        "labels" => [
                            [
                                "name" => "low",
                                "label" => "Low",
                                "color" => "green"
                            ],
                            [
                                "name" => "medium",
                                "label" => "Medium",
                                "color" => "yellow"
                            ],
                            [
                                "name" => "high",
                                "label" => "High",
                                "color" => "red"
                            ]
                        ]
                    ]
                ],
                "max_todo_task" => 8
            ])
        ]);
    }
}
