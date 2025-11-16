<?php

$apis = [
    "/auth/register"         => ["controller" => "AuthController", "method" => "register"],
    "/auth/login"            => ["controller" => "AuthController", "method" => "login"],
    "/auth/logout"           => ["controller" => "AuthController", "method" => "logout"],

    "/habits/create"         => ["controller" => "HabitController", "method" => "create"],
    "/habits/all"            => ["controller" => "HabitController", "method" => "getAllUserHabits"],
    "/habits/delete"         => ["controller" => "HabitController", "method" => "deleteHabit"],



];