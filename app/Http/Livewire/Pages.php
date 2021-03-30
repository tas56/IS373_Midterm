<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Page;
use App\Models\User;

class Pages extends Component
{
    public $pages, $title, $body, $page_id;
    public $isOpen = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        $user = auth()->user();
        $this->pages = $user->pages;
        return view('livewire.posts');
    }
    public function index() {

        return view('livewire.posts_public');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->title = '';
        $this->body = '';
        $this->page_id = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        Post::updateOrCreate(['id' => $this->page_id], [
            'title' => $this->title,
            'body' => $this->body,
        ]);

        session()->flash('message',
            $this->page_id ? 'Page Updated Successfully.' : 'Page Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $this->page_id = $id;
        $this->title = $page->title;
        $this->body = $page->body;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Page::find($id)->delete();
        session()->flash('message', 'Page Deleted Successfully.');
    }
}
