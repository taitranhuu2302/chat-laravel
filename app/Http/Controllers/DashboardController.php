<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Repositories\Friend\FriendRepositoryInterface;
use App\Repositories\FriendRequest\FriendRequestInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected FriendRequestInterface $friendRequestRepository;
    protected FriendRepositoryInterface $friendRepository;

    public function __construct(FriendRequestInterface $friendRequestRepo, FriendRepositoryInterface $friendRepo)
    {
        $this->friendRequestRepository = $friendRequestRepo;
        $this->friendRepository = $friendRepo;
    }

    public function index()
    {
        $friendRequests = $this->friendRequestRepository->findAllFriendRequestByUserId(Auth::id());
        $friends = $this->friendRepository->findAllFriendsByUserId(Auth::id());
        return view('pages.dashboard')->with('friendRequests', $friendRequests)->with('friends', $friends);
    }
}
