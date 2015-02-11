<?php
App::uses('AppController', 'Controller');

class CreateController extends AppController {
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

    # スレ立て確認
    # /create/confirm
    public function confirm() {
        $title = $this->request->data['title'];
        $this->set('title', $title);
    }

    # スレ立て
    # /create/exec
    public function exec() {

        $title = $this->request->data['title'];

        #立てたスレのトップにリダイレクト
        $this->redirect('/detail/1');
    }

}
