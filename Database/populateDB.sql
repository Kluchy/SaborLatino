-- Insert Genres
INSERT INTO Genres VALUES ( idGenres= 0, genreName= "mixed" );
INSERT INTO Genres VALUES ( idGenres= 1, genreName= "salsa" );
INSERT INTO Genres VALUES ( idGenres= 2, genreName= "bachata" );
INSERT INTO Genres VALUES ( idGenres= 3, genreName= "merengue" );
INSERT INTO Genres VALUES ( idGenres= 4, genreName= "cumbia" );
INSERT INTO Genres VALUES ( idGenres= 5, genreName= "reggaeton" );
INSERT INTO Genres VALUES ( idGenres= 6, genreName= "cha-cha-cha" );
INSERT INTO Genres VALUES ( idGenres= 7, genreName= "banda" );
INSERT INTO Genres VALUES ( idGenres= 8, genreName= "zouk" );
INSERT INTO Genres VALUES ( idGenres= 9, genreName= "tango" );
INSERT INTO Genres VALUES ( idGenres= 10, genreName= "modern" );

-- Insert Positions
INSERT INTO Positions VALUES ( idPositions= 0, position= "General Body Member" );
INSERT INTO Positions VALUES ( idPositions= 1, position= "Head Choreographer" );
INSERT INTO Positions VALUES ( idPositions= 2, position= "President" );
INSERT INTO Positions VALUES ( idPositions= 3, position= "Vice-President" );
INSERT INTO Positions VALUES ( idPositions= 4, position= "Treasurer" );
INSERT INTO Positions VALUES ( idPositions= 5, position= "Social Chair" );
INSERT INTO Positions VALUES ( idPositions= 6, position= "Secretary" );
INSERT INTO Positions VALUES ( idPositions= 7, position= "Publicity Chair" );

-- Insert Performances
INSERT INTO Performances VALUES ( idPerformances= 1, performanceTitle= "Sabor Annual Concert: And the Latin Grammy Goes to...", performanceLocation= "Ithaca State Theatre", performanceDate= "2013-12-07" );

-- Insert Members
INSERT INTO Members VALUES ( idMembers= 1, firstName= "Karl-Frederik", lastName= "Maurrasse", year= "Junior" );
INSERT INTO Members VALUES ( idMembers= 2, firstName= "Narda", lastName= "Terrones", year= "Senior" );
INSERT INTO Members VALUES ( idMembers= 3, firstName= "Emily", lastName= "Tavarez", year= "Sophomore" );

-- Insert MemberContactInfo
INSERT INTO MemberContactInfo VALUES ( memberID= 1, email= "kfm53@cornell.edu", phone= 6073795844, country= "USA", state= "NY", city= "Ithaca" );

-- Insert MembersHistory
INSERT INTO MembersHistory VALUES ( idHistory= 1, memberID= 1, positionID= 1, startDate= "Spring'14", endDate= "Spring'15" );


