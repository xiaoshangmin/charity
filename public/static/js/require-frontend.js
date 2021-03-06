var BASE_URL = document.scripts[document.scripts.length - 1].src.substring(0, document.scripts[document.scripts.length - 1].src.lastIndexOf('/')+1);
require.config({
    urlArgs: 'v=' + (!Config.site.app_debug ? Config.site.site_version :(new Date().getTime())),
    packages: [
        {
            name: 'moment',
            location: 'plugins/moment',
            main: 'moment'
        }
    ],
    baseUrl: BASE_URL,
    include: [
        'css','treeGrid','tableSelect',
        'treeTable','tableEdit','tableTree',
        'iconPicker','iconFonts',
        'toastr','step-lay','inputTags' ,'xmSelect',
        'timeago','multiSelect','cityPicker',
        'regionCheckBox','timePicker','croppers', 'moment',
        'md5','fun','fu','form','table','upload','addons','Vue'],
    paths: {
        'lang'          : 'empty:',
        'jquery'        : 'plugins/jquery/jquery-3.5.1.min', // jquery
        //layui等组件
        'treeGrid'      : 'plugins/lay-module/treeGrid/treeGrid',
        'tableSelect'   : 'plugins/lay-module/tableSelect/tableSelect',
        'treeTable'     : 'plugins/lay-module/treeTable/treeTable',
        'tableEdit'     : 'plugins/lay-module/tableTree/tableEdit',
        'tableTree'     : 'plugins/lay-module/tableTree/tableTree',
        'iconPicker'    : 'plugins/lay-module/iconPicker/iconPicker',
        'iconFonts'     : 'plugins/lay-module/iconPicker/iconFonts',
        'toastr'        : 'plugins/lay-module/toastr/toastr',//提示框
        'step-lay'      : 'plugins/lay-module/step-lay/step',
        'inputTags'     : 'plugins/lay-module/inputTags/inputTags',
        'timeago'       : 'plugins/lay-module/timeago/timeago',
        'multiSelect'   : 'plugins/lay-module/multiSelect/multiSelect',
        'cityPicker'    : 'plugins/lay-module/cityPicker/city-picker',
        'regionCheckBox': 'plugins/lay-module/regionCheckBox/regionCheckBox',
        'timePicker'    : 'plugins/lay-module/timePicker/timePicker',
        'croppers'      : 'plugins/lay-module/cropper/croppers',
        'xmSelect'      : 'plugins/lay-module/xm-select/xm-select',
        'moment'        : 'plugins/moment/moment',
        'md5'           : 'plugins/lay-module/md5/md5.min', // 后台扩展
        'fun'           : 'js/fun', // api扩展
        'fu'            : 'js/require-fu',
        'form'          : 'js/require-form',
        'table'         : 'js/require-table',
        'upload'        : 'js/require-upload',
        'addons'        : 'js/require-addons',//编辑器以及其他安装的插件
    },
    map: {
        '*': {
            'css': 'plugins/require-css/css.min'
        }
    },
    shim: {
        'cityPicker':{
            deps: ['plugins/lay-module/cityPicker/city-picker-data', 'css!plugins/lay-module/cityPicker/city-picker.css'],
        },
        'inputTags':{
            deps: ['css!plugins/lay-module/inputTags/inputTags.css'],
        },
        'regionCheckBox':{
            deps: ['css!plugins/lay-module/regionCheckBox/regionCheckBox.css'],
        },
        'multiSelect': {
            deps: ['css!plugins/lay-module/multiSelect/multiSelect.css'],
        },
        'timePicker':{
            deps:['css!plugins/lay-module/timePicker/timePicker.css'],
        },
        'step': {
            deps: ['css!plugins/lay-module/step/step.css'],
        },
        'croppers': {
            deps: ['plugins/lay-module/cropper/cropper', 'css!plugins/lay-module/cropper/cropper.css'], exports: "cropper"
        },
    },
    waitSeconds: 30,
    charset: 'utf-8' // 文件编码
});

//初始化控制器对应的JS自动加载
require(["jquery"], function ($) {
    // 配置语言包的路径
    var paths = {};
    paths["lang"] = Config.entrance + 'ajax/lang?callback=define&addons='+Config.addonname+'&controllername=' + Config.controllername;
    paths['frontend/'] = 'frontend/';
    require.config({paths:paths});
    $(function () {
        require(['fun','addons'], function (Fun) {
            $(function () {
                if ('undefined' != typeof Config.autojs && Config.autojs) {
                    console.log(Config.jspath)
                    require([BASE_URL+Config.jspath], function (Controller) {
                        console.log(Config.autojs)
                        if (Controller.hasOwnProperty(Config.actionname)) {
                            Controller[Config.actionname]();
                        } else {
                            console.log('action is not find')
                        }
                    });
                }
            })
        })
    })
});