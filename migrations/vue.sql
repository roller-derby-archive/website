DROP VIEW view__search;
CREATE VIEW view__search AS
SELECT cl.id, REGEXP_REPLACE(lower(cl.name), '[éèê]', 'e', 'g') as value, cl.name, 'club' as entity FROM club cl
UNION SELECT t.id, REGEXP_REPLACE(lower(t.name), '[éè]', 'e', 'g') as value, CONCAT(t.pronoun, ' ', t.name) as name, 'team' as entity FROM team t WHERE t.country_code = 'FRA'
UNION SELECT a.id, lower(a.alias) as value, a.name, 'club' as entity FROM club a WHERE a.alias NOTNULL
UNION SELECT ci.id,
      REGEXP_REPLACE(
              REGEXP_REPLACE(
                      REGEXP_REPLACE(
                              REGEXP_REPLACE(
                                      REGEXP_REPLACE(
                                              REGEXP_REPLACE(
                                                      REGEXP_REPLACE(lower(ci.cities::TEXT), '[\[\]"]', '', 'g')
                                                  , '\\u00ea|\\u00e9|\\u00e8|\\u00c9|\\u0153', 'e', 'g')
                                          , ',', ' ', 'g')
                                  , '\\u00e2', 'a', 'g')
                          , '\\u00f4', 'o', 'g')
                  , '\\u00ee', 'i', 'g')
          , '\\u00e7', 'c', 'g')
as value, ci.name, 'club' as entity FROM club ci
UNION SELECT t.id,
      REGEXP_REPLACE(
              REGEXP_REPLACE(
                      REGEXP_REPLACE(
                              REGEXP_REPLACE(
                                      REGEXP_REPLACE(
                                              REGEXP_REPLACE(
                                                      REGEXP_REPLACE(lower(ci.cities::TEXT), '[\[\]"]', '', 'g')
                                                  , '\\u00ea|\\u00e9|\\u00e8|\\u00c9|\\u0153', 'e', 'g')
                                          , ',', ' ', 'g')
                                  , '\\u00e2', 'a', 'g')
                          , '\\u00f4', 'o', 'g')
                  , '\\u00ee', 'i', 'g')
          , '\\u00e7', 'c', 'g')
as value, CONCAT(t.pronoun, ' ', t.name) as name, 'team' as entity FROM team t
    LEFT JOIN team_club tc on t.id = tc.team_id
    LEFT JOIN club ci on tc.club_id = ci.id
    WHERE tc.team_id NOTNULL AND t.country_code = 'FRA';

SELECT * FROM view__search WHERE value like '%aube%';
