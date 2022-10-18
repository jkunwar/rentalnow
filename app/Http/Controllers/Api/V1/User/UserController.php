<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Models\Room;
use App\Models\User;
use App\Models\House;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ImageRequest;
use \Illuminate\Http\Response as Res;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repository\Transformers\Room\RoomTransformer;
use App\Repository\Transformers\User\UserTransformer;
use App\Repository\Transformers\House\HouseTransformer;
use App\Repository\Transformers\Image\ImageTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

class UserController extends BaseController
{
    protected $user_transformer;
    protected $image_transformer;
    protected $room_transformer;
    protected $house_transformer;

    public function __construct(
        UserTransformer $userTransformer,
        ImageTransformer $imageTransformer,
        RoomTransformer $roomTransformer,
        HouseTransformer $houseTransformer
    ) {
        $this->user_transformer = $userTransformer;
        $this->image_transformer = $imageTransformer;
        $this->room_transformer = $roomTransformer;
        $this->house_transformer = $houseTransformer;
    }

    /**
     * @OA\Get(
     *     path="/users/{user_id}",
     *     tags={"Users"},
     *     description="Returns user with mathcing ID",
     *     summary="Returns user with mathcing ID",
     *     security= {{"App_Key":"","Bearer_auth":""}},
     *     @OA\Parameter(name="user_id", in="path", description="user id", required=true,
     *          @OA\Schema(type="integer",),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="user found successfully",
     *         @OA\JsonContent(
     *             type="object",
     *         ),
     *         @OA\Link(
     *              link="getUserById",
     *              operationId="show",
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
    public function show($id)
    {
        try {
            $user = (new User)->getUserById((int)$id);
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->user_transformer->transform($user), 'user found successfully');
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                $this->setStatusCode(Res::HTTP_NOT_FOUND);
                return $this->respondNotFound($e->getMessage());
            }

            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     *   @OA\Put(
     *     path="/users/{user_id}",
     *     tags={"Users"},
     *     description="update user",
     *     summary="update user",
     *     security= {{"App_Key":"","Bearer_auth":""}},
     *     @OA\Parameter(name="user_id", in="path", description="user id", required=true,
     *          @OA\Schema(type="integer",),
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="name",description="name",type="string"),
     *                 @OA\Property(property="dob",description="move in date (YYYY-mm-dd)",type="string",format="date"),
     *                 @OA\Property(property="gender",description="gender _type",type="string",enum={"male|female|other"}),
     *                 @OA\Property(property="phone_number",description="phone_number",type="number"),
     *                 @OA\Property(property="email",description="email",type="string", format="email"),


     *                 @OA\Property(property="address",description="room address",type="object",
     *                       @OA\Property(property="location_id", type="string"),
     *                       @OA\Property(property="location", type="string"),
     *                       @OA\Property(property="latitude", type="number", format="float"),
     *                       @OA\Property(property="longitude", type="number", format="float"),
     *                 ),
     *                 @OA\Property(property="_method",description="Add PUT in the field to update",type="string", enum="PUT"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response=200,description="update user success",
     *         @OA\JsonContent(type="object",
     *         ),
     *         @OA\Link(
     *             link="upateUser",
     *             operationId="update",
     *             parameters={
     *                   "name": "john doe",
     *                   "phone_number": "9087654321",
     *                   "email": "john@email.com",
     *                   "dob": "2020-05-28",
     *                   "gender":"male|female|other",
     *                   "address":{
     *                        "location_id": "ChIJGR3PtqsZ6zkRJZNczERbP-U",
     *                        "location": "Nepal Tourism Board, Pradarshani Marg, Kathmandu, Nepal",
     *                        "latitude": 27.7018982,
     *                        "longitude": 85.31700120000005,
     *                   },
     *                   "_method":"PUT",
     *             },
     *          ),
     *     ),
     *     @OA\Response( response="default",description="unexpected error",
     *         @OA\JsonContent(type="object",
     *         ),
     *     ),
     * )
     */
    public function update(UserUpdateRequest $request, $id)
    {
        if ((int)$id !== auth()->user()->id) {
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError('invalid user id');
        }
        DB::beginTransaction();
        try {
            if ($request->address) {
                $address = (new Address)->createNewAddress($request->address);
                $user = (new User)->updateUser($request, $address);
            } else {
                $user = (new User)->updateUser($request);
            }
            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->user_transformer->transform($user), 'user updated successfully');
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
     * @OA\Get(
     *     path="/users/{user_id}/rooms",
     *     tags={"Users"},
     *     description="Returns user's rooms",
     *     summary="Returns user's room",
     *     security= {{"App_Key":"","Bearer_auth":"", }},
     *     @OA\Parameter(name="user_id", in="path", description="user id", required=true,
     *          @OA\Schema(type="integer",),
     *      ),
     *     @OA\Parameter(name="offset", in="query", description="the number of items to skip", required=true,
     *          @OA\Schema(type="integer"),
     *      ),
     *     @OA\Parameter(name="limit",in="query",description="limit",
     *          @OA\Schema(type="integer"),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="user's rooms listed successfully",
     *         @OA\JsonContent(
     *             type="object",
     *         ),
     *         @OA\Link(
     *              link="Rooms",
     *              operationId="getUserRooms",
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
    public function getUserRooms($userId)
    {
        try {
            $rooms = (new Room)->getUserRooms((int)$userId);
            if ($rooms->count() === 0) {
                $this->setStatusCode(Res::HTTP_NOT_FOUND);
                return $this->respondNotFound('no records found');
            }

            $this->setStatusCode(Res::HTTP_OK);
            return $this->respondWithPagination($rooms, $this->room_transformer->transformCollection($rooms->all()), 'rooms listed successfully');
        } catch (\Exception $e) {
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/users/{user_id}/houses",
     *     tags={"Users"},
     *     description="Returns user's houses",
     *     summary="Returns user's room",
     *     security= {{"App_Key":"","Bearer_auth":"", }},
     *     @OA\Parameter(name="user_id", in="path", description="user id", required=true,
     *          @OA\Schema(type="integer",),
     *      ),
     *     @OA\Parameter(name="offset", in="query", description="the number of items to skip", required=true,
     *          @OA\Schema(type="integer"),
     *      ),
     *     @OA\Parameter(name="limit",in="query",description="limit",
     *          @OA\Schema(type="integer"),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="user's houses listed successfully",
     *         @OA\JsonContent(
     *             type="object",
     *         ),
     *         @OA\Link(
     *              link="Rooms",
     *              operationId="getUserRooms",
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
    public function getUserHouses($userId)
    {
        try {
            $houses = (new House)->getUserHouses((int)$userId);
            if ($houses->count() === 0) {
                $this->setStatusCode(Res::HTTP_NOT_FOUND);
                return $this->respondNotFound('no records found');
            }

            $this->setStatusCode(Res::HTTP_OK);
            return $this->respondWithPagination($houses, $this->house_transformer->transformCollection($houses->all()), 'houses listed successfully');
        } catch (\Exception $e) {
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     *@OA\Post(
     *   path="/users/{user_id}/images",
     *   tags={"Users"},
     *   summary="Update user profile picture",
     *   description="Update user profile picture",
     *   operationId="AppuserImageUpload",
     *   security= {{"App_Key":"","Bearer_auth":""}},
     *   @OA\Parameter(name="user_id", in="path", description="user id", required=true,
     *       @OA\Schema(type="integer",),
     *   ),
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="image",type="file"),
     *             ),
     *         ),
     *   ),
     *   @OA\Response(
     *         response=200,
     *         description="Image Uplaod successful",
     *         @OA\JsonContent(
     *             type="string",
     *         ),
     *         @OA\Link(
     *              link="Update Profile Picture",
     *              operationId="updateProfileImage",
     *              parameters={"image":"image.jpg"},
     *          ),
     *     ),
     *   @OA\Response(response=404, description="Image Uplaod Failed"),
     *   @OA\Response(response=500, description="internal server error"),
     *),
     */
    public function updateProfileImage(ImageRequest $request)
    {
        DB::beginTransaction();
        try {

            $user = (new User)->changeProfilePicture($request);

            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->user_transformer->transform($user), 'profile image updated successfully');
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
}
