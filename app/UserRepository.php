<?php
/**
 * Author: twinkledj
 * Date: 11/22/15
 */

namespace App;


class UserRepository
{
    public function find($id)
    {
        return User::find($id);
    }
}