<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Repositories\FriendRequest\FriendRequestInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $friendRequestRepository;

    public function __construct(FriendRequestInterface $repository)
    {
        $this->friendRequestRepository = $repository;
    }

    public function index()
    {
        $friendRequests = $this->friendRequestRepository->findFriendRequestByUserId(Auth::id());

        return view('pages.dashboard')->with('friendRequests', $friendRequests);
    }
}
