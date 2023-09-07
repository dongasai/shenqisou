<?php

namespace App\Admin\Actions\Grid;


use App\Models\BtTags;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EditTag extends \Dcat\Admin\Grid\RowAction
{
    /**
     * @return string
     */
	protected $title = '标签';

    public function render()
    {
        // 实例化表单类并传递自定义参数
        $data = BtTags::query()->where('bid',$this->getKey())->first();

       $form = EditTagForm::make()->payload([
           'id' => $this->getKey(),
           'tags'=>$data['tags']??''
       ]);

        return Modal::make()
            ->title($this->title())
            ->body($form)
            ->button($this->title());
    }
}
