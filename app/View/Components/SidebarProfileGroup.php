<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarProfileGroup extends Component
{
    public $room;
    public $roomName;
    public $roomAvatar;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($room, $roomAvatar, $roomName)
    {
        $this->room = $room;
        $this->roomAvatar = $roomAvatar;
        $this->roomName = $roomName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar-profile-group');
    }
}
