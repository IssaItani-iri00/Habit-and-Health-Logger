<?php

$apis = [
    "/auth/register"         => ["controller" => "AuthController", "method" => "register"],
    "/auth/login"            => ["controller" => "AuthController", "method" => "login"],
    "/auth/logout"           => ["controller" => "AuthController", "method" => "logout"],

    "/habits/create"         => ["controller" => "HabitController", "method" => "create"],
    "/habits/all"            => ["controller" => "HabitController", "method" => "getAllUserHabits"],
    "/habits/delete"         => ["controller" => "HabitController", "method" => "deleteHabit"],

    "/entries/create"        => ["controller" => "EntryController", "method" => "create"],
    "/entries/all"           => ["controller" => "EntryController", "method" => "getEntriesByUser"],
    "/entries/date"          => ["controller" => "EntryController", "method" => "getEntriesByDate"],
    "/entries/delete"        => ["controller" => "EntryController", "method" => "deleteEntry"],



];