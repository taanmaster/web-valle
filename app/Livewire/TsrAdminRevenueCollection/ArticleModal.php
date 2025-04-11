<?php

namespace App\Livewire\TsrAdminRevenueCollection;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

//Modelos
use App\Models\TsrAdminRevenueColletionArticle;

class ArticleModal extends Component
{

    public $article;

    #[Validate('required|max:255')]
    public $name = '';

    public $description = '';
    public $section_id;

    #[On('selectArticle')]
    public function showModal($id)
    {
        $this->article = TsrAdminRevenueColletionArticle::find($id);

        $this->name = $this->article->name;
        $this->description = $this->article->description;
    }

    #[On('newArticle')]
    public function new($id)
    {
        $this->section_id = $id;
        $this->article = '';
        $this->name = '';
        $this->description = '';
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:500',
        ]);

        if ($this->article != null) {
            $this->article->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Artículo actualizado correctamente.');

            // Redirigir
            return redirect()->route('trs_admin_revenue_collection.index');
        } else {
            TsrAdminRevenueColletionArticle::create([
                'section_id' => $this->section_id,
                'name' => $this->name,
                'description' => $this->description,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Artículo creado correctamente.');

            // Redirigir
            return redirect()->route('trs_admin_revenue_collection.index');
        }
    }

    public function render()
    {
        return view('tsr_admin_revenue_collection.utilities.article-modal');
    }
}
