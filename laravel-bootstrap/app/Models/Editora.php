<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editora extends Model
{
    use HasFactory;
    protected $table = 'editoras';

    protected $fillable = ['nome', 'descricao', 'quantidade', 'creator_id'];

    public function getNameLinkAttribute()
    {
        $title = __('app.show_detail_title', [
            'nome' => $this->nome, 'type' => __('editora.editora'),
        ]);
        $link = '<a href="'.route('editoras.show', $this).'"';
        $link .= ' title="'.$title.'">';
        $link .= $this->nome;
        $link .= '</a>';

        return $link;
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
