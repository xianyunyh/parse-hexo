<?php

namespace XianYun;

class ParseHexo
{
    private $fileArray = [];
    public function __construct($file)
    {
        if (!file_exists($file)) {
            throw new \Exception("文件不存在");
        }
        $this->file2Array($file);
        //获取头部结束和more结束的位置
        $res = $this->parseData($this->fileArray);

    }

    /**
     * 将文件变成数组
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    private function file2Array($file)
    {
        $data = file_get_contents($file);
        $arrs = explode("\n", $data);
        $this->fileArray = $arrs;
    }
    /**
     * 获取标题的结束位置和more的位置
     * @param  [type] &$arrs [description]
     * @return [type]        [description]
     */
    private function parseData(&$arrs)
    {

        $titleLine = 0;
        $moreLine = 10;
        foreach ($arrs as $key => $v) {

            if (stripos($v, '---') !== false) {
                if ($key == 0) {
                    continue;
                } else {

                    $titleLine = $key;
                    unset($arrs[$key]);
                }
            }
            if (strpos($v, "<!--more-->") !== false) {
                unset($arrs[$key]);
                $moreLine = $key;
                break;
            }
        }
        $this->titleEnd = $titleLine;
        $this->moreEnd = $moreLine;
    }
    /**
     * 解析头部的yaml数据
     * @param  [type] $data [description]
     * @param  [type] $line [description]
     * @return [type]       [description]
     */
    private function parseYaml($data, $line)
    {
        if (!extension_loaded('yaml')) {
            throw new \Exception("yaml拓展没有加载");
        }

        $res = join(array_slice($data, 0, $line), "\n");
        return yaml_parse($res);

    }

    private function parse($data, $begin, $end = null)
    {

        $res = join(array_slice($data, $begin, $end), "\n");
        return $res;
    }
    /**
     * 解析头部yaml
     * @return [type]       [description]
     */
    public function getHeader()
    {
        if ($this->titleEnd == 0) {
            return false;
        }
        return $this->parseYaml($this->fileArray, $this->titleEnd);
    }
    /**
     * 获取more 区域数据
     * @return [type]        [description]
     */
    public function getMore()
    {
        if ($this->titleLine == 0 && $this->moreEnd == 0) {
            return false;
        }
        return $this->parse($this->fileArray, $this->titleEnd, $this->moreEnd);
    }
    /**
     * 获取内容区域
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function getContent()
    {
        return $this->parse($this->fileArray, $this->moreEnd, null);
    }
}
