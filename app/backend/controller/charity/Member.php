<?php
declare (strict_types = 1);

namespace app\backend\controller\charity;

use think\Request;
use think\App;
use think\facade\View;
use app\backend\model\CharityMember as CharityMemberModel;
use app\common\annotation\NodeAnnotation;
use app\common\annotation\ControllerAnnotation;

/**
 * @ControllerAnnotation (title="Member")
 */
class Member extends \app\common\controller\Backend
{
    protected $pageSize = 15;
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->modelClass = new CharityMemberModel(); 
        View::assign('levelIdList',$this->modelClass->getLevelIdList());


    }

    /**
    * @NodeAnnotation(title="List")
    */
    public function index()
    {
        $this->relationSearch = true;
        if ($this->request->isAjax()) {
            if ($this->request->param('selectFields')) {
                $this->selectList();
            }
            list($this->page, $this->pageSize,$sort,$where) = $this->buildParames();
            $list = $this->modelClass
                ->where($where)
                ->withJoin(['charityLevel'])
                ->order($sort)
                ->paginate([
                    'list_rows'=> $this->pageSize,
                    'page' => $this->page,
                ]);
            $result = ['code' => 0, 'msg' => lang('Get Data Success'), 'data' => $list->items(), 'count' =>$list->total()];
            return json($result);
        }
        return view();
    }

    /**
    * @NodeAnnotation(title="Recycle")
    */
    public function recycle()
    {
        $this->relationSearch = true;
        if ($this->request->isAjax()) {
            if ($this->request->param('selectFields')) {
                $this->selectList();
            }
            list($this->page, $this->pageSize,$sort,$where) = $this->buildParames();
            $list = $this->modelClass->onlyTrashed()
                ->where($where)
                ->withJoin(['charityLevel'])
                ->order($sort)
                ->paginate([
                    'list_rows'=> $this->pageSize,
                    'page' => $this->page,
                ]);
            $result = ['code' => 0, 'msg' => lang('Get Data Success'), 'data' => $list->items(), 'count' =>$list->total()];
            return json($result);
        }
        return view('index');
    }

}

