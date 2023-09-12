<?php


namespace DcatAdmin\Echart\Lazy;

use Illuminate\Http\Request;

class EchatLine extends \DcatAdmin\Echart\Widgets\Line
{
    protected $chartHeight = 220;

    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();

        $this->title('New Users');
        $this->dropdown([
            '7' => 'Last 7 Days',
            '28' => 'Last 28 Days',
            '30' => 'Last Month',
            '365' => 'Last Year',
        ]);
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        $this->withChart([150, 230, 224, 218, 135, 147, 260]);
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return \Dcat\Admin\Widgets\Metrics\Card|EchatLine
     */
    public function withChart(array $list)
    {
        return $this->chart([
                'xAxis'  => [
                    'type' => 'category',
                    'data' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                ],
                'yAxis'  => [
                    'type' => 'value'
                ],
                'series' => [
                    [
                        'data' => $list,
                        'type' => 'line'
                    ]
                ]
            ]
        );
    }

    /**
     * 设置卡片内容.
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$content}</h2>
    <span class="mb-0 mr-1 text-80">{$this->title}</span>
</div>
HTML
        );
    }
}
