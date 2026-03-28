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
        $stmt = $this->pdo->query("SELECT id_try_class, class, class_category, date, from try_classes");
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
    

    // AUTRES METHODES

    // RECUPERATION DES COURS DE LA SEMAINE ACTUELLE

    public function findByDateRange(\DateTime $start, \DateTime $end): array {
    $sql = "SELECT * FROM try_classes 
            WHERE date BETWEEN :start AND :end 
            ORDER BY date ASC, time ASC";
            
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        ':start' => $start->format('Y-m-d'),
        ':end'   => $end->format('Y-m-d')
    ]);

    $classes = [];
    while ($row = $stmt->fetch()) {
        // On transforme chaque ligne en objet Entity TryClasses
        $classes[] = new TryClasses(
            $row['class'],
            $row['class_category'],
            new \DateTime($row['date']),
            new \DateTime($row['time']),
            (int)$row['id_try_class']
        );
    }
    return $classes;
    }
    // Fonctions save et delete pour la gestion du planning par l'administrateur

    public function addClass(TryClasses $tryClass): bool {
        $sql = "INSERT INTO try_classes (class, class_category, date, time) 
                VALUES (:class, :category, :date, :time)";
    
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'class'    => $tryClass->getClass(),
            'category' => $tryClass->getClassCategory(),
            'date'     => $tryClass->getDate()->format('Y-m-d'),
            'time'     => $tryClass->getTime()->format('H:i:s')
    ]);
    }

    public function deleteClass(int $id): bool {
        $sql = "DELETE FROM try_classes WHERE id_try_class = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>