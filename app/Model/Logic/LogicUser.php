<?php

class LogicUser extends Model {

    public function create_user( $controller, $facebook_user_data, $img_file_path ) {

        $this->log($facebook_user_data['albums'], LOG_DEBUG);

        $user = $this->_get_user($controller, $facebook_user_data['id']);

        # ToDo1:ユーザ情報に更新がある場合はアップデート
        # ToDo2:アルバム情報の永続化.ajaxで都度たたいてもいいけど、ある程度キャッシュさせといてもいいはず..
        if ( $user ) {
            # 最終ログイン日時をアップデート
            $controller->UserData->updateAll(
                array( 'updated_at'  => time() ),
                array( 'facebook_id' => $facebook_user_data['id'] )
            );
            return $user;
        } else {
            return $controller->UserData->save(array(
                'facebook_id' => $facebook_user_data['id'],
                'name'        => $facebook_user_data['name'],
                'gender'      => $facebook_user_data['gender'] == 'male' ? 'm' : 'f',
                'image'       => $img_file_path,
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
