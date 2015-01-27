<?php

class TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        echo "here";
        $suite = new TestSuite();

        $file = 'application/libraries/UserFactoryTest.php';

        echo 'Adding test: ' . $file . "\n";
        $suite->addTestFile($file);

        //add here algorithm that will search and add all test files from your /tests directory

    return $suite;
    }

}