<?php

namespace App\Models\KanbanBoard;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function columns(): HasMany
    {
        return $this->hasMany(Column::class)->orderBy('order');
    }
}
