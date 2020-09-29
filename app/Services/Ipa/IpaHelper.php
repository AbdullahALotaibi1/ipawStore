<?php

namespace App\Services\Ipa;
use ZipArchive;

class IpaHelper {
    public static function ExtractPlist($pathFolder, $file_ipa)
    {

        $returnValue = ['success' => false];
        $zip = new ZipArchive;
        $pathIPA = $pathFolder.'/'.$file_ipa;
        // Copy icon
        $iconPath = storage_path('app/public/store/_icon/'.$file_ipa.'.png');

        if (!$zip->open($pathIPA)){
            return $returnValue;
        }else{
            for ($i = 0; $i < $zip->numFiles; ++$i) {
                $path = $zip->getNameIndex($i);
                if (stripos(pathinfo($path, PATHINFO_BASENAME), ".app") !== false)
                {
                    $getFolderName = self::getStringBetween($path,'Payload/','.app');

                    $pathPlist = 'Payload/'.$getFolderName.'.app/Info.plist';//$path.'Info.plist'; // file name
                    $savePathPlist = "$pathFolder/Info.plist";
                    @copy("zip://{$pathIPA}#{$pathPlist}", $savePathPlist);
                    $returnValue['success'] = true;
                    $returnValue['pathPlist'] = $savePathPlist;
                    $returnValue['as'] = $pathPlist;
                }elseif(stripos(pathinfo($path, PATHINFO_BASENAME), "60x60@2x.png") !== false){
                        @copy("zip://{$pathIPA}#{$path}", $iconPath);
                        break;
                }elseif(stripos(pathinfo($path, PATHINFO_BASENAME), "AppIcon60x60@2x.png") !== false){
                    @copy("zip://{$pathIPA}#{$path}", $iconPath);
                    break;
                }elseif(stripos(pathinfo($path, PATHINFO_BASENAME), "60@2x.png") !== false){
                    @copy("zip://{$pathIPA}#{$path}", $iconPath);
                    break;
                }
            }
        }
        $zip->close();
        return $returnValue;
    }


    public static function getStringBetween($str,$from,$to)
    {
        $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
        return substr($sub,0,strpos($sub,$to));
    }
}
