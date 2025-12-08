-- 添加5篇草稿文章
USE news_system;

UPDATE pre_news_article SET status = 0 WHERE aid IN (10, 20, 30, 40, 50);

SELECT '已将5篇文章设为草稿' AS message;

