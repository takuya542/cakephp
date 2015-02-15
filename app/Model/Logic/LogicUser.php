<?php

class LogicUser extends Model {

    public function create_user( $controller, $facebook_user_data, $img_file_path ) {

        $user = $this->_get_user($controller, $facebook_user_data['id']);

        # ToDo1:ユーザ / アルバム情報に更新がある場合は現マスタデータとの差分アップデート / insert
        if ( $user ) {
            # 最終ログイン日時をアップデート
            $controller->UserData->updateAll(
                array( 'updated_at'  => time() ),
                array( 'facebook_id' => $facebook_user_data['id'] )
            );
            return $user;
        } else {

            # アルバムデータ
            # ToDo: cakephpでのバルクインサートよくわからない...
            foreach( $facebook_user_data['albums']['data'] as $album ) {
                $controller->AlbumData->save(array(
                    'facebook_id' => $facebook_user_data['id'],
                    'album_id'    => $album['id'],
                    'name'        => $album['name'],
                    'type'        => $album['type'],
                    'count'       => isset( $album['count'] ) ? $album['count'] : 0,
                    'link'        => $album['link'],
                    'created_at'  => time(),
                    'updated_at'  => time(),
                ));
            }

            # ユーザデータ
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
