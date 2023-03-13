<?php

declare(strict_types = 1);

namespace Fulll\Tests\Behat;

use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;
use Exception;
use Fulll\App\Command\LocalizeVehicleCommand;
use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\App\CommandHandler\LocalizeVehicleCommandHandler;
use Fulll\App\CommandHandler\RegisterVehicleCommandHandler;
use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Entity\User;
use Fulll\Domain\Entity\Vehicle;
use Fulll\Domain\Repository\FleetRepositoryInterface;
use Fulll\Domain\Repository\UserRepositoryInterface;
use Fulll\Domain\Repository\VehicleRepositoryInterface;
use Fulll\Domain\ValueObject\Location;
use RuntimeException;

class FeatureContext implements Context
{
    /***
     * @var Fleet
     */
    private Fleet $myFleet;

    private Connection $connection;

    /**
     * @var Fleet
     */
    private Fleet $otherFleet;

    /**
     * @var Vehicle
     */
    private Vehicle $vehicle;

    /**
     * @var Location
     */
    private Location $location;

    /**
     * @var Exception|null
     */
    private Exception|null $exception = null;

    private VehicleRepositoryInterface $vehicleRepository;

    private FleetRepositoryInterface $fleetRepository;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        VehicleRepositoryInterface $vehicleRepository,
        FleetRepositoryInterface $fleetRepository,
        UserRepositoryInterface $userRepository,
        Connection $connection
    ) {
        $this->vehicleRepository = $vehicleRepository;
        $this->fleetRepository = $fleetRepository;
        $this->connection = $connection;
        $this->userRepository = $userRepository;
    }

    /**
     * @BeforeScenario
     *
     * @return void
     * @throws \Doctrine\DBAL\Exception
     */
    public function clearData(): void
    {
        $this->connection->executeQuery('SET FOREIGN_KEY_CHECKS=0');
        $this->connection->executeQuery('TRUNCATE TABLE `fleet`');
        $this->connection->executeQuery('TRUNCATE TABLE `vehicle`');
        $this->connection->executeQuery('TRUNCATE TABLE `fleet_vehicle`');
        $this->connection->executeQuery('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @Then /^I should be informed that my vehicle is already parked at this location$/
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        if (null === $this->exception || $this->exception->getMessage() !== 'Vehicle already localize at this place') {
            throw new RuntimeException('Failed vehicle should be parked twice at the same location');
        }
    }

    /**
     * @Given my fleet
     */
    public function myFleet(): void
    {
        $user = new User(1);
        $this->userRepository->save($user);
        $this->myFleet = new Fleet();
        $this->myFleet->setUser($user);
        $this->fleetRepository->save($this->myFleet);
    }

    /**
     * @Given /^my vehicle has been parked into this location$/
     */
    public function myVehicleHasBeenParkedIntoThisLocation()
    {
        $this->vehicle->setLocation($this->location);
        $this->vehicleRepository->save($this->vehicle);
    }

    /**
     * @Given the fleet of another user
     */
    public function otherUserFleet(): void
    {
        $user = new User(2);
        $this->userRepository->save($user);
        $this->otherFleet = new Fleet();
        $this->otherFleet->setUser($user);
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle(): void
    {
        $this->vehicle = new Vehicle('ab666');
    }

    /**
     * @Given a location
     */
    public function aLocation(): void
    {
        $this->location = new Location('5.4497', '43.5283');
    }

    /**
     * @When I register this vehicle on my fleet
     */
    public function registerThisVehicleOnMyFleet(): void
    {
        $command = new RegisterVehicleCommand($this->myFleet->getId(), $this->vehicle->getPlateNumber());
        $handler = new RegisterVehicleCommandHandler($this->fleetRepository, $this->vehicleRepository);
        try {
            $handler->__invoke($command);
        } catch (Exception $e) {
            $this->exception = $e;
        }
    }

    /**
     * @Then vehicle should be part of my vehicle fleet
     */
    public function vehicleShouldBePartOfMyVehicleFleet()
    {
        $fleet = $this->fleetRepository->getById($this->myFleet->getId());
        $vehicle = $this->vehicleRepository->getByPlateNumber($this->vehicle->getPlateNumber());
        if (!in_array($vehicle, $fleet->getVehicles()->toArray())) {
            throw new RuntimeException('This vehicle is not in your fleet !');
        }
    }

    /**
     * @Then vehicle should be part of my vehicle fleet and the other user's fleet
     */
    public function vehicleShouldBePartOfMyVehicleFleetAndOtherUserToo()
    {
        if (!in_array($this->vehicle, $this->myFleet->getVehicles()->toArray())
            && !in_array($this->vehicle, $this->otherFleet->getVehicles()->toArray())) {
            throw new RuntimeException('Failed! Vehicle can\'t belong to more than one fleet');
        }
    }

    /**
     * @Given I have registered this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet()
    {
        $this->myFleet->addVehicle($this->vehicle);
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function otherUserHasRegisteredThisVehicleIntoHisFleet()
    {
        $this->otherFleet->addVehicle($this->vehicle);
    }

    /**
     * @Then I should be informed this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {
        if (null === $this->exception || $this->exception->getMessage() !== 'This Vehicle is already registered in this fleet') {
            throw new RuntimeException('Failed vehicle should be registered twice');
        }
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation()
    {
        $command = new LocalizeVehicleCommand($this->myFleet->getId(), $this->vehicle->getPlateNumber(), $this->location);
        $handler = new LocalizeVehicleCommandHandler($this->vehicleRepository, $this->fleetRepository);
        try {
            $handler->__invoke($command);
        } catch (Exception $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationShouldVerifyThisLocation()
    {
        if ($this->location !== $this->vehicle->getLocation()) {
            throw new RuntimeException('Failed ! Location not corresponding with vehicle location');
        }
    }
}

