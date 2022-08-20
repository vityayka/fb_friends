<?php declare(strict_types=1);

namespace App\Cli;

use App\Repository\FacebookFriends;

class FindFbPath extends CliAction
{
    public function __invoke($user0, $user1)
    {
        var_dump((new FacebookFriends($this->getContainer()))->findShortestPath((int)$user0, (int)$user1));
    }
}