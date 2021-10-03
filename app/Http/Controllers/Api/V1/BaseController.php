<?php

namespace App\Http\Controllers\Api\V1;

use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Response as Res;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseController extends Controller
{
    /**
        * @OA\Info(
        *   title="Rental now Api Documentation",
        *   version="1.0.0",
        *   termsOfService="http://www.rentalnow.com.au/",
        *   @OA\Contact(
        *     name="Jagdish kunwar",
        *     email="jagdishkunwar002@gmail.com",
        *   ),
        *   @OA\License(
        *      name="Apache 2.0",
        *      url="http://www.apache.org/licenses/LICENSE-2.0.html"
        *   ),
        *    @OA\ExternalDocumentation(
        *     description="Find more",
        *     url="https://github.com/zircote/swagger-php/blob/master/Examples/petstore-3.0/api.php"
        *   ),
        * )
    */
        //base url
    /**
        *   @OA\Server(
        *       url="/api/v1",
        *   ),
    */
        //component>SecurityScheme>app_key
    /**
        * @OA\SecurityScheme(
        *   securityScheme="Bearer_auth",
        *   type="http",
        *   scheme="bearer",
        * ),
        * @OA\SecurityScheme(
        *   securityScheme="App_Key",
        *   type="apiKey",
        *   in="header",
        *   name="X-APP-TOKEN",
        * ),
    */
    /**
     * @var int
     */

    protected $statusCode = Res::HTTP_OK;
    /**
     * @return mixed
     */
    public function getStatusCode() {
        return $this->statusCode;
    }

    /**
     * @param $message
     * @return json response
     */
    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function respondCreated($message, $data=null){
        return $this->respond([
            'status_code' => Res::HTTP_CREATED,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * @param Paginator $paginate
     * @param $data
     * @return mixed
     */
    protected function respondWithPagination(LengthAwarePaginator $paginate, $data, $message){
        // $data = array_merge($data, [
        //     'paginator' => [
        //         'total_count'  => $paginate->total(),
        //         'total_pages' => ceil($paginate->total() / $paginate->perPage()),
        //         'current_page' => $paginate->currentPage(),
        //         'limit' => $paginate->perPage(),
        //     ]
        // ]);
        $paginator = [
                'total_count'  => $paginate->total(),
                'total_pages' => ceil($paginate->total() / $paginate->perPage()),
                'current_page' => $paginate->currentPage(),
                'limit' => $paginate->perPage(),
        ];
        return $this->respond([
            'status_code' => Res::HTTP_OK,
            'message' => $message,
            'data' => $data,
            'paginator' => $paginator
        ]);
    }

    public function respondPagination($data, $headers = []) {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    public function respondNotFound($message = 'Not Found!'){
        return $this->respond([
            'status_code' => Res::HTTP_NOT_FOUND,
            'message' => $message,
            'error' => 'error',
        ]);
    }

    public function respondInternalError($message){
        return $this->respond([
            'error' => 'error',
            'status_code' => Res::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $message,
        ]);
    }

    public function respondValidationError($message, $errors){
        return $this->respond([
            'error' => 'error',
            'status_code' => Res::HTTP_UNPROCESSABLE_ENTITY,
            'message' => $message,
            'data' => $errors
        ]);
    }

    private function respond($data, $headers = []){
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    public function sendSuccessResponse($result, $message){
        return $this->respond([
            'status_code' => Res::HTTP_OK,
            'message' => $message,
            'data'    => $result,
        ]);
    }

    public function respondNoContent($message){
        return $this->respond([
            'error' => 'error',
            'status_code' => Res::HTTP_NO_CONTENT,
            'message' => $message,
        ]);
    }

    public function respondWithError($message){
        return $this->respond([
            'error' => 'error',
            'status_code' => Res::HTTP_BAD_REQUEST,
            'message' => $message,
        ]);
    }

    public function respondWithUnauthorized($message){
        return $this->respond([
            'error' => 'error',
            'status_code' => Res::HTTP_UNAUTHORIZED,
            'message' => $message,
        ]);
    }

    public function respondForbidden($message){
        return $this->respond([
            'error' => 'error',
            'status_code' => Res::HTTP_FORBIDDEN,
            'message' => $message,
        ]);
    }
}
