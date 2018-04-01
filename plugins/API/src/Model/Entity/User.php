<?php
namespace API\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 */
class User extends Entity
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

    protected function _setPassword($password)
    {
        if ($password != '') {
            return (new DefaultPasswordHasher)->hash($password); //bcrypt
        }
    }

    protected function _getFullName()
    {
        return mb_convert_case($this->_properties['name'] . ' ' . $this->_properties['surname'], MB_CASE_TITLE, "UTF-8");
    }
}