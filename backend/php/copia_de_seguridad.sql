

CREATE TABLE `datos_pers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data-tecnico` varchar(100) NOT NULL,
  `data-grupo` varchar(100) NOT NULL,
  `data-categoria` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO datos_pers VALUES('1','MARIA','Maria - Juan','Direccion');
INSERT INTO datos_pers VALUES('2','MARIA2','Maria - Juan','01 Direccion de informatica y sistemas > division de soporte tecnico');
INSERT INTO datos_pers VALUES('3','MARIA1','Maria - Juan','01 Direccion de informatica y sistemas > division de problemas de internet');
INSERT INTO datos_pers VALUES('4','MARIA','Maria - Juan','01 Direccion de informatica y sistemas > division de desarrollo de sistemas');
INSERT INTO datos_pers VALUES('5','MARIA','Maria - Juan','01 Direccion de informatica y sistemas > division de desarrollo de sistemas');
INSERT INTO datos_pers VALUES('6','MARIA2','Maria - Juan','Direccion 2');
INSERT INTO datos_pers VALUES('7','MARIA2','Maria - Juan','01 Direccion de informatica y sistemas > division de problemas de internet');
INSERT INTO datos_pers VALUES('8','MARIA','Maria - Juan','01 Direccion de informatica y sistemas > division de problemas de internet');
INSERT INTO datos_pers VALUES('9','MARIA','Maria - Juan','01 Direccion de informatica y sistemas > division de problemas de internet');
INSERT INTO datos_pers VALUES('10','MARIA2','Maria - Juan','Direccion');


CREATE TABLE `incidencias` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `prioridad` varchar(100) NOT NULL,
  `solicitante` varchar(100) NOT NULL,
  `tecnico` varchar(100) NOT NULL,
  `grupo` varchar(100) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `fecha` date DEFAULT '1970-01-01',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO incidencias VALUES('23','Arreglar sistema ','Sin resolver','Urgente','Lucia lopez','Juan Lopez','Carolina Vixleris','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-05');
