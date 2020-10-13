<?php
namespace App\Core\DAL;

use App\Core\Helpers\Utilities;
use App\Employee;

use Illuminate\Http\UploadedFile;

class EmployeeRepository extends BaseRepository {

    public function getList($conditions, $columns, $orderBy, $skip, $take)
    {
        $result = Employee::where('is_deleted', '=', 0)->where($conditions);

        if(!is_null($columns))
            $result = $result->select($columns);

        if(!is_null($orderBy))
        {
            $result = $result->orderBy($orderBy->column, $orderBy->dir);
        }

        return [
            'items' => $result->skip($skip)->take($take)->get(),
            'totalCount' => $result->count()
        ];
    }

    public function createEmployee($data)
    {

        return $this->createModel(new Employee($data));
    }


}
