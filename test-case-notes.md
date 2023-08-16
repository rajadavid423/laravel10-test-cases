1. No need to test full application on -> new release / updates / configuration changes  
2. Automatic testing in GitHub
3. Types -> Feature test & Unit test (write test for small piece of code individually)
4. Warning! -> Default test case affect the original database 
5. Configurations
    -> Change .env database config (separate database for test case)
    -> .env.testing - new env file for testing
    -> Phpunit.xml - run sqlite in memory (some case not working)
       .env.testing - (DB_CONNECTION=sqlite & DB_DATABASE=:memory:)
6. What are the things we can test?
    Status code / Return message / Access rights / Database content / Page content
7. Use RefreshDatabase
8. Model and route based test case
9. Disadvantage of assertSee function 
10. For repeated code use setup method
11. Code Coverage - This feature requires Xdebug or PCOV.
