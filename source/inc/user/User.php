<?php

namespace inc\user;

use Exception;

/**
 * A class to save and load a username and password.
 * It hashes the password automatically.
 */
class User
{
    public ?string $username;
    public ?string $password;
    public static string $location = '/etc/quarantaenie/passwd';

    /**
     * @param string $username => The username of the wanted user.
     * @param string|NULL $password => If you want to save the user provide a password
     */
    public function __construct(string $username, string $password=NULL)
    {
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    private function prepareInsert(): string
    {
        return "$this->username $this->password\n";
    }

    private function getInsert(string $row): array
    {
        $arr = preg_split("/ /", $row);
        return ['username' => $arr[0], 'password_hash' => trim($arr[1], " \n\r\t\v\x00")];
    }

    /**
     * Saves the password to the defined $location.
     *
     * @return void
     * @throws Exception => One or more class attributes are NULL
     */
    public function save(): void
    {
        if ($this->username and $this->password and static::$location)
        {
            // If exists then append else write
            if (is_file(static::$location))
                $txt = fopen(static::$location, 'a') or die("Unable to open file");
            else
                $txt = fopen(static::$location, "w") or die("Unable to open file");
            fwrite($txt, $this->prepareInsert());
            fclose($txt);
        }
        else
            throw new Exception("One or more class attributes are NULL");
    }

    /**
     * Load a user from file.
     *
     * @return array => The found user ['username' => admin, 'password_hash' => password_hash]
     * @throws Exception => User file not found
     */
    public function load(): array
    {
        // If file is found
        if (is_file(static::$location) and $this->username)
        {
            $txt = fopen(static::$location, "r") or die("Unable to open file!");
            $output = [];
            while (($line = fgets($txt)) !== false)
            {
                $output = $this->getInsert($line);
                if ($output['username'] == $this->username)
                {
                    $this->password = $output['password_hash'];
                    break;
                }
            }
            fclose($txt);
            return $output;
        }
        else
            throw new Exception("User file not found");
    }
}