-- This file contains all SQL code that will create the triggers in the bowling database. 

-- This trigger automatically creates the date for when the player joins.

/*
CREATE TRIGGER trigger_name
  [before | after]
  [delete | insert | update [of column]]
  [for each row]
  ....
 */

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

