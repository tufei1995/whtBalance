<?php
/**
 * 武汉通余额查询工具
 * @author 随风飘扬
 * @var
 */
$wht = new whtBalance();
$wht->balance($_GET['id']);

class whtBalance {

	/**
	 * 武汉通官网已注册手机号.
	 * @var
	 */
	protected static $phone = '';

	/**
	 * 武汉通官网已注册密码.
	 * @var
	 */
	protected static $passwd = '';

	/**
	 * cookie，用于后续查询操作.
	 * @var
	 */
	protected static $cookie;

	/**
	 * 操作网址列表
	 * @var array
	 */
	protected static $urls = array(
		'getCookie' => 'http://www.whcst.com/index',
		'login' => 'http://www.whcst.com/whtUser/login.jhtml',
		'balance' => 'http://www.whcst.com/whtUser/cardTradeRecord.jhtml'
	);

	public function __construct() {
		if (!static::$phone || !static::$passwd) {
			exit('还未设置武汉通官网查询账号');
		}
	}

	public function balance($id) {
		$rel = $this->post(static::$urls['getCookie'], '', true);
		preg_match_all("/WYSESSIONID=(.*);Pa/i", $rel, $session);
		static::$cookie = $session[1][0];
		$content = $this->post(static::$urls['login'], 'phone=' . static::$phone . '&passwd=' . static::$passwd . '&rememberMe=Y&callback=_login.jhtml');
		$content = json_decode($content);
		if ($content->ret == '9999') exit('账号不存在');
		else if ($content->ret == '0002') exit('密码错误');
		else echo $this->post(static::$urls['balance'], 'cardno='.$id);
	}

	private function post($url, $data = '', $return_header = false) {
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$test[] = $k.'='.urlencode($v);
			}
			$data = implode('&', $test);
		}
		$header = array(
			'User-Agent: Mozilla/5.0 (Linux; Android 5.1.1; Redmi Note 3 Build/LMY47V) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/37.0.0.0 Mobile MQQBrowser/6.8 TBS/036872 Safari/537.36 MicroMessenger/6.3.32.960 NetType/WIFI Language/zh_CN sfpy',
			'Cookie: WYSESSIONID='.static::$cookie,
		);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HEADER, $return_header);
		curl_setopt($curl, CURLOPT_NOBODY, $return_header);
		$content = curl_exec($curl);
		curl_close($curl);
		
		return $content;
	}
}

?>