<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class admin extends Model
{
    use SoftDelete;
    //登录校检
    public function login($data)
    {
        $validate=new \app\common\validate\Admin();
        if (!$validate->scene('login')->check($data)){
            return $validate->getError();
        }
        $result=$this->where($data)->find();
//        $result = $this->where($data)->find();
        if ($result){
            //判断用户是否可用
            if ($result['status']!=1){
                return '此账户被禁用！';
            }
            $sessionData=[
                'id'=>$result['id'],
                'username'=>$result['username'],
                'is_super'=>$result['is_super']
            ];
            session('admin',$sessionData);
            //1表示有这个用户，也就是用户名和密码正确
            return 1;
        }else{
            return '用户名或者密码错误';
        }
    }

    public function register($data)
    {
        $validate= new \app\common\validate\Admin();
        if (!$validate->scene('register')->check($data)){
            return $validate->getError();
        }
        //allowField(true) 数据库有的字段才会添加
        $result=$this->allowField(true)->save($data);
        if ($result){
//            mailto($data['email'],'注册管理员账户成功','注册管理员账户成功！');
            return 1;
        }else{
            return '注册失败';
        }

    }

    //添加管理员
    public function add($data)
    {
        $validate=new \app\common\validate\Admin();
        if (!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $result=$this->allowField(true)->save($data);
//        $result = $this->where($data)->find();
        if ($result){
            return 1;
        }else{
            return '用户名或者密码错误';
        }
    }

    //编辑管理员
    public function edit($data)
    {
        $validate=new \app\common\validate\Admin();
        if (!$validate->scene('edit')->check($data)){
            return $validate->getError();
        }
        $adminInfo=$this->find($data['id']);
        if ($data['oldpass']!=$adminInfo['password']){
            return '原密码不正确';
        }
        $adminInfo->password=$data['newpass'];
        $adminInfo->nickname=$data['username'];

        $result=$adminInfo->save();
        if ($result){
            return 1;
        }else{
            return '管理员编辑失败';
        }

        return false ;
    }
}
