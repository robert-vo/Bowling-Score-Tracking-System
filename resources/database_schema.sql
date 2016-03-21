-- https://docs.google.com/document/d/1SkxY0NnXMzxtM450nEUy3GQ_7iAWJgRgjFCNVYfvdiE/edit

/*
CREATE TABLE format
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

DROP TABLE IF EXISTS Game;
DROP TABLE IF EXISTS Events;
DROP TABLE IF EXISTS Event_Types;
DROP TABLE IF EXISTS Statistics;
DROP TABLE IF EXISTS Frame;
DROP TABLE IF EXISTS Roll;
DROP TABLE IF EXISTS Team;
DROP TABLE IF EXISTS Ball;
DROP TABLE IF EXISTS Players;

CREATE TABLE Ball (
  Ball_ID  INT          primary key AUTO_INCREMENT,
  Color    VARCHAR(20)  NOT NULL,
  Weight   INT          not NULL,
  Size     ENUM('XS', 'S', 'M', 'L', 'XL', 'XXL') NOT NULL
);

CREATE TABLE Players (
  Player_ID       INT             primary key AUTO_INCREMENT,
  Gender          ENUM('F', 'M')  NOT NULL,
  PhONe_Number    VARCHAR(15),
  Date_Joined     DATE            NOT NULL,
  Date_Of_Birth   DATETIME        NOT NULL,
  Address         VARCHAR(30),
  First_Name      VARCHAR(30)     NOT NULL,
  Last_Name       VARCHAR(30)     NOT NULL,
  Middle_Initial  VARCHAR(1),
  Email           VARCHAR(30)     NOT NULL
);

CREATE TABLE Team (
  Team_ID        INT            primary key AUTO_INCREMENT,
  Name           VARCHAR(20)	  NOT NULL,
  Leader         INT			      NOT NULL,
  Date_Created   DATETIME		    NOT NULL,
  Game_Count     INT			      default 0,
  Win_Count      INT			      default 0,
  PhONe_Number   VARCHAR(15),
  Address        VARCHAR(30),
  Player_1	     INT,
  Player_2	     INT            null,
  Player_3	     INT            null,
  Player_4	     INT            null,
  Player_5	     INT            null,
  FOREIGN KEY    (Leader)       REFERENCES Players(Player_ID),
  FOREIGN KEY    (Player_1)     REFERENCES Players(Player_ID),
  FOREIGN KEY    (Player_2)     REFERENCES Players(Player_ID),
  FOREIGN KEY    (Player_3)     REFERENCES Players(Player_ID),
  FOREIGN KEY    (Player_4)     REFERENCES Players(Player_ID),
  FOREIGN KEY    (Player_5)     REFERENCES Players(Player_ID)
);

CREATE TABLE Frame(
  Frame_ID        INT primary key AUTO_INCREMENT,
  Player_ID       INT,
  Roll_One_ID     INT,
  Roll_Two_ID     INT,
  Roll_Three_ID   INT,
  Score           INT DEFAULT 0,
  FOREIGN KEY (Player_ID) REFERENCES Players(Player_ID)
);

CREATE TABLE Roll (
  Roll_ID     INT     primary key AUTO_INCREMENT,
  Frame_ID    INT     NOT NULL,
  Ball_ID     INT,
  Is_Strike   BOOLEAN NOT NULL DEFAULT FALSE,
  Is_Spare    BOOLEAN NOT NULL DEFAULT FALSE,
  Is_Foul     BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_1		BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_2		BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_3		BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_4		BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_5		BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_6		BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_7		BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_8		BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_9		BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_10	BOOLEAN NOT NULL DEFAULT FALSE,
  FOREIGN KEY (Ball_ID) REFERENCES Ball(Ball_ID)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  FOREIGN KEY (Frame_ID) REFERENCES Frame(Frame_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE Events (
  Event_ID    INT primary key AUTO_INCREMENT,
  Game_ID     INT,
  Team_ID     INT,
  Event_Time  DATETIME,
  Winner      VARCHAR(20),
  Title       VARCHAR(20),
  LocatiON    VARCHAR(50),
  Event_Type  ENUM('Casual', 'Tournament'),
  FOREIGN KEY (Team_ID) REFERENCES Team(Team_ID)
);

CREATE TABLE Game (
  Game_ID     INT  primary key AUTO_INCREMENT,
  Event_ID    INT,
  Team_ID     INT,
  Frame_ID    INT,
  FOREIGN KEY (Event_ID) REFERENCES Events(Event_ID),
  FOREIGN KEY (Team_ID) REFERENCES Team(Team_ID),
  FOREIGN KEY (Frame_ID) REFERENCES Frame(Frame_ID)
);

CREATE TABLE Statistics (
  Stat_ID           INT primary key AUTO_INCREMENT,
  Player_ID         INT,
  Strikes           INT NOT NULL default 0,
  Perfect_Games     INT NOT NULL default 0,
  Spares            INT NOT NULL default 0,
  Best_Score        INT NOT NULL default 0,
  Worst_Score       INT NOT NULL default 0,
  Pins_Left         INT NOT NULL default 0,
  Average_Pin_Left  INT NOT NULL default 0,
  FOREIGN KEY (Player_ID) REFERENCES Players(Player_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

INSERT INTO Ball(Color, Weight, Size)
Values('hello world', 10, 'XS');

INSERT INTO Ball(Color, Weight, Size)
Values('this is cONnecting', 05, 'S');

INSERT INTO Ball(Color, Weight, Size)
Values('to an', 08, 'M');

INSERT INTO Ball(Color, Weight, Size)
Values('azure database', 15, 'XL');

INSERT INTO Ball(Color, Weight, Size)
Values('azure database', 15, 1);
select * from ball;