<?php

class LogicUser extends Model {

    public function create_user( $controller, $facebook_user_data ) {

        $user = $this->_get_user($controller, $facebook_user_data['id']);
        if ( $user ) {
            return $user;
        } else {
            return $controller->UserData->save(array(
                'facebook_id' => $facebook_user_data['id'],
                'name'        => $facebook_user_data['name'],
                'gender'      => $facebook_user_data['gender'] == 'male' ? 'm' : 'f',
                'image'       => "http://test.png",
                'created_at'  => time(),
                'updated_at'  => time(),
            ));
        }
    }

    # facebook_idをkeyにしてユーザ情報を参照
    protected function _get_user ( $controller, $id ) {
        return $controller->UserData->find('first', array(
            'conditions' => array('facebook_id' => $id),
        ));
    }
}
