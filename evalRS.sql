drop database if exists evalRS;
create database evalRS;
use evalRS;

create table user(
    id int auto_increment primary key,
    username varchar(255),
    password varchar(255),
    mail varchar(255),
    image varchar(255),
    joined date
);

create table post(
    id int auto_increment primary key,
    text varchar(255),
    userID int,
    FOREIGN KEY (userID) REFERENCES user(id)
);

create table comments(
    id int auto_increment primary key,
    text varchar(255),
    userID int,
    postID int,
    FOREIGN KEY (userID) REFERENCES user(id),
    FOREIGN KEY (postID) REFERENCES post(id)
);

create table likesReposts(
    userID int,
    postID int,
    FOREIGN KEY (userID) REFERENCES user(id),
    FOREIGN KEY (postID) REFERENCES post(id),
    liked boolean,
    reposted boolean
);

create table likesRepostsComments(
    userID int,
    commentID int,
    FOREIGN KEY (userID) REFERENCES user(id),
    FOREIGN KEY (commentID) REFERENCES comments(id),
    liked boolean
);

drop user if exists machin@'127.0.0.1';
create user machin@'127.0.0.1' identified by 'mdp123';
grant all privileges on evalRS.* to machin@'127.0.0.1';