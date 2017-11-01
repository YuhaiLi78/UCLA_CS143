INSERT INTO Movie(id, title, year, rating, company)
VALUES (3, "Project 1", 2017, "R", "UCLA");
/* duplicate primary key 3*/

INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (1, "Project", "1A", "Male", 2017-01-01, 2017-01-02);
/* duplicate primary key 1*/

INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (4, "Project", "1A", "Male", 2018-01-01, 2017-01-01);
/* date of birth is greater than the date of death
   because mysql ingores CHECK, there is no way to test it*/

INSERT INTO Sales(mid, ticketsSold, totalIncome)
VALUES (1, 1111, 2222);
/* mid refers to an id that is not in Movie table*/

INSERT INTO Director(id, last, first, dob, dod)
VALUES (16, "Project", "1A", 2017-01-01, 2018-01-01);
/* duplicate primary key 16 */

INSERT INTO Director(id, last, first, dob, dod)
VALUES (1, "Project", "1A", 2018-01-01, 2017-01-01);
/* date of birth is greater than the data of death */

INSERT INTO MovieGenre(mid, genre)
VALUES (1, "Drama");
/* the foreign key refers to an id that is not in Movie table*/

INSERT INTO MovieDirector(mid, did)
VALUES(1, 16);
/* foreign key mid refers to an id that is not in Movie table*/

INSERT INTO MovieDirector(mid, did)
VALUES(3, 1);
/* foreign key did refers to an id that is not in Director table*/

INSERT INTO MovieActor(mid, aid)
VALUES(1, 16);
/* foreign key mid refers to an id that is not in Movie table*/

INSERT INTO MovieActor(mid, aid)
VALUES(3, 5);
/* foreign key did refers to an id that is not in Actor table*/

INSERT INTO MovieRating(mid, imdb, rot)
VALUES(1, 2, 2);
/* foreign key mid refers to an id that is not in Movie table*/

INSERT INTO Review(name, time, mid, rating, comment)
VALUES ("Project", "2017-01-01", 1, 4, "aaaaaa");
/* foreign key mid refers to an id that is not in Movie table*/

INSERT INTO Review(name, time, mid, rating, comment)
VALUES ("Project", "2017-01-01", 3, 40, "help");
/* rating is out of range*/
