-- 创建留言板表
SET NAMES utf8mb4;
USE news_system;

CREATE TABLE IF NOT EXISTS `pre_guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '留言者姓名',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `content` text NOT NULL COMMENT '留言内容',
  `status` tinyint(1) DEFAULT 1 COMMENT '状态',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='留言板表';

INSERT INTO `pre_guestbook` (`name`, `email`, `content`, `status`) VALUES
('张三', 'zhangsan@example.com', '铭记历史，珍爱和平！向抗战英雄致敬！', 1),
('李四', 'lisi@example.com', '感谢这个网站让我们了解这段历史，永不忘记！', 1),
('王五', 'wangwu@example.com', '勿忘国耻，振兴中华！', 1),
('赵六', 'zhaoliu@example.com', '80年前的胜利来之不易，我们要倍加珍惜今天的和平生活。', 1),
('孙七', 'sunqi@example.com', '向所有为国捐躯的先烈们致以最崇高的敬意！', 1);

