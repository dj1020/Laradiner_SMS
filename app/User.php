<?php

namespace App;

use App\Sms\SmsCourierInterface;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function sms()
    {
        return $this->hasMany(\App\Messages::class);
    }

    // 挑戰 4：如果我不想使用 Event 系統來發簡訊的話怎麼辦？
    // Solution: 關注點分離，解耦合，Decoupling Handler，把傳 SMS 的
    //           處理程序移到別的 class 裡，做為獨立的 service。
    public function sendSms(SmsCourierInterface $courier, $message, $destPhone)
    {
        // 挑戰 1：有沒有什麼寫法是可以換簡訊平台卻不需要修改這一段已經寫好的 Production Code？
        // Solution 2: 提取 SmsCourierInterface 透過 Dependency Injection 注入，
        //             可利用 Laravel 的 constructor typehint 和 service provider
        $courier->sendTextMessage([
            'to' => $destPhone,
            'message' => $message
        ]);

        $this->sms()->create([
            'to' => $destPhone,
            'message' => $message
        ]);
    }
}
