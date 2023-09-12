<?php

namespace DcatAdmin\Echart\Widgets;



/**
 * 折/曲线图卡片.
 *
 * Class Line
 */
class Line extends Card
{


    protected $chartHeight='200';

    /**
     * 图表默认配置.
     *
     * @var array
     */
    protected $chartOptions = [

    ];

    /**
     * 初始化.
     */
    protected function init()
    {
        parent::init();

        // 使用图表
        $this->useChart();

    }




    /**
     * 渲染内容，加上图表.
     *
     * @return string
     */
    public function renderContent()
    {
        $content = parent::renderContent();

        return <<<HTML
{$content}
<div class="card-content">
    {$this->renderChart()}
</div>
HTML;
    }
}
