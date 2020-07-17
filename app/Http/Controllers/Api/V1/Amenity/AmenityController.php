<?php

namespace App\Http\Controllers\Api\V1\Amenity;

use App\Models\Amenity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Response as Res;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repository\Transformers\Amenity\AmenityTransformer;

class AmenityController extends BaseController
{

    protected $amenity_transformer;
    
    public function __construct(AmenityTransformer $amenityTransformer) {
        $this->amenity_transformer = $amenityTransformer;
    }

 /**
        * @OA\Get(
        *     path="/amenities/{amenity_for}",
        *     tags={"Amenities"},
        *     description="Returns amenities for rooms or houses",
        *     summary="Returns amenities for rooms or houses",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\Parameter(name="amenity_for", in="path", description="get amenities for 'rooms' or for 'houses'", required=true,
        *          @OA\Schema(type="string", enum={"rooms", "houses"}), 
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

    public function getAmenities($amenityFor) {
        try {
            $amenities = (new Amenity)->getAmenities($amenityFor);
			if(count($amenities) < 1) {
				$this->setStatusCode(Res::HTTP_NOT_FOUND);
				return $this->respondNotFound('no records found');
			}

    		$this->setStatusCode(Res::HTTP_OK);
	      	return $this->sendSuccessResponse($this->amenity_transformer->transformCollection($amenities->all()), 'amenities listed successfully');
    	} catch (\Exception $e) {
    		$this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
    	}
    }
}
