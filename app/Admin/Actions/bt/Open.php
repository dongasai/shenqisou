<?php

namespace App\Admin\Actions\bt;

use App\Models\Bt;
use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;

/**
 * 打开磁力连接
 *
 */
class Open extends RowAction
{
    /**
     * 返回字段标题
     *
     * @return string
     */
    public function title()
    {
        return '下载';
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return \Dcat\Admin\Actions\Response
     */
    public function handle(Request $request)
    {
        // 获取当前行ID
        $id = $this->getKey();

        $bt = Bt::find($id);
        $bt->hits++;
        $bt->save();

        $mt  = "magnet:?xt=urn:btih:{$bt->infohash}"; ;
//        dump($bt);
        // 返回响应结果并刷新页面
        return $this->response()->success("成功")->script('window.location.href = "'.$mt.'"; window.location.reload();');
    }





}
