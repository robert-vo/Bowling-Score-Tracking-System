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
CREATE DATABASE if NOT exists bowling;

use bowling;

DROP TABLE IF EXISTS Game;
DROP TABLE IF EXISTS Events;
DROP TABLE IF EXISTS Statistics;
DROP TABLE IF EXISTS Frame;
DROP TABLE IF EXISTS Roll;
DROP TABLE IF EXISTS Team;
DROP TABLE IF EXISTS Ball;
DROP TABLE IF EXISTS Players;

CREATE TABLE Ball (
  Ball_ID  INT          PRIMARY KEY AUTO_INCREMENT,
  Color    VARCHAR(20)  NOT NULL,
  Weight   INT          NOT NULL,
  Size     ENUM('XS', 'S', 'M', 'L', 'XL', 'XXL') NOT NULL,
  CHECK (Weight > 0)
);

CREATE TABLE Players (
  Player_ID       INT             PRIMARY KEY AUTO_INCREMENT,
  Gender          ENUM('F', 'M')  NOT NULL,
  Phone_Number    VARCHAR(15),
  Date_Joined     DATE            ,
  Date_Of_Birth   DATE            NOT NULL,
  Street_Address  VARCHAR(30)     NOT NULL,
  City            VARCHAR(30)     NOT NULL,
  State           VARCHAR(15)     NOT NULL,
  Zip_Code        INT             NOT NULL,
  First_Name      VARCHAR(30)     NOT NULL,
  Last_Name       VARCHAR(30)     NOT NULL,
  Middle_Initial  VARCHAR(1),
  Email           VARCHAR(30)     NOT NULL UNIQUE,
  Password        VARCHAR(256)    NOT NULL,
  Is_Admin        BOOLEAN         DEFAULT FALSE
);

CREATE TABLE Team (
  Team_ID        INT            PRIMARY KEY AUTO_INCREMENT,
  Name           VARCHAR(50)	  NOT NULL,
  Leader         INT			      NOT NULL,
  Date_Created   DATETIME,
  Game_Count     INT			      DEFAULT 0,
  Win_Count      INT			      DEFAULT 0,
  Player_1	     INT            NULL,
  Player_2	     INT            NULL,
  Player_3	     INT            NULL,
  Player_4	     INT            NULL,
  Player_5	     INT            NULL,
  FOREIGN KEY    (Leader)       REFERENCES Players(Player_ID)
    ON DELETE RESTRICT,
  FOREIGN KEY    (Player_1)     REFERENCES Players(Player_ID)
    ON DELETE RESTRICT,
  FOREIGN KEY    (Player_2)     REFERENCES Players(Player_ID)
    ON DELETE RESTRICT,
  FOREIGN KEY    (Player_3)     REFERENCES Players(Player_ID)
    ON DELETE RESTRICT,
  FOREIGN KEY    (Player_4)     REFERENCES Players(Player_ID)
    ON DELETE RESTRICT,
  FOREIGN KEY    (Player_5)     REFERENCES Players(Player_ID)
    ON DELETE RESTRICT,
  CHECK (Game_Count >= 0),
  CHECK (Win_Count >= 0)
);

CREATE TABLE Bowling_Events (
  Event_ID    INT PRIMARY KEY AUTO_INCREMENT,
  Team_ID     INT,
  Event_Time  DATETIME,
  Winner      VARCHAR(20),
  Title       VARCHAR(20),
  Location    VARCHAR(50),
  Event_Type  ENUM('Casual', 'Tournament') DEFAULT 'Casual',
  FOREIGN KEY (Team_ID) REFERENCES Team(Team_ID)
);

CREATE TABLE Frame(
  Frame_ID        INT PRIMARY KEY AUTO_INCREMENT,
  Frame_Number    INT NOT NULL DEFAULT 0,
  Player_ID       INT,
  Roll_One_ID     INT,
  Roll_Two_ID     INT,
  Roll_Three_ID   INT,
  Score           INT DEFAULT 0,
  Team_ID         INT,
  Event_ID        INT,
  FOREIGN KEY (Player_ID) REFERENCES Players(Player_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (Team_ID) REFERENCES Team(Team_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (Event_ID) REFERENCES Bowling_Events(Event_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CHECK (Frame_Number BETWEEN 1 and 10),
  CHECK (Score BETWEEN 0 and 300)
);

CREATE TABLE Roll (
  Roll_ID     INT     PRIMARY KEY AUTO_INCREMENT,
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

CREATE TABLE Game (
  Game_ID     INT PRIMARY KEY AUTO_INCREMENT,
  Event_ID    INT,
  Teams       VARCHAR(100) not null, -- CSV of all teams
  FOREIGN KEY (Event_ID) REFERENCES Bowling_Events(Event_ID)
);

CREATE TABLE Player_Stats (
  Stat_ID           INT PRIMARY KEY AUTO_INCREMENT,
  Player_ID         INT UNIQUE,
  Strikes           INT NOT NULL DEFAULT 0,
  Games_Played      INT NOT NULL DEFAULT 0,
  Perfect_Games     INT NOT NULL DEFAULT 0,
  Spares            INT NOT NULL DEFAULT 0,
  Best_Score        INT NOT NULL DEFAULT 0,
  Worst_Score       INT NOT NULL DEFAULT 0,
  Pins_Left         INT NOT NULL DEFAULT 0,
  Average_Pin_Left  DOUBLE NOT NULL DEFAULT 0,
  FOREIGN KEY (Player_ID) REFERENCES Players(Player_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CHECK (Strikes >= 0),
  CHECK (Games_Played >= 0),
  CHECK (Perfect_Games >= 0),
  CHECK (Spares >= 0),
  CHECK (Best_Score >= 0),
  CHECK (Worst_Score >= 0),
  CHECK (Pins_Left >= 0),
  CHECK (Average_Pin_Left >= 0)
);
