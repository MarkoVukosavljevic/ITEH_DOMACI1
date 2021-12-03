CREATE TABLE Books
(
    BookId int  AUTO_INCREMENT,
    AuthorId int NOT NULL,
    Caption varchar(255) NOT NULL,
    Genre varchar(1000) NOT NULL,
    PublishedOn datetime NOT NULL,
    InsertedOn datetime NOT NULL,
    DeletedOn datetime,
    PRIMARY KEY(BookId),
    FOREIGN KEY (AuthorId) REFERENCES Author(AuthorId)
);
