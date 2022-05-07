<?php

namespace App\Repositories\Profile;

use App\Models\Profile;
use App\Repositories\BaseRepository;

class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{

    /**
     * @return string
     */
    public function getModel(): string
    {
        return Profile::class;
    }

    public function updateByUserId($userId, $data)
    {
        $profile = $this->model->where('user_id', $userId)->first();
        $updated = null;
        if ($profile) {
            $updated = $profile->update($data);
        } else {
            $data['user_id'] = $userId;
            $updated = $this->create($data);
        }
        return $updated;
    }
}
