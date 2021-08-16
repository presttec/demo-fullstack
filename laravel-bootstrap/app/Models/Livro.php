<?php

namespace App\Models;

use App\Models\User;
use App\Models\Autor;
use App\Models\Genero;
use App\Models\Editora;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $fillable = ['autor_id','genero_id','editora_id', 'titulo', 'resumo', 'creator_id'];

    public function getNameLinkAttribute()
    {
        $title = __('app.show_detail_title', [
            'titulo' => $this->titulo, 'type' => __('livro.livro'),
        ]);
        $link = '<a href="'.route('livros.show', $this).'"';
        $link .= ' title="'.$title.'">';
        $link .= $this->titulo;
        $link .= '</a>';

        return $link;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function autor()
    {
        return $this->belongsTo(Autor::class, 'autor_id');
    }
    public function genero()
    {
        return $this->belongsTo(Genero::class, 'genero_id');
    }
    public function editora()
    {
        return $this->belongsTo(Editora::class, 'editora_id');
    }
}
