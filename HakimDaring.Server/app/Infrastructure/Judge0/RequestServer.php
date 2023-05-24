<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Judge0;

use App\Core\Pengerjaan\Data\HasilSubmission;
use App\Core\Pengerjaan\Data\TokenSubmission;
use App\Core\Pengerjaan\Interface\InterfaceRequestServer;
use App\Core\Repository\Pengerjaan\Entitas\UjiCobaSourceCode;

class RequestServer implements InterfaceRequestServer {

    const TOKEN_AUTHENTICATION = "d8bbf54d-321c-4cf2-9fde-b88373aabe43";
    const TOKEN_AUTHORIZATION = "db59f4e8-6772-455a-8950-5419a85c14e2";
    
    public function kirimBatchSubmissionUjiCoba(UjiCobaSourceCode $sourceCode) : array|false {
        $url = "http://localhost:2358/submissions/batch";

        $submissions = [];
        foreach($sourceCode->ambilDaftarInput() as $stdin) {
            array_push($submissions, [
                "source_code" => $sourceCode->ambilSourceCode(),
                "language_id" => $sourceCode->ambilBahasa(),
                "stdin" => $stdin,
            ]);
        }

        $data = [
            "submissions" => $submissions
        ];

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\nX-Auth-Token: ".$this::TOKEN_AUTHENTICATION."\r\nX-Auth-User: ".$this::TOKEN_AUTHORIZATION,
                'method'  => 'POST',
                'content' => json_encode($data),
            ),
        );

        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            return false;
        }

        $daftarToken= json_decode($response);

        $hasil = [];

        foreach($daftarToken as $token) {
            array_push($hasil, new TokenSubmission($hasil["token"]));
        }

        return $hasil;
    }

    public function ambilHasilSubmission(TokenSubmission $token) : HasilSubmission {
        $url = "http://localhost:2358/submissions/{$token->ambilToken()}";

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\nX-Auth-Token: ".$this::TOKEN_AUTHENTICATION."\r\nX-Auth-User: ".$this::TOKEN_AUTHORIZATION,
                'method'  => 'GET'
            ),
        );

        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            return false;
        }

        $hasilSubmission = json_decode($response);
        
        return new HasilSubmission(
            new TokenSubmission($hasilSubmission["token"]),
            $hasilSubmission["stdout"],
            floatval($hasilSubmission["time"]),
            intval($hasilSubmission["memory"]),
            $hasilSubmission["compile_output"],
            $hasilSubmission["status"]["description"]
        );
    }

    
    public function hapusSubmission(TokenSubmission $token) : void {
        $url = "http://localhost:2358/submissions/{$token->ambilToken()}";

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\nX-Auth-Token: ".$this::TOKEN_AUTHENTICATION."\r\nX-Auth-User: ".$this::TOKEN_AUTHORIZATION,
                'method'  => 'DELETE'
            ),
        );

        $context  = stream_context_create($options);
        file_get_contents($url, false, $context);
    }
}



?>