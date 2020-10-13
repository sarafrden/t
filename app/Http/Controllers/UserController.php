<?php

namespace App\Http\Controllers;

use App\Core\Helpers\Utilities;
use App\Core\DAL\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;
use Authy\AuthyApi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


//require_once '/path/to/vendor/autoload.php';

class UserController extends Controller
{
    private $UserRepository;
    public function __construct()
    {
        $this->UserRepository = new UserRepository(new User());
    }

    public function create(Request $request)
    {
        $data = $request->validate([

            'name' => 'required|string|max:255',
            'phone_number' => 'required|numeric|unique:Users',
            'password' => 'required|string|min:8',

        ]);
        $response = $this->UserRepository->createUser($data);
        return Utilities::wrap($response);
    }

    /**
     * updating User credentials
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * updating User credentials
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Post(
     *      path="api/auth/Users/{id}/update",
     *      operationId="Update User",
     *      tags={"Users"},
     *      summary="Insert new User info",
     *      description="Returns User data",
     *  @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *  security={
     *         {
     *             "api_key": {},
     *         }
     *     },
     * )
     */
    public function update($id, Request $request)
    {
        $data = $request->validate([

            'phone_number' => 'required',
            'name' =>'string',
            'passwod' =>'string',

        ]);


        $response = $this->UserRepository->update($id, $data);
        return Utilities::wrap($response);
    }
    /**
     * Getting Users' list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Getting Users' list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Post(
     *      path="api/Users/getList",
     *      operationId="getUsersList",
     *      tags={"Users"},
     *      summary="Get list of Users",
     *      description="Returns list of Users",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *     )
     */
    public function getList(Request $request)
    {
        $request->validate([
            'skip' => 'Integer',
            'take' => 'required|Integer'
        ]);

        $conditions = json_decode($request->filter, true);
        $columns = json_decode($request->columns, true);
        $sort = json_decode($request->sort);
        $skip = $request->skip;
        $take = $request->take;
        $response = $this->UserRepository->getList($conditions, $columns, $sort, $skip, $take);
        return Utilities::wrap($response);
    }

    /**
    * @OA\Get(
    *      path="api/Users/{id}/getById",
    *      operationId="GetSingleUser",
    *      tags={"Users"},
    *      summary="Get single Users",
    *      description="Returns Get single Users",
    * @OA\Parameter(
    *          name="id",
    *          description="Users id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/User")
    *       ),
    *     )
    */
    public function getById($id)
    {
        $response = $this->UserRepository->getById($id);
        return Utilities::wrap($response);
    }


    /**
    * @OA\Get(
    *      path="api/auth/Users/{id}/delete",
    *      operationId="DeleteSingleUser",
    *      tags={"Users"},
    *      summary="Delete single User",
    *      description="Returns Deleted",
    * @OA\Parameter(
    *          name="id",
    *          description="User id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/User")
    *       ),
    *     security={
    *         {
    *             "api_key": {},
    *         }
    *     },
    *     )
    */

    public function delete($id)
    {
        $response = $this->UserRepository->softDelete($id);

        return Utilities::wrap($response);
    }

}
