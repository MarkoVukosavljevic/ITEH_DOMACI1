CREATE TABLE Authors
(
    AuthorId int AUTO_INCREMENT,
    FirstName varchar(255) NOT NULL,
    LastName varchar(255) NOT NULL,
    InsertedOn datetime NOT NULL,
    DeletedOn datetime,
    PRIMARY KEY(AuthorId)
    
);