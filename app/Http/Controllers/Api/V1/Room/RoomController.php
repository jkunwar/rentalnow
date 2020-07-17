<?php

namespace App\Http\Controllers\Api\V1\Room;

use DB;
use App\Models\Room;
use App\Models\Address;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Response as Res;
use App\Http\Requests\Room\RoomCreateRequest;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repository\Transformers\Room\RoomTransformer;
use App\Repository\Transformers\Image\ImageTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

class RoomController extends BaseController
{
    protected $room_transformer;
	protected $image_transformer;

	public function __construct(RoomTransformer $roomTransformer, ImageTransformer $imageTransformer) {
		$this->room_transformer = $roomTransformer;
        $this->image_transformer = $imageTransformer;
	}

    /**
        * @OA\Get(
        *     path="/rooms",
        *     tags={"Rooms"},
        *     description="Returns rooms",
        *     summary="Returns rooms",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="offset", in="query", description="the number of items to skip", required=true,
        *          @OA\Schema(type="integer"),
        *      ),
        *     @OA\Parameter(name="limit",in="query",description="limit",
        *          @OA\Schema(type="integer"),
        *      ),
        *     @OA\Parameter(name="min_price",in="query",description="minimun rent", required=false,
        *          @OA\Schema(type="number"),
        *      ),
        *     @OA\Parameter(name="max_price",in="query",description="maximum rent", required=false,
        *          @OA\Schema(type="number"),
        *      ),
        *     @OA\Parameter(name="pets_allowed",in="query",description="pet allowed", required=false,
        *          @OA\Schema(type="boolean"),
        *      ),
        *     @OA\Parameter(name="radius",in="query",description="radius in kilometer",
        *          @OA\Schema(type="number"),
        *      ),
        *     @OA\Parameter(name="lat",in="query",description="latitude",
        *          @OA\Schema(type="number", format="float"),
        *      ),
        *     @OA\Parameter(name="lng",in="query",description="longitude",
        *          @OA\Schema(type="number", format="float"),
        *      ),
        *       @OA\Parameter(name="sort", in="query", description="rent order", required=false,
        *           @OA\Schema(type="string", enum={"rent_asc", "rent_desc", "latest", "oldest"}),
        *       ),
        *     @OA\Response(
        *         response=200,
        *         description="rooms listed successfully",
        *         @OA\JsonContent(
        *             type="object",
        *         ),
        *         @OA\Link(
        *              link="Rooms",
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
    public function index() {
    	try {
			$rooms = (new Room)->getAll();
			if($rooms->count() === 0) {
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
        *     path="/rooms/{room_id}",
        *     tags={"Rooms"},
        *     description="Returns room with mathcing ID",
        *     summary="Returns room with mathcing ID",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="room_id", in="path", description="room id", required=true,
        *          @OA\Schema(type="integer",), 
        *      ),
        *     @OA\Response(
        *         response=200,
        *         description="room found successfully",
        *         @OA\JsonContent(
        *             type="object",
        *         ),
        *         @OA\Link(
        *              link="finRoomById",
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

    public function show($id) {
    	try {
    		$room = (new Room)->findRoomById((int)$id);
    		$this->setStatusCode(Res::HTTP_OK);
    		return $this->sendSuccessResponse($this->room_transformer->transform($room), 'room found successfully');
    	} catch (\Exception $e) {
    		if($e instanceof ModelNotFoundException) {
    			$this->setStatusCode(Res::HTTP_NOT_FOUND);
	    		return $this->respondNotFound($e->getMessage());
    		}
    		$this->setStatusCode(Res::HTTP_BAD_REQUEST);
	    	return $this->respondWithError($e->getMessage());
    	}
    }

    /** 
        *   @OA\Post(
        *     path="/rooms",
        *     tags={"Rooms"},
        *     description="post new room",
        *     summary="post new room",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\RequestBody(
        *         @OA\MediaType(
        *             mediaType="application/json",
        *             @OA\Schema(
        *                 type="object",
        *                 @OA\Property(property="title",description="title",type="string"),
        *                 @OA\Property(property="currency",description="currency",type="string", enum={"USD|AUD"}),
        *                 @OA\Property(property="rent",description="rent",type="number"),
        *                 @OA\Property(property="description",description="description",type="string"),
        *
        *                 @OA\Property(property="building_type",description="building _type",type="string",enum={"apartment building (1-10 units)|apartment building(10+units)|apartment complex|house"}),
        *                 @OA\Property(property="move_in_fee",description="move_in_fee",type="number"),
        *                 @OA\Property(property="utilities_cost",description="utilities_cost",type="number"),
        *                 @OA\Property(property="parking_rent",description="parking_rent",type="number"),
        *                 @OA\Property(property="furnished",description="furnished",type="boolean"),
        *                 @OA\Property(property="pets_allowed",description="pets_allowed",type="boolean"),
        *                 @OA\Property(property="address",description="room address",type="object",
        *                       @OA\Property(property="location_id", type="string"),
        *                       @OA\Property(property="location", type="string"),
        *                       @OA\Property(property="latitude", type="double"),
        *                       @OA\Property(property="longitude", type="double"),
        *                 ),
        *                 @OA\Property(property="amenities", type="array",
        *                       @OA\Items(title="amenities", type="number"),
        *                 ),
        *             ),
        *         ),
        *     ),
        *     @OA\Response(response=200,description="room created successfully",
        *         @OA\JsonContent(type="object",
        *         ),
        *         @OA\Link(
        *             link="StoreNewRoom",
        *             operationId="store",
        *             parameters={
        *                   "title": "title here",
        *                   "currency": "AUD",
        *                   "rent": 700,
        *                   "description": "description here",
        *                   "building_type":"apartment building (1-10 units)|apartment building(10+units)|apartment complex|house",
        *                   "move_in_fee": 300,
        *                   "utilities_cost": 100,
        *                   "parking_rent": 100,
        *                   "is_furnished": true,
        *                   "pets_allowed": false,
        *                   "address":{
        *                        "location_id": "ChIJGR3PtqsZ6zkRJZNczERbP-U",
        *                        "location": "Nepal Tourism Board, Pradarshani Marg, Kathmandu, Nepal",
        *                        "latitude": 27.7018982,
        *                        "longitude": 85.31700120000005,
        *                   },
        *                   "amenities": "[1, 2, 3]"
        *             },
        *          ),
        *     ),
        *     @OA\Response( response="default",description="unexpected error",
        *         @OA\JsonContent(type="object",
        *         ),
        *     ),
        * )
    */
    public function store(RoomCreateRequest $request) {
        DB::beginTransaction();
        try {
            $address = (new Address)->createNewAddress($request->address);
            $room = (new Room)->addNewRoom($request, $address);
            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->room_transformer->transform($room), 'room created successfully');
        }catch(\Exception $e) {
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
        *   @OA\Post(
        *     path="/rooms/{room_id}/images",
        *     tags={"Rooms"},
        *     description="upload room images",
        *     summary="upload room images",
        *     security= {{"App_Key":"","Bearer_auth":"","Provider":"",}},
        *     @OA\Parameter(name="room_id", in="path", description="room id", required=true,
        *          @OA\Schema(type="integer",), 
        *      ),
        *     @OA\RequestBody(
        *       @OA\MediaType(
        *             mediaType="multipart/form-data",
        *             @OA\Schema(
        *                 type="object",
        *                 @OA\Property(property="image",description="image",type="file"),
        *             ),
        *         ),
        *     ),
        *     @OA\Response(response=200,description="upload item image success",
        *         @OA\JsonContent(type="object",
        *         ),
        *         @OA\Link(
        *             link="uploadImage",
        *             operationId="storeImage",
        *             parameters={
        *                   "image":"public/images/3.jpg",
        *             },
        *          ),
        *     ),
        *     @OA\Response( response="default",description="unexpected error",
        *         @OA\JsonContent(type="object",
        *         ),
        *     ),
        * )
    */
    public function storeImages(ImageRequest $request, $id) {
        DB::beginTransaction();
        try {
            $room = (new Room)->checkIfRoomExists((int)$id);
            if(auth()->user()->id !== $room->user_id) {
                $this->setStatusCode(Res::HTTP_BAD_REQUEST);
                return $this->respondWithError('invalid room id');
            }
            $image = (new RoomImage)->uploadImage($request, (int)$id);
            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->image_transformer->transform($image), 'image uploaded successfully');
        }catch(\Exception $e) {
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
        *   @OA\Put(
        *     path="/rooms/{room_id}",
        *     tags={"Rooms"},
        *     description="update room",
        *     summary="update room",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="room_id", in="path", description="room id", required=true,
        *          @OA\Schema(type="integer",), 
        *      ),
        *     @OA\RequestBody(
        *         @OA\MediaType(
        *             mediaType="application/json",
        *              @OA\Schema(
        *                 type="object",
        *                 @OA\Property(property="title",description="title",type="string"),
        *                 @OA\Property(property="currency",description="currency",type="string"),
        *                 @OA\Property(property="rent",description="rent",type="number"),
        *                 @OA\Property(property="description",description="description",type="string"),
        *
        *                 @OA\Property(property="building_type",description="building _type",type="string",enum={"apartment building (1-10 units)|apartment building(10+units)|apartment complex|house"}),
        *                 @OA\Property(property="move_in_fee",description="move_in_fee",type="number"),
        *                 @OA\Property(property="utilities_cost",description="utilities_cost",type="number"),
        *                 @OA\Property(property="parking_rent",description="parking_rent",type="number"),
        *                 @OA\Property(property="is_furnished",description="is_furnished",type="boolean"),
        *                 @OA\Property(property="pets_allowed",description="pets_allowed",type="boolean"),

        *                 @OA\Property(property="address",description="room address",type="object",
        *                       @OA\Property(property="country", type="string"),
        *                       @OA\Property(property="country_code", type="string"),
        *                       @OA\Property(property="location_id", type="string"),
        *                       @OA\Property(property="state", type="string"),
        *                       @OA\Property(property="address", type="string"),
        *                       @OA\Property(property="postal_code", type="number"),
        *                       @OA\Property(property="latitude", type="double"),
        *                       @OA\Property(property="longitude", type="double"),
        *                 ),
        *                 @OA\Property(property="amenities", type="array",
        *                       @OA\Items(title="amenities", type="number"),
        *                 ),
        *                 @OA\Property(property="_method",description="Add PUT in the field to update",type="string", enum="PUT"),
        *             ),
        *         ),
        *     ),
        *     @OA\Response(response=200,description="update room success",
        *         @OA\JsonContent(type="object",
        *         ),
        *         @OA\Link(
        *             link="updateRoom",
        *             operationId="update",
        *             parameters={
        *                   "title": "title here",
        *                   "currency": "aud",
        *                   "rent": 700,
        *                   "description": "description here",
        *                   "building_type":"apartment building (1-10 units)|apartment building(10+units)|apartment complex|house",
        *                   "move_in_fee": 300,
        *                   "utilities_cost": 100,
        *                   "parking_rent": 100,
        *                   "is_furnished": true,
        *                   "pets_allowed": false,
        *                   "address":{
        *                        "country": "Nepal",
        *                        "country_code": "NP",
        *                        "location_id": "ChIJGR3PtqsZ6zkRJZNczERbP-U",
        *                        "state": "Central Development Region",
        *                        "address": "Nepal Tourism Board, Pradarshani Marg, Kathmandu, Nepal",
        *                        "latitude": 27.7018982,
        *                        "longitude": 85.31700120000005,
        *                        "postal_code": 44600,
        *                   },
        *                   "amenities": "[1, 2, 3]",
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
    public function update(Request $request, $id) {
        DB::beginTransaction();
        try {
            $room = (new Room)->updateRoom($request, (int)$id);
            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->room_transformer->transform($room), 'room updated successfully');
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
        *   @OA\Delete(
        *     path="/rooms/{room_id}",
        *     tags={"Rooms"},
        *     description="Delete room",
        *     summary="Delete room",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="room_id", in="path", description="room id", required=true,
        *          @OA\Schema(type="integer",), 
        *      ),
        *     @OA\Response(response=200,description="room deleted successfully",
        *         @OA\JsonContent(type="object",
        *         ),
        *         @OA\Link(
        *             link="delete",
        *             operationId="deleteRoom",
        *             parameters={
        *                   "id": 1,
        *             },
        *          ),
        *     ),
        *     @OA\Response( response="default",description="unexpected error",
        *         @OA\JsonContent(type="object",
        *         ),
        *     ),
        * )
    */
    public function delete($id) {
    	try {
    		$room = (new Room)->deleteRoom((int)$id);
    		$this->setStatusCode(Res::HTTP_NO_CONTENT);
	        return $this->respondNoContent('room deleted successfully');
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
        *     path="/rooms/{room_id}/available",
        *     tags={"Rooms"},
        *     description="mark room as available",
        *     summary="mark room as available",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="room_id", in="path", description="room id", required=true,
        *          @OA\Schema(type="integer",), 
        *      ),
        *     @OA\RequestBody(
        *         @OA\MediaType(
        *             mediaType="application/json",
        *              @OA\Schema(
        *                 type="object",
        *                 @OA\Property(property="_method",description="Add PUT in the field to update",type="string", enum="PUT"),
        *             ),
        *         ),
        *     ),
        *     @OA\Response(response=200,description="update room success",
        *         @OA\JsonContent(type="object",
        *         ),
        *         @OA\Link(
        *             link="markAvailable",
        *             operationId="markAvailable",
        *             parameters={
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
    public function markAvailable($id) {
        DB::beginTransaction();
        try {
            $room = (new Room)->markAvailable((int)$id);
            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->room_transformer->transform($room), 'room marked unavailable successfully');
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
        *   @OA\Put(
        *     path="/rooms/{room_id}/unavailable",
        *     tags={"Rooms"},
        *     description="mark room as unavailable",
        *     summary="mark room as unavailable",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="room_id", in="path", description="room id", required=true,
        *          @OA\Schema(type="integer",), 
        *      ),
        *     @OA\RequestBody(
        *         @OA\MediaType(
        *             mediaType="application/json",
        *              @OA\Schema(
        *                 type="object",
        *                 @OA\Property(property="_method",description="Add PUT in the field to update",type="string", enum="PUT"),
        *             ),
        *         ),
        *     ),
        *     @OA\Response(response=200,description="update room success",
        *         @OA\JsonContent(type="object",
        *         ),
        *         @OA\Link(
        *             link="markUnavailable",
        *             operationId="markUnavailable",
        *             parameters={
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
    public function markUnavailable($id) {
        DB::beginTransaction();
        try {
            $room = (new Room)->markUnavailable((int)$id);
            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->room_transformer->transform($room), 'room marked unavailable successfully');
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
