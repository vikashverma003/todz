<?php 
namespace App\Repositories\Interfaces;

interface UserRepositoryInterface{
    public function all();
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function show($id);
    public function checkUserByEmail($email);
    public function updateToken($tkn,$id);
    public function getUserById($id);
    public function getUserByToken($tkn);
    public function resetPassword($data);
}