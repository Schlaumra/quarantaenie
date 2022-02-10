DROP DATABASE IF EXISTS quarantaenie;
DROP USER IF EXISTS quarantine@localhost;

CREATE DATABASE quarantaenie;
CREATE USER quarantine@localhost IDENTIFIED BY 'Kennwort0!';
GRANT ALL PRIVILEGES ON quarantaenie.* TO quarantine@localhost;

USE quarantaenie;

CREATE TABLE class (
  id integer AUTO_INCREMENT PRIMARY KEY,
  name varchar(100)
);

CREATE TABLE student (
  id integer AUTO_INCREMENT PRIMARY KEY,
  firstName varchar(100),
  lastName varchar(100),
  class_fk integer
);

CREATE TABLE quarantine (
  id integer AUTO_INCREMENT PRIMARY KEY,
  qStart date,
  qEnd date,
  student_fk integer
);

ALTER TABLE student
ADD CONSTRAINT fk_student_class FOREIGN KEY(class_fk) REFERENCES class(id);

ALTER TABLE quarantine
ADD CONSTRAINT fk_quarantine_student FOREIGN KEY(student_fk) REFERENCES student(id);