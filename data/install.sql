-- ============================================
-- 新闻资讯管理系统 - 数据库设计
-- 南开大学 互联网数据库开发 课程设计
-- 创建日期: 2025-12-08
-- ============================================

CREATE DATABASE IF NOT EXISTS `news_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `news_system`;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- 1. 用户表 (pre_sys_user)
-- ----------------------------
DROP TABLE IF EXISTS `pre_sys_user`;
CREATE TABLE `pre_sys_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password_hash` varchar(255) NOT NULL COMMENT '密码哈希',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机号',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `role` tinyint(1) DEFAULT 0 COMMENT '角色: 0普通用户 1管理员',
  `status` tinyint(1) DEFAULT 1 COMMENT '状态: 0禁用 1正常',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

-- 插入测试数据
INSERT INTO `pre_sys_user` (`username`, `password_hash`, `email`, `role`, `status`) VALUES
('admin', '$2y$13$EjaPFBnZOQsHdGuHI.xvhuDp1fHpo8hKRSk6yshqa9c5EG8j0vQa.', 'admin@example.com', 1, 1),
('user1', '$2y$13$EjaPFBnZOQsHdGuHI.xvhuDp1fHpo8hKRSk6yshqa9c5EG8j0vQa.', 'user1@example.com', 0, 1),
('user2', '$2y$13$EjaPFBnZOQsHdGuHI.xvhuDp1fHpo8hKRSk6yshqa9c5EG8j0vQa.', 'user2@example.com', 0, 1);

-- ----------------------------
-- 2. 新闻分类表 (pre_news_category)
-- ----------------------------
DROP TABLE IF EXISTS `pre_news_category`;
CREATE TABLE `pre_news_category` (
  `cid` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `description` varchar(255) DEFAULT NULL COMMENT '分类描述',
  `icon` varchar(50) DEFAULT NULL COMMENT '分类图标',
  `sort_order` int(11) DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) DEFAULT 1 COMMENT '状态: 0禁用 1正常',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`cid`),
  KEY `idx_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='新闻分类表';

-- 插入测试数据
INSERT INTO `pre_news_category` (`name`, `description`, `sort_order`, `status`) VALUES
('国内新闻', '国内时事热点新闻', 1, 1),
('国际新闻', '国际时事热点新闻', 2, 1),
('科技资讯', 'AI、互联网、科技前沿', 3, 1),
('体育新闻', '体育赛事、运动健康', 4, 1),
('娱乐新闻', '明星、影视、综艺', 5, 1);

