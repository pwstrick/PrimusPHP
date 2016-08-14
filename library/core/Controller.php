<?php
namespace library\core;
/**
 * 控制器父类
 */

class Controller {
    protected $view = [];

    /**
     * Controller constructor.
     */
    public function __construct() {

    }

    private function _template($folder) {
        $template = \InitPrimus::loadClass('\library\core\Template');//模版
        $template->setTemplatePath(APP_PATH . DS . APP_NAME . DS . $folder);//设置模版路径
        return $template;
    }
    /**
     * 将模版渲染出来
     * @param $path
     * @param bool $isReturn
     * @return mixed
     */
    protected function render($path, $isReturn = false) {
        $template = $this->_template('views');
        if($isReturn) {
            return $template->render($path, $this->view);
        }
        echo $template->render($path, $this->view);
    }

    /**
     * 模版配置
     * @param $path
     * @param $attr
     */
    protected function layout($path='default', $attr=[]) {
        $template = $this->_template('layouts');
        $template->setAttributes($attr);
        echo $template->render($path, $this->view);
    }

    /**
     * ajax数据返回
     * @param $status
     * @param string $message
     * @param array $data
     * @param string $type
     */
    protected function ajaxReturn($status, $message = '', $data = array(), $type = 'json') {
        $return_data = array('result' => $status, 'msg' => $message, 'data' => $data);
        $type = strtolower($type);
        if ($type == 'json') {
            header("Content-type: application/json");
            $json_data = json_encode($return_data);
            \InitPrimus::writeLog($json_data);
            exit($json_data);
        } elseif ($type == 'xml') {
            header('Content-type: text/xml');
            $xml = '<?xml version="1.0" encoding="utf-8"?>';
            $xml .= '<return>';
            $xml .= '<status>' .$status. '</status>';
            $xml .= '<message>' .$message. '</message>';
            $xml .= '<data>' .serialize($data). '</data>';
            $xml .= '</return>';
            exit($xml);
        } elseif ($type == "jsonp"){
            $callback = \library\util\Filter::filterStr($_GET['callback']);
            $json_data = json_encode($return_data);
            if (is_string($callback) && isset($callback[0])) {
                exit("{$callback}({$json_data});");
            } else {
                exit($json_data);
            }
        } elseif ($type == 'eval') {
            exit($return_data);
        }
    }

    /**
     * ajax成功
     * @param $data
     */
    protected function success($data=[]) {
        $msg = '操作成功';
        $result = [];
        if(is_string($data)) {
            $msg = $data;
        }else {
            $result = [
                'json' => $data
            ];
        }
        $this->ajaxReturn(1,$msg, $result);
    }
    /**
     * ajax失败
     * @param $data
     */
    protected function error($code, $msg, $data=[]) {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'json' => $data
        ];
        $this->ajaxReturn(0,'操作失败', $result);
    }
}