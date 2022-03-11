<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $promo_id
 * @property string $description
 */
class Prize extends Model
{
    public const TABLE = 'prizes';
    protected $table = self::TABLE;

    public $timestamps = false;
}
