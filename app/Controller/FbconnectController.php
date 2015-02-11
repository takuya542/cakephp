<?php
App::uses('AppController', 'Controller');
App::import('Vendor','facebook',array('file' => 'facebook'.DS.'src'.DS.'facebook.php'));

class FbconnectController extends AppController {

    public $uses = array('UserData', 'ThreadData', 'ThreadComment', 'LogicThread', 'LogicUser');

    private function createFacebook() {
        return new Facebook(array(
            'appId'  => '924244504263211',
            'secret' => '3e8fb618be7e300bddd4394c6d725995',
        ));
    }

    public function login(){
        $facebook  = $this->createFacebook();
        $login_url = $facebook->getLoginUrl(array(
            'redirect_uri' => 'http://dev.keijiban.com/login/callback',
        ));
        $this->redirect( $login_url );
    }

    public function callback(){//facebookの認証処理部分
        $facebook         = $this->createFacebook();
        $facebook_user_id = $facebook->getUser();//facebookユーザ情報取得

        if($facebook_user_id){ // 認証後
            $me = $facebook->api('/me', array(
                'fields' => 'id,name,gender,birthday'
            ));
            $created_user_data = $this->LogicUser->create_user( $this, $me );
            $this->redirect('/');
        }else{  //認証前
            $url = $facebook->getLoginUrl(array(
                'redirect_uri' => 'http://dev.keijiban.com/login/callback',
            ));
            $this->redirect($url);
        }
    }

    public function logout(){
        $facebook   = $this->createFacebook();
        $logout_url = $facebook->getLogoutUrl(array(
            'redirect_uri' => 'http://dev.keijiban.com',
        ));
        $this->redirect($logout_url);
    }

}
