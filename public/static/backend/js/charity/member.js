define(['table','form'], function (Table,Form) {
    let Controller = {
        index: function () {
            Table.init = {
                table_elem: 'list',
                tableId: 'list',
                requests:{
                    index_url:'charity.member/index',
                    add_url:'charity.member/add',
                    edit_url:'charity.member/edit',
                    destroy_url:'charity.member/destroy',
                    delete_url:'charity.member/delete',
                    recycle_url:'charity.member/recycle',
                    import_url:'charity.member/import',
                    export_url:'charity.member/export',
                    modify_url:'charity.member/modify',

                }
            }
            Table.render({
                elem: '#' + Table.init.table_elem,
                id: Table.init.tableId,
                url: Fun.url(Table.init.requests.index_url),
                init: Table.init,
                toolbar: ['refresh','add','destroy','export','recycle'],
                cols: [[
                    {checkbox: true,},
                    {field: 'id', title: __('ID'), sort:true,search:false},
                    {field:'username', title: __('Username'),align: 'center'},
                    {field:'enterprise', title: __('Enterprise'),align: 'center'},
                    {field:'level_id',  search: 'select',title: __('LevelId'),selectList:levelIdList,sort:true,templet: Table.templet.select},
                    {field:'avatar',title: __('Avatar'),templet: Table.templet.image,search:false},
                    {field:'sort',title: __('Sort'),align: 'center',edit:'text',sort:true,search:false},
                    {field:'description', title: __('Description'),align: 'center',search:false},
                    {field:'content', title: __('Content'),align: 'center',search:false},
                    {field:'create_time',title: __('CreateTime'),align: 'center',timeType:'datetime',dateformat:'yyyy-MM-dd HH:mm:ss',searchdateformat:'yyyy-MM-dd HH:mm:ss',search:'time',sort:true,search:false},
                    {field:'update_time',title: __('UpdateTime'),align: 'center',timeType:'datetime',dateformat:'yyyy-MM-dd HH:mm:ss',searchdateformat:'yyyy-MM-dd HH:mm:ss',search:'time',sort:true,search:false},
                    // {field:'delete_time',title: __('DeleteTime'),align: 'center',timeType:'datetime',dateformat:'yyyy-MM-dd HH:mm:ss',searchdateformat:'yyyy-MM-dd HH:mm:ss',search:'time',templet: Table.templet.time,sort:true},
                    {
                        minWidth: 250,
                        align: "center",
                        title: __("Operat"),
                        init: Table.init,
                        templet: Table.templet.operat,
                        operat: ["edit", "destroy","delete"]
                    },
                ]],
                limits: [10, 15, 20, 25, 50, 100,500],
                limit: 15,
                page: true,
                done: function (res, curr, count) {
                }
            });

            let table = $('#'+Table.init.table_elem);
            Table.api.bindEvent(table);
        },
        add: function () {
            Controller.api.bindevent()
        },
        edit: function () {
            Controller.api.bindevent()
        },
        recycle: function () {
            Table.init = {
                table_elem: 'list',
                tableId: 'list',
                requests: {
                    delete_url:'charity.member/delete',
                    recycle_url:'charity.member/recycle',
                    restore_url:'charity.member/restore',
                    
                },
            };
            Table.render({
                elem: '#' + Table.init.table_elem,
                id: Table.init.tableId,
                url: Fun.url(Table.init.requests.recycle_url),
                init: Table.init,
                toolbar: ['refresh','delete','restore'],
                cols: [[
                    {checkbox: true,},
                    {field: 'id', title: __('ID'), sort:true,},
                    {field:'username', title: __('Username'),align: 'center',sort:true},
                    {field:'enterprise', title: __('Enterprise'),align: 'center',sort:true},
                    {field:'level_id',search: true,title: __('LevelId'),selectList:levelIdList,sort:true,templet: Table.templet.tags},
                    {field:'avatar',title: __('Avatar'),sort:true,templet: Table.templet.image},
                    {field:'description', title: __('Description'),align: 'center',sort:true},
                    {field:'content', title: __('Content'),align: 'center',sort:true},
                    {field:'create_time',title: __('CreateTime'),align: 'center',timeType:'datetime',dateformat:'yyyy-MM-dd HH:mm:ss',searchdateformat:'yyyy-MM-dd HH:mm:ss',search:'time',templet: Table.templet.time,sort:true},
                    {field:'update_time',title: __('UpdateTime'),align: 'center',timeType:'datetime',dateformat:'yyyy-MM-dd HH:mm:ss',searchdateformat:'yyyy-MM-dd HH:mm:ss',search:'time',templet: Table.templet.time,sort:true},
                    {field:'delete_time',title: __('DeleteTime'),align: 'center',timeType:'datetime',dateformat:'yyyy-MM-dd HH:mm:ss',searchdateformat:'yyyy-MM-dd HH:mm:ss',search:'time',templet: Table.templet.time,sort:true},
                    {
                        minWidth: 250,
                        align: "center",
                        title: __("Operat"),
                        init: Table.init,
                        templet: Table.templet.operat,
                        operat: ["restore","delete"]
                    },
                ]],
                limits: [10, 15, 20, 25, 50, 100,500],
                limit: 15,
                page: true,
                done: function (res, curr, count) {
                }
            });
            let table = $('#'+Table.init.table_elem);
            Table.api.bindEvent(table);
        },
        api: {
            bindevent: function () {
                Form.api.bindEvent($('form'))
            }
        }
    };
    return Controller;
});