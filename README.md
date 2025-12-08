# 📰 新闻资讯管理系统

南开大学 计算机学院 《互联网数据库开发》课程设计项目

![Yii2](https://img.shields.io/badge/Yii2-2.0.32-blue)
![PHP](https://img.shields.io/badge/PHP-8.x-purple)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange)
![License](https://img.shields.io/badge/License-MIT-green)

## 📋 项目介绍

本项目是一个功能完整的新闻资讯管理系统，采用 Yii2 框架开发，包含：

- **前台展示网站**：新闻浏览、分类筛选、文章详情、评论展示
- **后台管理系统**：用户管理、分类管理、文章管理、评论管理

## 🖥️ 在线预览

| 模块 | 地址 |
|-----|------|
| 前台 | http://localhost/advanced/frontend/web/ |
| 后台 | http://localhost/advanced/backend/web/ |

**后台登录账号：**
- 用户名：`admin`
- 密码：`admin123`

## 📁 项目结构

```
advanced/
├── backend/                 # 后台管理系统
│   ├── controllers/         # 控制器
│   │   ├── ArticleController.php
│   │   ├── CategoryController.php
│   │   ├── CommentController.php
│   │   └── UserController.php
│   ├── models/              # 搜索模型
│   └── views/               # 视图文件
├── frontend/                # 前台展示网站
│   ├── controllers/         # 控制器
│   │   └── SiteController.php
│   └── views/               # 视图文件
├── common/                  # 公共代码
│   └── models/              # 数据模型
│       ├── PreSysUser.php
│       ├── PreNewsCategory.php
│       ├── PreNewsArticle.php
│       └── PreNewsComment.php
└── data/
    ├── install.sql          # 数据库文件
    ├── team/                # 团队作业
    └── personal/            # 个人作业
```

## 🗄️ 数据库设计

| 表名 | 说明 |
|-----|------|
| `pre_sys_user` | 用户表 |
| `pre_news_category` | 新闻分类表 |
| `pre_news_article` | 新闻文章表 |
| `pre_news_comment` | 评论表 |
| `pre_sys_config` | 系统配置表 |
| `user` | Yii2认证用户表 |

## 🚀 部署指南

### 环境要求

- PHP >= 7.4
- MySQL >= 5.7
- Apache/Nginx
- Composer (可选)

### 安装步骤

1. **安装 XAMPP**
   ```bash
   # 下载并安装 XAMPP
   # 启动 Apache 和 MySQL 服务
   ```

2. **解压项目到 htdocs**
   ```bash
   # 将项目解压到 C:\xampp\htdocs\advanced
   ```

3. **初始化项目**
   ```bash
   cd C:\xampp\htdocs\advanced
   init.bat
   # 选择 0 (Development)
   ```

4. **创建数据库**
   - 打开 phpMyAdmin: http://localhost/phpmyadmin
   - 创建数据库: `news_system`
   - 导入 `data/install.sql`

5. **配置数据库连接**
   - 编辑 `common/config/main-local.php`
   - 修改数据库名称为 `news_system`

6. **执行迁移**
   ```bash
   php yii migrate
   ```

7. **访问网站**
   - 前台: http://localhost/advanced/frontend/web/
   - 后台: http://localhost/advanced/backend/web/

## 👥 团队分工

| 成员 | 模块 | Model | Controller | View |
|-----|------|-------|------------|------|
| 组员A | 用户管理 | PreSysUser | UserController | user/* |
| 组员B | 分类管理 | PreNewsCategory | CategoryController | category/* |
| 刘浩泽 (2212478) | 首页+文章管理 | PreNewsArticle | ArticleController, SiteController | article/*, site/index,view,news |
| 组员D | 评论管理 | PreNewsComment | CommentController | comment/* |

## 📄 作业文档

所有团队作业文档位于 `data/team/` 目录：

- 📋 需求文档
- 📐 设计文档
- 📝 实现文档
- 📖 用户手册
- 🚀 部署文档
- 📊 项目展示PPT
- 🎥 录屏讲解

## 🛠️ 技术栈

- **后端框架**: Yii2 Advanced
- **数据库**: MySQL 8.0
- **前端**: HTML5, CSS3, JavaScript
- **UI框架**: Bootstrap, Font Awesome
- **开发工具**: VS Code, XAMPP, Git

## 📝 License

MIT License

## 🙏 致谢

- 南开大学计算机学院
- 乜鹏老师
- Yii2 框架团队

---

© 2025 南开大学 互联网数据库开发 课程设计
