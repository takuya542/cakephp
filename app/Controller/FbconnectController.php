<?php
App::uses('AppController', 'Controller');
App::import('Vendor','facebook',array('file' => 'facebook'.DS.'src'.DS.'facebook.php'));

class FbconnectController extends AppController {

    public $uses = array('UserData', 'ThreadData', 'ThreadComment', 'LogicThread', 'LogicUser');
    public $components = array('Cookie', 'Session');

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
        $facebook    = $this->createFacebook();
        $facebook_id = $facebook->getUser();//facebookユーザ情報取得

        if($facebook_id){ // 認証後

            # FB経由でユーザ情報取得
            $me = $facebook->api('/me', array( 'fields' => 'id,name,gender,birthday' ));

            # ユーザ情報の作成
            $created_user_data = $this->LogicUser->create_user( $this, $me );

            # facebook_idをkeyにしてセッションにユーザ情報を保管
            $this->Session->write($facebook_id, $created_user_data);

            # cookie
            # ToDo : dev / prodでcookie keyを分ける(configに設定)
            $encrypted_id = $this->_generate_encrypted_id($facebook_id);
            $this->Cookie->write('KJB_D', $encrypted_id);

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

        if ( $this->Cookie->check('KJB_D') ) {

            #Cookieの破棄
            $this->Cookie->delete('KJB_D');

            #facebookからのログアウト
            $logout_url = $facebook->getLogoutUrl(array(
                'redirect_uri' => 'http://dev.keijiban.com',
            ));
            $this->redirect($logout_url);
        } else {
            $this->redirect('/');
        }
    }

    protected function _generate_encrypted_id( $facebook_id ){
        # ToDo : 実サーバ上のみに存在するencrypted_secretを使用して暗号化
        return $facebook_id;
    }

}
