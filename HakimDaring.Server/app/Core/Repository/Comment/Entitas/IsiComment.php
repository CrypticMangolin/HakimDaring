<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Comment\Entitas;

use App\Core\Repository\Exception\MelebihiUkuranMaksimalException;

class IsiComment {

    const BATAS_MAKSIMAL_UKURAN_COMMENT_DALAM_BYTE = 4000000;

    private string $isiComment;

    public function __construct(string $isiComment)
    {
        $this->isiComment = $isiComment;
    }

    public function ambilIsiComment() : string {
        return $this->isiComment;
    }

    public static function buatIsiComment(string $isiComment) : IsiComment {
        if (strlen($isiComment) > self::BATAS_MAKSIMAL_UKURAN_COMMENT_DALAM_BYTE) {
            throw new MelebihiUkuranMaksimalException("ukuran maksimal comment adalah ".self::BATAS_MAKSIMAL_UKURAN_COMMENT_DALAM_BYTE." byte");
        }
        return new IsiComment($isiComment);
    }
}

?>