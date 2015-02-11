<?php

    #スレ閲覧
    Router::connect('/',                       array('controller' => 'thread', 'action' => 'index'),  array('pass' => array('page')) );
    Router::connect('/index',                  array('controller' => 'thread', 'action' => 'index'),  array('pass' => array('page')) );
    Router::connect('/pages/:page',            array('controller' => 'thread', 'action' => 'index'),  array('pass' => array('page')) );
    Router::connect('/detail/:thread_id',      array('controller' => 'thread', 'action' => 'detail'), array('pass' => array('thread_id')) );

    # スレ生成
    Router::connect('/create/confirm',         array('controller' => 'create', 'action' => 'create_confirm'));
    Router::connect('/create/exec',            array('controller' => 'create', 'action' => 'create_exec'));

    # レス生成
    Router::connect('/res/confirm/:thread_id', array('controller' => 'response', 'action' => 'res_confirm'), array('pass' => array('thread_id')));
    Router::connect('/res/exec',               array('controller' => 'response', 'action' => 'res_exec'));

    CakePlugin::routes();
    require CAKE . 'Config' . DS . 'routes.php';
