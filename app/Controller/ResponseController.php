<?php
App::uses('AppController', 'Controller');

class ResponseController extends AppController {
    public $autoRender = true;
    public $autoLayout = true;

    #Modelのロード
    public $uses = array('UserData', 'ThreadData', 'ThreadComment');


    # セッションのチェック & ユーザオブジェクト生成 & 未ログインならリダイレクト & postリクエストかチェック
    public function beforeFilter() {

        # methodのチェック
        if ( $this->request->is('get') ) {
            $this->redirect('/');
        }
    }

    # レス確認
    # /response/confirm/1
    public function confirm( $thread_id = null) {

        $comment = $this->request->data['comment'];
        $this->set('comment',   $comment);
        $this->set('thread_id', $thread_id);

        #csrfトークンの生成
        debug($thread_id);
        debug($comment);
    }

    # レス作成
    # /response/exec/1
    public function exec( $thread_id = null) {

        $comment   = $this->request->data['comment'];

        #レスしたスレのトップにリダイレクト
        $this->redirect("/detail/$thread_id");
    }
}
