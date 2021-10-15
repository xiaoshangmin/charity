<?php

namespace app\common\model;

use think\model\concern\SoftDelete;

class CharityMember extends BaseModel
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    public function charityLevel()
    {
        return $this->hasOne(CharityLevel::class, 'id', 'level_id');
    }
}
