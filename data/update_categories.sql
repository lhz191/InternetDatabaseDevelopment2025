-- 更新分类为抗战主题相关
-- @author 刘浩泽 (2212478)
-- @date 2025-12-18

USE news_system;

-- 清空原有分类
DELETE FROM pre_news_category;

-- 插入抗战主题分类
INSERT INTO pre_news_category (cid, name, description, sort_order, status, created_at) VALUES
(1, '重大战役', '抗日战争中的重要战役回顾', 1, 1, NOW()),
(2, '英雄人物', '抗战英雄人物事迹与故事', 2, 1, NOW()),
(3, '历史遗址', '抗战历史遗址与纪念馆介绍', 3, 1, NOW()),
(4, '抗战文化', '抗战时期的文化艺术作品', 4, 1, NOW()),
(5, '纪念活动', '各地抗战胜利纪念活动报道', 5, 1, NOW()),
(6, '历史档案', '珍贵历史档案与文献资料', 6, 1, NOW()),
(7, '老兵故事', '抗战老兵口述历史与回忆', 7, 1, NOW()),
(8, '国际视角', '世界反法西斯战争相关内容', 8, 1, NOW());

-- 更新现有文章的分类（随机分配到新分类）
UPDATE pre_news_article SET cid = FLOOR(1 + RAND() * 8) WHERE 1=1;
