create table if not exists `versions` (
    `id` int(10) unsigned not null auto_increment,
    `name` varchar(255) not null,
    `created` timestamp default current_timestamp,
    primary key (id)
)
engine = innodb
auto_increment = 1
character set utf8
collate utf8_general_ci;
create table if not exists `users` (
    `user_id` int(4) not null auto_increment,
    `login` varchar(255) not null,
    `pass` char(60) not null,
    primary key (user_id)
)
engine = innodb
auto_increment = 1
character set utf8
collate utf8_general_ci;
create table if not exists `books` (
    `book_id` int(4) unsigned not null auto_increment,
    `name` varchar(255) not null,
    `authors` varchar(400),
    `description` text,
    `year` year (4),
    `image` longblob,
    primary key (book_id)
)
engine = innodb
auto_increment = 1
character set utf8
collate utf8_general_ci;