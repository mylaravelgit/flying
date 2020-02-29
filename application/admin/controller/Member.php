<?php

namespace app\admin\controller;


class Member extends Base
{


    //会员列表
    public function all()
    {
        $where=[];
        $catename=null;
        if (input('?id')){
            $where=[
                'cate_id'=>input('id')
            ];
            $member=model('Member')->where($where)->paginate(10);
            $catename=model('Cate')->where('id',input('id'))->value('catename');
        }else{
            $member=model('Member')->order('create_time')->paginate(10);
        }

        //定义一个模板数据变量
        $viewData=[
            'members'=>$member,
            'catename'=>$catename,
        ];
        //渲染视图
        $this->assign($viewData);
        return view();
    }

    //会员添加
    public function add()
    {
        if (request()->isAjax()){
            $data=[
                'username'=>input('post.username'),
                'address'=>input('post.address'),
                'phone'=>input('post.phone'),
                'earphone'=>input('post.earphone'),
                'comes'=>input('post.comes'),
                'company'=>input('post.company'),
                'cate_id'=>input('post.cateid'),
                'status'=>input('post.status'),
                'followDate'=>input('post.followDate'),
                'content'=>input('post.content'),
            ];
            if ($data['followDate']){
                $data['followDate']=strtotime($data['followDate']);

            }
            $result=model('Member')->add($data);
            if ($result==1){
                $this->success('会员添加成功','admin/member/all');
            }else{
                $this->error($result);
            }
        }
        return view();
    }

    public function edit()
    {
        if (request()->isAjax()){
            $data=[
                'id'=>input('post.id'),
                'username'=>input('post.username'),
                'address'=>input('post.address'),
                'phone'=>input('post.phone'),
                'earphone'=>input('post.earphone'),
                'comes'=>input('post.comes'),
                'company'=>input('post.company'),
                'cate_id'=>input('post.cateid'),
                'status'=>input('post.status'),
                'followDate'=>input('post.followDate'),
                'content'=>input('post.content'),
            ];
            if ($data['followDate']) {
                $data['followDate'] = strtotime($data['followDate']);

            }
            $result=model('Member')->edit($data);
            if ($result==1){
                $this->success('会员修改成功','admin/member/all');
            }else{
                $this->error($result);
            }
        }
        $memerInfo=model('Member')->find(input('id'));
        $viewData=[
            'memberInfo'=>$memerInfo
        ];
        $this->assign($viewData);
        return view();
    }

    //会员删除
    public function del()
    {
        $memberInfo=model('Member')->with('comments')->find(input('post.id'));
        $result=$memberInfo->together('comments')->delete();
        if ($result){
            $this->success('会员删除成功！','admin/member/all');
        }else{
            $this->error('会员删除失败！');
        }
    }
}
