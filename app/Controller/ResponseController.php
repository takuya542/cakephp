<?php
App::uses('AppController', 'Controller');

class ResponseController extends AppController {
    public $autoRender = true;
    public $autoLayout = true;

    #Modelのロード
    public $uses = array('UserData', 'ThreadData', 'ThreadComment');


    # セッションのチェック & ユーザオブジェクト生成 & 未ログインならリダイレクト
    public function beforeFilter() {
    }

    # レス確認
    # /response/confirm/1
    public function confirm( $thread_id = null) {

        #csrfトークンの生成
        debug($thread_id);
    }

    # レス作成
    # /response/exec
    public function exec() {
        if ( $this->request->is('get') ) {
            $this->redirect('/');
        }

        $thread_id = $this->request->data['Post']['thread_id'];
        $user_id   = $this->request->data['Post']['user_id'];
        $comment   = $this->request->data['Post']['comment'];

        #レスしたスレのトップにリダイレクト
        $this->redirect('/thread/detail?thread_id=1');
    }
}
