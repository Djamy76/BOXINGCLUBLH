<?php
namespace App\Entity;

class CompetitionRegister {
    private int $Id_member;
    private ?Members $members;
    private int $Id_competition;
    private ?Competitions $competitions;

public function __construct(int $Id_member, int $Id_competition) {
        $this->Id_member=$Id_member; 
        $this->Id_competition=$Id_competition;
}

    public function getIdMember(): int {return $this->Id_member;}

    public function setIdMember(int $Id_member): self {
        $this->Id_member = $Id_member;
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