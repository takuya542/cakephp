<?php

class LogicThread extends Model {

    # ToDo:件数多くないし、全レコードスキャンで件数取得でいいかも
    # 真面目にやるならサマリーテーブル作る
    public function fetch_multi_thread( $controller, $top_comment_num, $limit, $offset ) {
        $threads  = $this->_fetch_multi_thread( $controller, $limit+1, $offset );
        $has_next = null;

        if ( count($threads) == $limit+1 ) {
            $has_next = 1;
            array_pop($threads);
        }

        $thread_list = array();
        foreach( $threads as $thread_val) {

            $thread_id = $thread_val["ThreadData"]["id"];
            $comments  = $this->_fetch_comments( $controller, $thread_id, $top_comment_num, 0 );

            $commented_user_ids = array();
            foreach( $comments as $comment_val) {
                array_push($commented_user_ids, $comment_val["ThreadComment"]["user_id"]);
            }
            $users = $this->_fetch_users( $controller, $commented_user_ids );

            # スレ作成者の情報
            $create_user_id   = $thread_val['ThreadData']['create_user_id'];
            $create_user_data = $this->_fetch_single_user( $controller, $create_user_id );

            array_push( $thread_list, array(
                'id'          => $thread_val['ThreadData']['id'],
                'title'       => $thread_val['ThreadData']['title'],
                'create_user' => array(
                    'id'         => $create_user_id,
                    'name'       => $create_user_data['UserData']["name"],
                    'image'      => $create_user_data['UserData']["image"],
                    'gender'     => $create_user_data['UserData']["gender"],
                ),
                'created_at'  => $thread_val['ThreadData']['created_at'],
                'updated_at'  => $thread_val['ThreadData']['updated_at'],
                'comments'    => $this->_merge_hash( $comments, $users)
            ));
        }

        return array(
            'thread_list' => $thread_list,
            'has_next'    => $has_next,
        );
    }

    public function fetch_single_thread( $controller, $thread_id, $limit, $offset ) {

        $thread   = $this->_fetch_single_thread( $controller, $thread_id );
        $comments = $this->_fetch_comments( $controller, $thread_id, $limit+1, $offset );
        $has_next = null;

        if ( count($comments) == $limit+1 ) {
            $has_next = 1;
            array_pop($comments);
        }

        $commented_user_ids = array();
        foreach( $comments as $key => $val) {
            array_push($commented_user_ids, $val["ThreadComment"]["user_id"]);
        }

        $users = $this->_fetch_users( $controller, $commented_user_ids );
        return array(
            'thread'      => $thread["ThreadData"],
            'comments'    => $this->_merge_hash($comments,$users),
            'has_next'    => $has_next,
        );
    }

    # スレッドを作成
    public function create_thread( $controller, $title, $user_id ) {
        $record = $controller->ThreadData->save(array(
            'title'          => $title,
            'create_user_id' => $user_id,
            'created_at'     => time(),
            'updated_at'     => time(),
        ));
        return $record['ThreadData']['id'];
    }

    # レスを作成
    # ToDO:rollback調査
    public function create_response( $controller, $thread_id, $user_id, $comment ) {
        $controller->ThreadComment->save(array(
            'thread_id'  => $thread_id,
            'user_id'    => $user_id,
            'comment'    => $comment,
            'image'      => null,
            'created_at' => time(),
            'updated_at' => time(),
        ));
        # スレの最終更新日時をupdate
        $controller->ThreadData->updateAll(
            array( 'updated_at' => time()     ),
            array( 'id'         => $thread_id )
        );
        return 1;
    }


    #<-----------  private method -------------->
    
    protected function _merge_hash ( $comments, $users ) {
        $merged_hash_data = array();

        foreach( $comments as $val) {
            $user_data = null;
            foreach( $users as $user_val) {
                if ( $user_val['UserData']['id'] == $val['ThreadComment']['user_id'] ) {
                    $user_data = $user_val['UserData'];
                }
            }
            array_push($merged_hash_data, array(
                    'comment'    => $val['ThreadComment']['comment'],
                    'created_at' => $val['ThreadComment']['created_at'],
                    'user_id'    => $user_data["id"],
                    'name'       => $user_data["name"],
                    'image'      => $user_data["image"],
                    'gender'     => $user_data["gender"],
                )
            );
        }
        return $merged_hash_data;
    }


    # スレッドIDをkeyにしてコメントを取得
    protected function _fetch_comments ( $controller, $thread_id, $limit, $offset  ) {
        return $controller->ThreadComment->find('all', array(
            'conditions' => array('thread_id' => $thread_id),
            'limit'      => $limit,
            'offset'     => $offset,
            'order'      => array('created_at' => 'desc' ),
        ));
    }

    # ユーザIDをkeyにしてユーザ情報を一件取得
    # ToDo : memdのせる.ユーザ情報更新のタイミングでuser_idをkeyにしてrefreshすればOK
    protected function _fetch_single_user( $controller, $user_id ) {
        return $controller->UserData->find('first', array(
            'conditions' => array('id' => $user_id ),
        ));
    }

