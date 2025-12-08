USE news_system;
INSERT INTO user (username, auth_key, password_hash, email, status, created_at, updated_at) 
VALUES ('admin', 'admin123key456789', '$2y$13$EjaPFBnZOQsHdGuHI.xvhuDp1fHpo8hKRSk6yshqa9c5EG8j0vQa.', 'admin@example.com', 10, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

