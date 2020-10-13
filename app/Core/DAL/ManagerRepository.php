<?php
namespace App\Core\DAL;

use App\Core\Helpers\Utilities;
use App\Manager;
use App\Employee;

use Illuminate\Http\UploadedFile;

class ManagerRepository extends BaseRepository {

    public function getList($conditions, $columns, $orderBy, $skip, $take)
    {
        $result = Manager::where('is_deleted', '=', 0)->where($conditions);

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

    public function createManager($data)
    {

        return $this->createModel(new Manager($data));
    }



    public function getEmployeeList($conditions, $columns, $orderBy, $skip, $take, $id)
    {
        $result = Employee::where('manager_id', $id)->where('is_deleted', '=', 0)->where($conditions);

        if(!is_null($columns))
            $result = $result->select($columns);

        if(!is_null($orderBy))
            $result = $result->orderBy($orderBy->column, $orderBy->dir);

        $totalCount = $result->count();
        $items = $result->skip($skip)->take($take)->get();
        return [
            'items' => $items,
            'totalCount' => $totalCount
        ];
    }


}
