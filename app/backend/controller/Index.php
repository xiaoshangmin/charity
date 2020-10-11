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
namespace app\backend\controller;
use app\backend\model\AuthRule;
use app\backend\service\AuthService;
use app\common\controller\Backend;
use think\facade\Db;
use think\facade\View;
use think\facade\Cache;
class Index extends Backend{

    protected $layout='';
    /**
     * @return string
     * @throws \Exception
     * 首页
     */
    public function index(){
        $menulsit = [];
//        $menulsit = Cache::get('adminmenushtml' .session('admin.id'));
        if (!$menulsit) {
            $cate = AuthRule::where('menu_status', 1)
                ->where('type',1)
                ->where('status',1)
                ->order('sort asc')->select()->toArray();
            $menulsit = (new AuthService())->menuhtml($cate,false);
            cache('adminmenushtml' . session('admin.id'), $menulsit, ['expire' => 3600]);
        }
        View::assign('menulist',$menulsit);
        return view();
    }

    /**
     * @return \think\response\View
     */
    public function console(){
        $version = Db::query('SELECT VERSION() AS ver');
        $config = Cache::get('main_config');
        if(!$config){
            $config  = [
                'url'             => $_SERVER['HTTP_HOST'],
                'document_root'   => $_SERVER['DOCUMENT_ROOT'],
                'document_protocol'   => $_SERVER['SERVER_PROTOCOL'],
                'server_os'       => PHP_OS,
                'server_port'     => $_SERVER['SERVER_PORT'],
                'server_ip'       => $_SERVER['REMOTE_ADDR'],
                'server_soft'     => $_SERVER['SERVER_SOFTWARE'],
                'server_file'     => $_SERVER['SCRIPT_FILENAME'],
                'php_version'     => PHP_VERSION,
                'mysql_version'   => $version[0]['ver'],
                'max_upload_size' => ini_get('upload_max_filesize'),
            ];
            Cache::set('main_config',$config,3600);
        }
        View::assign('config', $config);
        return view();
    }

    /**
     * 退出登录
     */
    public function logout()
    {

        (new AuthService())->logout();
        $this->success(lang('Logout success'), __u('login/index'));
    }


}