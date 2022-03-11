<?php

declare(strict_types=1);

namespace App\DTO;

use App\Models\Participant;
use App\Models\Prize;

class RaffleResultDTO
{
    public function __construct(
        public Participant $winner,
        public Prize $prize,
    ) {
    }
}
