# solemdalx
for Topface

http://solemdalx.rf.gd/

Страница с формой авторизацией: login.html
Страница с формой регистрации: register.html


База данных содержит одну таблицу
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` tinytext,
  `password` tinytext,
  `date_reg` tinytext,
  `email` tinytext,
  PRIMARY KEY (`id`)
);
