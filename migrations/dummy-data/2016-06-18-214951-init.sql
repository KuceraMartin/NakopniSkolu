/* schools table */
INSERT INTO `schools` (`id`, `name`, `email`, `password`, `phone`, `website`, `region_id`, `address`, `city`, `zip`, `created_at`) VALUES
(1,	'School #1',	'john.doe@yourdomain.com',	'$2y$10$bT.RK28hCqb08DABPNbCbO7jQ9t6iflXe.yCJwHXK47XGCNw1154m',	'+420 733 330 705',	'www.yourdomain.com',	1,	'Na příkopě 21',	'Praha 6',	'160 000',	'2016-06-18 00:00:00'), -- pass
(2,	'School #2',	'john.doe@yourdomain.com',	'$2y$10$bT.RK28hCqb08DABPNbCbO7jQ9t6iflXe.yCJwHXK47XGCNw1154m',	'+420 733 330 705',	'www.yourdomain.com',	1,	'Na příkopě 21',	'Praha 6',	'160 000',	'2016-06-18 00:00:00');

/* projects table */
INSERT INTO `projects` (`id`, `name`, `description`, `school_id`, `funded`, `created_at`) VALUES
(1,	'Project #1',	'Hi, I am an amazing project. Cool, huh?',	1,	0,	'2016-06-18 22:14:29');
