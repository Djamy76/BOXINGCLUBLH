<?php
namespace App\Entity;

class LegalRep {
    private ?int $Id_legal_representative;
    private string $name_legal_repres;
    private string $phone_legal_repres;
    private int $Id_user;
    private ?Users $users;

    public function __construct(string $name_legal_repres, string $phone_legal_repres, int $Id_user, ?int $Id_legal_representative= null) {
        $this->Id_legal_representative=$Id_legal_representative;  
        $this->name_legal_repres=$name_legal_repres;
        $this->phone_legal_repres=$phone_legal_repres;
        $this->Id_user=$Id_user;
    }

    public function getIdLegalRepresentative(): ?int { return $this->Id_legal_representative;}

    public function getNameLegalRepres(): string {return $this->name_legal_repres;}

    public function setNameLegalRepres(string $name_legal_repres): self {
        $this->name_legal_repres = $name_legal_repres;
        return $this;
    }

    public function getPhoneLegalRepres(): string {return $this->phone_legal_repres;}

    public function setPhoneLegalRepres(string $phone_legal_repres): self {
        $this->phone_legal_repres = $phone_legal_repres;
        return $this;
    }


    public function getIdUser(): int { return $this->Id_user;}

    public function setIdUser(int $Id_user): self {
        $this->Id_user = $Id_user;
        return $this;
    }

    public function getUsers(): ?Users  {return $this->users;}
}
?>