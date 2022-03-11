<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Formatters\ParticipantFormatter;
use App\Http\Formatters\PrizeFormatter;
use App\Http\Formatters\PromoFormatter;
use App\Http\Formatters\RaffleResultFormatter;
use App\Models\Prize;
use App\Models\Promo;
use App\Services\PromoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Webmozart\Assert\InvalidArgumentException;

class PromoController extends Controller
{
    public function store(Request $request, PromoFormatter $formatter, PromoService $service): JsonResponse
    {
        $model = $service->store($request->all());

        return response()->json($formatter->formatModel($model));
    }

    public function index(PromoFormatter $formatter): JsonResponse
    {
        $models = Promo::query()->get();

        return response()->json($formatter->formatCollection($models));
    }

    public function show(int $id, PromoFormatter $formatter, PromoService $service): JsonResponse
    {
        $model = $service->getById($id);

        return response()->json($formatter->formatModelWithRelations($model));
    }

    public function update(int $id, Request $request, PromoFormatter $formatter, PromoService $service): JsonResponse
    {
        $model = $service->update($id, $request->all());
        return response()->json($formatter->formatModel($model));
    }

    public function delete(int $id, PromoService $service): JsonResponse
    {
        $service->delete($id);

        return response()->json();
    }

    public function storeParticipant(int $id, Request $request, PromoService $service, ParticipantFormatter $formatter): JsonResponse
    {
        $model = $service->storeParticipant($id, $request->all());

        return response()->json($formatter->formatModel($model));
    }

    public function deleteParticipant(int $id, int $participant_id, PromoService $service): JsonResponse
    {
        $service->deleteParticipant($id, $participant_id);

        return response()->json();
    }

    public function storePrize(int $id, Request $request, PromoService $service, PrizeFormatter $formatter): JsonResponse
    {
        $model = $service->storePrize($id, $request->all());

        return response()->json($formatter->formatModel($model));
    }

    public function deletePrize(int $id, int $prize_id, PromoService $service): JsonResponse
    {
        $service->deletePrize($id, $prize_id);

        return response()->json();
    }

    public function raffle(int $id, PromoService $service, RaffleResultFormatter $formatter): JsonResponse
    {
        try {
            $raffle_dtos = $service->raffle($id);

            return response()->json($formatter->formatArray($raffle_dtos));
        } catch (InvalidArgumentException) {
            throw new HttpException(409, 'Wrong Participants and Prizes amount');
        }
    }
}
