<?php

declare(strict_types=1);

namespace App\Http\Formatters;

use App\Models\Participant;
use Illuminate\Support\Collection;

class ParticipantFormatter
{
    public function formatCollection(Collection $collection): array
    {
        $result = [];

        foreach ($collection->all() as $model) {
            $result[] = $this->formatModel($model);
        }

        return $result;
    }
    public function formatModel(Participant $participant): array
    {
        return [
            'id' => $participant->id,
            'name' => $participant->name,
        ];
    }
}
