<?php
App::uses('AppController', 'Controller');
App::import('Vendor','facebook',array('file' => 'facebook'.DS.'src'.DS.'facebook.php'));

class AjaxController extends AppController {

    public $uses = array('UserData', 'ThreadData', 'ThreadComment', 'AlbumData', 'LogicThread', 'LogicUser');
    public $components = array('Cookie', 'Session');

    public function beforeFilter() {
        $this->layout = null;
    }

    private function createFacebook() {
        return new Facebook(array(
            'appId'  => '924244504263211',
            'secret' => '714cef350db4a784e0a8ecb0bdf09bdd',
        ));
    }

    # ToDo:jsonで返してクライアント側でごにょる
    public function albums(){

        $facebook    = $this->createFacebook();
        $facebook_id = $facebook->getUser();

        $albums = $this->AlbumData->find('all', array(
            'conditions' => array('facebook_id' => $facebook_id,),
        ));

        $albums_data = array();
        foreach ( $albums as $album ) {
            if ( $this->_is_valid_album( $album['AlbumData']) ) {
                array_push( $albums_data, $album );
            }
        }
        $this->set('albums', $albums_data);

    }

    # ToDo:jsonで返してクライアント側でごにょる
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

    protected function _is_valid_album( $album ) {
        if ( isset( $album['count'] )
             && $album['count'] > 0 
             && !preg_match( "/app|normal/", $album['type'] )
        ) {
            return 1;
        } else {
            return null;
        }
    }
}
