<?php

namespace App;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

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
     *      description="name of the new user",
     *      example="sara"
     * )
     *
     * @var string
     */
    private $name;
     /**
     * @OA\Property(
     *      title="type",
     *      description="type of the new user",
     *      example="admin"
     * )
     *
     * @var string
     */
    private $type;
    /**
     * @OA\Property(
     *      title="phone_number",
     *      description="phone_number of the new user",
     *      example="07707722504"
     * )
     *
     * @var string
     */
    private $phone_number;
    /**
     * @OA\Property(
     *      title="password",
     *      description="Password of the new user",
     *      example="sara1234"
     * )
     *
     * @var string
     */
    private $password;
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
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard = 'user';
    protected $fillable = [
        'name', 'phone_number', 'password',  'isVerified', 'email', 'is_deleted', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function Manager()
    {
        return $this->hasMany(Manager::class);
    }

    public function Employee()
    {
        return $this->hasMany(Employee::class);
    }


}
