define(['table','form'], function (Table,Form) {
    let Controller = {
        index: function () {
            Table.init = {
                table_elem: 'list',
                tableId: 'list',
                requests:{
                    index_url:'demo.test/index',
                    add_url:'demo.test/add',
                    edit_url:'demo.test/edit',
                    delete_url:'demo.test/delete',
                    recycle_url:'demo.test/recycle',
                    import_url:'demo.test/import',
                    export_url:'demo.test/export',
                    modify_url:'demo.test/modify',

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
                  { field: 'id', title: __('ID'), sort:true,},
                  {field:'cate_id',search: true,title: __('CateId'),selectList:cateIdList,sort:true,templet: Table.templet.tags},
                  {field:'cate_ids',search: true,title: __('CateIds'),selectList:cateIdsList,sort:true,templet: Table.templet.tags},
                  {field:'week',search: 'select',title: __('Week'),filter: 'week',selectList:weekList,sort:true,templet: Table.templet.select},
                  {field:'sexdata',search: 'select',title: __('Sexdata'),filter: 'sexdata',selectList:sexdataList,sort:true,templet: Table.templet.select},
                  {field:'textarea', title: __('Textarea'),align: 'center',sort:'sort'},
                  {field:'image',title: __('Image'),sort:true,templet: Table.templet.image},
                  {field:'images', title: __('Images'),align: 'center',sort:'sort'},
                  {field:'attach_file',title: __('AttachFile'),sort:true,templet: Table.templet.image},
                  {field:'attach_files', title: __('AttachFiles'),align: 'center',sort:'sort'},
                  {field:'keywords', title: __('Keywords'),align: 'center',sort:'sort'},
                  {field:'price', title: __('Price'),align: 'center',sort:'sort'},
                  {field:'startdate', title: __('Startdate'),align: 'center',sort:'sort'},
                  {field:'activitytime', title: __('Activitytime'),align: 'center',sort:'sort'},
                  {field:'timestaptime', title: __('Timestaptime'),align: 'center',sort:'sort'},
                  {field:'year', title: __('Year'),align: 'center',sort:'sort'},
                  {field:'times', title: __('Times'),align: 'center',sort:'sort'},
                  {field:'switch',search: 'select',title: __('Switch'), filter: 'switch', selectList:switchList,sort:true,templet: Table.templet.switch},
                  {field:'open_switch',search: 'select',title: __('OpenSwitch'), filter: 'open_switch', selectList:openSwitchList,sort:true,templet: Table.templet.switch},
                  {field:'teststate',search: 'select',title: __('Teststate'),filter: 'teststate',selectList:teststateList,sort:true,templet: Table.templet.tags},
                  {field:'test2state',search: 'select',title: __('Test2state'),filter: 'test2state',selectList:test2stateList,sort:true,templet: Table.templet.tags},
                  {field:'editor_content', title: __('EditorContent'),align: 'center',sort:'sort'},
                  {field:'description', title: __('Description'),align: 'center',sort:'sort'},
                  {field:'test_color', title: __('TestColor'),align: 'center',sort:'sort'},
                  {field:'status',search: 'select',title: __('Status'),filter: 'status',selectList:statusList,sort:true,templet: Table.templet.select},
                  {
                        minWidth: 250,
                        align: "center",
                        title: __("Operat"),
                        init: Table.init,
                        templet: Table.templet.operat,
                        operat: ["edit", "destroy","delete"]
                    },
                ]],
                done: function(res){
                },
                //
                limits: [10, 15, 20, 25, 50, 100],
                limit: 15,
                page: true
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
                        recycle_url: 'demo.test/recycle',
                        delete_url: 'demo.test/delete',
                        restore_url: 'demo.test/restore',
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
                  { field: 'id', title: __('ID'), sort:true,},
                  {field:'cate_id',search: true,title: __('CateId'),selectList:cateIdList,sort:true,templet: Table.templet.tags},
                  {field:'cate_ids',search: true,title: __('CateIds'),selectList:cateIdsList,sort:true,templet: Table.templet.tags},
                  {field:'week',search: 'select',title: __('Week'),filter: 'week',selectList:weekList,sort:true,templet: Table.templet.select},
                  {field:'sexdata',search: 'select',title: __('Sexdata'),filter: 'sexdata',selectList:sexdataList,sort:true,templet: Table.templet.select},
                  {field:'textarea', title: __('Textarea'),align: 'center',sort:'sort'},
                  {field:'image',title: __('Image'),sort:true,templet: Table.templet.image},
                  {field:'images', title: __('Images'),align: 'center',sort:'sort'},
                  {field:'attach_file',title: __('AttachFile'),sort:true,templet: Table.templet.image},
                  {field:'attach_files', title: __('AttachFiles'),align: 'center',sort:'sort'},
                  {field:'keywords', title: __('Keywords'),align: 'center',sort:'sort'},
                  {field:'price', title: __('Price'),align: 'center',sort:'sort'},
                  {field:'startdate', title: __('Startdate'),align: 'center',sort:'sort'},
                  {field:'activitytime', title: __('Activitytime'),align: 'center',sort:'sort'},
                  {field:'timestaptime', title: __('Timestaptime'),align: 'center',sort:'sort'},
                  {field:'year', title: __('Year'),align: 'center',sort:'sort'},
                  {field:'times', title: __('Times'),align: 'center',sort:'sort'},
                  {field:'switch',search: 'select',title: __('Switch'), filter: 'switch', selectList:switchList,sort:true,templet: Table.templet.switch},
                  {field:'open_switch',search: 'select',title: __('OpenSwitch'), filter: 'open_switch', selectList:openSwitchList,sort:true,templet: Table.templet.switch},
                  {field:'teststate',search: 'select',title: __('Teststate'),filter: 'teststate',selectList:teststateList,sort:true,templet: Table.templet.tags},
                  {field:'test2state',search: 'select',title: __('Test2state'),filter: 'test2state',selectList:test2stateList,sort:true,templet: Table.templet.tags},
                  {field:'editor_content', title: __('EditorContent'),align: 'center',sort:'sort'},
                  {field:'description', title: __('Description'),align: 'center',sort:'sort'},
                  {field:'test_color', title: __('TestColor'),align: 'center',sort:'sort'},
                  {field:'status',search: 'select',title: __('Status'),filter: 'status',selectList:statusList,sort:true,templet: Table.templet.select},
                  {
                        minWidth: 250,
                        align: "center",
                        title: __("Operat"),
                        init: Table.init,
                        templet: Table.templet.operat,
                        operat: ["restore","delete"]
                    },
                ]],
                done: function(res){
                },
                limits: [10, 15, 20, 25, 50, 100],
                limit: 15,
                page: true
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