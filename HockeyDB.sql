DROP TABLE Goalie;
DROP TABLE Defense;
DROP TABLE Forward;
DROP TABLE Statistics_Of;
DROP TABLE Injury_Can_Have;
DROP TABLE Hockey_Player_ID;
DROP TABLE Hockey_Player_In;
DROP TABLE Record_Has_A;
DROP TABLE Staff_In;
DROP TABLE Team_Part_Of;
DROP TABLE Arena;
DROP TABLE Awards;
DROP TABLE Trophy;
DROP TABLE League;

CREATE TABLE Trophy (
    name    CHAR(50),
    t_year  INTEGER,
    winner  CHAR(50) NOT NULL,
    PRIMARY KEY (name, t_year)
);

CREATE TABLE League (
    league_name CHAR(50),
    PRIMARY KEY (league_name)
);

CREATE TABLE Awards (
    name        CHAR(50),
    a_year      INTEGER,
    league_name CHAR(50),
    PRIMARY KEY (name, a_year, league_name),
    FOREIGN KEY (name, a_year) REFERENCES Trophy ON DELETE CASCADE,
    FOREIGN KEY (league_name) REFERENCES League ON DELETE CASCADE
);

CREATE TABLE Arena (
    city    CHAR(50),
    arena   CHAR(50),
    PRIMARY KEY (city)
);

CREATE TABLE Team_Part_Of (
    team_name   CHAR(50),
    city        CHAR(50),
    league_name CHAR(50),
    PRIMARY KEY (team_name),
    FOREIGN KEY (city) REFERENCES Arena ON DELETE CASCADE
);

CREATE TABLE Staff_In (
    staff_id            INTEGER,
    first_name          CHAR(50),
    last_name           CHAR(50),
    stanley_cups_won    INTEGER,
    team_name           CHAR(50),
    PRIMARY KEY (staff_id),
    FOREIGN KEY (team_name) REFERENCES Team_Part_Of ON DELETE CASCADE
);

CREATE TABLE Record_Has_A (
    friendly_team_name      CHAR(50),
    opposing_team_name      CHAR(50),
    record_date             DATE,
    friendly_team_score     INTEGER,
    opposing_team_score     INTEGER,
    winning_team            CHAR(50),
    PRIMARY KEY(friendly_team_name, opposing_team_name, record_date),
    FOREIGN KEY(friendly_team_name) REFERENCES Team_Part_Of ON DELETE CASCADE,
    FOREIGN KEY(opposing_team_name) REFERENCES Team_Part_Of ON DELETE CASCADE
);

CREATE TABLE Hockey_Player_In (
    team_name       CHAR(50),
    jersey_number   INTEGER,
    first_name      CHAR(50),
    last_name       CHAR(50),
    age             INTEGER,
    handedness      CHAR(50),
    PRIMARY KEY (team_name,jersey_number),
    FOREIGN KEY (team_name) REFERENCES Team_Part_Of ON DELETE CASCADE
);

CREATE TABLE Hockey_Player_ID (
    hockey_player_id    INTEGER,
    jersey_number       INTEGER,
    team_name           CHAR(50),
    PRIMARY KEY (hockey_player_id),
    FOREIGN KEY (team_name, jersey_number) REFERENCES Hockey_Player_In ON DELETE CASCADE
);

CREATE TABLE Injury_Can_Have (
    injury_id           INTEGER,
    injury_type         CHAR(50),
    injury_date         DATE,
    hockey_player_id    INTEGER,
    PRIMARY KEY (injury_id),
    FOREIGN KEY (hockey_player_id) REFERENCES Hockey_Player_ID ON DELETE CASCADE
);

CREATE TABLE Statistics_Of (
    stat_id                 INTEGER,
    games_played            INTEGER,
    goals                   INTEGER,
    assists                 INTEGER,
    points                  INTEGER,
    goals_against_average   FLOAT,
    save_percentage         FLOAT,
    hockey_player_id        INTEGER,
    PRIMARY KEY (stat_id),
    FOREIGN KEY (hockey_player_id) REFERENCES Hockey_Player_ID ON DELETE CASCADE
);

