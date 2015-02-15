/* useage: mysql -u root < schema.sql */
/* パーティショニング予定はないので、シーケンステーブルは用意せずauto incrementでpk発番とする */

drop   database if exists cake_db;
create database           cake_db default character set utf8;
use                       cake_db;

drop table if exists user_data;
create table user_data(
    id                 int                  auto_increment,
    facebook_id        bigint            unsigned not null,
    name               varchar(255)               not null,
    gender             varchar(1)                 not null,  /* m or f */
    image              varchar(255)               not null,
    created_at         int               unsigned not null,
    updated_at         int               unsigned not null,  /* ログインのタイミングでアップデート*/
    primary key(id)
);

alter table user_data
 add unique  index(facebook_id);

/* 各スレのマスタデータ */
drop table if exists thread_data;
create table thread_data (
    id                 int                  auto_increment,
    create_user_id     int               unsigned not null,  /* facebook_id */
    title              varchar(255)               not null,
    created_at         int               unsigned not null,
    updated_at         int               unsigned not null, /* thread_commentsにinsertのタイミングでupdate*/
    primary key(id)
);

alter table thread_data
 add index   i1   (updated_at); /* スレッドフロート式で取得用 */


/* レス保存用 */
drop table if exists thread_comments;
create table thread_comments (
    thread_id          int               unsigned not null,
    user_id            int               unsigned not null,
    comment            text                               ,
    image              varchar(255)                       ,
    created_at         int               unsigned not null,
    updated_at         int               unsigned not null
);

alter table thread_comments
 add index   i1   (updated_at); /* スレッドフロート式で取得用 */



/* テストデータ */
insert into user_data (facebook_id,name,gender,image,created_at,updated_at)values(
1,"test_user_1","m","http://nukippo.com/image/nukippo_video_id_14626.png", UNIX_TIMESTAMP(), UNIX_TIMESTAMP() 
);

insert into user_data (facebook_id,name,gender,image,created_at,updated_at)values(
2,"test_user_2","f","http://nukippo.com/image/nukippo_video_id_14626.png", UNIX_TIMESTAMP()+1, UNIX_TIMESTAMP()+1
);

insert into user_data (facebook_id,name,gender,image,created_at,updated_at)values(
3,"test_user_3","f","http://nukippo.com/image/nukippo_video_id_14626.png", UNIX_TIMESTAMP()+2, UNIX_TIMESTAMP()+2 
);

insert into thread_data (create_user_id,title,created_at,updated_at)values(
1,"thread_title_1",UNIX_TIMESTAMP(), UNIX_TIMESTAMP()
);

insert into thread_data (create_user_id,title,created_at,updated_at)values(
2,"thread_title2",UNIX_TIMESTAMP()+1, UNIX_TIMESTAMP()+1
);

insert into thread_comments (thread_id,user_id,comment,image,created_at,updated_at)values(
1,1,"comment1 at thread1",null,UNIX_TIMESTAMP(), UNIX_TIMESTAMP()
);

insert into thread_comments (thread_id,user_id,comment,image,created_at,updated_at)values(
1,2,"comment2 at thread1",null,UNIX_TIMESTAMP()+1, UNIX_TIMESTAMP()+1
);

insert into thread_comments (thread_id,user_id,comment,image,created_at,updated_at)values(
1,3,"comment3 at thread1",null,UNIX_TIMESTAMP()+2, UNIX_TIMESTAMP()+2
);

insert into thread_comments (thread_id,user_id,comment,image,created_at,updated_at)values(
2,1,"comment1 at thread2",null,UNIX_TIMESTAMP()+3, UNIX_TIMESTAMP()+3
);

insert into thread_comments (thread_id,user_id,comment,image,created_at,updated_at)values(
2,2,"comment2 at thread2",null,UNIX_TIMESTAMP()+4, UNIX_TIMESTAMP()+4
);

insert into thread_comments (thread_id,user_id,comment,image,created_at,updated_at)values(
2,3,"comment3 at thread2",null,UNIX_TIMESTAMP()+5, UNIX_TIMESTAMP()+5
);

