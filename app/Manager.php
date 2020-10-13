<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Manager",
 *     description="Manager model",
 *     @OA\Xml(
 *         name="Manager"
 *     )
 * )
 */
class Manager extends Model
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;
    /**
     * @OA\Property(
     *      title="name",
     *      description="Manager name",
     *      example="Sara"
     * )
     *
     * @var string
     */
    private $name;
    /**
     * @OA\Property(
     *      title="phone",
     *      description="Manager phone",
     *      example="0770*******"
     * )
     *
     * @var string
     */
    private $phone_number;
    /**
     * @OA\Property(
     *      title="img",
     *      description="Manager picture",
     *      example="img"
     * )
     *
     * @var string
     */
    private $img;
    /**
     * @OA\Property(
     *      title="email",
     *      description="email of the new user",
     *      example="sara@gmail.com"
     * )
     *
     * @var string
     */
    private $email;

    protected $fillable = [


        'name',
        'img',
        'user_id',
        'is_deleted',
        'email',
        'phone_number',



    ];
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function Employee()
    {
        return $this->hasMany(Employee::class);
    }
}
