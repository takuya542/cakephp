<?php
App::uses('AppController', 'Controller');

class ThreadController extends AppController {
    public $autoRender = true;
    public $autoLayout = true;

    #Modelのロード
    public $uses = array('UserData', 'ThreadData', 'ThreadComment');


    # セッションのチェック & ユーザオブジェクト生成
    public function beforeFilter() {
    }

    # Top / スレ一覧
    public function index( $page = 1 ) {

        $users    = $this->UserData->find('all');   #setしないとviewで使えない
        $threads  = $this->ThreadData->find('all');
        $comments = $this->ThreadComment->find('all');

        debug($page);
#        debug($users);
#        debug($threads);
#        debug($comments);
    }

    # スレ詳細
    public function detail( $thread_id = null ) {
        debug($thread_id);
    }
}
