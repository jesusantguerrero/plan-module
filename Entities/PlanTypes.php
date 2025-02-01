<?php
namespace Modules\Plan\Entities;

enum PlanTypes: string {
    case CHORES = 'chores';
    case PLANS = 'plans';
    case EQUIPMENTS = 'equipments';
    case SHOPPING_LIST = 'shopping_list';
    case CUSTOM = 'custom';
}
