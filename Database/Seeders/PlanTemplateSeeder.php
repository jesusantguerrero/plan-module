<?php

namespace Modules\Plan\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PlanTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $planTypes = [
            [
                'name' => 'chores',
                'title' => 'Chores',
                'templates' => [
                    'name' => 'chores',
                    'title' => 'Chores',
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
                ]
            ],
            [
                'name' => 'plans',
                'title' => 'Plans',
                'templates' => [
                    'name' => 'plans',
                    'title' => 'Plans',
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
                ]
            ],
            [
                'name' => 'equipments',
                'title' => 'Equipment',
                'templates' => [
                    'name' => 'equipments',
                    'title' => 'Equipment',
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
                ]
            ],
            [
                'name' => 'shopping_list',
                'title' => 'Shopping List',
                'templates' => [
                    'name' => 'shopping_list',
                    'title' => 'Shopping List',
                    'config' => json_encode([
                        "fields" => [
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
                                "name" => 'category',
                                "title" => "Category",
                                "type" => "label",
                                "labels" => []
                            ],
                            [
                                "name" => 'place',
                                "title" => "Place",
                                "type" => "label",
                                "labels" => []
                            ],
                            [
                                "name" => 'unit',
                                "title" => "Unit",
                                "type" => "label",
                                "labels" => []
                            ],
                            [
                                "name" => 'ingredient_id',
                                "title" => "ingredient_id",
                                "type" => "number"
                            ],
                            [
                                "name" => 'quantity',
                                "title" => "Quantity",
                                "type" => "number"
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
                            ],
                            [
                                "name" => 'feedback',
                                "title" => "Feedback",
                                "type" => "label",
                                "labels" => [
                                    [
                                        "name" => "good",
                                        "label" => "Good",
                                        "color" => "green"
                                    ],
                                    [
                                        "name" => "soso",
                                        "label" => "Soso",
                                        "color" => "yellow"
                                    ],
                                    [
                                        "name" => "bad",
                                        "label" => "Bad",
                                        "color" => "red"
                                    ]
                                ]
                            ]
                        ],
                        "max_todo_task" => 8
                    ])
                ]
            ]
        ];

        foreach ($planTypes as $planType) {
           DB::table('plan_types')->insert([
                'name' => $planType['name'],
                'title' => $planType['title']
            ]);
            $planId = DB::getPdo()->lastInsertId();

            if (isset($planType['templates'])) {
                DB::table('plan_templates')->insert(
                    array_merge(['plan_type_id' => $planId],
                    $planType['templates'])
                );
            }
        }
    }
}
