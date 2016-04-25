-- This file contains all SQL code that will create the triggers in the bowling database. 

-- This trigger automatically creates the date for when the player joins.

-- CREATE TRIGGER trigger_name
--   [before | after]
--   [delete | insert | update [of column]]
--   [for each row]

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


-- Other triggers for archiving other tables
drop trigger if exists delete_from_ball;
CREATE TRIGGER delete_from_ball AFTER DELETE ON Ball
  FOR EACH ROW
  insert into Ball_Archive VALUES (old.Ball_ID,
    old.Color, old.Weight, old.Size, old.Date_Added, old.Last_Date_Modified, now());

drop trigger if exists delete_from_player;
CREATE TRIGGER delete_from_player AFTER DELETE ON Players
  FOR EACH ROW
  insert into Players_Archive VALUES (old.Player_ID,
    old.Gender, old.Phone_Number, old.Date_Joined, old.Date_of_Birth, old.Street_Address,
    old.City, old.State, old.Zip_Code, old.First_Name, old.Last_Name, old.Middle_Initial,
    old.Email, old.Password, old.Is_Admin, old.Reset_Key, old.Date_Added,
                                      old.Last_Date_Modified, now());

drop trigger if exists delete_from_teams;
CREATE TRIGGER delete_from_teams AFTER DELETE ON Team
  FOR EACH ROW
  insert into Team_Archive VALUES (old.TEAM_ID, old.Name, old.Leader,
    old.Date_Created, old.Game_Count, old.Win_Count, old.Player_1,
    old.Player_2, old.Player_3, old.Player_4, old.Player_5,
    old.Date_Added, old.Last_Date_Modified, now());

drop trigger if exists delete_from_Frame;
CREATE TRIGGER delete_from_Frame AFTER DELETE ON Frame
FOR EACH ROW
  insert into Frame_Archive VALUES (old.Frame_ID, old.Frame_Number,
    old.Player_ID, old.Roll_One_ID, old.Roll_Two_ID, old.Roll_Three_ID,
    old.Score, old.Team_ID, old.Game_ID, old.Date_Added, old.Last_Date_Modified, now());

drop trigger if exists delete_from_Roll;
CREATE TRIGGER delete_from_Roll AFTER DELETE ON Roll
FOR EACH ROW
  insert into Roll_Archive VALUES (old.Roll_ID,
    old.Frame_ID, old.Ball_ID, old.Is_Strike, old.Is_Spare,
    old.Is_Foul, old.Hit_Pin_1, old.Hit_Pin_2, old.Hit_Pin_3,
    old.Hit_Pin_4, old.Hit_Pin_5, old.Hit_Pin_6, old.Hit_Pin_7,
    old.Hit_Pin_8, old.Hit_Pin_9, old.Hit_Pin_10, old.Date_Added, old.Last_Date_Modified, now());

drop trigger if exists delete_from_Game;
CREATE TRIGGER delete_from_Game AFTER DELETE ON Game
FOR EACH ROW
  insert into Game_Archive VALUES (old.Game_ID, old.Teams,
    old.Game_Start_Time, old.Game_End_Time, old.Winner_Team_ID,
    old.Title, old.Location_ID, old.Event_Type, old.Game_Finished ,
    old.Date_Added, old.Last_Date_Modified, now());

drop trigger if exists delete_from_PlayerStats;
CREATE TRIGGER delete_from_PlayerStats AFTER DELETE ON Player_Stats
FOR EACH ROW
  insert into Player_Stats_Archive VALUES (old.Stat_ID, old.Player_ID,
    old.Strikes, old.Games_Played, old.Perfect_Games, old.Spares,
    old.Best_Score, old.Worst_Score, old.Pins_Left, old.Average_Pin_Left, old.Date_Added,
    old.Last_Date_Modified, old.Foul_Count, old.Pins_Hit, now());

drop trigger if exists delete_from_game_location;
CREATE TRIGGER delete_from_game_location AFTER DELETE ON Game_Location
FOR EACH ROW
  insert into Game_Location_Archive VALUES (old.Game_Location_ID,
    old.Game_Address, old.Game_Location_Name, old.Date_Added,
    old.Last_Date_Modified, now());

drop trigger if exists update_player_stats;
CREATE TRIGGER update_player_stats AFTER INSERT ON Roll
  for each ROW
  begin
  UPDATE bowling.Player_Stats, Frame
  set bowling.Player_Stats.Pins_Hit = bowling.Player_Stats.Pins_Hit +
    new.Hit_Pin_1 + new.Hit_Pin_2 + new.Hit_Pin_3 + new.Hit_Pin_4 + new.Hit_Pin_5 +
    new.Hit_Pin_6 + new.Hit_Pin_7 + new.Hit_Pin_8 + new.Hit_Pin_9 + new.Hit_Pin_10
  where (new.Frame_ID = Frame.Frame_ID) and frame.Player_ID = Player_Stats.Player_ID;

  if(new.Is_Spare = 1) THEN
    update Player_Stats, Frame
    SET Player_Stats.Spares = Player_Stats.Spares + 1
    where (new.Frame_ID = Frame.Frame_ID) and frame.Player_ID = Player_Stats.Player_ID;
  ELSEIF (new.Is_Strike = 1) THEN
    update Player_Stats, Frame
    SET Player_Stats.Strikes = Player_Stats.Strikes + 1
    where (new.Frame_ID = Frame.Frame_ID) and frame.Player_ID = Player_Stats.Player_ID;
  ELSEIF (new.Is_Foul = 1) THEN
    update Player_Stats, Frame
    SET Player_Stats.Foul_Count = Player_Stats.Foul_Count + 1
    where (new.Frame_ID = Frame.Frame_ID) and frame.Player_ID = Player_Stats.Player_ID;
  END IF;
