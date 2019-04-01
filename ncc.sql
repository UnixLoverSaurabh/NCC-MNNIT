/*create database registration; */

create table users (id int(11) UNIQUE AUTO_INCREMENT , username varchar(255) , email varchar(255) , password varchar(255) , PRIMARY KEY (username));

create table event (event_id int(11) AUTO_INCREMENT , event_username varchar(255) , event_name varchar(255) , event_desc varchar(1000) , event_date date , time varchar(11) , venue varchar(255) , status1 varchar(20) DEFAULT "Pending" , PRIMARY KEY (event_id) , FOREIGN KEY (event_username) REFERENCES users(username));

create table eventJoin (event_id int(11) , username varchar(255) , status2 varchar(20) DEFAULT "Join1" , PRIMARY KEY (event_id, username) , FOREIGN KEY (event_id) REFERENCES event(event_id));