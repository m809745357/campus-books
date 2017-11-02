<?php

namespace App\Repository;

interface Repository
{
    public function trending($num, $where);
}
