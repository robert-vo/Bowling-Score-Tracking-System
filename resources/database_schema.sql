-- https://docs.google.com/document/d/1SkxY0NnXMzxtM450nEUy3GQ_7iAWJgRgjFCNVYfvdiE/edit

/*
create table format
CREATE TABLE table_name (
  attribute_name  data_type  any_other_special_properties,
  ...,
  ...
  any_other_constraints
);
*/

drop database if exists bowling;
CREATE DATABASE if not exists bowling;

use bowling;

drop table if exists Game;
drop table if exists Events;
drop table if exists Event_Types;
drop table if exists Statistics;
drop table if exists Frame;
drop table if exists Roll;
drop table if exists Team;
drop table if exists Ball;
drop table if exists Players;

create table Ball (
  Ball_ID  int          primary key AUTO_INCREMENT,
  Color    varchar(20)  not null,
  Weight   int          not NULL,
  Size     ENUM('XS', 'S', 'M', 'L', 'XL', 'XXL')
);

create table Players (
  Player_ID       int           primary key AUTO_INCREMENT,
  Gender          ENUM('F', 'M'),
  Phone_Number    varchar(15),
  Date_Joined     date          not null,
  Date_Of_Birth   datetime      not null,
  Address         varchar(30),
  First_Name      varchar(30)   not null,
  Last_Name       varchar(30)   not null,
  Middle_Initial  varchar(1),
  Email           varchar(30)   not null
);

create table Team (
  Team_ID        int            primary key AUTO_INCREMENT,
  Name           varchar(20),
  Leader         int,
  Date_Created   datetime,
  Game_Count     int,
  Win_Count      int,
  Phone_Number   varchar(15),
  Address        varchar(30),
  Player_1	     int,
  Player_2	     int            null,
  Player_3	     int            null,
  Player_4	     int            null,
  Player_5	     int            null,
  foreign key    (Leader)       references Players(Player_ID),
  foreign key    (Player_1)     references Players(Player_ID),
  foreign key    (Player_2)     references Players(Player_ID),
  foreign key    (Player_3)     references Players(Player_ID),
  foreign key    (Player_4)     references Players(Player_ID),
  foreign key    (Player_5)     references Players(Player_ID)
);

create table Roll (
  Roll_ID     int     primary key AUTO_INCREMENT,
  Frame_ID    int     not null,
  Ball_ID     int     not null,
  Is_Strike   boolean not null,
  Is_Spare    boolean not null,
  Is_Foul     boolean not null,
  Hit_Pin_1		boolean not null,
  Hit_Pin_2		boolean not null,
  Hit_Pin_3		boolean not null,
  Hit_Pin_4		boolean not null,
  Hit_Pin_5		boolean not null,
  Hit_Pin_6		boolean not null,
  Hit_Pin_7		boolean not null,
  Hit_Pin_8		boolean not null,
  Hit_Pin_9		boolean not null,
  Hit_Pin_10	boolean not null,
  foreign key (Ball_ID) REFERENCES Ball(Ball_ID) on delete CASCADE
);

create table Frame(
  Frame_ID        int primary key AUTO_INCREMENT,
  Player_ID       int,
  Roll_One_ID     int,
  Roll_Two_ID     int,
  Roll_Three_ID   int null,
  Score           int,
  foreign key (Player_ID) references Players(Player_ID),
  foreign key (Roll_One_ID) references Roll(Roll_ID),
  foreign key (Roll_Two_ID) references Roll(Roll_ID),
  foreign key (Roll_Three_ID) references Roll(Roll_ID)
);

create table Events (
  Event_ID    int primary key AUTO_INCREMENT,
  Game_ID     int,
  Team_ID     int,
  Event_Time  datetime,
  Winner      varchar(20),
  Title       varchar(20),
  Location    varchar(50),
  Event_Type  ENUM('Casual', 'Tournament'),
  foreign key (Team_ID) references Team(Team_ID)
);

create table Game (
  Game_ID     int  primary key AUTO_INCREMENT,
  Event_ID    int,
  Team_ID     int,
  Frame_ID    int,
  foreign key (Event_ID) references Events(Event_ID),
  foreign key (Team_ID) references Team(Team_ID),
  foreign key (Frame_ID) references Frame(Frame_ID)
);

create table Statistics (
  Stat_ID           int  primary key AUTO_INCREMENT,
  Player_ID         int,
  Strikes           int,
  Perfect_Games     int,
  Spares            int,
  Best_Score        int,
  Worst_Score       int,
  Pins_Left         int,
  Average_Pin_Left  int,
  foreign key (Player_ID) references Players(Player_ID)
    on delete CASCADE
    on update CASCADE
);

