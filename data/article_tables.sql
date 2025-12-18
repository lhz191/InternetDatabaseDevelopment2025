-- =====================================================
-- 文章管理相关扩展表
-- @author 刘浩泽 (2212478)
-- @date 2025-12-18
-- @description 文章标签、浏览记录、点赞记录等扩展表
-- =====================================================

SET NAMES utf8mb4;
USE `news_system`;

-- 1. 文章标签表
CREATE TABLE IF NOT EXISTS `pre_article_tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标签ID',
  `name` varchar(50) NOT NULL COMMENT '标签名称',
  `color` varchar(20) DEFAULT '#8B0000' COMMENT '标签颜色',
  `sort_order` int(11) DEFAULT 0 COMMENT '排序',
  `article_count` int(11) DEFAULT 0 COMMENT '文章数量',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章标签表';

-- 2. 文章-标签关联表
CREATE TABLE IF NOT EXISTS `pre_article_tag_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL COMMENT '文章ID',
  `tag_id` int(11) NOT NULL COMMENT '标签ID',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_article_tag` (`aid`, `tag_id`),
  KEY `idx_aid` (`aid`),
  KEY `idx_tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章标签关联表';

-- 3. 文章浏览记录表
CREATE TABLE IF NOT EXISTS `pre_article_view_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL COMMENT '文章ID',
  `ip` varchar(50) DEFAULT NULL COMMENT '访客IP',
  `user_agent` varchar(500) DEFAULT NULL COMMENT '浏览器信息',
  `referer` varchar(500) DEFAULT NULL COMMENT '来源页面',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '浏览时间',
  PRIMARY KEY (`id`),
  KEY `idx_aid` (`aid`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章浏览记录表';

-- 4. 文章点赞记录表
CREATE TABLE IF NOT EXISTS `pre_article_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL COMMENT '文章ID',
  `uid` int(11) DEFAULT NULL COMMENT '用户ID(可为空,游客)',
  `ip` varchar(50) DEFAULT NULL COMMENT '点赞者IP',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_aid` (`aid`),
  KEY `idx_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章点赞记录表';

-- 5. 文章收藏表
CREATE TABLE IF NOT EXISTS `pre_article_favorite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL COMMENT '文章ID',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_user_article` (`uid`, `aid`),
  KEY `idx_aid` (`aid`),
  KEY `idx_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章收藏表';

-- 6. 文章附件表
CREATE TABLE IF NOT EXISTS `pre_article_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL COMMENT '文章ID',
  `filename` varchar(255) NOT NULL COMMENT '文件名',
  `filepath` varchar(500) NOT NULL COMMENT '文件路径',
  `filesize` int(11) DEFAULT 0 COMMENT '文件大小(字节)',
  `filetype` varchar(50) DEFAULT NULL COMMENT '文件类型',
  `downloads` int(11) DEFAULT 0 COMMENT '下载次数',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_aid` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章附件表';

-- =====================================================
-- 插入示例数据
-- =====================================================

-- 标签数据
INSERT INTO `pre_article_tag` (`name`, `color`, `sort_order`, `article_count`) VALUES
('重大战役', '#8B0000', 1, 50),
('英雄人物', '#B8860B', 2, 45),
('历史文献', '#4a4a4a', 3, 30),
('纪念活动', '#1890ff', 4, 25),
('抗战遗址', '#52c41a', 5, 20),
('老兵故事', '#722ed1', 6, 15),
('国际援助', '#13c2c2', 7, 10),
('胜利纪念', '#FFD700', 8, 35);

-- 文章标签关联数据（前20篇文章随机关联标签）
INSERT INTO `pre_article_tag_relation` (`aid`, `tag_id`) VALUES
(1, 1), (1, 2), (2, 1), (2, 3), (3, 2), (3, 4),
(4, 1), (4, 5), (5, 2), (5, 6), (6, 3), (6, 7),
(7, 4), (7, 8), (8, 1), (8, 2), (9, 5), (9, 6),
(10, 3), (10, 8), (11, 1), (12, 2), (13, 4), (14, 5),
(15, 6), (16, 7), (17, 8), (18, 1), (19, 2), (20, 3);

-- 模拟浏览记录
INSERT INTO `pre_article_view_log` (`aid`, `ip`, `user_agent`) VALUES
(1, '192.168.1.100', 'Mozilla/5.0 Chrome/120.0'),
(1, '192.168.1.101', 'Mozilla/5.0 Firefox/121.0'),
(2, '192.168.1.102', 'Mozilla/5.0 Safari/17.0'),
(3, '192.168.1.103', 'Mozilla/5.0 Edge/120.0'),
(4, '192.168.1.104', 'Mozilla/5.0 Chrome/120.0'),
(5, '192.168.1.105', 'Mozilla/5.0 Chrome/120.0');

-- 模拟点赞记录
INSERT INTO `pre_article_like` (`aid`, `ip`) VALUES
(1, '192.168.1.100'), (1, '192.168.1.101'), (1, '192.168.1.102'),
(2, '192.168.1.103'), (2, '192.168.1.104'),
(3, '192.168.1.105'), (3, '192.168.1.106'),
(4, '192.168.1.107'), (5, '192.168.1.108');

