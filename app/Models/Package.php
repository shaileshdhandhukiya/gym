<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'max_cost',
        'min_cost',
        'duration_days',
        'plan',
    ];

    public static function validationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'max_cost' => 'required|numeric',
            'min_cost' => 'required|numeric',
            'duration_days' => 'required|integer',
            'plan' => 'required|in:monthly,quarterly,half_year,year',
        ];
    }
}
