DROP DATABASE IF EXISTS `de_tests`;
CREATE DATABASE `de_tests` DEFAULT CHARSET=utf8;
USE de_tests;

DROP USER 'webserv'@'localhost';
CREATE USER 'webserv'@'localhost' IDENTIFIED BY 'rfnfcnhjaf';
GRANT DELETE, INSERT, SELECT, UPDATE ON de_tests.* TO 'webserv'@'localhost';

SET foreign_key_checks = 0; 

CREATE TABLE specialization (
    code varchar(3),
    name varchar(150) DEFAULT NULL,
    PRIMARY KEY (code)
)  ENGINE=InnoDB;

CREATE TABLE course (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(150) DEFAULT NULL,
    specode varchar(3),
    PRIMARY KEY (id),
    KEY fk_course_spec (specode),
    CONSTRAINT fk_course_spec FOREIGN KEY (specode)
        REFERENCES specialization (code)
        ON DELETE CASCADE ON UPDATE CASCADE
)  ENGINE=InnoDB;

CREATE TABLE test (
    id int(11) NOT NULL AUTO_INCREMENT,
    theme varchar(150) DEFAULT NULL,
    courseid int(11),
    PRIMARY KEY (id),
    KEY fk_test_course (courseid),
    CONSTRAINT fk_test_course FOREIGN KEY (courseid)
        REFERENCES course (id)
        ON DELETE CASCADE ON UPDATE CASCADE
)  ENGINE=InnoDB;

CREATE TABLE question (
    id int(11) NOT NULL AUTO_INCREMENT,
    qtext text,
    testid int(11),
    PRIMARY KEY (id),
    KEY fk_question_test (testid),
    CONSTRAINT fk_question_test FOREIGN KEY (testid)
        REFERENCES test (id)
        ON DELETE CASCADE ON UPDATE CASCADE
)  ENGINE=InnoDB;

CREATE TABLE answer (
    id int(11) NOT NULL AUTO_INCREMENT,
    atext text,
    correct tinyint(1),
    questid int(11),
    PRIMARY KEY (id),
    KEY fk_answer_question (questid),
    CONSTRAINT fk_answer_question FOREIGN KEY (questid)
        REFERENCES question (id)
        ON DELETE CASCADE ON UPDATE CASCADE
)  ENGINE=InnoDB;

SET foreign_key_checks = 1; 

