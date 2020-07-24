<?php
/**
 * SpeedAdmin
 * ============================================================================
 * 版权所有 2018-2027 SpeedAdmin，并保留所有权利。
 * 网站地址: https://www.SpeedAdmin.cn
 * ----------------------------------------------------------------------------
 * 采用最新Thinkphp6实现
 * ============================================================================
 * Author: yuege
 * Date: 2019/9/21
 */

namespace app\common\controller;
use app\backend\service\AuthService;
use app\common\traits\Jump;
use speed\addons\Controller;
use think\App;
use think\facade\Cookie;
use think\facade\Lang;
use think\facade\Config;
use think\facade\View;

class AddonsController extends Controller
{
    use Jump;

    /**
     * @var
     * 后台入口
     */
    protected $entrance;

    /**
     * @var
     * 模型
     */
    protected $modelClass;
    /**
     * @var
     * 页面大小
     */
    protected $pageSize;
    /**
     * @var
     * 页数
     */
    protected $page;

    /**
     * 模板布局, false取消
     * @var string|bool
     */
    protected $layout = 'layout/main';

    /**
     * 快速搜索时执行查找的字段
     */
    protected $searchFields = 'id';
    /**
     * 允许修改的字段
     */
    protected $allowModifyFields = [
        'status',
        'title',
        'auth_open'
    ];

    /**
     * 是否是关联查询
     */
    protected $relationSearch = false;

    public function __construct(App $app)
    {
        parent::__construct($app);
        if(!(new AuthService())->isLogin()){
            $this->redirect(url('/'));
        }
        //过滤参数
        $this->request->filter('trim,strip_tags,htmlspecialchars');
        $this->pageSize = input('limit', 15);
        //加载语言包
        $this->loadlang(strtolower($this->controller));
    }

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->entrance = config('entrance.backendEntrance');
        [$modulename, $controllername, $actionname] = [$this->module, $this->controller, $this->action];
        $controllername = str_replace('\\','.',$controllername);
        $controllers = explode('.', $controllername);
        $jsname = '';
        foreach ($controllers as $vo) {
            empty($jsname) ? $jsname = parse_name($vo) : $jsname .= '/' . parse_name($vo);
        }
        $autojs = file_exists(app()->getRootPath()."public".DS."static".'addons'.DS."{$this->addon}/
        {$modulename}".DS."js".DS."{$jsname}.js") ? true : false;
        $jspath ="addons/{$this->addon}/{$modulename}/js/{$jsname}.js";
        $auth = new \app\backend\service\AuthService();
        $authNode = $auth->nodeList();
        $data = [
            'entrance'    => $this->entrance,//入口
            'modulename'    => $modulename,
            'addonname'    => $this->addon,
            'moduleurl'    => rtrim(url("/{$modulename}", [], false), '/'),
            'controllername'       => parse_name($controllername),
            'actionname'           => parse_name($actionname),
            'requesturl'          => parse_name("addons/{$this->addon}/{$modulename}/{$controllername}/{$actionname}"),
            'jspath' => "{$jspath}",
            'autojs'           => $autojs,
            'authNode'           => $authNode,
            'superAdmin'           => session('admin.id')==1?1:0,
            'lang'           =>  strip_tags( Lang::getLangset()),
        ];
        View::assign($data);
    }

    //自动加载语言
    protected function loadlang($name)
    {
        $lang = Cookie::get('think_lang');
        Lang::load([
            $this->addon_path.$this->addon.DS.$this->module.DS . 'lang' . DS . $lang . DS . str_replace('.', '/', $name) . '.php'
        ]);
    }

