CREATE TABLE tblBlockedAddress (
  intBlockedAddressId INT          AUTO_INCREMENT NOT NULL,
  strAddress          VARCHAR(180)                NOT NULL,
  dtmTimestamp        DATETIME                    NOT NULL,

  UNIQUE KEY UK_intBlockedAddressId (intBlockedAddressId),
  UNIQUE KEY UK_strAddress (strAddress),
  PRIMARY KEY(intBlockedAddressId)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE tblPage (
  intPageId  INT          AUTO_INCREMENT NOT NULL,
  strName    VARCHAR(40)                 NOT NULL,
  strContent TEXT                        NOT NULL,
  strTitle   VARCHAR(280)                NOT NULL,

  UNIQUE KEY UK_intPageId (intPageId),
  PRIMARY KEY(intPageId)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE tblTweet (
  intTweetId        VARCHAR(100)  NOT NULL,
  intTimestamp      INT           NOT NULL,
  dtmTimestamp      DATETIME      NOT NULL,
  strContent        VARCHAR(560)  NOT NULL,
  strAvatar         VARCHAR(1000) NOT NULL,
  strName           VARCHAR(100)  NOT NULL,
  strScreenName     VARCHAR(60)   NOT NULL,
  intFetchTimestamp INT           NOT NULL,
  dtmFetchTimestamp DATETIME      NOT NULL,

  UNIQUE KEY UK_intTweetId (intTweetId),
  PRIMARY KEY(intTweetId)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE tblPost (
  intPostId    INT           AUTO_INCREMENT NOT NULL,
  intTimestamp INT                          NOT NULL,
  dtmTimestamp DATETIME                     NOT NULL,
  strTitle     VARCHAR(280)                 NOT NULL,
  strContent   TEXT                         NOT NULL,
  bolDraft     TINYINT(1)                   NOT NULL,
  bolTweeted   TINYINT(1)                   NOT NULL,

  UNIQUE KEY UK_intPostId (intPostId),
  PRIMARY KEY(intPostId)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE tblComment (
  intCommentId INT           AUTO_INCREMENT NOT NULL,
  strUsername  VARCHAR(100)                 NOT NULL,
  strContent   VARCHAR(4000)                NOT NULL,
  intTimestamp INT                          NOT NULL,
  dtmTimestamp DATETIME                     NOT NULL,
  strClientIp  VARCHAR(180)                 NOT NULL,
  intPostId    INT                          DEFAULT NULL,

  UNIQUE KEY UK_intCommentId (intCommentId),
  PRIMARY KEY (intCommentId),
  KEY K_intPostId (intPostId),
  CONSTRAINT FK_tblPost_intPostId FOREIGN KEY (intPostId) REFERENCES tblPost (intPostId)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE tblUser (
  intUserId   INT          AUTO_INCREMENT NOT NULL,
  strUsername VARCHAR(45)                 NOT NULL,
  strPassword VARCHAR(512)                NOT NULL,

  UNIQUE KEY UK_intUserId (intUserId),
  UNIQUE KEY UK_strUsername (strUsername),
  PRIMARY KEY(intUserId)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
