<?php

/**
 * FunAadmin
 * ============================================================================
 * 版权所有 2017-2028 FunAadmin，并保留所有权利。
 * 网站地址: https://www.FunAadmin.cn
 * ----------------------------------------------------------------------------
 * 采用最新Thinkphp6实现
 * ============================================================================
 * Author: yuege
 * Date: 2017/8/2
 */
namespace app\backend\model;

class Member extends BackendModel {

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
    public function userGroup(){

        return  $this->belongsTo('UserGroup','group_id','id');
    }
    public function memberLevel()
    {
        return $this->belongsTo('MemberLevel', 'level_id', 'id', [], 'LEFT');
    }

}
