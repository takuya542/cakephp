<?php
App::uses('AppController', 'Controller');
App::import('Vendor','facebook',array('file' => 'facebook'.DS.'src'.DS.'facebook.php'));

class AjaxController extends AppController {

    public $uses = array('UserData', 'ThreadData', 'ThreadComment', 'LogicThread', 'LogicUser');
    public $components = array('Cookie', 'Session');

    public function beforeFilter() {
        $this->layout = null;
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
                if( !preg_match( "/app|normal/", $album['type'] ) ) {
                    array_push( $albums, array(
                        'id'    => $album['id'],
                        'name'  => $album['name'],
                        'type'  => $album['type'],
                    ));
                }
            }
            $this->set('albums', $albums);
        } else {
            throw new BadRequestException();
        }
    }

    public function pictures( $album_id = null ){
        $facebook    = $this->createFacebook();
        $facebook_id = $facebook->getUser();

        if($facebook_id){
            $pictures  = $facebook->api("/$album_id/photos");

            $pictures_data = array();
            foreach ( $pictures['data'] as $picture ) {
                array_push( $pictures_data, array(
                    'id'     => $picture['id'],
                    'source' => $picture['source'],
                ));
            }
            $this->set('pictures_data', $pictures_data);
        } else {
            throw new BadRequestException();
        }

    }

}
