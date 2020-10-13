<?php
namespace App\Core\DAL;

use App\Core\Helpers\Utilities;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Passport;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;


class UserRepository extends BaseRepository {

    public function getList($conditions, $columns, $orderBy, $skip, $take)
    {
        $result = User::where('is_deleted', '=', 0)->where($conditions);

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
    public function createUser(array $data)
    {
        return $this->createModel(new User($data));
    }
}
