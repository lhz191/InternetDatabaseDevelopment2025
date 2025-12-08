#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
新闻爬虫脚本
@author 刘浩泽 (2212478)
@date 2025-12-08
@description 从新闻网站爬取新闻数据并生成SQL插入语句
"""

import requests
from bs4 import BeautifulSoup
import json
import re
from datetime import datetime
import time
import random

class NewsCrawler:
    """新闻爬虫类"""
    
    def __init__(self):
        self.headers = {
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        }
        self.news_list = []
        
    def crawl_sina_news(self):
        """爬取新浪新闻 - 多页爬取"""
        print("正在爬取新浪新闻...")
        try:
            # 新浪新闻API - 爬取多页
            url = "https://feed.mix.sina.com.cn/api/roll/get"
            
            # 不同频道ID
            channels = [
                ('153', '2509'),  # 综合
                ('153', '2510'),  # 国内
                ('153', '2511'),  # 国际
                ('153', '2669'),  # 科技
                ('153', '2512'),  # 财经
                ('153', '2513'),  # 体育
                ('153', '2514'),  # 娱乐
            ]
            
            for pageid, lid in channels:
                for page in range(1, 11):  # 每个频道爬10页
                    params = {
                        'pageid': pageid,
                        'lid': lid,
                        'k': '',
                        'num': '50',
                        'page': str(page)
                    }
                    try:
                        response = requests.get(url, params=params, headers=self.headers, timeout=10)
                        data = response.json()
                        
                        if data.get('result') and data['result'].get('data'):
                            for item in data['result']['data']:
                                news = {
                                    'title': item.get('title', ''),
                                    'summary': item.get('intro', '')[:200] if item.get('intro') else '',
                                    'content': item.get('intro', ''),
                                    'source': '新浪新闻',
                                    'author': item.get('author', '新浪编辑'),
                                    'url': item.get('url', ''),
                                    'created_at': item.get('ctime', datetime.now().strftime('%Y-%m-%d %H:%M:%S'))
                                }
                                if news['title'] and len(self.news_list) < 500:
                                    self.news_list.append(news)
                        
                        if len(self.news_list) >= 500:
                            break
                        time.sleep(0.2)  # 防止请求过快
                    except:
                        continue
                        
                if len(self.news_list) >= 500:
                    break
                    
            print(f"成功爬取 {len(self.news_list)} 条新闻")
        except Exception as e:
            print(f"爬取新浪新闻失败: {e}")
    
    def crawl_toutiao_hot(self):
        """爬取今日头条热点"""
        print("正在爬取今日头条热点...")
        try:
            url = "https://www.toutiao.com/hot-event/hot-board/"
            params = {'origin': 'toutiao_pc'}
            response = requests.get(url, params=params, headers=self.headers, timeout=10)
            data = response.json()
            
            if data.get('data'):
                for item in data['data'][:15]:
                    news = {
                        'title': item.get('Title', ''),
                        'summary': item.get('Title', ''),
                        'content': f"<p>{item.get('Title', '')}</p>",
                        'source': '今日头条',
                        'author': '头条编辑',
                        'url': item.get('Url', ''),
                        'created_at': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
                    }
                    if news['title']:
                        self.news_list.append(news)
                        
            print(f"当前共 {len(self.news_list)} 条新闻")
        except Exception as e:
            print(f"爬取头条热点失败: {e}")

    def generate_sample_news(self):
        """生成示例新闻数据（当爬虫无法访问时使用）"""
        print("生成示例新闻数据...")
        
        sample_news = [
            {
                'cid': 2, 'title': '人工智能技术突破：新算法效率提升10倍',
                'summary': '研究团队开发出全新的深度学习算法，在图像识别任务中效率提升显著。',
                'content': '<p>近日，某知名高校研究团队宣布在人工智能领域取得重大突破。</p><p>该团队开发的新型深度学习算法，通过优化网络结构和训练策略，在图像识别、自然语言处理等任务中，效率比传统方法提升了10倍以上。</p><p>这一突破有望推动AI技术在更多场景的应用。</p>',
                'source': '科技日报', 'author': '科技编辑'
            },
            {
                'cid': 2, 'title': '5G-A商用加速 运营商发布最新网络升级计划',
                'summary': '三大运营商宣布将在2025年底前完成主要城市的5G-A网络覆盖。',
                'content': '<p>中国移动、中国电信、中国联通联合宣布5G-A网络升级计划。</p><p>根据计划，到2025年底，北京、上海、深圳等一线城市将实现5G-A网络全覆盖，为用户提供更快速、更稳定的网络体验。</p><p>5G-A网络理论峰值速率可达10Gbps，时延低至1ms。</p>',
                'source': '通信世界', 'author': '通信记者'
            },
            {
                'cid': 3, 'title': '新能源汽车销量创新高 渗透率突破45%',
                'summary': '11月新能源汽车销量突破120万辆，市场渗透率首次超过45%。',
                'content': '<p>中国汽车工业协会发布最新数据，11月份新能源汽车销量达到123.5万辆，同比增长35%。</p><p>市场渗透率首次突破45%，标志着新能源汽车进入快速普及阶段。</p><p>其中，比亚迪、特斯拉、蔚来等品牌表现抢眼。</p>',
                'source': '汽车之家', 'author': '汽车编辑'
            },
            {
                'cid': 3, 'title': '房地产市场回暖 一线城市成交量环比上涨',
                'summary': '在政策利好推动下，一线城市房地产市场出现回暖迹象。',
                'content': '<p>据统计，11月份一线城市新房成交面积环比上涨18%，二手房成交量环比上涨25%。</p><p>北京、上海、深圳等城市房价止跌企稳，市场信心有所恢复。</p><p>业内人士分析，一系列房地产支持政策正在发挥效果。</p>',
                'source': '财经网', 'author': '房产编辑'
            },
            {
                'cid': 1, 'title': '全国文明城市复查结果公布 多地再次入选',
                'summary': '中央文明办公布新一轮全国文明城市复查结果，展现城市治理成效。',
                'content': '<p>中央文明办近日公布了全国文明城市复查结果。</p><p>此次复查覆盖全国300多个城市，综合考察城市基础设施、公共服务、环境卫生、市民素质等多个方面。</p><p>结果显示，绝大多数城市保持了文明城市创建成果，城市治理水平持续提升。</p>',
                'source': '人民日报', 'author': '本报记者'
            },
            {
                'cid': 4, 'title': 'CBA常规赛激战正酣 辽宁队保持领先',
                'summary': 'CBA联赛进入白热化阶段，辽宁队以16胜2负的战绩领跑积分榜。',
                'content': '<p>CBA2025-2026赛季常规赛战至第18轮，各队竞争激烈。</p><p>卫冕冠军辽宁队表现出色，以16胜2负的战绩位居积分榜首位。广东队、浙江队紧随其后。</p><p>本赛季CBA联赛观赏性大幅提升，场均上座率创历史新高。</p>',
                'source': 'CBA官网', 'author': '篮球记者'
            },
            {
                'cid': 5, 'title': '国产电影票房突破600亿 创年度新纪录',
                'summary': '2025年国产电影累计票房突破600亿元，多部影片口碑票房双丰收。',
                'content': '<p>据国家电影局统计，2025年国产电影累计票房已突破600亿元，创造年度新纪录。</p><p>其中，《流浪地球3》《熊出没》《唐探4》等影片票房表现亮眼。</p><p>国产电影质量持续提升，观众满意度创近五年新高。</p>',
                'source': '猫眼电影', 'author': '娱乐编辑'
            },
            {
                'cid': 6, 'title': '教育部推进义务教育优质均衡发展',
                'summary': '教育部发布新举措，推动义务教育优质均衡发展，缩小城乡差距。',
                'content': '<p>教育部近日印发《关于推进义务教育优质均衡发展的实施意见》。</p><p>意见提出，要加大农村学校建设投入，提升师资水平，推进教育数字化，确保城乡学生享有同等优质教育资源。</p><p>到2027年，力争80%的县区达到义务教育优质均衡标准。</p>',
                'source': '中国教育报', 'author': '教育记者'
            },
            {
                'cid': 7, 'title': '国家卫健委：冬季呼吸道疾病防控指南发布',
                'summary': '针对冬季呼吸道疾病高发，国家卫健委发布最新防控指南。',
                'content': '<p>国家卫生健康委员会发布《冬季呼吸道疾病防控指南》。</p><p>指南建议：保持室内通风、勤洗手、戴口罩、及时接种疫苗、均衡饮食、规律作息。</p><p>特别提醒老年人和儿童做好防护，出现发热咳嗽症状及时就医。</p>',
                'source': '健康中国', 'author': '健康编辑'
            },
            {
                'cid': 8, 'title': '中欧班列开行突破10万列 畅通国际物流',
                'summary': '中欧班列累计开行突破10万列，成为国际物流的重要通道。',
                'content': '<p>据国家铁路集团消息，中欧班列累计开行突破10万列，通达欧洲25个国家217个城市。</p><p>中欧班列运输时间比海运缩短一半以上，成本仅为空运的五分之一，已成为国际贸易的重要物流选择。</p><p>今年以来，中欧班列运送货物超过100万标箱。</p>',
                'source': '新华网', 'author': '国际记者'
            }
        ]
        
        for news in sample_news:
            news['created_at'] = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            self.news_list.append(news)
            
        print(f"生成了 {len(sample_news)} 条示例新闻")

    def generate_sql(self, output_file='crawled_news.sql'):
        """生成SQL插入语句"""
        print(f"正在生成SQL文件: {output_file}")
        
        sql_content = """-- =====================================================
