<?php
namespace library\core;

/**
 * 模版类
 */
class Template {
    protected $templatePath;
    protected $attributes = [];

    /**
     * 设置根路径
     * @param $templatePath
     */
    public function setTemplatePath($templatePath) {
        $this->templatePath = $templatePath;
    }

    /**
     * 设置通用属性
     * @param $attributes
     */
    public function setAttributes($attributes) {
        $this->attributes = $attributes;
    }

    /**
     * 渲染模版内容
     * @param $template
     * @param array $data
     * @return string
     */
    public function render($template, array $data = []) {
        $data = \array_merge($this->attributes, $data);
        ob_start();
        extract($data);
        include_once $this->templatePath . DS . $template . '.php';
        $output = ob_get_clean();
        return $output;
    }
}