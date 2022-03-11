<?php

declare(strict_types=1);

namespace App\Http\Formatters;

use App\Models\Prize;
use Illuminate\Support\Collection;

class PrizeFormatter
{
    public function formatCollection(Collection $collection): array
    {
        $result = [];

        foreach ($collection->all() as $model) {
            $result[] = $this->formatModel($model);
        }

        return $result;
    }

    public function formatModel(Prize $model): array
    {
        return [
            'id' => $model->id,
            'description' => $model->description,
        ];
    }
}
