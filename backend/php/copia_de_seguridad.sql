

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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO incidencias VALUES('9','Arreglar sistema ','Resuelto','Media','','Seleccionar...','Carolina Vixleris','Seleccionar...','2024-04-09');
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
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  KEY `fk_role` (`role_id_fk`),
  CONSTRAINT `fk_role` FOREIGN KEY (`role_id_fk`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO usuarios VALUES('2','maria','raicimer@gmail.com','$2y$10$fqVTmcQqaaDSi8gsHWRTPuhBqxBgGHS9T3CzRY4NTnfTbu27TWn..','2','','','0416-8799631','Upata','1');
INSERT INTO usuarios VALUES('3','juan garcia g','sofgirl2601@gmail.com','$2y$10$zOrSBc/HLJHlpJy0P3Mc6uRAEYZsB2UnRjV.MWwvMzb.yH3BfovRi','3','','','0412-1234569','Punta de plata','0');
INSERT INTO usuarios VALUES('4','Raici_cgt','maria@gmail.com','$2y$10$8RgxLhRWW.mM/PBeQNzQ9up.JDymCZHEeZoIqh4EzbEDJgfp4OPwK','3','','','0412-4567899','Nieves del Sur','1');
INSERT INTO usuarios VALUES('5','sebastianx','you@gmail.com','$2y$10$KGVP6wxyeKH02Jy52z4hHuihLSIfP6qhKf10q.7MXouuMvNfmoY42','3','','','0426-7896693','Farmatodo','0');
INSERT INTO usuarios VALUES('6','daniela','DANIELA@gmail.com','$2y$10$W.Oih31nX8196jxSKfDX1us9dxe1JT8qMCfELPv2VHAmUktvwJSp6','2','','','0412-7896548','Google','1');
INSERT INTO usuarios VALUES('7','Romeo','romeo@gmail.com','$2y$10$eUxQ7Fr41nqQSxUJlwniye/VKOyzJETZh2xPfok3oaWwzmB84xWei','2','','','0412-4563219','Colorada','1');
INSERT INTO usuarios VALUES('8','karol','karol@gmail.com','$2y$10$6Z8TWe3zcvJqykvC3QrR9.LrMIGDATAQkm9xHErNIhWdb7zoL1LN2','2','','','0412-7894565','Nieves','1');
INSERT INTO usuarios VALUES('9','Miko','babymiko@gmail.com','$2y$10$f4kDRHzEWIa7mqpcel9bke736jjsS7b1wySyDx4D0PrVMpSklSY.C','3','','','0424-7778889','deleder','1');
INSERT INTO usuarios VALUES('10','peach','peach@gmail.com','$2y$10$MdZZ5xyc2/38i8aFnUXpwOjJNmfKE8e/rzfPC0Lwce2hP2SmRGJuO','2','','','0414-9998887',' Reino Champiñón','1');
INSERT INTO usuarios VALUES('11','princess','princess@gmail.com','$2y$10$mTFzvGcZ2D2sYadqTk4weuOx2eV2zMcxvRByWno8dbByiL26M4L3O','2','','','0424-7778889',' Mundo del desierto','1');
INSERT INTO usuarios VALUES('12','nicki','nicki@gmail.com','$2y$10$Y0ZPMGjkWl5wscu8vySX5OC/dzdFfaJe6IsSbNRQHxOCrQc2CHN92','2','','','0426-9998887','Reino de los pingüinos.','1');
INSERT INTO usuarios VALUES('16','sofia','dire.inf.app@gmail.com','$2y$10$VL18uJQg9YWSrogeTJ24SuE5j0O7Or9JFLIybT.TtfBWK/o5r1FCa','1','','','0414-4563217','Santa Helena','1');
