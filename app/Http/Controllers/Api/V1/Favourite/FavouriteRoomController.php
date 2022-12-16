<?php

namespace App\Http\Controllers\Api\V1\Favourite;

use App\Models\Room;
use App\Models\FavouriteRoom;
use Illuminate\Support\Facades\DB;
use \Illuminate\Http\Response as Res;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repository\Transformers\Room\RoomTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

class FavouriteRoomController extends BaseController
{

    protected $room_transformer;

    public function __construct(RoomTransformer $roomTransformer)
    {
        $this->room_transformer = $roomTransformer;
    }

    /**
     * @OA\Get(
     *     path="/rooms/favourites",
     *     tags={"Favourites"},
     *     description="Returns favourit room",
     *     summary="Returns favourit room",
     *     security= {{"App_Key":"","Bearer_auth":""}},
     *     @OA\Parameter(name="offset", in="query", description="the number of items to skip", required=true,
     *          @OA\Schema(type="integer"),
     *      ),
     *     @OA\Parameter(name="limit",in="query",description="limit",
     *          @OA\Schema(type="integer"),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="favourite rooms listed successfully",
     *         @OA\JsonContent(
     *             type="object",
     *         ),
     *         @OA\Link(
     *              link="favouriteRooms",
     *              operationId="index",
     *           ),
     *     ),
     *     @OA\Response(
     *          response="default",
     *          description="an ""unexpected"" error",
     *          @OA\JsonContent(
     *             type="object",
     *          ),
     *      ),
     * )
     */
    public function favouriteRooms()
    {
        try {
            $favourite_rooms = (new Room)->getFavouriteRooms();
            // if ($favourite_rooms->count() === 0) {
            //     $this->setStatusCode(Res::HTTP_NOT_FOUND);
            //     return $this->respondNotFound('no records found');
            // }

            $this->setStatusCode(Res::HTTP_OK);
            return $this->respondWithPagination($favourite_rooms, $this->room_transformer->transformCollection($favourite_rooms->all()), 'favourite rooms listed successfully');
        } catch (\Exception $e) {
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/rooms/{room_id}/favourites",
     *     tags={"Favourites"},
     *     description="Mark room as favourite",
     *     summary="Mark room as favourite",
     *     security= {{"App_Key":"","Bearer_auth":""}},
     *     @OA\Parameter(name="room_id", in="path", description="room id", required=true,
     *          @OA\Schema(type="integer",),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="room saved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *         ),
     *         @OA\Link(
     *              link="SaveRoom",
     *              operationId="makeRoomFavourite",
     *           ),
     *     ),
     *     @OA\Response(
     *          response="default",
     *          description="an ""unexpected"" error",
     *          @OA\JsonContent(
     *             type="object",
     *          ),
     *      ),
     * )
     */

    public function makeRoomFavourite($roomId)
    {
        DB::beginTransaction();
        try {
            $room = (new Room)->checkIfRoomExists((int)$roomId);
            $favourite = (new FavouriteRoom)->favouriteRoom((int)$roomId);
            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->room_transformer->transform($favourite), 'room saved successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof ModelNotFoundException) {
                $this->setStatusCode(Res::HTTP_NOT_FOUND);
                return $this->respondNotFound($e->getMessage());
            }
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *     path="/rooms/{room_id}/favourites",
     *     tags={"Favourites"},
     *     description="Mark room as unfavourite",
     *     summary="Mark room as unfavourite",
     *     security= {{"App_Key":"","Bearer_auth":""}},
     *     @OA\Parameter(name="room_id", in="path", description="room id", required=true,
     *          @OA\Schema(type="integer",),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="room removed successfully",
     *         @OA\JsonContent(
     *             type="object",
     *         ),
     *         @OA\Link(
     *              link="RemoveFavouriteRoom",
     *              operationId="deleteFavouriteRoom",
     *           ),
     *     ),
     *     @OA\Response(
     *          response="default",
     *          description="an ""unexpected"" error",
     *          @OA\JsonContent(
     *             type="object",
     *          ),
     *      ),
     * )
     */
    public function deleteFavouriteRoom($roomId)
    {
        try {
            $room = (new Room)->checkIfRoomExists((int)$roomId);
            $favourite = (new FavouriteRoom)->deleteFavourite((int)$roomId);
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->room_transformer->transform($favourite), 'room removed successfully');
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                $this->setStatusCode(Res::HTTP_NOT_FOUND);
                return $this->respondNotFound($e->getMessage());
            }
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }
}