CREATE TABLE Forward (
    hockey_player_id    INTEGER,
    forward_position    CHAR(50),
    forward_type        CHAR(50),
    primary key (hockey_player_id),
    FOREIGN KEY (hockey_player_id) REFERENCES Hockey_Player_ID ON DELETE CASCADE
);
  
CREATE TABLE Defense (
    hockey_player_id    INTEGER,
    defense_position    CHAR(50),
    defense_type        CHAR(50),
    primary key (hockey_player_id),
    FOREIGN KEY (hockey_player_id) REFERENCES Hockey_Player_ID ON DELETE CASCADE
);
  
CREATE TABLE Goalie (
    hockey_player_id    INTEGER,
    goalie_type         CHAR(50),
    primary key (hockey_player_id),
    FOREIGN KEY (hockey_player_id) REFERENCES Hockey_Player_ID ON DELETE CASCADE
);

INSERT INTO Trophy VALUES ('The Stanley Cup', 2020, 'Tampa Bay Lightning');
INSERT INTO Trophy VALUES ('Conn Smythe Trophy', 2016, 'Sidney Crosby');
INSERT INTO Trophy VALUES ('Conn Smythe Trophy', 2021, 'Connor McDavid');
INSERT INTO Trophy VALUES ('Hart Memorial Trophy', 2021, 'Connor McDavid');
INSERT INTO Trophy VALUES ('Calder Memorial Trophy', 2014, 'Nathan MacKinnon');
INSERT INTO Trophy VALUES ('Vezina Trophy', 2009, 'Tim Thomas');

INSERT INTO League VALUES ('National Hockey League');
INSERT INTO League VALUES ('Kontinental Hockey League');
INSERT INTO League VALUES ('American Hockey League');
INSERT INTO League VALUES ('Western Hockey League');
INSERT INTO League VALUES ('Canadian Hockey League');

INSERT INTO Awards VALUES ('The Stanley Cup', 2020, 'National Hockey League');
INSERT INTO Awards VALUES ('Conn Smythe Trophy', 2016, 'National Hockey League');
INSERT INTO Awards VALUES ('Conn Smythe Trophy', 2021, 'National Hockey League');
INSERT INTO Awards VALUES ('Hart Memorial Trophy', 2021, 'National Hockey League');
INSERT INTO Awards VALUES ('Calder Memorial Trophy', 2014, 'National Hockey League');
INSERT INTO Awards VALUES ('Vezina Trophy', 2009, 'National Hockey League');

INSERT INTO Arena VALUES ('Vancouver', 'Rogers Arena');
INSERT INTO Arena VALUES ('Toronto', 'Scotiabank Arena');
INSERT INTO Arena VALUES ('Buffalo', 'KeyBank Center');
INSERT INTO Arena VALUES ('Anaheim', 'Honda Center');
INSERT INTO Arena VALUES ('Boston', 'TD Garden');
INSERT INTO Arena VALUES ('Pittsburgh', 'PPG Paints Arena');
INSERT INTO Arena VALUES ('Seattle', 'Climate Pledge Arena');
INSERT INTO Arena VALUES ('Chicago', 'United Center');
INSERT INTO Arena VALUES ('Edmonton', 'Rogers Place');
INSERT INTO Arena VALUES ('New York', 'UBS Arena');
INSERT INTO Arena VALUES ('Tampa Bay', 'Amalie Arena');
INSERT INTO Arena VALUES ('Colorado', 'Ball Arena');
INSERT INTO Arena VALUES ('New Jersey', 'Prudential Center');
INSERT INTO Arena VALUES ('Washington', 'Capital One Arena');
INSERT INTO Arena VALUES ('Detroit', 'Little Caesars Arena');
INSERT INTO Arena VALUES ('Montreal', 'Bell Centre');

