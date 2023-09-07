<?php

namespace App\Admin\Actions\Grid;



use App\Models\BtTags;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Contracts\LazyRenderable;
use function Clue\StreamFilter\fun;


class EditTagForm extends Form implements LazyRenderable
{
    use LazyWidget;

    public function handle($input)
    {
        $id = $this->payload['id'];

        $data = BtTags::query()->where('bid',$id)->first();
        if(!$data){
            $data = new BtTags();
            $data->bid = $id;
        }
        $data->tags  =implode(',',$input['tags']);
        $data->save();
//        dump($input,$id,$this->getKey());



        return $this->response()->refresh();
    }

    public function form()
    {
//        dump($this);
        $this->list('tags')->default(explode(',',$this->payload['tags']))->required();
    }

}
