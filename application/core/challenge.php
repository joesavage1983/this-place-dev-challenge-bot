<?php

/**
 * Challenge.
 *
 * @category Dev_Challenges
 * @package  This_Place_Challenge
 * @author   Joe Savage <joe.savage@yahoo.co.uk>
 * @license  GPL http://opensource.org/licenses/gpl-license.php GNU Public License
 */

use GuzzleHttp\Client;

class Challenge
{

    /**
     * The Guzzle HTTP Client.
     *
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * The name of the person completing the challenge.
     *
     * @var string
     */
    private $name;

    /**
     * The base URI of the challenge.
     *
     * @var string
     */
    private $baseUri;

    /**
     * The question URI from which to fetch the next question in the challenge.
     *
     * @var string
     */
    private $nextQuestionUri;

    /**
     * The next question type.
     *
     * @var string
     */
    private $nextQuestionType;

    /**
     * The next question text from which to parse the question parameters.
     *
     * @var string
     */
    private $nextQuestionTextRaw;

    /**
     * The next answer URI
     *
     * @var string
     */
    private $nextAnswerUri;

    /**
     * The next answer field name in which the next answer should be sent.
     *
     * @var string
     */
    private $nextAnswerFieldName = "answer";

    /**
     * The total number of questions expected in the challenge.
     *
     * @var int
     */
    private $totalQuestions = 5;

    /**
     * The prize received after successfully completing the challenge.
     *
     * @var string
     */
    private $prize;

    /**
     * The prize URI from which to fetch the prize.
     *
     * @var string
     */
    private $prizeUri;

    /**
     * Get the client.
     *
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set the client.
     *
     * @param \GuzzleHttp\Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the base URI.
     *
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * Set the base URI.
     *
     * @param string $baseUri
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;
    }

    /**
     * Get the next question URI.
     *
     * @return string
     */
    public function getNextQuestionUri()
    {
        return $this->nextQuestionUri;
    }

    /**
     * Set the net question URI.
     *
     * @param string $nextQuestionUri
     */
    public function setNextQuestionUri($nextQuestionUri)
    {
        $this->nextQuestionUri = $nextQuestionUri;
    }

    /**
     * Get the next question type.
     *
     * @return string
     */
    public function getNextQuestionType()
    {
        return $this->nextQuestionType;
    }

    /**
     * Set the next question type.
     *
     * @param string $nextQuestionType
     */
    public function setNextQuestionType($nextQuestionType)
    {
        $this->nextQuestionType = $nextQuestionType;
    }

    /**
     * Get the next question raw text.
     *
     * @return string
     */
    public function getNextQuestionTextRaw()
    {
        return $this->nextQuestionTextRaw;
    }

    /**
     * Set the next question raw text.
     *
     * @param string $nextQuestionTextRaw
     */
    public function setNextQuestionTextRaw($nextQuestionTextRaw)
    {
        $this->nextQuestionTextRaw = $nextQuestionTextRaw;
    }

    /**
     * Get the next answer URI.
     *
     * @return string
     */
    public function getNextAnswerUri()
    {
        return $this->nextAnswerUri;
    }

    /**
     * Set the next answer uri.
     *
     * @param string $nextAnswerUri
     */
    public function setNextAnswerUri($nextAnswerUri)
    {
        $this->nextAnswerUri = $nextAnswerUri;
    }

    /**
     * Get the next answer field name.
     *
     * @return string
     */
    public function getNextAnswerFieldName()
    {
        return $this->nextAnswerFieldName;
    }

    /**
     * Set the next answer field name.
     *
     * @param string $nextAnswerFieldName
     */
    public function setNextAnswerFieldName($nextAnswerFieldName)
    {
        $this->nextAnswerFieldName = $nextAnswerFieldName;
    }

    /**
     * Get the total number of questions.
     * @return int
     */
    public function getTotalQuestions()
    {
        return $this->totalQuestions;
    }

    /**
     * Set the total number of questions.
     *
     * @param string $totalQuestions
     */
    public function setTotalQuestions($totalQuestions)
    {
        $this->totalQuestions = $totalQuestions;
    }

    /**
     * Get the prize.
     *
     * @return string
     */
    public function getPrize()
    {
        return $this->prize;
    }

    /**
     * Set the prize.
     *
     * @param string $prize
     */
    public function setPrize($prize)
    {
        $this->prize = $prize;
    }

    /**
     * Get the prize URI.
     *
     * @return string
     */
    public function getPrizeUri()
    {
        return $this->prizeUri;
    }