-- 爬虫获取的新闻数据
-- @author 刘浩泽 (2212478)
-- @date {date}
-- @description 通过爬虫脚本自动获取的新闻数据
-- =====================================================

USE `news_system`;

""".format(date=datetime.now().strftime('%Y-%m-%d'))

        for i, news in enumerate(self.news_list):
            cid = news.get('cid', random.randint(1, 8))
            title = news['title'].replace("'", "''")
            summary = news.get('summary', '')[:200].replace("'", "''")
            content = news.get('content', f"<p>{news['title']}</p>").replace("'", "''")
            source = news.get('source', '网络').replace("'", "''")
            author = news.get('author', '编辑').replace("'", "''")
            views = random.randint(1000, 50000)
            likes = random.randint(50, 2000)
            is_top = 1 if i < 3 else 0
            is_hot = 1 if random.random() > 0.5 else 0
            created_at = news.get('created_at', datetime.now().strftime('%Y-%m-%d %H:%M:%S'))
            
            sql = f"""INSERT INTO `pre_news_article` (`cid`, `uid`, `title`, `summary`, `content`, `source`, `author`, `views`, `likes`, `is_top`, `is_hot`, `status`, `created_at`, `updated_at`) VALUES
({cid}, 1, '{title}', '{summary}', '{content}', '{source}', '{author}', {views}, {likes}, {is_top}, {is_hot}, 1, '{created_at}', NOW());

"""
            sql_content += sql
        
        with open(output_file, 'w', encoding='utf-8-sig') as f:
            f.write(sql_content)
            
        print(f"SQL文件生成完成，共 {len(self.news_list)} 条记录")
        return output_file

    def run(self):
        """运行爬虫"""
        print("=" * 50)
        print("新闻爬虫开始运行")
        print("=" * 50)
        
        # 尝试爬取在线新闻
        self.crawl_sina_news()
        time.sleep(1)
        self.crawl_toutiao_hot()
        
        # 如果爬取失败，使用示例数据
        if len(self.news_list) < 5:
            print("\n在线爬取数据较少，补充示例数据...")
            self.generate_sample_news()
        
        # 生成SQL
        self.generate_sql()
        
        print("\n" + "=" * 50)
        print("爬虫运行完成！")
        print(f"共获取 {len(self.news_list)} 条新闻")
        print("请执行 crawled_news.sql 导入数据")
        print("=" * 50)


if __name__ == '__main__':
    crawler = NewsCrawler()
    crawler.run()

