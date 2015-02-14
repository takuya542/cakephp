<?php
App::uses('AppController', 'Controller');
App::import('Vendor','facebook',array('file' => 'facebook'.DS.'src'.DS.'facebook.php'));

class AjaxController extends AppController {

    public $uses = array('UserData', 'ThreadData', 'ThreadComment', 'LogicThread', 'LogicUser');
    public $components = array('Cookie', 'Session');

    public function beforeFilter() {
        #$this->autoRender = FALSE;
        $this->layout     = null;

        if($this->request->is('ajax')) {
        }else{
#            throw new BadRequestException();
        }
    }

    private function createFacebook() {
        return new Facebook(array(
            'appId'  => '924244504263211',
            'secret' => 'dfc09a4c57dcc636bd68114bcb7ec84e',
        ));
    }

    public function albums(){
        $facebook    = $this->createFacebook();
        $facebook_id = $facebook->getUser();

        if($facebook_id){
            $me = $facebook->api('/me', array( 'fields' => 'albums' ));

            $albums = array();
            foreach ( $me['albums']['data'] as $album ) {
                array_push( $albums, array(
                    'id'    => $album['id'],
                    'name'  => $album['name'],
    #                'count' => $album['count'],
                    'type'  => $album['type'],
                ));
            }
            $this->set('albums', $albums);
            $this->log($albums);
        } else {
            throw new BadRequestException();
        }
    }

    public function pictures( $album_id = null ){
        $this->log($album_id);

/*
        if($facebook_id){
            $pictures  = $facebook->api("/$album_id/picture");
            $this->log($pictures, LOG_DEBUG);
        }
*/
    }

}
