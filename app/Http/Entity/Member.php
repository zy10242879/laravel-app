<?php

namespace App\Http\Entity;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
  protected $table = 'member';
  //protected $primaryKey = 'id'; //由于所有主键都设置为id所以此行不需要
  //public $timestamps = false;//关联created_at updated_at，由于所有表都创建了前两个字段，此处可以不用false来关闭
  protected $guarded = [];//创建记录时不允许添加的字段，空为都允许
}
