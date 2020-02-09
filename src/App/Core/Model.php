<?php

namespace App\App\Core;

interface Model
{

    function get();
    function first();
    function find($primary);

}