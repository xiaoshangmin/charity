<?php
declare (strict_types = 1);

namespace app\backend\controller\charity;

use think\Request;
use think\App;
use think\facade\View;
use app\backend\model\CharityLevel as CharityLevelModel;
use app\common\annotation\NodeAnnotation;
use app\common\annotation\ControllerAnnotation;

/**
 * @ControllerAnnotation (title="职位表")
 */
class Level extends \app\common\controller\Backend
{
    protected $pageSize = 15;
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->modelClass = new CharityLevelModel();
        View::assign('statusList',$this->modelClass->getStatusList());


    }

    

}

