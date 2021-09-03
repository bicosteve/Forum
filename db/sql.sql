CREATE TABLE users(
  userid INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  username VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  join_date DATE NOT NULL,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE posts(
  postid INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  post VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  post_date DATE NOT NULL,
  userid INT NOT NULL,
  FOREIGN KEY(userid) REFERENCES users(userid)
);

CREATE TABLE comments(
  commentid INT PRIMARY KEY AUTO_INCREMENT  NOT NULL,
  comment TEXT NOT NULL,
  userid INT NOT NULL,
  postid INT NOT NULL,
  comment_date DATE NOT NULL,
  FOREIGN KEY (userid) REFERENCES users(userid)
                        ON DELETE CASCADE,
  FOREIGN KEY (postid) REFERENCES posts(postid)
                        ON DELETE CASCADE
);