<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Feedpost extends Component
{
    public $posts;
    public $noPosts;
    public $loadedPosts;
    public $postsCount;
    public $postsPage;
    public $recommendations;

    public function render()
    {
        return view('livewire.feedpost');
    }
}
