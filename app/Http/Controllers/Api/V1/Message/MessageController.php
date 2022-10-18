<?php

namespace App\Http\Controllers\Api\V1\Message;

use App\Models\Message;
use Illuminate\Support\Facades\DB;
use \Illuminate\Http\Response as Res;
use App\Http\Requests\Message\MessageRequest;
use App\Http\Controllers\Api\V1\BaseController;

class MessageController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/messages",
     *     tags={"Messages"},
     *     description="Returns user contacts",
     *     summary="Returns user contacts",
     *     security= {{"App_Key":"","Bearer_auth":""}},
     *     @OA\Response(
     *         response=200,
     *         description="user contacts fetched successfully",
     *         @OA\JsonContent(
     *             type="object",
     *         ),
     *         @OA\Link(
     *              link="Message",
     *              operationId="getMessages",
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

    public function getMessages()
    {
        try {
            $messages = (new Message)->getMessages();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($messages, 'user contacts fetched successfully');
        } catch (\Exception $e) {
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     *   @OA\Post(
     *     path="/messages/{user_id}",
     *     tags={"Messages"},
     *     description="Send message",
     *     summary="Send message",
     *     security= {{"App_Key":"","Bearer_auth":""}},
     *     @OA\Parameter(name="user_id", in="path", description="user id", required=true,
     *          @OA\Schema(type="integer",),
     *      ),
     *     @OA\RequestBody(
     *         description="User login",
     *         required=true,
     *          @OA\JsonContent(
     *           type="object",
     *            @OA\Property(property="message",description="message",title="message",type="string",)
     *            ),
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="message",description="message",type="string",)
     *             ),
     *           ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="message sent successfully",
     *         @OA\JsonContent(
     *             type="object",
     *         ),
     *         @OA\Link(
     *              link="Message",
     *              operationId="sendMessage",
     *              parameters={
     *                   "message":"hi! there",
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
    public function sendMessage(MessageRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $message = (new Message)->sendMessage($request->message, (int)$id);

            DB::commit();
            $this->setStatusCode(Res::HTTP_OK);
            return $this->sendSuccessResponse($message, 'message sent successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/messages/{user_id}",
     *     tags={"Messages"},
     *     description="Returns messages of user with matching ID",
     *     summary="Returns messages of user with matching ID",
     *     security= {{"App_Key":"","Bearer_auth":""}},
     *     @OA\Parameter(name="user_id", in="path", description="user id", required=true,
     *          @OA\Schema(type="integer",),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="messages fetched successfully",
     *         @OA\JsonContent(
     *             type="object",
     *         ),
     *         @OA\Link(
     *              link="Message",
     *              operationId="getUserMessage",
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
    public function getUserMessage($id)
    {
        try {
            $messages = (new Message)->getUserMessage((int)$id);
            return $this->sendSuccessResponse($messages, 'messages fetched successfully');
        } catch (\Exception $e) {
            $this->setStatusCode(Res::HTTP_BAD_REQUEST);
            return $this->respondWithError($e->getMessage());
        }
    }
}
