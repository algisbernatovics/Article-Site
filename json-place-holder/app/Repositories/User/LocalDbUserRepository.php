<?php


namespace App\Repositories\User;

use App\Controllers\ErrorController;
use App\Core\Functions;
use App\Core\PDO;
use App\Models\Users;


class LocalDbUserRepository implements UserRepository
{
    private object $PDOConnection;
    private object $queryBuilder;

    public function __construct()
    {
        $this->PDOConnection = (new PDO())->getPDOconnection();
        $this->queryBuilder = $this->PDOConnection->createQueryBuilder();
    }

    public function getUsers(string $requestUri): ?array
    {
        $id = Functions::digitsOnly($requestUri);

        if ($id > 0) {
            $response = $this->queryBuilder->select('*')
                ->from('users')
                ->where("id =$id")
                ->fetchAllAssociative();
        } else {
            $response = $this->queryBuilder->select('*')
                ->from('users')
                ->fetchAllAssociative();
        }
        return $this->buildModel($response);
    }


    private function buildModel(array $response): array
    {
        $users = [];
        foreach ($response as $user) {
            $users[] = new Users(
                $user['id'],
                $user['name'],
                $user['username'],
                $user['email'],
                $user['city'],
                $user['phone'],
                $user['website'],
                $user['company'],
                $user['password']
            );
        }
        return $users;
    }

    public function deleteUser(string $requestUri): void
    {

    }

    public function userLogin($PostData): string
    {
        $userInputEmail = $PostData['email'];
        $userInputPassword = $PostData['password'];
        $response = $this->queryBuilder->select('*')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $userInputEmail)
            ->fetchAllAssociative();

        if ($response[0]['password'] === $userInputPassword && count($response) === 1) {
            return $response[0]['id'];
        } else return (new ErrorController())->wrongEmailOrPassword();

    }

    public function addUser($PostData): void

    {
        $this->queryBuilder
            ->insert('users')
            ->values([
                'id' => ':id',
                'name' => ':name',
                'username' => ':username',
                'email' => ':email',
                'city' => ':city',
                'phone' => ':phone',
                'website' => ':website',
                'company' => ':company',
                'password' => ':password',

            ])
            ->setParameter('id', $PostData['id'])
            ->setParameter('name', $PostData['name'])
            ->setParameter('username', $PostData['username'])
            ->setParameter('email', $PostData['email'])
            ->setParameter('city', $PostData['city'])
            ->setParameter('phone', $PostData['phone'])
            ->setParameter('website', $PostData['website'])
            ->setParameter('company', $PostData['company'])
            ->setParameter('password', $PostData['password'])
            ->executeStatement();
    }
}
