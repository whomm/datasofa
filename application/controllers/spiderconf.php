<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class spiderconf extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->model('grocery_crud_model');
		$this->load->library('grocery_CRUD');
	}

	public function _myoutput($output = null)
	{
		$this->load->view('spiderconf.php',$output);
	}



	public function index()
	{
		$this->_myoutput((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function booktheme()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('spconf_book_theme');
			$crud->columns('name');

			//创建必选
			$crud->required_fields('name');

			//唯一
			$crud->unique_fields(array('name'));


			$crud->display_as('name','名称');

			$crud->set_subject('图书题材');

			$output = $crud->render();

			$this->_myoutput($output);
	}
	/*
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
  */

    public function book()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('spconf_book');
			$crud->columns('ip','bookinfourl','author','isgetsaleamount','booktype','themetype','pubtime','pubfrom');

			//创建必选
			$crud->required_fields('ip');

			//唯一
			$crud->unique_fields(array('ip'));


			$crud->display_as('ip','IP')
				 ->display_as('bookinfourl','作品详情链接')
				 ->display_as('author','作者')
				 ->display_as('isgetsaleamount','是否获取网络图书销量')
				 ->display_as('booktype','体载类型')
				 ->display_as('themetype','题材类型')
				 ->display_as('pubtime','首发时间')
				 ->display_as('pubfrom','首发处');

			$crud->set_subject('图书抓取');
			$crud->set_relation('isgetsaleamount','spconf_yesornot','yesorno');
			$crud->set_relation('booktype','spconf_book_type','name');
			$crud->set_relation('themetype','spconf_book_theme','name');

			$output = $crud->render();

			$this->_myoutput($output);
	}







}
