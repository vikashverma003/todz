<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class ProjectManager extends Facade{
    protected static function getFacadeAccessor() { return 'project-manager'; }
}