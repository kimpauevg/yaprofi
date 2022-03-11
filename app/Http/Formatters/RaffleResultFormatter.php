<?php

declare(strict_types=1);

namespace App\Http\Formatters;

use App\DTO\RaffleResultDTO;

class RaffleResultFormatter
{
    public function formatArray(array $dtos): array
    {
        $prize_formatter = new PrizeFormatter();
        $participant_formatter = new ParticipantFormatter();

        $result = [];

        /** @var RaffleResultDTO $dto */
        foreach ($dtos as $dto) {
            $result[] = [
                'winner' => $participant_formatter->formatModel($dto->winner),
                'prize' => $prize_formatter->formatModel($dto->prize),
            ];
        }

        return $result;
    }
}
