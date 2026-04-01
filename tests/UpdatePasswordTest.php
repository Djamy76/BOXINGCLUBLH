<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Entity\Users;
use App\Service\UsersService;
use App\Repository\UsersRepository;

class UpdatePasswordTest extends TestCase {

        public function testCanUpdatePasswordWithUser(): void {

        // On prépare un faux utilisateur avec un mot de passe haché
        $fakeUser = new Users(1, 'Rocky', 'Balboa', new \DateTime(), 'rocky@example.com', password_hash('Rocky6789', PASSWORD_ARGON2ID), null);
        
        // Create a "Mock" of the repository (we don't need a real DB)
        $repositoryMock = $this->createMock(UsersRepository::class);
        
        // ON DIT AU MOCK DE RENVOYER CET UTILISATEUR
        $repositoryMock->method('findById')
            ->willReturn($fakeUser);

        // Instantiate the service with the mock
        $service = new UsersService($repositoryMock);

        // Expectation
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Utilisateur non trouvé");

        // 4. Action
        $service->updatePassword(2, 'Rocky6789','Rocky1234', 'Rocky1234'); 
    }
        public function testCanUpdatePasswordWithFalseOldPassword(): void {

        // On prépare un faux utilisateur avec un mot de passe haché
        $fakeUser = new Users(1, 'Rocky', 'Balboa', new \DateTime(), 'rocky@example.com', password_hash('Rocky6789', PASSWORD_ARGON2ID), null);
        
        // Create a "Mock" of the repository (we don't need a real DB)
        $repositoryMock = $this->createMock(UsersRepository::class);
        
        // ON DIT AU MOCK DE RENVOYER CET UTILISATEUR
        $repositoryMock->method('findById')
            ->willReturn($fakeUser);

        // Instantiate the service with the mock
        $service = new UsersService($repositoryMock);

        // Expectation
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("L'ancien mot de passe est incorrect.");

        // 4. Action
        $service->updatePassword(1, 'Rocky2222','Rocky1234', 'Rocky1234'); 
    }
    public function testCanUpdatePasswordWithshortPassword(): void {
        // On prépare un faux utilisateur avec un mot de passe haché
        $fakeUser = new Users(1, 'Rocky', 'Balboa', new \DateTime(), 'rocky@example.com', password_hash('Rocky6789', PASSWORD_ARGON2ID), null);
        
        // Create a "Mock" of the repository (we don't need a real DB)
        $repositoryMock = $this->createMock(UsersRepository::class);
        
        // ON DIT AU MOCK DE RENVOYER CET UTILISATEUR
        $repositoryMock->method('findById')
            ->willReturn($fakeUser);

        // Instantiate the service with the mock
        $service = new UsersService($repositoryMock);

        // Expectation
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Le mot de passe doit contenir au moins 8 caractères.');

        // 4. Action
        $service->updatePassword(1, 'Rocky6789','Rocky', 'Rocky'); 
    }

    public function testCanUpdatePasswordWithNumber(): void {

        // On prépare un faux utilisateur avec un mot de passe haché
        $fakeUser = new Users(1, 'Rocky', 'Balboa', new \DateTime(), 'rocky@example.com', password_hash('Rocky6789', PASSWORD_ARGON2ID), null);
        
        // Create a "Mock" of the repository (we don't need a real DB)
        $repositoryMock = $this->createMock(UsersRepository::class);
        
        // ON DIT AU MOCK DE RENVOYER CET UTILISATEUR
        $repositoryMock->method('findById')
            ->willReturn($fakeUser);

        // Instantiate the service with the mock
        $service = new UsersService($repositoryMock);

        // Expectation
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Le mot de passe doit contenir une majuscule, une minuscule et un chiffre.');

        // 4. Action
        $service->updatePassword(1, 'Rocky6789','Rockytest', 'Rockytest'); 
    }
        public function testCanUpdatePasswordWithSimilarNewPassword(): void {

        // On prépare un faux utilisateur avec un mot de passe haché
        $fakeUser = new Users(1, 'Rocky', 'Balboa', new \DateTime(), 'rocky@example.com', password_hash('Rocky6789', PASSWORD_ARGON2ID), null);
        
        // Create a "Mock" of the repository (we don't need a real DB)
        $repositoryMock = $this->createMock(UsersRepository::class);
        
        // ON DIT AU MOCK DE RENVOYER CET UTILISATEUR
        $repositoryMock->method('findById')
            ->willReturn($fakeUser);

        // Instantiate the service with the mock
        $service = new UsersService($repositoryMock);

        // Expectation
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Les nouveaux mots de passe ne sont pas identiques.");

        // 4. Action
        $service->updatePassword(1, 'Rocky6789','Rocky1234', 'Rocky12345'); 
    }
    public function testCanUpdatePasswordWithOldPassword(): void {

        // On prépare un faux utilisateur avec un mot de passe haché
        $fakeUser = new Users(1, 'Rocky', 'Balboa', new \DateTime(), 'rocky@example.com', password_hash('Rocky6789', PASSWORD_ARGON2ID), null);
        
        // Create a "Mock" of the repository (we don't need a real DB)
        $repositoryMock = $this->createMock(UsersRepository::class);
        
        // ON DIT AU MOCK DE RENVOYER CET UTILISATEUR
        $repositoryMock->method('findById')
            ->willReturn($fakeUser);

        // Instantiate the service with the mock
        $service = new UsersService($repositoryMock);

        // Expectation
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Le nouveau mot de passe est identique au précédent.");

        // 4. Action
        $service->updatePassword(1, 'Rocky6789','Rocky6789', 'Rocky6789'); 
    }
}
?>