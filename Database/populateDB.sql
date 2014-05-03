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
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (18, "Diego", "Arenas", "Senior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (19, "Mariana", "Pinos", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (20, "Dri", "Watson", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (21, "Rubina", "Ogno", "Junior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (22, "Rebecca", "Jakubson", "Junior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (23, "Leonardo", "Peña", "Sophomore");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (24, "Sahil", "Gupta", "Junior");
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (25, "Jeffrey", "Ly", "Junior");
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
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 3, "et343@cornell.edu", 9085916767, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 4, "cca47@cornell.edu", "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 5, "par244@cornell.edu", 4847676209, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 6, "imp6@cornell.edu", 3027231545, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 7, "dm642@cornell.edu", 6268255072, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 8, "mgc86@cornell.edu", 3474036063, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 9, "bca37@cornell.edu", "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 10, "lm499@cornell.edu", 7869420746,  "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 11, "mc2326@cornell.edu", 8455498090, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 12, "jas879@cornell.edu", 6314560866, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 13, "mdc239@cornell.edu", 6463192277, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 14, "ma523@cornell.edu", 3472540343, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 15, "jmg495@cornell.edu", 9412019852, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 16, "yg96@cornell.edu", 6073199255, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 17, "er392@cornell.edu", "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 19, "myp6@cornell.edu", 9177531320, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 20, "diw28@cornell.edu", "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 21, "ro222@cornell.edu", 3154160221, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 22, "raj96@cornell.edu", 6073511108, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 23, "lp373@cornell.edu", 6462807424, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 24, "skg73@cornell.edu", 2033768500, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 25, "jll348@cornell.edu", 4103571760, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 26, "dec245@cornell.edu", "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 27, "dag258@cornell.edu", "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 28, "ias37@cornell.edu", "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, country, state, city) VALUES ( 29, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 30, "cim36@cornell.edu", "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 31, "nhk25@cornell.edu", "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 32, "nmc67@cornell.edu", "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 33, "rjh326@cornell.edu", "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, phone, country, state, city) VALUES ( 34, "jp843@cornell.edu", 9739070016, "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 35, "sdr78@cornell.edu", "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 36, "tjf78@cornell.edu", "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 37, "vhr6@cornell.edu", "USA", "NY", "Ithaca" );
INSERT INTO MemberContactInfo (memberID, email, country, state, city) VALUES ( 38, "imb27@cornell.edu", "USA", "NY", "Ithaca" );


-- Insert MembersHistory
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 1, 1, 1, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 2, 2, 1, "Spring'13", "Fall'13" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 3, 3, 2, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 4, 4, 3, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 5, 5, 7, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 6, 6, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 7, 7, 1, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 8, 8, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 9, 9, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 10, 10, 6, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 11, 11, 4, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 12, 12, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 13, 13, 6, "Spring'13", "Fall'13" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 14, 14, 0, "Spring'13", "Fall'13" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 15, 15, 1, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 16, 16, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 17, 17, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 18, 18, 1, "Spring'13", "Spring'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 19, 19, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 20, 20, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 21, 21, 1, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 22, 22, 1, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 23, 23, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 24, 24, 5, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 25, 25, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 26, 26, 2, "Spring'13", "Fall'13" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 27, 27, 0, "Spring'13", "Spring'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 28, 28, 0, "Spring'13", "Spring'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 29, 29, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 30, 30, 0, "Spring'13", "Spring'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 31, 31, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 32, 32, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 33, 33, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 34, 34, 0, "Spring'14", "Fall'14" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 35, 35, 0, "Spring'13", "Fall'13" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 36, 36, 0, "Spring'13", "Fall'13" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 37, 37, 0, "Spring'14", "Fall'14" );


-- Insert Videos
INSERT INTO Videos (idvideos, urlV, captionV, performanceID) VALUES ( 1, "https://www.youtube.com/watch?v=wh3IlKOQ8KE", "Salsa Piece", 1 );
INSERT INTO Videos (idvideos, urlV, captionV, performanceID) VALUES ( 2, "https://www.youtube.com/watch?v=Q2oMLmcgWdY", "Banda Piece", 1 );
INSERT INTO Videos (idvideos, urlV, captionV, performanceID) VALUES ( 3, "https://www.youtube.com/watch?v=C5zYIeYfnYo", "Intro Piece", 1 );
INSERT INTO Videos (idvideos, urlV, captionV, performanceID) VALUES ( 4, "https://www.youtube.com/watch?v=69Ncj-J9Ii4", "2012 Mix", 2 );

-- Insert Members into Videos
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 1, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 2, 2 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 7, 2 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 30, 2 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 2, 1 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 18, 1 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 22, 1 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 26, 1 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 2, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 3, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 4, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 5, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 6, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 7, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 10, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 11, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 12, 2 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 13, 1 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 14, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 15, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 16, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 17, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 18, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 19, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 20, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 21, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 22, 2 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 23, 1 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 24, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 25, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 26, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 27, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 28, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 29, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 30, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 31, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 32, 2 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 33, 1 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 34, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 35, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 36, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 37, 3 );

-- Link Choreographers to Video
INSERT INTO ChoreographersOfVid (memberID, videoID) VALUES ( 2, 1 );
INSERT INTO ChoreographersOfVid (memberID, videoID) VALUES ( 2, 3 );
INSERT INTO ChoreographersOfVid (memberID, videoID) VALUES ( 7, 2 );

-- Add Genres To Videos
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 1, 1);
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 7, 2);
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 0, 3);
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 0, 4);