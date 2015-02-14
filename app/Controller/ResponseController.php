<?php
App::uses('AppController', 'Controller');

class ResponseController extends AppController {
    public $autoRender = true;
    public $autoLayout = true;

    #Modelのロード
    public $uses = array('UserData', 'ThreadData', 'ThreadComment', 'LogicThread');

    # レス確認
    # /response/confirm/1
    public function confirm( $thread_id = null) {

        $comment = $this->request->data['comment'];
        $this->set('comment',   $comment);
        $this->set('thread_id', $thread_id);

        #csrfトークンの生成
    }

    # レス作成
    # /response/exec/1
    public function exec( $thread_id = null) {

        $user_id   = 1;
        $comment   = $this->request->data['comment'];
        $this->LogicThread->create_response( $this, $thread_id, $user_id, $comment );

        #レスしたスレのトップにリダイレクト
        $this->redirect("/detail/$thread_id");
    }
}
