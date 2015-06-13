-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2015 年 06 月 13 日 04:35
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `testguest`
-- 
CREATE DATABASE `testguest` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `testguest`;

-- --------------------------------------------------------

-- 
-- 表的结构 `tg_article`
-- 

CREATE TABLE `tg_article` (
  `tg_id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '//ID',
  `tg_reid` mediumint(8) unsigned NOT NULL default '0' COMMENT '//主题ID',
  `tg_username` varchar(20) NOT NULL COMMENT '//发帖人',
  `tg_type` tinyint(2) unsigned NOT NULL COMMENT '//发帖类型',
  `tg_title` varchar(40) NOT NULL COMMENT '//帖子标题',
  `tg_content` text NOT NULL COMMENT '//帖子内容',
  `tg_readcount` tinyint(5) unsigned NOT NULL COMMENT '//读取次数',
  `tg_commentcount` tinyint(5) unsigned NOT NULL COMMENT '//评论次数',
  `tg_nice` tinyint(1) NOT NULL default '0' COMMENT '//精华贴',
  `tg_last_modify_time` datetime NOT NULL COMMENT '//最后修改时间',
  `tg_time` datetime NOT NULL COMMENT '//时间',
  PRIMARY KEY  (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=335 ;

-- 
-- 导出表中的数据 `tg_article`
-- 

INSERT INTO `tg_article` VALUES (200, 0, '炎日', 1, '我的第一个帖子', '1、HTML+CSS静态网页     JavaScript     交互\r\n      JavaScript一种直译式脚本语言，是一种动态类型、弱类型、基于原型的语言，内置支持类型。它的解释器被称为JavaScript引擎，为浏览器的一部分，广泛用于客户端的脚本语言，最早是在HTML（标准通用标记语言下的一个应用）网页上使用，用来给HTML网页增加动态功能。\r\n2、第一个JS特效——鼠标提示框\r\n     分析效果实现原理\r\n          ---样式：Div的display\r\n          ---事件：onmouseover、onmouseout\r\n          ---动手编写此效果\r\n     特效基础\r\n          ---事件驱动：onmouseover\r\n          ---元素属性操作：obj.style.[......]\r\n          ---特效实现原理概括：响应用户操作，对页面元素（标签）进行某种修改\r\n3、兼容性问题doucment.getElementById\r\n     火狐浏览器和谷歌浏览器下不能直接拿元素名来使用，这样做是不兼容的\r\n     例如，想使用div1时，应该写成doucment.getElementById(''div1'')\r\n4、编写JS的流程\r\n     ---布局：HTML+CSS\r\n     ---属性：确定修改哪些属性\r\n     ---事件：确定用户做哪些操作（产品设计）\r\n     ---编写JS：在事件中，用JS来修改页面元素的样式\r\n5、函数\r\n<script>\r\n    function funName()\r\n    {\r\n        \r\n    }\r\n</script>\r\n 6、重用\r\n     变量     var oDiv=doucment.getElementById(''div1'');\r\n7、if语句\r\n8、JS编写元素，在HTML里怎么写在JS里就怎么写，但有一个例外，HTML里的class在JS里用className替换。\r\n9、函数传参\r\n      操作属性的第二种方式（采用数组形式）：在修改的属性不固定时使用。\r\n10、style加样式和取样式里的属性都是从行间取得的\r\n     样式优先级：* < 标签 < class < ID < 行间\r\nstyle与className：元素.style.属性=xxx 是修改行间样式；在此之后修改className不会有效果\r\n     对同一个元素只采用className或style其中一种，两种一起用可能会混淆，而且容易 出错，强烈建议不用。\r\n11、window.onload     在页面加载完成后再执行JS代码，否则容易出错。\r\n     行为（JS）、样式（CSS）、结构（HTML）三者分离：为达到该目标，1、不要加行间样式；2、不要加行间JS事件。\r\n12、getElementsByTagName：获取一组元素的标签名\r\n     var aDiv=document.getElementsByTagName(''div'');\r\n13、注意在JS里面一次只能对一个元素设置样式，而不能对一组元素设置样式\r\n14、选项卡的实现\r\n<!DOCTYPE html>\r\n<html>\r\n<head lang="en">\r\n    <meta charset="UTF-8">\r\n    <title>无标题文档</title>\r\n    <style>\r\n        #div1 .active{background: yellow }\r\n        #div1 div {\r\n            width:200px;\r\n            height: 200px;\r\n            background: #CCC;\r\n            border: 1px solid #999;\r\n            display: none;\r\n        }\r\n    </style>\r\n    <script>\r\n        window.onload=function()\r\n        {\r\n            var oDiv=document.getElementById(''div1'');\r\n            var aBtn=oDiv.getElementsByTagName(''input'');\r\n            var aDiv=oDiv.getElementsByTagName(''div'');\r\n            for(var i=0;i<aBtn.length;i++)\r\n            {\r\n                aBtn[i].index=i;\r\n                aBtn[i].onclick=function()\r\n                {\r\n                    for(var i=0;i<aBtn.length;i++)\r\n                    {\r\n                        aBtn[i].className='''';\r\n                        aDiv[i].style.display=''none'';\r\n                    }\r\n                    this.className=''active'';\r\n                    aDiv[this.index].style.display=''block'';\r\n                };\r\n            }\r\n        }\r\n    </script>\r\n</head>\r\n<body>\r\n    <div id="div1">\r\n        <input class="active" type="button" value="教育" />\r\n        <input type="button" value="培训" />\r\n        <input type="button" value="招生" />\r\n        <input type="button" value="出国" />\r\n        <div style="display: block;">1111</div>\r\n        <div>2222</div>\r\n        <div>3333</div>\r\n        <div>4444</div>\r\n    </div>\r\n</body>\r\n</html>\r\n15、JS简易日历的实现\r\n     innerHTML', 11, 0, 0, '0000-00-00 00:00:00', '2015-06-06 19:15:41');
INSERT INTO `tg_article` VALUES (300, 0, '娜美', 1, 'TestGuest5.2发帖测试功能', '[size=20]字体大小[/size]\r\n[b]粗体[/b]\r\n[i]斜体[/i]\r\n[u]下划线[/u]\r\n[s]删除线[/s]\r\n[color=#f00]红色[/color]\r\n[url]http://www.baidu.com[/url][email]y.w.yang@163.com[/email]', 36, 4, 0, '0000-00-00 00:00:00', '2015-06-06 21:33:20');
INSERT INTO `tg_article` VALUES (2, 0, '娜美', 1, 'TestGuest5.2发帖测试功能！', '[size=20]字体大小[/size]\r\n\r\n[b]粗体[/b]\r\n\r\n[i]倾斜[/i]\r\n\r\n[u]下划线[/u]\r\n\r\n[s]删除线[/s]\r\n\r\n[color=#800080]颜色[/color]\r\n\r\n[url]http://www.baidu.com[/url]\r\n\r\n[email]yc60.com@gmail.com[/email]\r\n\r\n[img]qpic/1/25.gif[/img]\r\n\r\n[flash]http://player.youku.com/player.php/sid/XMTc1NzQxMjQ0/v.swf[/flash]', 89, 0, 0, '0000-00-00 00:00:00', '2010-09-23 14:49:10');
INSERT INTO `tg_article` VALUES (3, 0, '娜美', 10, 'mm纯情升级即将开启 v1.1版内容大曝光', '阳光明媚的3月，[color=#f00]《美眉梦工场》[/color]（mm）纯情内测盛大开启，为广大玩家呈上精彩的v1.0版本，正是这一版本的mm，陪我们一起度过了美好的人间四月天！如今，春暖花开的五月已近在眼前，而mm也将更加出色、更加完美，——因为，主打“学院战争”主题的v1.1版本，马上就要横空出世了，mm纯情升级即将开启！ \r\n\r\n[img]monipic/xw082.jpg[/img]\r\n\r\n上周，神秘人士“黄金岁月”在mm官方论坛上，针对即将推出的v1.1版本内容进行了抢先“爆料”（[url]http://bbs.mm.kunlun.com[/url]），短短几天时间，这个贴子的关注度便飞速飙升，更有许多玩家积极地参与到热烈的讨论当中！当然，也有部分玩家，对此始终抱着半信半疑的谨慎态度，毕竟，mm 的v1.0版本才刚刚推出不到一个月，这么短的时间，便马上又要追加内容如此丰富的崭新版本了，这种研发速度确实令人难以置信！\r\n\r\n[img]monipic/xw083.jpg[/img]\r\n\r\n[img]qpic/1/1.gif[/img][img]qpic/1/2.gif[/img][img]qpic/1/3.gif[/img][img]qpic/2/1.gif[/img][img]qpic/3/2.gif[/img][img]qpic/3/6.gif[/img][img]qpic/3/7.gif[/img]', 5, 0, 0, '0000-00-00 00:00:00', '2010-09-23 15:12:16');
INSERT INTO `tg_article` VALUES (4, 0, '小樱', 8, '花花世界寻友记《开心》新人招募计划', '还在羡慕别人能在花花世界里一呼百应？为什么不主动呼朋唤友，把你的同学、好友、同事……统统拉进《开心》（[url]http://kx.91.com[/url]）呢！最火爆的新人集结，热闹非凡的玩乐基地，赶快让《开心》成为你们聚会的最佳地点，同享花花世界的精彩吧！\r\n\r\n[img]monipic/xw065.jpg[/img]\r\n\r\n数码相机、psp、百元灵石……这些大奖如何拥有？呼朋引伴就能夺得！在活动期间，老玩家通过建立推广链接邀请好友入驻《开心》，拉拢的好友数量越多，将有机会登上金牌推荐人排行榜，每周上榜前100名，就有机会收获200元的灵石；同时，只要有2位推荐好友人物等级达到30级、60级时，你即可参加抽奖，抱走ipod shufflf、开心时装、星之祝福等奖励。 \r\n\r\n[img]monipic/xw066.jpg[/img]\r\n\r\n不但送你开心大礼，好友入驻花花世界，同样也享不完的惊喜。新玩家通过链接注册91帐号、创建游戏人物，即刻获赠价值888元公测新手礼包；同时，修行等级达到30级、60级时，同样能够参加抽奖，抽取经验礼包、星之祝福、月之祝福等奖励。此外，新玩家也可以生成链接邀请好友入驻，同享开心大礼！', 4, 1, 0, '0000-00-00 00:00:00', '2010-09-23 19:45:46');
INSERT INTO `tg_article` VALUES (5, 0, '妮可罗宾', 15, '完美国际新副本即将推出 背景揭秘', '完美大陆作为人、羽、妖三大种族的栖息繁衍之地，以宽广辽阔的版图，抚育了无数战斗精英和游戏高手。《完美世界国际版》资料片“精灵战歌”的正式推出，更为六大职业的玩家带来了福音，因为此后“元素精灵”将作为完美大陆上平息战乱的又一成员陪伴在我们的身边。 \r\n\r\n然而好景不长，当人们正沉浸在探寻精灵玩法的喜悦中时，飘沙城一夜封闭的怪事，惊动了完美大陆上的所有居民。经过“圣城元老”的调查，原来这一切都是怨灵大军进入“元素精灵”聚居的五灵幻界与现实世界接口-战歌之城导致的。如果战歌之城被控制，那么…… \r\n\r\n[img]monipic/xw039.jpg[/img]\r\n\r\n就在这个时候，神秘的“五行地巡使”出现了。他持有神秘精灵展现出来的力量，令所有人目瞪口呆。于是大家才知道世界上还有“元素精灵”这样的存在。“五行地巡使”自称是古老的“火之贤者”的后裔，他们这一族掌握着五行循环的奥秘，从来未曾对外有过半点泄露。 \r\n\r\n[img]monipic/xw040.jpg[/img]\r\n\r\n战歌之城，本为“元素精灵”聚居的五灵幻界与现实世界间的唯一接口，神秘无比，从来不曾为任何人所知，城内承接五灵幻界的五行变换，为完美世界稳定运行的重要基础。而进入战歌之城的入口只有两个，一个隐藏在风景如画的桃源镇，另一个则便是那高高在上的飘沙城，两者均为守卫森严之地。 \r\n\r\n[img]monipic/xw042.jpg[/img]', 4, 0, 0, '0000-00-00 00:00:00', '2010-09-23 19:48:41');
INSERT INTO `tg_article` VALUES (6, 0, '旋涡鸣人', 5, '新概念战车网游《钢铁围攻》24日封测', '《钢铁围攻》是一款以坦克为主题的新概念战车网游，凝结新世纪网络游戏的精华，以创新的玩法、狂热的战斗，再现坦克大战的经典，致力于给玩家带去全新的对战体验。\r\n\r\n“时间过去了300年，地球刚刚从核子冬天走出来，到处是腐蚀的大地和人类文明的残骸。变异的昆虫在天空和大地上肆虐，苦难的人们即将成为他们的食物；成片的菌株森林覆盖着茫茫的荒野，到处弥漫着剧毒的孢子，威胁人类脆弱的生命。 \r\n\r\n就这样，在如此恶劣的环境下，人类的生存空间越来越狭小。只能依托先辈们的科学，用为数不多的坦克组成他们生命最后的防线，建立自己的基地……” \r\n\r\n[img]monipic/xw090.jpg[/img]\r\n\r\n《钢铁围攻》最具特色的是坦克的重装工厂系统，坦克部件的购买、组装、涂装迷彩、制造及升级都在重装工厂内进行，玩家按照自己的蓝图组装属于自己的战车。 \r\n\r\n当玩家赚取到一定的资金以后，可以在重装工厂购买部件来组装战车并提升战车的性能；由底盘、引擎和主炮来配备一辆基本的坦克，装甲和副武器作为可选部件也异常重要；底盘和炮台可以涂上不一样迷彩来打造个性的战车。 \r\n\r\n获得战车部件的设计图纸和生产原料以后，在重装工厂内可以进行战车部件的制造，通常制造的部件会比直接购买的部件拥有更强的属性；升级部件可以让自己的战车更加强大，任何一款部件都需要相应的原材料，升级部件虽需要一定的费用，但升级后的效果是非同一般的。 \r\n\r\n[img]monipic/xw091.jpg[/img]\r\n\r\n《钢铁围攻》的战役将要打响，强悍的战车已经重装上阵。勇敢的战士们啊，让我们一同开动坦克，开始战斗！游戏有三大个性鲜明的职业可供玩家选择，任何一个职业都可以让你在坦克大战中突出重围。\r\n\r\n“神射手”，对射击技能有着他人难及的天赋，精通各种武器，并且能在不经意的时刻给予对手致命的一击；\r\n\r\n[img]monipic/xw092.jpg[/img]\r\n\r\n疯狂炮火覆盖，碾碎邪恶力量；强悍的人生要用坦克证明！\r\n\r\n4月24日 ，全新坦克网游《钢铁围攻》将开启封测！ \r\n\r\n《钢铁围攻》官方网站： [url]http://tank.fu16.com[/url]\r\n\r\n《钢铁围攻》官方论坛： [url]http://tank.bbs.fu16.com[/url]', 4, 0, 0, '0000-00-00 00:00:00', '2010-09-23 19:53:11');
INSERT INTO `tg_article` VALUES (7, 0, '小丸子', 4, '姚仙亲自主刀 《仙剑5》剧透曝光', '关于仙剑五的剧情，“姚仙”（编注：即姚壮宪，《仙剑1》的设计师）也曾表示可能会从自己早年规划的两个剧本中选取一个作为其背景。但目前游戏还仅仅处于统筹阶段，这一点从“姚仙”桌子上那厚厚一摞应聘游戏策划的简历中便可以看出端倪。\r\n\r\n在离开台湾之前，姚壮宪也曾为《仙剑二》写过几版剧情，其中两版是他比较满意的。这两版的故事背景设定在某个民不聊生的年代，穷人走投无路，被迫落草为寇，成为山贼，他们平时只打劫过路的商贾，从不骚扰附近的县城。游戏的男主角张真就是由这样一群山贼收养带大的，而游戏的女主角唐晓诗（《仙剑三》中的 “唐雪见”即源于此名），则分为了两个不同的版本。 \r\n\r\n[img]monipic/17146944.jpg[/img]\r\n\r\n在第一个版本中，女主角是县城大员外的女儿，从小体弱多病，却也因此而渐渐精通了药理。一次她出门采药，走得太远，在山脚下遇见野兽，危急中被男主角搭救。两人相谈甚欢，并约好了今后常常见面。女主角平时被家人管得很紧，出来走动的机会较少，男主角便经常溜进县城看她，还帮她采药。就这样，两人从相识、相知，一路走到相爱。而此时，一系列令人意想不到的变故发生了，女主角的身世也逐渐被揭开。原来她的体质之所以异于常人，是因为在她身体里流淌着魔尊的血统。二十年前，一场惨烈的战斗将魔王暂时封印了起来，女主角即在那一刻诞生。她既是封印魔王的锁，又是打开封印的钥匙。二十年后，即将迎来20岁生日的她成了人族与魔族争夺的对象。魔族四处打探她的下落，企图把她抓回去，作为祭品解开魔王的封印。而员外也并非她的生父，他只是奉命看守这把“钥匙”，不让她落入魔族手中。虽然他们之间已经结下了深厚的亲情，但如果最终无法击退魔族，为了人类的命运，他只能选择把她杀死。\r\n\r\n[img]monipic/17146945.jpg[/img]\r\n\r\n据悉，“仙剑五”的策划将全部由姚仕宪本人亲自面试。可见，仙剑奇侠传五的剧情必定会嫁接这两个剧本中的一个之中，当然不排除大规模的改动，一定会使剧情的丰富程度大大加强。', 3, 0, 0, '0000-00-00 00:00:00', '2010-09-23 19:58:24');
INSERT INTO `tg_article` VALUES (8, 0, '龟仙人', 3, '炫舞吧 内测火爆 引领休闲舞蹈网游', '自从《炫舞吧》进入内测之后游戏的火爆程度让人吃惊，对于这款新兴的音乐舞蹈游戏给予了巨大的支持。这不仅是因为游戏本身素质过硬，还有游戏的新内容吸引人。作为一款舞蹈游戏，《炫舞吧》不走寻常路线，以真实系角色的姿态示人，游戏中角色具有漫画中的八头身人物身材，女的高挑苗条，男的挺拔英俊，这让人一眼看上去就会产生好感，而且真实系的角色很容易让玩家产生代入感，让玩家将自己代入到游戏中。 \r\n\r\n[img]monipic/xw127.jpg[/img]\r\n\r\n《炫舞吧》针对真实系角色身材好的特色准备了上百的服装供玩家装饰自己，在内测中又新增了上百件新服装，这让玩家们大呼过瘾，服装里不仅有时下最流行的服饰，还有许多改良型，比如中式汉服超短裙版、旗袍超短版等，一些原本存在于概念中的服装在游戏中得以具现。 \r\n\r\n[img]monipic/xw128.jpg[/img]\r\n\r\n内测中玩家将会体会到约会模式、结婚模式、竞猜机等新内容。新颖的约会模式让人体会到速配约会的感觉，三男三女的速配不仅考验你如何在短时间内展示自己，还能考验你的应变能力。而强大的结婚模式更是情侣们的最爱，与爱侣一起步入婚姻的殿堂，与好友一起狂欢，那是何等的快乐。除此之外游戏还加入了竞猜机迷你游戏，让你在紧张的劲舞之余可以调剂一下，还能赢得点小东西。 \r\n\r\n官方网站：[url]http://58.gyyx.cn[/url]', 2, 0, 0, '0000-00-00 00:00:00', '2010-09-23 20:05:14');
INSERT INTO `tg_article` VALUES (9, 0, '天津饭', 7, '盘点多年以后你还刻骨铭心的十款游戏', '曾经有人说过，每个游戏里的女人都是狂野的，其实要我说，每一个游戏里的人都是狂野与细腻的矛盾体，想想那些让我们难忘的游戏，我们或许狂野、残酷、疯狂、深沉，但确都让我们用情极深，那些离去的朋友，那些远去的岁月，我们伫立在这里，眼角落雨，那些网络上的相逢，证明我来过，投入过，在乎过，将每个游戏的笑容，剪下一块，放在记忆深处。(注:以下排名不分先后)\r\n\r\n[img]monipic/17125921.jpg[/img]\r\n\r\n《拳皇》以摧枯拉朽之势席卷了整个格斗游戏界，每年《拳皇》推出新作之时便是全世界格斗玩家狂欢的节日。玩家在连击中找到绝妙的爽快感，在充满魄力的必杀技中找到了异常的震撼。\r\n\r\n\r\n\r\n暴雪的力作，游戏界的不朽丰碑，开创了即时联机RPG的崭新时代，令后世之作纷纷效仿。玩家孜孜不倦的杀怪为了期盼着某个时刻掉出一件暗金或者绿色的装备，那便是游戏生活中最美妙的时刻，正是玩家对极品装备的追求给予了他们无尽的动力，执着地坚持着不得到最好的东西誓不罢休。\r\n\r\n[img]monipic/17125919.jpg[/img]\r\n\r\n《拳皇》以摧枯拉朽之势席卷了整个格斗游戏界，每年《拳皇》推出新作之时便是全世界格斗玩家狂欢的节日。玩家在连击中找到绝妙的爽快感，在充满魄力的必杀技中找到了异常的震撼。\r\n\r\n[img]monipic/17125917.jpg[/img]\r\n\r\n即时战略一直以来是广大玩家最为喜欢的类型之一。男人大都喜欢这种战争游戏的运筹帷幄和靠作爽快感。而《魔兽争霸3》更是继承了同门师兄《星际争霸》的真髓，把这种运筹帷幄和靠作爽快感推向了一个新的极致。', 10, 2, 0, '0000-00-00 00:00:00', '2010-09-23 20:09:18');
INSERT INTO `tg_article` VALUES (10, 0, '蜡笔小新', 13, '永恒之塔的日子有一种自豪叫做牺牲', '今晚做完25的深渊任务，我踏入了永恒之塔新的征程，进入到深渊练级、PK与被PK…… \r\n\r\n[img]monipic/xw462.jpg[/img]\r\n\r\n没有兴奋，我知道这是另一个难点的开始，考验我的心态与*.*作的时候到了。PK，没有冷静的心态和娴熟的*.*作，只有等死的份了…… \r\n\r\n[img]monipic/xw463.jpg[/img]\r\n\r\n在深渊的魔族练级点休息，等待练级的时机。这边常有天族来骚扰~ \r\n\r\n[img]monipic/xw464.jpg[/img]\r\n\r\n初入深渊的战绩，PK5人挂1次……\r\n\r\n虽不辉煌，对于在各类游戏里都无视PK的我来说，已经是个很不错的开端了\r\n\r\n[img]monipic/xw465.jpg[/img]\r\n\r\n三个天族的把我逼死，死也死得很悲壮……\r\n\r\n过完今晚，我们的命运将会如何呢？\r\n\r\n期待能有更辉煌的战斗！！', 6, 0, 0, '0000-00-00 00:00:00', '2010-09-23 20:12:24');
INSERT INTO `tg_article` VALUES (11, 0, '阿瞬', 16, '暗黑魔幻《炼狱》4月19正式开放封测', '2009年4月19日，暗黑魔幻3DMMORPG网络游戏《炼狱》（[url]http://www.lianyu.com[/url]）将正式开放封测，届时将带给玩家们更多的惊喜！\r\n\r\n[img]monipic/xw153.jpg[/img]\r\n\r\n无数玩家为这一刻的到来期待了许久，终于能以最快的速度进入游戏，感受日臻完善的魔幻世界。新版新服心满足，在今天正式开放的封测中，《炼狱》新增了更多极具可玩性的游戏内容，彻底满足大家的需要！\r\n\r\n双倍经验大放送，助您轻松升级！\r\n\r\n想快快升级？想抢先体验高级别职业技能？《炼狱》封测期间开放双倍经验，让您轻松升级，体验职业华丽技能！\r\n\r\n现金点券送不停\r\n\r\n你爱美吗？型男美女的福音到啦！《炼狱》化身圣诞老人，在每个午夜将现金点券送到每个玩家的游戏账号中，令您可以到商城中尽情购物。大家一起齐装扮！\r\n\r\n珍奇神兽降临人间\r\n\r\n帅气的坐骑在封测期间以每日一拍的形式，在每天中午十二点为您献上5级酷炫神兽供玩家拍卖，千万不可错过哦！\r\n\r\n活动多多，礼品多多，《炼狱》4月19日封测，期待您的加入！\r\n\r\n请注意，本次《炼狱》封闭测试的客户端安装程序，下载完成后可直接安装即可进入游戏。如果您在客户端下载过程中有其它疑问，请与我们的客户服务人员取得联系，我们将竭诚为您服务。\r\n\r\n2009年4月19日，《炼狱》正式对外封测，日前客户端下载已经开放，火热领取激活码活动也全面开启。如果想了解更多关于《炼狱》的资料信息，敬请关注《炼狱》中文官方网站（[url]http://www.lianyu.com[/url]）。\r\n12\r\n34', 174, 16, 1, '2015-06-07 16:42:34', '2015-06-07 16:39:04');
INSERT INTO `tg_article` VALUES (12, 0, '香吉士', 6, '格斗大作《街头霸王4》PC版即将公布', '[img]monipic/17125663.jpg[/img]\r\n\r\nCAPCOM超人气跨平台格斗大作《街头霸王4》已经在PS3、X360以及街机平台上市，销量惊人，不过PC游戏玩家完全还没有看到PC版的任何消息。目前CAPCOM的官方网站已经明明白白为《街头霸王4》标明了PC版，但是任何官方消息都只字不提PC版的事情，也确实让人烦躁。\r\n\r\n针对玩家们质疑的《街头霸王4》会有PC版本推出，CAPCOM官方Blog有消息指出，他们预计今年5月1日正式官方公布《街头霸王4》移植PC版的消息，请玩家们稍安勿躁，至于PC版《快打旋风4》是否会新增原创要素目前也不明。不过可以确定的是如果玩家电脑配备够高档，PC版《街头霸王4》绝对可以远远超越家用主机本，就请拭目以待吧。\r\n\r\n[img]monipic/17125666.jpg[/img]\r\n\r\n[img]monipic/17125665.jpg[/img]\r\n\r\n[img]monipic/17125664.jpg[/img]', 2, 0, 0, '0000-00-00 00:00:00', '2010-09-23 20:19:59');
INSERT INTO `tg_article` VALUES (13, 0, '佐助', 2, '天掉下馅饼《游戏人生》变装拿大奖', '天上又掉馅饼了！《游戏人生》天降仙女，天降忍者，天降甲壳虫轿车……各种神仙异侠附体大行动！漂亮护士MM，超级忍者，魔幻厨师，功夫小子，埃及僵尸，变形金刚……想变什么就变什么，当侠客，还是当神仙？还是当一个科学异侠？你自己灵活选择啦！众多奇幻华丽的变身道具让你享受史上超震撼的无厘头刺激！同时各种神秘的惊喜大奖等你来拿喔！\r\n\r\n《游戏人生》“连环大奖从天降，人人有份拿到爽”活动将在4月25、26日晚上20:30——21:30分开启，赶快和你的朋友一起过来参加史上最华丽的变装舞会吧！参与就有大奖哦，如果你不怕被天上随时可能落下来的馅饼砸着的话，那么就赶快带着背包来接从天而降的神秘礼物吧！你的精灵兽也可以获得意外的惊喜哦！\r\n\r\n活动详情：[url]http://rs.wanku.com/article/2009/0421/article_2392.html[/url]\r\n\r\n[img]monipic/xw315.jpg[/img]\r\n\r\n重大消息！火石成为第三家与盛大合作的合作伙伴！4月17日，《游戏人生》开通电信三区，更广阔的娱乐空间等你体验！周二晚上20：00～23：00“人生”全服大开双倍，周五、六、日晚上20：00～23：00“人生”全服2.5倍经验，劲爆冲级浪潮席卷而来！赶快去体验吧! \r\n\r\n[img]monipic/xw318.jpg[/img]\r\n\r\n《游戏人生》官方网站：[url]http://rs.wanku.com/[/url]\r\n\r\n《游戏人生》是火石软件继《水浒Q传》、《西游Q记》之后的又一款最大最全最好的、高度仿真现实生活的社区网游。具有买车、盖楼、交友、结婚、生育、养宠、种植、畜牧、生产、开店、创业、创作等玩法。在这个创新自由的网游2.0世界里，你可以随心所欲地扮演自己精彩的"第二人生"。游戏具有"创意家园、酷帅名车、武器改造、精宠合成"四大亮点：', 5, 0, 0, '0000-00-00 00:00:00', '2010-09-23 20:23:22');
INSERT INTO `tg_article` VALUES (14, 0, '樱木花道', 9, '创意时代：解密QQ仙侠传美术创意设计', '在腾讯新品发布会上引起广泛媒体关注的腾讯自研3D大作《QQ仙侠传》，在美术设计上的独树一帜，使得这款网游更为抢眼，今天对这款历时五年诚意奉献的游戏在美术风格上进行系列解读。 \r\n\r\n[img]monipic/xw027.jpg[/img]\r\n\r\n行书----突出“飘逸”的感觉，《QQ仙侠传》是一款带有奇幻色彩的武侠类的游戏，美术风格偏于唯美，较为洒脱的行书书法的字体更能表现此种风格。\r\n\r\n剑气----宝剑是比较能体现武侠背景游戏的标志物件之一，但是由于很难和行书字体完美的融合且当前应用泛滥，流于庸俗，而改为一道剑气变形为“侠”字的一撇，这样使logo的元素融合更为统一，整体感觉更具速度感。\r\n\r\n红印----红色印章的创意来源于一个设计上的无奈，在设计上非常忌讳重复出现同样的东西，“仙侠传”三个字都有单人旁，形成设计上的难度，设计师有过很多尝试但效果都不理想，引入红色印记对“传”字进行变形才解决了这个问题，并且红色印章也是对单调黑色字体的一种打破和点缀。\r\n\r\n云纹----弧形的传统云纹背景体现“仙”的感觉，也是缓和字体太多尖锐感觉。形成一定反差，更凸显文字。\r\n\r\n人物设计\r\n\r\n写真----基于用户的喜好，设计团队将现代的时尚元素融入到了东方仙侠风格的人物设定中来，以真实人物的比例与气质为出发点进行美术创作，让极具“仙气”的人物形象更加活脱不失时尚、柔美的感觉。较之市面上充斥的“充气娃娃”式的角色形象，则更显设计团队的“独具匠心” \r\n\r\n[img]monipic/xw028.jpg[/img]\r\n\r\n还原----《QQ仙侠传》的原画创作之初，设计团队就曾利用旅游的机会进行采风，足迹遍及世界各地，将最终镜头实拍的照片场景进行还原，形成了当前极具代入感的唯美画面。较之市面上多如牛毛的拼凑出的“编辑器图像”则更显设计团队的“用心良苦”', 5, 0, 0, '0000-00-00 00:00:00', '2010-09-23 20:25:14');
INSERT INTO `tg_article` VALUES (15, 0, '炎日', 9, '推荐两首亚洲歌后最新主打MV！！！', '安室奈美惠，1977年9月20日生于日本冲绳县那霸市，是一位亚洲女性流行曲歌手。她于14岁出道，是女子组合Super Monkey''s的一分子。其超过10年的歌手生涯，使她成为其中一位日本最长寿歌手。曾获得“2009日本100演艺名人公众形象满意度调查榜” 排名第一等荣誉。\r\n\r\n[flash]http://player.youku.com/player.php/sid/XMTg5OTU5MjQ4/v.swf[/flash]\r\n\r\n亚洲天后、Top Star，SM公司招牌明星，21世纪韩国歌谣界的瑰宝.曾被CNN、路透社、美联社专访。宝儿在日本音乐歌坛专辑销量版7连冠的奇迹。并且超过了许多歌唱实力相当的歌手。宝儿进入歌坛时年仅13岁，没有人能预料到这个瘦弱的小姑娘，之后会创造出曾连续2年荣登日本音乐FANS喜欢的明星排行TOP 10，创造了在日本所发的6张日语正规专辑和2日语精选专辑张专辑全部荣登ORICON排行榜冠军（日本史上历代单独第二位）辉煌记录；更获得过MTV亚洲大奖“ 最具影响力的亚洲艺术家”奖，以及“最具人气的韩国艺术家”奖。这个站在亚洲女歌手荣誉顶端的女孩，几乎是用无数个大奖铺成的个人履历。宝儿可谓是近来韩国歌手在日本发展的一个成功范例。如今的宝儿，已经成为当今亚洲乐坛最富有活力的明星。流利的韩语、日语、和英语，超越年龄的成熟歌唱实力，娴熟的舞技，外加甜美秀丽的外表，这位兼具实力和偶像特质的韩国少女，已经成为史上第一个被日韩两国艺能界共同全力追捧的偶像宝贝。\r\n\r\n[flash]http://player.youku.com/player.php/sid/XMTY5MzYzMTky/v.swf[/flash]', 6, 1, 0, '0000-00-00 00:00:00', '2010-09-23 20:29:12');
INSERT INTO `tg_article` VALUES (16, 0, '星矢', 1, '《梦幻迪士尼》资料片将于9月28日开启', '不论是热爱迪士尼的童话狂人，或是憧憬魔幻世界的游戏高手，或是渴望在游戏中体验线上浪漫人生的幻想达人，《梦幻迪士尼》都将成为你的不二之选。继5月正式开启公测后，《梦幻迪士尼》以其特色玩法为玩家呈现出一个绝无仅有的成人童话世界，而在9月28日，《梦幻迪士尼》首部资料片“媚影觉醒”将携两大全新职业正式与玩家见面。人族新宠“媚术师”将颠覆玩家对人族的固有印象，而血族新贵“血影贵族”更将以其傲人的法术和特殊技能为玩家带来与众不同的游戏体验！\r\n\r\n[b]媚术师妖娆魅力 颠覆人族印象[/b]\r\n\r\n在游戏中，人族职业向来是单体物攻和治疗系的象征。人族的“贵族剑士”以其骄傲的“风华连舞”这一单体多次强攻技能，成为当之无愧的BOSS终结者；而“圣女”作为游戏中唯一的治愈系职业，不仅拥有群体HP、MP恢复技能，更有副本战斗、 BOSS挑战中不可或缺的复活术技能，这一切都让“圣女”成为组队中不可或缺的主力成员。\r\n\r\n然而，也正是因为如此，人族也给外界留下了“法力欠缺”的印象，没有法术攻击的加持，人族团队始终无法在PK赛中占据绝对优势。\r\n\r\n而岁这9月28日新资料片公测，人族的星光职业“媚术师”将正式与玩家见面。“媚术师”的多项禁锢技能将撼动同样拥有封系法术的精灵族和血族。其封系技能不仅能够限制对手的法术攻击以及物理攻击，更可以限制攻击回合数，让对手只有“默默挨打”的份！\r\n\r\n[b]血族新贵华丽暴走 外形不怒自威[/b]\r\n\r\n血影贵族是《梦幻迪士尼》爆发力最强的职业！他们对力量有着狂热的崇拜，追求的是身体与力量的完美结合。“血影舞者”敏捷的身手以及“血影领主”令人畏惧的魔力暴走，让血族成为最受玩家欢迎的种族之一。而“血影贵族”的出现，则将血族的高傲冷酷更加深化，在特定的情况下，血影贵族会变身为另一种形态，陷入狂暴的他们力量大增，能给予多个对手致命的伤害。\r\n\r\n血影贵族还是爱宠人士。他的职业特色是在喂养伙伴时加倍提升伙伴的忠诚度，并且伙伴死亡后不掉忠诚度。这就决定了血影贵族可以更好的控制伙伴为其战斗，是《梦幻迪士尼》中强大的训宠师！\r\n\r\n随着新资料片即将开启，装备特技、装备改造、伙伴装备等全新玩法也将同期与玩家见面，更多详情请密切留意官网http://dsn.91.com，你也可以登录玩家交流论坛http://bbs.91.com/board/69-330.html与更多玩家一起交流游戏心得，集众人智慧，获取第一手优质资讯！《梦幻迪士尼》全新资料片“媚影觉醒”即将于9月27日正式开启，体验全新技能带来的战斗快感，以及更多装备、伙伴养成玩法，你绝不能错过！\r\n\r\n《梦幻迪士尼》作为网龙网络有限公司2010年力推的大作，是网龙公司与迪士尼合作研发，在中国推出的首款唯美成人童话网络游戏，真实还原迪士尼经典动画片场景，众多经典迪士尼形象将和你相约在游戏世界中。3D技术与2D画风完美融合，酷炫变装给你更多装扮选择;3大种族12大职业，上百种战斗和生活技能，多人阵法与西方魔法交融，给玩家带来最震撼视觉特效。', 15, 0, 0, '0000-00-00 00:00:00', '2010-09-23 20:31:56');
INSERT INTO `tg_article` VALUES (301, 1, '炎日', 0, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '我的第一个回帖~~~~~~~~~~~~~~~~', 1, 0, 0, '0000-00-00 00:00:00', '2015-06-07 11:12:37');
INSERT INTO `tg_article` VALUES (302, 1, '炎日', 0, 'RE:我要发帖子了', 'asfasfdasdffas阿萨德发酸发撒旦法撒旦发射点发射导弹发射点发[img]qpic/1/16.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 11:13:09');
INSERT INTO `tg_article` VALUES (303, 9, '炎日', 0, 'RE:推荐两首亚洲歌后最新主打MV！！！', 'RE:推荐两首亚洲歌后最新主打MV！！！', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 11:15:41');
INSERT INTO `tg_article` VALUES (304, 9, '炎日', 0, 'RE:创意时代：解密QQ仙侠传美术创意设计', 'RE:创意时代：解密QQ仙侠传美术创意设计', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 11:19:26');
INSERT INTO `tg_article` VALUES (305, 15, '炎日', 0, 'RE:完美国际新副本即将推出背景揭秘', 'RE:完美国际新副本即将推出 背景揭秘', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 11:21:35');
INSERT INTO `tg_article` VALUES (306, 11, '炎日', 16, 'RE:暗黑魔幻《炼狱》4月19正式开放封测', 'RE:暗黑魔幻《炼狱》4月19正式开放封测', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 11:26:13');
INSERT INTO `tg_article` VALUES (307, 11, '香吉士', 16, 'RE:暗黑魔幻《炼狱》4月19正式开放封测', '有机会试一试[img]qpic/2/8.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 13:38:23');
INSERT INTO `tg_article` VALUES (308, 300, '香吉士', 1, 'RE:TestGuest5.2发帖测试功能', 'asfasfdasdf', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 13:55:17');
INSERT INTO `tg_article` VALUES (309, 11, '香吉士', 16, 'RE:RE:暗黑魔幻《炼狱》4月19正式开放封测', 'asfasfdasdf阿萨法[img]qpic/1/17.gif[/img][img]qpic/3/17.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 14:57:45');
INSERT INTO `tg_article` VALUES (310, 11, '香吉士', 16, 'RE:RE:RE:暗黑魔幻《炼狱》4月19正式开放封测', 'asfasfdasdfsfasfasdfafasdfqwerqwe[img]qpic/3/11.gif[/img][img]qpic/2/4.gif[/img][img]qpic/2/1.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 14:58:22');
INSERT INTO `tg_article` VALUES (311, 11, '香吉士', 16, 'RE:RE:暗黑魔幻《炼狱》4月19正式开放封测', '德法撒旦法撒旦法撒旦发射放大速读法韦尔奇围绕是否[img]qpic/1/41.gif[/img][img]qpic/1/43.gif[/img][img]qpic/1/42.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 14:58:57');
INSERT INTO `tg_article` VALUES (312, 11, '香吉士', 16, 'RE:RE:暗黑魔幻《炼狱》4月19正式开放封测', '之前写过一篇日志，是关于如何搭建自己的OpenWRT开发环境。经过最近一段时间的开发学习和实践，对OpenWRT环境的开发有了一定的了解。在这里将我的开发心得做个整理。', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 15:00:57');
INSERT INTO `tg_article` VALUES (313, 11, '香吉士', 16, 'RE:RE:暗黑魔幻《炼狱》4月19正式开放封测', '要通过官网下载很多相关的软件包，所以必须保证能够顺利连上外网。由于下载速度的限制，编译过程大概需要数小时。编译结束后，所有的产品都会放在编译根目录下的bin/yourtarget/. 例如:我所编译的产物都放在./bin/brcm47xx/下，其中文件主要有几类：\r\n（1）.bin/.trx 文件: 这些都是在我们所选的targ', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 15:01:22');
INSERT INTO `tg_article` VALUES (314, 11, '香吉士', 16, 'RE:RE:RE:暗黑魔幻《炼狱》4月19正式开放封测', 'm是brcm47xx，host system是Linux-x86_64，使用的编译工具以及库是4.3.3+cs_uClibc-0.9.30.1。\r\n（4）md5sums 文件: 这个文件记录了所', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 15:09:21');
INSERT INTO `tg_article` VALUES (315, 11, '香吉士', 16, 'RE:RE:RE:暗黑魔幻《炼狱》4月19正式开放封测', '相同的名字放在这个目录下，然后开始编译即可。编译时，会将软件包解压到build_dir目录下。\r\n当然，你也可以自己在dl里面创建自己的软件包，然后更改相关的配置文件，让openwrt可以识别这个文件包。\r\n由于我的项目更改的内容是底层的，需要跟固件一起安装。所以，我使用的方法就是直接更改dl目录下软件包，然后重新进行固件编译。感觉类似于Linux的内核编译。反复编过十多', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 15:09:35');
INSERT INTO `tg_article` VALUES (316, 11, '香吉士', 16, 'RE:RE:RE:暗黑魔幻《炼狱》4月19正式开放封测', '/****************\r\n* Helloworld.c\r\n* The most simplistic C program ever written.\r\n* An epileptic monkey on crack could write this code.\r\n*****************/\r\n#include <stdio.h>\r\n#include <unistd.h>\r\nint main(void)\r\n{', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 15:10:01');
INSERT INTO `tg_article` VALUES (317, 11, '香吉士', 16, 'RE:RE:RE:暗黑魔幻《炼狱》4月19正式开放封测', '两个文件的目录下，执行make 应该可以生成helloworld的可执行文件。执行helloworld后，能够打印出“Hell! O'' world, why won''t my code compile?”。 这一步，主要保证我们的源程序是可以正常编译的。下面我们将其移植到OpenWRT上。\r\n（2）将OpenWrt-SDK-brcm47xx-for-Linux-x86_64-gcc-4.3.3+cs_uClibc-0.9.30.1.tar.bz2解压\r\ntar –xvf OpenWrt-SDK-brcm47xx-for-Linux-x86_64-gcc-4.3.3+cs_uClibc-0.9.30.1.tar.bz2\r\n（3）进入SDK', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 15:10:27');
INSERT INTO `tg_article` VALUES (318, 11, '香吉士', 16, 'RE:暗黑魔幻《炼狱》4月19正式开放封测', 'Makefile文件模板内容如下：\r\n##############################################\r\n# OpenWrt Makefile for helloworld program\r\n#\r\n#\r\n# Most of the variables used here are defined in\r\n# the include directives below. We just need to\r\n# specify a basic description of the package,\r\n# where to build our program, where to find\r\n# the source files, and where to install the\r\n# compiled program on the router.\r\n#\r\n# Be very careful of spacing in this file.\r\n# Indents should be tabs, not spaces, and\r\n# there should be no trailing whitespace in\r\n# lines that are not commented.', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 15:16:11');
INSERT INTO `tg_article` VALUES (319, 11, '阿瞬', 16, 'RE:暗黑魔幻《炼狱》4月19正式开放封测', '测试自己给自己发帖时，显示自己为楼主还是沙发', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 15:29:23');
INSERT INTO `tg_article` VALUES (320, 11, '炎日', 16, '回复10楼的香吉士', '回复10楼的香吉士回复10楼的香吉士回复10楼的香吉士回复10楼的香吉士回复10楼的香吉士回复10楼的香吉士回复10楼的香吉士', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 18:41:20');
INSERT INTO `tg_article` VALUES (321, 300, '樱木花', 1, 'RE:TestGuest5.2发帖测试功能', '测试回帖功能是否可以，[img]qpic/2/10.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 21:04:14');
INSERT INTO `tg_article` VALUES (322, 0, '樱木花', 1, '第一次发贴', '第一次发贴第一次发贴第一次发贴第一次发贴第一次发贴第一次发贴第一次发贴', 9, 0, 0, '0000-00-00 00:00:00', '2015-06-07 21:25:34');
INSERT INTO `tg_article` VALUES (323, 0, '樱木花', 1, '第二次发贴', '第二次发贴第二次发贴第二次发贴第二次发贴第二次发贴第二次发贴第二次发贴第二次发贴第二次发贴', 1, 0, 0, '0000-00-00 00:00:00', '2015-06-07 21:26:35');
INSERT INTO `tg_article` VALUES (324, 300, '樱木花', 1, 'RE:TestGuest5.2发帖测试功能', '第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 21:30:15');
INSERT INTO `tg_article` VALUES (325, 300, '樱木花', 1, 'RE:TestGuest5.2发帖测试功能', '第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖第一次回帖', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 21:30:47');
INSERT INTO `tg_article` VALUES (327, 326, '樱木花', 1, 'RE:第三次发帖测试数据验证是否有效', '111$aClean[''time''] = time();$aClean[''time''] = time();$aClean[''time''] = time();', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 21:43:56');
INSERT INTO `tg_article` VALUES (328, 326, '樱木花', 1, 'RE:第三次发帖测试数据验证是否有效', '$aClean[''time''] = time();$aClean[''time''] = time();$aClean[''time''] = time();$aClean[''time''] = time();$aClean[''time''] = time();$aClean[''time''] = time();$aClean[''time''] = time();$aClean[''time''] = time();$aClean[''time''] = time();', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 21:44:08');
INSERT INTO `tg_article` VALUES (329, 326, '樱木花', 1, 'RE:第三次发帖测试数据验证是否有效', 'sfasdfdtg_reply_timetg_reply_timetg_reply_time', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-07 21:45:13');
INSERT INTO `tg_article` VALUES (332, 11, '炎日', 16, 'RE:暗黑魔幻《炼狱》4月19正式开放封测', '没有验证码也可以验证吗', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-08 18:21:06');
INSERT INTO `tg_article` VALUES (333, 11, '炎日', 16, 'RE:暗黑魔幻《炼狱》4月19正式开放封测', 'woyouaslfdajsfdl', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-08 18:23:33');
INSERT INTO `tg_article` VALUES (334, 4, '樱木花', 8, 'RE:花花世界寻友记《开心》新人招募计划', '[size=10]文字[/size][u]是短发散发[/u][b]阿萨德发射点发[/b]', 0, 0, 0, '0000-00-00 00:00:00', '2015-06-10 23:34:23');

-- --------------------------------------------------------

-- 
-- 表的结构 `tg_dir`
-- 

CREATE TABLE `tg_dir` (
  `tg_id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '//ID',
  `tg_name` varchar(20) NOT NULL COMMENT '//相册目录名',
  `tg_type` tinyint(1) unsigned NOT NULL COMMENT '//相册的类型',
  `tg_password` char(40) default NULL COMMENT '//相册的密码',
  `tg_content` varchar(200) default NULL COMMENT '//相册的描述',
  `tg_covers` varchar(200) default NULL COMMENT '//相册目录封面',
  `tg_dir` varchar(200) NOT NULL COMMENT '//相册的物理地址',
  `tg_date` datetime NOT NULL COMMENT '//相册创建的时间',
  PRIMARY KEY  (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- 导出表中的数据 `tg_dir`
-- 

INSERT INTO `tg_dir` VALUES (3, '网络游戏宣传图', 0, NULL, '网络游戏宣传图', 'monipic/moshou.jpg', 'photo/1286182218', '2015-06-09 21:33:28');
INSERT INTO `tg_dir` VALUES (4, '诱惑ChinaJoy2010', 1, '7c4a8d09ca3762af61e59520943dc26494f8941b', '诱惑ChinaJoy2010', 'monipic/chinajoy.jpg', 'photo/1286182238', '2015-06-09 21:34:08');
INSERT INTO `tg_dir` VALUES (8, '个人相册', 0, NULL, '个人相册测试', 'monipic/person.gif', 'photo/1433947048', '2015-06-10 22:37:28');

-- --------------------------------------------------------

-- 
-- 表的结构 `tg_flower`
-- 

CREATE TABLE `tg_flower` (
  `tg_id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '//ID',
  `tg_toUser` varchar(20) NOT NULL COMMENT '//收花者',
  `tg_fromUser` varchar(20) NOT NULL COMMENT '//送花者',
  `tg_count` mediumint(8) unsigned NOT NULL COMMENT '//花朵数量',
  `tg_content` varchar(200) NOT NULL COMMENT '//送花感言',
  `tg_time` datetime NOT NULL COMMENT '//送花时间',
  PRIMARY KEY  (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- 
-- 导出表中的数据 `tg_flower`
-- 

INSERT INTO `tg_flower` VALUES (5, '娜美', '炎日', 18, '非常欣赏你，送你花啦~~~', '2015-06-05 23:13:02');
INSERT INTO `tg_flower` VALUES (4, '娜美', '炎日', 71, '非常欣赏你，送你花啦~~~', '2015-06-05 23:12:50');
INSERT INTO `tg_flower` VALUES (6, 'ywyang', 'ywyang', 100, '非常欣赏你，送你花啦~~~', '2015-06-11 13:50:57');
INSERT INTO `tg_flower` VALUES (7, 'ywyang', '炎日', 63, '非常欣赏你，送你花啦~~~', '2015-06-11 21:18:16');

-- --------------------------------------------------------

-- 
-- 表的结构 `tg_friend`
-- 

CREATE TABLE `tg_friend` (
  `tg_id` mediumint(8) NOT NULL auto_increment COMMENT '//ID',
  `tg_toUser` varchar(20) NOT NULL COMMENT '//被添加的好友',
  `tg_fromUser` varchar(20) NOT NULL COMMENT '//添加人',
  `tg_content` varchar(200) NOT NULL COMMENT '//请求内容',
  `tg_state` tinyint(1) NOT NULL default '0' COMMENT '//确定是否为好友',
  `tg_time` datetime NOT NULL COMMENT '//时间',
  PRIMARY KEY  (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- 
-- 导出表中的数据 `tg_friend`
-- 

INSERT INTO `tg_friend` VALUES (1, '樱桃小丸子', '炎日', '', 1, '2015-06-05 15:48:03');
INSERT INTO `tg_friend` VALUES (2, '龟仙人', '炎日', '我非常想和你交个朋友！', 0, '2015-06-05 15:57:26');
INSERT INTO `tg_friend` VALUES (3, '索罗', '炎日', '我非常想和你交个朋友！', 1, '2015-06-05 20:34:50');
INSERT INTO `tg_friend` VALUES (5, '冰河', '炎日', '我非常想和你交个朋友！', 0, '2015-06-05 20:35:13');
INSERT INTO `tg_friend` VALUES (6, '炎日', '好人和坏人', '我非常想和你交个朋友！', 1, '2015-06-05 20:36:44');
INSERT INTO `tg_friend` VALUES (7, '炎日', '一辉', '我非常想和你交个朋友！sfasdfasdf', 0, '2015-06-05 20:37:49');

-- --------------------------------------------------------

-- 
-- 表的结构 `tg_message`
-- 

CREATE TABLE `tg_message` (
  `tg_id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '//ID',
  `tg_toUser` varchar(20) NOT NULL COMMENT '//收信人',
  `tg_fromUser` varchar(20) NOT NULL COMMENT '//发信人',
  `tg_content` varchar(200) NOT NULL COMMENT '//发信内容',
  `tg_state` tinyint(1) NOT NULL default '0' COMMENT '//信息状态',
  `tg_time` datetime NOT NULL COMMENT '//发信时间',
  PRIMARY KEY  (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- 
-- 导出表中的数据 `tg_message`
-- 

INSERT INTO `tg_message` VALUES (1, '娜美', '炎日', '奈美你好，我想和你交朋友！！！', 1, '2010-09-09 11:21:15');
INSERT INTO `tg_message` VALUES (2, '炎日', '妮可罗宾', '方寸间，历数世上桑田沧海；时空里，细问人间暑往寒来；是朋友，星移斗转情不改；是知音，天涯海角记心怀。', 1, '2010-09-12 09:51:24');
INSERT INTO `tg_message` VALUES (3, '炎日', '香吉士', '风是透明的，雨是滴答的，云是流动的，歌是自由的，爱是用心的，恋是疯狂的，天是永恒的，你是难忘的。', 1, '2010-09-12 09:51:55');
INSERT INTO `tg_message` VALUES (4, '炎日', '索罗', '初遇你的心情是温馨的，和你交友的时候是真心的，与你在一起的时候是开心的，认识你这个朋友是无怨无悔的。', 1, '2010-09-12 09:52:45');
INSERT INTO `tg_message` VALUES (5, '炎日', '娜美', '风雨的街头，招牌能挂多久，爱过的老歌，你能记得几首，别忘了有像我这样的一位朋友！永远祝福你！', 1, '2010-09-12 09:54:17');
INSERT INTO `tg_message` VALUES (8, '炎日', '佐助', '家是避风的港湾，朋友是鼓风的海岸。家遮挡了苦雨风霜，朋友送来艳阳里一瓣心香。无家透心凉，有友透心亮。', 0, '2010-09-12 09:55:47');
INSERT INTO `tg_message` VALUES (12, '炎日', '紫龙', '把昨天的烦恼交给风，让今天的感动化作笑容，给忙碌的心情放个假，让平凡的生活变得快乐。', 0, '2010-09-12 10:03:08');
INSERT INTO `tg_message` VALUES (13, '炎日', '星矢', '草长莺飞七月天，转眼一晃又半年，发条短信寄祝愿：身体健康多赚钱！', 1, '2010-09-12 10:07:45');
INSERT INTO `tg_message` VALUES (14, '炎日', '短笛', '茶要喝浓的，香到心里；酒要喝醉的，醒不来的；人要最爱的，下辈子接着爱的；朋友要永远的，看手机的这个，不错！', 0, '2010-09-12 10:08:15');
INSERT INTO `tg_message` VALUES (15, '炎日', '乐平', '大地知道天空的真诚，因为有雨滋润；海岸知道海的真诚，因为有潮抚弄；我知道你的真诚，因为有心语传递。', 0, '2010-09-12 10:09:09');
INSERT INTO `tg_message` VALUES (16, '炎日', '天津饭', '大海因浪花而美丽，人生因友谊而充实，我把快乐的音符作为礼物送给你，愿爱你的人更爱你，你爱的人更懂你！', 0, '2010-09-12 10:09:43');
INSERT INTO `tg_message` VALUES (17, '炎日', '贝吉塔', '当你收到这条短信时，同时也收到我送给你的忘忧草与幸运草，忘忧草能让你忘记烦恼，幸运草能带给你幸运与快乐。', 0, '2010-09-12 10:10:15');
INSERT INTO `tg_message` VALUES (20, '娜美', '炎日', 'woxiangsasdfasdf', 0, '2015-06-05 20:24:35');
INSERT INTO `tg_message` VALUES (21, '樱木花', '炎日', 'vghgfygjklsl;fajsdfl;a', 1, '2015-06-10 23:32:36');
INSERT INTO `tg_message` VALUES (22, 'ywyang', 'ywyang', 'sfasfasdfasfasdfasdfas', 1, '2015-06-11 13:51:20');
INSERT INTO `tg_message` VALUES (23, 'ywyang', '炎日', 'o:ywyango:ywyango:ywyango:ywyango:ywyango:ywyango:ywyango:ywyango:ywyango:ywyango:ywyango:ywyango:ywyango:ywyango:ywyango:ywyango:ywyang', 0, '2015-06-11 21:17:59');

-- --------------------------------------------------------

-- 
-- 表的结构 `tg_photo`
-- 

CREATE TABLE `tg_photo` (
  `tg_id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '//ID',
  `tg_name` varchar(20) NOT NULL COMMENT '//图片名',
  `tg_url` varchar(200) NOT NULL COMMENT '//图片路径',
  `tg_content` varchar(200) default NULL COMMENT '//图片简介',
  `tg_sid` mediumint(8) unsigned NOT NULL COMMENT '//图片所在的目录',
  `tg_username` varchar(20) NOT NULL COMMENT '//上传者',
  `tg_readcount` smallint(5) NOT NULL default '0' COMMENT '//浏览量',
  `tg_commentcount` smallint(5) NOT NULL default '0' COMMENT '//评论量',
  `tg_date` datetime NOT NULL,
  PRIMARY KEY  (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- 
-- 导出表中的数据 `tg_photo`
-- 

INSERT INTO `tg_photo` VALUES (1, '仙剑奇侠传三', 'photo/1286182218/1286241130.jpg', '仙剑奇侠传三', 3, '炎日', 0, 0, '2010-10-05 09:12:22');
INSERT INTO `tg_photo` VALUES (2, '仙剑奇侠传四', 'photo/1286182218/1286241210.jpg', '仙剑奇侠传四', 3, '炎日', 0, 0, '2010-10-05 09:13:33');
INSERT INTO `tg_photo` VALUES (3, 'ChinaJoyMM1', 'photo/1286182238/1286241247.jpg', 'ChinaJoyMM1', 4, '炎日', 4, 0, '2010-10-05 09:14:09');
INSERT INTO `tg_photo` VALUES (4, 'ChinaJoyMM2', 'photo/1286182238/1286241260.jpg', 'ChinaJoyMM2', 4, '炎日', 3, 0, '2010-10-05 09:14:47');
INSERT INTO `tg_photo` VALUES (5, '网络游戏1', 'photo/1286182218/1286245379.jpg', '网络游戏1', 3, '炎日', 0, 0, '2010-10-05 10:23:07');
INSERT INTO `tg_photo` VALUES (6, '网络游戏2', 'photo/1286182218/1286245397.jpg', '网络游戏2', 3, '炎日', 0, 0, '2010-10-05 10:23:23');
INSERT INTO `tg_photo` VALUES (7, 'ChinaJoyMM3', 'photo/1286182238/1286245414.jpg', 'ChinaJoyMM3', 4, '炎日', 3, 0, '2010-10-05 10:23:42');
INSERT INTO `tg_photo` VALUES (8, 'ChinaJoyMM4', 'photo/1286182238/1286245482.jpg', 'ChinaJoyMM4', 4, '炎日', 3, 0, '2010-10-05 10:24:50');
INSERT INTO `tg_photo` VALUES (9, '网络游戏4', 'photo/1286182218/1286245546.jpg', '网络游戏4', 3, '炎日', 0, 0, '2010-10-05 10:26:03');
INSERT INTO `tg_photo` VALUES (10, '网络游戏6', 'photo/1286182218/1286245571.jpg', '网络游戏6', 3, '炎日', 0, 0, '2010-10-05 10:26:18');
INSERT INTO `tg_photo` VALUES (11, 'ChinaJoyMM5', 'photo/1286182238/1286245602.jpg', 'ChinaJoyMM5', 4, '炎日', 3, 0, '2010-10-05 10:26:49');
INSERT INTO `tg_photo` VALUES (12, 'ChinaJoyMM6', 'photo/1286182238/1286245615.jpg', 'ChinaJoyMM6', 4, '炎日', 3, 0, '2010-10-05 10:27:01');
INSERT INTO `tg_photo` VALUES (27, 'beau4', 'photo/1433947048/1433947347.jpg', '', 8, 'ywyang', 7, 0, '2015-06-10 22:42:30');
INSERT INTO `tg_photo` VALUES (26, 'beau3', 'photo/1433947048/1433947312.jpg', '', 8, 'ywyang', 4, 0, '2015-06-10 22:41:55');
INSERT INTO `tg_photo` VALUES (15, 'ChinaJoyMM7', 'photo/1286182238/1286245723.jpg', 'ChinaJoyMM7', 4, '炎日', 5, 0, '2010-10-05 10:28:56');
INSERT INTO `tg_photo` VALUES (16, 'ChinaJoyMM9', 'photo/1286182238/1286245744.jpg', 'ChinaJoyMM9', 4, '炎日', 9, 0, '2010-10-05 10:29:10');
INSERT INTO `tg_photo` VALUES (17, '网络游戏9', 'photo/1286182218/1286245768.jpg', '网络游戏9', 3, '炎日', 0, 0, '2010-10-05 10:29:39');
INSERT INTO `tg_photo` VALUES (18, '网络游戏10', 'photo/1286182218/1286245785.jpg', '网络游戏10', 3, '炎日', 3, 0, '2010-10-05 10:29:51');
INSERT INTO `tg_photo` VALUES (19, 'ChinaJoyMM9', 'photo/1286182238/1286245804.jpg', 'ChinaJoyMM9', 4, '炎日', 63, 8, '2010-10-05 10:30:10');
INSERT INTO `tg_photo` VALUES (20, 'ChinaJoyMM10', 'photo/1286182238/1286245817.jpg', 'ChinaJoyMM10', 4, '炎日', 3, 0, '2010-10-05 10:30:21');
INSERT INTO `tg_photo` VALUES (24, 'beau1', 'photo/1433947048/1433947229.jpg', '', 8, 'ywyang', 123, 0, '2015-06-10 22:40:33');
INSERT INTO `tg_photo` VALUES (30, 'beau2', 'photo/1433947048/1433947544.jpg', '', 8, 'ywyang', 12, 0, '2015-06-10 22:45:46');
INSERT INTO `tg_photo` VALUES (28, 'beau5', 'photo/1433947048/1433947387.jpg', '', 8, 'ywyang', 3, 0, '2015-06-10 22:43:15');
INSERT INTO `tg_photo` VALUES (29, '座右铭', 'photo/1433947048/1433947428.jpg', '', 8, 'ywyang', 43, 0, '2015-06-10 22:43:50');
INSERT INTO `tg_photo` VALUES (31, 'beau2', 'photo/1433947048/1433947544.jpg', '', 8, 'ywyang', 13, 0, '2015-06-10 22:45:53');
INSERT INTO `tg_photo` VALUES (33, '首页测试显示最新图片', 'photo/1433947048/1434076796.jpg', '', 8, 'ywyang', 3, 0, '2015-06-12 10:39:58');

-- --------------------------------------------------------

-- 
-- 表的结构 `tg_photo_comment`
-- 

CREATE TABLE `tg_photo_comment` (
  `tg_id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '//ID',
  `tg_title` varchar(20) NOT NULL COMMENT '//评论标题',
  `tg_content` text NOT NULL COMMENT '//评论内容',
  `tg_sid` mediumint(8) unsigned NOT NULL COMMENT '//图片ID',
  `tg_username` varchar(20) NOT NULL COMMENT '//评论者',
  `tg_date` datetime NOT NULL COMMENT '//评论时间',
  PRIMARY KEY  (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- 
-- 导出表中的数据 `tg_photo_comment`
-- 

INSERT INTO `tg_photo_comment` VALUES (4, 'RE:ChinaJoyMM9', '评论111111\r\nWomen at war: How women ended up on the front line in Afghanistan\r\nIn 2010 the U.S. Army Special Operations Command created Cultural Support Teams, a pilot program to put women on the battlefield in Afghanistan. In this excerpt from her book, Ashley''s War, writer Gayle Tzemach Lemmon shares the background that led to this game-changing decision.', 19, 'ywyang', '2015-06-11 20:41:06');
INSERT INTO `tg_photo_comment` VALUES (5, 'RE:ChinaJoyMM9', '评论22222\r\nWomen at war: How women ended up on the front line in Afghanistan\r\nIn 2010 the U.S. Army Special Operations Command created Cultural Support Teams, a pilot program to put women on the battlefield in Afghanistan. In this excerpt from her book, Ashley''s War, writer Gayle Tzemach Lemmon shares the background that led to this game-changing decision.', 19, 'ywyang', '2015-06-11 20:41:23');
INSERT INTO `tg_photo_comment` VALUES (6, 'RE:ChinaJoyMM9', '评论33333\r\nWomen at war: How women ended up on the front line in Afghanistan\r\nIn 2010 the U.S. Army Special Operations Command created Cultural Support Teams, a pilot program to put women on the battlefield in Afghanistan. In this excerpt from her book, Ashley''s War, writer Gayle Tzemach Lemmon shares the background that led to this game-changing decision.', 19, 'ywyang', '2015-06-11 20:41:45');
INSERT INTO `tg_photo_comment` VALUES (7, 'RE:ChinaJoyMM9', '评论44444\r\nWomen at war: How women ended up on the front line in Afghanistan\r\nIn 2010 the U.S. Army Special Operations Command created Cultural Support Teams, a pilot program to put women on the battlefield in Afghanistan. In this excerpt from her book, Ashley''s War, writer Gayle Tzemach Lemmon shares the background that led to this game-changing decision.', 19, 'ywyang', '2015-06-11 20:41:57');
INSERT INTO `tg_photo_comment` VALUES (8, 'RE:ChinaJoyMM9', '评论5555\r\nWomen at war: How women ended up on the front line in Afghanistan\r\nIn 2010 the U.S. Army Special Operations Command created Cultural Support Teams, a pilot program to put women on the battlefield in Afghanistan. In this excerpt from her book, Ashley''s War, writer Gayle Tzemach Lemmon shares the background that led to this game-changing decision.', 19, 'ywyang', '2015-06-11 20:42:17');
INSERT INTO `tg_photo_comment` VALUES (9, 'RE:ChinaJoyMM9', '评论6666\r\nWomen at war: How women ended up on the front line in Afghanistan\r\nIn 2010 the U.S. Army Special Operations Command created Cultural Support Teams, a pilot program to put women on the battlefield in Afghanistan. In this excerpt from her book, Ashley''s War, writer Gayle Tzemach Lemmon shares the background that led to this game-changing decision.', 19, 'ywyang', '2015-06-11 20:42:29');
INSERT INTO `tg_photo_comment` VALUES (10, 'RE:ChinaJoyMM9', '博学之，审问之，慎思之，明辨之，笃行之[img]qpic/2/6.gif[/img]', 19, '炎日', '2015-06-11 21:15:12');

-- --------------------------------------------------------

-- 
-- 表的结构 `tg_system`
-- 

CREATE TABLE `tg_system` (
  `tg_id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '//ID',
  `tg_webname` varchar(20) NOT NULL COMMENT '//网站名称',
  `tg_article` tinyint(2) unsigned NOT NULL default '0' COMMENT '//文章分页数',
  `tg_blog` tinyint(2) unsigned NOT NULL default '0' COMMENT '//博友分页数',
  `tg_photo` tinyint(2) unsigned NOT NULL default '0' COMMENT '//相册分页数',
  `tg_skin` tinyint(1) unsigned NOT NULL default '0' COMMENT '//网站皮肤',
  `tg_string` varchar(200) NOT NULL COMMENT '//网站敏感字符串',
  `tg_post` tinyint(3) unsigned NOT NULL default '0' COMMENT '//发帖限制',
  `tg_re` tinyint(3) unsigned NOT NULL default '0' COMMENT '//回帖限制',
  `tg_captcha` tinyint(1) unsigned NOT NULL default '0' COMMENT '//是否启用验证码',
  `tg_register` tinyint(1) unsigned NOT NULL default '0' COMMENT '//是否开放会员',
  PRIMARY KEY  (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- 导出表中的数据 `tg_system`
-- 

INSERT INTO `tg_system` VALUES (1, '多用户留言系统', 10, 20, 12, 2, '他妈的|NND|草|操|垃圾|淫荡|贱货|SB|sb|jb|JB|法轮功|小泉', 60, 30, 1, 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `tg_user`
-- 

CREATE TABLE `tg_user` (
  `tg_id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '//用户自动编号',
  `tg_uniqid` char(40) NOT NULL COMMENT '//验证身份的唯一标识符',
  `tg_active` char(40) NOT NULL COMMENT '//激活登录用户',
  `tg_username` varchar(20) NOT NULL COMMENT '//用户名',
  `tg_password` char(40) NOT NULL COMMENT '//密码',
  `tg_question` varchar(20) NOT NULL COMMENT '//密码提示',
  `tg_answer` char(40) NOT NULL COMMENT '//密码回答',
  `tg_email` varchar(40) default NULL COMMENT '//邮件',
  `tg_qq` varchar(10) default NULL COMMENT '//QQ',
  `tg_url` varchar(40) default NULL COMMENT '//网址',
  `tg_sex` char(1) NOT NULL COMMENT '//性别',
  `tg_avatar` char(20) NOT NULL COMMENT '//头像',
  `tg_switch` tinyint(1) unsigned NOT NULL default '0' COMMENT '//个性签名的开关',
  `tg_autograph` varchar(200) default NULL COMMENT '//签名内容',
  `tg_level` tinyint(1) unsigned NOT NULL default '0' COMMENT '//会员等级',
  `tg_post_time` varchar(20) NOT NULL default '0' COMMENT '//发帖的时间戳',
  `tg_reply_time` varchar(20) NOT NULL default '0' COMMENT '//回帖的时间戳',
  `tg_reg_time` datetime NOT NULL COMMENT '//注册时间',
  `tg_last_login_time` datetime NOT NULL COMMENT '//最后登录的时间',
  `tg_last_login_ip` varchar(20) NOT NULL COMMENT '//最后登录的IP',
  `tg_login_count` smallint(4) unsigned NOT NULL default '0' COMMENT '//登录次数',
  PRIMARY KEY  (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

-- 
-- 导出表中的数据 `tg_user`
-- 

INSERT INTO `tg_user` VALUES (5, '9bf40be3f04307790fc2e63996363dd40f446edd', '', '炎日', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我家的狗狗', '4d5cf6a96cf8a438e3ae210bf7b2dac02b6fa1a4', 'bnbbs@163.com', '234234234', 'http://www.yc60.com', '男', 'avatar/m01.gif', 1, '阿萨随时都发撒旦发射的地方', 1, '1433758127', '1433759013', '2010-08-18 22:26:31', '2015-06-11 21:14:49', '127.0.0.1', 51);
INSERT INTO `tg_user` VALUES (6, 'fce4b3004724c08ba283f1af4bc382b009bb3829', 'fe33b6f30b30ddf90c14c8747f010b169a3d5155', '蜡笔小新', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我最喜欢的是', '34bb28945fd223b49e67f9b4bf6d2c12cb73f8f9', 'labixiaoxin@163.com', '234234234', 'http://www.yc60.com', '男', 'avatar/m29.gif', 0, NULL, 0, '0', '0', '2010-08-18 22:30:30', '2010-08-18 22:30:30', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (9, '6528afa27002db3281185c926d273db15e5b70b0', 'bbcc5d47ec78538240e10538299d386230fea512', '樱桃小丸子', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我有个姐姐', '0693b23e03efc840446c716dad880193c1cebe93', 'yintao@sina.com.cn', '23478234', 'http://www.yc60.com', '女', 'avatar/m34.gif', 0, NULL, 0, '0', '0', '2010-08-19 08:58:41', '2010-08-19 08:58:41', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (10, 'a0a9003ebd0a20d72ae92b131fe984c0149dd667', 'f9203a499bdbe661cde5ef18634b953c57812f74', '奥特曼', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是奥特曼', '2694e30d5dca7d243b831aeea8cf03e0511e2fce', 'aoteman@sina.com.cn', '12323423', 'http://www.aoteman.com', '女', 'avatar/m25.gif', 0, NULL, 0, '0', '0', '2010-08-21 15:17:48', '2010-08-21 15:17:48', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (11, '1acc0c777cd4c9490843c168a15bd89a9076b321', '642d05bcedef0bc318b108457e8abc41176310b4', '奥特', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是奥特曼', '2694e30d5dca7d243b831aeea8cf03e0511e2fce', 'bnbbs@163.com', '234234234', 'http://www.aoteman.com', '女', 'avatar/m43.gif', 0, NULL, 0, '0', '0', '2010-08-21 18:48:12', '2010-08-21 18:48:12', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (12, '9666e60c620264b53522f84fed6dc48bf5574e14', 'a9db682808415330181bf77a50e0803711993469', '小丸子', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是小丸子', 'bb18a82d08e1391ff3c575c48a1712c4e980bf39', 'xiaowanzi@sina.com.cn', '234234234', 'http://www.sina.com.cn', '女', 'avatar/m30.gif', 0, NULL, 0, '0', '0', '2010-08-21 19:11:05', '2010-08-21 19:11:05', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (13, '4c629f3a5e62c5bfa7bf16d3f9a00bd330eff235', '283d8f1649facf7b8b0f5b9b42e4478e72b378b4', '好人', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是好人', '320b5da92489bdb993e7108e35954b5102b7171e', 'haoren@sina.com.cn', '2342342', 'http://www.sina.com.cn', '女', 'avatar/m40.gif', 0, NULL, 0, '0', '0', '2010-08-21 19:20:57', '2010-08-21 19:20:57', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (14, '2638e2d7255e32edb5481b53e47bd4a86ad655af', '', '坏人', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是坏人', '67415ef1e4bda2dd233ac3e9d38c607256bf1ff1', 'huairen@163.com', '423432423', 'http://www.163.com', '男', 'avatar/m47.gif', 0, NULL, 0, '0', '0', '2010-08-21 19:22:31', '2010-08-21 19:22:31', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (15, '641eabc04bb6bd32d90d05c0bab2fc2c6d741c41', '', '好人和坏人', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是好人和坏人', '76c27d4fc01e7f9cbf31fb2c2ced77942c9f6cf6', 'haohuai@sina.com.cn', '23423423', 'http://www.sina.com.cn', '男', 'avatar/m22.gif', 0, NULL, 0, '0', '0', '2010-08-21 19:40:02', '2015-06-05 20:36:25', '127.0.0.1', 1);
INSERT INTO `tg_user` VALUES (16, 'a678b77efb52a387c5dbb05d7c14008dc2987eba', '', '孙悟空', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是孙悟空', 'deaed6c927227f47387781299458118e9cdec5b3', 'sunwukong@sina.com.cn', '23423489', 'http://www.sunwukong.com', '男', 'avatar/m02.gif', 0, NULL, 0, '0', '0', '2010-08-24 10:57:02', '2010-08-24 10:57:02', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (17, '231bff478710803c3126327fd96d6d3158120d17', '', '孙悟饭', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是孙悟饭', 'aaa589902087dcad6ab2a6af5643c0fc69e4484c', 'sunwufan@sina.com.cn', '23489734', 'http://www.sunwufan.com', '男', 'avatar/m03.gif', 0, NULL, 0, '0', '0', '2010-08-24 10:58:01', '2010-08-24 10:58:01', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (18, 'b5a4d74d5dc01372083c173c869bf60e729ffbf2', '', '孙悟天', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是孙悟天', 'deaed6c927227f47387781299458118e9cdec5b3', 'sunwutian@sina.com.cn', '23423984', 'http://www.sunwutian.com', '男', 'avatar/m04.gif', 0, NULL, 0, '0', '0', '2010-08-24 10:59:34', '2010-08-24 10:59:34', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (19, '8b4bb3130c8d390013434a704bdaa3be2d614676', '', '克林', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是克林', 'deaed6c927227f47387781299458118e9cdec5b3', 'kelin@sina.com.cn', '234234283', 'http://www.kelin.com.cn', '男', 'avatar/m05.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:02:51', '2010-08-24 11:02:51', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (20, '60bff63cf3e484ec0a8b4daa46dec6baebff989b', '', '龟仙人', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是龟仙人', 'deaed6c927227f47387781299458118e9cdec5b3', 'guixianren@sina.com.cn', '234234999', 'http://www.guixianren.com', '男', 'avatar/m06.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:06:32', '2010-08-24 11:06:32', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (21, 'f31e4adcb6fa592bf718ca73de485ed266220d70', '', '贝吉塔', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是贝吉塔', 'deaed6c927227f47387781299458118e9cdec5b3', 'beijita@sina.com.cn', '23423498', 'http://www.beijita.com', '男', 'avatar/m07.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:07:52', '2010-08-24 11:07:52', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (22, 'a15429e7a5c61d1225d2618b993b1c386565cbd8', '', '天津饭', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是天津饭', 'deaed6c927227f47387781299458118e9cdec5b3', 'tianjf@sina.com.cn', '234234989', 'http://www.tianfjf.com', '男', 'avatar/m08.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:08:39', '2010-08-24 11:08:39', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (23, 'df72455b70f2908ecbdb7fd9ce7947063193fdbd', '', '乐平', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是乐平', 'deaed6c927227f47387781299458118e9cdec5b3', 'leping@sina.com.cn', '234234980', 'http://www.leping.com', '男', 'avatar/m09.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:09:13', '2010-08-24 11:09:13', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (24, '590d5606bfb9a9f5ce755f0059bba31cfa78e927', '', '短笛', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是短笛', 'deaed6c927227f47387781299458118e9cdec5b3', 'duandi@sina.com.cn', '2349854534', 'http://www.duandi.com', '男', 'avatar/m10.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:10:02', '2010-08-24 11:10:02', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (25, 'c75fd7135784a2bd2fe5937e3787445c3e3a6c79', '', '星矢', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是星矢', '2d668504f97a0f9d1798298b84288980c7b388ea', 'xinshi@sina.com.cn', '234234900', 'http://www.xinshi.com', '男', 'avatar/m12.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:13:33', '2015-06-10 10:50:40', '127.0.0.1', 1);
INSERT INTO `tg_user` VALUES (26, '4075ba67f8a2d056f51479b019bf1969e3280189', '', '紫龙', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是紫龙', 'deaed6c927227f47387781299458118e9cdec5b3', 'zilong@sina.com.cn', '23423498', 'http://www.zilong.com.cn', '男', 'avatar/m13.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:17:51', '2010-08-24 11:17:51', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (27, '03135e0fddcfb1b3303a82e9d7aa77aaae1ed20b', '', '一辉', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是一辉', 'deaed6c927227f47387781299458118e9cdec5b3', 'yihui@sina.com.cn', '234234234', 'http://www.yihui.com', '男', 'avatar/m15.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:26:56', '2015-06-05 20:37:35', '127.0.0.1', 1);
INSERT INTO `tg_user` VALUES (28, 'b388eca1454ef38c6032fe7f0478429947276639', '', '阿瞬', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是阿顺', 'deaed6c927227f47387781299458118e9cdec5b3', 'ashun@sina.com.cn', '234982349', 'http://www.ashun.com', '男', 'avatar/m16.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:27:43', '2015-06-07 20:40:42', '127.0.0.1', 2);
INSERT INTO `tg_user` VALUES (29, '302e807532deea9f2c10fdc7612065d7c06452c3', '', '冰河', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是冰河', '2d668504f97a0f9d1798298b84288980c7b388ea', 'binghe@sina.com.cn', '239832498', 'http://www.binghe.com', '男', 'avatar/m18.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:32:05', '2010-08-24 11:32:05', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (30, '938ad75124c268dc96e21bf453d6fdce449cbc23', '', '旋涡鸣人', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是鸣人', 'deaed6c927227f47387781299458118e9cdec5b3', 'mingren@sina.com.cn', '234892374', 'http://www.mingren.com', '男', 'avatar/m19.gif', 0, NULL, 1, '0', '0', '2010-08-24 11:32:57', '2010-08-24 11:32:57', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (31, '73c003e0d282f3221884ede5106724d5400131c4', '', '佐助', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是佐助', 'deaed6c927227f47387781299458118e9cdec5b3', 'zuozhu@sina.com.cn', '23489234', 'http://www.zuozhu.com', '男', 'avatar/m20.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:36:06', '2015-06-09 20:38:25', '127.0.0.1', 3);
INSERT INTO `tg_user` VALUES (32, '98b7bd390dd629f53d53f81f389fc3ff2ba8a7ff', '', '小樱', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是小樱', 'deaed6c927227f47387781299458118e9cdec5b3', 'xiaoying@sima.com.cn', '23427834', 'http://www.xiaoying.com', '女', 'avatar/m21.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:36:43', '2010-08-24 11:36:43', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (33, '1adc7152087dec00eb0ccb290ddc6dc83de0c358', '', '路飞', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是路飞', 'deaed6c927227f47387781299458118e9cdec5b3', 'lufei@sina.com.cn', '2343247', 'http://www.lufei.com', '男', 'avatar/m22.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:38:14', '2010-08-24 11:38:14', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (34, '8e3d876dd74a586a6d7dc8d9cb3c598ab6802f83', '', '娜美', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是娜美', 'deaed6c927227f47387781299458118e9cdec5b3', 'namei@sina.com.cn', '23423489', 'http://www.namei.com.cn', '女', 'avatar/m24.gif', 1, '大家好，我叫娜美，请多多关照~~~', 0, '0', '0', '2010-08-24 11:40:27', '2015-06-08 10:17:19', '127.0.0.1', 5);
INSERT INTO `tg_user` VALUES (35, '3d38a55cd8e81cb529c1a0cdfe0e5e9a68ec4053', '', '索罗', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是索罗', 'aaa589902087dcad6ab2a6af5643c0fc69e4484c', 'suoluo@sina.com.cn', '234234234', 'http://www.suoluo.com', '男', 'avatar/m25.gif', 0, NULL, 0, '0', '0', '2010-08-24 11:54:44', '2015-06-05 22:02:01', '127.0.0.1', 1);
INSERT INTO `tg_user` VALUES (36, 'e26f7eef584adb0c92ae7c865f82590085c9b2ed', '', '香吉士', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是香吉士', '2d668504f97a0f9d1798298b84288980c7b388ea', 'xiangjishi@sina.com.cn', '2134234324', 'http://www.xiangjishi.com', '男', 'avatar/m01.gif', 1, '[img]monipic/love.jpg[/img]', 0, '0', '0', '2010-08-24 11:55:36', '2015-06-12 13:35:40', '127.0.0.1', 5);
INSERT INTO `tg_user` VALUES (37, 'f02289006c5c9d480aa0695238be37cd58efa878', '', 'ywyang2', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我家的狗狗', 'f6c61682721e42b344bd253f236f9a7efffb114c', 'yuanyang@163.com', '123456', 'http://www.baidu.com', '男', 'avatar/m08.gif', 0, NULL, 0, '0', '0', '2015-06-02 14:40:34', '2015-06-02 14:40:34', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (38, '9d4b67acdb905160bcb3d2ac9f03ab6469485b00', '170634196886cd3090e22273995975f1a33a4fc5', '假如', '7c4a8d09ca3762af61e59520943dc26494f8941b', '假如没有', 'f9205cc3324dbff527552d3359c23fda19dff4ca', 'bnbbs@sina.com', '1212341234', 'http://www.baidu.com', '男', 'avatar/m01.gif', 0, NULL, 0, '0', '0', '2015-06-06 09:53:49', '2015-06-06 09:53:49', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (39, 'dab94ae851ea1d20550ca8a1759fd08709e25929', '', '假如5', '7c4a8d09ca3762af61e59520943dc26494f8941b', '假如没有', 'f9205cc3324dbff527552d3359c23fda19dff4ca', 'bnbbs@sina.com', '1212341234', 'http://www.baidu.com', '男', 'avatar/m01.gif', 0, NULL, 0, '0', '0', '2015-06-06 09:54:58', '2015-06-06 09:54:58', '127.0.0.1', 0);
INSERT INTO `tg_user` VALUES (40, '5ce71b207e6541d4b3d52648ff399fbe5b2851b3', '', '假如6', '7c4a8d09ca3762af61e59520943dc26494f8941b', '假如没有', 'f9205cc3324dbff527552d3359c23fda19dff4ca', 'bnbbs@sina.com', '1212341234', 'http://www.baidu.com', '女', 'avatar/m09.gif', 0, NULL, 0, '0', '0', '2015-06-06 09:56:10', '2015-06-08 22:18:53', '127.0.0.1', 1);
INSERT INTO `tg_user` VALUES (41, 'ff20e88488709b0db8369eb33b8f82b29a048d42', '', '樱木花', '7c4a8d09ca3762af61e59520943dc26494f8941b', '假如没有', 'f9205cc3324dbff527552d3359c23fda19dff4ca', 'bnbbs@sina.com', '1212341234', 'http://www.baidu.com', '女', 'avatar/m01.gif', 1, '伤心的人不要听慢歌', 1, '1433684465', '1433950463', '2015-06-06 10:43:25', '2015-06-10 23:33:05', '127.0.0.1', 2);
INSERT INTO `tg_user` VALUES (42, '43cbfa2436e8ce9b6639ed646c3ea5399278bd5c', '', 'ywyang', '7c4a8d09ca3762af61e59520943dc26494f8941b', '最简单的', '0f0904038d3418131d8666dde0bebfdca4c95a78', 'y.w.yang@163.com', '1055664950', 'http://www.github.com', '男', 'avatar/m32.gif', 1, '博学之，审问之，慎思之，明辨之，笃行之。', 1, '0', '0', '2015-06-11 09:55:40', '2015-06-13 10:22:17', '127.0.0.1', 15);
