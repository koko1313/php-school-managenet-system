INSERT INTO `roles` (`id`, `role`) VALUES (NULL, 'administrator'), (NULL, 'class teacher'), (NULL, 'teacher'), (NULL, 'student');

INSERT INTO `administrator` (`id`, `username`, `password`, `role_id`, `allow_password_change`) VALUES (NULL, 'administrator', 'password', '1', '1');

INSERT INTO `terms` (`id`, `term`, `term_label`) VALUES (NULL, '1', 'Първи'), (NULL, '2', 'Втори');

INSERT INTO `grades` (`id`, `grade`, `grade_label`) VALUES (NULL, '2', 'Слаб'), (NULL, '3', 'Среден'), (NULL, '4', 'Добър'), (NULL, '5', 'Много Добър'), (NULL, '6', 'Отличен');

INSERT INTO `school_session` (`term_id`, `now`) VALUES ('1','1'), ('2','0');

INSERT INTO `school` (`name`, `description`) VALUES ('Име на училището','Описание');

