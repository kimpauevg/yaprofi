<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 *
 * @property-read Collection|Prize[] $prizes
 * @property-read Collection|Participant[] $participants
 */
class Promo extends Model
{
    public const TABLE = 'promos';
    protected $table = self::TABLE;

    public $timestamps = false;

    public function prizes(): HasMany
    {
        return $this->hasMany(Prize::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }
}
