<?php
namespace App\Repository;

use App\Entity\LegalRep;
use \PDO;

class LegalRepRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo=$pdo;
    }

    // CRUD - CREATE
    public function create(LegalRep $legalRep): bool {
        $stmt=$this->pdo->prepare("INSERT INTO legal_representatives (name_legal_repres, phone_legal_repres, Id_user) 
            VALUES (:name_legal_repres, :phone_legal_repres, :Id_user)");
        $stmt->bindValue(":name_legal_repres",$legalRep->getNameLegalRepres());
        $stmt->bindValue(":phone_legal_repres",$legalRep->getPhoneLegalRepres());
        $stmt->bindValue(":Id_user",$legalRep->getIdUser());
        $result = $stmt->execute();
        return $result;
    }
    // CRUD - READ
    public function findById(int $id): ?LegalRep {
        $stmt = $this->pdo->prepare("SELECT * FROM legal_representatives WHERE Id_legal_representative=:id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $row=$stmt->fetch();
        if (!$row) return null;
        $LegalRep=new LegalRep($row[''], $row['name_legal_repres'],$row['phone_legal_repres'],$row['Id_user'],$row['Id_legal_representative']);
        return $LegalRep;
    }
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM legal_representatives");
        $LegalReps=[];
        while ($row=$stmt->fetch()) {
            $LegalReps[] = new LegalRep($row['name_legal_repres'],$row['phone_legal_repres'],$row['Id_user'],$row['Id_legal_representative']);
        }
        return $LegalReps;
    }
    // CRUD - UPDATE
    public function update(LegalRep $legalRep): bool {
        $stmt = $this->pdo->prepare("UPDATE legal_representatives SET name_legal_repres=:name_legal_repres, phone_legal_repres=:phone_legal_repres, Id_user=:Id_user WHERE Id_legal_representative=:id");
        $stmt->bindValue(":name_legal_repres",$legalRep->getNameLegalRepres());
        $stmt->bindValue(":phone_legal_repres",$legalRep->getPhoneLegalRepres());
        $stmt->bindValue(":Id_user",$legalRep->getIdUser());
        $stmt->bindValue(":Id",$legalRep->getIdLegalRepresentative());
        $result = $stmt->execute();
        return $result;
    }   
    // CRUD - DELETE
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM legal_representatives WHERE Id_legal_representative=:id");
        $stmt->bindValue(":id", $id);
        $result=$stmt->execute();
        return $result;
    }
}
?>