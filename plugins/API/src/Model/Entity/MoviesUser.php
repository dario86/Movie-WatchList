<?php
namespace API\Model\Entity;

use Cake\ORM\Entity;

/**
 * MoviesUser Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $movie_id
 * @property bool $watched
 *
 * @property \API\Model\Entity\User $user
 * @property \API\Model\Entity\Movie $movie
 */
class MoviesUser extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true
    ];
}
