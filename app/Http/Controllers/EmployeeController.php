<?php

namespace App\Http\Controllers;

use App\Core\Helpers\Utilities;
use App\Core\DAL\EmployeeRepository;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    private $EmployeeRepository;
    public function __construct()
    {
        $this->EmployeeRepository = new EmployeeRepository(new Employee());
    }

    /**
     * Getting Employees' list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Post(
     *      path="api/Employees/getList",
     *      operationId="getEmployeesList",
     *      tags={"Employees"},
     *      summary="Get list of Employees",
     *      description="Returns list of Employees",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Employee")
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
        $response = $this->EmployeeRepository->getList($conditions, $columns, $sort, $skip, $take);
        return Utilities::wrap($response);
    }

    /**
    * @OA\Get(
    *      path="api/Employees/getById/{id}",
    *      operationId="GetSingleEmployee",
    *      tags={"Employees"},
    *      summary="Get single Employees",
    *      description="Returns Get single Employees",
    * @OA\Parameter(
    *          name="id",
    *          description="Employees id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/Employee")
    *       ),
    *     )
    */

    public function getById($id)
    {
        $response = $this->EmployeeRepository->getById($id);
        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="api/auth/Employees/create",
     *      operationId="Insert Employee",
     *      tags={"Employees"},
     *      summary="Insert new Employee",
     *      description="Returns Employee data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Employee")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Employee")
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
            'manager_id' => 'nullable',
        ]);
        if($request->hasFile('img'))
            $data['img'] = Utilities::upload(request()->img, 'Employees');

        $response = $this->EmployeeRepository->createEmployee($data);
        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="api/auth/Employees/{id}/update",
     *      operationId="Update Employee",
     *      tags={"Employees"},
     *      summary="Insert new Employee info",
     *      description="Returns Employee data",
     *  @OA\Parameter(
     *          name="id",
     *          description="Employee id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Employee")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Employee")
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
            'manager_id' => 'nullable',
        ]);

        if($request->hasFile('img'))
            $data['img'] = Utilities::upload(request()->img, 'Employees');

        $response = $this->EmployeeRepository->update($id, $data);
        return Utilities::wrap($response);
    }

    /**
    * @OA\Get(
    *      path="api/auth/Employees/{id}/delete",
    *      operationId="DeleteSingleEmployee",
    *      tags={"Employees"},
    *      summary="Delete single Employee",
    *      description="Returns Deleted",
    * @OA\Parameter(
    *          name="id",
    *          description="Employee id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/Employee")
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
        $response = $this->EmployeeRepository->softDelete($id);

        return Utilities::wrap($response);
    }


}
