-- Clear DB
DELETE FROM `Genres` WHERE 1;
DELETE FROM `GenresInVid` WHERE 1;
DELETE FROM `MemberContactInfo` WHERE 1;
DELETE FROM `Members` WHERE 1;
DELETE FROM `MembersInVid` WHERE 1;
DELETE FROM `MembersHistory` WHERE 1;
DELETE FROM `Performances` WHERE 1;
DELETE FROM `Pictures` WHERE 1;
DELETE FROM `Positions` WHERE 1;
DELETE FROM `Videos` WHERE 1;

-- Insert Genres
INSERT INTO Genres (idGenres, genreName) VALUES ( 0, "mixed" );
INSERT INTO Genres (idGenres, genreName) VALUES ( 1, "salsa" );
INSERT INTO Genres (idGenres, genreName) VALUES ( 2, "bachata" );
INSERT INTO Genres (idGenres, genreName) VALUES ( 3, "merengue" );
INSERT INTO Genres (idGenres, genreName) VALUES ( 4, "cumbia" );
INSERT INTO Genres (idGenres, genreName) VALUES ( 5, "reggaeton" );
INSERT INTO Genres (idGenres, genreName) VALUES ( 6, "cha-cha-cha" );
INSERT INTO Genres (idGenres, genreName) VALUES ( 7, "banda" );
INSERT INTO Genres (idGenres, genreName) VALUES ( 8, "zouk" );
INSERT INTO Genres (idGenres, genreName) VALUES ( 9, "tango" );
INSERT INTO Genres (idGenres, genreName) VALUES ( 10, "modern" );

-- Insert Positions
INSERT INTO Positions (idPositions, position) VALUES ( 0, "General Body Member" );
INSERT INTO Positions (idPositions, position) VALUES ( 1, "Head Choreographer" );
INSERT INTO Positions (idPositions, position) VALUES ( 2, "President" );
INSERT INTO Positions (idPositions, position) VALUES ( 3, "Vice-President" );
INSERT INTO Positions (idPositions, position) VALUES ( 4, "Treasurer" );
INSERT INTO Positions (idPositions, position) VALUES ( 5, "Social Chair" );
INSERT INTO Positions (idPositions, position) VALUES ( 6, "Secretary" );
INSERT INTO Positions (idPositions, position) VALUES ( 7, "Publicity Chair" );

-- Insert Pictures
INSERT INTO Pictures (idPictures, urlP, captionP) VALUES (0, "http://info230.cs.cornell.edu/users/skemab/www/m3/img/defaultProfilePic.jpg", "generic pic");

-- Insert Performances
INSERT INTO Performances (idPerformances, performancetitle, performanceLocation, performanceDate) VALUES ( 1, "Sabor Annual Concert: And the Latin Grammy Goes to...", "Ithaca State Theatre", "2013-12-07" );
INSERT INTO Performances (idPerformances, performancetitle, performanceLocation, performanceDate) VALUES ( 2, "Sabor Annual Concert", "Ithaca State Theatre", "2012-12-07" );

-- Insert Members
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 1, "Karl-Frederik", "Maurrasse", "Junior" );
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 2, "Narda", "Terrones", "Senior" );
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 3, "Emily", "Tavarez", "Sophomore" );
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 4, "Christine", "Akoh", "Graduate" );
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 5, "Priscilla", "Ruilova", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 6, "Ivette", "Planell-Mendez", "Senior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 7, "Daniel", "Muniz", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 8, "Michelle", "Garcia", "Freshman");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 9, "Bonnie", "Acosta", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (10, "Laura", "Montoya", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (11, "Miguel", "Castellanos", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (12, "Jonathan", "Sanchez", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (13, "Michael", "Collaguazo", "Senior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (14, "Martina", "Azar", "Senior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (15, "Jazlin", "Gomez", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (16, "Yashna", "Gungadurdoss", "Junior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (17, "Eduardo", "Rosario", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (18, "Priscilla", "Ruillova", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (19, "Mariana", "Pinos", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (20, "Dri", "Watson", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (21, "Rubina", "Ogno", "Junior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (22, "Rebecca", "Jakubson", "Junior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (23, "Leonardo", "Peña", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (24, "Sahil", "Gupta", "Junior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (25, "Jeffrey", "Lee", "Junior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (26, "Deborah", "Cabrera", "Senior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (27, "Diana", "Glattly", "Senior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (28, "Isabel", "Soto", "Senior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (29, "Isabella", "Virginia", "Junior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (30, "Carmen", "Martinez", "Senior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (31, "Nikki", "Kimura", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (32, "Nicole", "Cruz", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (33, "Reinaldo", "Hernandez", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (34, "Jonathan", "Pabon", "Freshman");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (35, "Sady", "Ramirez", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (36, "Taylor", "Famighetti", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (37, "Victor", "Riomana", "Freshman");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (38, "Isabel", "Bosque", "Sophomore");


-- Insert MemberContactInfo
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 1, "kfm53@cornell.edu", 6073795844, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 2, "njt36@cornell.edu", 9562258808, "USA", "NY", "Ithaca" );

-- Insert MembersHistory
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 1, 1, 1, "Spring'14", "Spring'15" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 2, 2, 1, "Spring'13", "Spring'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 3, 3, 2, "Spring'14", "Spring'15" );

-- Insert Videos
INSERT INTO Videos (idvideos, urlV, captionV, performanceID) VALUES ( 1, "https://www.youtube.com/watch?v=wh3IlKOQ8KE", "Salsa Piece", 1 );
INSERT INTO Videos (idvideos, urlV, captionV, performanceID) VALUES ( 2, "https://www.youtube.com/watch?v=Q2oMLmcgWdY", "Banda Piece", 1 );
INSERT INTO Videos (idvideos, urlV, captionV, performanceID) VALUES ( 3, "https://www.youtube.com/watch?v=C5zYIeYfnYo", "Intro Piece", 1 );
INSERT INTO Videos (idvideos, urlV, captionV, performanceID) VALUES ( 4, "https://www.youtube.com/watch?v=69Ncj-J9Ii4", "2012 Mix", 2 );

-- Insert Members into Videos
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 1, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 2, 2 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 2, 1 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 2, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 3, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 4, 3 );

-- Link Choreographers to Video
INSERT INTO ChoreographersOfVid (memberID, videoID) VALUES ( 2, 1 );
INSERT INTO ChoreographersOfVid (memberID, videoID) VALUES ( 2, 3 );

-- Add Genres To Videos
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 1, 1);
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 7, 2);
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 0, 3);
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 0, 4);