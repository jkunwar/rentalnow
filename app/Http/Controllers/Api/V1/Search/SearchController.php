<?php

namespace App\Http\Controllers\Api\V1\Search;

use Illuminate\Http\Request;
use App\Traits\GetGeolocation;
use \Illuminate\Http\Response as Res;
use App\Http\Controllers\Api\V1\BaseController;

class SearchController extends BaseController
{
    use GetGeolocation;

    public function getSuggestions(Request $request)
    {
        try {
            $query = urlencode($request['query']);
            $result = $this->getSuggestionLists($query);
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($result, 'suggestions found successfully');
        } catch (\Exception $e) {
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }

    public function getLatLngFromLocationId(Request $request, $locationId)
    {
        try {
            $result = $this->getLocation($locationId);
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($result, 'location found successfully');
        } catch (\Exception $e) {
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }
}
