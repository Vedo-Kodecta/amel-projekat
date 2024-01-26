<?php

namespace App\Interfaces;

interface ProductStatusInterface
{
    function addVaraint();
    function removeVaraint();
    function activate();
    function delete();
}
