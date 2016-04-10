-- This file contains all SQL code that will create the triggers in the bowling database. 

-- This trigger automatically creates the date for when the player joins.

# CREATE TRIGGER trigger_name
#   [before | after]
#   [delete | insert | update [of column]]
#   [for each row]

CREATE DATABASE if NOT exists bowling;
use bowling;

-- Auto populates the Date_Joined attribute of Players to the current time.
drop trigger if exists players_date_joined;
CREATE TRIGGER players_date_joined BEFORE INSERT ON Players
FOR EACH ROW
  SET NEW.Date_Joined = NOW();

drop trigger if exists team_date_joined;
CREATE TRIGGER team_date_joined BEFORE INSERT ON Team
FOR EACH ROW
  SET NEW.Date_Created = NOW();

drop trigger if exists game_start_time;
CREATE TRIGGER game_start_time BEFORE INSERT ON Game
FOR EACH ROW
  SET NEW.Game_Start_Time = NOW();

drop trigger if exists game_finished;
DELIMITER $$
CREATE TRIGGER game_finished before UPDATE ON Game
FOR EACH ROW
  BEGIN
    if (new.Game_Finished = true) then
        set new.Game_End_Time = now();
    end IF;
end$$
DELIMITER ;

-- Other triggers for archiving other tables
drop trigger if exists delete_from_ball;
CREATE TRIGGER delete_from_ball AFTER DELETE ON Ball
  FOR EACH ROW
  insert into Ball_Archive VALUES (old.Ball_ID, old.Color, old.Weight, old.Size, now());

drop trigger if exists delete_from_player;
CREATE TRIGGER delete_from_player AFTER DELETE ON Players
  FOR EACH ROW
  insert into Players_Archive VALUES (old.Player_ID, old.Gender, old.Phone_Number, old.Date_Joined, old.Date_of_Birth, old.Street_Address ,old.City, old.State, old.Zip_Code, old.First_Name, old.Last_Name, old.Middle_Initial, old.Email, old.Password, old.Is_Admin, old.Reset_Key, now());

drop trigger if exists delete_from_teams;
CREATE TRIGGER delete_from_teams AFTER DELETE ON Team
  FOR EACH ROW
  insert into Team_Archive VALUES (old.TEAM_ID, old.Name, old.Leader, old.Date_Created, old.Game_Count, old.Win_Count, old.Player_1, old.Player_2, old.Player_3, old.Player_4, old.Player_5, now());

drop trigger if exists delete_from_Frame;
CREATE TRIGGER delete_from_Frame AFTER DELETE ON Frame
FOR EACH ROW
  insert into Frame_Archive VALUES (old.Frame_ID, old.Frame_Number, old.Player_ID, old.Roll_One_ID, old.Roll_Two_ID, old.Roll_Three_ID, old.Score, old.Team_ID, old.Game_ID, now());

drop trigger if exists delete_from_Roll;
CREATE TRIGGER delete_from_Roll AFTER DELETE ON Roll
FOR EACH ROW
  insert into Roll_Archive VALUES (old.Roll_ID, old.Frame_ID, old.Ball_ID, old.Is_Strike, old.Is_Spare, old.Is_Foul, old.Hit_Pin_1, old.Hit_Pin_2, old.Hit_Pin_3, old.Hit_Pin_4, old.Hit_Pin_5, old.Hit_Pin_6, old.Hit_Pin_7, old.Hit_Pin_8, old.Hit_Pin_9, old.Hit_Pin_10, now());

drop trigger if exists delete_from_Game;
CREATE TRIGGER delete_from_Game AFTER DELETE ON Game
FOR EACH ROW
  insert into Game_Archive VALUES (old.Game_ID, old.Teams, old.Game_Start_Time, old.Game_End_Time, old.Winner_Team_ID, old.Title, old.Location_ID, old.Event_Type, old.Game_Finished , now());

drop trigger if exists delete_from_PlayerStats;
CREATE TRIGGER delete_from_PlayerStats AFTER DELETE ON Player_Stats
FOR EACH ROW
  insert into Player_Stats_Archive VALUES (old.Stat_ID, old.Player_ID, old.Strikes, old.Games_Played, old.Perfect_Games, old.Spares, old.Best_Score, old.Worst_Score, old.Pins_Left, old.Average_Pin_Left, now());

drop trigger if exists delete_from_game_location;
CREATE TRIGGER delete_from_game_location AFTER DELETE ON Game_Location
FOR EACH ROW
  insert into Game_Location_Archive VALUES (old.Game_Location_ID, old.Game_Address, old.Game_Location_Name, now());


-- Trigger for date_added

drop trigger if exists date_added;
CREATE TRIGGER date_added BEFORE INSERT ON ball
FOR EACH ROW
  SET NEW.date_added = NOW();

drop trigger if exists date_added;
CREATE TRIGGER date_added BEFORE INSERT ON bowling_events
FOR EACH ROW
  SET NEW.date_added = NOW();


drop trigger if exists date_added;
CREATE TRIGGER date_added BEFORE INSERT ON frame
FOR EACH ROW
  SET NEW.date_added = NOW();


drop trigger if exists date_added;
CREATE TRIGGER date_added BEFORE INSERT ON game
FOR EACH ROW
  SET NEW.date_added = NOW();

drop trigger if exists date_added;
CREATE TRIGGER date_added BEFORE INSERT ON player_stats
FOR EACH ROW
  SET NEW.date_added = NOW();


drop trigger if exists date_added;
CREATE TRIGGER date_added BEFORE INSERT ON players
FOR EACH ROW
  SET NEW.date_added = NOW();

drop trigger if exists date_added;
CREATE TRIGGER date_added BEFORE INSERT ON roll
FOR EACH ROW
  SET NEW.date_added = NOW();

drop trigger if exists date_added;
CREATE TRIGGER date_added BEFORE INSERT ON team
FOR EACH ROW
  SET NEW.date_added = NOW();

-- Trigger for last date modified

drop trigger if exists last_date_modified;
CREATE TRIGGER last_date_modified BEFORE INSERT ON ball
FOR EACH ROW
  SET NEW.last_date_modified = NOW();

drop trigger if exists last_date_modified;
CREATE TRIGGER last_date_modified BEFORE INSERT ON bowling_events
FOR EACH ROW
  SET NEW.last_date_modified = NOW();

drop trigger if exists last_date_modified;
CREATE TRIGGER last_date_modified BEFORE INSERT ON frame
FOR EACH ROW
  SET NEW.last_date_modified = NOW();

drop trigger if exists last_date_modified;
CREATE TRIGGER last_date_modified BEFORE INSERT ON game
FOR EACH ROW
  SET NEW.last_date_modified = NOW();

drop trigger if exists last_date_modified;
CREATE TRIGGER last_date_modified BEFORE INSERT ON player_stats
FOR EACH ROW
  SET NEW.last_date_modified = NOW();

drop trigger if exists last_date_modified;
CREATE TRIGGER last_date_modified BEFORE INSERT ON players
FOR EACH ROW
  SET NEW.last_date_modified = NOW();

drop trigger if exists last_date_modified;
CREATE TRIGGER last_date_modified BEFORE INSERT ON roll
FOR EACH ROW
  SET NEW.last_date_modified = NOW();

drop trigger if exists last_date_modified;
CREATE TRIGGER last_date_modified BEFORE INSERT ON team
FOR EACH ROW
  SET NEW.last_date_modified = NOW();
