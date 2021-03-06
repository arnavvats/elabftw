<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Test creating an experiment');
testLogin($I);
$I->amOnPage('experiments.php');
$I->see('Experiments');
$I->amOnPage('experiments.php?create=true');
$I->see('Tags');
$I->see('Date');
$I->see('Title');
$I->wantTo('Change the visibility to user');
$I->amOnPage('experiments.php?mode=edit&id=1');
$I->selectOption('#visibility_select', 'Only me');
$I->waitForJS('return jQuery.active == 0', 10);
$I->amOnPage('experiments.php?mode=view&id=1');
$I->see('User');
