<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Participant;
use App\Models\Prize;
use App\Models\Promo;
use Tests\Feature\TestCase;

class PromoControllerTest extends TestCase
{
    public function testStore(): void
    {
        $this->post('/promo', [
            'name' => 'A',
            'description' => 'B'
        ]);

        $this->assertDatabaseHas(Promo::TABLE, [
            'name' => 'A',
            'description' => 'B',
        ]);
    }

    public function testIndex(): void
    {
        $this->createPromo();

        $result = $this->get('/promo');

        $result->assertJson([
            ['id' => 1, 'name' => 'A', 'description' => 'B'],
        ]);
    }

    public function testShow(): void
    {
        $this->createPromo();

        $this->createParticipant();

        $prize = new Prize();
        $prize->id = 11;
        $prize->promo_id = 1;
        $prize->description = 'Prize_D';
        $prize->save();

        $result = $this->get('/promo/1');

        $result->assertJson([
            'id' => 1,
            'name' => 'A',
            'description' => 'B',
            'prizes' => [
                [
                    'id' => 11,
                    'description' => 'Prize_D',
                ]
            ],
            'participants' => [
                ['id' => 21, 'name' => 'Participant_C']
            ]
        ]);
    }

    public function testUpdate(): void
    {
        $this->createPromo();

        $this->put('/promo/1', [
            'name' => 'C',
            'description' => 'D',
        ]);

        $this->assertDatabaseHas(Promo::TABLE, [
            'id' => 1,
            'name' => 'C',
            'description' => 'D',
        ]);
    }

    public function testDelete(): void
    {
        $this->createPromo();

        $this->delete('/promo/1');

        $this->assertDatabaseCount(Promo::TABLE, 0);
    }

    public function testStoreParticipant(): void
    {
        $this->createPromo();

        $this->post('/promo/1/participant', ['name' => 'Participant']);

        $this->assertDatabaseHas(Participant::TABLE, [
            'promo_id' => 1,
            'name' => 'Participant'
        ]);
    }

    public function testDeleteParticipant(): void
    {
        $this->createPromo();
        $this->createParticipant();

        $this->delete('/promo/1/participant/21')->assertOk();

        $this->assertDatabaseCount(Participant::TABLE, 0);
    }


    public function testStorePrize(): void
    {
        $this->createPromo();

        $this->post('/promo/1/prize', ['description' => 'Prize']);

        $this->assertDatabaseHas(Prize::TABLE, [
            'promo_id' => 1,
            'description' => 'Prize'
        ]);
    }

    public function testDeletePrize(): void
    {
        $this->createPromo();
        $this->createPrize();

        $this->delete('/promo/1/prize/11')->assertOk();

        $this->assertDatabaseCount(Participant::TABLE, 0);
    }

    public function testRaffle(): void
    {
        $this->createPromo();

        $this->createPrize(1);
        $this->createParticipant(2);
        $this->createPrize(3);
        $this->createParticipant(4);

        $this->post('/promo/1/raffle')
            ->assertJsonFragment(['id' => 1])
            ->assertJsonFragment(['id' => 2])
            ->assertJsonFragment(['id' => 3])
            ->assertJsonFragment(['id' => 4])
        ;
    }

    private function createPromo(): void
    {
        $model = new Promo();
        $model->id = 1;
        $model->name = 'A';
        $model->description = 'B';
        $model->save();
    }

    private function createParticipant(int $id = 21): void
    {
        $participant = new Participant();
        $participant->id = $id;
        $participant->promo_id = 1;
        $participant->name = 'Participant_C';
        $participant->save();

    }

    private function createPrize(int $id = 11): void
    {
        $prize = new Prize();
        $prize->id = $id;
        $prize->promo_id = 1;
        $prize->description = 'Prize_D';
        $prize->save();
    }
}
