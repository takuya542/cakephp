<?php
App::uses('AppController', 'Controller');

class CakeController extends AppController {

    # http://ec2-54-148-210-220.us-west-2.compute.amazonaws.com/Cake
    # http://ec2-54-148-210-220.us-west-2.compute.amazonaws.com/Cake/index
    public function index() {
        $this -> autoRender = false;
        echo "<html><head></head><body>";
        echo "<h1>サンプルページ</h1>";
        echo "<p>これがサンプルのページです。</p>";
        echo "</body></html>";
    }
    
    # http://ec2-54-148-210-220.us-west-2.compute.amazonaws.com/Cake/fuck
    public function fuck() {
        $this -> autoRender = false;
        echo "<html><head></head><body>";
        echo "<h1>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</h1>";
        echo "<p>これがサンプルのページです。</p>";
        echo "</body></html>";
    }
}
