<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $uses = array('UserData', 'ThreadData', 'ThreadComment', 'LogicThread', 'LogicUser');
    public $components = array('Cookie', 'Session');

    # ToDo : routeに各種attribute持たせてどのフィルタ通すか裁きたい
    # allow http methodとかcsrfとかログイン必須とかetc...
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

        # ログイン必須のページの場合、ログイン訴求ページに遷移
        # ToDo:calback_url持たせてログイン飛ばされる前の画面に戻す
        if ( $this->_is_authz_required($this->request->params['controller']) && (!$this->USER) )  {
            $this->redirect('/login/confirm');
        }

        # methodのチェック(postリクエストの対応)
        if ( $this->_is_post_only($this->request->params['controller']) && (!$this->request->is('post')) ) {
            $this->redirect('/?invalidRequest=1');
        }

        # methodのチェック(ajaxリクエストの対応)
        if ( $this->_is_ajax_only($this->request->params['controller']) && (!$this->request->is('ajax')) ) {
            $this->redirect('/?invalidRequest=1');
        }

        if ( isset( $this->request->query['invalidRequest'] ) ) {
            $this->set('invalidRequest',1);
        }

        if ( isset( $this->request->query['invalidParams'] ) ) {
            $this->set('invalidParams',1);
        }

        if ( $this->_is_csrf_embed_required($this->request->params['action']) && $this->USER ) {
            $this->set('csrf_token',$this->_create_csrf_token( $this->USER['id']) );
        }

        # CSRFトークンのverification
        # ToDo : CakePHPのsecurityの仕組みに乗っかる
        if ( $this->_is_csrf_verify_required($this->request->params['action']) && $this->USER ) {
            if ( !$this->_is_csrf_verified( $this->request->data['csrf_token'], $this->USER['id']) ) {
                $this->redirect('/?invalidRequest=1');
            }
        }

    }

    public function afterFilter() {
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

    protected function _is_post_only( $controller ){
        $regexp = preg_match("/create|response/",$controller);
        return ( $regexp ) ? 1 : null;
    }

    protected function _is_ajax_only( $controller ){
        $regexp = preg_match("/ajax/",$controller);
        return ( $regexp ) ? 1 : null;
    }

    protected function _is_authz_required( $controller ){
        $regexp = preg_match("/create|response/",$controller);
        return ( $regexp ) ? 1 : null;
    }

    protected function _is_csrf_embed_required( $controller ){
        $regexp = preg_match("/confirm/",$controller);
        return ( $regexp ) ? 1 : null;
    }

    protected function _is_csrf_verify_required( $controller ){
        $regexp = preg_match("/exec/",$controller);
        return ( $regexp ) ? 1 : null;
    }

    # ToDo : 時刻 + encrypted_secretを元に認証する。というかCakePhpの仕組みにのっかる
    protected function _is_csrf_verified( $token, $user_id ){
        return ( $token == $user_id) ? 1 : null;
    }

    # ToDo : 時刻 + encrypted_secretから生成する。というかCakePhpの仕組みにのっかる
    protected function _create_csrf_token( $user_id ){
        return $user_id;
    }
}
