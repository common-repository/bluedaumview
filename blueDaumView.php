<?php
/*
Plugin Name: blueDaumView
Plugin URI: http://www.blueiblog.com/ko
Description: blueDaumView는 워드프레스에서 글을 발행 시 다음뷰에 동시 발행 해주며 다음뷰로 발행된 포스팅은 하단에 추천 코드 삽입을 해주는 플러그인입니다.
Version: 1.0.1
Author: Blueⓘ
Author URI: http://www.blueiblog.com
Author Email: bluei@blueiblog.com
*/

class BlueDaumView {
	var $name = "blueDaumView";
	var $version = "1.0.1";
	var $pluginurl;
	var $pluginfile;
	var $options;
	
	function __construct() {
		$this->initialize();
	}
	
	function BlueDaumView() {
		$this->initialize();
	}
	
	/**
	 * 플러그인 실행 준비 작업
	 */
	function initialize() {
		$this->options = get_option($this->name);
		$this->pluginurl = substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']));
		$this->pluginfile = basename(__FILE__);
		register_activation_hook( __FILE__, array(&$this, 'activatePlugin' ));
		add_action("admin_menu", array(&$this, 'addAdminPage'));
		add_action("admin_menu", array(&$this, 'addWriteMetaBox'));
		add_filter("the_content", array(&$this,'processingContent'));
	}

	/**
	 * 플러그인 활성화시 처리
	 */
	function activatePlugin() {
		if(!$this->options["recombox_type"]) $this->options = array("recombox_type" => '1');
		if(!$this->options["recombox_skin"]) $this->options = array("recombox_skin" => '<table width="100%"><tr><td align="center">{$recombox}</td></tr></table>');
		update_option($this->name, $this->options);
	}
	
	/**
	 * 어드민 페이지 설정 함수 ( 출력 및 변경된 내용을 저장 )
	 */
	function addAdminPage() {
		if($_POST) {
			foreach($_POST as $key=>$val) {
				if($key != "Submit") $this->options[$key] = $val;
			}
			update_option($this->name, $this->options);
		}
		add_submenu_page('options-general.php', "blueDaumView", "blueDaumView", 10, basename(__FILE__), array(&$this,'printSettingPage'));
	}
	
	function addWriteMetaBox() {
		if( function_exists( 'add_meta_box' )) {
			add_meta_box('daumbloggernews', '다음뷰에 송고하기', array(&$this,'printWriteMetaBox'), 'post', 'side');
		}
	}

	/**
	 * 어드민 페이지 출력 함수
	 */	
	function printSettingPage() {
		include dirname(__FILE__)."/page_admin_setting.php";
	}
	
	function printWriteMetaBox() {
		//$xml = $this->getXML("api.v.daum.net", "/open/category.xml");
		//$xml = simplexml_load_file("http://api.v.daum.net/open/category.xml");
		$xml = simplexml_load_file(dirname(__FILE__)."/category.xml");

		if(is_object($xml)) {
			if($xml->head->code == "200") {
				$category = $xml->entity->category;
			};
		}
		include dirname(__FILE__)."/write_meta_box.php";
	}
	
	/**
	 * 포스팅 내용 처리 함수
	 */
	function processingContent($content) {
		$nid = $this->getNid();
		$box = array(
					1=>'<embed src="http://api.v.daum.net/static/recombox1.swf?nid='.$nid.'" quality="high" bgcolor="#ffffff" width="400" height="80" type="application/x-shockwave-flash"></embed>',
					2=>'<embed src="http://api.v.daum.net/static/recombox2.swf?nid='.$nid.'" quality="high" bgcolor="#ffffff" width="400" height="58" type="application/x-shockwave-flash"></embed>',
					3=>'<embed src="http://api.v.daum.net/static/recombox3.swf?nid='.$nid.'" quality="high" bgcolor="#ffffff" width="67" height="80" type="application/x-shockwave-flash"></embed>'
				);
		if($nid != -1) $content .= str_replace("{\$recombox}", $box[$this->options['recombox_type']], stripslashes($this->options['recombox_skin']));
		return $content;
	}
	
	/**
	 * 다음뷰에 포스트가 송고 되어 있는지 체크
	 */
	function getNid() {
		$ret = -1;
		$xml = $this->getXML("api.v.daum.net", "/open/news_info.xml?permalink=".get_permalink());
		//$xml = simplexml_load_file("http://api.v.daum.net/open/news_info.xml?permalink=".get_permalink());
		if(is_object($xml)) {
			if($xml->head->code == "200") $ret = $xml->entity->news->id;
		}
		return $ret;
	}
	
	function getXML($url, $uri) {
		if(!($fp=fsockopen($url, 80, $errno, $errstr, 5 )))
			fprintf( stderr, $errstr );
		
		$out  = "GET $uri HTTP/1.1\r\n";
		$out .= "Host: api.v.daum.net\r\n";
		$out .= "Connection:Close\r\n\r\n";
		
		fputs( $fp, $out );
		
		while( $data = fgets($fp) ){
			if( !trim($data) )
				break;
		}
		
		$data = stream_get_contents($fp);
		return simplexml_load_string($data);
	}
}
$blueDaumView = new BlueDaumView();
?>
