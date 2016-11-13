


# DATASOFA
DATASOFA是一个部署后；新建表格；添加几行代码就可以直接对数据库的表格实现增删改查操作的后台服务工具。

## 功能简介
datasofa是组合 http://www.grocerycrud.com/ crud  和 ci 框架，并添加了一个简单的后台管理框架的一个CRUD管理后台。它包含了一键部署的源代码和实例数据库以及nginx的配置文件，即使你是一个初学者也能很快部署使用。
 ![image](https://github.com/whomm/datasofa/raw/master/screenshot/screenshot.png)

## 适用环境
1. 如果仅对数据库表格进行数据的增删改查操作，可以直接使用该工具。
2. 如果增删改查涉及简单的表格关联，该工具也可以直接支持。
3. 使用者了解一点php，知道mysql数据库，服务器配置好了php和nginx的环境。

## 安装步骤
1. cd 到部署路径 git clone https://github.com/whomm/datasofa ./
2. 创建mysql的数据库datasofa并导入当前文件夹的import.sql文件
3. 复制nginx.conf的内容添加到机器的nginx的配置文件中。注意：里面提示的需要修改的地方。
4. 如果配置的nginx的端口不是80.修改 application/config/config.php 中的 $config['base_url'] 。例如修改成 http://127.0.0.1:8090。注意重新加载nginx配置。
5. 修改application/config/database.php 中的
    1. $db['default']['hostname'] = 'localhost:3306';
    2. $db['default']['username'] = '';
    3. $db['default']['password'] = '';
6. 打开浏览器输入：http://127.0.0.1/即可看到已经添加的示例。
7. 输入http://127.0.0.1/index.php/Examples/index 可以看到grocerycrud提供的示例。

## 使用示例
1. 创建表格
```
---在数据库中创建一个表格
CREATE TABLE `spconf_book` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT 'ip',
  `bookinfourl` varchar(200) NOT NULL DEFAULT '' COMMENT '作品详情链接',
  `author` varchar(10) NOT NULL DEFAULT '' COMMENT '作者',
  `isgetsaleamount` int(11) NOT NULL DEFAULT '0' COMMENT '是否获取网络图书销量',
  `booktype` int(11) NOT NULL DEFAULT '1' COMMENT '体载类型',
  `themetype` int(11) NOT NULL DEFAULT '1' COMMENT '题材类型',
  `pubtime` datetime NOT NULL COMMENT '首发时间',
  `pubfrom` varchar(200) NOT NULL DEFAULT '' COMMENT '首发处',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图书抓取配置';
```
2. 添加crud功能 /application/controllers/spiderconf.php
```
#添加具体处理的方法
public function book()
{
        $crud = new grocery_CRUD();

        $crud->set_table('spconf_book'); //设置需要处理的表格
        $crud->columns('ip','bookinfourl','author','isgetsaleamount','booktype','themetype','pubtime','pubfrom');
        //设置需要显示的列

        //设置ip字段为创建的时候必选
        $crud->required_fields('ip');

        //设置ip字段是唯一的
        $crud->unique_fields(array('ip'));

        //设置显示列表的字段对应的列名称
        $crud->display_as('ip','IP')
             ->display_as('bookinfourl','作品详情链接')
             ->display_as('author','作者')
             ->display_as('isgetsaleamount','是否获取网络图书销量')
             ->display_as('booktype','体载类型')
             ->display_as('themetype','题材类型')
             ->display_as('pubtime','首发时间')
             ->display_as('pubfrom','首发处');

        //设置创建的按钮名称
        $crud->set_subject('图书抓取');
        //设置isgetsaleamount 的关联表格
        $crud->set_relation('isgetsaleamount','spconf_yesornot','yesorno');
        //设置booktype 的关联表格
        $crud->set_relation('booktype','spconf_book_type','name');
        //设置themetype 的关联表格
        $crud->set_relation('themetype','spconf_book_theme','name');

        $output = $crud->render();

        $this->_myoutput($output);
}
```
3. 添加管理界面的左侧菜单 /application/views/welcome_message.php

```
<li class="active"> <a href="#layout" class="active"> <i class="fa fa-columns icon"> <b class="bg-warning"></b> </i> <span class="pull-right"> <i class="fa fa-angle-down text"></i> <i class="fa fa-angle-up text-active"></i> </span> <span>图书管理</span> </a>
    <ul class="nav lt" style="display: block;">
      <li class=""> <a href="/index.php/spiderconf/booktheme" target="good" class=""> <i class="fa fa-angle-right"></i> <span>图书题材</span> </a> </li>
      <li> <a href="/index.php/spiderconf/book" target="good"> <i class="fa fa-angle-right"></i> <span>图书</span> </a> </li>
    </ul>
</li>
```



## 延伸问题
1. 权限管理 datasofa并没有提供权限管理的功能，后续可能会支持。如果是内网简单使用该功能，建议使用nginx提供的权限验证，添加一个密码校验。

## 可以改进的地方
1. 表的字段注释直接作为展现时候的列名称。
2. 简单的权限管理。
3. 自动生成简单的api数据查询接口。

## 联系方式
1. Email: lacing@126.com
2. QQ Group: 544670985
