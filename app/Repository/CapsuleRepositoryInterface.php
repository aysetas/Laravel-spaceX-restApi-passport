<?php


namespace App\Repository;


interface CapsuleRepositoryInterface
{
    public function listFilterCapsule();
    public function showCapsule($capsule_serial);

}
