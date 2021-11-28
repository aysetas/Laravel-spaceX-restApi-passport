<?php

namespace App\Repository\Eloquent;

use App\Models\Capsule;

use App\Repository\CapsuleRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use PHPUnit\TextUI\Exception;


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
        $capsule = $this->capsule->with('missions')->get();
        if (request()->get('status')) {
            $capsule = $capsule->where('status', 'like', request()->get('status'));
        }
        return response($capsule, 200);
    }

    public function showCapsule($capsule_serial)
    {
        $capsule= $this->capsule->with('missions')->where('capsule_serial',$capsule_serial)->get();
        return response([
            'data' => $capsule,
        ], 200);
    }
}
