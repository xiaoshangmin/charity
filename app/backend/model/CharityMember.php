<?php
declare (strict_types = 1);

namespace app\backend\model;
use app\common\model\BaseModel;
use think\Model;
use think\model\concern\SoftDelete;
/**
 * @mixin \think\Model
 */
class CharityMember extends BaseModel
{
    use SoftDelete;
    protected $defaultSoftDelete =0;
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
    public function charityLevel()
    {
        return $this->hasOne('CharityLevel', 'id','level_id');
    }


    public function getLevelIdList()
    {
        return CharityLevel::column("name", 'id');
    }

}
