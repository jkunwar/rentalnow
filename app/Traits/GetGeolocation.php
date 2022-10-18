<?php

namespace App\Traits;

use App\Exceptions\GeoLocationException;

trait GetGeolocation
{

    public function getLocation($locationId)
    {
        try {
            $geocoder_api = 'http://geocoder.api.here.com/6.2/geocode.json?locationid=' . $locationId . '&jsonattributes=1&gen=9&app_id=kbyNs2CXP9UcEavAe3xt&app_code=xDFG9tDcVJyLzrvb8oMRHQ';
            $result = json_decode(file_get_contents($geocoder_api), true);
            $view = $result['response']['view'][0]['result'][0]['location'];
            $location['location_id'] = $locationId;
            $location['latitude'] = $view['displayPosition']['latitude'];
            $location['longitude'] = $view['displayPosition']['longitude'];
            $location['top_left_lat'] = $view['mapView']['topLeft']['latitude'];
            $location['top_left_lng'] = $view['mapView']['topLeft']['longitude'];
            $location['bottom_right_lat'] = $view['mapView']['bottomRight']['latitude'];
            $location['bottom_right_lng'] = $view['mapView']['bottomRight']['longitude'];
            return $location;
        } catch (\Exception $e) {
            throw new GeoLocationException($e->getMessage());
        }
    }

    public function getSuggestionLists($query)
    {
        try {
            $geocoder_api = 'http://autocomplete.geocoder.api.here.com/6.2/suggest.json?app_id=kbyNs2CXP9UcEavAe3xt&app_code=xDFG9tDcVJyLzrvb8oMRHQ&query=' . $query;
            $result = json_decode(file_get_contents($geocoder_api), true);
            return $result;
        } catch (\Exception $e) {
            throw new GeoLocationException($e->getMessage());
        }
    }
}
