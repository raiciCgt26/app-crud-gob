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
  `target_pub_id` int unsigned DEFAULT NULL,
  `target_user_id` int unsigned DEFAULT NULL,
  `target_tag_id` int unsigned DEFAULT NULL,
  `capture_dt` datetime DEFAULT CURRENT_TIMESTAMP,
  `date` date GENERATED ALWAYS AS (cast(`capture_dt` as date)) VIRTUAL,
  `time` time GENERATED ALWAYS AS (cast(`capture_dt` as time)) VIRTUAL,
  PRIMARY KEY (`mov_id`),
  KEY `target_pub_id` (`target_pub_id`),
  KEY `target_tag_id` (`target_tag_id`),
  CONSTRAINT `audit_log_ibfk_1` FOREIGN KEY (`target_pub_id`) REFERENCES `publications` (`pub_id`),
  CONSTRAINT `audit_log_ibfk_2` FOREIGN KEY (`target_tag_id`) REFERENCES `tags` (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO audit_log VALUES
("1","1","5","1","1","1","2024-03-26 19:42:57","2024-03-26","19:42:57"),
("2","1","5","2","","","2024-03-26 19:43:32","2024-03-26","19:43:32"),
("3","1","5","3","","","2024-04-01 19:15:58","2024-04-01","19:15:58"),
("4","1","5","4","","","2024-04-01 19:43:06","2024-04-01","19:43:06");




CREATE TABLE `book_actions` (
  `book_act_id` int unsigned NOT NULL AUTO_INCREMENT,
  `focus_user_id` int unsigned NOT NULL,
  `focus_pub_id` int unsigned DEFAULT NULL,
  `misc_info` varchar(255) NOT NULL,
  PRIMARY KEY (`book_act_id`),
  KEY `focus_pub_id` (`focus_pub_id`),
  KEY `focus_user_id` (`focus_user_id`),
  CONSTRAINT `book_actions_ibfk_1` FOREIGN KEY (`focus_pub_id`) REFERENCES `publications` (`pub_id`),
  CONSTRAINT `book_actions_ibfk_2` FOREIGN KEY (`focus_user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;






CREATE TABLE `cited_sources` (
  `source_id` int unsigned NOT NULL AUTO_INCREMENT,
  `pub_id` int unsigned DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`source_id`),
  KEY `pub_id` (`pub_id`),
  CONSTRAINT `cited_sources_ibfk_1` FOREIGN KEY (`pub_id`) REFERENCES `publications` (`pub_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO cited_sources VALUES
("1","","Autor","BRIAN W. KERNIGHAN"),
("2","2","Autor","Jesús Fereira"),
("3","2","Autor","Pedro Rodriguez"),
("4","2","Tutor","Marco Romero"),
("5","3","Autor","Miguel Bernejo Herrero"),
("6","4","Autor","Peter Briban"),
("7","4","Autor","Albert Paul");




CREATE TABLE `pub_cota_data` (
  `pub_cd_id` int unsigned NOT NULL AUTO_INCREMENT,
  `pub_id` int unsigned DEFAULT NULL,
  `prefix_string` varchar(150) DEFAULT NULL,
  `cota` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`pub_cd_id`),
  KEY `pub_id` (`pub_id`),
  CONSTRAINT `pub_cota_data_ibfk_1` FOREIGN KEY (`pub_id`) REFERENCES `publications` (`pub_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO pub_cota_data VALUES
("1","","","01"),
("2","2","","1445"),
("3","3","","3604"),
("4","3","","3605"),
("5","3","","3606"),
("6","3","","3603"),
("7","3","","3602"),
("8","4","Tomo I","0616"),
("9","4","Tomo II","0617"),
("10","4","Tomo III","0618"),
("11","4","Tomo IV","0619");




CREATE TABLE `pub_join_tags` (
  `pt_id` int unsigned NOT NULL AUTO_INCREMENT,
  `pub_id` int unsigned NOT NULL,
  `tag_id` int unsigned NOT NULL,
  PRIMARY KEY (`pt_id`),
  KEY `pub_id` (`pub_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `pub_join_tags_ibfk_1` FOREIGN KEY (`pub_id`) REFERENCES `publications` (`pub_id`),
  CONSTRAINT `pub_join_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO pub_join_tags VALUES
("1","1","2"),
("2","1","14"),
("3","1","17"),
("4","2","18"),
("5","2","2"),
("6","2","14"),
("7","3","17"),
("8","3","5"),
("9","3","14"),
("10","4","17"),
("11","4","5"),
("12","4","14");




CREATE TABLE `publications` (
  `pub_id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(4500) DEFAULT NULL,
  `code` varchar(15) DEFAULT NULL,
  `quantity` int unsigned NOT NULL,
  `state` int DEFAULT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pub_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO publications VALUES
("1","El lenguaje de programación C","Programación en C.","9789688802052","1","1","0"),
("2","Desarrollo de Biblioteca Virtual UPTEB","La presente investigación está orientada a la creación de una biblioteca virtual en línea bajo el nombre de la Universidad Politécnica Territorial del Estado Bolívar, permitiéndole a la universidad compartir su catálogo de conocimientos a la comunidad. A su vez, esto requiere la creación de un sistema de gestión y control de material bibliotecario de la universidad. Para abordar el estudio se realizó la investigación-acción según su nivel y   el diseño, enmarcada en la modalidad de proyecto factible. La población la conformó el directivo de la universidad y el personal encargado de la biblioteca de la sede Casco Histórico de la UPTEB. La muestra estuvo representada por 3 trabajadores. Los datos relacionados con el estudio fueron recopilados por medio de observación y entrevistas, se conoció el proceso actual de gestión para el control de inventario, y la necesidad de la universidad de volverse multimodal, así como la información requerida para su posterior ejecución de resolución del problema dando como resultado los requerimientos funcionales del sistema; mediante entrevistas aplicadas a los trabajadores se obtuvo un impulso al estudio de la factibilidad del proyecto. Para el desarrollo del sistema se utilizó la metodología RUP haciendo al cliente parte del equipo y trabajando sobre la marcha con prueba y error, se utilizó un editor de texto para el código, conocido como sublime texto 3 y lenguajes de programación como PHP, JavaScript y el servidor local Apache. Dicho sistema se realizó con la finalidad de crear una biblioteca virtual con el propósito de expandir el rango de la universidad a la hora de aportar a la comunidad.","","1","","0"),
("3","Geometria Descriptiva Aplicada","","","5","","0"),
("4","Electricidad y Electrónica. Aplicaciones Prácticas","","","4","","0");




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
  `description` varchar(500) DEFAULT NULL,
  `tag_category` varchar(255) NOT NULL DEFAULT 'PNF',
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO tags VALUES
("1","Ninguno","Esta etiqueta se utiliza para libros miscelaneos que son de uso general o no caben dentro del molde de los PNF existentes.","PNF","0"),
("2","Informática","El PNF en Informática tiene como fin promover un conjunto de estudios y actividades académicas conducentes a los títulos de Técnico o Técnica Superior Universitaria en Informática e Ingeniero o Ingeniera en Informática, así como el grado de Especialista en áreas afines, donde se asocia el conocimiento con la investigación en escenarios reales, utilizando como método el diseño, desarrollo y puesta en marcha de Proyectos Socio Tecnológicos.","PNF","0"),
("3","Materiales Industriales","El PNF en Materiales Industriales está dirigido a la formación de un profesional con conocimiento integral sobre los PNFles, capaz de diseñar, seleccionar, transformar, usar y aplicar los diferentes PNFles de ingeniería.","PNF","0"),
("4","Higiene y Seguridad Laboral","El PNF en Higiene y Seguridad Laboral, está dirigido a la formación de un profesional con una visión integral del ser humano, con sentido social y responsabilidad ambientalista, capacitado para el diseño, instalación, operación, evaluación, gerencia, investigación e innovación en el área de higiene y seguridad.","PNF","0"),
("5","Electricidad","El PNF en Electricidad está dirigido a la formación de un profesional con pensamiento crítico, científico humanista, con habilidades técnicas y científicas orientadas a la planificación, diseño, desarrollo, evaluación, construcción, innovación, instalación, operación, mantenimiento y supervisión en sistemas eléctricos.","PNF","0"),
("6","Geociencias","El PNF en Geociencias es concebido en función de satisfacer la necesidad de formar profesionales en el área de Geociencias, con principios, visión integral, valores y pertinencia social.","PNF","0"),
("7","Mecánica","El PNF en Mecánica está dirigido a la formación de un profesional para identificar, abordar y resolver problemas relacionados con el análisis, diseño, construcción, montaje puesta en marcha, operación, mantenimiento, desincorporación y desecho de equipos e instalaciones industriales.","PNF","0"),
("8","Química","El PNF en Química tiene como objetivo promover en los actores del proceso educativo el talento para el análisis psicoquímico y la producción de sustancias o formulaciones químicas en diferentes escalas para lograr la transformación del aparato socioproductivo de la nación, fundamentado en valores éticos, biocéntricos, sociales y una clara identidad regional, nacional, latinoamericana y caribeña.","PNF","0"),
("9","Orfebrería y Joyería","El PNF en Orfebrería y Joyería forma a profesionales con experiencia específica en el proceso de producción de joyas que, adicionalmente, pueda desempeñar cargos de coordinación en el proceso de producción.","PNF","0"),
("10","Sistemas de Calidad y Ambiente","El PNF en Sistemas de Calidad y Ambiente se diseña para dar respuesta a la necesidad de transformación del modelo tecnológico nacional, orientándolo con principios éticos, políticos, ideológicos y revolucionarios, hacia la formación de un ser humano integral, sensibilizado a la problemática social de las distintas organizaciones.","PNF","0"),
("11","Agroalimentación","El PNF en Agroalimentación forma un profesional integral con una visión comprehensiva de la realidad agrícola del país, capaz de abordar sistémicamente el conjunto de la cadena agroalimentaria (producción, transformación, distribución y consumo), con un enfoque agroecológico.","PNF","0"),
("12","Ingenieria de Mantenimiento","El PNF en Ingeniería de Mantenimiento es una gestión de tecnología y debe ser transversal a todo el proceso de producción de bienes y servicios, abarcando actividades desde la concepción del proyecto, ingeniería conceptual, diseño, ingeniería básica y de detalle, hasta la instalación, puesta en marcha, producción y sobre todo un amplio apoyo y seguimiento durante la fase de operación. ","PNF","0"),
("13","Distribución y Logística","El PNF en Distribución y Logística.","PNF","0"),
("14","Casco Histórico","La biblioteca ubicada en la sede del Casco Histórico.","Ubicación","0"),
("15","Germania","La biblioteca ubicada en la sede de la Germania.","Ubicación","0"),
("16","Aldea","La biblioteca ubicada en la sede de la Aldea. Aún no está activa.","Ubicación","0"),
("17","Libro","Libros en la poseción por la institución.","Documento","0"),
("18","Tesis","Tesis de proyectos sociales desarrollados en la institución.","Documento","0");




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
("1","admin","$2y$10$7Ftl.1l5h6lFn.6G4zzvFe../pjt.4ripgBz6oiOiDi5KvlHpaI.K","admin@example.com","admin","0412-5550134"),
("2","testuser","$2y$10$7Ftl.1l5h6lFn.6G4zzvFe../pjt.4ripgBz6oiOiDi5KvlHpaI.K","testuser@example.com","user","0412-5550148");




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;