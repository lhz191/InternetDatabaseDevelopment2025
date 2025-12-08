# 新闻爬虫模块

## 作者
刘浩泽 (2212478)

## 功能说明
本模块用于从新闻网站爬取数据，并生成SQL插入语句导入到数据库。

## 使用方法

### 1. 安装依赖
```bash
pip install -r requirements.txt
```

### 2. 运行爬虫
```bash
python news_crawler.py
```

### 3. 导入数据
```bash
mysql -u root news_system < crawled_news.sql
```

## 数据来源
- 新浪新闻
- 今日头条热点
- 示例数据（当网络不可用时）

## 注意事项
- 爬虫仅用于学习目的
- 请遵守网站robots协议
- 数据仅供课程作业使用

