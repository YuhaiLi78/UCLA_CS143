CREATE TABLE Movie(
       id INT NOT NULL,
       title VARCHAR(100) NOT NULL,
       year INT,
       rating VARCHAR(10),
       company VARCHAR(50),
       PRIMARY KEY (id)/* Each movie has a unique id */
) ENGINE=INNODB;
CREATE TABLE Actor(
       id INT NOT NULL,
       last VARCHAR(20),
       first VARCHAR(20),
       sex VARCHAR(6),
       dob DATE NOT NULL,
       dod DATE,
       PRIMARY KEY (id),/* Each actor has a unique id */
       CHECK (DATEDIFF(dob, dod) >= 0 )/* Date of birth has to be smaller than the date of death */
) ENGINE=INNODB;
CREATE TABLE Sales(
       mid INT NOT NULL,
       ticketsSold INT,
       totalIncome INT,
       FOREIGN KEY(mid) REFERENCES Movie(id)/* The mid refers to the id in Movie table*/
) ENGINE=INNODB;
CREATE TABLE Director(
       id INT NOT NULL,
       last VARCHAR(20),
       first VARCHAR(20),
       dob DATE,
       dod DATE,
       PRIMARY KEY (id),/* Each Director has an unique id */
       CHECK (DATEDIFF(dob, dod) >= 0)/* Date of birth has to be smaller than the date of death */
) ENGINE=INNODB;
CREATE TABLE MovieGenre(
       mid INT NOT NULL,
       genre VARCHAR(20),
       FOREIGN KEY(mid) REFERENCES Movie(id)/* Each mid refers to the id in Movie table*/
) ENGINE=INNODB;
CREATE TABLE MovieDirector(
       mid INT NOT NULL,
       did INT NOT NULL,
       FOREIGN KEY(mid) REFERENCES Movie(id),/* The mid refers to the PRIMARY KEY in Movie table */
       FOREIGN KEY(did) REFERENCES Director(id)/* The did refers to the PRIMARY KEY  in Director table */
) ENGINE=INNODB;
CREATE TABLE MovieActor(
       mid INT NOT NULL,
       aid INT NOT NULL,
       role VARCHAR(50),
       FOREIGN KEY(mid) REFERENCES Movie(id),/* The mid refers to the PRIMARY KEY in Movie table */
       FOREIGN KEY(aid) REFERENCES Actor(id)/* The aid refers to the PRIMARY KEY in Actor table */
) ENGINE=INNODB;
CREATE TABLE MovieRating(
       mid INT NOT NULL,
       imdb INT,
       rot INT,
       FOREIGN KEY(mid) REFERENCES Movie(id)/* The mid refers to the PRIMARY KEY in Movie table */
) ENGINE=INNODB;
CREATE TABLE Review(
       name VARCHAR(20) NOT NULL,
       time TIMESTAMP NOT NULL,
       mid INT NOT NULL,
       rating INT NOT NULL,
       comment VARCHAR(500) NOT NULL,
       FOREIGN KEY(mid) REFERENCES Movie(id),/* The mid refers to the PRIMARY KEY in Movie table */
       CHECK (0<=rating AND rating<=5)/* The value must be between 0 to 5*/
) ENGINE=INNODB;
CREATE TABLE MaxPersonID(
       id INT NOT NULL
) ENGINE=INNODB;
CREATE TABLE MaxMovieID(
       id INT NOT NULL
) ENGINE=INNODB;
