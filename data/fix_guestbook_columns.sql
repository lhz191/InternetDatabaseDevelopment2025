-- 修复留言板表字段，使其与模型匹配
SET NAMES utf8mb4;
USE news_system;

-- 添加缺失的列
ALTER TABLE `pre_guestbook` 
    ADD COLUMN IF NOT EXISTS `nickname` varchar(50) DEFAULT NULL COMMENT '留言者昵称' AFTER `id`,
    ADD COLUMN IF NOT EXISTS `ip_address` varchar(50) DEFAULT NULL COMMENT '留言IP' AFTER `content`,
    ADD COLUMN IF NOT EXISTS `is_read` tinyint(1) DEFAULT 0 COMMENT '管理员是否已读' AFTER `ip_address`;

-- 如果有 name 列，将数据迁移到 nickname
UPDATE `pre_guestbook` SET `nickname` = `name` WHERE `nickname` IS NULL AND `name` IS NOT NULL;

-- 如果有 status 列，将数据迁移到 is_read
UPDATE `pre_guestbook` SET `is_read` = `status` WHERE `is_read` = 0 AND `status` IS NOT NULL;

