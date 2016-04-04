-- This file contains all SQL code that will create the triggers in the bowling database. 

-- This trigger automatically creates the date for when the player joins.

/*
CREATE TRIGGER trigger_name
  [before | after]
  [delete | insert | update [of column]]
  [for each row]
  ....
 */
use bowling;

drop trigger if exists players_date_joined;
CREATE TRIGGER players_date_joined BEFORE INSERT ON Players
FOR EACH ROW
  SET NEW.Date_Joined = NOW();

drop trigger if exists team_date_joined;
CREATE TRIGGER team_date_joined BEFORE INSERT ON Team
FOR EACH ROW
  SET NEW.Date_Created = NOW();

-- Other triggers for archiving other tables
drop trigger if exists delete_from_ball;
CREATE TRIGGER delete_from_ball AFTER DELETE ON Ball
  FOR EACH ROW
  insert into Ball_Archive VALUES (old.Ball_ID, old.Color, old.Weight, old.Size, now());

drop trigger if exists delete_from_player;
CREATE TRIGGER delete_from_player AFTER DELETE ON Players
  FOR EACH ROW
  insert into Players_Archive VALUES (old.Player_ID, old.Gender, old.Phone_Number, old.Date_Joined, old.Date_of_Birth, old.Street_Address ,old.City, old.State, old.Zip_Code, old.First_Name, old.Last_Name, old.Middle_Initial, old.Email, old.Password, old.Is_Admin, now());

