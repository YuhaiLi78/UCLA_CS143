SELECT CONCAT(a.first, " ", a.last) AS ActorName 
FROM MovieActor ma 
INNER JOIN Movie m on ma.mid=m.id 
INNER JOIN Actor a on ma.aid=a.id 
WHERE m.title='Death to Smoochy';

SELECT COUNT(*)
FROM(
SELECT DISTINCT md.did
FROM MovieDirector md
INNER JOIN Movie m ON md.mid=m.id
INNER JOIN Director d ON md.did=d.id
GROUP BY md.did
HAVING COUNT(md.mid) >= 4) AS i;


/*Select the name and movie titles of the directors who direct more than 10 movies*/
SELECT md.did, m.title
FROM MovieDirector md
INNER JOIN Movie m ON md.mid=m.id
WHERE md.did IN ( SELECT d.id
FROM MovieDirector md
INNER JOIN Director d ON md.did=d.id
GROUP BY d.id
HAVING COUNT(*) > 10);


/*Select the actor and his/her total box office*/
SELECT CONCAT(a.first, " ", a.last) AS name, SUM(s.totalIncome) AS bo
FROM Actor a
INNER JOIN MovieActor ma ON a.id=ma.aid
INNER JOIN Sales s ON s.mid=ma.mid
GROUP BY a.id
HAVING SUM(s.totalIncome);

