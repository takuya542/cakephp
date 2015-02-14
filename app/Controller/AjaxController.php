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
                    'type'  => $album['type'],
                ));
            }
            $this->set('albums', $albums);
            $this->log($albums, LOG_DEBUG);
        } else {
            throw new BadRequestException();
        }
    }

    public function pictures( $album_id = null ){
        $facebook    = $this->createFacebook();
        $facebook_id = $facebook->getUser();

        if($facebook_id){
            $pictures  = $facebook->api("/$album_id/photos");

            $picture_links = array();
            foreach ( $pictures['data'] as $picture ) {
                array_push( $picture_links, $picture['source'] );
            }
            $this->set('picture_links', $picture_links);
            $this->log($picture_links, LOG_DEBUG);
        } else {
            throw new BadRequestException();
        }

    }

}