    # ユーザIDをkeyにしてユーザ情報を複数取得
    protected function _fetch_users ( $controller, $user_ids ) {
        return $controller->UserData->find('all', array(
            'conditions' => array('id' => $user_ids),
        ));
    }

    # スレッドIDをkeyにしてスレッド情報を一件取得
    # ToDo : マスタデータかつ更新無いので,memdのせる
    protected function _fetch_single_thread ( $controller, $id ) {
        return $controller->ThreadData->find('first', array(
            'conditions' => array('id' => $id ),
        ));
    }

    # 更新の新しい順にスレッドを複数件取得
    protected function _fetch_multi_thread ( $controller, $limit, $offset ) {
        return $controller->ThreadData->find('all', array(
            'limit'      => $limit,
            'offset'     => $offset,
            'order'      => array('updated_at' => 'desc' ),
        ));
    }


}


/*
    $multi_threads = $this->LogicThread->fetch_multi_thread( $this, $comment_num, $limit, $offset );
    debug($multi_thread) =
            'thread_list' => array(
                (int) 0 => array(
                    'id' => '2',
                    'title' => 'thread_title2',
                    'create_user' => array(
                        'id' => '2',
                        'name' => 'test_user_2',
                        'image' => 'http://nukippo.com/image/nukippo_video_id_14626.png',
                        'gender' => 'f'
                    ),
                    'created_at' => '1423641670',
                    'comments' => array(
                        (int) 0 => array(
                            'comment' => 'comment3 at thread2',
                            'created_at' => '1423641674',
                            'user_id' => '3',
                            'name' => 'test_user_3',
                            'image' => 'http://nukippo.com/image/nukippo_video_id_14626.png',
                            'gender' => 'f'
                        ),
                        (int) 1 => array(
                            'comment' => 'comment2 at thread2',
                            'created_at' => '1423641673',
                            'user_id' => '2',
                            'name' => 'test_user_2',
                            'image' => 'http://nukippo.com/image/nukippo_video_id_14626.png',
                            'gender' => 'f'
                        ),
                        (int) 2 => array(
                            'comment' => 'comment1 at thread2',
                            'created_at' => '1423641672',
                            'user_id' => '1',
                            'name' => 'test_user_1',
                            'image' => 'http://nukippo.com/image/nukippo_video_id_14626.png',
                            'gender' => 'm'
                        )
                    )
                ),
                (int) 1 => array(
                    'id' => '1',
                    'title' => 'thread_title_1',
                    'create_user' => array(
                        'id' => '1',
                        'name' => 'test_user_1',
                        'image' => 'http://nukippo.com/image/nukippo_video_id_14626.png',
                        'gender' => 'm'
                    ),
                    'created_at' => '1423641669',
                    'comments' => array(
                        (int) 0 => array(
                            'comment' => 'comment3 at thread1',
                            'created_at' => '1423641671',
                            'user_id' => '3',
                            'name' => 'test_user_3',
                            'image' => 'http://nukippo.com/image/nukippo_video_id_14626.png',
                            'gender' => 'f'
                        ),
                        (int) 1 => array(
                            'comment' => 'comment2 at thread1',
                            'created_at' => '1423641670',
                            'user_id' => '2',
                            'name' => 'test_user_2',
                            'image' => 'http://nukippo.com/image/nukippo_video_id_14626.png',
                            'gender' => 'f'
                        ),
                        (int) 2 => array(
                            'comment' => 'comment1 at thread1',
                            'created_at' => '1423641669',
                            'user_id' => '1',
                            'name' => 'test_user_1',
                            'image' => 'http://nukippo.com/image/nukippo_video_id_14626.png',
                            'gender' => 'm'
                        )
                    )
                )
            ),
            'has_next' => null
        )


    $single_thread = $this->LogicThread->fetch_single_thread( $this, $thread_id ,$limit, $offset );
    debug($single_thread) = 
        array(
            'thread' => array(
                'id' => '1',
                'create_user_id' => '1',
                'title' => 'thread_title_1',
                'created_at' => '1423641669',
                'updated_at' => '1423641669'
            ),
            'comments' => array(
                (int) 0 => array(
                    'comment' => 'comment3 at thread1',
                    'created_at' => '1423641671',
                    'user_id' => '3',
                    'name' => 'test_user_3',
                    'image' => 'http://nukippo.com/image/nukippo_video_id_14626.png',
                    'gender' => 'f'
                ),
                (int) 1 => array(
                    'comment' => 'comment2 at thread1',
                    'created_at' => '1423641670',
                    'user_id' => '2',
                    'name' => 'test_user_2',
                    'image' => 'http://nukippo.com/image/nukippo_video_id_14626.png',
                    'gender' => 'f'
                ),
                (int) 2 => array(
                    'comment' => 'comment1 at thread1',
                    'created_at' => '1423641669',
                    'user_id' => '1',
                    'name' => 'test_user_1',
                    'image' => 'http://nukippo.com/image/nukippo_video_id_14626.png',
                    'gender' => 'm'
                )
            ),
            'has_next' => null
        )





*/
