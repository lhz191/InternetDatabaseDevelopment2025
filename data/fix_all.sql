-- 修复分类和创建缺失的表
-- @author 刘浩泽 (2212478)

SET NAMES utf8mb4;
USE news_system;

-- 1. 修复分类数据
DELETE FROM pre_news_category;

INSERT INTO pre_news_category (cid, name, description, sort_order, status, created_at) VALUES
(1, '重大战役', '抗日战争中的重要战役回顾', 1, 1, NOW()),
(2, '英雄人物', '抗战英雄人物事迹与故事', 2, 1, NOW()),
(3, '历史遗址', '抗战历史遗址与纪念馆介绍', 3, 1, NOW()),
(4, '抗战文化', '抗战时期的文化艺术作品', 4, 1, NOW()),
(5, '纪念活动', '各地抗战胜利纪念活动报道', 5, 1, NOW()),
(6, '历史档案', '珍贵历史档案与文献资料', 6, 1, NOW()),
(7, '老兵故事', '抗战老兵口述历史与回忆', 7, 1, NOW()),
(8, '国际视角', '世界反法西斯战争相关内容', 8, 1, NOW());

-- 更新文章分类
UPDATE pre_news_article SET cid = FLOOR(1 + RAND() * 8);

-- 2. 创建团队部门表（如果不存在）
CREATE TABLE IF NOT EXISTS `pre_team_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '部门名称',
  `description` text COMMENT '部门描述',
  `sort_order` int(11) DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) DEFAULT 1 COMMENT '状态',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='团队部门表';

-- 3. 创建团队成员表（如果不存在）
CREATE TABLE IF NOT EXISTS `pre_team_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL COMMENT '部门ID',
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `position` varchar(100) COMMENT '职位',
  `avatar` varchar(255) COMMENT '头像',
  `description` text COMMENT '简介',
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='团队成员表';

-- 4. 创建留言板表（如果不存在）
CREATE TABLE IF NOT EXISTS `pre_guest_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '留言者姓名',
  `email` varchar(100) COMMENT '邮箱',
  `content` text NOT NULL COMMENT '留言内容',
  `status` tinyint(1) DEFAULT 1 COMMENT '状态',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='留言板表';

-- 插入示例团队部门数据
INSERT IGNORE INTO `pre_team_department` (`id`, `name`, `description`, `sort_order`, `status`) VALUES
(1, '开发组', '负责系统开发与维护', 1, 1),
(2, '设计组', '负责UI设计与美化', 2, 1);

-- 插入示例团队成员数据
INSERT IGNORE INTO `pre_team_member` (`id`, `department_id`, `name`, `position`, `description`, `sort_order`, `status`) VALUES
(1, 1, '彭浩然', '开发', '负责用户管理模块', 1, 1),
(2, 1, '刘浩泽', '开发', '负责首页和文章管理', 2, 1),
(3, 1, '董珺', '开发', '负责分类管理模块', 3, 1),
(4, 1, '童汉鑫', '组长', '负责评论管理模块', 4, 1);


