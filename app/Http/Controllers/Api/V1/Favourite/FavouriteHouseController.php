<?php

namespace App\Http\Controllers\Api\V1\Favourite;

use DB;
use App\Models\House;
use Illuminate\Http\Request;
use App\Models\FavouriteHouse;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Response as Res;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repository\Transformers\House\HouseTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

class FavouriteHouseController extends BaseController
{

    protected $house_transformer;

	public function __construct(HouseTransformer $houseTransformer) {
        $this->house_transformer = $houseTransformer;
	}

    /**
        * @OA\Get(
        *     path="/houses/favourites",
        *     tags={"Favourites"},
        *     description="Returns favourite houses",
        *     summary="Returns favourite houses",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="offset", in="query", description="the number of items to skip", required=true,
        *          @OA\Schema(type="integer"),
        *      ),
        *     @OA\Parameter(name="limit",in="query",description="limit",
        *          @OA\Schema(type="integer"),
        *      ),
        *     @OA\Response(
        *         response=200,
        *         description="favourite houses listed successfully",
        *         @OA\JsonContent(
        *             type="object",
        *         ),
        *         @OA\Link(
        *              link="favouriteHouses",
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
    public function favouriteHouses() {
        try {
            $favourite_houses = (new House)->getFavouriteHouses();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->respondWithPagination($favourite_houses, $this->house_transformer->transformCollection($favourite_houses->all()), 'favourite houses listed successfully');
        } catch (\Exception $e) {
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
        * @OA\Post(
        *     path="/houses/{house_id}/favourites",
        *     tags={"Favourites"},
        *     description="Mark house as favourite",
        *     summary="Mark house as favourite",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="house_id", in="path", description="house id", required=true,
        *          @OA\Schema(type="integer",),
        *      ),
        *     @OA\Response(
        *         response=200,
        *         description="house saved successfully",
        *         @OA\JsonContent(
        *             type="object",
        *         ),
        *         @OA\Link(
        *              link="SaveHouse",
        *              operationId="makeHouseFavourite",
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

    public function makeHouseFavourite($houseId) {
        DB::beginTransaction();
        try {
            $house = (new House)->checkIfHouseExists((int)$houseId);
            $favourite = (new FavouriteHouse)->favouriteHouse((int)$houseId);
            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->house_transformer->transform($favourite), 'house saved successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            if($e instanceof ModelNotFoundException) {
                $this->setStatusCode(Res::HTTP_NOT_FOUND);
                return $this->respondNotFound($e->getMessage());
            }
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
        * @OA\Delete(
        *     path="/houses/{house_id}/favourites",
        *     tags={"Favourites"},
        *     description="Mark house as unfavourite",
        *     summary="Mark house as unfavourite",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="house_id", in="path", description="house id", required=true,
        *          @OA\Schema(type="integer",),
        *      ),
        *     @OA\Response(
        *         response=200,
        *         description="house removed successfully",
        *         @OA\JsonContent(
        *             type="object",
        *         ),
        *         @OA\Link(
        *              link="RemoveFavouriteHouse",
        *              operationId="deleteFavouriteHouse",
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
    public function deleteFavouriteHouse($houseId) {
        try {
            $house = (new House)->checkIfHouseExists((int)$houseId);
            $favourite = (new FavouriteHouse)->deleteFavourite((int)$houseId);
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->house_transformer->transform($favourite), 'house removed successfully');
        } catch (\Exception $e) {
            if($e instanceof ModelNotFoundException) {
                $this->setStatusCode(Res::HTTP_NOT_FOUND);
                return $this->respondNotFound($e->getMessage());
            }
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }
}
