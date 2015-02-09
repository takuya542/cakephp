<?php
App::uses('AppController', 'Controller');

class CakeController extends AppController {
    public $autoRender = true;
    public $autoLayout = true;


    # http://ec2-54-148-210-220.us-west-2.compute.amazonaws.com/Cake
    # http://ec2-54-148-210-220.us-west-2.compute.amazonaws.com/Cake/index
    public function index() {
        #$this->set('users', $this->UserData->find('all'));


        # $this->layout = 'cutsom_layout'; # if you want to change layout template
    }

    public function user_list() {
        #$this->set('users', $this->UserData->find('all'));
    }
}
