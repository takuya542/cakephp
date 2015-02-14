<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $uses = array('UserData', 'ThreadData', 'ThreadComment', 'LogicThread', 'LogicUser');
    public $components = array('Cookie', 'Session');

    public function beforeFilter() {

        # ログイン状態のチェック
        $facebook_id = $this->_decrypt_id( $this->Cookie->read('KJB_D') );
        if ( $facebook_id ) {
            $user_data  = $this->_get_user_data( $facebook_id );
            $this->USER = $user_data['UserData'];
            $this->set('USER', $user_data['UserData']);
        } else {
            $this->USER = null;
            $this->set('USER', null);
        }

        # methodのチェック(post系endpointをはじく)
        #if ( $this->request->is('get') ) {
        #    $this->redirect('/');
        #}
    }

    public function afterFilter() {
        # ToDo:tracking cookieの発行 & ロギング
    }

    protected function _get_user_data( $facebook_id ){
        if ( $this->Session->check($facebook_id) ) {
            return $this->Session->read( $facebook_id);
        } else {
            $user_data = $this->UserData->find('first', array(
                'conditions' => array('facebook_id' => $facebook_id),
            ));
            $this->Session->write($facebook_id, $user_data);
            return $user_data;
        }
    }

    protected function _decrypt_id( $encrypted_id ){
        # ToDo : 実サーバ上のみに存在するencrypted_secretを使用して復号化
        return ( $encrypted_id ) ? $encrypted_id : null;
    }
}
