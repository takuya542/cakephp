<?php

    Router::parseExtensions('json');

    #スレ閲覧
    Router::connect('/',                       array('controller' => 'thread', 'action' => 'index'),  array('pass' => array('page')) );
    Router::connect('/index',                  array('controller' => 'thread', 'action' => 'index'),  array('pass' => array('page')) );
    Router::connect('/pages/:page',            array('controller' => 'thread', 'action' => 'index'),  array('pass' => array('page')) );
    Router::connect('/detail/:thread_id',      array('controller' => 'thread', 'action' => 'detail'), array('pass' => array('thread_id')) );

    # スレ生成
    Router::connect('/create/confirm',         array('controller' => 'create', 'action' => 'confirm'));
    Router::connect('/create/exec',            array('controller' => 'create', 'action' => 'exec'));

    # レス生成
    Router::connect('/response/confirm/:thread_id', array('controller' => 'response', 'action' => 'confirm'), array('pass' => array('thread_id')));
    Router::connect('/response/exec/:thread_id',    array('controller' => 'response', 'action' => 'exec'),    array('pass' => array('thread_id')));

    # ログイン
    Router::connect('/login',          array('controller' => 'fbconnect', 'action' => 'login'));
    Router::connect('/login/callback', array('controller' => 'fbconnect', 'action' => 'callback'));
    Router::connect('/logout',         array('controller' => 'fbconnect', 'action' => 'logout'));

    #Ajax
    Router::connect('/ajax/facebook/albums',             array('controller' => 'ajax', 'action' => 'albums'));
    Router::connect('/ajax/facebook/pictures/:album_id', array('controller' => 'ajax', 'action' => 'pictures'), array('pass' => array('album_id')));

    CakePlugin::routes();
    require CAKE . 'Config' . DS . 'routes.php';
