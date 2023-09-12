<?php

namespace DcatAdmin\Echart\Widgets;

use Dcat\Admin\Admin;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Support\JavaScript;
use Dcat\Admin\Traits\InteractsWithApi;
use Dcat\Admin\Widgets\Widget;
use Illuminate\Support\Str;

class Chart extends Widget
{

    use InteractsWithApi;


    protected $htmlAttributes=[
        'style'=>'width:100%;height:100%;'
    ];
    public static $js = [
        ];


    protected $containerSelector;

    protected $built = false;

    public function __construct($selector = null, $options = [])
    {
        if ($selector && !is_string($selector)) {
            $options = $selector;
            $selector = null;
        }

        $this->selector($selector);

        $this->options($options);
    }

    /**
     * 设置或获取图表容器选择器.
     *
     * @param string|null $selector
     * @return Chart|string|null
     */
    public function selector(?string $selector = null)
    {
        if ($selector === null) {
            return $this->containerSelector;
        }

        $this->containerSelector = $selector;

        if ($selector && !$this->built) {
            $this->autoRender();
        }

        return $this;
    }


    /**
     * @return string
     */
    protected function buildDefaultScript()
    {
        $options = JavaScript::format($this->options);

        return <<<JS
(function () {
    var options = {$options};
      var myChart = echarts.init(document.getElementById('{$this->containerSelector}'));

      // 使用刚指定的配置项和数据显示图表。
      myChart.setOption(options);

})();
JS;
    }

    /**
     * @return string
     */
    public function addScript()
    {

        Admin::js(['@dcat-admin.echart.path/echarts/echarts.js']);
        if (!$this->allowBuildRequest()) {
            return $this->script = $this->buildDefaultScript();
        }

        $this->fetched(
            <<<JS
if (! response.status) {
    return Dcat.error(response.message || 'Server internal error.');
}

var chartBox = $(response.selector || '{$this->containerSelector}');

if (chartBox.length) {
    chartBox.html('');

    if (typeof response.options === 'string') {
        eval(response.options);
    }

    setTimeout(function () {

        console.log('myChart',chartBox,response.options)

        var myChart = echarts.init(chartBox[0]);
        myChart.setOption(response.options);
        // myChart
        // new ApexCharts(chartBox[0], response.options).render();
    }, 100);
}
JS
        );

        return $this->script = $this->buildRequestScript();
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->built) {
            return;
        }
        $this->built = true;

        return parent::render();
    }

    public function html()
    {
        $hasSelector = $this->containerSelector ? true : false;

        if (!$hasSelector) {
            // 没有指定ID，需要自动生成
            $id = $this->generateId();

            $this->selector('#' . $id);
        }

        $this->addScript();

        if ($hasSelector) {
            return;
        }

        // 没有指定容器选择器，则需自动生成
        $this->setHtmlAttribute([
            'id' => $id,
        ]);

        return <<<HTML
<div {$this->formatHtmlAttributes()}></div>
HTML;
    }

    /**
     * 返回API请求结果.
     *
     * @return array
     */
    public function valueResult()
    {
        return [
            'status'   => 1,
            'selector' => $this->containerSelector,
            'options'  => $this->formatScriptOptions(),
        ];
    }

    /**
     * 配置选项转化为JS可执行代码.
     *
     * @return string
     */
    protected function formatScriptOptions()
    {
        $code = JavaScript::format($this->options);

        return "response.options = {$code}";
    }

    /**
     * 生成唯一ID.
     *
     * @return string
     */
    protected function generateId()
    {
        return 'echart-' . Str::random(8);
    }

}
