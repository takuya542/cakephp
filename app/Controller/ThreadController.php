<?php
App::uses('AppController', 'Controller');

class ThreadController extends AppController {
    public $autoRender = true;
    public $autoLayout = true;

    #Modelのロード
    public $uses = array('UserData', 'ThreadData', 'ThreadComment', 'LogicThread');


    # Top / スレ一覧
    public function index( $page = 1 ) {

        $limit         = $this->_thread_num();
        $offset        = $this->_offset( $page, $limit );
        $comment_num   = $this->_top_comment_num();
        $multi_threads = $this->LogicThread->fetch_multi_thread( $this, $comment_num, $limit, $offset );

        $this->set('thread_list',  $multi_threads['thread_list']);
        $this->set('has_next',     $multi_threads["has_next"]);
    }

    # スレ詳細
    public function detail( $thread_id = null ) {

        $page          = isset( $this->request->query['page'] ) ? $this->request->query['page'] : 1;
        $limit         = $this->_comment_num();
        $offset        = $this->_offset( $page, $limit );
        $single_thread = $this->LogicThread->fetch_single_thread( $this, $thread_id ,$limit, $offset );

        $this->set('comments', $single_thread["comments"]);
        $this->set('thread',   $single_thread["thread"]);
        $this->set('has_next', $single_thread["has_next"]);
        $this->set('page',     $page);
    }

    public function login_confirm(){
        $this->render('/Fbconnect/confirm');
    }

    protected function _offset( $page, $limit ) {
        return $limit * ( $page -1 );
    }

    # スレ詳細ページでの最大レス表示数
    protected function _comment_num() {
        return 100;
    }

    # 一覧ページでの最大スレッド表示数
    protected function _thread_num() {
        return 10;
    }

    # 一覧ページ,各スレッドで表示するレス数
    protected function _top_comment_num() {
        return 10;
    }
}
