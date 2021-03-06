<?php

namespace app\admin\controller;

use think\Controller;

class Admin extends Base
{
    public function add()
    {

        if (request()->isAjax()){
            $data=[
                'username'=>input('post.username'),
                'password'=>input('post.password'),
                'conpass'=>input('post.conpass'),

            ];
            $result=model('Admin')->add($data);
            if ($result==1){
                $this->success('管理员添加成功','admin/admin/all');
            }else{
                $this->error($result);
            }
        }
        return view();
    }
    public function all()
    {
        $adminInfo=model('Admin')
//            ->order(['is_super'=>'desc','status'=>'desc'])
            ->paginate(10);
        $viewData=[
            'admins'=>$adminInfo,
        ];
        $this->assign($viewData);
        return view();
    }
    public function edit()
    {

        if (request()->isAjax()){
            $data=[
                'id'=>input('post.id'),
                'oldpass'=>input('post.oldpass'),
                'newpass'=>input('post.newpass'),
                'username'=>input('post.username'),
            ];
            $result=model('Admin')->edit($data);
            if ($result==1){
                $this->success('管理员修改成功','admin/admin/all');
            }else{
                $this->error($result);
            }
        }
        $adminInfo=model('Admin')->find(input('id'));
        $viewData=[
            'adminInfo'=>$adminInfo,
        ];
        $this->assign($viewData);
        return view();
    }
    //状态操作
    public function status()
    {
        $data=[
            'id'=>input('post.id'),
            'status'=>input('post.status')?0:1,
        ];
        $adminInfo=model('Admin')->find($data['id']);
        $adminInfo->status=$data['status'];
        $result=$adminInfo->save();
        if ($result){
            $this->success('操作成功','admin/admin/all');
        }else{
            $this->error('操作失败');
        }
    }
    //删除
    public function del()
    {
        $adminInfo=model('Admin')->find(input('post.id'));
        $result=$adminInfo->delete();
        if ($result){
            $this->success('删除成功','admin/admin/all');
        }else{
            $this->error('删除失败！');
        }
    }
}
