alter table `users`
    add column `active` tinyint(1) not null default 1 after `pass`;