<?php
namespace App\Entity;

class CompetitionRegister {
    private int $Id_user;
    private ?Users $users;
    private int $Id_competition;
    private ?Competitions $competitions;

public function __construct(int $Id_user, int $Id_competition) {
        $this->Id_user=$Id_user; 
        $this->Id_competition=$Id_competition;
}

    public function getIdUser(): int {return $this->Id_user;}

    public function setIdUser(int $Id_user): self {
        $this->Id_user = $Id_user;
        return $this;
    }

    public function getUsers(): ?Users {return $this->users;}

    public function getIdCompetition(): int {return $this->Id_competition;}

    public function setIdCompetition(int $Id_competition): self {
        $this->Id_competition = $Id_competition;
        return $this;
    }

    public function getCompetitions(): ?Competitions {return $this->competitions;}
}
?>