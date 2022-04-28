<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarFriendRequest extends Component
{
    public $friendRequests;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($friendRequests)
    {
        $this->friendRequests = $friendRequests;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar-friend-request');
    }
}
