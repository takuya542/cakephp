<?php
App::uses('AppController', 'Controller');

class CreateController extends AppController {
    public $autoRender = true;
    public $autoLayout = true;

    #Modelのロード
    public $uses = array('UserData', 'ThreadData', 'ThreadComment');


    # セッションのチェック & ユーザオブジェクト生成 & 未ログインならリダイレクト
    public function beforeFilter() {
    }

    # スレ立て
    public function confirm() {
        #csrfトークンの生成
    }

    # スレ立て
    public function exec() {
        if ( $this->request->is('get') ) {
            $this->redirect('/');
        }

        $user_id = $this->request->data['Post']['user_id'];
        $title   = $this->request->data['Post']['title'];

        #立てたスレのトップにリダイレクト
        $this->redirect('/detail/1');
    }

}
