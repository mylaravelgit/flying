<?php

namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    //
    public function initialize()
    {
//        if (!session('?admin.id')){
//            return $this->redirect('admin/index/login');
//        }else{
            $cates=model('Cate')->order('sort','asc')->select();
        $webInfo=model('System')->find();
            $viewData=[
                'cates'=>$cates,
                'webInfos'=>$webInfo

            ];
            $this->view->share($viewData);
        }
//    }


}