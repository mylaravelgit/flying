<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class index extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */

    public function home()
    {
        $webInfo=model('System')->find();
        $viewData=[
            'webInfo'=>$webInfo
        ];
        $this->assign($viewData);
        return view();
    }
    //后台登录
    public function login()
    {
        if (request()->isAjax()){
            $data=[
                'username'=>input('post.username'),
                'password'=>input('post.password')
            ];
            $result=model('Admin')->login($data);
            if ($result==1){
                $this->success('登录成功','admin/index/home');
            }else{
                $this->error($result);
            }
        }
        return view();
    }
    //注册
    public function register()
    {
        if (request()->isAjax()){
            $data=[
                'username'=>input('post.username'),
                'password'=>input('post.password'),
                'conpass'=>input('post.conpass'),
                'nickname'=>input('post.nickname'),
                'email'=>input('post.email'),
            ];
            $result=model('Admin')->register($data);
            if ($result==1){
                $this->success('注册成功','admin/index/login');
            }else{
                $this->error($result);
            }
        }
        return view();
    }




}
