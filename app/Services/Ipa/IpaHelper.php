<?php

namespace App\Services\Ipa;
use ZipArchive;

class IpaHelper {
    public static function ExtractPlist($pathFolder, $file_ipa)
    {
        $returnValue = ['success' => false];
        $zip = new ZipArchive;
        $pathIPA = $pathFolder.'/'.$file_ipa;
        if (!$zip->open($pathIPA)){
            return $returnValue;
        }else{
            for ($i = 0; $i < $zip->numFiles; ++$i) {
                $path = $zip->getNameIndex($i);
                if (stripos(pathinfo($path, PATHINFO_BASENAME), ".app") !== false)
                {
                    $pathPlist = $path.'Info.plist'; // file name
                    $pathIcon = $path.'AppIcon60x60@2x.png'; // file name
                    $savePathPlist = "$pathFolder/Info.plist";
                    copy("zip://{$pathIPA}#{$pathPlist}", $savePathPlist);
                    copy("zip://{$pathIPA}#{$pathIcon}", "$pathFolder/icon.png");
                    $returnValue['success'] = true;
                    $returnValue['pathPlist'] = $savePathPlist;
                    break;
                }
            }
        }
        $zip->close();
        return $returnValue;
    }
}
