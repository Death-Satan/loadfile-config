<?php

namespace DeathSatan\LoadfileConfig;

use ArrayAccess;
use DeathSatan\LoadfileConfig\Load\DefaultLoad;
use DeathSatan\LoadfileConfig\Load\IniLoader;
use DeathSatan\LoadfileConfig\Load\YamlLoader;
use Exception;

class Config implements ArrayAccess
{
    protected array $attribute = [];

    /**
     * 获取配置值
     * @param string|null $key
     * @param null $default
     * @return mixed|null
     */
    public function get(?string $key=null,$default=null): mixed
    {
        if ($key===null){
            return $this->attribute;
        }
        if (str_contains($key, '.')){
            $keys = explode(',',$key);
            $data = $default;
            foreach ($keys as $item){
                if (empty($this->attribute[$item])){
                    return $data;
                }
                if ($data!==$default){
                    if (empty($data[$item])){
                        return $default;
                    }
                    $data = $data[$item];
                    continue;
                }
                $data = $this->attribute[$item];
            }
            return $data;
        }
        if (empty($this->attribute[$key])){
            return $default;
        }else{
            return $this->attribute[$key];
        }
    }

    /**
     * 设置一个值 支持`.`访问语法
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function set(string $key,mixed $value=null):mixed
    {
        if (str_contains($key,'.')){
            $keys = explode('.',$key);
            $data =null;
            foreach ($keys as $i=> $item){
                if ($i===0){
                $data = &$this->attribute[$item];
                }else{
                    $data = &$data[$item];
                }
            }
            $data = $value;
            return $this->get($key);
        }
        $this->attribute[$key] = $value;
        return $this->get($key);
    }

    /**
     * 删除一个配置项
     * @param string $key
     * @return void
     */
    public function delete(string $key)
    {
        if (str_contains($key,'.')) {
            $keys = explode('.', $key);
            $count = count($keys)-1;
            $data = $this->attribute;
            foreach ($keys as $i=>$item)
            {
                if ($i===0){
                    $datum = &$data[$item];
                }else{
                    if ($count===$i){
                        unset($datum[$item]);
                    }else{
                        $datum = &$data[$item];
                    }
                }
            }
            $this->attribute = $data;
            return;
        }
    }

    /**
     * @param string $name
     * @return DefaultLoad|IniLoader|YamlLoader
     */
    public function getDriver(string $name)
    {
        return match ($name) {
            'ini' => new IniLoader(),
            'yaml' => new YamlLoader(),
            default => new DefaultLoad(),
        };
    }

    /**
     * @throws Exception
     */
    public function load(string $file_path)
    {
        $is_dir = is_dir($file_path);
        if ($is_dir){
            foreach (glob(rtrim(rtrim($file_path,'\\'),'/')) as $path)
            {
                if (is_file($path)&&is_readable($path)){
                    $this->load($path);
                }
            }
        }
        if (is_file($file_path)&&is_readable($file_path)){
            $ext = pathinfo($file_path,PATHINFO_EXTENSION);
            $name = pathinfo($file_path,PATHINFO_FILENAME);
            $driver = $this->getDriver($ext);
            $config = $driver->load($file_path);
            $this->set($name,$config);
            return;
        }else{
            throw new Exception(printf('the file `%s` Does not exist or does not have permission to access',$file_path));
        }
    }

    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }

    public function offsetSet($offset, $value)
    {
       return $this->set($offset,$value);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetExists($offset): bool
    {
        return empty($this->get($offset));
    }
}