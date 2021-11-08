<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    public const NOT_STARTED = "not_started";
    public const STARTED     = "started";
    public const PENDING     = "pending";

    protected $fillable = ["title", 'todo_list_id', "status", "description"];

    public function todoList(): BelongsTo
    {
        return $this->belongsTo(TodoList::class, "todo_list_id", "id");
    }
}
