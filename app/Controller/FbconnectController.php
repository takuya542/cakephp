<?php
App::uses('AppController', 'Controller');
App::import('Vendor','facebook',array('file' => 'facebook'.DS.'src'.DS.'facebook.php'));

class FbconnectController extends AppController {

    public $uses = array('UserData', 'ThreadData', 'ThreadComment', 'AlbumData', 'LogicThread', 'LogicUser');
    public $components = array('Cookie', 'Session');

    public function beforeFilter() {
    }

    private function createFacebook() {
        return new Facebook(array(
            'appId'  => '924244504263211',
            'secret' => 'dfc09a4c57dcc636bd68114bcb7ec84e',
        ));
    }

    public function login(){
        $facebook  = $this->createFacebook();
        $login_url = $facebook->getLoginUrl(array(
            'redirect_uri' => 'http://dev.keijiban.com/login/callback',
            'scope'        => 'user_photos',
        ));
        $this->redirect( $login_url );
    }

    public function callback(){//facebookの認証処理部分
        $facebook    = $this->createFacebook();
        $facebook_id = $facebook->getUser();//facebookユーザ情報取得

        if($facebook_id){ // 認証後
            
            # permission確認
            #$permissions = $facebook->api("/$facebook_id/permissions");
            #$this->log($permissions, LOG_DEBUG);

            # FB経由でユーザ情報取得
            $me  = $facebook->api('/me', array( 'fields' => 'id,name,gender,birthday,albums' ));
            $this->log($me, LOG_DEBUG);
            $pic = $facebook->api('/me/picture','GET',array (
                'type' => 'normal',
                'redirect' => false,
                'height' => '200',
                'width' => '200',
            ));
            $img           = file_get_contents( $pic['data']['url']);
            $img_file_path = $facebook_id.'.jpg';
            file_put_contents($img_file_path, $img);

            # ユーザ情報の作成
            $created_user_data = $this->LogicUser->create_user( $this, $me, $img_file_path );

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

    public function confirm(){
    }

    public function logout(){
        $facebook    = $this->createFacebook();
        $facebook_id = $facebook->getUser();//facebookユーザ情報取得

        if ( $this->Cookie->check('KJB_D') ) {

            #Cookieの破棄
            $this->Cookie->delete('KJB_D');

            # セッションのユーザ情報を破棄
            $this->Session->delete($facebook_id);

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
