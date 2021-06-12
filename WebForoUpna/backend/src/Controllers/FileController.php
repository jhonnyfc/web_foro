<?php

namespace Foroupna\Controllers;

use Exception;

class FileController
{

    /**
     * @throws Exception
     */
    public function saveImg(string $dir, string $filename): string
    {
        $target_dir = __DIR__ . "/../../public/imgs/" . $dir . "/" . $filename . "/";

        for ( $i=0; $i < sizeof($_FILES['imgs']['name']); ++$i ) {

            $img_name = $_FILES['imgs']['name'][$i];
            $img_tmp = $_FILES['imgs']['tmp_name'][$i];

            if ( !$this->isImage($img_tmp) ) {
                return "Invalid image";
            }

            $imgFileType = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

            if ( !$this->isImgFormatIsValid($imgFileType) ) {
                return "Invalid image format (jpg, png, jpeg).";
            }

            $nextImgNumber = sizeof(scandir($target_dir)) - 1;

            $target_file = $target_dir . $filename . "_" . $nextImgNumber . "." . $imgFileType;

            move_uploaded_file($img_tmp, $target_file);
        }

        return "Images successfully uploaded.";
    }


    private function isImage($img): bool
    {
        return !(getimagesize($img) === false);
    }

    private function isImgFormatIsValid(string $imgFileType): bool
    {
        return !($imgFileType !== "jpg" && $imgFileType !== "png" && $imgFileType !== "jpeg");
    }

}