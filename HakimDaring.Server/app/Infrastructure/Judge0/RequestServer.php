<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Judge0;

use App\Core\Repository\Pengerjaan\Entitas\HasilSubmission;
use App\Core\Repository\Pengerjaan\Entitas\SourceCodePengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\TokenSubmission;
use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Services\Pengerjaan\BahasaPemrograman;
use App\Core\Services\Pengerjaan\InterfaceRequestServer;

class RequestServer implements InterfaceRequestServer {

    const TOKEN_AUTHENTICATION = "d8bbf54d-321c-4cf2-9fde-b88373aabe43";
    const TOKEN_AUTHORIZATION = "db59f4e8-6772-455a-8950-5419a85c14e2";

    // public function kirimBatchSubmissionUjiCoba(SourceCodePengerjaan $sourceCode, array $daftarTestcase, BatasanSoal $batasan) : array|false;

    // /**
    //  * @param Testcase[] $daftarTestcase
    //  * @return TokenSubmission[]|false
    //  */
    // public function kirimBatchSubmissionPengerjaan(SourceCodePengerjaan $sourceCode, array $daftarTestcase) : array|false;

    // public function ambilHasilSubmission(TokenSubmission $token) : HasilSubmission;

    // public function hapusSubmission(TokenSubmission $token) : void;

    public function kirimBatchSubmissionUjiCoba(SourceCodePengerjaan $sourceCode, array $daftarTestcase, BatasanSoal $batasan) : array|false {
        $url = "http://localhost:2358/submissions/batch";

        $submissions = [];
        foreach($daftarTestcase as $soal) {
            array_push($submissions, [
                "source_code" => $sourceCode->ambilSourceCode(),
                "language_id" => BahasaPemrograman::MAPPING[$sourceCode->ambilBahasa()],
                "stdin" => $soal->ambilSoal(),
                "cpu_time_limit" => $batasan->ambilBatasanWaktuPerTestcase(),
                "memory_limit" => $batasan->ambilBatasanMemoriDalamKB(),
                "stack_limit" => 128000
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
            array_push($hasil, new TokenSubmission($token->token));
        }

        return $hasil;
    }

    public function kirimBatchSubmissionPengerjaan(SourceCodePengerjaan $sourceCode, array $daftarTestcase, BatasanSoal $batasan) : array|false {
        $url = "http://localhost:2358/submissions/batch";

        $submissions = [];
        foreach($daftarTestcase as $testcase) {
            array_push($submissions, [
                "source_code" => $sourceCode->ambilSourceCode(),
                "language_id" => BahasaPemrograman::MAPPING[$sourceCode->ambilBahasa()],
                "stdin" => $testcase->ambilSoalTestcase()->ambilSoal(),
                "expected_output" => $testcase->ambilJawabanTestcase()->ambilJawaban(),
                "cpu_time_limit" => $batasan->ambilBatasanWaktuPerTestcase(),
                "memory_limit" => $batasan->ambilBatasanMemoriDalamKB(),
                "stack_limit" => 128000
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
            array_push($hasil, new TokenSubmission($token->token));
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

        do {
            usleep(50000);
            $context  = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
    
            if ($response === false) {
                return false;
            }
    
            $hasilSubmission = json_decode($response);
        } while($hasilSubmission->status->id < 3);
        
        return new HasilSubmission(
            new TokenSubmission($hasilSubmission->token),
            strval($hasilSubmission->stdout),
            floatval($hasilSubmission->time),
            intval($hasilSubmission->memory),
            $hasilSubmission->compile_output != null ? $hasilSubmission->compile_output : $hasilSubmission->stderr,
            $hasilSubmission->status->description
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