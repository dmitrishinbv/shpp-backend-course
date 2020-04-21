create table if not exists `authors` (
    `id` int(4) unsigned not null auto_increment,
    `author` varchar(255) unique not null,
    primary key (id)
)
engine = innodb
auto_increment = 1
character set utf8
collate utf8_general_ci;
create table if not exists `books_and_authors` (
    `id` int(4) unsigned not null auto_increment,
    `book_id` int(4) unique not null,
    `author_id` int(4) default 0,
    primary key (id)
)
engine = innodb
auto_increment = 1
character set utf8
collate utf8_general_ci;