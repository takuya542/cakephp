/*
useage: mysql -u root < schema.sql
 */

drop   database if exists cake_db;
create database           cake_db default character set utf8;
grant all on cake_db.* to 'game'@'localhost' identified by 'Drag1100';
use                       cake_db;



drop table if exists user_data;
create table user_data (
  id                 int               unsigned not null,
  facebook_id        int               unsigned not null,
  name               varchar(255)               not null,
  image              varchar(255)               not null,
  created_at         int               unsigned not null,
  updated_at         int               unsigned not null
) character set 'utf8',
type=InnoDB;

alter table favorite
 add primary key     (id),
 add unique  index(facebook_id);


/*-----user_id-------*/
drop table if exists seq_user;
create table seq_user (
  id        int               unsigned not null
) character set 'utf8',
type=Myisam;
insert into seq_user values(1000);