    /**
     * 组合参数
     * @param null $searchfields
     * @param null $relationSearch
     * @return array
     */
    protected function buildParames($searchfields=null,$relationSearch=null)
    {
        $searchfields = is_null($searchfields) ? $this->searchFields : $searchfields;
        $relationSearch = is_null($relationSearch) ? $this->relationSearch : $relationSearch;
        $search = $this->request->get("search", '');
        $get = $this->request->get();
        $page = isset($get['page']) && !empty($get['page']) ? $get['page'] : 1;
        $limit = isset($get['limit']) && !empty($get['limit']) ? $get['limit'] : 15;
        $filters = isset($get['filter']) && !empty($get['filter']) ? $get['filter'] : '{}';
        $ops = isset($get['op']) && !empty($get['op']) ? $get['op'] : '{}';
        $sort = $this->request->get("sort", !empty($this->modelClass) && $this->modelClass->getPk() ? $this->modelClass->getPk() : 'id');
        $order = $this->request->get("order", "DESC");
        $filters = json_decode($filters, true);
        $ops = json_decode($ops, true);
        $tableName = '';
        if ($relationSearch) {
            if (!empty($this->modelClass)) {
                $name = parse_name(basename(str_replace('\\', '/', get_class($this->modelClass))));
                $name = $this->modelClass->getTable();
                $tableName = $name . '.';
            }
            $sortArr = explode(',', $sort);
            foreach ($sortArr as $index => & $item) {
                $item = stripos($item, ".") === false ? $tableName . trim($item) : $item;
            }
            unset($item);
            $sort= implode(',', $sortArr);
        }else{
            $sort = ["$sort"=>$order];
        }
        $where = [];
        if ($search) {
            $searcharr = is_array($searchfields) ? $searchfields : explode(',', $searchfields);
            foreach ($searcharr as $k => &$v) {
                $v = stripos($v, ".") === false ? $tableName . $v : $v;
            }
            unset($v);
            $where[] = [implode("|", $searcharr), "LIKE", "%{$search}%"];
        }
        foreach ($filters as $key => $val) {
            $op = isset($ops[$key]) && !empty($ops[$key]) ? $ops[$key] : '%*%';
            switch (strtolower($op)) {
                case '=':
                    $where[] = [$key, '=', $val];
                    break;
                case '%*%':
                    $where[] = [$key, 'LIKE', "%{$val}%"];
                    break;
                case '*%':
                    $where[] = [$key, 'LIKE', "{$val}%"];
                    break;
                case '%*':
                    $where[] = [$key, 'LIKE', "%{$val}"];
                    break;
                case 'BETWEEN':
                case 'NOT BETWEEN':
                    $arr = array_slice(explode(',', $val), 0, 2);
                    if (stripos($val, ',') === false || !array_filter($arr)) {
                        continue 2;
                    }
                    //当出现一边为空时改变操作符
                    if ($arr[0] === '') {
                        $op = $op == 'BETWEEN' ? '<=' : '>';
                        $arr = $arr[1];
                    } elseif ($arr[1] === '') {
                        $op = $op == 'BETWEEN' ? '>=' : '<';
                        $arr = $arr[0];
                    }
                    $where[] = [$k, $op, $arr];
                    break;
                case 'range':
                    [$beginTime, $endTime] = explode(' - ', $val);
                    $where[] = [$key, '>=', strtotime($beginTime)];
                    $where[] = [$key, '<=', strtotime($endTime)];
                    break;
                case 'NOT RANGE':
                    $val = str_replace(' - ', ',', $val);
                    $arr = array_slice(explode(',', $val), 0, 2);
                    if (stripos($val, ',') === false || !array_filter($arr)) {
                        continue 2;
                    }
                    //当出现一边为空时改变操作符
                    if ($arr[0] === '') {
                        $op = $op == 'RANGE' ? '<=' : '>';
                        $arr = $arr[1];
                    } elseif ($arr[1] === '') {
                        $op = $op == 'RANGE' ? '>=' : '<';
                        $arr = $arr[0];
                    }
                    $where[] = [$k, str_replace('RANGE', 'BETWEEN', $op) . ' time', $arr];
                    break;
                case 'NULL':
                case 'IS NULL':
                case 'NOT NULL':
                case 'IS NOT NULL':
                    $where[] = [$k, strtolower(str_replace('IS ', '', $op))];
                    break;
                default:
                    $where[] = [$key, $op, "%{$val}%"];
            }
        }
        return [$page, $limit,$sort,$where];
    }


    /**
     * 刷新Token
     */
    protected function token()
    {
        $check = $this->request->checkToken('__token__', $this->request->param());
        if (false === $check) {
            $this->error(lang('Token verification error'), '', ['__token__' => $this->request->buildToken()]);
        }
        //刷新Token
        $this->request->buildToken();
    }





}