<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const STATUS_PUBLIC =1;
    const STATUS_PRIVATE=0;

    const HOT_ON =1;
    const HOT_OFF =0;

    protected $guarded = [];
    protected  $status =[
        1   =>[
            'name'=>'Public',
            'class'=>'label label-danger'
        ],
        0   =>[
            'name'=>'Private',
            'class'=>'label label-default'
        ]
    ];

    protected  $hot =[
        1   =>[
            'name'=>'Nổi bật',
            'class'=>'label label-success'
        ],
        0   =>[
            'name'=>'Không',
            'class'=>'label label-default'
        ]
    ];
    public function getStatus(){
        return array_get($this->status,$this->pro_active,'[N\A]');
    }

    public function getHot(){
        return array_get($this->hot,$this->pro_hot,'[N\A]');
    }
    public function category(){
        return $this->belongsTo(Category::class,'pro_category_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
