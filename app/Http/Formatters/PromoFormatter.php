<?php

declare(strict_types=1);

namespace App\Http\Formatters;

use App\Models\Promo;
use Illuminate\Support\Collection;

class PromoFormatter
{
    public function formatCollection(Collection $collection): array
    {
        $result = [];

        /** @var Promo $model */
        foreach ($collection->all() as $model) {
            $result[] = $this->formatModel($model);
        }

        return $result;
    }

    public function formatModelWithRelations(Promo $model): array
    {
        $result = $this->formatModel($model);

        $result['prizes'] = (new PrizeFormatter())->formatCollection($model->prizes);
        $result['participants'] = (new ParticipantFormatter())->formatCollection($model->participants);

        return $result;
    }

    public function formatModel(Promo $model): array
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'description' => $model->description,
        ];

    }
}
