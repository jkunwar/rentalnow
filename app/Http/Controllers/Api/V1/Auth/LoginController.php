<?php

namespace App\Http\Controllers\Api\V1\Auth;

use DB;
use Validator;
use Socialite;
use App\Models\User;
use App\Models\Provider;
use App\Traits\IssueToken;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use App\Traits\GoogleValidation;
use App\Traits\FacebookValidation;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Response as Res;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repository\Transformers\User\UserTransformer;


class LoginController extends BaseController
{
    use  GoogleValidation, FacebookValidation, IssueToken;

    private $client;
    protected $user_transformer;

    public function __construct(UserTransformer $userTransformer) {
        $this->user_transformer = $userTransformer;
    }

    /** 
        *   @OA\Post(
        *     path="/login",
        *     tags={"Auth"},
        *     description="User login",
        *     summary="User login",
        *     security= {{"App_Key":""}},
        *     @OA\RequestBody(
        *         description="User login",
        *         required=true,
        *          @OA\JsonContent(
        *           type="object",
        *            @OA\Property(property="name",description="name",title="name",type="string",),
        *            @OA\Property(property="dob",description="YYYY-mm-dd",title="date of birth",type="date",),
        *            @OA\Property(property="email",description="user email",title="user email",type="string",),
        *            @OA\Property(property="phone_number",description="phone number",title="phone number",type="number",),
        *            @OA\Property(property="token",description="token",title="token",type="string",),
        *            @OA\Property(property="provider",description="provider",title="provider",
        *              type="string",
        *             @OA\Items(type="string", enum={"Google|Facebook"}),
        *             ),
        *             @OA\Property(property="gender",description="gender",title="gender",
        *              type="string",
        *             @OA\Items(type="string", enum={"male|female|other"}),
        *              ),
        *              @OA\Property(property="image",description="profile image",title="profile image",type="string",),
        *            ),
        *          @OA\MediaType(
        *             mediaType="multipart/form-data",
        *             @OA\Schema(
        *                 type="object",
        *                 @OA\Property(property="name",description="name*",type="string",),
        *                 @OA\Property(property="dob",description="dob YYYY-mm-dd",type="date",format="date"),
        *                  @OA\Property(property="email",description="email*", type="string"),
        *                 @OA\Property(property="phone_number",description="phone_number*",type="number",),
        *                 @OA\Property(property="token",description="social media token*",type="string",format="int64",),
        *                 @OA\Property(property="provider",description="social media type*",enum={"google","facebook"}),
        *                 @OA\Property(property="gender",description="user gender",enum={"male","female","other"},),
        *                 @OA\Property(property="image",description="user profile image from social media", type="string",),
        *                 @OA\Property(property="device_type",description="device type*",enum={"ios","android"},),
        *                 @OA\Property(property="device_id",description="device unique id*", type="string",),
        *                 @OA\Property(property="fcm_token",description="firebase token", type="string",),
        *             ),
        *           ),
        *     ),
        *     @OA\Response(
        *         response=200,
        *         description="login success",
        *         @OA\JsonContent(
        *             type="object",
        *         ),
        *         @OA\Link(
        *              link="User login",
        *              operationId="login",
        *              parameters={
        *                   "name":"melyna.hintz",
        *                   "dob":"1994-07-27",
        *                   "email":"johndoe@email.com",
        *                   "phone_number":1234567890,
        *                   "token":"asdasfdsgrsfdzdghgzsdgfxczxbdgbxcz",
        *                   "provider":"google|facebook",
        *                   "gender":"male|female|other",
        *                   "image": "https://google.com/user-id/user-profile-picture",
        *                   "device_type": "ios|android",
        *                   "device_id": "1cdf23123",
        *                   "fcm_token": "20cXaYfj8xSaM:APA91bHKna7n-wYz8Y5hOtG8XqYF4_fCzcdQ6-tPIgGo4rM-xk__Nor0jCRTH3fr6Ha9PbkivKyMyh1y7RAPpFR5j8S5LYpvG8r3chU-a9j1e6ZnwfBNtZeXapQDmn46jiFcOWy79Uav"
        *              },
        *          ),
        *     ),
        *     @OA\Response(
        *         response="default",
        *         description="unexpected error",
        *         @OA\JsonContent(
        *             type="object",
        *         ),
        *     ),
        * )
    */
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'          => 'bail|required|string|max:191',
            'dob'           => 'bail|nullable||date|date_format:"Y-m-d|before:today',
            'gender'		=> 'bail|nullable|in:male,female,other',
            'phone_number'  => 'bail|required|digits_between:7,10',
            'email'         => 'bail|required|email',
            'token'         => 'required',
            'provider'      => 'bail|required|in:facebook,google',
            'device_type'   => 'bail|required|in:ios,android',
            'device_id'     => 'bail|required',
            'fcm_token'     => 'bail|nullable',
        ]);

        if($validator->fails()){
            $this->setStatusCode(Res::HTTP_UNPROCESSABLE_ENTITY);
            return $this->respondValidationError('Validation Error.', $validator->errors());
        }

        DB::beginTransaction();
        try {
            /**Social media token validation*/
            if($request->provider == 'facebook'){
                $result = $this->validateFacebookToken($request->token);
                $request->request->add([
                    'username' => $result['data']['user_id'], //user_id is given by facebook
                    'password' => $result['data']['user_id']
                ]);
            }
            if($request->provider == 'google'){
                $result = $this->validateGoogleToken($request->token, $request->device_type);
                $request->request->add([
                    'username' => $result,
                    'password' => $result
                ]);
            }
            /**Social media token validation*/

            // check if user already exists
            $provider = (new Provider)->findByUsername($request);
            if($provider && $provider->deleted_at !== null) {
                $this->setStatusCode(Res::HTTP_BAD_REQUEST);
                return $this->respondWithError('Your account is suspended');
            }
            if(!$provider) {
                $user =  (new User)->createUser($request);
                $provider = (new Provider)->storeProvider($request, $user->id);
            }
            
            // issue passport token
            $this->client = DB::table('oauth_clients')->where('password_client',1)->first();

            $response = $this->issueToken($request, 'password');
            
            $json = (array) json_decode($response->getContent()); 
            
            if(isset($json['error'])){
                $this->setStatusCode(Res::HTTP_UNAUTHORIZED);
                return $this->respondWithUnauthorized($json['message']);
            }
            $user_id = $provider->user->id;
            (new DeviceToken)->storeUserDevice($request, $user_id);

            $user = (new User)->getUserById($user_id);
            $json['user'] = $this->user_transformer->transform($user);
            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($json, 'Logged In successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }

    public function socialLogin($social) {
        if ($social == "facebook" || $social == "google" || $social == "linkedin") {
            return Socialite::driver($social)->stateless()->redirect();
        } else {
            return Socialite::driver($social)->redirect();           
        }
    }

    public function handleProviderCallback(Request $request, $social) {
        if ($social == "facebook" || $social == "google" || $social == "linkedin") {
            $userSocial = Socialite::driver($social)->stateless()->user();
        } else {
            $userSocial = Socialite::driver($social)->user();           
        }
        try {
            if($social== 'facebook') {
                $request->request->add([
                    'gender' => $userSocial->user['gender']     
                ]);
            }

            $request->request->add([
                'provider' => $social,
                'token' => $userSocial->token,
                'name' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'username' => $userSocial->getId(),
                'password' => $userSocial->getId(),
                'image' => $userSocial->getAvatar()
            ]);

            return $this->loginUser($request);
           
        } catch (\Exception $e) {
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            
            return $this->respondWithError($e->getMessage());
        }
    }

    public function loginUser($request) {
        DB::beginTransaction();
        
        try {      
            // check if user already exists
            $provider = (new Provider)->findByUsername($request);
            if($provider && $provider->deleted_at !== null) {
                $this->setStatusCode(Res::HTTP_BAD_REQUEST);
                return $this->respondWithError('Your account is suspended');
            }
            if(!$provider) {
                $user =  (new User)->createUser($request);
                $provider = (new Provider)->storeProvider($request, $user->id);
            }
            // issue passport token
            $this->client = DB::table('oauth_clients')->where('password_client',1)->first();

            $response = $this->issueToken($request, 'password');
            
            $json = (array) json_decode($response->getContent()); 
            
            if(isset($json['error'])){
                $this->setStatusCode(Res::HTTP_UNAUTHORIZED);
                return $this->respondWithUnauthorized($json['message']);
            }
            $json['user'] = $provider->user;
            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);

            return $this->sendSuccessResponse($json, 'Logged In successfully')->cookie('user', $json['user'], 5, '/', null,false, false);
        
        } catch (\Exception $e) {
            DB::rollBack();
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            
            return $this->respondWithError($e->getMessage());
        }
    }

    /** 
        *   @OA\Post(
        *     path="/logout",
        *     tags={"Auth"},
        *     description="logout",
        *     summary="logout",
        *     security= {{"App_Key":"","Bearer_auth":""}},
        *     @OA\RequestBody(
        *         description="User logout",
        *         required=true,
        *          @OA\JsonContent(
        *           type="object",
        *             @OA\Property(
        *              property="fcm_token",
        *              description="fcm_token",
        *              title="fcm_token",
        *              type="string",
        *              ),
        *            ),
        *     ),
        *     @OA\Response(
        *         response=200,
        *         description="logout success",
        *         @OA\JsonContent(
        *             type="object",
        *         ),
        *         @OA\Link(
        *              link="UserLogout",
        *              operationId="LogoutUser",
        *              parameters={
        *                   "fcm_token":"XYZasbhkabdsfkhabvka.."
        *              },
        *          ),
        *     ),
        *     @OA\Response(
        *         response="default",
        *         description="unexpected error",
        *         @OA\JsonContent(
        *             type="object",
        *         ),
        *     ),
        * )
    */
    public function logout(Request $request){
        $accessToken = auth()->user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);

        if($request->fcm_token){
            (new DeviceToken)->deleteByFcmToken($request->fcm_token);
        }

        $accessToken->revoke();

        $this->setStatusCode(Res::HTTP_NO_CONTENT);
        
        return $this->respondNoContent('logged out successfully');
    }

    /** 
        *   @OA\Post(
        *     path="/tokens/refresh",
        *     tags={"Auth"},
        *     description="refresh token",
        *     summary="refresh-token",
        *     security= {{"App_Key":"","Provider":"",}},
        *     @OA\RequestBody(
        *         description="refresh-token",
        *         required=true,
        *          @OA\JsonContent(
        *           type="object",
        *            @OA\Property(property="refresh_token",description="refresh_token",title="refresh_token",type="string",),
        *          ),
        *          @OA\MediaType(
        *             mediaType="multipart/form-data",
        *             @OA\Schema(
        *                 type="object",
        *                 @OA\Property(property="refresh_token",description="refresh token",type="string",),
        *             ),
        *           ),
        *     ),
        *     @OA\Response(
        *         response=200,
        *         description="refresh token success",
        *         @OA\JsonContent(
        *             type="object",
        *         ),
        *         @OA\Link(
        *              link="refreshToken",
        *              operationId="refresh-token",
        *              parameters={
        *                   "refresh_token":"measdasdlcascascyna.asdadasfafasdscas",
        *              },
        *          ),
        *     ),
        *     @OA\Response(
        *         response="default",
        *         description="unexpected error",
        *         @OA\JsonContent(
        *             type="object",
        *         ),
        *     ),
        * )
    */
    public function refreshToken(Request $request) {
        $refresh_token = $request->refresh_token;

        $this->client = DB::table('oauth_clients')->where('password_client',1)->first();

        $response = $this->issueToken($request, 'refresh_token');
        
        $json = (array) json_decode($response->getContent()); 
        
        if(isset($json['error'])){
            $this->setStatusCode(Res::HTTP_UNAUTHORIZED);
            return $this->respondWithUnauthorized('The refresh token is invalid.');
        }

        $this->setStatusCode(Res::HTTP_OK);
        
        return $this->sendSuccessResponse($json, 'token refreshed successfully');
    }
}
