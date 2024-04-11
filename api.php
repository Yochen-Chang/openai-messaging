<?php
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// echo "Hello, API!!!" . "\n";
// echo "當前 PHP 版本為：" . phpversion() . "\n";

$yourApiKey = $_ENV['OPENAI_API'];
// echo "OPENAI 金鑰：" . $yourApiKey . "\n";

// 检查是否是 POST 请求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_question = $_POST['question'] ?? '未輸入';


    $client = OpenAI::client($yourApiKey);

    $result = $client->chat()->create([
        "model" => "gpt-4",
        "messages" => [
            ["role" => "user", "content" => $user_question],
        ],
    ]);

    $return_message = $result->choices[0]->message->content; // question: hello -> result: Hello! How can I assist you today?
    echo json_encode([
        'status' => 'success',
        'message' => $return_message
    ]);

} else {
    // 如果不是 POST 请求，返回一个错误
    echo json_encode([
        'status' => 'error',
        'message' => '只接受 POST 请求'
    ]);
}
?>