INSERT INTO incidencias VALUES('24','Arreglar sistema','En Curso','Baja','maria juanita','Carolina Vixleris','Jose Arenas','01 Direccion de informatica y sistemas > division de soporte tecnico','0000-00-00');
INSERT INTO incidencias VALUES('25','SUPERVISAR','En Curso','Media','Lucia lopez','Carolina Vixleris','Carolina Vixleris','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-19');
INSERT INTO incidencias VALUES('26','Arreglar sistema ','Resuelto','Urgente','Lucia lopez','Jose Arenas','Juan Lopez','01 Direccion de informatica y sistemas > division de desarrollo de sistemas','2024-04-18');
INSERT INTO incidencias VALUES('27','Arreglar sistema','En Curso','Baja','Lucia lopez','Juan Lopez','Jose Arenas','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-19');
INSERT INTO incidencias VALUES('28','Arreglar sistema ','Sin resolver','Urgente','maria','Carolina Vixleris','Carolina Vixleris','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-13');
INSERT INTO incidencias VALUES('29','SUPERVISAR','Resuelto','Urgente','maria','Jose Arenas','Carolina Vixleris','01 Direccion de informatica y sistemas > division de desarrollo de sistemas','0000-00-00');
INSERT INTO incidencias VALUES('30','Arreglar sistema ','Sin resolver','Urgente','maria','Carolina Vixleris','Carolina Vixleris','01 Direccion de informatica y sistemas > division de desarrollo de sistemas','2024-04-04');
INSERT INTO incidencias VALUES('31','Arreglar sistema ','En Curso','Media','Lucia lopez','Carolina Vixleris','Carolina Vixleris','01 Direccion de informatica y sistemas > division de problemas de internet','2024-04-06');
INSERT INTO incidencias VALUES('32','SUPERVISAR','Resuelto','Urgente','maria lopez','Carolina Vixleris','Carolina Vixleris','01 Direccion de informatica y sistemas > division de problemas de internet','2024-04-30');
INSERT INTO incidencias VALUES('33','kkkkk','Sin resolver','Urgente','Lucia lopez','Jose Arenas','Carolina Vixleris','01 Direccion de informatica y sistemas > division de desarrollo de sistemas','2024-04-06');
INSERT INTO incidencias VALUES('34','Arreglar sistema ','Resuelto','Media','kkkkk','Juan Lopez','Carolina Vixleris','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-19');
INSERT INTO incidencias VALUES('35','Arreglar sistema ','Sin resolver','Urgente','maria lopez','Jose Arenas','Carolina Vixleris','Seleccionar...','0000-00-00');
INSERT INTO incidencias VALUES('36','SUPERVISAR','Sin resolver','Urgente','kkkkk','Jose Arenas','Carolina Vixleris','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-27');
INSERT INTO incidencias VALUES('37','Arreglar sistema ','Resuelto','Baja','Emilia','Juan Lopez','Juan Lopez','01 Direccion de informatica y sistemas > division de soporte tecnico','0000-00-00');
INSERT INTO incidencias VALUES('38','Arreglar sistema','En Curso','Media','Lucia lopez','Juan Lopez','Carolina Vixleris','01 Direccion de informatica y sistemas > division de desarrollo de sistemas','2024-04-30');
INSERT INTO incidencias VALUES('39','Arreglar sistema','Sin resolver','Media','maria lopez','Carolina Vixleris','Jose Arenas','01 Direccion de informatica y sistemas > division de problemas de internet','2024-05-04');
INSERT INTO incidencias VALUES('40','SUPERVISAR','En Curso','Media','Lucia lopez','Jose Arenas','Carolina Vixleris','01 Direccion de informatica y sistemas > division de problemas de internet','2024-04-20');
INSERT INTO incidencias VALUES('41','Arreglar sistema ','En Curso','Urgente','maria lopez','Jose Arenas','Jose Arenas','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-19');
INSERT INTO incidencias VALUES('42','Arreglar sistema','Sin resolver','Urgente','lucianakllj;lm','Jose Arenas','Juan Lopez','01 Direccion de informatica y sistemas > division de desarrollo de sistemas','2024-04-03');
INSERT INTO incidencias VALUES('43','SUPERVISAR','Sin resolver','Urgente','ytghjkl;','Carolina Vixleris','Juan Lopez','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-10');
INSERT INTO incidencias VALUES('44','Arreglar sistema','Resuelto','Urgente','juanakkkkkkkk','Carolina Vixleris','Jose Arenas','01 Direccion de informatica y sistemas > division de soporte tecnico','0000-00-00');
INSERT INTO incidencias VALUES('47','Arreglar sistema ','Sin resolver','Urgente','juanaaaaa','Carolina Vixleris','Carolina Vixleris','01 Direccion de informatica y sistemas > division de desarrollo de sistemas','2024-04-23');
INSERT INTO incidencias VALUES('48','Arreglar sistema','Sin resolver','Urgente','juan','Seleccionar...','Seleccionar...','Seleccionar...','2024-04-18');
INSERT INTO incidencias VALUES('49','SUPERVISAR','Sin resolver','Urgente','elsa','Jose Arenas','Carolina Vixleris','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-13');
INSERT INTO incidencias VALUES('50','Arreglar sistema ','Sin resolver','Urgente','Lucia lopez lopez','Carolina Vixleris','Carolina Vixleris','01 Direccion de informatica y sistemas > division de desarrollo de sistemas','0000-00-00');
INSERT INTO incidencias VALUES('51','kkkkk','Sin resolver','Urgente','jorge','Jose Arenas','Jose Arenas','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-18');
INSERT INTO incidencias VALUES('52','matia','Sin resolver','Urgente','maria juelieta','Jose Arenas','Carolina Vixleris','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-11');
INSERT INTO incidencias VALUES('53','Arreglar sistema n','Sin resolver','Urgente','juli','Jose Arenas','Jose Arenas','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-10');
INSERT INTO incidencias VALUES('54','Arreglar sistema ','En Curso','Baja','juanakk','Jose Arenas','Carolina Vixleris','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-11');
INSERT INTO incidencias VALUES('55','Arreglar sistema','Sin resolver','Urgente','lucianakkk','Jose Arenas','Carolina Vixleris','01 Direccion de informatica y sistemas > division de soporte tecnico','0000-00-00');
INSERT INTO incidencias VALUES('57','aaaaaaaaaaaaaaaa','Sin resolver','Urgente','','Seleccionar...','Carolina Vixleris','Seleccionar...','2024-04-16');
INSERT INTO incidencias VALUES('58','jujjjj','Sin resolver','Urgente','jjjjgyfyhv','Jose Arenas','Carolina Vixleris','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-25');
INSERT INTO incidencias VALUES('59','maria morena','Sin resolver','Urgente','kkkkk','Jose Arenas','Carolina Vixleris','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-19');
INSERT INTO incidencias VALUES('60','maria','Sin resolver','Urgente','Lucia lopez','Carolina Vixleris','Carolina Vixleris','01 Direccion de informatica y sistemas > division de desarrollo de sistemas','0000-00-00');
INSERT INTO incidencias VALUES('61','Arreglar sistema ','Sin resolver','Urgente','maria lopez','Juan Lopez','Carolina Vixleris','Seleccionar...','2024-04-25');
INSERT INTO incidencias VALUES('62','Arreglar sistema Rojo','Resuelto','Media','Lucia lopez','Jose Arenas','Jose Arenas','01 Direccion de informatica y sistemas > division de soporte tecnico','2024-04-12');
INSERT INTO incidencias VALUES('63','','Sin resolver','Urgente','','Seleccionar...','Carolina Vixleris','Seleccionar...','0000-00-00');


CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `message` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO mensajes VALUES('1','maria2','maria2','Este es un mensaje de prueba enviado desde la consola del navegador','2024-04-17 01:52:41');
INSERT INTO mensajes VALUES('2','maria2','maria2','Este es un mensaje de prueba enviado desde la consola del navegador','2024-04-17 02:03:20');
INSERT INTO mensajes VALUES('3','maria3','<?php echo $chatUser; ?>','k,mkl','2024-04-18 11:17:08');
INSERT INTO mensajes VALUES('4','maria3','<?php echo $chatUser; ?>','','2024-04-18 11:17:08');
INSERT INTO mensajes VALUES('5','maria3','<?php echo $chatUser; ?>','kmlk','2024-04-18 11:19:00');
INSERT INTO mensajes VALUES('6','maria2','<?php echo $chatUser; ?>',',m,..','2024-04-18 11:19:03');
INSERT INTO mensajes VALUES('7','maria2','<?php echo $chatUser; ?>','m,k,.','2024-04-18 11:22:03');
INSERT INTO mensajes VALUES('8','maria2','<?php echo $chatUser; ?>','kkk','2024-04-18 15:55:19');
INSERT INTO mensajes VALUES('9','maria3','<?php echo $chatUser; ?>','kk','2024-04-18 15:57:46');
INSERT INTO mensajes VALUES('10','maria3','<?php echo $chatUser; ?>','kkkkk','2024-04-18 16:02:55');
INSERT INTO mensajes VALUES('11','maria2','<?php echo $chatUser; ?>','m','2024-04-18 16:03:51');
INSERT INTO mensajes VALUES('12','maria3','<?php echo $chatUser; ?>','oo','2024-04-18 17:00:32');
INSERT INTO mensajes VALUES('13','maria3','maria2','l','2024-04-18 17:03:30');
INSERT INTO mensajes VALUES('14','maria3','maria2','','2024-04-18 17:03:30');
INSERT INTO mensajes VALUES('15','maria3','maria2','l','2024-04-18 17:08:47');
INSERT INTO mensajes VALUES('16','maria2','maria3','llll','2024-04-18 17:09:44');
INSERT INTO mensajes VALUES('17','maria2','maria3',',','2024-04-18 17:09:46');
INSERT INTO mensajes VALUES('18','maria3','maria2','k','2024-04-18 17:14:20');
INSERT INTO mensajes VALUES('19','maria3','maria2','kikk','2024-04-18 17:15:16');
INSERT INTO mensajes VALUES('20','maria3','maria2','hoal','2024-04-18 17:15:20');
INSERT INTO mensajes VALUES('21','maria2','maria3','kkk','2024-04-18 17:24:29');
INSERT INTO mensajes VALUES('22','maria2','maria3','kkk','2024-04-18 17:24:32');
INSERT INTO mensajes VALUES('23','maria2','maria3','kk','2024-04-18 17:25:42');
INSERT INTO mensajes VALUES('24','maria2','maria3','i','2024-04-18 17:25:46');
INSERT INTO mensajes VALUES('25','maria2','maria3','hola juan','2024-04-18 17:26:25');
INSERT INTO mensajes VALUES('26','maria2','maria3','hola jose','2024-04-18 17:26:32');
INSERT INTO mensajes VALUES('27','maria3','maria2','kkk','2024-04-18 17:57:28');
INSERT INTO mensajes VALUES('28','maria3','maria2','fff','2024-04-18 17:57:34');


CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roles` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO roles VALUES('1','Admin');
INSERT INTO roles VALUES('2','Jefe');
INSERT INTO roles VALUES('3','Administrativo');


CREATE TABLE `usuarios` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id_fk` int(11) DEFAULT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `phone` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `file` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `status` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  KEY `fk_role` (`role_id_fk`),
  CONSTRAINT `fk_role` FOREIGN KEY (`role_id_fk`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO usuarios VALUES('2','maria','raicimer@gmail.com','$2y$10$fqVTmcQqaaDSi8gsHWRTPuhBqxBgGHS9T3CzRY4NTnfTbu27TWn..','2','','','0416-8799631','Upata','','1','en línea');
INSERT INTO usuarios VALUES('3','juan garcia g','sofgirl2601@gmail.com','$2y$10$zOrSBc/HLJHlpJy0P3Mc6uRAEYZsB2UnRjV.MWwvMzb.yH3BfovRi','3','','','0412-1234569','Punta de plata','','0','desconectado');
INSERT INTO usuarios VALUES('4','Raici_cgt','maria@gmail.com','$2y$10$8RgxLhRWW.mM/PBeQNzQ9up.JDymCZHEeZoIqh4EzbEDJgfp4OPwK','3','','','0412-4567899','Nieves del Sur','','1','desconectado');
INSERT INTO usuarios VALUES('5','sebastianx','you@gmail.com','$2y$10$KGVP6wxyeKH02Jy52z4hHuihLSIfP6qhKf10q.7MXouuMvNfmoY42','3','','','0426-7896693','Farmatodo','','0','desconectado');
INSERT INTO usuarios VALUES('6','daniela','DANIELA@gmail.com','$2y$10$W.Oih31nX8196jxSKfDX1us9dxe1JT8qMCfELPv2VHAmUktvwJSp6','2','','','0412-7896548','Google','','1','desconectado');
INSERT INTO usuarios VALUES('7','Romeo','romeo@gmail.com','$2y$10$eUxQ7Fr41nqQSxUJlwniye/VKOyzJETZh2xPfok3oaWwzmB84xWei','2','','','0412-4563219','Colorada','','1','desconectado');
INSERT INTO usuarios VALUES('8','karol','karol@gmail.com','$2y$10$6Z8TWe3zcvJqykvC3QrR9.LrMIGDATAQkm9xHErNIhWdb7zoL1LN2','2','','','0412-7894565','Nieves','','1','desconectado');
INSERT INTO usuarios VALUES('9','Miko','babymiko@gmail.com','$2y$10$f4kDRHzEWIa7mqpcel9bke736jjsS7b1wySyDx4D0PrVMpSklSY.C','3','','','0424-7778889','deleder','','1','desconectado');
INSERT INTO usuarios VALUES('10','peach','peach@gmail.com','$2y$10$MdZZ5xyc2/38i8aFnUXpwOjJNmfKE8e/rzfPC0Lwce2hP2SmRGJuO','2','','','0414-9998887',' Reino Champiñón','','1','desconectado');
INSERT INTO usuarios VALUES('11','princess','princess@gmail.com','$2y$10$mTFzvGcZ2D2sYadqTk4weuOx2eV2zMcxvRByWno8dbByiL26M4L3O','2','','','0424-7778889',' Mundo del desierto','','1','desconectado');
INSERT INTO usuarios VALUES('12','nicki','nicki@gmail.com','$2y$10$Y0ZPMGjkWl5wscu8vySX5OC/dzdFfaJe6IsSbNRQHxOCrQc2CHN92','2','','','0426-9998887','Reino de los pingüinos.','','1','desconectado');
INSERT INTO usuarios VALUES('16','sofia','dire.inf.app@gmail.com','$2y$10$VL18uJQg9YWSrogeTJ24SuE5j0O7Or9JFLIybT.TtfBWK/o5r1FCa','1','','','0414-4563217','Santa Helena','','1','desconectado');
INSERT INTO usuarios VALUES('17','maria2','maria2@gmail.com','$2y$10$yccouZSlEseLbWKN8937Eup7J2v/OtFkOWArw5yTCd2zQwlW.Ismy','3','','','0414-7899998','Maria Montesori','Captura de pantalla (77).png','1','desconectado');
INSERT INTO usuarios VALUES('18','maria3','maria3@gmail.com','$2y$10$yx2IaFpvWbfRNGmtiPKrX.smou8kWTQUOm9bFcveo3n6yql0fC6/K','3','','','0412-4566547','Nieves','Captura de pantalla (79).png','1','en línea');
INSERT INTO usuarios VALUES('19','maria4','maria4@gmail.com','$2y$10$Z82dOortPALgpcgvIzGJn.Fv3aOnt2Gq5Go5xPo3KgHTY8XL81T/e','3','','','0412-7778889','Nieves','Captura de pantalla (67).png','1','desconectado');