INSERT INTO Team_Part_Of VALUES ('Canucks', 'Vancouver', 'National Hockey League');
INSERT INTO Team_Part_Of VALUES ('Blackhawks', 'Chicago', 'National Hockey League');
INSERT INTO Team_Part_Of VALUES ('Kraken', 'Seattle', 'National Hockey League');
INSERT INTO Team_Part_Of VALUES ('Penguins', 'Pittsburgh', 'National Hockey League');
INSERT INTO Team_Part_Of VALUES ('Bruins', 'Boston', 'National Hockey League');
INSERT INTO Team_Part_Of VALUES ('Oilers', 'Edmonton', 'National Hockey League');
INSERT INTO Team_Part_Of VALUES ('Islanders', 'New York', 'National Hockey League');
INSERT INTO Team_Part_Of VALUES ('Lightning', 'Tampa Bay', 'National Hockey League');
INSERT INTO Team_Part_Of VALUES ('Avalanche', 'Colorado', 'National Hockey League');
INSERT INTO Team_Part_Of VALUES ('Devils', 'New Jersey', 'National Hockey League');
INSERT INTO Team_Part_Of VALUES ('Capitals', 'Washington', 'National Hockey League');
INSERT INTO Team_Part_Of VALUES ('Red Wings', 'Detroit', 'National Hockey League');
INSERT INTO Team_Part_Of VALUES ('Canadiens', 'Montreal', 'National Hockey League');

INSERT INTO Staff_In VALUES (1, 'Mike', 'Sullivan', 2, 'Penguins');
INSERT INTO Staff_In VALUES (2, 'Dave', 'Tippett', 0, 'Oilers');
INSERT INTO Staff_In VALUES (3, 'Travis', 'Green', 0, 'Canucks');
INSERT INTO Staff_In VALUES (4, 'Barry', 'Trotz', 1, 'Islanders');
INSERT INTO Staff_In VALUES (5, 'Jon', 'Cooper', 2, 'Lightning');

INSERT INTO Record_Has_A VALUES ('Canucks', 'Bruins', '03-JAN-2021', 2, 1, 'Canucks');
INSERT INTO Record_Has_A VALUES ('Islanders', 'Blackhawks', '04-MAR-2021', 6, 4, 'Islanders');
INSERT INTO Record_Has_A VALUES ('Bruins', 'Oilers', '28-OCT-2020', 0, 3, 'Oilers');
INSERT INTO Record_Has_A VALUES ('Lightning', 'Kraken', '26-SEP-2021', 4, 8, 'Kraken');
INSERT INTO Record_Has_A VALUES ('Canucks', 'Penguins', '03-OCT-2021', 10, 1, 'Canucks');

INSERT INTO Hockey_Player_In VALUES ('Oilers', 97, 'Connor', 'McDavid', 24, 'Right');
INSERT INTO Hockey_Player_In VALUES ('Penguins', 87, 'Sidney', 'Crosby', 34, 'Right');
INSERT INTO Hockey_Player_In VALUES ('Avalanche', 8, 'Cale', 'Makar', 22, 'Left');
INSERT INTO Hockey_Player_In VALUES ('Blackhawks', 29, 'Marc-Andre', 'Fleury', 36, 'Left');
INSERT INTO Hockey_Player_In VALUES ('Devils', 30, 'Martin', 'Brodeur', 49, 'Right');
INSERT INTO Hockey_Player_In VALUES ('Bruins', 63, 'Brad', 'Marchand', 33, 'Left');
INSERT INTO Hockey_Player_In VALUES ('Capitals', 43, 'Tom', 'Wilson', 27, 'Right');
INSERT INTO Hockey_Player_In VALUES ('Bruins', 37, 'Patrice', 'Bergeron', 36, 'Right');
INSERT INTO Hockey_Player_In VALUES ('Islanders', 33, 'Zdeno', 'Chara', 44, 'Left');
INSERT INTO Hockey_Player_In VALUES ('Red Wings', 24, 'Chris', 'Chelios', 59, 'Right');
INSERT INTO Hockey_Player_In VALUES ('Lightning', 77, 'Victor', 'Hedman', 30, 'Left');
INSERT INTO Hockey_Player_In VALUES ('Capitals', 74, 'John', 'Carlson', 31, 'Right');
INSERT INTO Hockey_Player_In VALUES ('Canucks', 30, 'Kirk', 'McLean', 55, 'Left');
INSERT INTO Hockey_Player_In VALUES ('Bruins', 30, 'Tim', 'Thomas', 47, 'Left');
INSERT INTO Hockey_Player_In VALUES ('Canadiens', 31, 'Carey', 'Price', 34, 'Left');

