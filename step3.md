### Code Quality Tool
**PHPCS (PHP Code Sniffer) :** very useful code quality tool which allows to keep the same code style between team members.
In order to customize it, several options like PSRs respect, naming conventions or indenting rules can be configured.

### CI/CD

In order to setup a CI/CD process, we need to define a pipeline with several jobs like :
- pull the code
- setup an environment (with docker for example)
- launch code quality tools (like PHPCS, PHPStan,..)
- launch tests (like Behat, PHPUnit)
- ...

Finally if no error, merging the branch is allowed.