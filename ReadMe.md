## 解析hexo的post的markdown文件。

依赖**erusev/parsedown** 和 **yaml**

```shell
composer install
```

测试实例

```php
$file = "./crontab.md";
$parse = new \XianYun\ParseHexo($file);
$header = $parse->getHeader();//markdown header中yaml数据
$content = $parse->getContent();//正文内容
$Parsedown = new \Parsedown();// 利用parsemarkdown 解析正文
$content = $Parsedown->text($content);
```



