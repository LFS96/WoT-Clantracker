
/**
  Sprache mit Anzahl Spieler und Anzahl Clans
 */
SELECT l.id, count(*) as player, count(distinct c.id) as clans, l.name
FROM langs l
         INNER Join clans c on l.id = c.lang_id
         INNER join players p on c.id = p.clan_id
GROUP BY l.id
Order by player desc;

/** Anzahl Spieler Anzahl Clans */
SELECT "clans", count(*) as clans From clans
UNION
SELECT "players", count(*) as players From players;


/** Inaktive deutsche CLans */
SELECT c.*, count(distinct p2.id) as players_active, count(distinct p.id) as players_total
FROM clans c
         INNER JOIN players p on c.id = p.clan_id
         INNER Join players p2 on c.id = p2.clan_id AND p2.lastBattle > curdate() - INTERVAL 7 DAY
WHERE c.lang_id = "DEU"
GROUP BY c.id
HAVING players_active / players_total < 0.2 OR players_active < 5



/** Clans ohne Sprache, sortiert nach Spielern */
SELECT c.*, count(*) as player, lang_id
FROM  clans c
INNER join players p on c.id = p.clan_id
WHERE c.lang_id is null
GROUP BY c.id
Order by player desc;


/* Übersicht round( Clans_member ,10), anzahl Clans, aktiv % */
SELECT player , count(*), avg(player2), sum(if(player2 >= 10,1,0)) FROM (
    SELECT c.id, tag , floor(count(*)/10)*10 as player, (sum(if(p.lastBattle > curdate() - interval 30 day, 1,0)))  as player2, c.lang_id, c.name
    FROM  clans c
              LEFT join players p on c.id = p.clan_id
          #  WHERE tag LIKE "1FP%"
    GROUP BY c.id HAVING player2 < 10 AND player = 100 ORDER BY player2 desc
                                                                        ) as t  GROUP BY player ORDER BY player desc;


/* Ausgetretene Spieler */
SELECT p.id as Spieler_ID, p.nickname as Nickname, date(p.quit) as Austritt, date(p.lastBattle) as LetztesGefecht,
       (SELECT  tag FROM histories INNER JOIN clans c on histories.clan_id = c.id WHERE player_id = p.id ORDER BY joined desc limit 1) as LetzerClan,
       (SELECT  GROUP_CONCAT(DISTINCT lang_id) FROM histories INNER JOIN clans c on histories.clan_id = c.id WHERE player_id = p.id  ORDER BY joined ) as Sprachen
FROM players p
WHERE p.clan_id is null AND p.lastBattle > curdate() - INTERVAL 30 DAY
HAVING Sprachen LIKE "%DEU%" OR Sprachen LIKE "%NLD%"
ORDER BY date(p.quit) desc;


/** Aktivität 1FP */
SELECT c.id, tag ,count(*) as player, (sum(if(p.lastBattle > curdate() - interval 7 day, 1,0))) as player2
FROM  clans c
 LEFT join players p on c.id = p.clan_id
WHERE tag LIKE "1FP%"
GROUP BY c.id ORDER BY player2 desc










