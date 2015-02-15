<?php
App::uses('AppController', 'Controller');

class CreateController extends AppController {
    public $autoRender = true;
    public $autoLayout = true;

    #Modelのロード
    public $uses = array('UserData', 'ThreadData', 'ThreadComment', 'LogicThread');

    # スレ立て確認
    public function confirm() {
        $title = $this->request->data['title'];
        if(!$title){
            $this->redirect("/?invalidParams=1");
        }
        $this->set('title', $title);
    }

    # スレ立て
    public function exec() {

        $title   = $this->request->data['title'];
        $user_id = $this->USER['id'];
        if(!$title){
            $this->redirect("/?invalidParams=1");
        }
        $created_thread_id = $this->LogicThread->create_thread( $this, $title, $user_id );

        #トップにリダイレクト
        $this->redirect("/detail/$created_thread_id");
    }

}
