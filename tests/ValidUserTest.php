<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Service\UsersService;
use App\Repository\UsersRepository;

class ValidUserTest extends TestCase {

    public function testCanValidUserByEmail(): void {

        // 1. Create a "Mock" of the repository (we don't need a real DB)
        $repositoryMock = $this->createMock(UsersRepository::class);

        // 2. Instantiate the service with the mock
        $service = new UsersService($repositoryMock);

        // 3. Expectation
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Email invalide !');

        // 4. Action
        $service->validUser("rocky.Balboa@gmail", 'Rocky1234', 'Rocky1234'); 
    }
    public function testCanValidUserPasswordTooShort(): void {

        // 1. Create a "Mock" of the repository (we don't need a real DB)
        $repositoryMock = $this->createMock(UsersRepository::class);

        // 2. Instantiate the service with the mock
        $service = new UsersService($repositoryMock);

        // 3. Expectation
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Le mot de passe doit contenir au moins 8 caractères.');

        // 4. Action
        $service->validUser("rocky.Balboa@gmail.com", 'Rocky1', 'Rocky1'); 
    }
    
    public function testCanValidUserPasswordStrongFormat(): void {

        // 1. Create a "Mock" of the repository (we don't need a real DB)
        $repositoryMock = $this->createMock(UsersRepository::class);

        // 2. Instantiate the service with the mock
        $service = new UsersService($repositoryMock);

        // 3. Expectation
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Le mot de passe doit contenir une majuscule, une minuscule et un chiffre.');

        // 4. Action
        $service->validUser("rocky.Balboa@gmail.com", 'Rockybalboa', 'Rockybalboa'); 
    }
    public function testCanValidUserPasswordStrongConfirm(): void {

        // 1. Create a "Mock" of the repository (we don't need a real DB)
        $repositoryMock = $this->createMock(UsersRepository::class);

        // 2. Instantiate the service with the mock
        $service = new UsersService($repositoryMock);

        // 3. Expectation
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Les mots de passe ne correspondent pas.");

        // 4. Action
        $service->validUser("rocky.Balboa@gmail.com", 'Rocky1234', 'Rocky6789'); 
    }
    public function testCanValidUserWithNoEmailValue(): void {

        // 1. Create a "Mock" of the repository (we don't need a real DB)
        $repositoryMock = $this->createMock(UsersRepository::class);

        // 2. Instantiate the service with the mock
        $service = new UsersService($repositoryMock);

        // 3. Expectation
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Email invalide !");

        // 4. Action
        $service->validUser("", 'Rocky1234', 'Rocky1234'); 
    }
}
?>