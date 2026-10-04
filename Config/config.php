<?php

return [
    'name' => 'Plan',

    // Eloquent model used for board/field labels. Loger extends the Atmosphere
    // label in App\Domains\AppCore; other apps can point to Freesgen\Atmosphere\Models\Label.
    'label_model' => env('PLAN_LABEL_MODEL', 'App\\Domains\\AppCore\\Models\\Label'),

    // Loger's household routes (/housing/plans, chores, equipments). Apps that only
    // use the boards (e.g. Neatlancer Studio projects) turn them off.
    'housing_routes' => env('PLAN_HOUSING_ROUTES', true),

    // Create one board per PlanTypes case when a Jetstream team is created (Loger).
    'create_team_plans' => env('PLAN_CREATE_TEAM_PLANS', true),

    // Plan types whose items should NOT get the default daily recurrence on create.
    'non_recurring_types' => ['project'],
];
