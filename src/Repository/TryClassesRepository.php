<?php
namespace App\Repository;

use App\Entity\TryClasses;
use \PDO;
use \DateTime;

class TryClassesRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo=$pdo;
    }

    // CRUD - CREATE
    public function create(tryClasses $tryClasses): bool {
        $stmt=$this->pdo->prepare("INSERT INTO try_classes (class, class_category,date, time, id_try_class)
            VALUES (:class, :class_category,:date, :time, :id_try_class);");
        $stmt->bindValue(":class",$tryClasses->getClass());
        $stmt->bindValue(":class_category",$tryClasses->getClassCategory());
        $stmt->bindValue(":date",$tryClasses->getDate()->format('Y-m-d'));
        $stmt->bindValue(":time",$tryClasses->getTime()->format('H:i:s'));
        $stmt->bindValue(":id_try_class",$tryClasses->getIdTryClass());
        $result = $stmt->execute();
        return $result;
    }
    // CRUD - READ
    public function findById(int $id): ?TryClasses {
        $stmt = $this->pdo->prepare("SELECT * from try_classes WHERE id_try_class=:id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $row=$stmt->fetch();
        if (!$row) return null;
            $tryClasses=new TryClasses($row['class'], $row['class_category'], new DateTime($row['date']), new DateTime($row['time']), $row['id_try_class']);
        return $tryClasses;
    }
    function findAll(): array {
        $stmt = $this->pdo->query("SELECT * from try_classes");
        $tryClasses=[];
        while ($row=$stmt->fetch()) {
            $tryClasses[] = new TryClasses($row['class'], $row['class_category'], new DateTime($row['date']), new DateTime($row['time']), $row['id_try_class']);
        }
            return $tryClasses;
    }
    // CRUD - UPDATE
    public function update(tryClasses $tryClasses): bool {
        $stmt=$this->pdo->prepare("UPDATE try_classes SET class=:class, class_category=:class_category, date=:date, time=:time, id_try_class=:id_try_class");
        $stmt->bindValue(":class",$tryClasses->getClass());
        $stmt->bindValue(":class_category",$tryClasses->getClassCategory());
        $stmt->bindValue(":date",$tryClasses->getDate()->format('Y-m-d'));
        $stmt->bindValue(":time",$tryClasses->getTime()->format('H:i:s'));
        $stmt->bindValue(":id_try_class",$tryClasses->getIdTryClass());
        $result = $stmt->execute();
        return $result;
    }
    // CRUD - DELETE
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE from try_classes WHERE id_try_class=:id");
        $stmt->bindValue(":id", $id);
        $result=$stmt->execute();
        return $result;
    }
    
}
?>