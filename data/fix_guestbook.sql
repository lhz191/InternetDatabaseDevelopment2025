-- 创建留言板表 (修正版)
SET NAMES utf8mb4;
USE news_system;

DROP TABLE IF EXISTS `pre_guestbook`;
CREATE TABLE `pre_guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) NOT NULL COMMENT '留言者昵称',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `content` text NOT NULL COMMENT '留言内容',
  `ip_address` varchar(50) DEFAULT NULL COMMENT '留言IP',
  `is_read` tinyint(1) DEFAULT 0 COMMENT '管理员是否已读',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='留言板表';

INSERT INTO `pre_guestbook` (`nickname`, `email`, `content`, `ip_address`) VALUES
('张三', 'zhangsan@example.com', '铭记历史，珍爱和平！向抗战英雄致敬！', '127.0.0.1'),
('李四', 'lisi@example.com', '感谢这个网站让我们了解这段历史，永不忘记！', '127.0.0.1'),
('王五', 'wangwu@example.com', '勿忘国耻，振兴中华！', '127.0.0.1'),
('赵六', 'zhaoliu@example.com', '80年前的胜利来之不易，我们要倍加珍惜今天的和平生活。', '127.0.0.1'),
('孙七', 'sunqi@example.com', '向所有为国捐躯的先烈们致以最崇高的敬意！', '127.0.0.1');
