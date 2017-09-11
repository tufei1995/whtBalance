# 武汉通余额查询工具
## 使用方法
### 1. 注册
前往[武汉城市通官网](http://www.whcst.com/)使用手机号注册
### 2. 下载上传
在本页面`Clone or Download`按钮选择`Download Zip`下载本项目压缩包，使用编辑器打开wht.php修改账号密码配置为刚才所注册账户。
```php
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
```
将修改完毕后的wht.php上传到网站目录，访问http://hostname/wht.php?id=武汉通卡号 即可开始查询。

### 3.示例 
[武汉通余额查询](http://wht.whutech.com/)

作者 [@随风飘扬](http://www.suifengpiaoyang.cn/)     
2017 年 05月 05日
