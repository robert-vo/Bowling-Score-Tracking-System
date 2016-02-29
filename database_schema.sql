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

use bowling;

drop table if exists Game;
drop table if exists Roll;
drop table if exists Ball;
drop table if exists Team;
drop table if exists Frame;
drop table if exists Events;
drop table if exists Event_Types;
drop table if exists Statistics;
drop table if exists Players;

create table Ball (
  Ball_ID  int  primary key,
  Color    varchar(20),
  Weight   int,
  Size     varchar(2)
);

create table Players (
  Player_ID  int primary key,
  Gender     varchar(2),
  Phone_Number      varchar(15),
  Date_Joined  date,
  Date_Of_Birth  datetime,
  Address    varchar(30),
  First_Name     varchar(30),
  Last_Name  varchar(30),
  Middle_Initial  varchar(1),
  Email  varchar(30) 
);

create table Team (
  Team_ID        int primary key,
  Name           varchar(20),
  Leader         int,
  Date_Created   datetime,
  -- Players 
  Game_Count     int,
  Win_Count      int,
  Phone_Number   varchar(15),
  Address        varchar(30),
  foreign key (Leader) references Players(Player_ID)
);



create table Frame(
  Frame_ID int primary key,
  Player_ID int,
  Roll_One_ID int,
  Roll_Two_ID int,
  Roll_Three_ID int,
  Score int
);

create table Roll (
  Roll_ID int primary key,
  Frame_ID int,
  Ball_ID int,
  Is_Stike  boolean,
  Is_Spare  boolean,
  Is_Foul   boolean,
  foreign key (Frame_ID) references Frame(Frame_ID),
  foreign key (Ball_ID) references Ball(Ball_ID)
  -- pins
);

create table Event_Types (
  Event_Type_ID int primary key,
  Event_Type_Name varchar(30)
);

create table Events (
  Event_ID int primary key,
  Type_ID int,
  Game_ID int ,
  Event_Time  datetime,  
  Winner varchar(20),
  Title varchar(20),
  Location varchar(50),
  foreign key (Type_ID) references Event_Types(Event_Type_ID)
);

create table Game (
  Game_ID  int  primary key,
  Event_ID int,
  Player_ID int,
  Frame_ID int,
  foreign key (Event_ID) references Events(Event_ID),
  foreign key (Player_ID) references Players(Player_ID),
  foreign key(Frame_ID) references Roll(Frame_ID)
);

create table Statistics (
  Stat_ID  int  primary key,
  Player_ID  int,
  Strikes  int,
  Perfect_Games  int,
  Spares  int,
  Best_Score  int,
  Worst_Score  int,
  Pins_Left  int,
  Average_Pin_Left  int,
  foreign key (Player_ID) references Players(Player_ID) 
);
