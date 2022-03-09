# config manage

## 可读取 `yaml` `ini` `php` 配置文件

## 示例

---
```php
$config = new \DeathSatan\LoadfileConfig\Config();
$dir = __DIR__.DIRECTORY_SEPARATOR;
$config->load($dir.'aaa.php'); //读取 php配置文件
$config->load($dir.'test.ini'); //读取ini配置文件
$config->load($dir.'demo.yaml');//读取yaml配置文件
var_dump($config->get());//打印所有已加载的配置项
/**
* array(3) {
  ["aaa"]=>
  array(1) {
    ["log"]=>
    array(1) {
      ["type"]=>
      string(4) "file"
    }
  }
  ["test"]=>
  array(2) {
    ["APP"]=>
    array(2) {
      ["DEBUG"]=>
      int(1)
      ["Track"]=>
      int(1)
    }
    ["OPTION"]=>
    array(1) {
      ["Check"]=>
      int(1)
    }
  }
  ["demo"]=>
  array(1) {
    ["yaml"]=>
    array(1) {
      ["name"]=>
      string(6) "厕所"
    }
  }
}

 */

```
---