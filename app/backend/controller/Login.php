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
use app\backend\service\AuthService;
use app\common\controller\Backend;
use Exception;
use fun\helper\SignHelper;
use fun\helper\StringHelper;
use think\exception\ValidateException;

class Login extends Backend {

    protected $layout='';
    public function index(){
        StringHelper::randomNum();
        if (!$this->request->isPost()) {
            $admin= session('admin');
            $admin_sign= session('admin.token') == SignHelper::authSign($admin) ? $admin['id'] : 0;
            // 签名验证是否存在
            if ($admin && $admin_sign) {
                $this->redirect(__u('index/index'));
            }
            $view = ['loginbg'=> "/static/backend/images/admin-bg.jpg"];
            return view('',$view);

        } else {
            $data  = $this->request->post() ;
            $username = $this->request->post('username', '', 'fun\helper\StringHelper::filterWords');
            $password = $this->request->post('password', '', 'fun\helper\StringHelper::filterWords');
            $rememberMe = $this->request->post('rememberMe');
            $rule = [
                "captcha|验证码" => 'require|captcha',
                "username|用户名" => 'require',
                "password|密码" => 'require',
            ];
            $this->validate($data, $rule);
            // 用户信息验证
            try {
                $auth = new AuthService();
                $auth->checkLogin($username, $password, $rememberMe);
            } catch (Exception $e) {
                 $this->error(lang('Login Failed')."：{$e->getMessage()}",'',['token'=>$this->token()]);
            }
            $this->success(lang('Login Success').'...',__u('index/index'));
        }
    }
    public function verify()
    {
        return parent::verify(); // TODO: Change the autogenerated stub
    }

}