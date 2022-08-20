<?php declare(strict_types=1);

namespace App\Repository;

class FacebookFriends extends Repository
{
    public function findShortestPath(int $user0, int $user1): array
    {
        $stm = $this->getPDO()->prepare('
            select
                f1.user_id as parent_id,
                f1.friend_id as friend1_id,
                f2.friend_id as friend2_id,
                f3.friend_id as friend3_id,
                f4.friend_id as friend4_id,
                f1.friend_name,
                case when f1.friend_id = :user1 then 1
                     when f2.friend_id = :user1 then 2
                     when f3.friend_id = :user1 then 3
                     when f4.friend_id = :user1 then 4 end as handshakes
                from facebook_friends f1
                    left join facebook_friends f2 on f2.user_id = f1.friend_id
                    left join facebook_friends f3 on f3.user_id = f2.friend_id
                    left join facebook_friends f4 on f4.user_id = f3.friend_id 
                where
                    :user0 = f1.user_id and :user0 not in (f1.friend_id, f2.friend_id, f3.friend_id, f4.friend_id)
                  and :user1 in (f1.friend_id, f2.friend_id, f3.friend_id, f4.friend_id)
                order by handshakes limit 1
        ');

        $stm->execute([
            'user0' => $user0,
            'user1' => $user1
        ]);

        $result = [];
        foreach ($stm->fetch(\PDO::FETCH_ASSOC) as $friendId) {
            $result[] = $friendId;
            if ($friendId === $user1) {
                break;
            }
        }

        return $result;
    }
}