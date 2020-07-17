<?php

namespace App\Http\Controllers\Api\V1\Device;

use DB;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Response as Res;
use App\Http\Requests\Device\DeviceInfoRequest;
use App\Http\Controllers\Api\V1\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

class DeviceController extends BaseController
{
    /** 
        *   @OA\Post(
        *     path="/device/tokens",
        *     tags={"Device Info"},
        *     description="store user's device info",
        *     summary="store user's device info",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\RequestBody(
        *         @OA\MediaType(
        *             mediaType="application/json",
        *             @OA\Schema(
        *                 type="object",
        *                 @OA\Property(property="fcm_token",description="firebase token",type="string"),
        *                 @OA\Property(property="device_id",description="device unique id",type="string",),
        *                 @OA\Property(property="device_type",description="device_type",type="string", enum={"android|ios"}),
        *             ),
        *         ),
        *     ),
        *     @OA\Response(response=200,description="device info saved successfully",
        *         @OA\JsonContent(type="object",
        *         ),
        *         @OA\Link(
        *             link="storeDeviceInfo",
        *             operationId="storeDeviceInfo",
        *             parameters={
        *                   "fcm_token":"dYzlgDI01Pw:APA91bGnaPiRaq3nHo6f1M8MAuRMoolBkY-WqkMvn9U0DWMupwqmU_V24sqo_2ROcBlPASYoZM5lzzH16fod__IYHi65FEu6t7dBE3NIczFF_KXkPX0gfdPY1Rnn-goqi6B55gIjMAMd",
        *                   "device_id":"4c402fccc0a4de16e890",
        *                   "device_type":"android|ios",
        *             },
        *          ),
        *     ),
        *     @OA\Response( response="default",description="unexpected error",
        *         @OA\JsonContent(type="object",
        *         ),
        *     ),
        * )
	*/
    public function store(DeviceInfoRequest $request) {
    	DB::beginTransaction();
    	try {
            $user_id = auth()->user()->id;
	    	$device = (new DeviceToken)->storeUserDevice($request, $user_id);
	    	DB::commit();
	    	$this->setStatusCode(Res::HTTP_OK);
	        return $this->sendSuccessResponse($device, 'device info saved successfully');
    	} catch (\Exception $e) {
            DB::rollBack();
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }
}
