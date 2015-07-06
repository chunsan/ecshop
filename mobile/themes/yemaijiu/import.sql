
--
-- 表的结构 `ecs_touch_nav`
--

DROP TABLE IF EXISTS `ecs_touch_nav`;

CREATE TABLE IF NOT EXISTS `ecs_touch_nav` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `ctype` varchar(10) DEFAULT NULL,
  `cid` smallint(5) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `ifshow` tinyint(1) NOT NULL,
  `vieworder` tinyint(1) NOT NULL,
  `opennew` tinyint(1) NOT NULL,
  `url` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `ifshow` (`ifshow`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ecs_touch_nav`
--

INSERT INTO `ecs_touch_nav` (`id`, `ctype`, `cid`, `name`, `ifshow`, `vieworder`, `opennew`, `url`, `pic`, `type`) VALUES
(1, '', 0, '全部分类', 1, 0, 0, 'index.php?c=category&amp;a=all', 'themes/yemaijiu/images/nav/nav_0.png', 'middle'),
(2, '', 0, '我的订单', 1, 0, 0, 'index.php?m=default&amp;c=user&amp;a=order_list', 'themes/yemaijiu/images/nav/nav_1.png', 'middle'),
(3, '', 0, '最新团购', 1, 0, 0, 'index.php?m=default&amp;c=groupbuy', 'themes/yemaijiu/images/nav/nav_2.png', 'middle'),
(4, '', 0, '促销活动', 1, 0, 0, 'index.php?m=default&amp;c=activity', 'themes/yemaijiu/images/nav/nav_3.png', 'middle'),
(5, '', 0, '热门搜索', 1, 0, 0, 'javascript:openSearch();', 'themes/yemaijiu/images/nav/nav_4.png', 'middle'),
(6, '', 0, '品牌街', 1, 0, 0, 'index.php?m=default&amp;c=brand', 'themes/yemaijiu/images/nav/nav_5.png', 'middle'),
(7, '', 0, '个人中心', 1, 0, 0, 'index.php?m=default&amp;c=user', 'themes/yemaijiu/images/nav/nav_6.png', 'middle'),
(8, '', 0, '购物车', 1, 0, 0, 'index.php?m=default&amp;c=flow&amp;a=cart', 'themes/yemaijiu/images/nav/nav_7.png', 'middle');
