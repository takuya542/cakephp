<?php
App::uses('AppController', 'Controller');
App::import('Vendor','facebook',array('file' => 'facebook'.DS.'src'.DS.'facebook.php'));

class ResponseController extends AppController {
    public $autoRender = true;
    public $autoLayout = true;

    #Modelのロード
    public $uses = array('UserData', 'ThreadData', 'ThreadComment', 'LogicThread');

    private function createFacebook() {
        return new Facebook(array(
            'appId'  => '924244504263211',
            'secret' => 'dfc09a4c57dcc636bd68114bcb7ec84e',
        ));
    }

    # レス確認
    public function confirm( $thread_id = null) {

        $comment = $this->request->data['comment'];
        if(!$comment){
            $this->redirect("/?invalidParams=1");
        }

        $picture_id     = $this->request->data['picture_id'];
        $picture_source = $this->request->data['picture_source'];

        $this->set('comment',   $comment);
        $this->set('thread_id', $thread_id);

        $this->set('picture_id',     $picture_id);
        $this->set('picture_source', $picture_source);

        #csrfトークンの生成
    }

    # レス作成
    public function exec( $thread_id = null) {

        $facebook    = $this->createFacebook();
        $facebook_id = $facebook->getUser();

        $user_id    = $this->USER['id'];
        $comment    = $this->request->data['comment'];
        $picture_id = $this->request->data['picture_id'];
        $picture_source = $this->request->data['picture_source'];

        /*
        $img           = file_get_contents( $picture_source );
        $img_file_path = $picture_link;
        file_put_contents($img_file_path, $img);
        $this->LogicThread->create_response( $this, $thread_id, $user_id, $comment, $img_file_path );
        */

        # 暫定対応:facebook上の画像をcurlで取得できない。。
        $this->LogicThread->create_response( $this, $thread_id, $user_id, $comment, $picture_source );

        #レスしたスレのトップにリダイレクト
        $this->redirect("/detail/$thread_id");
    }
}