    /**
     * Set the prize URI.
     *
     * @param string $prizeUri
     */
    public function setPrizeUri($prizeUri)
    {
        $this->prizeUri = $prizeUri;
    }

    /**
     * Initializes a challenge with a name and a base URI for the dev challenge server.
     *
     * @param string $name
     * @param string $baseUri
     * @param int    $totalQuestions
     */
    public function __construct($name = "", $baseUri = "http://dev-challenge.thisplace.com", $totalQuestions = 5)
    {
        $httpClient = new Client(
            [
            'base_uri' => $baseUri,
            'timeout'  => 2.0,
            ]
        );
        $this->setClient($httpClient);
        $this->setName($name);
        $this->setBaseUri($baseUri);
        $this->setTotalQuestions(5);
    }

    /**
     * Extracts a question URI from the response received back from the challenge server.
     *
     * @param  string $body
     * @return string
     */
    public function extractQuestionUriFromResponse($body = "")
    {
        $responseBodySplit = preg_split('@(?=/question)@', $body);
        $questionUri = $responseBodySplit[1];
        return $questionUri;
    }

    /**
     * Sets the name and starts the challenge.
     */
    public function begin()
    {
        $name = $this->getName();
        $httpClient = $this->getClient();
        $response = $httpClient->request(
            'POST',
            'hello',
            [
                'form_params' => [
                    'name' => $name,
                ]
            ]
        );

        $body = $response->getBody();
        $nextQuestionUri = $this->getBaseUri() . $this->extractQuestionUriFromResponse($body);
        $this->setNextQuestionUri($nextQuestionUri);

        return true;
    }

    /**
     * Completes the dev challenge.
     */
    public function complete()
    {
        $this->begin();

        $totalQuestions = $this->getTotalQuestions();

        for ($x = 1; $x <= $totalQuestions; $x++) {
            $this->getNextQuestion();
            $nextQuestionType = $this->getNextQuestionType();
            $nextQuestionTextRaw = $this->getNextQuestionTextRaw();

            $nextQuestionText = str_replace("What is", "", $nextQuestionTextRaw);
            $nextQuestionText = str_replace("What are", "", $nextQuestionText);
            $nextQuestionText = str_replace("?", "", $nextQuestionText);
            $nextQuestionText = str_replace("the", "", $nextQuestionText);
            $questionTextArgs = explode(" ", trim($nextQuestionText));

            if ($nextQuestionType == "Arithmetic") {
                $answer = $this->calculateArithmeticQuestion($questionTextArgs[0], $questionTextArgs[1], $questionTextArgs[2]);
                $this->answerArithmeticQuestion($answer);
            } elseif ($nextQuestionType == "Word") {
                $matches = array();
                preg_match('/".*?"/', $nextQuestionText, $matches);
                $word = str_replace('"', '', $matches[0]);
                $answer = $this->calculateWordQuestion($word, $questionTextArgs[1], $questionTextArgs[0]);
                $this->answerWordQuestion($answer);
            } elseif ($nextQuestionType == "Guess") {
                $this->answerGuessQuestion();
            }
        }

        return true;
    }

    /**
     * Fetches the next question to answer in the challenge.
     */
    public function getNextQuestion()
    {
        $nextQuestionUri = $this->getNextQuestionUri();
        $httpClient = $this->getClient();
        $request = $httpClient->request('GET', $nextQuestionUri);
        $response = $request->getBody();

        $questionType = explode(' ', trim($response))[0];
        $this->setNextQuestionType($questionType);

        $responseBlankLinesCleaned = preg_replace('/^\h*\v+/m', '', trim($response));
        $nextQuestionTextRawExploded = explode("\n", $responseBlankLinesCleaned);

        $this->setNextQuestionTextRaw($nextQuestionTextRawExploded[1]);
        $this->setNextAnswerUri($nextQuestionUri);

        $nextAnswerFieldNameMatches = array();
        preg_match('/`.*?`/', $response, $nextAnswerFieldNameMatches);
        $nextAnswerFieldNameCleaned = str_replace("`", "", $nextAnswerFieldNameMatches[0]);

        if (!empty($nextAnswerFieldNameMatches[0])) {
            $this->setNextAnswerFieldName($nextAnswerFieldNameCleaned);
        }
    }

    /**
     * Calculates an arithmetic type question.
     *
     * @param  int    $number1
     * @param  string $arithmeticOperator
     * @param  string $number2
     * @return int    $answer
     */
    public function calculateArithmeticQuestion($number1, $arithmeticOperator = "", $number2)
    {
        switch ($arithmeticOperator) {
            case "plus":
                $answer = $number1 + $number2;
                break;
            case "minus":
                $answer = $number1 - $number2;
                break;
            case "times":
                $answer = $number1 * $number2;
                break;
            default:
                throw new UnexpectedValueException("Invalid arithmetic operator");
        }
        return $answer;
    }

