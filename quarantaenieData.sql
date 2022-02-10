USE quarantaenie;

INSERT INTO class(name)
VALUES ('FI2'),
       ('FI3'),
       ('FI4'),
       ('HV2'),
       ('HV3'),
       ('HV4');


INSERT INTO student(firstName, lastName, class_fk)
VALUES ('Mario', 'Draghi', 1),
       ('Georg', 'Kuppenkas', 1),
       ('Bananen', 'Klauber', 2),
       ('Max', 'Kohl', 3),
       ('Tom', 'Turbo', 4),
       ('Elsa', 'Eis', 5),
       ('Walter', 'Lokomotive', 6),
       ('Lotte', 'Buff', 6);

INSERT INTO quarantine(qStart, qEnd, student_fk)
VALUES ("2020-12-01", "2022-12-01", 1),
       ("2020-12-01", "2022-12-01", 2),
       ("2020-12-01", "2021-12-01", 2),
       ("2020-12-01", "2022-12-01", 3),
       ("2020-12-01", "2021-12-01", 4),
       ("2022-01-01", "2022-12-01", 4),
       ("2022-01-01", "2022-12-01", 5),
       ("2022-01-01", "2020-12-01", 6),
       ("2022-01-01", "2021-12-01", 7),
       ("2022-01-01", "2022-12-01", 8);