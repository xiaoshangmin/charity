<?php
/**
 * FunAdmin
 * ============================================================================
 * 版权所有 2017-2028 FunAdmin，并保留所有权利。
 * 网站地址: http://www.FunAdmin.com
 * ----------------------------------------------------------------------------
 * 采用最新Thinkphp6实现
 * ============================================================================
 * Author: yuege
 * Date: 2017/8/2
 */
namespace app\frontend\controller;

use app\common\controller\Frontend;
use think\App;
use think\captcha\facade\Captcha;
use think\facade\Console;
use think\facade\Db;
class Index extends Frontend {
    protected $layout='';
    public function __construct(App $app)
    {
        parent::__construct($app);
    }
    public function index(){
        // header("Location:/2gZlbJX5TN.php");
        // return view();
        return 403;
    }
    /**
     * @return \think\Response
     * 验证码
     */
    public function verify()
    {
        return Captcha::create();
    }

}