    /**
     * Answers an arithmetic type question.
     *
     * @param  int  $answer
     * @return bool
     */
    public function answerArithmeticQuestion($answer)
    {
        $answerFieldName = $this->getNextAnswerFieldName();

        $nextAnswerUri = $this->getNextAnswerUri();
        $httpClient = $this->getClient();
        $response = $httpClient->request(
            'POST',
            $nextAnswerUri,
            [
            'form_params' => [
                $answerFieldName => $answer,
            ]
            ]
        );

        $body = $response->getBody();
        $bodyExploded = explode("\n", trim($body));
        $markedAnswer = $bodyExploded[0];

        if ($markedAnswer !== "Correct!") {
            throw new UnexpectedValueException("Arithmetic question answered incorrectly");
        }

        $nextQuestionUri = $this->getBaseUri() . $this->extractQuestionUriFromResponse($body);
        $this->setNextQuestionUri($nextQuestionUri);

        return $answer;
    }

    /**
     * Calculates a word type question.
     *
     * @param  string $word
     * @param  int    $lettersCount
     * @param  string $position
     * @return string $answer
     */
    public function calculateWordQuestion($word = "", $lettersCount = 0, $position = "")
    {
        if ($position == "first") {
            $answer = substr($word, 0, $lettersCount);
        } elseif ($position == "last") {
            $answer = substr($word, -$lettersCount);
        }

        return $answer;
    }

    /**
     * Answers a word type question.
     *
     * @param  string $answer
     * @return bool
     */
    public function answerWordQuestion($answer)
    {
        $answerFieldName = $this->getNextAnswerFieldName();

        $nextAnswerUri = $this->getNextAnswerUri();
        $httpClient = $this->getClient();
        $response = $httpClient->request(
            'POST',
            $nextAnswerUri,
            [
            'form_params' => [
                $answerFieldName => $answer,
            ]
            ]
        );

        $body = $response->getBody();
        $bodyExploded = explode("\n", trim($body));
        $markedAnswer = $bodyExploded[0];

        if ($markedAnswer !== "Correct!") {
            throw new UnexpectedValueException("Unable to answer word question correctly");
        }

        $nextQuestionUri = $this->getBaseUri() . $this->extractQuestionUriFromResponse($body);
        $this->setNextQuestionUri($nextQuestionUri);

        return true;
    }

    /**
     * Answers a guess type question.
     *
     * @return bool
     */
    public function answerGuessQuestion()
    {
        $answerFieldName = $this->getNextAnswerFieldName();

        $topRange = 9;
        $lowRange = 0;
        $guess = ceil($lowRange + $topRange / 2);

        for ($x = 1; $x <= 4; $x++) {
            $nextAnswerUri = $this->getNextAnswerUri();
            $httpClient = $this->getClient();
            $response = $httpClient->request(
                'POST',
                $nextAnswerUri,
                [
                'form_params' => [
                    $answerFieldName => $guess,
                ]
                ]
            );
            $body = $response->getBody();

            if (strpos($body, "greater") !== false) {
                $lowRange = $guess + 1;
                $guess = ($lowRange + $topRange) / 2;
                $guess = ceil($guess);
            } elseif (strpos($body, "less") !== false) {
                $topRange = $guess - 1;
                $guess = ($lowRange + $topRange) / 2;
                $guess = ceil($guess);
            } elseif (strpos($body, "Correct") !== false) {
                $responseBodySplit = preg_split('@(?=/success)@', $body);
                $prizeUri = $this->baseUri . $responseBodySplit[1];
                $this->setPrizeUri($prizeUri);
                $this->fetchPrize();
                $this->showPrize();
                return true;
            } elseif (strpos($body, "incorrect") !== false) {
                throw new UnexpectedValueException("Unable to answer the guess question correctly");
            }

        }

        return false;


    }

    /**
     * Fetches the prize from the prize URI.
     *
     */
    private function fetchPrize()
    {
        $prizeUri = $this->getPrizeUri();
        $httpClient = $this->getClient();
        $request = $httpClient->request('GET', $prizeUri);
        $prize = $request->getBody();
        $this->setPrize($prize);
        return true;
    }

    /**
     * Displays the prize.
     */
    public function showPrize()
    {
        $prize = $this->getPrize();
        echo $prize;
    }

}