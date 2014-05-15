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
INSERT INTO Pictures (idPictures, urlP, captionP) VALUES (0, "../img/profilePics/defaultProfilePic.jpg", "generic pic");

-- Insert Performances
INSERT INTO Performances (idPerformances, performancetitle, performanceLocation, performanceDate) VALUES ( 0, "Miscellaneous", "Ithaca State Theatre", "2013-12-07" );
INSERT INTO Performances (idPerformances, performancetitle, performanceLocation, performanceDate) VALUES ( 1, "Sabor Annual Concert: And the Latin Grammy Goes to...", "Ithaca State Theatre", "2013-12-07" );
INSERT INTO Performances (idPerformances, performancetitle, performanceLocation, performanceDate) VALUES ( 2, "Sabor Annual Concert", "Ithaca State Theatre", "2012-12-07" );
INSERT INTO Performances (idPerformances, performancetitle, performanceLocation, performanceDate) VALUES ( 3, "Sabor Annual Concert: World Cup", "Ithaca State Theatre", "2014-12-07" );

-- Insert Members
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 1, "Karl-Frederik", "Maurrasse", 2015 );
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 2, "Narda", "Terrones", 2014 );
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 3, "Emily", "Tavarez", 2016 );
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 4, "Christine", "Akoh", "Graduate" );
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 5, "Priscilla", "Ruilova", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 6, "Ivette", "Planell-Mendez", 2014);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 7, "Daniel", "Muniz", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 8, "Michelle", "Garcia", 2017);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES ( 9, "Bonnie", "Acosta", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (10, "Laura", "Montoya", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (11, "Miguel", "Castellanos", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (12, "Jonathan", "Sanchez", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (13, "Michael", "Collaguazo", 2014);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (14, "Martina", "Azar", 2014);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (15, "Jazlin", "Gomez", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (16, "Yashna", "Gungadurdoss", 2015);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (17, "Eduardo", "Rosario", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (18, "Diego", "Arenas", 2014);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (19, "Mariana", "Pinos", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (20, "Dri", "Watson", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (21, "Rubina", "Ogno", 2015);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (22, "Rebecca", "Jakubson", 2015);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (23, "Leonardo", "Pena", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (24, "Sahil", "Gupta", 2015);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (25, "Jeffrey", "Ly", 2015);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (26, "Deborah", "Cabrera", 2014);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (27, "Diana", "Glattly", 2014);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (28, "Isabel", "Soto", 2014);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (29, "Isabella", "Virginia", 2015);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (30, "Carmen", "Martinez", 2014);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (31, "Nikki", "Kimura", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (32, "Nicole", "Cruz", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (33, "Reinaldo", "Hernandez", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (34, "Jonathan", "Pabon", 2017);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (35, "Sady", "Ramirez", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (36, "Taylor", "Famighetti", 2016);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (37, "Victor", "Riomana", 2017);
INSERT INTO Members (idMembers, firstName, lastName, year) VALUES (38, "Isabel", "Bosque", 2016);



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
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 1, 1, 1, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 2, 2, 1, "2013-01-01", "2013-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 3, 3, 2, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 4, 4, 3, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 5, 5, 7, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 6, 6, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 7, 7, 1, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 8, 8, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 9, 9, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 10, 10, 6, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 11, 11, 4, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 12, 12, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 13, 13, 6, "2013-01-01", "2013-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 14, 14, 0, "2013-01-01", "2013-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 15, 15, 1, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 16, 16, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 17, 17, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 18, 18, 1, "2013-01-01", "2014-01-01" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 19, 19, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 20, 20, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 21, 21, 1, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 22, 22, 1, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 23, 23, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 24, 24, 5, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 25, 25, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 26, 26, 2, "2013-01-01", "2013-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 27, 27, 0, "2013-01-01", "2014-01-01" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 28, 28, 0, "2013-01-01", "2014-01-01" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 29, 29, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 30, 30, 0, "2013-01-01", "2014-01-01" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 31, 31, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 32, 32, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 33, 33, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 34, 34, 0, "2014-01-01", "2014-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 35, 35, 0, "2013-01-01", "2013-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 36, 36, 0, "2013-01-01", "2013-12-30" );
INSERT INTO MembersHistory (idHistory, memberID, positionID, startDate, endDate) VALUES ( 37, 37, 0, "2014-01-01", "2014-12-30" );


-- Insert Videos
INSERT INTO Videos (idVideos, urlV, captionV, performanceID) VALUES ( 1, "https://www.youtube.com/watch?v=wh3IlKOQ8KE", "Salsa Piece", 1 );
INSERT INTO Videos (idVideos, urlV, captionV, performanceID) VALUES ( 2, "https://www.youtube.com/watch?v=Q2oMLmcgWdY", "Banda Piece", 1 );
INSERT INTO Videos (idVideos, urlV, captionV, performanceID) VALUES ( 3, "https://www.youtube.com/watch?v=C5zYIeYfnYo", "Intro Piece", 1 );
INSERT INTO Videos (idVideos, urlV, captionV, performanceID) VALUES ( 4, "https://www.youtube.com/watch?v=69Ncj-J9Ii4", "2012 Mix", 2 );
INSERT INTO Videos (idVideos, urlV, captionV, performanceID) VALUES ( 5, "https://www.youtube.com/watch?v=bd09WZl1L9A", "Shakira Mashup", 1); 
INSERT INTO Videos (idVideos, urlV, captionV, performanceID) VALUES ( 6, "https://www.youtube.com/watch?v=t_jJ5e62ZVU", "Cumbia Piece", 1); 
INSERT INTO Videos (idVideos, urlV, captionV, performanceID) VALUES ( 7, "https://www.youtube.com/watch?v=VLRsTv06OfA", "All Female Cha-Cha", 2); 
INSERT INTO Videos (idVideos, urlV, captionV, performanceID) VALUES ( 8, "https://www.youtube.com/watch?v=z_ldLa7BTuQ", "Merengue Piece", 1); 

-- Insert Members into Videos
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 1, 3 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 1, 5 );
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
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 2, 6 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 4, 6 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 6, 6 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 7, 6 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 11, 6 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 24, 6 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 15, 8 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 3 , 8 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 4, 8 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 5, 8 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 6, 8 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 23, 8 );
INSERT INTO MembersInVid (memberID, videoID) VALUES ( 13, 8 );



-- Link Choreographers to Video
INSERT INTO ChoreographersOfVid (memberID, videoID) VALUES ( 2, 1 );
INSERT INTO ChoreographersOfVid (memberID, videoID) VALUES ( 2, 3 );
INSERT INTO ChoreographersOfVid (memberID, videoID) VALUES ( 2, 6 );
INSERT INTO ChoreographersOfVid (memberID, videoID) VALUES ( 2, 5 );
INSERT INTO ChoreographersOfVid (memberID, videoID) VALUES ( 15, 5 );
INSERT INTO ChoreographersOfVid (memberID, videoID) VALUES ( 2, 7 );
INSERT INTO ChoreographersOfVid (memberID, videoID) VALUES ( 15, 8 );


-- Add Genres To Videos
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 1, 1);
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 7, 2);
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 0, 3);
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 0, 4);
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 0, 5);
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 4, 6);
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 6, 7);
INSERT INTO GenresInVid (genreID, videoID) VALUES ( 3, 8);