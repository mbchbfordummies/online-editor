<?php

include 'template.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['question'])) {

        //sanitize the data
        $questionData = htmlspecialchars($_POST['question']);
       
        //split the input into lines to process each question separately
        $lines = explode("\n", $questionData);

        //create an array to hold the questions
        $questions = [];
        $currentQuestion = null;

        foreach ($lines as $line) {
            //Split the line into components
            $components = explode(":", $line, 2); //limit the number of components to 2

            if (count($components) === 2){
                $key = trim($components[0]);
                $value = trim($components[1]);

                switch ($key) {
                    case 'Question Text':
                        if (isset($currentQuestion)) {
                            $questions[] = $currentQuestion;
                        }
                        $currentQuestion = [
                            'question_text' => $value,
                            'choices' => [],
                            'correct_answer' => '', // Changed 'correct_choice' to 'correct_answer'
                        ];
                    break;
                    case 'Correct Answer':
                        $currentQuestion['correct_answer'] = trim($value);
                    break;
                }
            } elseif (isset($currentQuestion)) {
                //Handle additional lines of choices
                if (preg_match('/^[A-E]\)\s*(.*)/', $line, $matches)) {
                    // Remove 'A)', 'B)', 'C)', 'D)' prefixes from choices
                    $choice = trim($matches[1]);
                    $currentQuestion['choices'][] = $choice;
                }
            }
        }

        // Add the last currentQuestion to the questions array
        if (isset($currentQuestion)) {
            $questions[] = $currentQuestion;
        }

// Start building the Moodle XML
$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml .= '<quiz xmlns="http://www.imsglobal.org/xsd/imsqti_v2p1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.imsglobal.org/xsd/imsqti_v2p1 http://www.imsglobal.org/xsd/imsqti_v2p1.xsd" identifier="quiz" title="Quiz">' . "\n";

// Iterate through the questions from your $questions array
foreach ($questions as $index => $question) {
    $questionText = $question['question_text'];
    $choices = $question['choices'];
    $correctAnswer = $question['correct_answer'];

    $xml .= '<question type="multichoice">' . "\n";
    $xml .= '    <name>' . "\n";
    $xml .= '        <text><![CDATA[Question ' . ($index + 1) . ']]></text>' . "\n";
    $xml .= '    </name>' . "\n";
    $xml .= '    <questiontext format="html">' . "\n";
    $xml .= '        <text><![CDATA[' . $questionText . ']]></text>' . "\n";
    $xml .= '    </questiontext>' . "\n";
    $xml .= '    <generalfeedback format="html">' . "\n";
    $xml .= '        <text></text>' . "\n";
    $xml .= '    </generalfeedback>' . "\n";
    $xml .= '    <defaultgrade>1.0000000</defaultgrade>' . "\n";
    $xml .= '    <penalty>0.0000000</penalty>' . "\n";
    $xml .= '    <hidden>0</hidden>' . "\n";
    $xml .= '    <idnumber></idnumber>' . "\n";
    $xml .= '    <single>true</single>' . "\n";
    $xml .= '    <shuffleanswers>true</shuffleanswers>' . "\n";
    $xml .= '    <answernumbering>abc</answernumbering>' . "\n";
    $xml .= '    <showstandardinstruction>0</showstandardinstruction>' . "\n";
    $xml .= '    <correctfeedback format="html">' . "\n";
    $xml .= '        <text>Your answer is correct.</text>' . "\n";
    $xml .= '    </correctfeedback>' . "\n";
    $xml .= '    <partiallycorrectfeedback format="html">' . "\n";
    $xml .= '        <text>Your answer is partially correct.</text>' . "\n";
    $xml .= '    </partiallycorrectfeedback>' . "\n";
    $xml .= '    <incorrectfeedback format="html">' . "\n";
    $xml .= '        <text>Your answer is incorrect.</text>' . "\n";
    $xml .= '    </incorrectfeedback>' . "\n";

// Iterate through choices
foreach ($choices as $choiceIndex => $choice) {
    $choiceLetter = chr(65 + $choiceIndex); // A, B, C, D, ...
    $isCorrect = ($correctAnswer === $choiceLetter);

    $xml .= '    <answer fraction="' . ($isCorrect ? '100' : '0') . '" format="html">' . "\n";
    $xml .= '        <text><![CDATA[' . $choice . ']]></text>' . "\n";
    $xml .= '        <feedback format="html">' . "\n";
    $xml .= '            <text><![CDATA[Answer Feedback]]></text>' . "\n";
    $xml .= '        </feedback>' . "\n";
    $xml .= '    </answer>' . "\n";
}


    $xml .= '</question>' . "\n";
}

$xml .= '</quiz>' . "\n";

// Output the Moodle XML
// echo '<pre>';
// echo htmlentities($xml);
// echo '</pre>';

// Output the Moodle XML within a textarea
echo '    <div><label for="xmlTextarea" class="block font-mono text-cyan-700 text-sm font-semibold">Copy the Multiple Choice Questions Below:</label><br></div>';
echo '<div class="flex justify-center items-center my-4">';
echo '<textarea name="xmlTextarea" id="xmlTextarea" class="mih-h-[auto] w-full resize border rounded p-2 overflow-auto" rows="16" cols="70" readonly>';
echo htmlentities($xml);
echo '</textarea>';
echo '</div>';
echo '<div class="flex justify-center items-center my-4">';
// Add the "Copy to Clipboard" button
echo '<button class="copy-button bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="copyToClipboard()">Copy to Clipboard</button>';
echo '</div>';
// JavaScript function to copy the XML content to clipboard
echo '<script>
function copyToClipboard() {
    var textarea = document.getElementById("xmlTextarea");
    textarea.select();
    document.execCommand("copy");
    alert("XML content copied to clipboard");
}
</script>';




    } else {
        echo "No question data received";
    }
    
} else {
    //Handle the case where the form hasn't been submitted
    echo "Form not submitted";
}
