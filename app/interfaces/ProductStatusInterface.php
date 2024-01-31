<?php

namespace App\Interfaces;

use App\Http\Requests\VariantRequest;

interface ProductStatusInterface
{
    function addVaraint(VariantRequest $request);
    function removeVaraint();
    function activate();
    function delete();
    function listAvailableFunctions();
}
