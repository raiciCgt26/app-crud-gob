SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
--
-- Database: `db_local_upteb_biblioteca`
--




CREATE TABLE `audit_log` (
  `mov_id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `action_id` int unsigned NOT NULL,
  `target_book_id` int unsigned DEFAULT NULL,
  `target_user_id` int unsigned DEFAULT NULL,
  `target_tag_id` int unsigned DEFAULT NULL,
  `capture_dt` datetime DEFAULT CURRENT_TIMESTAMP,
  `date` date GENERATED ALWAYS AS (cast(`capture_dt` as date)) VIRTUAL,
  `time` time GENERATED ALWAYS AS (cast(`capture_dt` as time)) VIRTUAL,
  PRIMARY KEY (`mov_id`),
  KEY `target_book_id` (`target_book_id`),
  KEY `target_tag_id` (`target_tag_id`),
  CONSTRAINT `audit_log_ibfk_1` FOREIGN KEY (`target_book_id`) REFERENCES `books` (`book_id`),
  CONSTRAINT `audit_log_ibfk_2` FOREIGN KEY (`target_tag_id`) REFERENCES `tags` (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO audit_log VALUES
("1","1","1","1","1","1","2023-12-03 18:13:18","2023-12-03","18:13:18");




CREATE TABLE `book_tags` (
  `bt_id` int unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int unsigned NOT NULL,
  `tag_id` int unsigned NOT NULL,
  `thesis_id` int unsigned NOT NULL,
  PRIMARY KEY (`bt_id`),
  KEY `book_id` (`book_id`),
  KEY `tag_id` (`tag_id`),
  KEY `thesis_id` (`thesis_id`),
  CONSTRAINT `book_tags_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  CONSTRAINT `book_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`),
  CONSTRAINT `book_tags_ibfk_3` FOREIGN KEY (`thesis_id`) REFERENCES `thesis` (`thesis_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO book_tags VALUES
("1","1","1","1");




CREATE TABLE `books` (
  `book_id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `publish` varchar(255) NOT NULL,
  `code` varchar(15) NOT NULL,
  `quantity` int unsigned NOT NULL,
  `state` int unsigned NOT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO books VALUES
("1","El lenguaje de programación C","BRIAN W. KERNIGHAN","PRENTICE HALL HISPANOAMERICANA S.A","9789688802052","1","1","0");




CREATE TABLE `security_answers` (
  `security_id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `answer0` varchar(255) NOT NULL,
  `answer1` varchar(255) NOT NULL,
  `answer2` varchar(255) NOT NULL,
  PRIMARY KEY (`security_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `security_answers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO security_answers VALUES
("1","1","Clockwork Orange","Margarita","Hallaca");




CREATE TABLE `tags` (
  `tag_id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO tags VALUES
("1","Materiales Industriales","El PNF en Materiales Industriales está dirigido a la formación de un profesional con conocimiento integral sobre los materiales, capaz de diseñar, seleccionar, transformar, usar y aplicar los diferentes materiales de ingeniería.","0"),
("2","Geociencias","El PNF en Geociencias es concebido en función de satisfacer la necesidad de formar profesionales en el área de Geociencias, con principios, visión integral, valores y pertinencia social.","0"),
("3","Orfebrería y Joyería","El PNF en Orfebrería y Joyería forma a profesionales con experiencia específica en el proceso de producción de joyas que, adicionalmente, pueda desempeñar cargos de coordinación en el proceso de producción.","0"),
("4","Distribución y Logística","El PNF en Distribución y Logística.","0");




CREATE TABLE `thesis` (
  `thesis_id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `author_names` varchar(255) NOT NULL,
  `tutor_name` varchar(255) NOT NULL,
  `cota` int unsigned NOT NULL,
  `disponibility` int unsigned NOT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`thesis_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO thesis VALUES
("1","Desarrollo de aplicación biblioteca virtual UPTEB","Jesús Fereira y Pedro Rodriguez","Marco Romero","1","1","0"),
("2","asasas","asasasasaasa","asasassasasassasas","3","1","1");




CREATE TABLE `users` (
  `user_id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO users VALUES
("1","admin","$2y$10$l7BeEqrXcDqRVc09Tc3qj.tDnv6cM8JcauF/JHZsWFp8ja3vQ0F/C","admin@example.com","admin","0412-5550134"),
("2","testuser","$2y$10$l7BeEqrXcDqRVc09Tc3qj.tDnv6cM8JcauF/JHZsWFp8ja3vQ0F/C","testuser@example.com","user","0412-5550148");




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;