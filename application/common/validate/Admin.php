<?php


namespace app\common\validate;


use think\Validate;

class Admin extends Validate
{
    protected $rule=[
        'username|管理员账户'=>'require|unique:admin',
        'password|密码'=>'require',
        'oldpass|原密码'=>'require',
        'newpass|新密码'=>'require',
        'conpass|确认密码'=>'require|confirm:password',

        'code|验证码'=>'require'
    ];
    //登录验证
    public function sceneLogin()
    {
        return $this->only(['username','password'])->remove('username','unique');
    }
    //注册验证
    public function sceneRegister()
    {
        return  $this->only(['username','password','conpass'])
            ->append('username','unique:admin');
    }

    //添加管理员
    public function sceneAdd()
    {
        return $this->only(['username','password','conpass'])
            ->append('username','unique:admin');
    }
    //编辑管理员场景
    public function sceneEdit()
    {
        return $this->only(['oldpass','newpass','username']);
    }

}