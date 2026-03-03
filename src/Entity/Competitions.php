<?php
namespace App\Entity;

use DateTime;

class Competitions {
    private ?int $Id_competition;
    private string $competition;
    private string $competition_category;
    private string $sexe;
    private DateTime $date;
    private DateTime $time;

    public function __construct(string $competition, string $competition_category, string $sexe, DateTime $date, DateTime $time, ?int $Id_competition= null) {
        $this->Id_competition=$Id_competition;  
        $this->competition=$competition;
        $this->competition_category=$competition_category;
        $this->sexe=$sexe;
        $this->date=$date;
        $this->time=$time;
    }

    public function getIdCompetition(): ?int {return $this->Id_competition;}

    public function getCompetition(): string {return $this->competition;}

    public function setCompetition(string $competition): self {
        $this->competition = $competition;
        return $this;}
    
    public function getCompetitionCategory(): string {return $this->competition_category;}

    public function setCompetitionCategory(string $competition_category): self {
        $this->competition_category = $competition_category;
        return $this;}

    public function getSexe(): string { return $this->sexe;}

    public function setSexe(string $sexe): self {
        $this->sexe = $sexe;
        return $this;
    }

    public function getDate(): DateTime {return $this->date;}

    public function setDate(DateTime $date): self {
        $this->date = $date;
        return $this;}
    
    public function getTime(): DateTime { return $this->time;}

    public function setTime(DateTime $time): self {
        $this->time = $time;
        return $this;}
}
?>