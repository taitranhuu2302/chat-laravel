<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\Room;
use App\Models\User;
use App\Repositories\Friend\FriendRepositoryInterface;
use App\Repositories\FriendRequest\FriendRequestInterface;
use App\Repositories\Room\RoomRepositoryInterface;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Factory;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected RoomRepositoryInterface $roomRepository;
    protected FriendRequestInterface $friendRequestRepository;

    public function __construct(RoomRepositoryInterface $roomRepo, FriendRequestInterface $friendRequestRepo)
    {
        $this->roomRepository = $roomRepo;
        $this->friendRequestRepository = $friendRequestRepo;
    }

    public function index(): Factory|View|Application
    {
        $rooms = $this->roomRepository->findAllRoomByUserId(Auth::id());
        $friendRequests = $this->friendRequestRepository->findAllFriendRequestByUserId(Auth::id());
        return view('pages.dashboard')
            ->with('rooms', $rooms)
            ->with('friendRequests', $friendRequests);
    }
}
