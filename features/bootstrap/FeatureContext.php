<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Fulll\App\Command\LocalizeVehicleCommand;
use Fulll\App\Command\ParkVehicleCommand;
use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\App\CommandHandler\LocalizeVehicleCommandHandler;
use Fulll\App\CommandHandler\ParkVehicleCommandHandler;
use Fulll\App\CommandHandler\RegisterVehicleCommandHandler;
use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Entity\User;
use Fulll\Domain\Entity\Vehicle;
use Fulll\Domain\Repository\FleetRepositoryInterface;
use Fulll\Domain\Repository\VehicleRepositoryInterface;
use Fulll\Domain\ValueObject\Location;
use Fulll\Infra\Repository\FleetRepository;
use Fulll\Infra\Repository\VehicleRepository;

class FeatureContext implements Context
{
    /***
     * @var Fleet
     */
    private Fleet $myFleet;

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

    /**
     * @Then /^I should be informed that my vehicle is already parked at this location$/
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        if (null === $this->exception || $this->exception->getMessage() !== 'This vehicle is already parked at this location') {
            throw new RuntimeException('Failed vehicle should be parked twice at the same location');
        }
    }

    /**
     * @Given my fleet
     */
    public function myFleet(): void
    {
        $this->myFleet = new Fleet(new User(rand(1, 10)));
    }

    /**
     * @Given /^my vehicle has been parked into this location$/
     */
    public function myVehicleHasBeenParkedIntoThisLocation()
    {
        $this->vehicle->setLocation($this->location);
    }

    /**
     * @Given the fleet of another user
     */
    public function otherUserFleet(): void
    {
        $this->otherFleet = new Fleet(new User(rand(11, 20)));
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
        $command = new RegisterVehicleCommand($this->myFleet, $this->vehicle);
        $handler = new RegisterVehicleCommandHandler(new FleetRepository());
        try {
            $handler->handle($command);
        } catch (Exception $e) {
            $this->exception = $e;
        }
    }

    /**
     * @Then vehicle should be part of my vehicle fleet
     */
    public function vehicleShouldBePartOfMyVehicleFleet()
    {
        if (!in_array($this->vehicle, $this->myFleet->getVehicles())) {
            throw new RuntimeException('This vehicle is not in your fleet !');
        }
    }

    /**
     * @Then vehicle should be part of my vehicle fleet and the other user's fleet
     */
    public function vehicleShouldBePartOfMyVehicleFleetAndOtherUserToo()
    {
        if (!in_array($this->vehicle, $this->myFleet->getVehicles())
            && !in_array($this->vehicle, $this->otherFleet->getVehicles())) {
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
        if (null === $this->exception || $this->exception->getMessage() !== 'Ce véhicule est déjà enregistré dans votre flotte.') {
            throw new RuntimeException('Failed vehicle should be registered twice');
        }
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation()
    {
        $command = new LocalizeVehicleCommand($this->vehicle, $this->location);
        $handler = new LocalizeVehicleCommandHandler(new VehicleRepository());
        try {
            $handler->handle($command);
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

