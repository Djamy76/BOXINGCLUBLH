<?php
namespace App\Repository;

use App\Entity\Competitions;
use \PDO;

class CompetitionsRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo=$pdo;
    }

    // CRUD - CREATE
    public function create(Competitions $competitions): bool {
        $stmt=$this->pdo->prepare("INSERT INTO competitions (competition, competition_category, sexe, date_, time_) 
            VALUES (:competition, :competition_category, :sexe, :date_, :time_)");
        $stmt->bindValue(":competition",$competitions->getCompetition());
        $stmt->bindValue(":competition_category",$competitions->getCompetitionCategory());
        $stmt->bindValue(":sexe",$competitions->getSexe());
        $stmt->bindValue(":date_",$competitions->getDate()->format('Y-m-d'));
        $stmt->bindValue(":time_",$competitions->getTime()->format('H:i:s'));        
        $result = $stmt->execute();
        return $result;
    }
    // CRUD - READ
    public function findById(int $id): ?Competitions {
        $stmt = $this->pdo->prepare("SELECT * FROM competitions  WHERE Id_competition=:id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $row=$stmt->fetch();
        if (!$row) return null;
        $competitions=new Competitions($row['competition'],$row['competition_category'],$row['sexe'],new \DateTime($row['date_']),new \DateTime($row['time_']),$row['Id_competition']);
        return $competitions;
    }
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM competitions ");
        $competitions=[];
        while ($row=$stmt->fetch()) {
        $competitions[] = new Competitions($row['competition'],$row['competition_category'],$row['sexe'],new \DateTime($row['date_']),new \DateTime($row['time_']),$row['Id_competition']);
        }
        return $competitions;
    }
    // CRUD - UPDATE
    public function update(Competitions $competitions): bool {
        $stmt = $this->pdo->prepare("UPDATE competitions  SET competition=:competition, competition_category=:competition_category, sexe=:sexe, date=:date_, time=:time_ WHERE Id_competition=:id");
        $stmt->bindValue(":competition",$competitions->getCompetition());
        $stmt->bindValue(":competition_category",$competitions->getCompetitionCategory());
        $stmt->bindValue(":sexe",$competitions->getSexe());
        $stmt->bindValue(":date_",$competitions->getDate()->format('Y-m-d'));
        $stmt->bindValue(":time_",$competitions->getTime()->format('H:i:s'));  
        $stmt->bindValue(":id",$competitions->getIdCompetition());     
        $result = $stmt->execute();
        return $result;
    }   
    // CRUD - DELETE
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM competitions WHERE Id_competition=:id");
        $stmt->bindValue(":id", $id);
        $result=$stmt->execute();
        return $result;
    }
}
?>