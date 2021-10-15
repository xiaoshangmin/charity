<?php

namespace app\common\service;

use app\common\model\{CharityLevel, CharityMember};

class CharityService extends AbstractService
{

    /**
     * 获取职位列表
     *
     * @return void
     */
    public static function getLevelList()
    {
        return CharityLevel::where('status', 1)->hidden(['create_time', 'update_time', 'delete_time', 'sort', 'status'])
            ->order('sort', 'asc')->select();
    }

    public static function getUserList(int $levelId, int $page, int $pageSize)
    {
        return CharityMember::withJoin(['charityLevel' => ['name']])
            ->where('level_id', $levelId)->hidden(['create_time', 'update_time', 'delete_time', 'sort', 'status'])
            ->order('id', 'desc')->page($page, $pageSize)->select();
    }

    public static function countUserByLevelId(int $levelId)
    {
        return CharityMember::where('level_id', $levelId)->count();
    }

    public static function getUserInfo(int $uid)
    {
        return CharityMember::withJoin(['charityLevel' => ['name']])
            ->hidden(['create_time', 'update_time', 'delete_time'])->find($uid);
    }
}