end;

CREATE FUNCTION SPLIT_STR(
  x VARCHAR(255),
  delim VARCHAR(12),
  pos INT
)
  RETURNS VARCHAR(255)
  RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(x, delim, pos),
                           LENGTH(SUBSTRING_INDEX(x, delim, pos -1)) + 1),
                 delim, '');

drop trigger if exists created_new_game;
CREATE TRIGGER created_new_game after insert ON Game
FOR EACH ROW
  BEGIN
    DECLARE team INT DEFAULT 0;
    label1: LOOP
      SET team = team + 1;
      IF team < 20 THEN
        update Team
        set Team.Game_Count = Team.Game_Count + 1
        where Team_ID = SPLIT_STR(new.Teams, ',', team);

        update Player_Stats ps
          JOIN Team t
          ON t.Leader = ps.Player_ID or t.Player_1 = ps.Player_ID or
             t.Player_2 = ps.Player_ID or t.Player_3 = ps.Player_ID OR
             t.Player_4 = ps.Player_ID or t.Player_5 = ps.Player_ID
        set ps.Games_Played = ps.Games_Played + 1
        where t.Team_ID = SPLIT_STR(new.Teams, ',', team);

        ITERATE label1;
      END IF;
      LEAVE label1;
    END LOOP label1;
  END;

drop trigger if exists update_win_count;
CREATE TRIGGER update_win_count after update ON game
FOR EACH ROW
  if(new.Game_Finished = 1 and new.Winner_Team_ID > 0) THEN
    update team
      set Win_Count = Win_Count + 1 where game.Winner_Team_ID = Team.Team_ID;
  END IF;



drop trigger if exists Date_Added_Ball;
CREATE TRIGGER Date_Added_Ball BEFORE INSERT ON Ball
FOR EACH ROW
  SET NEW.Date_Added = NOW();

drop trigger if exists Date_Added_Game_Location;
CREATE TRIGGER Date_Added_Game_Location BEFORE INSERT ON Game_Location
FOR EACH ROW
  SET NEW.Date_Added = NOW();

drop trigger if exists Date_Added_Game_Frame;
CREATE TRIGGER Date_Added_Game_Frame BEFORE INSERT ON Frame
FOR EACH ROW
  SET NEW.Date_Added = NOW();

drop trigger if exists Date_Added_Game;
CREATE TRIGGER Date_Added_Game BEFORE INSERT ON Game
FOR EACH ROW
  SET NEW.Date_Added = NOW();

drop trigger if exists Date_Added_Player_Stats;
CREATE TRIGGER Date_Added_Player_Stats BEFORE INSERT ON Player_Stats
FOR EACH ROW
  SET NEW.Date_Added = NOW();

drop trigger if exists Date_Added_Player;
CREATE TRIGGER Date_Added_Player BEFORE INSERT ON Players
FOR EACH ROW
  SET NEW.Date_Added = NOW();

drop trigger if exists Date_Added_Roll;
CREATE TRIGGER Date_Added_Roll BEFORE INSERT ON Roll
FOR EACH ROW
  SET NEW.Date_Added = NOW();

drop trigger if exists Date_Added_Team;
CREATE TRIGGER Date_Added_Team BEFORE INSERT ON Team
FOR EACH ROW
  SET NEW.Date_Added = NOW();

-- Trigger for last date modified

drop trigger if exists Last_Date_Modified_Ball;
CREATE TRIGGER Last_Date_Modified_Ball BEFORE UPDATE ON Ball
FOR EACH ROW
  SET NEW.Last_Date_Modified  = NOW();

drop trigger if exists Last_Date_Modified_Game_Location;
CREATE TRIGGER Last_Date_Modified_Game_Location BEFORE UPDATE ON Game_Location
FOR EACH ROW
  SET NEW.Last_Date_Modified  = NOW();

drop trigger if exists Last_Date_Modified_Frame;
CREATE TRIGGER Last_Date_Modified_Frame BEFORE UPDATE ON Frame
FOR EACH ROW
  SET NEW.Last_Date_Modified  = NOW();

drop trigger if exists Last_Date_Modified_Game;
CREATE TRIGGER Last_Date_Modified_Game BEFORE UPDATE ON Game
FOR EACH ROW
  SET NEW.Last_Date_Modified  = NOW();

drop trigger if exists Last_Date_Modified_Player_Stats;
CREATE TRIGGER  Last_Date_Modified_Player_Stats BEFORE UPDATE ON Player_Stats
FOR EACH ROW
  SET NEW.Last_Date_Modified  = NOW();

drop trigger if exists Last_Date_Modified_Players;
CREATE TRIGGER Last_Date_Modified_Players BEFORE UPDATE ON Players
FOR EACH ROW
  SET NEW.Last_Date_Modified  = NOW();

drop trigger if exists Last_Date_Modified_Roll;
CREATE TRIGGER Last_Date_Modified_Roll BEFORE UPDATE ON Roll
FOR EACH ROW
  SET NEW.Last_Date_Modified  = NOW();

drop trigger if exists Last_Date_Modified_Team;
CREATE TRIGGER Last_Date_Modified_Team BEFORE UPDATE ON Team
FOR EACH ROW
  SET NEW.Last_Date_Modified = NOW();

