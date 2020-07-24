<?php

namespace App\Http\Controllers\Api\V1\House;

use DB;
use App\Models\House;
use App\Models\Address;
use App\Models\HouseImage;
use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Response as Res;
use App\Http\Requests\House\HouseCreateRequest;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repository\Transformers\House\HouseTransformer;
use App\Repository\Transformers\Image\ImageTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

class HouseController extends BaseController
{

    protected $house_transformer;
	protected $image_transformer;

	public function __construct(HouseTransformer $houseTransformer, ImageTransformer $imageTransformer) {
		$this->house_transformer = $houseTransformer;
        $this->image_transformer = $imageTransformer;
	}

	/**
        * @OA\Get(
        *     path="/houses",
        *     tags={"Houses"},
        *     description="Returns houses",
        *     summary="Returns houses",
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
        *     @OA\Parameter(name="sort", in="query", description="rent order", required=false,
        *           @OA\Schema(type="string", enum={"rent_asc", "rent_desc", "latest", "oldest"}),
        *      ),
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
			$houses = (new House)->getAll();
			if($houses->count() === 0) {
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
        * @OA\Get(
        *     path="/houses/{house_id}",
        *     tags={"Houses"},
        *     description="Returns house with mathcing ID",
        *     summary="Returns house with mathcing ID",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="house_id", in="path", description="house id", required=true,
        *          @OA\Schema(type="integer",), 
        *      ),
        *     @OA\Response(
        *         response=200,
        *         description="house found successfully",
        *         @OA\JsonContent(
        *             type="object",
        *         ),
        *         @OA\Link(
        *              link="findHouseById",
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
            $house = (new House)->findHouseById((int)$id);
            $this->setStatusCode(Res::HTTP_OK);

            return $this->sendSuccessResponse($this->house_transformer->transform($house), 'house found successfully');
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
        *     path="/houses",
        *     tags={"Houses"},
        *     description="post new house",
        *     summary="post new house",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\RequestBody(
        *         @OA\MediaType(
        *             mediaType="application/json",
        *             @OA\Schema(
        *                 type="object",
        *                 @OA\Property(property="title",description="title",type="string"),
        *                 @OA\Property(property="currency",description="currency",type="string", enum={"AUD|USD"}),
        *                 @OA\Property(property="rent",description="rent",type="number"),
        *                 @OA\Property(property="description",description="description",type="string"),
        *
        *                 @OA\Property(property="bedrooms",description="bedrooms",type="string",enum={"studio|1|2|3|4|5|6|7|8"}),
        *                 @OA\Property(property="bathrooms",description="bathrooms",type="number"),
        *                 @OA\Property(property="mesurement",description="mesurement",type="number"),
        *                 @OA\Property(property="measurement_unit",description="measurement_unit",type="string",enum={"square meter|square feet"}),
        *                 @OA\Property(property="furnished",description="furnished",type="boolean"),
        *                 @OA\Property(property="pets_allowed",description="pets allowed",type="boolean"),

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
        *     @OA\Response(response=200,description="house created successfully",
        *         @OA\JsonContent(type="object",
        *         ),
        *         @OA\Link(
        *             link="StoreNewHouse",
        *             operationId="store",
        *             parameters={
        *                   "title": "title here",
        *                   "currency": "AUD",
        *                   "rent": 2000,
        *                   "description": "description here",
        *                   "bedrooms":"studio|1|2|3|4|5",
        *                   "bathroom": "2",
        *                   "measurement": 20,
        *                   "measurement_unit": "square meter|square feet",
        *                   "furnished": true,
        *                   "pets_allowed": true,
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
    public function store(HouseCreateRequest $request) {
        DB::beginTransaction();
        try {
            $address = (new Address)->createNewAddress($request->address);
            $house = (new House)->addNewHouse($request, $address);
            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);

            return $this->sendSuccessResponse($this->house_transformer->transform($house), 'house created successfully');
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
        *     path="/houses/{house_id}/images",
        *     tags={"Houses"},
        *     description="upload house images",
        *     summary="upload house images",
        *     security= {{"App_Key":"","Bearer_auth":"","Provider":"",}},
        *     @OA\Parameter(name="house_id", in="path", description="house id", required=true,
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
            $house = (new House)->checkIfHouseExists((int)$id);
            if(auth()->user()->id !== $house->user_id) {
                $this->setStatusCode(Res::HTTP_BAD_REQUEST);
                return $this->respondWithError('invalid house id');
            }
            $image = (new HouseImage)->uploadImage($request, (int)$id);
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
        *     path="/houses/{house_id}",
        *     tags={"Houses"},
        *     description="update house",
        *     summary="update house",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="house_id", in="path", description="house id", required=true,
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
        *                 @OA\Property(property="bedrooms",description="bedrooms",type="string",enum={"studio|1|2|3|4|5|6"}),
        *                 @OA\Property(property="bathrooms",description="bathrooms",type="number"),
        *                 @OA\Property(property="measurement",description="measurement",type="number"),
        *                 @OA\Property(property="m_unit",description="measurement_unit",type="string",enum={"square meter|square feet"}),
        *                 @OA\Property(property="furnished",description="furnished",type="boolean"),
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
        *     @OA\Response(response=200,description="update house success",
        *         @OA\JsonContent(type="object",
        *         ),
        *         @OA\Link(
        *             link="updateRoom",
        *             operationId="update",
        *             parameters={
        *                   "title": "title here",
        *                   "currency": "aud",
        *                   "rent": 2000,
        *                   "description": "description here",
        *                   "bedrooms":"studio|1|2|3|4|5",
        *                   "bathroom": "2",
        *                   "measurement": 20,
        *                   "m_unit": "square meter|square feet",
        *                   "furnished": true,
        *                   "pets_allowed": true,
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
        *                   "amenities": "[1, 3, 5]",
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
            $house = (new House)->updateHouse($request, (int)$id);
            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->house_transformer->transform($house), 'house updated successfully');
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
        *     path="/houses/{house_id}",
        *     tags={"Houses"},
        *     description="Delete house",
        *     summary="Delete house",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="house_id", in="path", description="house id", required=true,
        *          @OA\Schema(type="integer",), 
        *      ),
        *     @OA\Response(response=200,description="house deleted successfully",
        *         @OA\JsonContent(type="object",
        *         ),
        *         @OA\Link(
        *             link="delete",
        *             operationId="deleteHouse",
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
            $house = (new House)->deleteHouse((int)$id);
            $this->setStatusCode(Res::HTTP_NO_CONTENT);
            return $this->respondNoContent('house deleted successfully');
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
        *     path="/houses/{house_id}/available",
        *     tags={"Houses"},
        *     description="mark house as available",
        *     summary="mark house as available",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="house_id", in="path", description="house id", required=true,
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
        *     @OA\Response(response=200,description="update house success",
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
            $house = (new House)->markAvailable((int)$id);
            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->house_transformer->transform($house), 'house marked available successfully');
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
        *     path="/houses/{house_id}/unavailable",
        *     tags={"Houses"},
        *     description="mark house as unavailable",
        *     summary="mark house as unavailable",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="house_id", in="path", description="house id", required=true,
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
        *     @OA\Response(response=200,description="update house success",
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
            $house = (new House)->markUnavailable((int)$id);
            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($this->house_transformer->transform($house), 'house marked unavailable successfully');
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
