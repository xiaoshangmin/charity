<?php

namespace app\api\controller\v1;

use think\facade\Request;
use fun\auth\Api;
use fun\auth\validate\ValidataBase;
use app\common\service\CharityService;

class Charity extends Api
{
    /**
     * 不需要鉴权方法
     * index、save不需要鉴权
     * ['index','save']
     * 所有方法都不需要鉴权
     * [*]
     */
    protected $noAuth = ['*'];

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function level()
    {
        $levelList = CharityService::getLevelList();
        $this->success('ok', ['list' => $levelList]);
    }

    public function userList()
    {
        $id = $this->request->post('id');
        $p = $this->request->post('page', 1);
        $ps = $this->request->post('pageSize', 10);
        $userList  = [];
        $count = CharityService::countUserByLevelId($id);
        if ($count) {
            $userList = CharityService::getUserList($id, $p, $ps);
        }
        $this->success('ok', ['list' => $userList, 'totalPage' => ceil($count / $ps)]);
    }

    public function userDetail(int $uid)
    {
        $userInfo = CharityService::getUserInfo($uid);
        $this->success('ok', $userInfo);
    }
}