INSERT INTO Hockey_Player_ID VALUES (1, 97, 'Oilers');
INSERT INTO Hockey_Player_ID VALUES (2, 87, 'Penguins');
INSERT INTO Hockey_Player_ID VALUES (3, 8, 'Avalanche');
INSERT INTO Hockey_Player_ID VALUES (4, 29, 'Blackhawks');
INSERT INTO Hockey_Player_ID VALUES (5, 30, 'Devils');
INSERT INTO Hockey_Player_ID VALUES (6, 63, 'Bruins');
INSERT INTO Hockey_Player_ID VALUES (7, 43, 'Capitals');
INSERT INTO Hockey_Player_ID VALUES (8, 37, 'Bruins');
INSERT INTO Hockey_Player_ID VALUES (9, 33, 'Islanders');
INSERT INTO Hockey_Player_ID VALUES (10, 24, 'Red Wings');
INSERT INTO Hockey_Player_ID VALUES (11, 77, 'Lightning');
INSERT INTO Hockey_Player_ID VALUES (12, 74, 'Capitals');
INSERT INTO Hockey_Player_ID VALUES (13, 30, 'Canucks');
INSERT INTO Hockey_Player_ID VALUES (14, 30, 'Bruins');
INSERT INTO Hockey_Player_ID VALUES (15, 31, 'Canadiens');

INSERT INTO Injury_Can_Have VALUES (1, 'Lower Body Injury', '13-JAN-2021', 1);
INSERT INTO Injury_Can_Have VALUES (2, 'Upper Body Injury', '27-MAY-2016', 2);
INSERT INTO Injury_Can_Have VALUES (3, 'Shoulder', '13-SEP-2017', 3);
INSERT INTO Injury_Can_Have VALUES (4, 'Sprained Ankle', '01-JUN-2020', 4);
INSERT INTO Injury_Can_Have VALUES (5, 'Fractured Rib', '05-MAY-2011', 5);

INSERT INTO Statistics_Of VALUES (1, 412, 201, 386, 587, NULL, NULL, 1);
INSERT INTO Statistics_Of VALUES (2, 1039, 486, 839, 1325, NULL, NULL, 2);
INSERT INTO Statistics_Of VALUES (3, 105, 20, 75, 95, NULL, NULL, 3);
INSERT INTO Statistics_Of VALUES (4, 886, 0, 18, 18, 2.55, 0.913, 4);
INSERT INTO Statistics_Of VALUES (5, 1266, 2, 45, 47, 2.24, 0.912, 5);
INSERT INTO Statistics_Of VALUES (6, 818, 327, 408, 735, NULL, NULL, 6);
INSERT INTO Statistics_Of VALUES (7, 123, 37, 28, 65, NULL, NULL, 7);
INSERT INTO Statistics_Of VALUES (8, 1157, 381, 549, 930, NULL, NULL, 8);
INSERT INTO Statistics_Of VALUES (12, 100, 50, 14, 64, NULL, NULL, 12);

INSERT INTO Forward VALUES (1, 'Center', 'Playmaker');
INSERT INTO Forward VALUES (2, 'Center', 'Playmaker');
INSERT INTO Forward VALUES (6, 'Left Wing', 'Sniper');
INSERT INTO Forward VALUES (7, 'Right Wing', 'Grinder');
INSERT INTO Forward VALUES (8, 'Center', 'Two-Way');

INSERT INTO Defense VALUES (3, 'Right Defense', 'Offensive Defensemen');
INSERT INTO Defense VALUES (9, 'Left Defense', 'Defensive Defensemen');
INSERT INTO Defense VALUES (10, 'Right Defense', 'Enforcer Defensemen');
INSERT INTO Defense VALUES (11, 'Left Defense', 'Two-Way Defensemen');
INSERT INTO Defense VALUES (12, 'Right Defense', 'Offensive Defensemen');

INSERT INTO Goalie VALUES (4, 'Butterfly');
INSERT INTO Goalie VALUES (5, 'Hybrid');
INSERT INTO Goalie VALUES (13, 'Stand-Up');
INSERT INTO Goalie VALUES (14, 'Hybrid');
INSERT INTO Goalie VALUES (15, 'Butterfly');
