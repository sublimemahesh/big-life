<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;

class Save extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public Page $parent;

    public Page $page;

    public $image;

    protected function rules()
    {
        return [
            'page.title' => 'required',
            'image' => [Rule::requiredIf($this->page->image === null), 'nullable', 'image'],
            'page.content' => 'required',
            'page.parent_id' => 'sometimes'
        ];
    }

    public $image_config = [
        'image_ratio_crop' => 'C',
        'image_resize' => true,
        'image_ratio_y' => true,
        'image_x' => 1980,
    ];

    public function mount(Page $page, Page $parent)
    {
        $this->page = $page;
        $this->parent = $parent;
        $this->page->parent_id = $parent->id;
    }

    public function updated($name)
    {
        $this->validateOnly($name);
    }

    /**
     * @throws AuthorizationException
     */
    public function save()
    {
        $this->validate();
        if ($this->page->id === null) {
            $this->authorize('create', $this->page);
        } else {
            $this->authorize('update', $this->page);
        }

        if (!empty($this->image)) {
            $image_name = $this->page->replicate()->slug . "-" . Carbon::now()->timestamp . '.' . $this->image->extension();
            if (!empty($this->page->image)) {
                Storage::delete('pages/' . $this->page->image);
            }
            $this->image->storeAs('pages', $image_name);
            $this->page->image = $image_name;
        }

        $this->page->save();

        session()->flash('message', 'Page has been created successfully!');
        //  cleanup
        if ($this->parent->id !== null) {
            redirect()->signedRoute('admin.sections.index', ['page' => $this->parent->slug]);
        } else {
            redirect()->route('admin.pages.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.pages.save');
    }
}
