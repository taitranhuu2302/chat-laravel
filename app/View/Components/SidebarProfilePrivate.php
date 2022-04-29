<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarProfilePrivate extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $roomAvatar;
    public $roomName;
    public $userProfile;

    public function __construct($roomAvatar, $roomName, $userProfile)
    {
        $this->roomAvatar = $roomAvatar;
        $this->roomName = $roomName;
        $this->userProfile = $userProfile;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar-profile-private');
    }
}
