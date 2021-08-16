<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;
    protected $table = 'generos';

    protected $fillable = ['nome', 'descricao', 'quantidade', 'creator_id'];

    public function getNameLinkAttribute()
    {
        $title = __('app.show_detail_title', [
            'nome' => $this->nome, 'type' => __('genero.genero'),
        ]);
        $link = '<a href="'.route('generos.show', $this).'"';
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
