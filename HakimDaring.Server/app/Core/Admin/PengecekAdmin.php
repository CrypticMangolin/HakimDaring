<?php 

// declare(strict_types = 1);

// namespace App\Core\Admin;

// use App\Core\Admin\Interface\InterfacePengecekAdmin;
// use App\Core\Repository\Data\IDUser;
// use App\Core\Repository\InterfaceRepositoryDataUser;
// use InvalidArgumentException;

// class PengecekAdmin implements InterfacePengecekAdmin {

//     private InterfaceRepositoryDataUser $repositoryDataUser;

//     public function __construct(InterfaceRepositoryDataUser $repositoryDataUser)
//     {
//         if ($repositoryDataUser == null) {
//             throw new InvalidArgumentException("repositoryDataUser bernilai null");
//         }
//         $this->repositoryDataUser = $repositoryDataUser;
//     }

//     public function cekApakahAdmin(IDUser $idUser) : bool {
//         $dataUser = $this->repositoryDataUser->ambilDataUser($idUser);

//         return $dataUser->ambilKelompok() == "admin";
//     }

// }

?>