-- ----------------------------
-- 3. 新闻文章表 (pre_news_article)
-- ----------------------------
DROP TABLE IF EXISTS `pre_news_article`;
CREATE TABLE `pre_news_article` (
  `aid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `cid` int(11) NOT NULL COMMENT '分类ID',
  `uid` int(11) DEFAULT NULL COMMENT '作者ID',
  `title` varchar(255) NOT NULL COMMENT '文章标题',
  `summary` varchar(500) DEFAULT NULL COMMENT '文章摘要',
  `content` text COMMENT '文章内容',
  `cover_image` varchar(255) DEFAULT NULL COMMENT '封面图片',
  `source` varchar(100) DEFAULT NULL COMMENT '来源',
  `author` varchar(50) DEFAULT NULL COMMENT '作者名',
  `views` int(11) DEFAULT 0 COMMENT '浏览量',
  `likes` int(11) DEFAULT 0 COMMENT '点赞数',
  `is_top` tinyint(1) DEFAULT 0 COMMENT '是否置顶: 0否 1是',
  `is_hot` tinyint(1) DEFAULT 0 COMMENT '是否热门: 0否 1是',
  `status` tinyint(1) DEFAULT 1 COMMENT '状态: 0草稿 1发布 2下架',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`aid`),
  KEY `idx_cid` (`cid`),
  KEY `idx_uid` (`uid`),
  KEY `idx_status` (`status`),
  KEY `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='新闻文章表';

-- 插入2025年热点新闻测试数据
INSERT INTO `pre_news_article` (`cid`, `uid`, `title`, `summary`, `content`, `source`, `author`, `views`, `likes`, `is_top`, `is_hot`, `status`) VALUES
(1, 1, '2025年哈尔滨亚洲冬季运动会盛大开幕', '2025年2月，第九届亚洲冬季运动会在中国黑龙江省哈尔滨市隆重开幕，来自亚洲各国的运动员齐聚冰城。', '<p>2025年2月，第九届亚洲冬季运动会在中国黑龙江省哈尔滨市隆重开幕。本届亚冬会是中国第二次举办亚洲冬季运动会，共设11个大项、64个小项。</p><p>开幕式在哈尔滨体育中心举行，展现了冰雪文化与现代科技的完美融合。来自亚洲各国和地区的运动员将在冰雪赛场上展开激烈角逐。</p>', '新华社', '张三', 15680, 892, 1, 1, 1),
(3, 1, 'AI大模型技术突破：国产大模型性能再创新高', '2025年，中国人工智能大模型技术取得重大突破，多款国产大模型在国际评测中名列前茅。', '<p>2025年，中国人工智能领域迎来重大突破。多家科技企业发布的大语言模型在多项国际权威评测中取得优异成绩。</p><p>这些模型在自然语言理解、代码生成、多模态处理等方面展现出强大能力，标志着中国AI技术迈上新台阶。</p>', '科技日报', '李四', 23450, 1560, 1, 1, 1),
(1, 1, '西藏日喀则地震救援工作有序进行', '2025年1月7日，西藏自治区日喀则市发生地震，各方救援力量迅速响应。', '<p>2025年1月7日，西藏自治区日喀则市定日县发生地震。地震发生后，党中央、国务院高度重视，迅速启动应急响应机制。</p><p>解放军、武警部队、消防救援队伍等各方力量第一时间赶赴现场开展救援工作，全力保障受灾群众生命安全。</p>', '央视新闻', '王五', 18920, 756, 0, 1, 1),
(2, 1, '中美经贸关系新动向：双方加强沟通协调', '2025年，中美两国在经贸领域展开多轮对话，就共同关心的问题交换意见。', '<p>2025年以来，中美两国经贸团队保持密切沟通，就双边经贸关系中的重要议题进行了深入交流。</p><p>双方表示将继续本着相互尊重、平等互利的原则，推动中美经贸关系健康稳定发展。</p>', '经济日报', '赵六', 12350, 534, 0, 0, 1),
(4, 1, '中国体育健儿在国际赛场再创佳绩', '2025年，中国运动员在多项国际体育赛事中取得优异成绩，为国争光。', '<p>2025年，中国体育代表团在多项国际赛事中表现出色。在亚冬会、世锦赛等重要赛事中，中国运动员奋勇拼搏，取得了优异成绩。</p><p>这些成绩的取得，离不开运动员的刻苦训练和教练团队的科学指导。</p>', '体育周报', '钱七', 8760, 423, 0, 0, 1);

-- ----------------------------
-- 4. 评论表 (pre_news_comment)
-- ----------------------------
DROP TABLE IF EXISTS `pre_news_comment`;
CREATE TABLE `pre_news_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `aid` int(11) NOT NULL COMMENT '文章ID',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `content` text NOT NULL COMMENT '评论内容',
  `parent_id` int(11) DEFAULT 0 COMMENT '父评论ID(用于回复)',
  `likes` int(11) DEFAULT 0 COMMENT '点赞数',
  `status` tinyint(1) DEFAULT 1 COMMENT '状态: 0待审核 1已发布 2已删除',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_aid` (`aid`),
  KEY `idx_uid` (`uid`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='新闻评论表';

-- 插入测试数据
INSERT INTO `pre_news_comment` (`aid`, `uid`, `content`, `likes`, `status`) VALUES
(1, 2, '哈尔滨亚冬会太棒了！为中国运动员加油！', 56, 1),
(1, 3, '冰雪运动越来越受欢迎了，期待精彩比赛！', 34, 1),
(2, 2, 'AI技术发展真快，国产大模型加油！', 78, 1),
(2, 3, '希望能早日用上更智能的AI助手', 45, 1),
(3, 2, '向救援人员致敬！', 89, 1);

-- ----------------------------
-- 5. 系统配置表 (pre_sys_config) [可选]
-- ----------------------------
DROP TABLE IF EXISTS `pre_sys_config`;
CREATE TABLE `pre_sys_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(50) NOT NULL COMMENT '配置名称',
  `key` varchar(50) NOT NULL COMMENT '配置键',
  `value` text COMMENT '配置值',
  `description` varchar(255) DEFAULT NULL COMMENT '配置描述',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统配置表';

-- 插入默认配置
INSERT INTO `pre_sys_config` (`name`, `key`, `value`, `description`) VALUES
('网站名称', 'site_name', '新闻资讯管理系统', '网站标题'),
('网站描述', 'site_description', '南开大学互联网数据库课程设计项目', '网站描述'),
('版权信息', 'copyright', '© 2025 南开大学计算机学院', '页脚版权信息');

SET FOREIGN_KEY_CHECKS = 1;

-- ----------------------------
-- 6. 部门/团队表 (pre_team_department)
-- 用于前台“团队展示”
-- ----------------------------
DROP TABLE IF EXISTS `pre_team_department`;
CREATE TABLE `pre_team_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '部门名称',
  `description` varchar(255) DEFAULT NULL COMMENT '部门职能描述',
  `sort_order` int(11) DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='团队部门表';

-- ----------------------------
-- 7. 团队成员表 (pre_team_member)
-- 用于前台“个人信息展示”
-- ----------------------------
DROP TABLE IF EXISTS `pre_team_member`;
CREATE TABLE `pre_team_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_id` int(11) NOT NULL COMMENT '所属部门ID',
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `position` varchar(100) DEFAULT NULL COMMENT '职位',
  `avatar` varchar(255) DEFAULT NULL COMMENT '照片路径',
  `bio` text COMMENT '个人简介',
  `email` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1在职 0离职',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_dept` (`dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='团队成员表';

-- ----------------------------
-- 8. 留言板表 (pre_guestbook)
-- 用于前台“留言”功能
-- ----------------------------
DROP TABLE IF EXISTS `pre_guestbook`;
CREATE TABLE `pre_guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) NOT NULL COMMENT '留言者昵称',
  `email` varchar(100) DEFAULT NULL,
  `content` text NOT NULL COMMENT '留言内容',
  `ip_address` varchar(50) DEFAULT NULL COMMENT '留言IP',
  `is_read` tinyint(1) DEFAULT 0 COMMENT '管理员是否已读',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='留言板表';

-- ----------------------------
-- 9. 访问日志表 (pre_visit_log)
-- 用于后台“动态图形展示”（统计访问量）
-- ----------------------------
DROP TABLE IF EXISTS `pre_visit_log`;
CREATE TABLE `pre_visit_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_url` varchar(255) NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `visit_time` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_time` (`visit_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='访问日志表';

-- ----------------------------
-- 10. 标签表 (pre_tag)
-- 丰富新闻功能
-- ----------------------------
DROP TABLE IF EXISTS `pre_tag`;
CREATE TABLE `pre_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '标签名',
  `frequency` int(11) DEFAULT 0 COMMENT '使用频率',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='新闻标签表';

-- ----------------------------
-- 11. 文章-标签关联表 (pre_article_tag)
-- ----------------------------
DROP TABLE IF EXISTS `pre_article_tag`;
CREATE TABLE `pre_article_tag` (
  `aid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  PRIMARY KEY (`aid`, `tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章标签关联表';

-- ----------------------------
-- 12. 友情链接表 (pre_link)
-- ----------------------------
DROP TABLE IF EXISTS `pre_link`;
CREATE TABLE `pre_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='友情链接表';


-- ============================================
-- 数据库设计完成
-- 共5张表：用户、分类、文章、评论、配置
-- ============================================


