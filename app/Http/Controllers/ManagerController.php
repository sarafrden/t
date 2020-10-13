<?php

namespace App\Http\Controllers;

use App\Core\Helpers\Utilities;
use App\Core\DAL\ManagerRepository;
use App\Manager;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    private $ManagerRepository;
    public function __construct()
    {
        $this->ManagerRepository = new ManagerRepository(new Manager());
    }

    /**
     * Getting Managers' list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Post(
     *      path="api/Managers/getList",
     *      operationId="getManagersList",
     *      tags={"Managers"},
     *      summary="Get list of Managers",
     *      description="Returns list of Managers",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Manager")
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
        $response = $this->ManagerRepository->getList($conditions, $columns, $sort, $skip, $take);
        return Utilities::wrap($response);
    }

    /**
    * @OA\Get(
    *      path="api/Managers/getById/{id}",
    *      operationId="GetSingleManager",
    *      tags={"Managers"},
    *      summary="Get single Managers",
    *      description="Returns Get single Managers",
    * @OA\Parameter(
    *          name="id",
    *          description="Managers id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/Manager")
    *       ),
    *     )
    */

    public function getById($id)
    {
        $response = $this->ManagerRepository->getById($id);
        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="api/auth/Managers/create",
     *      operationId="Insert Manager",
     *      tags={"Managers"},
     *      summary="Insert new Manager",
     *      description="Returns Manager data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Manager")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Manager")
     *       ),
     *   security={
     *         {
     *             "api_key": {},
     *         }
     *     },
     * )
     */

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|string',
            'img' => 'file|nullable',
            'user_id' => 'required',
        ]);
        if($request->hasFile('img'))
            $data['img'] = Utilities::upload(request()->img, 'Managers');

        $response = $this->ManagerRepository->createManager($data);
        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="api/auth/Managers/{id}/update",
     *      operationId="Update Manager",
     *      tags={"Managers"},
     *      summary="Insert new Manager info",
     *      description="Returns Manager data",
     *  @OA\Parameter(
     *          name="id",
     *          description="Manager id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Manager")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Manager")
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
            'name' => 'string',
            'phone_number' => 'string',
            'email' => 'string',
            'img' => 'file',
            'user_id' => 'nullable',
        ]);

        if($request->hasFile('img'))
            $data['img'] = Utilities::upload(request()->img, 'Managers');

        $response = $this->ManagerRepository->update($id, $data);
        return Utilities::wrap($response);
    }

    /**
    * @OA\Get(
    *      path="api/auth/Managers/{id}/delete",
    *      operationId="DeleteSingleManager",
    *      tags={"Managers"},
    *      summary="Delete single Manager",
    *      description="Returns Deleted",
    * @OA\Parameter(
    *          name="id",
    *          description="Manager id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/Manager")
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
        $response = $this->ManagerRepository->softDelete($id);

        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="api/auth/Managers/{id}/getEmployeeList",
     *      operationId="getManagersEmployeeList",
     *      tags={"Managers"},
     *      summary="Get list of Managers Employee",
     *      description="Returns list of Managers Employee",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Manager")
     *       ),
     *     )
     */
    public function getEmployeeList($id, Request $request)
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
        $response = $this->ManagerRepository->getEmployeeList($conditions, $columns, $sort, $skip, $take, $id);
        return Utilities::wrap($response);
    }


}
