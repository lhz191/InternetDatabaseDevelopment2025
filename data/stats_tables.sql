-- =====================================================
-- 数据统计相关表
-- @author 刘浩泽 (2212478)
-- @date 2025-12-18
-- @description 支持动态图表展示的统计数据表
-- =====================================================

SET NAMES utf8mb4;
USE `news_system`;

-- 1. 每日统计表 (用于趋势图)
CREATE TABLE IF NOT EXISTS `pre_daily_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stat_date` date NOT NULL COMMENT '统计日期',
  `article_count` int(11) DEFAULT 0 COMMENT '当日新增文章数',
  `view_count` int(11) DEFAULT 0 COMMENT '当日浏览量',
  `like_count` int(11) DEFAULT 0 COMMENT '当日点赞数',
  `comment_count` int(11) DEFAULT 0 COMMENT '当日评论数',
  `user_count` int(11) DEFAULT 0 COMMENT '当日新增用户数',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_date` (`stat_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='每日统计表';

-- 2. 分类统计表 (用于饼图)
CREATE TABLE IF NOT EXISTS `pre_category_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL COMMENT '分类ID',
  `article_count` int(11) DEFAULT 0 COMMENT '文章数量',
  `view_count` int(11) DEFAULT 0 COMMENT '总浏览量',
  `like_count` int(11) DEFAULT 0 COMMENT '总点赞数',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_cid` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='分类统计表';

-- =====================================================
-- 插入模拟统计数据 (最近30天)
-- =====================================================

INSERT INTO `pre_daily_stats` (`stat_date`, `article_count`, `view_count`, `like_count`, `comment_count`, `user_count`) VALUES
('2025-11-18', 15, 1200, 89, 23, 5),
('2025-11-19', 12, 980, 76, 18, 3),
('2025-11-20', 18, 1450, 102, 31, 7),
('2025-11-21', 10, 890, 65, 15, 2),
('2025-11-22', 22, 1680, 125, 42, 8),
('2025-11-23', 8, 720, 48, 12, 1),
('2025-11-24', 14, 1100, 82, 25, 4),
('2025-11-25', 19, 1520, 98, 35, 6),
('2025-11-26', 16, 1280, 91, 28, 5),
('2025-11-27', 11, 950, 68, 19, 3),
('2025-11-28', 25, 1890, 145, 48, 9),
('2025-11-29', 13, 1050, 75, 22, 4),
('2025-11-30', 17, 1380, 95, 32, 6),
('2025-12-01', 20, 1600, 112, 38, 7),
('2025-12-02', 9, 780, 55, 14, 2),
('2025-12-03', 23, 1750, 132, 45, 8),
('2025-12-04', 15, 1200, 88, 26, 5),
('2025-12-05', 18, 1420, 105, 34, 6),
('2025-12-06', 12, 980, 72, 20, 3),
('2025-12-07', 21, 1650, 118, 41, 7),
('2025-12-08', 14, 1150, 85, 27, 4),
('2025-12-09', 16, 1300, 93, 30, 5),
('2025-12-10', 19, 1480, 108, 36, 6),
('2025-12-11', 11, 920, 66, 18, 3),
('2025-12-12', 24, 1820, 138, 47, 9),
('2025-12-13', 13, 1080, 78, 24, 4),
('2025-12-14', 17, 1350, 96, 33, 5),
('2025-12-15', 20, 1580, 115, 39, 7),
('2025-12-16', 15, 1220, 87, 28, 5),
('2025-12-17', 22, 1720, 128, 44, 8),
('2025-12-18', 18, 1450, 102, 35, 6);

-- 分类统计数据
INSERT INTO `pre_category_stats` (`cid`, `article_count`, `view_count`, `like_count`) VALUES
(1, 85, 45000, 3200),
(2, 72, 38000, 2800),
(3, 45, 22000, 1600),
(4, 58, 31000, 2100),
(5, 63, 35000, 2400),
(6, 38, 18000, 1200),
(7, 52, 28000, 1900),
(8, 67, 36000, 2500);


