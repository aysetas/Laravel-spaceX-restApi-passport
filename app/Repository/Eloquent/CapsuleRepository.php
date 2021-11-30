<?php

namespace App\Repository\Eloquent;

use App\Models\Capsule;

use App\Repository\CapsuleRepositoryInterface;



class CapsuleRepository extends BaseRepository implements CapsuleRepositoryInterface
{
    protected $capsule;

    public function __construct(Capsule $capsule)
    {
        $this->capsule = $capsule;
        parent::__construct($capsule);
    }

    public function listFilterCapsule()
    {
        $capsule = $this->capsule->with('missions') ->orderBy('original_launch_unix', 'ASC')->paginate(10);
        if (request()->status) {
            $capsule = $capsule->where('status', 'like', request()->status);
        }
        return response($capsule, 200);
    }

    public function showCapsule($capsule_serial)
    {
        $capsule= $this->capsule->with('missions')->where('capsule_serial',$capsule_serial)->first();
        return response([
            'data' => $capsule,
        ], 200);
    }
}
