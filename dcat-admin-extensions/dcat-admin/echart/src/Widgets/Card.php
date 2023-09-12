<?php

namespace DcatAdmin\Echart\Widgets;


use Dcat\Admin\Support\Helper;

class Card extends \Dcat\Admin\Widgets\Metrics\Card
{


    /**
     * 启用图表.
     *
     * @return Chart
     */
    public function useChart()
    {

        return $this->chart ?: ($this->chart = Chart::make());
    }

    /**
     * 设置图表.
     *
     * @param  array|\Closure  $options
     * @return \Dcat\Admin\Widgets\Metrics\Card
     */
    public function chart($options = [])
    {
//        $this->setHtmlAttribute('style','height:')
        if ($options instanceof \Closure) {
            $this->chartCallback = $options;
        } else {
            $this->chartOptions = array_merge(
                $this->chartOptions,
                Helper::array($options)
            );
        }

        $this->useChart();

        return $this;
    }

}
