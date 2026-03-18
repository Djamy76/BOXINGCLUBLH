<?php
namespace App\Entity;

class CompetitionRegister {
    private int $id_member;
    private ?Members $members;
    private int $Id_competition;
    private ?Competitions $competitions;

public function __construct(int $id_member, int $Id_competition) {
        $this->id_member=$id_member; 
        $this->Id_competition=$Id_competition;
}

    public function getIdMember(): int {return $this->id_member;}

    public function setIdMember(int $id_member): self {
        $this->id_member = $id_member;
        return $this;
    }

    public function getMembers(): ?Members {return $this->members;}

    public function getIdCompetition(): int {return $this->Id_competition;}

    public function setIdCompetition(int $Id_competition): self {
        $this->Id_competition = $Id_competition;
        return $this;
    }

    public function getCompetitions(): ?Competitions {return $this->competitions;}
}
?>