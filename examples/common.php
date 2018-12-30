<?php

namespace Examples;

function generateFakeUser()
{
    $genders = ['male', 'female'];
    $gender = $genders[rand(0, 1)];
    $fakeUser = file_get_contents("https://uinames.com/api/?gender=$gender");
    $user = json_decode($fakeUser, true);
    $user['age'] = rand(10, 40);
    return $user;
}
