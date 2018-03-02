<?php

class View {

    protected $view;
    protected $data;

    public function __construct($view = null)
    {
        $this->view = $view;
    }

    /**
     * 传入视图文件
     */
    public static function make(string $viewName = null)
    {
        if (!$viewName) {
            throw new \InvalidArgumentException('视图名称不能为空');
        } else {
            $file = ROOT.'/resources/views/'.$viewName.'.php';
            if (!is_file($file)) {
                throw new \UnexpectedValueException('视图文件不存在');
            } else {
                $file = self::getFilePath($viewName);
                return new View($file);
            }
        }
    }

    /**
     * 获取视图文件绝对地址
     */
    protected static function getFilePath(string $viewName)
    {
        $filePath = str_replace('.', '/', $viewName);
        return ROOT.'/resources/views/'.$filePath.'.php';
    }

    /**
     * 数据传入
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }
        return $this;
    }

    /**
     * 视图渲染
     */
    protected function render()
    {
        $obLevel = ob_get_level();
        ob_start();
        if ($this->view) {
            if ($this->data) {
                extract($this->data);
            }
        }
        try {
            include $this->view;
        } catch (Exception $e) {
            $this->handleViewException($e, $obLevel);
        } catch (Throwable $e) {
            $this->handleViewException(new \FatalThrowableError($e), $obLevel);
        }
        return ltrim(ob_get_clean());
    }

    /**
     * 视图错误捕捉
     */
    protected function handleViewException(Exception $e, $obLevel)
    {
        while (ob_get_level() > $obLevel) {
            ob_end_clean();
        }

        throw $e;
    }

    public function __toString()
    {
        return $this->render();
    }
}