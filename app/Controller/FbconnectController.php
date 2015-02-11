<?php
App::uses('AppController', 'Controller');
App::import('Vendor','facebook',array('file' => 'facebook'.DS.'src'.DS.'facebook.php'));

class FbconnectController extends AppController {

    private function createFacebook() {
        return new Facebook(array(
            'appId'  => '924244504263211',
            'secret' => '3e8fb618be7e300bddd4394c6d7259952',
        ));
    }

    public $name = 'Fbconnect';
    public function index(){
        $this->facebook = $this->createFacebook();
        $user = $this->facebook->getUser();//ユーザ情報取得
        if ($user) {
            $this->set('loginUrl',  "test_login");
            $this->set('logoutUrl', $this->facebook->getLogoutUrl());
        } else {
            $this->set('loginUrl',  $this->facebook->getLoginUrl());
            $this->set('logoutUrl', "test_logout");
        }
    }

    function showdata(){//トップページ
        #$facebook = $this->createFacebook(); //セッション切れ対策 (?)
        $myFbData = $this->Session->read('mydata');//facebookのデータ
        //$myFbData_kana = $this->Session->read('fbdata_kana'); //フリガナ
        //pr($myFbData_kana); //フリガナデータ表示
        pr($myFbData);//表示
        $this->fbpost("hello world");//facebookに投稿
    }

    public function facebook(){//facebookの認証処理部分
        $this->autoRender = false;
        $this->facebook   = $this->createFacebook();
        $user = $this->facebook->getUser();//ユーザ情報取得
        if($user){//認証後
            $this->redirect('showdata');
        }else{//認証前
            $url = $this->facebook->getLoginUrl(array(
            'scope' => 'email,publish_stream,user_birthday'
            ,'canvas' => 1,'fbconnect' => 0));
            $this->redirect($url);
        }
    }


    public function fbpost($postData) {//facebookのwallにpostする処理
        $facebook = $this->createFacebook();
        $attachment = array(
            'access_token' => $facebook->getAccessToken(), //access_token入手
            'message' => $postData,
            'name' => "test",
            'link' => "http://twitter.com/n0bisuke",
            'description' => "test",
        );
        $facebook->api('/me/feed', 'POST', $attachment);
    }
}
