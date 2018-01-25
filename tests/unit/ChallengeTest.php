<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . '../application/core/challenge.php';


class ChallengeTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $challenge;

    /**
     * Tests starting the challenge.
     */
    public function testBegin()
    {
        $challenge = new Challenge("Joe Savage");
        $this->tester->assertTrue($challenge->begin());
    }

    /**
     * Tests calculating a plus type arithmetic question.
     */
    public function testCalculateArithmeticPlusQuestion()
    {
        $challenge = new Challenge("Joe Savage");
        $answer = $challenge->calculateArithmeticQuestion(7, "plus", 4);
        $this->tester->assertEquals($answer, 11);
    }

    /**
     * Tests calculating a minus type arithmetic question.
     */
    public function testCalculateArithmeticMinusQuestion()
    {
        $challenge = new Challenge("Joe Savage");
        $answer = $challenge->calculateArithmeticQuestion(7, "minus", 4);
        $this->tester->assertEquals($answer, 3);
    }

    /**
     * Tests calculating an invalid arithmetic question.
     */
    public function testCalculateInvalidArithmeticQuestion()
    {
        $this->tester->expectException(new UnexpectedValueException("Invalid arithmetic operator"), function() {
            $challenge = new Challenge("Joe Savage");
            $challenge->calculateArithmeticQuestion(6, "divided", 2);
        });
    }

    /**
     * Tests calculating a times type arithmetic question.
     */
    public function testCalculateArithmeticTimesQuestion()
    {
        $challenge = new Challenge("Joe Savage");
        $answer = $challenge->calculateArithmeticQuestion(7, "times", 4);
        $this->tester->assertEquals($answer, 28);
    }

    /**
     * Tests calculating a word first question.
     */
    public function testCalculateWordFirstQuestion()
    {
        $challenge = new Challenge("Joe Savage");
        $answer = $challenge->calculateWordQuestion("trusting", 2, "first");
        $this->tester->assertEquals("tr", $answer);
    }

    /**
     * Tests calculating a word last question.
     */
    public function testCalculateWordLastQuestion()
    {
        $challenge = new Challenge("Joe Savage");
        $answer = $challenge->calculateWordQuestion("trusting", 2, "last");
        $this->tester->assertEquals("ng", $answer);
    }

    /**
     * Tests extracting a question URL from a challenge server response.
     */
    public function testExtractQuestionUriFromResponse()
    {
        $challenge = new Challenge("Joe Savage");
        $questionUri = $challenge->extractQuestionUriFromResponse("Hello Joe Savage, thanks for starting the challenge! Please proceed to the first question by making a GET request to /question/1/Joe Savage/7036d622");
        $this->tester->assertEquals("/question/1/Joe Savage/7036d622", $questionUri);
    }

    /**
     * Tests completing the challenge.
     */
    public function testComplete()
    {
        $challenge = new Challenge("Joe Savage");
        $this->tester->assertTrue($challenge->complete());
    }

}