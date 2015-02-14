<?php
App::uses('AppController', 'Controller');

class CreateController extends AppController {
    public $autoRender = true;
    public $autoLayout = true;

    #Modelのロード
    public $uses = array('UserData', 'ThreadData', 'ThreadComment', 'LogicThread');
#    public $components = array(
#        'Security' => array(
#            'csrfExpires' => '+1 hour'
#        )
#    );


    # スレ立て確認
    # /create/confirm
    public function confirm() {
        $title = $this->request->data['title'];
        $this->set('title', $title);
    }

    # スレ立て
    # /create/exec
    public function exec() {

        $title          = $this->request->data['title'];
        $user_id        = 1;

        $created_thread_id = $this->LogicThread->create_thread( $this, $title, $user_id );

        #トップにリダイレクト
        $this->redirect("/detail/$created_thread_id");
    }

}
