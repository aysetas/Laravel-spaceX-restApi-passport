<?php


namespace App\Services;

use App\Repository\Eloquent\CapsuleRepository;


class CapsuleService
{
    protected $capsuleRepository;

    public function __construct(CapsuleRepository $capsuleRepository)
    {
        $this->capsuleRepository = $capsuleRepository;
    }

    public function listFilterCapsule()
    {
        return $this->capsuleRepository->listFilterCapsule();
    }

    public function showCapsule($capsule_serial)
    {
        return $this->capsuleRepository->showCapsule($capsule_serial);
    }



}
