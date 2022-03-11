<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\RaffleResultDTO;
use App\Models\Participant;
use App\Models\Prize;
use App\Models\Promo;
use Illuminate\Support\Arr;
use Webmozart\Assert\Assert;

class PromoService
{
    public function store(array $params): Promo
    {
        return $this->updateModel(new Promo(), $params);
    }
    public function update(int $id, array $params): Promo
    {
        $model = $this->getById($id);

        return $this->updateModel($model, $params);
    }

    private function updateModel(Promo $model, array $params): Promo
    {
        $model->name = Arr::get($params, 'name');
        $model->description = Arr::get($params, 'description');

        $model->save();

        return $model;
    }

    public function getById(int $id): Promo
    {
        return Promo::query()->findOrFail($id);
    }

    public function delete(int $id): void
    {
        $promo = $this->getById($id);

        $promo->delete();
    }

    public function storeParticipant(int $id, array $params): Participant
    {
        $participant = new Participant();

        $participant->name = Arr::get($params, 'name');
        $participant->promo_id = $id;

        $participant->save();

        return $participant;
    }

    public function deleteParticipant(int $id, int $participant_id): void
    {
        $promo = $this->getById($id);

        /** @var Participant $participant */
        $participant = $promo->participants->firstOrFail('id', $participant_id);

        $participant->delete();
    }

    public function storePrize(int $id, array $params): Prize
    {
        $prize = new Prize();
        $prize->promo_id = $id;
        $prize->description = Arr::get($params, 'description');

        $prize->save();

        return $prize;
    }

    public function deletePrize(int $id, int $prize_id): void
    {
        $model = $this->getById($id);

        /** @var Prize $prize */
        $prize = $model->prizes->firstOrFail('id', $prize_id);

        $prize->delete();
    }

    public function raffle(int $id): array
    {
        $model = $this->getById($id);

        $prizes = $model->prizes->shuffle()->values();
        $prize_count = $prizes->count();

        $participants = $model->participants->shuffle()->values();

        Assert::eq($prize_count, $participants->count());

        $dtos = [];

        for ($prize_index = 0; $prize_index < $prize_count; $prize_index++) {
            $dtos[] = new RaffleResultDTO(
                $participants->get($prize_index),
                $prizes->get($prize_index),
            );
        }

        return $dtos;
    }
}
