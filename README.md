# 公众号第三方平台

> [第三方平台官方概要说明](https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/res_list&verify=1&id=open1419318292&token=&lang=zh_CN
),组件基于[overtrue/wechat](https://github.com/overtrue/wechat) 进行扩展

## 安装

环境要求：PHP >=5.5.9

1. 使用 [composer](https://getcomposer.org/)

  ```shell
  composer require "gibson/wechat"
  ```
  
2. 注册 ServiceProvider

  ```php
  Gibson\Wechat\Providers\WechatServiceProvider::class,
  ``` 
  
3. 创建配置文件

  ```shell
  php artisan vendor:publish --provider="Gibson\Wechat\Providers\WechatServiceProvider"
  ```