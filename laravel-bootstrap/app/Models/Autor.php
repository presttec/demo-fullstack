<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;
    protected $table = 'autores';

    protected $fillable = ['nome', 'biografia', 'ano_nascimento', 'sexo', 'nacionalidade', 'quantidade', 'creator_id'];

    public function getNameLinkAttribute()
    {
        $title = __('app.show_detail_title', [
            'nome' => $this->nome, 'type' => __('autor.autor'),
        ]);
        $link = '<a href="'.route('autores.show', $this).'"';
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
