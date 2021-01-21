<?php

declare(strict_types=1);

namespace Tasklist\DataAccess;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\NoResultException;

class DbalConnection
{

    public function getConnection(): Connection
    {
        //TODO: Get Params from Environment
        $connectionParams = [
            'dbname' => getenv('CONFIG_MYSQL_DATABASE'),
            'user' => getenv('CONFIG_MYSQL_USER'),
            'password' => getenv('CONFIG_MYSQL_PASSWORD'),
            'host' => getenv('CONFIG_MYSQL_HOST'),
            'driver' => 'pdo_mysql',
        ];

        return DriverManager::getConnection($connectionParams);

    }

    public function getResults($stmt, $param1 = null, $bindValue1 = null, $param2 = null, $bindValue2 = null): array
    {
        $sql = $this->getConnection()->prepare($stmt);

        if ($param1 && $bindValue1){
            $sql->bindValue($param1, $bindValue1);
        }

        if ($param2 && $bindValue2){
            $sql->bindValue($param2, $bindValue2);
        }

        $sql->execute();

        $newResult = [];

        while(($result = $sql->fetchAssociative()) !== false){
            $newResult[] = $result;
        };

        return $newResult;
    }

    public function executeStatement(
        $stmt,
        $param1 = null,
        $bindValue1 = null,
        $param2 = null,
        $bindValue2 = null,
        $param3 = null,
        $bindValue3 = null,
        $param4 = null,
        $bindValue4 = null,
        $param5 = null,
        $bindValue5 = null
    ): string
    {
        try {
            $sql = $this->getConnection()->prepare($stmt);
        } catch (\Doctrine\DBAL\Exception $e) {
            return "Exception while trying to connecto to Database: $e";
        }

        if ($param1 && $bindValue1){
            $sql->bindValue($param1, $bindValue1);
        }

        if ($param2 && $bindValue2){
            $sql->bindValue($param2, $bindValue2);
        }

        if ($param3 && $bindValue3){
            $sql->bindValue($param3, $bindValue3);
        }

        if ($param4 && $bindValue4){
            $sql->bindValue($param4, $bindValue4);
        }

        if ($param5 && $bindValue5){
            $sql->bindValue($param5, $bindValue5);
        }

        $output = 'Success';

        try {
            $sql->execute();
        } catch (Exception $e) {
            return "Error: Please check your POST params! Exception: $e";
        }
        return $output;
    }
}