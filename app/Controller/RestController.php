<?php
declare(strict_types=1);

namespace App\Controller;


interface RestController
{
    public function index();

    public function show(int $id);

    public function store();

    public function update();

    public function delete(int $id);
}