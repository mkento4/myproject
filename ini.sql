create database mychat;
use mychat;

create table users(
  user_id int not null auto_increment primary key,
  user_name VARCHAR(255),
  user_pass VARCHAR(255),
  user_email VARCHAR(255),
  user_profile VARCHAR(255),
  user_country text,
  user_gender text,
  forgotten_answer VARCHAR(255),
  log_in VARCHAR(255),
  one_msg VARCHAR(255),
);


create table users_chat(
  msg_id int not null auto_increment PRIMARY KEY,
  sender_username VARCHAR(255),
  receiver VARCHAR(255),
  msg_content VARCHAR(255),
  msg_status text,
  msg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

create table friend (
  id int not null auto_increment primary key,
  friend1 int  not null,
  friend2 int  not null
);


CREATE TABLE friend_request (
  id int,
  sender int NOT NULL,
  receiver int NOT NULL
);

create table timeline (
  post_id int not null auto_increment primary key,
  user_name VARCHAR(255),
  tl_title VARCHAR(255),
  tl_content VARCHAR(255)
);


create table comment (
  post_id int,
  user_name VARCHAR(255),
  comment VARCHAR(255)
);

create table active_chat (
  now_chat int DEFAULT null
);

-- user_name
insert into active_chat 'now_chat' values 3;


