<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffLeave extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'leave_date',
        'reason',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'leave_date' => 'date',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
