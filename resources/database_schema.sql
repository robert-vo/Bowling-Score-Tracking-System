
/*
CREATE TABLE format
CREATE TABLE table_name (
  attribute_name  data_type  any_other_special_properties,
  ...,
  ...
  any_other_constraints
);
*/
CREATE DATABASE if NOT exists bowling;
use bowling;

CREATE TABLE Ball (
  Ball_ID  INT          PRIMARY KEY AUTO_INCREMENT,
  Color    VARCHAR(20)  NOT NULL,
  Weight   INT          NOT NULL,
  Size                  ENUM('XS', 'S', 'M', 'L', 'XL', 'XXL') NOT NULL,
  Date_Added            DATETIME,
  Last_Date_Modified    DATETIME,
  CHECK (Weight > 0)
);

CREATE TABLE Players (
  Player_ID           INT             PRIMARY KEY AUTO_INCREMENT,
  Gender              ENUM('F', 'M')  NOT NULL,
  Phone_Number        VARCHAR(15),
  Date_Joined         DATE,
  Date_Of_Birth       DATE            NOT NULL,
  Street_Address      VARCHAR(30)     NOT NULL,
  City                VARCHAR(30)     NOT NULL,
  State               VARCHAR(15)     NOT NULL,
  Zip_Code            INT             NOT NULL,
  First_Name          VARCHAR(30)     NOT NULL,
  Last_Name           VARCHAR(30)     NOT NULL,
  Middle_Initial      VARCHAR(1),
  Email               VARCHAR(30)     NOT NULL UNIQUE,
  Password            VARCHAR(256)    NOT NULL,
  Is_Admin            BOOLEAN         DEFAULT FALSE,
  Reset_Key           VARCHAR(100)    DEFAULT '',
  Date_Added          DATETIME,
  Last_Date_Modified  DATETIME

);

CREATE TABLE Team (
  Team_ID             INT             PRIMARY KEY AUTO_INCREMENT,
  Name                VARCHAR(50)	    NOT NULL,
  Leader              INT			        NOT NULL,
  Date_Created        DATETIME,
  Game_Count          INT			        DEFAULT 0,
  Win_Count           INT			        DEFAULT 0,
  Player_1	          INT             NULL,
  Player_2	          INT             NULL,
  Player_3	          INT             NULL,
  Player_4	          INT             NULL,
  Player_5	          INT             NULL,
  Date_Added          DATETIME,
  Last_Date_Modified  DATETIME,
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

CREATE TABLE Game_Location (
  Game_Location_ID    INT PRIMARY KEY AUTO_INCREMENT,
  Game_Address        VARCHAR(100) not null,
  Game_Location_Name  VARCHAR(100) not null,
  Date_Added          DATETIME,
  Last_Date_Modified  DATETIME
);

CREATE TABLE Game (
  Game_ID             INT PRIMARY KEY AUTO_INCREMENT,
  Teams               VARCHAR(100) not null, -- CSV of all teams
  Game_Start_Time     DATETIME,
  Game_End_Time       DATETIME,
  Winner_Team_ID      INT          null,
  Title               VARCHAR(100)  not null,
  Location_ID         INT,
  Event_Type          ENUM('Casual', 'Tournament') DEFAULT 'Casual',
  Game_Finished       BOOLEAN DEFAULT FALSE,
  Date_Added          DATETIME,
  Last_Date_Modified  DATETIME,
  FOREIGN KEY (Winner_Team_ID) REFERENCES Team(Team_ID),
  FOREIGN KEY (Location_ID) REFERENCES Game_Location(Game_Location_ID)
);

CREATE TABLE Frame(
  Frame_ID            INT PRIMARY KEY AUTO_INCREMENT,
  Frame_Number        INT NOT NULL DEFAULT 0,
  Player_ID           INT,
  Roll_One_ID         INT,
  Roll_Two_ID         INT,
  Roll_Three_ID       INT,
  Score               INT DEFAULT 0,
  Team_ID             INT,
  Game_ID             INT,
  Date_Added          DATETIME,
  Last_Date_Modified  DATETIME,
  FOREIGN KEY (Player_ID) REFERENCES Players(Player_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (Team_ID) REFERENCES Team(Team_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (Game_ID) REFERENCES Game(Game_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CHECK (Frame_Number BETWEEN 1 and 10),
  CHECK (Score BETWEEN 0 and 300)
);

CREATE TABLE Roll (
  Roll_ID             INT     PRIMARY KEY AUTO_INCREMENT,
  Frame_ID            INT     NOT NULL,
  Ball_ID             INT,
  Is_Strike           BOOLEAN NOT NULL DEFAULT FALSE,
  Is_Spare            BOOLEAN NOT NULL DEFAULT FALSE,
  Is_Foul             BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_1		        BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_2		        BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_3		        BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_4		        BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_5		        BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_6		        BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_7		        BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_8		        BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_9		        BOOLEAN NOT NULL DEFAULT FALSE,
  Hit_Pin_10	        BOOLEAN NOT NULL DEFAULT FALSE,
  Date_Added          DATETIME,
  Last_Date_Modified  DATETIME,
  FOREIGN KEY (Ball_ID) REFERENCES Ball(Ball_ID)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  FOREIGN KEY (Frame_ID) REFERENCES Frame(Frame_ID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE Player_Stats (
  Stat_ID             INT PRIMARY KEY AUTO_INCREMENT,
  Player_ID           INT UNIQUE,
  Strikes             INT NOT NULL DEFAULT 0,
  Games_Played        INT NOT NULL DEFAULT 0,
  Perfect_Games       INT NOT NULL DEFAULT 0,
  Spares              INT NOT NULL DEFAULT 0,
  Best_Score          INT NOT NULL DEFAULT 0,
  Worst_Score         INT NOT NULL DEFAULT 0,
  Pins_Left           INT NOT NULL DEFAULT 0,
  Average_Pin_Left    DOUBLE NOT NULL DEFAULT 0,
  Date_Added          DATETIME,
  Last_Date_Modified  DATETIME,
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
