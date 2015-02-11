<?php
App::uses('AppController', 'Controller');

class CakeController extends AppController {
    public $autoRender = true;
    public $autoLayout = true;

    #Modelのロード
    public $uses = array('UserData', 'ThreadData', 'ThreadComment');

    # http://ec2-54-148-210-220.us-west-2.compute.amazonaws.com/cake
    # http://ec2-54-148-210-220.us-west-2.compute.amazonaws.com/cake/index
    public function index() {
        $users    = $this->UserData->find('all');   #setしないとviewで使えない
        $threads  = $this->ThreadData->find('all');
        $comments = $this->ThreadComment->find('all');

        debug($users);
        debug($threads);
        debug($comments);
        # $this->layout = 'cutsom_layout'; # if you want to change layout template
    }

    # スレ詳細
    public function thread_list() {
    }


    # スレ詳細
    public function thread() {
    }
}
